@extends('admin.layouts.master')
@section('title', __('notifications.details'))

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('notifications.details') }}
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.notifications.all') }}" class="text-muted text-hover-primary">{{ __('notifications.notifications') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">{{ __('notifications.details') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header border-0 cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('notifications.details') }}</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('admin.notifications.all') }}" class="btn btn-sm btn-light-primary">
                                <i class="fas fa-arrow-left me-2"></i> {{ __('notifications.back') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="d-flex align-items-center mb-8">
                            <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-light-{{
                                $notification->meta['type'] ?? '' === 'warning' ? 'primary' :
                                ($notification->meta['type'] ?? '' === 'success' ? 'success' :
                                ($notification->meta['type'] ?? '' === 'info' ? 'info' : 'primary'))
                            }}">
                                <i class="fas
                                    @if(($notification->meta['type'] ?? '') === 'warning') fa-bell text-primary
                                    @elseif(($notification->meta['type'] ?? '') === 'success') fa-check-circle text-success
                                    @elseif(($notification->meta['type'] ?? '') === 'info') fa-info-circle text-info
                                    @else fa-bell text-primary
                                    @endif
                                fs-2x"></i>
                            </span>
                            </div>
                            <div class="d-flex flex-column">
                                <h2 class="fw-bold mb-1">{{ $notification->title }}</h2>
                                <span class="text-muted">{{ $notification->created_at_human }}</span>
                            </div>
                        </div>

                        <div class="mb-8">
                            <div class="fs-6 text-gray-800 p-6 bg-light rounded">{!! nl2br(e($notification->body)) !!}</div>
                        </div>

                        @if(isset($notification->meta['attachments']) && is_array($notification->meta['attachments']) && count($notification->meta['attachments']) > 0)
                            <div class="separator my-6"></div>
                            <div class="mb-8">
                                <h5 class="fw-semibold mb-4"><i class="fas fa-paperclip me-2"></i>{{ __('notifications.attachments') }}</h5>
                                <div class="row g-4">
                                    @foreach($notification->meta['attachments'] as $attachment)
                                        <div class="col-md-6 col-xl-4">
                                            <div class="d-flex flex-column flex-sm-row align-items-center p-4 bg-light rounded">
                                                <div class="symbol symbol-40px me-4 mb-3 mb-sm-0">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="fas fa-file text-primary"></i>
                                            </span>
                                                </div>
                                                <div class="flex-grow-1 me-2">
                                                    <a href="{{ $attachment['url'] ?? '#' }}" target="_blank"
                                                       class="text-gray-800 text-hover-primary fw-bold d-block">
                                                        {{ basename($attachment['path'] ?? $attachment['url'] ?? '') }}
                                                    </a>
                                                    <span class="text-muted">{{ __('notifications.click_to_download') }}</span>
                                                </div>
                                                <a href="{{ $attachment['url'] ?? '#' }}" target="_blank"
                                                   class="btn btn-icon btn-sm btn-light-primary">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!empty($notification->meta['link']))
                            <div class="separator my-6"></div>
                            <div class="mb-8">
                                <h5 class="fw-semibold mb-4"><i class="fas fa-link me-2"></i>{{ __('notifications.reference_link') }}</h5>
                                <div class="d-flex align-items-center p-4 bg-light rounded">
                                    <i class="fas fa-external-link-alt me-3 text-primary fs-2"></i>
                                    <div class="flex-grow-1">
                                        <a href="{{ $notification->meta['link'] }}" target="_blank"
                                           class="text-primary text-hover-underline d-block">
                                            {{ Str::limit($notification->meta['link'], 50) }}
                                        </a>
                                        <span class="text-muted">{{ __('notifications.click_to_open') }}</span>
                                    </div>
                                    <a href="{{ $notification->meta['link'] }}" target="_blank"
                                       class="btn btn-sm btn-light-primary">
                                        {{ __('notifications.visit') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
