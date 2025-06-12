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
        <span class="menu-icon"><i class="fa-solid fa-user"></i></span>
        <span class="menu-title">Users</span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->
<div class="menu-item {{setMenuOpenClass(['admin.schools.index'])}}">
    <!--begin:Menu link-->
    <a class="menu-link {{setActiveClass('admin.schools.index')}}"
       href="{{route('admin.schools.index')}}">
        <span class="menu-icon"><i class="fa-solid fa-school"></i></span>
        <span class="menu-title">Manage Schools</span>
    </a>
    <!--end:Menu link-->
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
<div class="menu-item {{setMenuOpenClass(['admin.students.index'])}}">
    <!--begin:Menu link-->
    <a class="menu-link {{setActiveClass('admin.students.index')}}"
       href="{{route('admin.students.index')}}">
        <span class="menu-icon"><i class="fa-solid fa-users"></i></span>
        <span class="menu-title">Manage Students</span>
    </a>
    <!--end:Menu link-->
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
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">Manage Exams</span>
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
    </div>
</div>
<!--end:Menu item-->
