@extends('layouts.app')
@section('title',$pageTitle)
@section('content')
    <section class="admin-content">
        <div class="bg-dark">
            <div class="container-fluid m-b-30">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-white p-t-40 p-b-90">
                        <h4>Guarantor List</h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-t-40 p-b-90">
                        <div class="row align-items-end justify-content-end">
                            <div class="col-lg-6 col-md-4 col-sm-12">
                                <button class="btn m-b-15 ml-2 mr-2 btn-dark w-75" data-toggle="modal"
                                    data-target="#createModal">
                                    Create New Guarantor
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pull-up">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-t-10">
                                <table id="example" class="table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($guarantors as $key => $guarantor)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $guarantor->name }}</td>
                                                <td>{{ $guarantor->email }}</td>
                                                <td>{{ $guarantor->phone }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#"
                                                            class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-primary edit-user"
                                                            data-toggle="modal" data-target="#editModal"
                                                            data-id="{{ $guarantor->id }}"
                                                            data-name="{{ $guarantor->name }}"
                                                            data-email="{{ $guarantor->email }}"
                                                            data-phone="{{ $guarantor->phone }}"
                                                            data-address="{{ $guarantor->address }}">
                                                            <i class="mdi mdi-pen"></i>
                                                        </a>

                                                        <button type="button"
                                                            class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-dark"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            data-id="{{ $guarantor->id }}"
                                                            data-name="{{ $guarantor->name }}">
                                                            <i class="mdi mdi-delete-forever"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Create Guarantor Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create New Guarantor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('guarantors.store') }}" id="create_guarantor">
                        @csrf
                        <div class="form-group">
                            <label for="create-name">Guarantor Name</label>
                            <input type="text" class="form-control" id="create-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="create-email">Guarantor Email</label>
                            <input type="email" class="form-control" id="create-email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="create-phone">Phone</label>
                            <input type="text" class="form-control" id="create-phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="create-address">Address</label>
                            <input type="text" class="form-control" id="create-address" name="address">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Create Guarantor" id="create-guarantor"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Create Guarantor Modal -->

    <!-- Edit Confirmation Modal Popup -->
    @if(isset($guarantor))
    <div class="modal fade add-category-list" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="editGuarantorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGuarantorModalLabel">Edit Guarantor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit-name">Guarantor Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name"
                                value="{{ $guarantor->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Guarantor Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email"
                                value="{{ $guarantor->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-phone">Phone</label>
                            <input type="text" class="form-control" id="edit-phone" name="phone"
                                value="{{ $guarantor->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-address">Address</label>
                            <input type="text" class="form-control" id="edit-address" name="address"
                            value="{{ $guarantor->address }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Guarantor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Confirmation Modal Popup -->

    <!-- Delete Confirmation Modal Popup -->
    <div class="modal fade category-delete-conformation" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mySmallModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="deleteConfirmationMessage">Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal Popup -->
@endsection
@section('scripts')
<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var guarantorId = button.data('id');

        var formAction = site_url + '/guarantors/' + guarantorId;
        $(this).find('#deleteForm').attr('action', formAction);
    });

    $('.edit-user').on("click", function () {
        let userId = $(this).data("id");
        let userName = $(this).data("name");
        let userEmail = $(this).data("email");
        let userPhone = $(this).data("phone");
        let userAddress = $(this).data("address");

        $("#editModal #userId").val(userId);
        $("#editModal #edit-name").val(userName);
        $("#editModal #edit-email").val(userEmail);
        $("#editModal #edit-phone").val(userPhone);
        $("#editModal #edit-address").val(userAddress);

        var formAction = site_url + '/guarantors/' + userId;
        $(document).find('#editForm').attr('action', formAction);
    });

    $(document).ready(function(){
        $("#create-guarantor").click(function(event) {
            $('#create_guarantor').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                        maxlength: 255,
                    },
                    email: {
                        email: true,
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    address: {
                        required: true,
                    },

                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    })
</script>
@endsection
