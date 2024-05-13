<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
        @include('partials.sidebar')
    </div>
<div class="wrapper d-flex flex-column min-vh-100">
    <header class="header header-sticky p-0 mb-4">
        @include('partials.header')
    </header>
    <div class="body flex-grow-1">
        <div class="container-lg px-4">
            @yield('content')
        </div>
    </div>
    <footer class="footer px-4">
        @include('partials.footer')
    </footer>
</div>

@include('partials.scripts')

</body>
</html>
