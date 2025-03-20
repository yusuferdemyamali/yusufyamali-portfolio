@extends('layout.app')
@section('content'),
<main class="s-content">
    <!-- ### intro
            ================================================== -->
    <section id="intro" class="s-intro target-section">

        <div class="row intro-content wide">

            <div class="column">
                <div class="text-pretitle with-line">
                    Merhaba Dünya
                </div>

                <h1 class="text-huge-title">
                    {{$about->title}} <br>
                    Back-End <br>
                    yazılım <br>
                    geliştiricisiyim.
                </h1>
            </div>

            <ul class="intro-social">
                <li><a href="{{$settings->instagram}}" target="_blank"><i class="fa-brands fa-square-instagram" style="font-size: 3em;"></i></a></li>
                <li><a href="{{$settings->linkedin}}" target="_blank"><i class="fa-brands fa-linkedin" style="font-size: 3em;"></i></a></li>
                <li><a href="{{$settings->github}}" target="_blank"><i class="fa-brands fa-github" style="font-size: 3em;"></i></a></li>
                <li><a href="https://wa.me/{{$settings->phone}}" target="_blank"><i class="fa-brands fa-whatsapp" style="font-size: 3em;"></i></a></li>
                <li><a href="mailto:{{$settings->email}}"><i class="fa-solid fa-envelope" style="font-size: 3em;"></i></a></li>
            </ul>

        </div> <!-- end intro content -->

        <a href="#about" class="intro-scrolldown smoothscroll">
            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M11 21.883l-6.235-7.527-.765.644 7.521 9 7.479-9-.764-.645-6.236 7.529v-21.884h-1v21.883z"/></svg>
        </a>

    </section> <!-- end s-intro -->
    <!-- ### about
                ================================================== -->
    <section id="about" class="s-about target-section">


        <div class="row about-info wide" data-animate-block>

            <div class="column lg-6 md-12 about-info__pic-block">
                <img src="{{asset('storage/' . $about->image)}}"
                     srcset="{{asset('storage/' . $about->image)}} 1x, {{asset('storage/' . $about->image)}} 2x" alt="" class="about-info__pic" data-animate-el>
            </div>

            <div class="column lg-6 md-12">
                <div class="about-info__text" >

                    <h2 class="text-pretitle with-line" data-animate-el>
                        Ben Kimim?
                    </h2>
                    <p class="attention-getter" data-animate-el>
                        {{$about->description}}
                    </p>
                    <a href="{{asset('CV.pdf')}}" class="btn btn--medium u-fullwidth" target="_blank" rel="noopener noreferrer" data-animate-el>CV’mi İncele.</a>

                </div>
            </div>
        </div> <!-- about-info -->


        <div class="row about-expertise" data-animate-block>
            <div class="column lg-12">

                <h2 class="text-pretitle" data-animate-el></h2>

                <ul class="skills-list h1" data-animate-el>
                    <li>Web Geliştirme</li>
                    <li>SEO Yönetimi</li>
                    <li>Sistem Yöneticiliği</li>
                    <li>Dijital Dönüşüm Uzmanı</li>
                    <li>Masaüstü Uyguluma Geliştirme</li>
                    <li>Bot Geliştirme</li>
                </ul>

            </div>
        </div> <!-- end about-expertise -->


        <div class="row about-timelines" data-animate-block>

            <div class="column lg-12" style="margin-bottom: 4rem;">

                <h2 class="text-pretitle" data-animate-el>
                    Deneyim
                </h2>

                <div class="timeline" data-animate-el>
                    @foreach($experiences->sortByDesc('start_date') as $experience)
                        <div class="timeline__block">
                            <div class="timeline__bullet"></div>
                            <div class="timeline__header">
                                <h4 class="timeline__title">{{$experience->company_name}}</h4>
                                <h5 class="timeline__meta">{{$experience->position}}</h5>
                                <p class="timeline__timeframe">
                                    {{$experience->start_date}} / {{$experience->end_date ?? 'Halen Çalışıyorum'}}
                                </p>
                            </div>
                            <div class="timeline__desc">
                                <p>
                                    {{$experience->description}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div> <!-- end timeline -->

            </div> <!-- end column -->

            <hr style="width: 100%; border: none; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 2rem 0;">


            <div class="column lg-12" style="margin-top: 4rem;">

                <h2 class="text-pretitle" data-animate-el>
                    Eğitim
                </h2>

                <div class="timeline" data-animate-el>

                    @foreach($educations->sortByDesc('start_date') as $education)
                        <div class="timeline__block">
                            <div class="timeline__bullet"></div>
                            <div class="timeline__header">
                                <h4 class="timeline__title">{{$education->school_name}}</h4>
                                <h5 class="timeline__meta">{{$education->field_of_study ?? '-'}}</h5>
                                <p class="timeline__timeframe">{{$education->start_date}} - {{$education->end_date ?? 'Halen Okuyorum'}}</p>
                            </div>
                            <div class="timeline__desc">
                                <p>{{$education->description ?? ''}}</p>
                            </div>
                        </div>
                    @endforeach


                </div> <!-- end timeline -->

            </div> <!-- end column -->


        </div> <!-- end about-timelines -->

    </section> <!-- end s-about -->
    <!-- ### works
            ================================================== -->
    <section id="works" class="s-works target-section">


        <div class="row works-portfolio">

            <div class="column lg-12" data-animate-block>

                <h2 class="text-pretitle" data-animate-el>
                    Geçmiş Projelerim
                </h2>
                <p class="h1" data-animate-el>
                    Son zamanlarda gerek müşterilerim için gerek kendi tutkumla çalıştığım projelerden bazıları. İlginizi çekerse göz atabilirsiniz!
                </p>

                <ul class="folio-list row block-lg-one-half block-stack-on-1000">

                    @foreach($works as $work)
                        <li class="folio-list__item column" data-animate-el>
                            <a class="folio-list__item-link" href="#modal-{{$work->id}}">
                                <div class="folio-list__item-pic">
                                    <img src="{{asset('storage/' . $work->image)}}" alt="">
                                </div>

                                <div class="folio-list__item-text">
                                    <div class="folio-list__item-cat">
                                        {{$work->work_type}}
                                    </div>
                                    <div class="folio-list__item-title">
                                        {{$work->title}}
                                    </div>
                                </div>
                            </a>
                            <a class="folio-list__proj-link" href="#modal-{{$work->id}}">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.14645 3.14645C8.34171 2.95118 8.65829 2.95118 8.85355 3.14645L12.8536 7.14645C13.0488 7.34171 13.0488 7.65829 12.8536 7.85355L8.85355 11.8536C8.65829 12.0488 8.34171 12.0488 8.14645 11.8536C7.95118 11.6583 7.95118 11.3417 8.14645 11.1464L11.2929 8H2.5C2.22386 8 2 7.77614 2 7.5C2 7.22386 2.22386 7 2.5 7H11.2929L8.14645 3.85355C7.95118 3.65829 7.95118 3.34171 8.14645 3.14645Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                            </a>
                        </li> <!--end folio-list__item -->
                    @endforeach

                </ul> <!-- end folio-list -->

            </div> <!-- end column -->


            <!-- Modal Templates Popup
            -------------------------------------------- -->
            @foreach($works as $work)
                <div id="modal-{{$work->id}}" hidden>
                    <div class="modal-popup">
                        <div class="swiper-container modal-slider">
                            <div class="swiper-wrapper">
                                @foreach($work->images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{asset('storage/' . $image->image)}}" alt="{{$work->title}}" style="width: 800px; height: 550px; object-fit: fill;">
                                        <div class="swiper-slide-caption">
                                            <h5>{{$image->title ?? 'Resim ' . $loop->iteration}}</h5>
                                            <p>{{$image->alt_text ?? 'Resim ' . $loop->iteration}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Slider navigasyon okları -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- Pagination göstergesi -->
                            <div class="swiper-pagination"></div>
                        </div>

                        <div class="modal-popup__desc">
                            <ul class="modal-popup__cat">
                                <li>{{$work->technologies}}</li>
                            </ul>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @if($work->github_link)
                                <li style="margin: 0 auto 1rem auto; text-align: center; width: 100%;">
                                    <a class="btn btn--medium" href="{{$work->github_link}}">Github Linki</a>
                                </li>
                            @endif
                            @if($work->demo_link)
                                    <li style="margin: 0 auto 1rem auto; text-align: center; width: 100%;">
                                            <a class="btn btn--medium" href="{{$work->demo_link}}">Demo Linki</a>
                                    </li>
                            @endif
                        </ul>
                    </div>

                </div> <!-- end modal -->
            @endforeach

        </div> <!-- end works-portfolio -->


    </section> <!-- end s-works -->

    <hr style="width: 100%; border: none; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 2rem 0;">

    <!-- ### blog
    ================================================== -->
    <section id="blogs" class="s-blog target-section">
        <div class="row works-portfolio" >
            <div class="column lg-12" data-animate-block>
                <p class="h1" data-animate-el>
                    Son Yazılarım
                </p>
            </div>
        </div>

        <div style="margin-top: 2rem;" class="row block-lg-one-half block-tab-whole" data-animate-block>
            @foreach($blogs as $blog)
                <div class="column" data-animate-el>
                    <div class="blog-card">
                        <div class="blog-card__image">
                            <img src="{{asset('storage/' . $blog->image)}}" alt="{{$blog->title}}">
                        </div>
                        <div class="blog-card__content">
                            <h3 class="blog-card__title">
                                <a href="{{ route('front.blog.details', $blog->slug) }}">
                                    {{$blog->title}}
                                </a>
                            </h3>
                            <p class="blog-card__excerpt">
                                {!! $blog->excerpt !!}
                            </p>
                            <div class="blog-card__meta">
                                <span class="date">{{$blog->created_at->format('d.m.Y')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row" data-animate-block>
            <div class="column lg-12" data-animate-el>
                <a href="{{ route('front.blog') }}" class="btn btn--medium u-fullwidth">
                    Tüm Yazıları Görüntüle
                </a>
            </div>
        </div>
    </section> <!-- end s-blog -->    <!-- ### contact
           ================================================== -->
    <section id="contact" class="s-contact target-section">

        <div class="row contact-top">
            <div class="column lg-12">
                <h2 class="text-pretitle">
                    Bana Ulaşın
                </h2>

                <p class="h1">
                    Sorularınız, destek veya hizmet talepleriniz için ya da sadece merhaba demek isterseniz, bana her zaman ulaşabilirsiniz. <br>
                </p>
            </div>
        </div> <!-- end contact-top -->

        <div class="row contact-bottom">
            <div class="column lg-6 md-5 tab-6 stack-on-550 contact-block">
                <h3 class="text-pretitle">İletişim Bilgilerim</h3>
                <p class="contact-links">
                    <a href="mailto:{{$settings->email}}" class="mailtoui">{{$settings->email}}</a> <br>
                    <a href="https://wa.me/{{$settings->phone}}">{{$settings->phone}}</a>
                </p>
            </div>
            <div class="column lg-6 md-5 tab-6 stack-on-550 contact-block">
                <h3 class="text-pretitle">Sosyal Medya Hesaplarım</h3>
                <ul class="contact-social">
                    <li><a href="{{$settings->linkedin}}" target="_blank">Linkedin</a></li>
                    <li><a href="{{$settings->instagram}}" target="_blank">Instagram</a></li>
                    <li><a href="{{$settings->github}}" target="_blank">Github</a></li>
                </ul>
            </div>
        </div> <!-- end contact-bottom -->

    </section> <!-- end contact -->
</main>
@endsection
