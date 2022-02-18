<?php

namespace Haringsrob\LaravelInterfaceTranslation\Http\Livewire;

use Haringsrob\LaravelInterfaceTranslation\Facades\LaravelInterfaceTranslation;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\TranslationLoader\LanguageLine;

class TranslationList extends Component
{
    use WithPagination;

    /**
     * @var LanguageLine[]
     */
    public $items;

    public function getRules()
    {
        $rules = [
            'items' => 'required|array',
            'items.*.text' => 'required|array',
            'items.*.id' => 'required|numeric',
            'items.*.key' => 'required|string',
            'items.*.group' => 'required|string',
        ];

        foreach (config('laravel-interface-translation.locales') as $locale) {
            $rules['items.*.text.' . $locale] = 'string|nullable';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();
        foreach ($this->items as $item) {
            $line = LanguageLine::findOrFail($item['id']);
            $line->text = $item['text'];
            if ($line->isDirty()) {
                $line->save();
            }
        }
    }

    public function mount()
    {
        $this->items = LanguageLine::all()->toArray();
    }

    /**
     * Action for parsing the files and updating the db.
     */
    public function updateDatabase(): void
    {
        LaravelInterfaceTranslation::parseAndUpdateDbWithStrings();
    }

    public function render(): View
    {
        return view('laravel-interface-translation::livewire.translation-list');
    }
}
