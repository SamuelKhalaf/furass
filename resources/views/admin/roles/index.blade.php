@use(\App\Enums\PermissionEnum)
@extends('admin.layouts.master')

@section('title', 'Roles')

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Roles
                        List</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">System Management</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Roles</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                    @if(!empty($roles) && $roles->count() > 0)
                        @foreach($roles as $role)
                            <!--begin::Col-->
                            <div class="col-md-4">
                                <!--begin::Card-->
                                <div class="card card-flush h-md-100">
                                    <!--begin::Card header-->
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>{{$role->name}}</h2>
                                        </div>
                                        <!--end::Card title-->
                                        @if(auth()->user()->hasPermissionTo(PermissionEnum::DELETE_ROLES->value))
                                        <!--begin::Delete button-->
                                        <a href="#" class="btn deleteRoleButton p-2 d-flex align-items-center" data-role-id="{{ $role->id }}">
                                            <i class="bi bi-trash delete-icon fs-5 text-hover-danger" style="color: #ff6666;"></i>
                                        </a>
                                        <!--end::Delete button-->
                                        @endif
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-1">
                                        <!--begin::Users-->
                                        <div class="fw-bold text-gray-600 mb-5">Total users with this
                                            role: {{$role->users_count}}</div>
                                        <!--end::Users-->
                                        <!--begin::Permissions-->
                                        <div class="d-flex flex-column text-gray-600">
                                            @if ($role->permissions->isNotEmpty())
                                                @foreach ($role->permissions->take(5) as $permission)
                                                    <div class="d-flex align-items-center py-2">
                                                        <span
                                                            class="bullet bg-primary me-3"></span>{{ $permission->name }}
                                                    </div>
                                                @endforeach

                                                @if ($role->permissions->count() > 5)
                                                    <div class="d-flex align-items-center py-2">
                                                        <span class="bullet bg-primary me-3"></span>
                                                        <em>and {{ $role->permissions->count() - 5 }} more...</em>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-muted">No permissions assigned</div>
                                            @endif
                                        </div>
                                        <!--end::Permissions-->
                                    </div>
                                    <!--end::Card body-->
                                    <!--begin::Card footer-->
                                    @if(auth()->user()->hasAnyPermission([PermissionEnum::VIEW_ROLES->value,PermissionEnum::UPDATE_ROLES->value]))
                                    <div class="card-footer flex-wrap pt-0">
                                        @if(auth()->user()->hasPermissionTo(PermissionEnum::VIEW_ROLES->value))
                                            <a href="{{route('admin.roles.show',$role->id)}}" class="btn btn-light btn-active-primary my-1 me-2">
                                                View Role
                                            </a>
                                        @endif
                                        @if(auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_ROLES->value))
                                            <button type="button" id="editRoleButton" class="btn btn-light btn-active-light-primary my-1"
                                                    data-role-id="{{ $role->id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                                                Edit Role
                                            </button>
                                        @endif
                                    </div>
                                    @endif
                                    <!--end::Card footer-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Col-->
                        @endforeach
                    @endif
                    <!--begin::Add Role card-->
                        @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_ROLES->value))
                            <div class="ol-md-4">
                                <!--begin::Card-->
                                <div class="card h-md-100">
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex flex-center">
                                        <!--begin::Button-->
                                        <button type="button" class="btn btn-clear d-flex flex-column flex-center"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                            <!--begin::Illustration-->
                                            <img src="{{asset('assets/media/illustrations/sketchy-1/4.png')}}" alt=""
                                                 class="mw-100 mh-150px mb-7"/>
                                            <!--end::Illustration-->
                                            <!--begin::Label-->
                                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                                            <!--end::Label-->
                                        </button>
                                        <!--begin::Button-->
                                    </div>
                                    <!--begin::Card body-->
                                </div>
                                <!--begin::Card-->
                            </div>
                        @endif
                    <!--begin::Add Role card-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->

    <!--begin::Modals-->
    @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_ROLES->value))
        <!--begin::Modal - Add role-->
        @include('admin.roles.modals.create')
        <!--end::Modal - Add role-->
    @endif
    @if(auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_ROLES->value))
        <!--begin::Modal - Update role-->
        @include('admin.roles.modals.edit')
        <!--end::Modal - Update role-->
    @endif
    <!--end::Modals-->

@endsection
@section('scripts')
    @if(auth()->user()->hasPermissionTo(PermissionEnum::CREATE_ROLES->value))
        <script src="{{asset('assets/js/custom/apps/user-management/roles/list/add.js')}}"></script>
    @endif
    @if(auth()->user()->hasPermissionTo(PermissionEnum::UPDATE_ROLES->value))
        <!-- Fetch data to the Edit Modal role -->
        <script>
            $(document).on('click', '#editRoleButton', function (e) {
                e.preventDefault();

                let roleId = $(this).data('role-id');

                // Send AJAX request to fetch role data
                $.ajax({
                    url: '/roles/' + roleId + '/edit', // Make the request to the backend to fetch the role and its permissions
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {

                            document.querySelector('#role_name').value = response.role.name;
                            document.querySelector('#role_id').value = response.role.id;

                            // Clear previous permissions
                            $('#permissions_table_body').empty();
                            var selectAllRow = `<tr>
                                        <td class="text-gray-800">Administrator Access
                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allows a full access to the system"></i></td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
                                                <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>`;
                            $('#permissions_table_body').append(selectAllRow);

                            // Loop through the categories of permissions
                            var formattedPermissions = response.formatted_permissions; // The formatted permissions are an object
                            Object.keys(formattedPermissions).forEach(function(category) {
                                var row = `
                                        <tr>
                                            <td class="text-gray-800">${category} Management</td>
                                            <td>
                                                <div class="d-flex flex-nowrap gap-3">`;

                                // Loop through each permission under the category
                                formattedPermissions[category].forEach(function(permission) {
                                    // Check if the permission is assigned
                                    var isChecked = response.assigned_permissions.includes(permission.id) ? 'checked' : '';

                                    row += `
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="${permission.id}" ${isChecked} />
                                        <span class="form-check-label">${permission.name}</span>
                                    </label>
                                `;
                                });

                                row += `
                                        </div>
                                    </td>
                                </tr>
                            `;
                                $('#permissions_table_body').append(row);
                            });

                            // Show the modal
                            $('#kt_modal_update_role').modal('show');

                        } else {
                            Swal.fire({
                                text: "Failed to load role data!",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            text: "An error occurred while fetching data!",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });

            });
        </script>
        <script src="{{asset('assets/js/custom/apps/user-management/roles/list/update-role.js')}}"></script>
    @endif
    @if(auth()->user()->hasPermissionTo(PermissionEnum::DELETE_ROLES->value))
        <!-- Handle Delete Role -->
        <script>
            $(document).on('click', '.deleteRoleButton', function (e) {
                e.preventDefault();

                let roleId = $(this).data('role-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Deleting this role might affect existing users. Do you want to continue?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Soft Delete",
                    cancelButtonText: "No, cancel",
                    showDenyButton: true,
                    denyButtonText: "Force Delete",
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-secondary",
                        denyButton: "btn btn-warning"
                    }
                }).then((result) => {
                    if (result.isConfirmed || result.isDenied) {
                        let forceDelete = result.isDenied ? 1 : 0;

                        // Send AJAX request to delete role
                        $.ajax({
                            url: '/roles/' + roleId,
                            method: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                force: forceDelete
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        text: "Role deleted successfully!",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        text: response.message,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    text: xhr.responseJSON?.message || "An error occurred while deleting!",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endif
@endsection
