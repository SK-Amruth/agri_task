"use strict";

// Class definition
let SFS_EcommerceUser = function () {
    let form;
    let submitBtn, cancelBtn, i, modal;
    let validation;



    const userDiv = document.getElementById('userDiv');


    function setupEditModal(e) {
        let parent = this.parentElement;
        parent.querySelector('[data-firstname]');
        form.first_name.value = parent.querySelector('[data-firstname]').innerText;
        form.last_name.value = parent.querySelector('[data-lastname]').innerText;
        form.email.value = parent.querySelector('[data-email]').dataset.email;
        form.user_type.value = parent.querySelector('[data-user_type]').dataset.user_type;
        form.password.value = form.password_confirmation.value = parent.querySelector('[data-pwd]').dataset.pwd;
        form._method.value = 'PUT';
        form.querySelector('h1').innerText = "Edit User";
        form.querySelector('.indicator-label').innerText = "Update";
        form.querySelector('#userFormSubmit').classList.add('btn-warning');
        form.setAttribute("action", BASE_URL + '/users/' + this.dataset.id);
        modal.show()
    }

    const enableEdit = () => {
        const editUserBtn = document.querySelectorAll('.editUserBtn');
        editUserBtn.forEach((item) => {
            item.addEventListener('click', setupEditModal)
        });
    }

    function deleteUser() {
        let parent = this.parentElement;
        parent.querySelector('[data-firstname]');

        Swal.fire({
            title: "Sure! you want to delete " + parent.querySelector('[data-firstname]').innerText + "?",
            text: "Once deleted you cant able to retrive this user related datas",
            icon: "question",
            showCancelButton: true,
            buttonsStyling: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            },
            preConfirm: () => {
                return axios.delete(BASE_URL + '/users/' + this.dataset.id)
                    .then(function (response) {

                        if (response.data.status == 'success') {
                            Swal.fire({
                                icon: response.data.status,
                                title: response.data.title,
                                text: response.data.message,
                            }).then(function () {
                                window.location.reload();
                            });
                        } else if (response.data.status == 'info' || response.status == 'error') {
                            Swal.fire({
                                icon: response.data.status,
                                title: response.data.title,
                                text: response.data.message,
                            })
                        }


                    }).catch(function (error) {

                    }).finally(function () {

                    });

            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    }

    const enableDelete = () => {
        const deleteUserBtn = document.querySelectorAll('.deleteUserBtn');
        deleteUserBtn.forEach((item) => {
            item.addEventListener('click', deleteUser)
        });
    }

    const setUsers = (users) => {
        let html = '';
        users.forEach(user => {
            html += `<div class="col-md-4 col-sm-6 ">
            <div class="card card-rounded overflow-hidden position-relative">`;

            if (user.user_type == 'Accountant') {
                html += ` <a href="javascript:void(0)" class="deleteUserBtn" data-id="${user.id}"><div class="ribbon ribbon-top ribbon-vertical">
                <div class="ribbon-label bg-danger">
                    <i class="bi bi-trash fs-3 text-white"></i>
                </div>
            </div></a>`;
            }

            html += `  <div class="card-body d-flex flex-center flex-column ">
                <div class="symbol symbol-65px symbol-circle mb-5">
                    <img src="https://ui-avatars.com/api/?background=random&name=${user.first_name + ' ' + user.last_name}" alt="image" />
                    <div
                        class="bg-success position-absolute border border-4 border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3">
                    </div>
                </div>
                <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0"><span data-firstname='first_name'>${user.first_name}</span>&nbsp;<span data-lastname='last_name'>${user.last_name}</span></a>
                <div class="d-flex mt-2 mb-2">
                    <div class="badge ${user.user_type == 'Admin' ? 'badge-info' : 'badge-dark'} me-5" data-user_type=${user.user_type}>${user.user_type == 'Admin' ? 'Admin' : 'Accountant'}</div>
                </div>
                <div class="fw-semibold text-gray-400 mb-3" data-email='${user.email}'>${user.email}</div>
                <a href="javascript:void(0)" class="editUserBtn" data-id="${user.id}">
                <div class="ribbon ribbon-triangle ribbon-bottom-end border-warning" data-pwd='${user.show_password}'>
                <div class="ribbon-icon mt-0 ">
                        <i class="las la-highlighter fs-2 text-white"></i>
                    </div>
                </div></a>
            </div>
            </div >
        </div > `;
        });
        userDiv.innerHTML = html;
        enableEdit();
        enableDelete();
    }
    const fetchUsers = () => {
        axios.get(BASE_URL + '/users', {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(function (response) {

                if (response.data.status == 'success') {
                    setUsers(response.data.users)
                    // let notifications = response.data.notifications.data;
                    // if (response.data.notifications.to) setNotificationBody(notifications);
                    // if (response.data.notifications.next_page_url) {
                    //     link = response.data.notifications.next_page_url;
                    // } else {
                    //     isNeedFetch = false;
                    //     loader.removeAttribute('data-kt-indicator');
                    // }
                } else if (response.data.status == 'error') {


                }


            })
            .catch(function (error) {

            })
            .finally(function () {
                // loader.classList.add('d-none');
            });
    }


    const setUpsubmitForm = () => {
        validation = FormValidation.formValidation(form, {
            fields: {
                first_name: { validators: { notEmpty: { message: "first name field is required" } } },
                last_name: { validators: { notEmpty: { message: "last name field is required" } } },
                email: { validators: { notEmpty: { message: "email field is required" } } },
                user_type: { validators: { notEmpty: { message: "user type field is required" } } },
                password: { validators: { notEmpty: { message: "password field is required" } } },
                password_confirmation: { validators: { notEmpty: { message: "password confirmation field is required" } } },
            },
            plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "is-invalid", eleValidClass: "" }) },
        })


        submitBtn.addEventListener("click", function (e) {

            e.preventDefault();
            const field = Array.from(form.elements);
            // reset fields



            validation &&
                validation.validate().then(function (e) {
                    if ("Valid" == e) {
                        submitBtn.setAttribute("data-kt-indicator", "on")
                        submitBtn.disabled = !0
                        axios.post(form.getAttribute('action'), new FormData(form))
                            .then(function (response) {
                                if (response.data.status == 'success') {
                                    form.reset(), modal.hide();
                                    setUsers(response.data.users)
                                    Swal.fire({
                                        title: response.data.title,
                                        text: response.data.message,
                                        icon: response.data.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        },
                                    })
                                } else if (response.data.status == 'error' || response.data.status == 'info') {
                                    Swal.fire({
                                        title: response.data.title,
                                        text: response.data.message,
                                        icon: response.data.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        },
                                    })
                                }

                            })
                            .catch(function (error) {
                                if (error.response.status === 422) {
                                    let dataMessage = error.response.data.message;
                                    let dataErrors = error.response.data.errors;
                                    for (const errorsKey in dataErrors) {
                                        if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                        form.elements[errorsKey].classList.add("is-invalid");
                                        form.elements[errorsKey].parentElement.children[2].innerText = dataErrors[errorsKey];
                                    }
                                    if (error.response) {
                                        Swal.fire({
                                            text: dataMessage,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                }
                            })
                            .then(function () {
                                submitBtn.removeAttribute('data-kt-indicator');
                                submitBtn.disabled = false;
                            });
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn btn-primary" },
                        });
                    }

                });
        })
    }



    document.getElementById('addNewUser').addEventListener('click', function () {
        form.reset();
        form._method.value = 'POST';
        form.querySelector('h1').innerText = "Add New User";
        form.querySelector('.indicator-label').innerText = "Add";
        form.querySelector('#userFormSubmit').classList.remove('btn-warning');
        form.setAttribute("action", BASE_URL + '/users');
        modal.show()
    });

    document.querySelector('#userFormCancel').addEventListener('click', function (e) {
        e.preventDefault();
        form.reset();
        modal.hide();
    });





    return {
        init: function () {
            fetchUsers();
            (i = document.querySelector("#SFS_UserModal")) &&
                (modal = new bootstrap.Modal(i));
            form = document.querySelector('#userForm');
            submitBtn = form.querySelector('#userFormSubmit');
            setUpsubmitForm();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    SFS_EcommerceUser.init();
});
