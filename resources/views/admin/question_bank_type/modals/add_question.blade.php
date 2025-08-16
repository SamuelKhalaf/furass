<div class="modal fade" id="kt_crud_question" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_crud_question_form" method="POST" enctype="multipart/form-data">
                @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_crud_question_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Questions</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_crud_question_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_crud_question_header" data-kt-scroll-wrappers="#kt_crud_question_scroll" data-kt-scroll-offset="300px">
                        <!--begin::School form-->
                        <div id="kt_crud_question_info"  class="collapse show">
                            <!--begin::Input group-->

                            <div class="question">
                                <div class="fv-row mb-7">
                                    <input type="text" name="questions[0][ar]" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="enter question text (arabic)" required />
                                </div>
                                <div class="fv-row mb-7">
                                    <input type="text" name="questions[0][en]" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="enter question text (english)" required />
                                </div>
                                <div class="fv-row mb-7">
                                    <select name="related_value_id" class="form-select form-control-solid" id="related_value_id">
                                    </select>
                                </div>

                            </div>

                        </div>

                        <button type="button" id="add-question">+ Add Question</button>
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                        Discard
                    </button>
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>

@push('scripts')

    <script>
        let questionIndex = 1;

        document.getElementById('add-question').addEventListener('click', () => {
            const container = document.getElementById('kt_crud_question_info');

            const div = document.createElement('div');
            div.classList.add('question');

            div.innerHTML = `

                 <div class="fv-row mb-7">
                   <input type="text" name="questions[${questionIndex}][ar]" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="enter question text (arabic)" required />
                </div>

                <div class="fv-row mb-7">
                  <input type="text" name="questions[${questionIndex}][en]" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="enter question text (english)" required />
                </div>


               <button type="button" class="remove-question">Remove</button>
        `;
            container.appendChild(div);
            questionIndex++;

            // Handle remove button
            div.querySelector('.remove-question').addEventListener('click', () => {
                div.remove();
            });
        });



    </script>


@endpush
