@extends('admin.layouts.master')
@section('title', __('questions.title'))

@section('content')
        <style>
            .container {
                display: flex;
                height: 100vh;
                gap: 20px;
                padding: 20px;
            }

            .questions-panel {
                flex: 1;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                padding: 30px;
                overflow-y: auto;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }


            .question-item {
                background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
                border-radius: 16px;
                padding: 25px;
                margin-bottom: 20px;
                box-shadow: 0 8px 32px rgba(252, 182, 159, 0.3);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .question-item::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .question-item:hover::before {
                opacity: 1;
            }

            .question-item:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 40px rgba(252, 182, 159, 0.4);
            }

            .question-item.selected {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                box-shadow: 0 16px 40px rgba(102, 126, 234, 0.4);
                transform: translateY(-4px);
            }

            .question-item.selected::before {
                opacity: 0;
            }

            .question-content {
                display: flex;
                align-items: flex-start;
                gap: 20px;
                position: relative;
                z-index: 2;
            }

            .custom-checkbox {
                position: relative;
                width: 24px;
                height: 24px;
                margin-top: 2px;
            }

            .custom-checkbox input {
                opacity: 0;
                position: absolute;
                cursor: pointer;
            }
            .custom-checkbox input:checked ~ .checkmark {
                background: rgba(255, 255, 255, 0.9);
                border-color: white;
            }


            .custom-checkbox input:checked ~ .checkmark::after {
                display: block;
            }

            .question-text {
                flex: 1;
                font-size: 16px;
                line-height: 1.6;
                color: rgba(0, 0, 0, 0.8);
                font-weight: 500;
            }

            .question-item.selected .question-text {
                color: white;
            }

            .no-content {
                text-align: center;
                color: rgba(0, 0, 0, 0.5);
                font-size: 18px;
                margin-top: 80px;
                font-weight: 500;
            }


            @keyframes spin {
                to { transform: rotate(360deg); }
            }


            .exams-panel::-webkit-scrollbar-thumb:hover,
            .questions-panel::-webkit-scrollbar-thumb:hover {
                background: rgba(102, 126, 234, 0.7);
            }

            .custom-select-container {
                position: relative;
                width: 100%;
                margin: 20px 0;
            }

            .custom-select {
                position: relative;
                display: inline-block;
                width: 100%;
            }

            .select-trigger {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-radius: 15px;
                padding: 15px 20px;
                color: rgba(0, 0, 0, 0.8);
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: relative;
                box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
            }

            .select-trigger:hover {
                background: rgba(255, 255, 255, 0.25);
                border-color: rgba(255, 255, 255, 0.5);
                transform: translateY(-2px);
                box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
            }

            .select-trigger.active {
                background: rgba(255, 255, 255, 0.25);
                border-color: rgba(102, 126, 234, 0.6);
                box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
            }

            .select-arrow {
                width: 0;
                height: 0;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-top: 8px solid rgba(102, 126, 234, 0.7);
                transition: transform 0.3s ease;
            }

            .select-trigger.active .select-arrow {
                transform: rotate(180deg);
            }

            .select-options {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(15px);
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-radius: 15px;
                margin-top: 5px;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all 0.3s ease;
                z-index: 1000;
                box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
                overflow: hidden;
            }

            .select-options.show {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .select-option {
                padding: 15px 20px;
                color: rgba(0, 0, 0, 0.8);
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                border-bottom: 1px solid rgba(255, 255, 255, 0.3);
                position: relative;
                overflow: hidden;
            }

            .select-option:last-child {
                border-bottom: none;
            }

            .select-option::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                opacity: 0;
                transition: opacity 0.3s ease;
                z-index: -1;
            }

            .select-option:hover::before {
                opacity: 0.1;
            }

            .select-option:hover {
                color: #667eea;
                transform: translateX(5px);
            }

            .select-option.selected {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                font-weight: 600;
            }

            .select-option.selected::before {
                opacity: 0;
            }

            .select-label {
                display: block;
                margin-bottom: 10px;
                font-size: 16px;
                font-weight: 600;
                color: rgba(0, 0, 0, 0.8);
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .summary-table-container {
                margin: 20px 0;
                display: flex;
                justify-content: center;
            }

            .summary-table {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                padding: 25px;
                min-width: 300px;
                max-width: 400px;
                transition: all 0.3s ease;
            }

            .summary-table:hover {
                transform: translateY(-4px);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            }

            .table-header {
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 2px solid rgba(102, 126, 234, 0.2);
                text-align: center;
            }

            .table-header h3 {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .table-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.3);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .table-row:last-child {
                border-bottom: none;
            }

            .table-row::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .table-row:hover::before {
                opacity: 0.1;
            }

            .table-row:hover {
                transform: translateX(5px);
            }

            .table-label {
                font-size: 16px;
                font-weight: 600;
                color: rgba(0, 0, 0, 0.8);
                position: relative;
                z-index: 2;
            }

            .table-value {
                font-size: 16px;
                font-weight: 700;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                padding: 6px 12px;
                border-radius: 12px;
                background-color: rgba(240, 147, 251, 0.1);
                position: relative;
                z-index: 2;
            }

            .error-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            }

            .error-box {
                background: #fff;
                color: #721c24;
                padding: 20px 30px;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.3);
                max-width: 500px;
                width: 90%;
                position: relative;
                text-align: center;
                font-size: 16px;
            }

            .error-box .close-btn {
                position: absolute;
                top: 10px;
                right: 12px;
                background: transparent;
                border: none;
                font-size: 24px;
                cursor: pointer;
                color: #000;
            }

            .error-content {
                margin-top: 10px;
            }

        </style>
    <div class="container">
        <!-- Questions Panel -->
        <div class="questions-panel">
            @if (!empty($error))
                <div class="error-overlay">
                    <div class="error-box">
                        <button class="close-btn" onclick="closeError()">×</button>
                        <div class="error-content">
                            {{ $error }}
                        </div>
                    </div>
                </div>
            @else
                <div id="questions-content">
                    <div class="custom-select-container" >
                       {{-- <div class="questions-header">
                            <div class="exam-title">${examName}</div>
                            <div class="question-count">${data.questions.length} ${questions}</div>
                        </div>--}}

                        <label class="select-label"> {{ __('questions.result.number_of_attempts') }}:</label>
                        <div class="custom-select">
                            <div class="select-trigger" onclick="toggleSelect()">
                                <span class="select-text"> {{ __('questions.result.choose_an_attempt') }}:</span>
                                <div class="select-arrow"></div>
                            </div>
                            <div class="select-options" id="selectOptions">
                                @isset($tryingNumber)
                                    @foreach($tryingNumber as $try)
                                        <div class="select-option"
                                             data-exam-id="{{ $bank_id }}"
                                             data-student-id="{{ $studentId }}"
                                             data-trying="{{ $try }}"
                                             onclick="selectOption(this, '{{ $try }}')">
                                            Attempt {{ $try }}
                                        </div>
                                    @endforeach
                                @endisset

                            </div>
                        </div>
                    </div>

                    <!-- Summary Statistics Table -->
                    <div class="summary-table-container">
                        <div class="summary-table">
                            <div class="table-header">
                                <h3>{{ __('questions.result.evaluations_summary') }}</h3>
                            </div>
                            <div id="container-values">
                                @isset($questions[1])
                                    @foreach($questions[1] as $value)
                                        <div class="table-row">
                                            @php
                                                $valueName = \App\Models\ValuesQuestions::where('id' ,$value-> value_id)->first();
                                            @endphp
                                            <div class="table-label">{{ $valueName->name[app()->getLocale()] }}</div>
                                            <div class="table-value">{{ $value-> total_evaluation}}</div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>

                    <div id="questionsContainer">
                        @isset($questions[0])
                            @foreach($questions[0] as $question)
                                <div class="question-item">
                                    <div class="question-content">
                                        @php
                                            $text = json_decode($question->text, true);
                                        @endphp
                                        <div class="question-text">{{ $text[app()->getLocale()] ?? '' }}</div>
                                        <div class="custom-checkbox">{{ $question->evaluation  }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection

@section('scripts')

<script>
    function closeError() {
        document.querySelector('.error-overlay').style.display = 'none';
    }

    function loadQuestions(exam_id, student_id, trying) {
        $.ajax({
            url: `/evaluation-question/${exam_id}/${student_id}/${trying}`,
            method: 'GET',
            success: function (data) {
                // Clear current questions
                const container = document.getElementById('questionsContainer');
                const containerValues = document.getElementById('container-values');

                container.innerHTML = '';
                containerValues.innerHTML = '';

                if (!data.length) {
                    container.innerHTML = `<div class="no-content">No questions found for this attempt.</div>`;
                    return;
                }

                // Loop through returned questions
                data[0].forEach(question => {
                    const textObj = JSON.parse(question.text);
                    const text = textObj[document.documentElement.lang] || '';

                    const evaluation = question.evaluation;

                    const html = `
                    <div class="question-item">
                        <div class="question-content">
                            <div class="question-text">${text}</div>
                            <div class="custom-checkbox">${evaluation}</div>
                        </div>
                    </div>
                 `;

                    container.insertAdjacentHTML('beforeend', html);
                });

                // Loop through returned values
                data[1].forEach(value => {
                    const nameObj = JSON.parse(value.name || '{}');
                    const locale = document.documentElement.lang || 'en';
                    const textObj = nameObj[locale] || '';
                    const evaluationSum = value.total_evaluation || '';
                    const html = `
                                  <div class="table-row">
                                      <div class="table-label">${textObj}</div>
                                      <div class="table-value">${evaluationSum}</div>
                                   </div>
                 `;
                    containerValues.insertAdjacentHTML('beforeend', html);
                });
            },
            error: function () {
                alert('Failed to load questions for this attempt.');
            }
        });
    }


    function toggleSelect() {
        const trigger = document.querySelector('.select-trigger');
        const options = document.getElementById('selectOptions');

        trigger.classList.toggle('active');
        options.classList.toggle('show');
    }

    function selectOption(element, value) {
        const trigger = document.querySelector('.select-trigger');
        const options = document.getElementById('selectOptions');
        const selectText = document.querySelector('.select-text');

        document.querySelectorAll('.select-option').forEach(opt => {
            opt.classList.remove('selected');
        });

        element.classList.add('selected');

        selectText.textContent = element.textContent;

        trigger.classList.remove('active');
        options.classList.remove('show');

        const examId = element.dataset.examId;
        const studentId = element.dataset.studentId;
        const trying = element.dataset.trying;

        loadQuestions(examId , studentId , trying)
    }

    document.addEventListener('click', function(event) {
        const select = document.querySelector('.custom-select');
        if (!select.contains(event.target)) {
            const trigger = document.querySelector('.select-trigger');
            const options = document.getElementById('selectOptions');
            trigger.classList.remove('active');
            options.classList.remove('show');
        }
    });
</script>
@endsection

