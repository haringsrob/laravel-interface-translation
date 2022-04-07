<?php

namespace Haringsrob\LaravelInterfaceTranslation;

use Illuminate\Database\QueryException;
use Illuminate\Translation\FileLoader;
use Illuminate\Support\Facades\Schema;
use Spatie\TranslationLoader\TranslationLoaders\TranslationLoader;

/**
 * This is a slightly adapted version of the Spatie's translation loader.
 *
 * It alsow supports namespaced loading instead of defaulting to files.
 */
class TranslationLoaderManager extends FileLoader
{
    /**
     * Load the messages for the given locale.
     *
     * @param string $locale
     * @param string $group
     * @param string $namespace
     *
     * @return array
     *
     * @todo: This is subotpimal and can be improved.
     */
    public function load($locale, $group, $namespace = null): array
    {
        try {
            $fileTranslations = parent::load($locale, $group, $namespace);


            if ($group === '*' && $namespace === '*') {
                $group = '*';
            }
            else {
                // Concatinate the group and namespace for searching.
                $group = $namespace . '::' . $group;
            }

            $loaderTranslations = $this->getTranslationsForTranslationLoaders($locale, $group);

            if (!is_null($namespace) && $namespace !== '*' && empty($loaderTranslations)) {
                return $fileTranslations;
            }

            $loaderTranslations = $loaderTranslations[$group] ?? $loaderTranslations;

            return array_replace_recursive($fileTranslations, $loaderTranslations);
        } catch (QueryException $e) {
            $modelClass = config('translation-loader.model');
            $model = new $modelClass;
            if (is_a($model, LanguageLine::class)) {
                if (! Schema::hasTable($model->getTable())) {
                    return parent::load($locale, $group, $namespace);
                }
            }

            throw $e;
        }
    }

    protected function getTranslationsForTranslationLoaders(
        string $locale,
        string $group,
        string $namespace = null
    ): array {
        return collect(config('translation-loader.translation_loaders'))
            ->map(function (string $className) {
                return app($className);
            })
            ->mapWithKeys(function (TranslationLoader $translationLoader) use ($locale, $group, $namespace) {
                return $translationLoader->loadTranslations($locale, $group, $namespace);
            })
            ->toArray();
    }
}
