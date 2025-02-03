@extends('layout.default', [
    'appTopNav' => true,
	'appSidebarHide' => true,
	'appClass' => 'app-with-top-nav app-without-sidebar'
])

@section('title', 'change password')

@section('content')
<div class="card shadow border-1 border-theme mb-5">
    <div class="card-body">
        <h1>Change your Password</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
         @if ($errors->any())

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach

                @endif
            <form action="{{route('change-password')}}" method="POST">
                @csrf
                <div class="container">
                <div class="form-group mb-3">
                        <label class="form-label" for="password">New Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter Password"
                            name="password" >
                </div>
                <div class="form-group mb-3">
                        <label class="form-label" for="confirm password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password"
                            name="password_confirmation">
                </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3.5"> Submit</button>

                </div>
            </form>
    </div>
</div>
@endsection
