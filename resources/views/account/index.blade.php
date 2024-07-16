@extends('layouts.app')

@section('title', 'Account')


@section('styles')
@endsection

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Account
                        Details
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('home.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Account Details</li>
                    </ul>
                </div>
                <a href="#" class="btn btn-sm fw-bold btn-dark" id="addNewPayment">Add New Payment</a>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container">
                <div class="card card-flush mt-6 mt-xl-12">
                    <div class="card-header mt-5">
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1">Account Details</h3>
                        </div>
                        <div class="card-toolbar my-1">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-3 position-absolute ms-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input type="text" data-table-search="search"
                                    class="form-control form-control-solid form-select-sm w-150px ps-9"
                                    placeholder="Search Account" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table id="paymentTable"
                                class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-30px pe-2">#</th>
                                        <th>Item</th>
                                        <th>Type</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-6">

                                </tbody>
                            </table>

                            <div id="totalAmountContainer">
                                <h2>Total Amount: <span id="totalAmount"></span></h2>
                            </div>
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

    <div class="modal fade" id="PaymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <h1 class="modal-title" id="payment-modal-title">Add Payment</h1>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                        </svg>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">

                    <form id="paymentForm" method="POST" class="form" action="#" autocomplete="off"
                        enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Add New Payment</h1>
                        </div>

                        <div class="row g-9 mb-8">

                            <input type="hidden" name="user"
                                value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}">

                            <div class="col-md-12 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Item Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" placeholder="Enter Item Name"
                                    name="item" />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">Type</label>
                                <select class="form-select form-select-solid" data-placeholder="Select Status"
                                    name="type">
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="Income">Income</option>
                                    <option value="Expense">Expense</option>
                                </select>
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Amount</span>
                                </label>
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Enter Item Amount" name="amount" />
                            </div>

                        </div>

                        <div class="text-end">
                            <button type="reset" id="paymentFormCancel" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="paymentFormSubmit" class="btn btn-primary">
                                <span class="indicator-label" id="btn-text">Submit</span>
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
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('agri/accounts/index.js') }}"></script>
@endsection
