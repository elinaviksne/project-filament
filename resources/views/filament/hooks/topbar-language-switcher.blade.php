<div class="fi-topbar-item hidden sm:flex items-center gap-2 text-sm">
    <a
        href="{{ route('locale.switch', ['locale' => 'lv']) }}"
        @class([
            'font-semibold text-primary-600 dark:text-primary-400' => app()->getLocale() === 'lv',
            'text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400' => app()->getLocale() !== 'lv',
        ])
    >LV</a>
    <span class="text-gray-400">|</span>
    <a
        href="{{ route('locale.switch', ['locale' => 'en']) }}"
        @class([
            'font-semibold text-primary-600 dark:text-primary-400' => app()->getLocale() === 'en',
            'text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400' => app()->getLocale() !== 'en',
        ])
    >EN</a>
</div>
