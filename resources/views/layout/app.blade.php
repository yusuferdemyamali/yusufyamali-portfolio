<!DOCTYPE html>
<html class="no-js ss-preload" lang="tr">
@include('layout.head')
<body id="top">


<div id="preloader">
    <div id="loader">
    </div>
</div>

    <div class="s-pagewrap">
        <div class="circles">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        @if(View::yieldContent('show_header') !== '0')
            @include('layout.header')
        @endif

        @yield('content')
        @include('layout.footer')
        @include('layout.script')

    </div>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/plugins.js')}}"></script>

</body>
</html>
