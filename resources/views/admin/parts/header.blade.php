<div class="d-flex justify-content-end animate-left">
    <div class="d-flex align-items-center">
        @if(request()->routeIs('admin.dashboard'))
        <select class="text-dark custom-dropdown" onchange="handleLanguageChange(this)" id="languageSelect">
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                <i class="fa fa-fw fa-globe pe-2"></i> English
            </option>
            <option value="gu" {{ app()->getLocale() == 'gu' ? 'selected' : '' }}>
                <i class="fa fa-fw fa-globe pe-2"></i> ગુજરાતી
            </option>
        </select>
        @endif

        <div class="dropdown d-flex profile-1">
            <a href="{{ route('admin.dashboard') }}" data-bs-toggle="dropdown"
                class="leading-none nav-link pe-0 d-flex justify-content-start animate">
                <img src="{{ asset('images/logo.png') }}" alt="profile-user" class="avatar profile-user brround cover-image">
                <div class="p-1 text-center d-flex d-lg-none-max">
                    <h6 class="mb-0 ms-1" id="profile-heading">
                        {{ auth()->user()->name }}
                        <i class="user-angle ms-1 fa fa-angle-down "></i>
                    </h6>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow dropdown">
                <a href="{{ route('admin.changePassword') }}" class="dropdown-item">
                    <i class="fa fa-lock me-3"></i>
                    {{ __('portal.change_password') }}
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
