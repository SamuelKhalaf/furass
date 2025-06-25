<!-- Notification Dropdown Structure -->
<div class="app-navbar-item ms-1 ms-md-3">
    <!--begin::Menu wrapper-->
    <div class="position-relative btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
         data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
         data-kt-menu-attach="parent"
         data-kt-menu-placement="bottom-end"
         id="notification-trigger">
        <span class="svg-icon svg-icon-2">
            <i class="fa-solid fa-bell fs-2"></i>
        </span>
        <span style="top:8px" class="position-absolute start-75 translate-middle badge rounded-pill bg-danger notification-badge d-none">
            0
            <span class="visually-hidden">unread notifications</span>
        </span>
    </div>

    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="notification-dropdown">
        <!--begin::Heading-->
        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);">
            <!--begin::Title-->
            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
                Notifications
                <span class="fs-8 opacity-75 ps-3 notification-count">0 unread</span>
            </h3>
            <!--end::Title-->

            <!--begin::Tabs-->
            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                       data-bs-toggle="tab"
                       href="#kt_notifications_all">
                        All
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
                       data-bs-toggle="tab"
                       href="#kt_notifications_unread">
                        Unread
                    </a>
                </li>
            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Heading-->

        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab panel - All Notifications-->
            <div class="tab-pane fade show active" id="kt_notifications_all" role="tabpanel">
                <!--begin::Items-->
                <div class="scroll-y mh-325px my-5 px-8 notification-container">
                    <!-- Notifications will be loaded here dynamically -->
                    <div class="text-center py-10">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Loading notifications...</div>
                    </div>
                </div>
                <!--end::Items-->

                <!--begin::View more-->
                <div class="py-3 text-center border-top">
                    <a href="/notifications" class="btn btn-color-gray-600 btn-active-color-primary">
                        View All Notifications
                        <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
                <!--end::View more-->
            </div>
            <!--end::Tab panel-->

            <!--begin::Tab panel - Unread Notifications-->
            <div class="tab-pane fade" id="kt_notifications_unread" role="tabpanel">
                <!-- Content will be loaded dynamically -->
                <div class="d-flex flex-column px-9">
                    <div class="pt-10 pb-0">
                        <h3 class="text-dark text-center fw-bold">Loading...</h3>
                        <div class="text-center text-gray-600 fw-semibold pt-1">Checking for new notifications</div>
                    </div>
                    <div class="text-center px-4">
                        <div class="spinner-border text-primary mb-5 mt-5" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Menu-->
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            class NotificationSystem {
                constructor() {
                    this.notificationDropdown = $('#notification-dropdown');
                    this.notificationBadge = $('.notification-badge');
                    this.allTab = $('#kt_notifications_all');
                    this.unreadTab = $('#kt_notifications_unread');
                    this.notificationContainer = $('.notification-container');
                    this.notificationCount = $('.notification-count');

                    this.hasLoaded = false;
                    this.init();
                }

                init() {
                    this.loadNotifications();

                    // Load notifications when dropdown is opened
                    // $('#notification-trigger').on('click', () => this.loadNotifications());

                    // Handle mark as read actions
                    this.notificationDropdown.on('click', '.mark-as-read', (e) => {
                        const notificationId = $(e.currentTarget).data('id');
                        this.markAsRead(notificationId);
                    });

                    // Handle mark all as read
                    this.notificationDropdown.on('click', '.mark-all-read', () => {
                        this.markAllAsRead();
                    });
                }

                loadNotifications() {
                    $.ajax({
                        url: '/notifications/get',
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        beforeSend: () => {
                            this.notificationContainer.html(`
                            <div class="text-center py-10">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mt-2">Loading notifications...</div>
                            </div>
                        `);
                        },
                        success: (data) => {
                            this.hasLoaded = true;
                            this.updateNotificationBadge(data.unread_count);
                            this.renderNotifications(data.notifications);
                        },
                        error: (xhr, status, error) => {
                            console.error('Notification error:', error);
                            this.notificationContainer.html(`
                            <div class="text-center py-10">
                                <i class="fas fa-exclamation-triangle text-danger fs-2x mb-3"></i>
                                <div class="text-danger">Failed to load notifications</div>
                            </div>
                        `);
                        }
                    });
                }

                updateNotificationBadge(count) {
                    this.notificationCount.text(count + ' unread');

                    if (count > 0) {
                        this.notificationBadge.text(count).removeClass('d-none');
                    } else {
                        this.notificationBadge.addClass('d-none');
                    }
                }

                renderNotifications(notifications) {
                    // Clear existing notifications
                    this.notificationContainer.empty();

                    const unreadNotifications = notifications.filter(n => !n.is_read);

                    // Render all notifications
                    if (!notifications || notifications.length === 0) {
                        this.notificationContainer.html(`
                            <div class="text-center py-10">
                                <i class="fas fa-info-circle text-muted fs-2x mb-3"></i>
                                <div class="text-gray-600">You have no notifications yet.</div>
                            </div>
                        `);
                    }else {
                        notifications.forEach(notification => {
                            this.notificationContainer.append(this.createNotificationElement(notification));
                        });
                    }

                    // Update unread tab
                    if (unreadNotifications.length > 0) {
                        this.unreadTab.html(`
                        <div class="scroll-y mh-325px my-5 px-8">
                            ${unreadNotifications.map(n =>
                            this.createNotificationElement(n)[0].outerHTML
                        ).join('')}
                        </div>
                        <div class="py-3 text-center border-top">
                            <button class="btn btn-color-gray-600 btn-active-color-primary mark-all-read">
                                Mark All as Read
                                <i class="fas fa-check ms-1"></i>
                            </button>
                        </div>
                    `);
                    } else {
                        this.unreadTab.html(`
                        <div class="d-flex flex-column px-9">
                            <div class="pt-10 pb-0">
                                <h3 class="text-dark text-center fw-bold">No New Notifications</h3>
                                <div class="text-center text-gray-600 fw-semibold pt-1">You're all caught up! Check back later for updates</div>
                            </div>
                            <div class="text-center px-4">
                                <i class="fas fa-bell-slash fa-4x text-gray-400 mb-5 mt-5"></i>
                            </div>
                        </div>
                    `);
                    }
                }

                createNotificationElement(notification) {
                    const element = $(`
                    <div class="d-flex flex-stack p-4 mb-5 notification-item ${!notification.is_read ? 'notification-unread bg-light-primary bg-opacity-10 rounded-3 px-4' : ''}">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <i class="fas ${this.getNotificationIcon(notification)} fa-2x ${this.getNotificationIconColor(notification)}"></i>
                            </div>
                            <div class="mb-0 me-2">
                                <a href="#" class="fs-6 ${notification.is_read ? 'text-gray-600' : 'text-gray-800'} text-hover-primary fw-bold">${notification.title}</a>
                                <div class="${notification.is_read ? 'text-gray-500' : 'text-gray-600'} fs-7">${notification.body}</div>
                                ${this.getNotificationMeta(notification)}
                                <div class="${notification.is_read ? 'text-gray-500' : 'text-gray-600'} fs-8 mt-1">${notification.created_at_human}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            ${!notification.is_read ? `
                                <button class="btn btn-icon btn-sm btn-active-color-primary mb-1 mark-as-read" data-id="${notification.id}">
                                    <i class="fas fa-check"></i>
                                </button>
                            ` : ''}
                            <button class="btn btn-icon btn-sm btn-active-color-primary">
                                <i class="fas fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                    </div>
                `);
                    return element;
                }

                getNotificationIcon(notification) {
                    if (notification.meta?.type === 'warning') return 'fa-exclamation-triangle';
                    if (notification.meta?.type === 'success') return 'fa-check-circle';
                    if (notification.meta?.type === 'info') return 'fa-info-circle';
                    return 'fa-bell';
                }

                getNotificationIconColor(notification) {
                    if (notification.meta?.type === 'warning') return 'text-warning';
                    if (notification.meta?.type === 'success') return 'text-success';
                    if (notification.meta?.type === 'info') return 'text-info';
                    return 'text-primary';
                }

                getNotificationMeta(notification) {
                    if (!notification.meta) return '';

                    let metaHtml = '';

                    if (Array.isArray(notification.meta.attachments) && notification.meta.attachments.length > 0) {
                        metaHtml += `<span class="badge badge-light-primary fs-8 fw-bold me-2">
                        <i class="fas fa-paperclip me-1"></i> Attachment
                    </span>`;
                    }

                    if (notification.meta.link) {
                        metaHtml += `<span class="badge badge-light-info fs-8 fw-bold me-2">
                        <i class="fas fa-link me-1"></i> Reference Link
                    </span>`;
                    }

                    return metaHtml ? `<div class="d-flex mt-2">${metaHtml}</div>` : '';
                }

                markAsRead(notificationId) {
                    $.ajax({
                        url: `/notifications/${notificationId}/read`,
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: () => {
                            this.loadNotifications();
                        },
                        error: (xhr, status, error) => {
                            console.error('Error marking as read:', error);
                        }
                    });
                }

                markAllAsRead() {
                    $.ajax({
                        url: '/notifications/read-all',
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: () => {
                            this.loadNotifications();
                        },
                        error: (xhr, status, error) => {
                            console.error('Error marking all as read:', error);
                        }
                    });
                }
            }

            // Initialize the notification system
            new NotificationSystem();
        });
    </script>
@endpush
