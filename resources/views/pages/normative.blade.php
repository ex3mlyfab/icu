@extends('layout.default', [
    'appTopNav' => true,
    'appSidebarHide' => true,
    'appClass' => 'app-with-top-nav app-without-sidebar',
])

@section('title', 'Normative Value')

@push('css')
@endpush

@push('js')
   <script>
     $(document).ready(function(){

    });
   </script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title
                        ">Normative Value</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatableDefault">
                                <thead>
                                    <tr>
                                        <th>Parameter</th>
                                        <th>lower Limit</th>
                                        <th>High Limit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

