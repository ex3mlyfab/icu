@extends('layout.default', [
    'appTopNav' => true,
	'appSidebarHide' => true,
	'appClass' => 'app-with-top-nav app-without-sidebar'
])

@section('title', 'Users List')

@push('css')
	<link href="{{asset('assets/plugins/select-picker/dist/picker.min.css')}}" rel="stylesheet">
@endpush

@push('js')
<script src="{{asset('assets/plugins/select-picker/dist/picker.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#ex-search').picker({ search: true });
    });
</script>
@endpush

@section('content')
<div class="row mb-3">
    <div class="card border-1 border-teal-500">
        <div class="card-body">
           <h1>Edit User: {{$user->fullname}}</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="card">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif
        <form action="{{route('user.update', $user->id)}}" method="POST">
            @csrf
            @method('PUT')

        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="first-name">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg " id="first-name" name="first_name" value="{{$user->first_name ?? old('first_name')}}" placeholder="Enter First Name" required autofocus>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                     <div class="form-group mb-3">
                        <label class="form-label" for="last-name">Other Names <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="last-name" name="last_name" value="{{$user->last_name ?? old('last_name')}}" placeholder="Enter Other Names" required>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                     <div class="form-group mb-3">
                        <label class="form-label" for="telephome">Telephone No <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="telephome" name="telephone" value="{{$user->telephone ?? old('telephone')}}" placeholder="Enter Telephone No" >
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                     <div class="form-group mb-3">
                        <label class="form-label" for="telephome">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg" id="telephome" name="email" value="{{$user->email ?? old('email')}}" placeholder="Enter Telephone No" >
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <label class="form-label">Select Role <span class="text-danger">*</span></label>
                    <select class="selectpicker form-control form-control-lg" id="ex-search" name="role" @selected($user->role)>
                        @foreach ($roles as $item)
                            <option value="{{$item->name}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button class="w-full btn btn-outline-primary" type="submit"> Update User</button>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection
