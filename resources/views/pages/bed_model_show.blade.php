@extends('layout.default',  [
    'appTopNav' => true,
	'appSidebarHide' => true,
	'appClass' => 'app-with-top-nav app-without-sidebar'
])

@section('title', 'Create Bed')

@push('css')
@endpush

@push('js')
@endpush

@section('content')
    <div class="container">
        <div class="card border-theme">
            <div class="card-title">
                Update Bed Model
            </div>
            <div class="card-body">
                @if ($errors->any())

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach

                @endif
                <form action="{{route('bed.update',$data)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    {{-- <h1>{{$data->section}}</h1> --}}
                    <div class="form-group mb-3">
                        <label class="form-label d-block" for="bed_section">Select Bed Section</label>
                        <div class="form-check form-check-inline">

                            <input class="form-check-input" name="section" type="radio" value="Section A"
                                id="section_female" @checked($data->section == 'Section A')>
                            <label class="form-check-label" for="section_female">Section A</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="section" type="radio" value="Section B"
                                id="section_male" @checked($data->section == 'Section B')>
                            <label class="form-check-label" for="section_male">Section B</label>

                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Bed Code</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Bed Code"
                            name="name" value="{{ old('name') ?? $data->name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description')  ?? $data->description}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full"> submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection
