<?php

namespace Haringsrob\LaravelInterfaceTranslation;

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

            $search = [
                    'group' => 'laravel-interface-translation',
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
