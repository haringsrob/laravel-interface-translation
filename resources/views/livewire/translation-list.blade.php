<div>
    <div class="flex w-full flex-col items-end py-4 gap-5">
        <button wire:click="save" class="p-4 bg-green-600 rounded text-white">{{__('Save translations')}}</button>
        @if ($saved)
            <div class="text-green-600 text-sm">
                @lang('Last saved:') {{$saved}}
            </div>
        @endif
    </div>
    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <x-laravel-interface-translation::table-head>
                Key
            </x-laravel-interface-translation::table-head>
            @foreach(config('laravel-interface-translation.locales') as $locale)
                <x-laravel-interface-translation::table-head>
                    {{$locale}}
                </x-laravel-interface-translation::table-head>
            @endforeach
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
        @foreach($items as $key => $item)
            <x-laravel-interface-translation::table-row>
                <x-laravel-interface-translation::table-col>
                    {{ $item['key'] }}
                </x-laravel-interface-translation::table-col>
                @foreach(config('laravel-interface-translation.locales') as $locale)
                    <x-laravel-interface-translation::table-col :no-padding="true">
                        <input name="{{$item['key']}}.{{$locale}}"
                               class="border-gray-300 dark:border-gray-500 border-2 dark:bg-gray-600 h-full w-full py-3 px-3"
                               wire:model.defer="items.{{ $key }}.text.{{ $locale }}"
                               type="text">
                    </x-laravel-interface-translation::table-col>
                @endforeach
            </x-laravel-interface-translation::table-row>
        @endforeach
        </tbody>
    </table>
</div>
