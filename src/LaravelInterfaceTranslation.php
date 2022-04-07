<?php

namespace Haringsrob\LaravelInterfaceTranslation;

use Illuminate\Support\Str;
use KKomelin\TranslatableStringExporter\Core\StringExtractor;
use Spatie\TranslationLoader\LanguageLine;

class LaravelInterfaceTranslation
{
    /**
     * @param bool $force
     *  If true it will overwrite the db.
     *
     * @return LanguageLine[]
     */
    public function parseAndUpdateDbWithStrings(bool $force = false): array
    {
        $extractor = new StringExtractor();
        $list = $extractor->extract();

        $objectList = [];

        foreach ($list as $group => $value) {
            $text = [];

            foreach (config('laravel-interface-translation.locales') as $locale) {
                $text[$locale] = __($group, [], $locale);
            }

            if (Str::contains($group, '.') && !Str::contains($group, '::')) {
                $namespace = '*::' . Str::before($group, '.');
            }
            else {
                if (Str::contains($group, '.')) {
                    $namespace = Str::before($group, '.');
                }
                else {
                    $namespace = Str::before($group, '::');
                }
            }

            // A string containing spaces is usually not a namespace.
            if (Str::contains($namespace, ' ')){
                $namespace = '*';
            }

            $search = [
                    'group' => $group !== $namespace ? $namespace : '*',
                    'key' => $group,
                ];

            $data = $search + ['text' => $text];

            if ($force) {
                $objectList[] = LanguageLine::updateOrCreate($search, $data);
            }
            else {
                $objectList[] = LanguageLine::firstOrCreate($search, $data);
            }
        }

        return $objectList;
    }
}
