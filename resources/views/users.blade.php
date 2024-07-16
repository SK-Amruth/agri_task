@extends('layouts.app')

@section('title', 'Users')


@section('styles')
@endsection

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Users</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('home.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Users</li>
                    </ul>
                </div>
                <a href="#" class="btn btn-sm fw-bold btn-dark" id="addNewUser">Add New Users</a>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="tab-content">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div id="kt_project_users_card_pane" class="tab-pane fade show active">
                        <div class="row g-6 g-xl-9" id="userDiv">


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('drawers')
@endsection

@section('modals')
    <div class="modal fade" id="SFS_UserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">

                    <form id="userForm" class="form" action="{{ route('users.store') }}" autocomplete="off">
                        <input type="hidden" name="_method" value="POST">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Add New User</h1>
                            <div class="text-muted fw-semibold fs-5">Active users can access admin panel
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="col-md-6 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">First Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="Enter First Name"
                                    name="first_name" />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Last Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="Enter Last Name"
                                    name="last_name" />
                            </div>

                            <div class="col-md-12 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Login Email Address</span>
                                </label>
                                <input type="email" class="form-control form-control-solid"
                                    placeholder="Enter Email Address" name="email" />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Password</span>
                                </label>
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Enter login password" name="password" />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Confirm Password</span>
                                </label>
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Re enter same password" name="password_confirmation" />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">Status</label>
                                <select class="form-select form-select-solid" data-placeholder="Select Status"
                                    name="user_type">
                                    <option value="" selected disabled>Select User Type</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Accountant">Accountant</option>
                                </select>
                            </div>

                        </div>

                        <div class="text-center">
                            <button type="reset" id="userFormCancel" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="userFormSubmit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('agri/users/index.js') }}"></script>
@endsection
