<!-- header start -->
@include('backend.layout.header')
<!-- header end -->
<div id="app-view">
    <!-- sidebar start -->
    @include('backend.layout.sidebar')
    <!-- sidebar end -->
    <main class="main-content">
        <header class="top-header">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLMBJ7llJpN8xVe93gwvNziaTpbb9A9m0B8Q&s" alt="State Life Full Logo">
        </header>
        @yield('content')

</div>
    @stack('msncript')

@include('backend.layout.footer')