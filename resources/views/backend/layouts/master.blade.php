<!DOCTYPE html>
<html lang="pt-BR">
@include('backend.layouts.head')

<body id="page-top">

    {{-- Page Wrapper --}}
    <div id="wrapper">

    {{-- Sidebar --}}
    @include('backend.layouts.sidebar')
    {{-- End of sidebar --}}

    {{-- Content Wrapper --}}
    <div id="content-wrapper" class="d-flex flex-column">

    {{-- Main content --}}
    <div id="content">

        {{-- Topbar --}}
        @include('backend.layouts.header')
        {{-- End of Topbar --}}

        {{-- Page content --}}
        @yield('content')
        {{-- End of content --}}
    </div>
    {{-- End of Main-content --}}
    @include('backend.layouts.footer')
</body>

</html>
