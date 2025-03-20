<head>
    <meta charset="utf-8">
    <title>{{$settings->site_description}}</title>
    <meta name="description" content="{{$settings->meta_description}}">
    <meta name="author" content="{{$settings->site_title}}">
    <meta name="keywords" content="{{$settings->meta_keywords}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor.css')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/apple-touch-icon.png')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('storage/' . $settings->site_favicon)}}">
    <link rel="manifest" href="{{asset('site.webmanifest')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
