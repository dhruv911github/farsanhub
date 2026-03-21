<div class="app-sidebar">

    {{-- ─── DESKTOP: Full sidebar with logo + menu ─────────────── --}}
    <div class="main-menu">
        <div class="main-sidemenu text-center pb-3">
            <span class="sidebar-logo-text" style="font-size:1.5rem;font-weight:800;letter-spacing:1px;"><span style="color:#e85d04;">Farsan</span><span style="color:#000000;">Hub</span></span>
        </div>
        <div class="pt-2 side-menu">

            <div class="slide animate-right px-2">
                <a @class(['side-menu__item has-link', 'active' => request()->routeIs('admin.dashboard')])
                    data-bs-toggle="slide" href="{{ route('admin.dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1772 1772">
                        <path d="M384 1152q0-53-37.5-90.5T256 1024t-90.5 37.5T128 1152t37.5 90.5T256 1280t90.5-37.5T384 1152zm192-448q0-53-37.5-90.5T448 576t-90.5 37.5T320 704t37.5 90.5T448 832t90.5-37.5T576 704zm428 481 101-382q6-26-7.5-48.5T1059 725t-48 6.5-30 39.5l-101 382q-60 5-107 43.5t-63 98.5q-20 77 20 146t117 89 146-20 89-117q16-60-6-117t-72-91zm660-33q0-53-37.5-90.5T1536 1024t-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm-640-640q0-53-37.5-90.5T896 384t-90.5 37.5T768 512t37.5 90.5T896 640t90.5-37.5T1024 512zm448 192q0-53-37.5-90.5T1344 576t-90.5 37.5T1216 704t37.5 90.5T1344 832t90.5-37.5T1472 704zm320 448q0 261-141 483-19 29-54 29H195q-35 0-54-29Q0 1414 0 1152q0-182 71-348t191-286 286-191 348-71 348 71 286 191 191 286 71 348z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="side-menu__label">{{ __('portal.dashboard') }}</span>
                </a>
            </div>

            <div class="slide animate-right px-2">
                <a @class(['side-menu__item has-link', 'active' => request()->routeIs('admin.expense.*')])
                    data-bs-toggle="slide" href="{{ route('admin.expense.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 8.25H9m6 3H9m3 6-3-3h1.5a3 3 0 1 0 0-6M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span class="side-menu__label">{{ __('portal.expense') }}</span>
                </a>
            </div>

            <div class="slide animate-right px-2">
                <a @class(['side-menu__item has-link', 'active' => request()->routeIs('admin.customer.*')])
                    data-bs-toggle="slide" href="{{ route('admin.customer.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <span class="side-menu__label">{{ __('portal.customers') }}</span>
                </a>
            </div>

            <div class="slide animate-right px-2">
                <a @class(['side-menu__item has-link', 'active' => request()->routeIs('admin.product.*')])
                    data-bs-toggle="slide" href="{{ route('admin.product.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <span class="side-menu__label">{{ __('portal.products') }}</span>
                </a>
            </div>

            <div class="slide animate-right px-2">
                <a @class(['side-menu__item has-link', 'active' => request()->routeIs('admin.order.*')])
                    data-bs-toggle="slide" href="{{ route('admin.order.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <span class="side-menu__label">{{ __('portal.orders') }}</span>
                </a>
            </div>

            <div class="slide animate-right px-2">
                <a @class(['side-menu__item has-link', 'active' => request()->routeIs('admin.monthly-report.*')])
                    data-bs-toggle="slide" href="{{ route('admin.monthly-report.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span class="side-menu__label">{{ __('portal.monthly-reports') }}</span>
                </a>
            </div>

        </div>
    </div>

</div>

{{-- ─── MOBILE: Custom full-height sidebar — rendered at body level via @push ── --}}
@push('mobile-sidebar')

{{-- Dark backdrop --}}
<div id="mob-sidebar-backdrop" class="mob-sidebar-backdrop" onclick="closeMobSidebar()" style="display: none;"></div>

{{-- Sidebar panel --}}
<div id="mob-sidebar" class="mob-sidebar" style="visibility: hidden; transform: translateX(-100%);">

    {{-- Header strip --}}
    <div class="mob-sidebar-head">
        <div class="mob-sidebar-brand">
            <span class="mob-brand-logo"><span style="color:#e85d04;">Farsan</span><span style="color:#fff;">Hub</span></span>
            <small class="mob-brand-user">{{ auth()->user()->name ?? '' }}</small>
        </div>
        <button class="mob-sidebar-close" onclick="closeMobSidebar()" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    {{-- Menu --}}
    <nav class="mob-sidebar-nav">

        <a href="{{ route('admin.dashboard') }}"
           class="mob-nav-item @if(request()->routeIs('admin.dashboard')) active @endif">
            <span class="mob-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1772 1772" width="22" height="22">
                    <path d="M384 1152q0-53-37.5-90.5T256 1024t-90.5 37.5T128 1152t37.5 90.5T256 1280t90.5-37.5T384 1152zm192-448q0-53-37.5-90.5T448 576t-90.5 37.5T320 704t37.5 90.5T448 832t90.5-37.5T576 704zm428 481 101-382q6-26-7.5-48.5T1059 725t-48 6.5-30 39.5l-101 382q-60 5-107 43.5t-63 98.5q-20 77 20 146t117 89 146-20 89-117q16-60-6-117t-72-91zm660-33q0-53-37.5-90.5T1536 1024t-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm-640-640q0-53-37.5-90.5T896 384t-90.5 37.5T768 512t37.5 90.5T896 640t90.5-37.5T1024 512zm448 192q0-53-37.5-90.5T1344 576t-90.5 37.5T1216 704t37.5 90.5T1344 832t90.5-37.5T1472 704zm320 448q0 261-141 483-19 29-54 29H195q-35 0-54-29Q0 1414 0 1152q0-182 71-348t191-286 286-191 348-71 348 71 286 191 191 286 71 348z" fill="currentColor"/>
                </svg>
            </span>
            <span class="mob-nav-label">{{ __('portal.dashboard') }}</span>
        </a>

        <a href="{{ route('admin.expense.index') }}"
           class="mob-nav-item @if(request()->routeIs('admin.expense.*')) active @endif">
            <span class="mob-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="22" height="22">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 8.25H9m6 3H9m3 6-3-3h1.5a3 3 0 1 0 0-6M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </span>
            <span class="mob-nav-label">{{ __('portal.expense') }}</span>
        </a>

        <a href="{{ route('admin.customer.index') }}"
           class="mob-nav-item @if(request()->routeIs('admin.customer.*')) active @endif">
            <span class="mob-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="22" height="22">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </span>
            <span class="mob-nav-label">{{ __('portal.customers') }}</span>
        </a>

        <a href="{{ route('admin.product.index') }}"
           class="mob-nav-item @if(request()->routeIs('admin.product.*')) active @endif">
            <span class="mob-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="22" height="22">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </span>
            <span class="mob-nav-label">{{ __('portal.products') }}</span>
        </a>

        <a href="{{ route('admin.order.index') }}"
           class="mob-nav-item @if(request()->routeIs('admin.order.*')) active @endif">
            <span class="mob-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="22" height="22">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </span>
            <span class="mob-nav-label">{{ __('portal.orders') }}</span>
        </a>

        <a href="{{ route('admin.monthly-report.index') }}"
           class="mob-nav-item @if(request()->routeIs('admin.monthly-report.*')) active @endif">
            <span class="mob-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="22" height="22">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </span>
            <span class="mob-nav-label">{{ __('portal.monthly-reports') }}</span>
        </a>

    </nav>
</div>

<script>
function openMobSidebar() {
    const sidebar = document.getElementById('mob-sidebar');
    const backdrop = document.getElementById('mob-sidebar-backdrop');
    
    // Clear inline states to let CSS transitions take over
    sidebar.style.visibility = 'visible';
    sidebar.style.transform = 'translateX(0)';
    sidebar.classList.add('open');
    
    backdrop.style.display = 'block';
    setTimeout(() => backdrop.classList.add('show'), 10);
    
    document.body.style.overflow = 'hidden';
}
function closeMobSidebar() {
    const sidebar = document.getElementById('mob-sidebar');
    const backdrop = document.getElementById('mob-sidebar-backdrop');
    
    sidebar.classList.remove('open');
    backdrop.classList.remove('show');
    
    setTimeout(() => {
        if (!sidebar.classList.contains('open')) {
            sidebar.style.visibility = 'hidden';
            sidebar.style.transform = 'translateX(-100%)';
        }
        if (!backdrop.classList.contains('show')) {
            backdrop.style.display = 'none';
        }
    }, 320); // match CSS transition time
    
    document.body.style.overflow = '';
}
</script>
@endpush
