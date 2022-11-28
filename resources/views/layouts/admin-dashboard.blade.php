@include('admin.section.header')

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
        @include('admin.section.sidebar')
        @include('admin.section.top-nav')

                @yield('content')

        @include('admin.section.copy')
        </div>
    </div>

@include('admin.section.scripts')
</body>
@include('admin.section.footer')
