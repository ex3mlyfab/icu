@extends('layout.empty')

@section('title', 'Login')

@section('content')
    <!-- BEGIN login -->

            <div class="login" style="background: url({{ asset('images/gate.jpg') }}) center; height: 100vh; background-size: cover;">

                <!-- BEGIN login-content -->
                <div class="login-content">
                    <div class="card border-theme shadow-sm mb-3 p-2">
                        <div class="card-body">
                        <img src="{{asset('images/fmc_logo.jpeg')}}" alt="" class="card-img-top" height="180"/>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title text-center text-primary fw-bolder">ICU </h1>
                            <h4 class="card-text text-center text-primary">Monitoring Application</h4>
                        </div>

                    <form action="{{route('login')}}" method="POST" name="login_form">
                        @csrf
                        <h1 class="text-center">Sign In</h1>

                        @session('status')
                            <div class="alert alert-danger" role="alert">
                                {{ session('status') }}
                            </div>
                        @endsession
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="text" class="form-control form-control-lg fs-15px" name="email"
                                value="{{ old('email') }}"
                                @error('email')
                        is-invalid
                    @enderror
                                placeholder="username@address.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="d-flex">
                                <label class="form-label">Password</label>
                                {{-- <a href="route('password.request')" class="ms-auto text-muted">Forgot password?</a> --}}
                            </div>
                            <input type="password" class="form-control form-control-lg fs-15px" name="password"
                                placeholder="Enter your password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="customCheck1"
                                    name="remember">
                                <label class="form-check-label fw-500" for="customCheck1">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-theme btn-lg d-block w-100 fw-500 mb-3">Sign In</button>

                    </form>
                    </div>
                </div>
                <!-- END login-content -->

            </div>
    <!-- END login -->
@endsection
