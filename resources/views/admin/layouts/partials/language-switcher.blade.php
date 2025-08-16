<!--begin::Menu item-->
<div class="menu-item px-3">
    <a href="{{ route('language.switch', 'en') }}" class="menu-link px-3 {{ app()->getLocale() == 'en' ? 'active' : '' }}">
        <span class="symbol symbol-20px me-4">
            <img class="rounded-1" src="{{ asset('assets/media/flags/united-states.svg') }}" alt="{{ __('language.english') }}" />
        </span>
        {{ __('language.english') }}
    </a>
</div>
<!--end::Menu item-->
<!--begin::Menu item-->
<div class="menu-item px-3">
    <a href="{{ route('language.switch', 'ar') }}" class="menu-link px-3 {{ app()->getLocale() == 'ar' ? 'active' : '' }}">
        <span class="symbol symbol-20px me-4">
            <img class="rounded-1" src="{{ asset('assets/media/flags/saudi-arabia.svg') }}" alt="{{ __('language.arabic') }}" />
        </span>
        {{ __('language.arabic') }}
    </a>
</div>
<!--end::Menu item--> 