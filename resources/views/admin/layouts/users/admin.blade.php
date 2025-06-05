@php use App\Enums\PermissionEnum; @endphp
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion {{setMenuOpenClass(['admin.dashboard'])}}">
                    <span class="menu-link {{setActiveClass('admin.dashboard')}}" href="{{route('admin.dashboard')}}">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Admin Dashboard</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">General indicators</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Detailed analysis</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Consultants Reports</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Schools Reports</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Students Reports</span>
            </a>
        </div>
    </div>
</div>
<!--begin:Menu item-->
<div class="menu-item {{setMenuOpenClass(['admin.users.index'])}}">
    <!--begin:Menu link-->
    <a class="menu-link {{setActiveClass('admin.users.index')}}"
       href="{{route('admin.users.index')}}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z"
                                        fill="currentColor"/>
                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
        <span class="menu-title">Users</span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Manage Schools</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Display</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Create</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Edit</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Delete</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Manage Consultants</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Display</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Create</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Edit</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Delete</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Manage Students</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Display</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Create</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Edit</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Delete</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Manage Trips</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Display</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Create</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Edit</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Delete</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Manage Workshops</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Display</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Create</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Edit</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Delete</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Manage Pages</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Display</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Create</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Edit</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Delete</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Manage Programs</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Display</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">Create</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Edit</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">Delete</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">System Setting</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">General Setting</span>
            </a>
        </div>
        @if(auth()->user()->hasAnyPermission(PermissionEnum::rolePermissions()))
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{setActiveClass('admin.roles.index')}}"
                   href="{{route('admin.roles.index')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                    <span class="menu-title">Roles</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
        @endif
        @if(auth()->user()->hasAnyPermission(PermissionEnum::permissionPermissions()))
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{setActiveClass('admin.permissions.index')}}"
                   href="{{route('admin.permissions.index')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                    <span class="menu-title">Permissions</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
        @endif
    </div>
</div>
<!--end:Menu item-->
