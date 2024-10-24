<meta charset="utf-8" />
<title>ICU | @yield('title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="@yield('metaDescription')" />
<meta name="author" content="@yield('metaAuthor')" />
<meta name="keywords" content="@yield('metaKeywords')" />
<link rel="shortcut icon" href="{{asset('images/fmc_logo.ico')}}" type="image/x-icon">

@stack('metaTag')

<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="{{asset('assets/css/vendor.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" /> 

<!-- original style for bootstrap 4.1.3 --> <!-- <link href="/assets/css/app.min.css" rel="stylesheet" /> -->
<!-- =================== END BASE CSS STYLE ================== -->

@stack('css')
