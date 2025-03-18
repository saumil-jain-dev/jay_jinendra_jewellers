@extends('layouts.app')
@section('title',$pageTitle)
@section('content')
    <section class="admin-content">
        <div class="bg-dark">
            <div class="container-fluid m-b-30">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-white p-t-40 p-b-90">
                        <h4>User List</h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-t-40 p-b-90">
                        <div class="row align-items-end justify-content-end">
                            <div class="col-lg-6 col-md-4 col-sm-12">
                                <button class="btn m-b-15 ml-2 mr-2 btn-dark w-75" data-toggle="modal"
                                    data-target="#createModal">
                                    Create New User
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
                                        @foreach ($parties as $key => $party)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $party->name }}</td>
                                                <td>{{ $party->email }}</td>
                                                <td>{{ $party->phone }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#"
                                                            class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-primary edit-user"
                                                            data-toggle="modal" data-target="#editModal"
                                                            data-id="{{ $party->id }}" data-name="{{ $party->name }}"
                                                            data-email="{{ $party->email }}"
                                                            data-phone="{{ $party->phone }}"
                                                            data-address="{{ $party->address }}"
                                                            data-aadhar_card_no="{{ $party->aadhar_card_no }}">
                                                            <i class="mdi mdi-pen"></i>
                                                        </a>
                                                        <a type="button" class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-primary"
                                                            href="{{ route('parties.show',$party->id) }}"
                                                        >
                                                        <i class="mdi mdi-eye"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-sm ml-2 mr-2 p-1 pr-2 pl-2 btn-dark"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            data-id="{{ $party->id }}" data-name="{{ $party->name }}">
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

    <!-- Create User Modal -->
    <!-- Create User Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('parties.store') }}" id="create-user">
                        @csrf
                        <div class="form-group">
                            <label for="create-name">User Name</label>
                            <input type="text" class="form-control" id="create-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="create-email">User Email</label>
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
                        <div class="form-group">
                            <label for="create-phone">Aadhar Card Number</label>
                            <input type="text" class="form-control" id="create-aadhar_card_no" name="aadhar_card_no">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Create User" id="create_user" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Create User Modal -->

    <!-- End Create User Modal -->

    <!-- Edit User Modal -->
    @if(isset($party))
    <div class="modal fade add-category-list" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit-name">User Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name"
                                value="{{ $party->name }}">
                        </div>
                        <div class="form-group">
                            <label for="edit-email">User Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email"
                                value="{{ $party->email }}" >
                        </div>
                        <div class="form-group">
                            <label for="edit-phone">Phone</label>
                            <input type="text" class="form-control" id="edit-phone" name="phone"
                                value="{{ $party->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="edit-address">Address</label>
                            <input type="text" class="form-control" id="edit-address" name="address"
                            value="{{ $party->address }}">
                        </div>
                        <div class="form-group">
                            <label for="edit-phone">Aadhar Card Number</label>
                            <input type="text" class="form-control" id="edit-aadhar_card_no" name="aadhar_card_no"
                                value="{{ $party->aadhar_card_no }}">
                        </div>
                        {{-- <div class="form-group">
                            <label for="edit-guarantor">Guarantor</label>
                            <select class="form-control" id="edit-gurantor" name="gurantor[]" multiple="true">
                                <option>Select Guarantor</option>
                                @foreach ($guarantor as $guarantorData)
                                    <option value="{{ $guarantorData->id }}">{{ $guarantorData->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <input type="submit" class="btn btn-primary" value="Update User" id="update-user" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- End Edit User Modal -->

    <!-- Delete Confirmation Modal -->
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
    <!-- End Delete Confirmation Modal -->
@endsection
@section('scripts')
<script type="text/javascript">
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var userId = button.data('id'); // Extract user ID from data-* attributes

        var formAction = site_url + '/parties/' + userId; // Construct the form action URL
        $(this).find('#deleteForm').attr('action', formAction); // Set the action attribute
    });

    $('.edit-user').on("click", function () {
        let userId = $(this).data("id");
        let userName = $(this).data("name");
        let userEmail = $(this).data("email");
        let userPhone = $(this).data("phone");
        let userAddress = $(this).data("address");
        let aadharCardNo = $(this).data("aadhar_card_no");

        $("#editModal #userId").val(userId);
        $("#editModal #edit-name").val(userName);
        $("#editModal #edit-email").val(userEmail);
        $("#editModal #edit-phone").val(userPhone);
        $("#editModal #edit-address").val(userAddress);
        $("#editModal #edit-aadhar_card_no").val(aadharCardNo);

        var formAction = site_url + '/parties/' + userId;
        $(document).find('#editForm').attr('action', formAction);
    });

    // Initialize select2 for multiple select dropdown
    $(document).ready(function() {
        $('#edit-gurantor').select2({
            placeholder: 'Select Guarantors',
            allowClear: true
        });

        //Form validation

        function setupValidation(formSelector) {
            $(formSelector).validate({
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
                    aadhar_card_no:{
                        digits: true,
                        minlength: 12,
                        maxlength: 12,
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        }

        // Bind validation to forms
        $("#create_user").click(function () {
            setupValidation('#create-user');
        });

        $("#update-user").click(function () {
            setupValidation('#editForm');
        });
    });
</script>
@endsection
