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

        foreach ($list as $key => $value) {
            $text = [];

            foreach (config('laravel-interface-translation.locales') as $locale) {
                $text[$locale] = __($key, [], $locale);
            }

            $group = Str::before($key, '::');
            $key = Str::after($key, '::');

            // A string containing :: and spaces is usually not a namespace.
            if (Str::contains($group, ' ')){
                $group = '*';
            }

            $search = [
                    'group' => $key !== $group ? $group : '*',
                    'key' => $key,
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
