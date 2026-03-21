<div class="d-flex align-items-center gap-2 animate-left">

    {{-- Mobile/Tablet: hamburger toggle (hidden on desktop) --}}
    <button class="sidebar-toggle-btn d-flex d-lg-none align-items-center justify-content-center flex-shrink-0"
        type="button" onclick="openMobSidebar()" aria-label="Open navigation">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="18" x2="21" y2="18" />
        </svg>
    </button>

    {{-- Desktop spacer (keeps right-side content aligned) --}}
    <span class="d-none d-lg-block flex-grow-1"></span>

    {{-- Right side: language selector + profile (half-half on mobile) --}}
    <div class="d-flex align-items-center justify-content-end header-actions gap-2">

        @if(request()->routeIs('admin.dashboard'))
        <div class="lang-wrapper">
            <select class="btn btn-lang d-flex align-items-center" onchange="handleLanguageChange(this)" id="languageSelect">
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                   <i class="bi bi-translate me-1"></i> <span>English</span>
                </option>
                <option value="gu" {{ app()->getLocale() == 'gu' ? 'selected' : '' }}>
                   <i class="bi bi-translate me-1"></i> <span>ગુજરાતી</span>
                </option>
            </select>
        </div>
        @endif

        <div class="dropdown d-flex profile-1 justify-content-end">
            <a href="{{ route('admin.dashboard') }}" data-bs-toggle="dropdown"
                class="leading-none nav-link pe-0 d-flex align-items-center justify-content-end animate w-100">
                <div class="p-1 text-center d-flex d-lg-none-max overflow-hidden">
                    <h6 class="mb-0 ms-1 text-truncate" id="profile-heading">
                        {{ auth()->user()->name }}
                        <i class="user-angle ms-1 fa fa-angle-down"></i>
                    </h6>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow dropdown">
                <a href="{{ route('admin.changePassword') }}" class="dropdown-item">
                    <i class="fa fa-lock me-3"></i>
                    {{ __('portal.change_password') }}
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out me-3"></i>
                    {{ __('portal.logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>

    </div>

</div>
