@extends('admin.layouts.master')
@section('title', __('notifications.all_notifications'))

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('notifications.all_notifications') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">{{ __('dashboard.title') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('notifications.notifications') }}</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">{{ __('notifications.all_notifications') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <div class="card-body p-0">
                    <div class="pt-5 pb-10 px-5">
                        <h2 class="fs-2x fw-bold mb-5 text-center">{{ __('notifications.all_notifications') }}</h2>
                        @if($notifications->count() === 0)
                            <div class="text-center py-10">
                                <i class="fas fa-info-circle text-muted fs-2x mb-3"></i>
                                <div class="text-gray-600">{{ __('notifications.no_notifications') }}</div>
                            </div>
                        @else
                            <div class="notification-list">
                                @foreach($notifications as $notification)
                                    <div class="card shadow-sm mb-5 bg-hover-light notification-item {{ !$notification->is_read ? 'notification-unread border-primary' : '' }}">
                                        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                            <div class="d-flex align-items-center mb-3 mb-md-0">
                                                <div class="me-4">
                                                    <i class="fas
                                                        @if(($notification->meta['type'] ?? '') === 'warning') fa-bell text-primary
                                                        @elseif(($notification->meta['type'] ?? '') === 'success') fa-check-circle text-success
                                                        @elseif(($notification->meta['type'] ?? '') === 'info') fa-info-circle text-info
                                                        @else fa-bell text-primary
                                                        @endif
                                                    fa-2x"></i>
                                                </div>
                                                <div>
                                                    <div class="fs-5 fw-bold mb-1 {{ $notification->is_read ? 'text-gray-600' : 'text-dark' }}">{{ $notification->title }}</div>
                                                    <div class="fs-7 text-muted mb-2">{{ Str::limit($notification->body, 100) }}</div>
                                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                                        @if(isset($notification->meta['attachments']) && is_array($notification->meta['attachments']) && count($notification->meta['attachments']) > 0)
                                                            <span class="badge badge-light-primary fs-8 fw-bold">
                                                                <i class="fas fa-paperclip me-1"></i> {{ __('notifications.attachment') }}
                                                            </span>
                                                        @endif
                                                        @if(!empty($notification->meta['link']))
                                                            <span class="badge badge-light-info fs-8 fw-bold">
                                                                <i class="fas fa-link me-1"></i> {{ __('notifications.reference_link') }}
                                                            </span>
                                                        @endif
                                                        <span class="fs-8 text-gray-500 ms-2">{{ $notification->created_at_human }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('admin.notifications.show', $notification->id) }}"
                                                   class="btn btn-sm btn-primary rounded-pill shadow-sm px-4 d-flex align-items-center"
                                                   style="transition: background 0.2s, box-shadow 0.2s;"
                                                   data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('notifications.view_details') }}">
                                                    <i class="fas fa-eye me-2"></i>
                                                    <span>{{ __('notifications.view') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                            {{ $notifications->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
