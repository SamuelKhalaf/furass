<div class="app-navbar-item ms-1 ms-md-3">
    <!--begin::Menu-wrapper-->
    <div class="position-relative btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
         data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
         data-kt-menu-attach="parent"
         data-kt-menu-placement="bottom-end">
        <span class="svg-icon svg-icon-2">
            <i class="fa-solid fa-bell fs-2"></i>
        </span>
        <span style="top:8px" class="position-absolute start-75 translate-middle badge rounded-pill bg-danger">
            5
            <span class="visually-hidden">unread notifications</span>
        </span>
    </div>

    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
        <!--begin::Heading-->
        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);">
            <!--begin::Title-->
            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
                Notifications
                <span class="fs-8 opacity-75 ps-3">24 unread</span>
            </h3>
            <!--end::Title-->

            <!--begin::Tabs-->
            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_notifications_alerts">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_notifications_updates">Unread</a>
                </li>
            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Heading-->

        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab panel-->
            <div class="tab-pane fade show active" id="kt_notifications_alerts" role="tabpanel">
                <!--begin::Items-->
                <div class="scroll-y mh-325px my-5 px-8">
                    <!-- Unread Notification -->
                    <div class="d-flex flex-stack py-4 bg-light-primary bg-opacity-10 rounded-3 px-4">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="me-4">
                                <i class="fas fa-info-circle fa-2x text-primary"></i>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Content-->
                            <div class="mb-0 me-2">
                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">New message received</a>
                                <div class="text-gray-600 fs-7">You have 5 new messages from the customer support team</div>
                                <div class="d-flex mt-2">
                  <span class="badge badge-light-primary fs-8 fw-bold me-2">
                    <i class="fas fa-paperclip me-1"></i> Attachment
                  </span>
                                    <span class="text-gray-500 fs-8">2 mins ago</span>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-column align-items-center">
                            <button class="btn btn-icon btn-sm btn-active-color-primary mb-1">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-icon btn-sm btn-active-color-primary">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Item-->

                    <!-- Read Notification -->
                    <div class="d-flex flex-stack py-4">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="me-4">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Content-->
                            <div class="mb-0 me-2">
                                <a href="#" class="fs-6 text-gray-600 text-hover-primary fw-bold">Task completed</a>
                                <div class="text-gray-500 fs-7">Your project "Dashboard UI" has been approved</div>
                                <div class="text-gray-500 fs-8 mt-1">1 hour ago</div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-column align-items-center">
                            <button class="btn btn-icon btn-sm btn-active-color-primary">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Item-->

                    <!-- Warning Notification -->
                    <div class="d-flex flex-stack py-4 bg-light-warning bg-opacity-10 rounded-3 px-4">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="me-4">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Content-->
                            <div class="mb-0 me-2">
                                <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">System warning</a>
                                <div class="text-gray-600 fs-7">Your storage is almost full (85% used)</div>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="progress w-100px h-5px me-3">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"></div>
                                    </div>
                                    <span class="text-gray-500 fs-8">30 mins ago</span>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-column align-items-center">
                            <button class="btn btn-icon btn-sm btn-active-color-primary mb-1">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-icon btn-sm btn-active-color-primary">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Item-->

                    <!-- Info Notification with Link -->
                    <div class="d-flex flex-stack py-4">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="me-4">
                                <i class="fas fa-link fa-2x text-info"></i>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Content-->
                            <div class="mb-0 me-2">
                                <a href="#" class="fs-6 text-gray-600 text-hover-primary fw-bold">New link shared</a>
                                <div class="text-gray-500 fs-7">Team member shared a document with you</div>
                                <div class="d-flex mt-2">
                  <span class="badge badge-light-info fs-8 fw-bold me-2">
                    <i class="fas fa-link me-1"></i> Reference Link
                  </span>
                                    <span class="text-gray-500 fs-8">4 hours ago</span>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-column align-items-center">
                            <button class="btn btn-icon btn-sm btn-active-color-primary">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Item-->

                    <!-- Success Notification -->
                    <div class="d-flex flex-stack py-4">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="me-4">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Content-->
                            <div class="mb-0 me-2">
                                <a href="#" class="fs-6 text-gray-600 text-hover-primary fw-bold">Payment received</a>
                                <div class="text-gray-500 fs-7">$2,500 USD payment received from client</div>
                                <div class="text-gray-500 fs-8 mt-1">1 day ago</div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-column align-items-center">
                            <button class="btn btn-icon btn-sm btn-active-color-primary">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Items-->

                <!--begin::View more-->
                <div class="py-3 text-center border-top">
                    <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">
                        View All
                        <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
                <!--end::View more-->
            </div>
            <!--end::Tab panel-->

            <!--begin::Tab panel-->
            <div class="tab-pane fade" id="kt_notifications_updates" role="tabpanel">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column px-9">
                    <!--begin::Section-->
                    <div class="pt-10 pb-0">
                        <!--begin::Title-->
                        <h3 class="text-dark text-center fw-bold">No New Notifications</h3>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="text-center text-gray-600 fw-semibold pt-1">You're all caught up! Check back later for updates</div>
                        <!--end::Text-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Illustration-->
                    <div class="text-center px-4">
                        <i class="fas fa-bell-slash fa-4x text-gray-400 mb-5 mt-5"></i>
                    </div>
                    <!--end::Illustration-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Menu-->
</div>
