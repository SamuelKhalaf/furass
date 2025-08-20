<div class="modal fade" id="kt_modal_update_program" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <form class="form" action="{{ route('admin.programs.update', ['program' => '__ID__']) }}" id="kt_modal_update_program_form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="program_id" value="">
                <input type="hidden" name="path_points" id="pathPointsData" value="">

                <div class="modal-header" id="kt_modal_update_program_header">
                    <h2 class="fw-bold">Update Program</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <div class="modal-body py-4 px-4">
                    <div class="row">
                        <!-- Basic Program Info -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Program Information</h5>

                            <div class="fv-row mb-3">
                                <label class="required fw-semibold fs-6 mb-2">Title (Arabic)</label>
                                <input type="text" name="title_ar" class="form-control form-control-solid" placeholder="Enter program name in Arabic" required />
                            </div>

                            <div class="fv-row mb-3">
                                <label class="required fw-semibold fs-6 mb-2">Title (English)</label>
                                <input type="text" name="title_en" class="form-control form-control-solid" placeholder="Enter program name in English" required />
                            </div>

                            <div class="fv-row mb-3">
                                <label class="required fw-semibold fs-6 mb-2">Description (Arabic)</label>
                                <textarea name="description_ar" class="form-control form-control-solid" rows="3" placeholder="Enter description in Arabic" required></textarea>
                            </div>

                            <div class="fv-row mb-3">
                                <label class="required fw-semibold fs-6 mb-2">Description (English)</label>
                                <textarea name="description_en" class="form-control form-control-solid" rows="3" placeholder="Enter description in English" required></textarea>
                            </div>

                            <!-- Available Path Points -->
                            <div class="mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Available Path Points</h6>
                                    <small class="text-muted">Click to add to program</small>
                                </div>
                                <div class="available-points border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    <!-- Will be populated dynamically -->
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Program Path Configuration -->
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Learning Path</h5>
                                <button type="button" class="btn btn-sm btn-light clear-path-btn">
                                    <i class="fas fa-trash me-1"></i>Clear All
                                </button>
                            </div>

                            <!-- Path Visualization -->
                            <div class="path-visual">
                                <div id="programPath" class="program-path">
                                    <div class="empty-path">
                                        <i class="fas fa-route fa-2x mb-3 text-muted"></i>
                                        <p class="mb-0">Drag path points here to create learning path</p>
                                        <small class="text-muted">You can reorder by dragging</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Path Summary -->
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6 class="mb-2">Path Summary</h6>
                                <div class="d-flex justify-content-between">
                                    <span>Total Steps:</span>
                                    <span id="totalSteps" class="fw-bold">0</span>
                                </div>
{{--                                <div class="d-flex justify-content-between">--}}
{{--                                    <span>Estimated Duration:</span>--}}
{{--                                    <span id="estimatedDuration" class="fw-bold">-</span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="button" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">Save Program</span>
                        <span class="indicator-progress d-none">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
