<?php

namespace Haringsrob\LaravelInterfaceTranslation\Http\Livewire;

use Carbon\Carbon;
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

    public ?string $saved = null;

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

        $this->saved = Carbon::now()->format('Y-m-d H:i');
    }

    public function mount()
    {
        $this->items = LanguageLine::all()->toArray();
    }

    public function render(): View
    {
        return view('laravel-interface-translation::livewire.translation-list');
    }
}
