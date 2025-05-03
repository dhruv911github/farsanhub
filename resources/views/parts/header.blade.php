<div class="d-flex justify-content-end animate-left">
    <div class="d-flex align-items-center">
        <div class="lacale">
            <a href="" class="dropdown-item">
                <i class="fa fa-fw fa-globe pe-2"></i>
                English
            </a>
            <a href="" class="dropdown-item">
                <i class="fa fa-fw fa-globe pe-2"></i>
                Gujarati
            </a>
        </div>
        <div class="dropdown d-flex profile-1">
            <a href="" data-bs-toggle="dropdown" class="leading-none nav-link pe-2 d-flex justify-content-start animate">
                <img src="{{ asset('images/favicon.ico') }}" alt="profile-user" class="avatar profile-user brround cover-image">
                <div class="p-1 text-center d-flex d-lg-none-max">
                    <h6 class="mb-0 ms-1" id="profile-heading"> Admin
                        <i class="user-angle ms-1 fa fa-angle-down "></i>
                    </h6>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow dropdown">
                <a href="" class="dropdown-item">
                    <i class="fa fa-fw fa-user pe-2"></i>
                    Change Password
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item">
                    <i class="fa fa-sign-out me-2"></i>
                    Sign out
                </a>
            </div>
        </div>
    </div>
</div>
