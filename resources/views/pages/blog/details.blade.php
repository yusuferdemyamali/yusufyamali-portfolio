@extends('layout.app')
@section('show_header', '0')
@section('content')
    <header class="s-header">

        <div class="header-mobile">
            <span class="mobile-home-link"><a href="{{route('front.home')}}">Ana Sayfa.</a></span>
        </div>

        <div class="row wide main-nav-wrap">
            <nav class="column lg-12 main-nav">
                <ul>
                    <li><a href="{{route('front.home')}}" class="home-link">Ana Sayfa.</a></li>
                </ul>
            </nav>
        </div>

    </header> <!-- end s-header -->

    <div id="styles" class="s-styles">
        <div class="row">

            <div class="column lg-12 intro">

                <h1>{{$blog->title}}</h1>

                <p class="lead">
                    {!! $blog->content !!}
                </p>

                <hr>
            </div>

        </div> <!-- end row -->

    </div>

@endsection
