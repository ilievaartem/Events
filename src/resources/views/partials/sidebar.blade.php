<style>
    .position-icon {
        margin-right: 25px;
        margin-left: 8px;
    }
</style>
<div class="sidebar-header border-bottom">
    <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
            aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
</div>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fa-solid fa-chart-line position-icon"></i>
            Dashboard
            <span class="badge badge-sm bg-info ms-auto">NEW</span>
        </a>
    </li>
    <li class="nav-title">General</li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fa-solid fa-user-group position-icon"></i>
            Users
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('events.index') }}">
            <i class="fa-regular fa-calendar position-icon"></i>
            Events
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('categories.index') }}">
            <i class="fa-solid fa-list position-icon"></i>
            Categories
        </a>
    </li>
    <li class="nav-title">Geo</li>
    <li class="nav-group">
        <a class="nav-link" href="">
            <i class="fa-solid fa-flag-usa position-icon"></i>
            Country
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="{{ route('regions.index') }}">
            <i class="fa-solid fa-earth-americas position-icon"></i>
            Regions
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fa-solid fa-city position-icon"></i>
            Communities
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="">
            <i class="fa-solid fa-house position-icon"></i>
            Places
        </a>
    </li>
    <li class="nav-title">Contacts</li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('complaints.index') }}">
            <i class="fa-solid fa-flag position-icon"></i>
            Complaints
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('comments.index') }}">
            <i class="fa-solid fa-comments position-icon"></i>
            Comments
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('questions.index') }}">
            <i class="fa-solid fa-question position-icon"></i>
            Questions
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('messages.index') }}">
            <i class="fa-solid fa-message position-icon"></i>
            Messages
        </a>
    </li>
</ul>
<div class="sidebar-footer border-top d-none d-md-flex">
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
