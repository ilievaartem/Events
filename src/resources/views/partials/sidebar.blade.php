<div class="sidebar-header border-bottom">
    <div class="sidebar-brand">
{{--      <svg class="sidebar-brand-full" width="88" height="32"> --}}{{--  alt="CoreUI Logo"--}}
            <use xlink:href="assets/brand/coreui.svg#full"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="32" height="32" >
{{--            <use xlink:href="assets/brand/coreui.svg#signet"></use>--}}
        </svg>
    </div>
    <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
            aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
</div>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-title">General</li>
    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">
            <svg class="nav-icon">
{{--                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-drop"></use>--}}
            </svg>
            Users</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">
            <svg class="nav-icon">
{{--                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>--}}
            </svg>
            Events</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">
            <svg class="nav-icon">
{{--                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>--}}
            </svg>
            Categories</a></li>
    <li class="nav-title">Geo</li>
    <li class="nav-group"><a class="nav-link" href="">
            <svg class="nav-icon">
{{--                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>--}}
            </svg>
            Country</a>
    <li class="nav-group"><a class="nav-link" href="{{ route('regions.index') }}">
            <svg class="nav-icon">
{{--                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cursor"></use>--}}
            </svg>
            Regions</a>
    <li class="nav-item"><a class="nav-link" href="">
            <svg class="nav-icon">
{{--                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chart-pie"></use>--}}
            </svg>
            Communities</a></li>
    <li class="nav-group"><a class="nav-link" href="">
            <svg class="nav-icon">
{{--                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-notes"></use>--}}
            </svg>
            Places</a>
    </li>
    <li class="nav-title">Contacts</li>
    <li class="nav-item"><a class="nav-link" href="{{ route('complaints.index') }}">
            <svg class="nav-icon">
            </svg>
            Complaints</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('comments.index') }}">
            <svg class="nav-icon">
            </svg>
            Comments</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('questions.index') }}">
            <svg class="nav-icon">
            </svg>
            Questions</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('messages.index') }}">
            <svg class="nav-icon">
            </svg>
            Messages</a></li>
</ul>
<div class="sidebar-footer border-top d-none d-md-flex">
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
