@php use App\Enums\PermissionEnum; @endphp
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion {{setMenuOpenClass(['admin.dashboard'])}}">
                    <span class="menu-link {{setActiveClass('admin.dashboard')}}" href="{{route('admin.dashboard')}}">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">{{ __('admin.dashboard.title') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.dashboard.general_indicators') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.dashboard.detailed_analysis') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.dashboard.consultants_reports') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.dashboard.schools_reports') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.dashboard.students_reports') }}</span>
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
        <span class="menu-title">{{ __('admin.users.title') }}</span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->
<div class="menu-item {{setMenuOpenClass(['admin.schools.index'])}}">
    <!--begin:Menu link-->
    <a class="menu-link {{setActiveClass('admin.schools.index')}}"
       href="{{route('admin.schools.index')}}">
        <span class="menu-icon"><i class="fa-solid fa-school"></i></span>
        <span class="menu-title">{{ __('admin.schools.title') }}</span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">{{ __('admin.consultants.title') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.display') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.create') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.edit') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.delete') }}</span>
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
        <span class="menu-title">{{ __('admin.students.title') }}</span>
    </a>
    <!--end:Menu link-->
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">{{ __('admin.trips.title') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.display') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.create') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.edit') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.delete') }}</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">{{ __('admin.workshops.title') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.display') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.create') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.edit') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.delete') }}</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">{{ __('admin.pages.title') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.display') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.create') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.edit') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.delete') }}</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">{{ __('admin.programs.title') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.display') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                <span class="menu-title">{{ __('admin.actions.create') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.edit') }}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.actions.delete') }}</span>
            </a>
        </div>
    </div>
</div>
<!--end:Menu item-->
<div data-kt-menu-trigger="click"
     class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"><i class="bi bi-grid"></i></span>
                        <span class="menu-title">{{ __('admin.settings.title') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                <span class="menu-title">{{ __('admin.settings.general') }}</span>
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
                    <span class="menu-title">{{ __('admin.settings.roles') }}</span>
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
                    <span class="menu-title">{{ __('admin.settings.permissions') }}</span>
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
                        <span class="menu-title">{{ __('admin.exams.title') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item {{setMenuOpenClass(['admin.QuestionBank.index'])}}">
            <!--begin:Menu link-->
            <a class="menu-link {{setActiveClass('admin.QuestionBank.index')}}"
               href="{{route('admin.QuestionBank.index')}}">
                <span class="menu-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                <span class="menu-title">{{ __('admin.questionBank.title') }}</span>
            </a>
            <!--end:Menu link-->
        </div>

        <div class="menu-item {{setMenuOpenClass(['admin.valueQuestion.index'])}}">
            <!--begin:Menu link-->
            <a class="menu-link {{setActiveClass('admin.valueQuestion.index')}}"
               href="{{route('admin.valueQuestion.index')}}">
                <span class="menu-icon">  <i class="fa-solid fa-layer-group me-2"></i></span>
                <span class="menu-title">{{ __('valueQuestion.title-sidebar') }}</span>
            </a>
            <!--end:Menu link-->
        </div>
    </div>
</div>
