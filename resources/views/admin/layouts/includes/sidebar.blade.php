@use(App\Enums\PermissionEnum;use App\Enums\RoleEnum;use App\Models\Student)
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
     data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo pe-6" id="kt_app_sidebar_logo" style=" border-bottom: 1px solid #393945">
        <!--begin::Logo image-->
        <a href="#">
            <img alt="Logo" src="{{asset('assets/media/logos/furass.png')}}"
                 class="app-sidebar-logo-default"
                 {{--                 @if( auth()->user()?->hasRole(RoleEnum::STUDENT->value) )--}}
                 style="padding-left: 34px;width: 200px;height: 112px;"
                {{--                 @else--}}
                {{--                    style="width: 230px; height: 150px;"--}}
                {{--                 @endif--}}
            />
            <img alt="Logo" src="{{asset('assets/media/logos/furass.png')}}"
                 class="app-sidebar-logo-minimize" style="width: 60px;height: 98px;"/>
        </a>
        <!--end::Logo image-->
        @if( false )
            <!--begin::Sidebar toggle-->
            <div id="kt_app_sidebar_toggle"
                 class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                 data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                 data-kt-toggle-name="app-sidebar-minimize">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
                <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5"
                          d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                          fill="currentColor"/>
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor"/>
                </svg>
            </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Sidebar toggle-->
        @endif
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
             data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
             data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
             data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                 data-kt-menu="true" data-kt-menu-expand="false">
                <!--begin:Menu item-->
                @if( !auth()->user()->hasRole(RoleEnum::STUDENT->value) )
                    <div class="menu-item {{setMenuOpenClass(['admin.dashboard'])}}">
                        <a class="menu-link {{setActiveClass('admin.dashboard')}}"
                           href="{{route('admin.dashboard')}}">
                            <span class="menu-icon"><i class="fa-solid fa-gauge-high"></i></span>
                            <span class="menu-title">{{ __('admin.dashboard.title') }}</span>
                        </a>
                    </div>
                @endif

                <!--start:Student Links -->
                @if( auth()->user()->hasRole(RoleEnum::STUDENT->value) )
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.profile.show'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.profile.show')}}"
                           href="{{route('admin.profile.show')}}">
                            <span class="menu-icon"><i class="fa-solid fa-user"></i></span>
                            <span class="menu-title">{{ __('admin.profile.title') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.student.achievements'])}}">
                        <a class="menu-link {{setActiveClass('admin.student.achievements')}}"
                           href="{{route('admin.student.achievements')}}">
                            <span class="menu-icon"><i class="fa-solid fa-award"></i></span>
                            <span class="menu-title">{{ __('admin.achievements.title') }}</span>
                        </a>
                    </div>
                    <!--end:Menu item-->

                    <!--begin:Menu item-->
                    <div
                        class="menu-item {{setMenuOpenClass(['admin.student.enrollments.index'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link
                            {{setActiveClass(['admin.student.enrollments.index'])}}"
                           href="{{route('admin.student.enrollments.index')}}">
                            <span class="menu-icon"><i class="fa-solid fa-briefcase"></i></span>
                            <span class="menu-title">{{ __('admin.programs.my_programs') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    @php
                        $user = auth()->user();

                       $student = Student::where('user_id', $user->id)
                           ->with(['enrollments.program'])
                           ->first();

                       $enrollments = $student ? $student->enrollments : collect();
                    @endphp
                    <!--begin:Menu items - Enrollments -->
                    @foreach($enrollments as $enrollment)
                        @php
                            $program = $enrollment->program;
                        @endphp
                        @if($program)
                            <div class="menu-item {{ setMenuOpenClass([['admin.student.enrollments.show' => ['program' => $enrollment->program_id]]]) }}">
                                <a class="menu-link {{ setActiveClass([['admin.student.enrollments.show' => ['program' => $enrollment->program_id]]]) }}"
                                   href="{{ route('admin.student.enrollments.show', $enrollment->program_id) }}">
                                    <span class="menu-icon"><i class="fa-solid fa-graduation-cap"></i></span>
                                    <span class="menu-title">{{ app()->getLocale() == 'ar' ? $program->title_ar : $program->title_en }}</span>
                                </a>
                            </div>
                        @endif
                    @endforeach
                    <!--end:Menu items - Enrollments -->
                @endif
                <!--end:Student Links -->

                @if(auth()->user()->hasAnyPermission(PermissionEnum::userPermissions()))
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
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::schoolPermissions()))
                    <!--begin:Menu item-->
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
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::consultantPermissions()))
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.consultants.index'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.consultants.index')}}"
                           href="{{route('admin.consultants.index')}}">
                            <span class="menu-icon"><i class="fa-solid fa-headset"></i></span>
                            <span class="menu-title">{{ __('admin.consultants.title') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::studentPermissions()))
                    <!--begin:Menu item-->
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
                @endif

                @if( auth()->user()->hasAnyPermission(PermissionEnum::programPermissions()) ||
                     auth()->user()->hasRole(RoleEnum::SCHOOL->value) ||
                    auth()->user()->hasAnyPermission(PermissionEnum::pathPointPermissions())
                )
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion
                         {{setMenuOpenClass([
                            'admin.programs.index',
                            'admin.programs.enroll',
                            'admin.path_points.index'
                        ])}}">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="fa-solid fa-route"></i></span>
                            <span class="menu-title">{{ __('admin.programs.title') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if(auth()->user()->hasAnyPermission(PermissionEnum::programPermissions()))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{setActiveClass('admin.programs.index')}}"
                                       href="{{route('admin.programs.index')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('admin.programs.show') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif
                            @if(auth()->user()->hasRole(RoleEnum::SCHOOL->value))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{setActiveClass('admin.programs.enroll')}}"
                                       href="{{route('admin.programs.enroll')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('admin.programs.enroll') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif
                            @if( auth()->user()->hasAnyPermission(PermissionEnum::pathPointPermissions()) )
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{setActiveClass('admin.path_points.index')}}"
                                       href="{{route('admin.path_points.index')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('admin.path_points.title') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif

                        </div>
                    </div>
                @endif

                <!--start:In-Active School Students-->
                @if( auth()->user()->hasRole(RoleEnum::SCHOOL->value) )
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.school.inactive-students'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.school.inactive-students')}}"
                           href="{{route('admin.school.inactive-students')}}">
                            <span class="menu-icon"><i class="fa-solid fa-users"></i></span>
                            <span class="menu-title">{{ __('dashboard.inactive_students') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.school.students.program-status'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.school.students.program-status')}}"
                           href="{{route('admin.school.students.program-status')}}">
                            <span class="menu-icon"><i class="fa-solid fa-users"></i></span>
                            <span class="menu-title">{{ __('schools.student_program_status') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif
                <!--end:In-Active School Students-->

                <!--start:Consultant and Sub-admin Students-->
                @if(auth()->user()->hasRole([RoleEnum::CONSULTANT->value, RoleEnum::SUB_ADMIN->value]))
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{ setMenuOpenClass(
                            [
                                'admin.students.evaluation.result',
                                'admin.consultant.students.index',
                                'admin.consultant.consultation.schedule.form',
                                'admin.sub-admin.trips.index',
                                'admin.sub-admin.trip.students',
                                'admin.sub-admin.trip.attendance',
                                'admin.sub-admin.workshops.index',
                                'admin.sub-admin.workshop.students',
                                'admin.sub-admin.workshop.attendance'
                            ]) }}">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="fa-solid fa-users"></i></span>
                            <span class="menu-title">{{ __('admin.students.title') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if(auth()->user()->hasRole([RoleEnum::CONSULTANT->value]))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ setActiveClass('admin.students.evaluation.result') }}"
                                       href="{{ route('admin.students.evaluation.result') }}">
                                        <span class="menu-icon"><i class="fa-solid fa-chart-line me-2"></i></span>
                                        <span class="menu-title">{{ __('admin.evaluation-result.title') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ setActiveClass('admin.consultant.students.index') }}"
                                       href="{{route('admin.consultant.students.index')}}">
                                        <span class="menu-icon"><i class="fa-solid fa-microphone-lines me-2"></i></span>
                                        <span class="menu-title">{{ __('admin.consultations.title') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif
                            @if(auth()->user()->hasRole([RoleEnum::SUB_ADMIN->value]))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ setActiveClass(['admin.sub-admin.trips.index','admin.sub-admin.trip.students','admin.sub-admin.trip.attendance']) }}"
                                       href="{{route('admin.sub-admin.trips.index')}}">
                                        <span class="menu-icon"><i class="fa-solid fa-map-location-dot me-2"></i></span>
                                        <span class="menu-title">{{ __('admin.trips.title') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ setActiveClass(['admin.sub-admin.workshops.index','admin.sub-admin.workshop.students','admin.sub-admin.workshop.attendance']) }}"
                                       href="{{route('admin.sub-admin.workshops.index')}}">
                                        <span class="menu-icon"><i class="fa-solid fa-map-location-dot me-2"></i></span>
                                        <span class="menu-title">{{ __('admin.workshops.title') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif

                        </div>
                    </div>
                @endif
                <!--end:Consultant and Sub-admin Students-->

                <!--start:Consultant Calendar -->
                @if( auth()->user()->hasRole(RoleEnum::CONSULTANT->value) )
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.consultant.calendar'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.consultant.calendar')}}"
                           href="{{route('admin.consultant.calendar')}}">
                            <span class="menu-icon"><i class="fa-solid fa-calendar"></i></span>
                            <span class="menu-title">{{ __('admin.calendar.title') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif
                <!--end:Consultant Calendar -->

                @if(auth()->user()->hasAnyPermission(PermissionEnum::tripPermissions()))
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.trips.index'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.trips.index')}}"
                           href="{{route('admin.trips.index')}}">
                            <span class="menu-icon"><i class="fa-solid fa-map-location-dot"></i></span>
                            <span class="menu-title">{{ __('admin.trips.title') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::workshopPermissions()))
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.workshops.index'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.workshops.index')}}"
                           href="{{route('admin.workshops.index')}}">
                            <span class="menu-icon"><i class="fa-solid fa-house-flag"></i></span>
                            <span class="menu-title">{{ __('admin.workshops.title') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::eventPermissions()))
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.calendar.index'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.calendar.index')}}"
                           href="{{route('admin.calendar.index')}}">
                            <span class="menu-icon"><i class="fa-solid fa-calendar-days"></i></span>
                            <span class="menu-title">{{ __('admin.calendar.title') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::newsPermissions()))
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.news.index'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.news.index')}}"
                           href="{{route('admin.news.index')}}">
                            <span class="menu-icon"><i class="fa-regular fa-newspaper"></i></span>
                            <span class="menu-title">{{ __('admin.news.title') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if(auth()->user()->hasPermissionTo(PermissionEnum::SEND_NOTIFICATIONS))
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.notifications.index'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.notifications.index')}}"
                           href="{{route('admin.notifications.index')}}">
                            <span class="menu-icon"><i class="fa-regular fa-bell"></i></span>
                            <span class="menu-title">{{ __('admin.notifications.title') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::ExamsPermissions()))
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{setMenuOpenClass(['admin.QuestionBank.index','admin.valueQuestion.index' , 'admin.question.index'])}}">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                            <span class="menu-title">{{ __('admin.exams.title') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item {{setMenuOpenClass(['admin.QuestionBank.index' ])}}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{setActiveClass('admin.QuestionBank.index')}}"
                                   href="{{route('admin.QuestionBank.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('admin.questionBank.title') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                            <div class="menu-item {{setMenuOpenClass(['admin.valueQuestion.index'])}}">
                                <!--begin:Menu link-->
                                <a class="menu-link {{setActiveClass('admin.valueQuestion.index')}}"
                                   href="{{route('admin.valueQuestion.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('valueQuestion.title-sidebar') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                    </div>
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::LIST_PAGES))
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{setMenuOpenClass(['admin.roles.index','admin.roles.show','admin.permissions.index'])}}">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                            <span class="menu-title">{{ __('admin.settings.pages') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if(auth()->user()->hasAnyPermission(PermissionEnum::permissionPermissions()))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{setActiveClass('admin.cke_pages.create')}}"
                                       href="{{route('admin.pages.index')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('admin.cke_pages.create') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->

                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{setActiveClass('admin.cke-about.index')}}"
                                       href="{{route('admin.cke.about.index')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('admin.cke_pages.about') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif
                        </div>
                    </div>
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::permissionPermissions()) || auth()->user()->hasAnyPermission(PermissionEnum::rolePermissions()))
                    <div data-kt-menu-trigger="click"
                         class="menu-item menu-accordion {{setMenuOpenClass(['admin.roles.index','admin.roles.show','admin.permissions.index' , 'admin.setting.index'])}}">
                        <span class="menu-link">
                            <span class="menu-icon"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                            <span class="menu-title">{{ __('admin.settings.title') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @if(auth()->user()->hasAnyPermission(PermissionEnum::rolePermissions()))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{setActiveClass(['admin.roles.index','admin.roles.show'])}}"
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
                            @if(auth()->user()->hasAnyPermission(PermissionEnum::permissionPermissions()))
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{setActiveClass('admin.setting.index')}}"
                                       href="{{route('admin.setting.index')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                        <span class="menu-title">{{ __('admin.setting.name') }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif
                        </div>
                    </div>
                @endif

                @if(auth()->user()->hasAnyPermission(PermissionEnum::MANAGE_QUESTIONS))
                    <!--begin:Menu item-->
                    <div class="menu-item {{setMenuOpenClass(['admin.manage.question'])}}">
                        <!--begin:Menu link-->
                        <a class="menu-link {{setActiveClass('admin.manage.question')}}"
                           href="{{route('admin.manage.question')}}">
                            <span class="menu-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                            <span class="menu-title">{{ __('questions.consultant.manage_exams') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif
            </div>
        </div>
    </div>
</div>
