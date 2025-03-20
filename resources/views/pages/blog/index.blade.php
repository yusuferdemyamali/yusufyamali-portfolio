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

    <section id="blogs" class="s-works target-section">
        <div class="row works-portfolio">
            <div class="column lg-12">

                <h2 class="text-pretitle">
                    İlginizi Çekebilecek
                </h2>
                <p class="h1">
                    Son Blog Yazıları. <br>
                </p>

                <ul class="folio-list row block-lg-one-half block-stack-on-1000">

                    @foreach($blogs as $blog)
                        <li class="folio-list__item column">
                            <a class="folio-list__item-link" href="{{route('front.blog.details',['slug'=>$blog->slug])}}">
                                <div class="folio-list__item-pic">
                                    <img src="{{asset('storage/' . $blog->image)}}" alt="">
                                </div>

                                <div class="folio-list__item-text">
                                    <div class="folio-list__item-title">
                                        {{$blog->title}}
                                    </div>
                                    <div style="margin-top: 2rem;" class="folio-list__item-cat">
                                        {!! $blog->excerpt !!}
                                    </div>
                                </div>
                            </a>
                            <a class="folio-list__proj-link" href="{{route('front.blog.details',['slug'=>$blog->slug])}}">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.14645 3.14645C8.34171 2.95118 8.65829 2.95118 8.85355 3.14645L12.8536 7.14645C13.0488 7.34171 13.0488 7.65829 12.8536 7.85355L8.85355 11.8536C8.65829 12.0488 8.34171 12.0488 8.14645 11.8536C7.95118 11.6583 7.95118 11.3417 8.14645 11.1464L11.2929 8H2.5C2.22386 8 2 7.77614 2 7.5C2 7.22386 2.22386 7 2.5 7H11.2929L8.14645 3.85355C7.95118 3.65829 7.95118 3.34171 8.14645 3.14645Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                            </a>
                        </li> <!--end folio-list__item -->
                    @endforeach
                </ul>
            </div> <!-- end column -->
        </div>
    </section>

@endsection
