@extends('layout.empty')

@section('title', '404 Error')

@section('content')
    <!-- BEGIN error -->
    <div class="error-page">
        <!-- BEGIN error-page-content -->
        <div class="error-page-content">
            <div class="error-img">
                <div class="error-img-code">404</div>
                <img src="/assets/img/page/404.svg" alt="" />
            </div>

            <h1>Oops!</h1>
            <h3>We can't seem to find the page you're looking for</h3>
            <p class="text-muted mb-2">
                Here are some helpful links instead:
            </p>
            <p class="mb-4">
                <a href="/" class="text-decoration-none">Home</a>
                <span class="link-divider"></span>
                <a href="/" class="text-decoration-none">Search</a>
                <span class="link-divider"></span>
                <a href="/" class="text-decoration-none">Email</a>
                <span class="link-divider"></span>
                <a href="/" class="text-decoration-none">Calendar</a>
                <span class="link-divider"></span>
                <a href="/" class="text-decoration-none">Settings</a>
                <span class="link-divider"></span>
                <a href="/" class="text-decoration-none">Helper</a>
            </p>
            <a href="/" class="btn btn-primary">Go to Homepage</a>
        </div>
        <!-- END error-page-content -->
    </div>
    <!-- END error -->
@endsection
