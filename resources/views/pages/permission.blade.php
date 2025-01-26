@extends('layout.default', [
    'appTopNav' => true,
    'appSidebarHide' => true,
    'appClass' => 'app-with-top-nav app-without-sidebar',
])

@section('title', 'Users List')

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            loadPermission(1); // Initial load with page 1
            let rowId = 0;
            $('#skin-save-spinner').hide();

            // Handle search input
            $('#search-input').on('input', function() {
                loadPermission(1); // Refresh with the new search on first page
            });

            $('#add-new-row').on('click', function() {
                rowId++;
                $('#other-row').append(`
                    <div class="row" id="rowId-${rowId}">
                    <div class="col-md-9 mb-3">
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-skin">Permission Name</span>
                                            <input type="text" id="skin-integrity" class="form-control" name="permissions[]"
                                                placeholder="Permission" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 d-flex justify-content-center">
                                        <button type="button" class="btn btn-sm btn-danger delete-row" >Delete Row</button>

                    </div>
                </div>
        `)
        });
            $('#other-row').on('click', '.delete-row', function() {
                $(this).closest('.row').remove();
            });

            $('#perm-form').on('submit', function(e) {
                e.preventDefault();
                $('#skin-save-spinner').show();
                $.ajax({
                    url: '{{route('permission.store')}}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                        $('#modal-perm').modal('hide');
                        $('#perm-form')[0].reset();
                        $('#other-row').empty();
                        loadPermission(1); // Refresh with the new data on first page
                        $('#skin-save-spinner').hide();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving data:', error);
                        $('#skin-save-spinner').hide();
                    }
                });
            });
        // Handle pagination clicks (using event delegation for dynamically generated links)
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                loadPermission(page);
            });
            // reset modal on closing modal dialog
           $('.modal').on('hidden.bs.modal', function() {
                $('#perm-form')[0].reset();
                $('#other-row').empty();
            });

        });


        function loadPermission(page) {
            var search = $('#search-input').val();
            $.ajax({
                url: '{{ url('/') }}/admin/permissionn/get/?page=' + page + (search ? '&search=' + search :
                    ''),
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#product-list').empty(); // Clear current list

                    $.each(response.data, function(index, permission) {
                        $('#product-list').append(`
                         <div class="col-md-4 mb-3">
                             <div class="card border-theme">
                              <div class="card-body text-center">
                                   <h5 class="fw-bold">${permission.name}</h5>

                                </div>
                             </div>
                         </div>
                        `);
                    });

                    $('#pagination').html(generatePaginationLinks(response.links));
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }


        function generatePaginationLinks(links) {
            let html = `<nav aria-label="Page navigation example">
                             <ul class="pagination">`;

            links.forEach(link => {
                if (link.url) {
                    html += `<li class="page-item ${link.active ? 'active' : ''}">
                  <a class="page-link" href="${link.url}">${link.label}</a></li>`;
                } else {
                    html += `<li class="page-item disabled">
                 <span class="page-link">${link.label}</span></li>`;
                }

            });
            html += `</ul>
                      </nav>`;
            return html;
        }
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-1">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1>Permision</h1>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#modal-perm">Add New Permissions</button>
                </div>

            </div>
        </div>
    </div>
    <!--Begin Row -->
    <div class="row mt-3">
        <div class="mb-3">
            <input type="text" class="form-control" id="search-input" placeholder="Search by name">
        </div>
        <div id="product-list" class="row"></div>
        <div id="pagination"></div>
    </div>
    <div class="modal fade" id="modal-perm" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Permission(s)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="perm-form">

                    <div class="modal-body">
                        @csrf

                        <div class="row" id="significant-row">
                            <div class="col-md-9 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-skin">Permission Name</span>
                                    <input type="text" id="skin-integrity" class="form-control" name="permissions[]"
                                        placeholder="Permission" required>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 d-flex justify-content-center">
                                <button type="button" class="btn btn-sm btn-teal" id="add-new-row">Add more</button>

                            </div>

                        </div>
                        <div id="other-row"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="skin-save">
                            <div class="spinner-grow spinner-grow-sm" id="skin-save-spinner"></div> Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

