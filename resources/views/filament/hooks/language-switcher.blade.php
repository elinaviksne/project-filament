<div class="mb-4 flex justify-end gap-2 text-sm">
    <span class="text-gray-500 dark:text-gray-400">{{ __('app.language.label') }}:</span>
    <a
        href="{{ route('locale.switch', ['locale' => 'lv']) }}"
        @class([
            'font-semibold underline' => app()->getLocale() === 'lv',
            'text-gray-600 hover:text-primary-600 dark:text-gray-300' => app()->getLocale() !== 'lv',
        ])
    >{{ __('app.language.lv') }}</a>
    <span class="text-gray-400">|</span>
    <a
        href="{{ route('locale.switch', ['locale' => 'en']) }}"
        @class([
            'font-semibold underline' => app()->getLocale() === 'en',
            'text-gray-600 hover:text-primary-600 dark:text-gray-300' => app()->getLocale() !== 'en',
        ])
    >{{ __('app.language.en') }}</a>
</div>
