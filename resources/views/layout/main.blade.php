<!doctype html>
<html>
    {{-- <html lang="en" dir="ltr"> --}}
    <!--Head-->
    @include('layout/head')
    <!--/ Head-->

    <body class="font-montserrat">
    <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
            </div>
        </div>
        <div id="main_content">
            <!--sidebar-->
            @include('layout/sidebar')
            <!--/ sidebar-->
            <div class="page">
                <!--navbar-->
                @include('layout/navbar')
                <!--/ navbar-->
                @yield('content')
            </div>  
                <!--footer-->
                {{-- @include('layout/footer') --}}
                <!--/ footer-->  
        </div>  
        <!--common scripts-->
        @include('layout/scripts')
        <!--/ common scripts-->  
    </body>
</html>
