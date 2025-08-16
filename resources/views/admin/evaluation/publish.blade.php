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

            .exams-panel {
                width: 380px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                padding: 30px;
                overflow-y: auto;
                border: 1px solid rgba(255, 255, 255, 0.2);
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

            .panel-title {
                font-size: 28px;
                font-weight: 800;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 30px;
                text-align: center;
            }

            .exam-card {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                border-radius: 16px;
                padding: 25px;
                margin-bottom: 20px;
                box-shadow: 0 8px 32px rgba(240, 147, 251, 0.3);
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }

            .exam-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .exam-card:hover::before {
                opacity: 1;
            }

            .exam-card:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 20px 40px rgba(240, 147, 251, 0.4);
            }

            .exam-card.active {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
            }

            .exam-card.active::before {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                opacity: 1;
            }

            .exam-content {
                position: relative;
                z-index: 2;
            }

            .exam-name {
                font-size: 20px;
                font-weight: 700;
                color: white;
                margin-bottom: 15px;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .exam-meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                color: rgba(255, 255, 255, 0.9);
                font-size: 14px;
                margin-bottom: 20px;
            }

            .view-questions-btn {
                background: rgba(255, 255, 255, 0.2);
                color: white;
                border: 2px solid rgba(255, 255, 255, 0.3);
                padding: 12px 24px;
                border-radius: 25px;
                cursor: pointer;
                font-size: 14px;
                font-weight: 600;
                transition: all 0.3s ease;
                width: 100%;
                backdrop-filter: blur(10px);
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .view-questions-btn:hover {
                background: rgba(255, 255, 255, 0.3);
                border-color: rgba(255, 255, 255, 0.5);
                transform: translateY(-2px);
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

            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 24px;
                width: 24px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 6px;
                border: 2px solid rgba(255, 255, 255, 0.5);
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }

            .custom-checkbox input:checked ~ .checkmark {
                background: rgba(255, 255, 255, 0.9);
                border-color: white;
            }

            .checkmark::after {
                content: "";
                position: absolute;
                display: none;
                left: 7px;
                top: 3px;
                width: 6px;
                height: 10px;
                border: solid #667eea;
                border-width: 0 2px 2px 0;
                transform: rotate(45deg);
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

            .questions-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid rgba(102, 126, 234, 0.2);
            }

            .exam-title {
                font-size: 24px;
                font-weight: 700;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .question-count {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                color: white;
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 14px;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
            }

            .no-content {
                text-align: center;
                color: rgba(0, 0, 0, 0.5);
                font-size: 18px;
                margin-top: 80px;
                font-weight: 500;
            }

            .loading {
                text-align: center;
                color: rgba(0, 0, 0, 0.6);
                font-size: 18px;
                margin-top: 80px;
                font-weight: 500;
            }

            .loading::after {
                content: '';
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 3px solid rgba(102, 126, 234, 0.3);
                border-radius: 50%;
                border-top-color: #667eea;
                animation: spin 1s ease-in-out infinite;
                margin-left: 10px;
            }

            @keyframes spin {
                to { transform: rotate(360deg); }
            }

            .selected-count {
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 15px 25px;
                border-radius: 50px;
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
                font-weight: 600;
                font-size: 16px;
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.3s ease;
                z-index: 1000;
            }

            .selected-count.show {
                opacity: 1;
                transform: translateY(0);
            }

            /* Scrollbar styling */
            .exams-panel::-webkit-scrollbar,
            .questions-panel::-webkit-scrollbar {
                width: 8px;
            }

            .exams-panel::-webkit-scrollbar-track,
            .questions-panel::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }

            .exams-panel::-webkit-scrollbar-thumb,
            .questions-panel::-webkit-scrollbar-thumb {
                background: rgba(102, 126, 234, 0.5);
                border-radius: 10px;
            }

            .exams-panel::-webkit-scrollbar-thumb:hover,
            .questions-panel::-webkit-scrollbar-thumb:hover {
                background: rgba(102, 126, 234, 0.7);
            }

            .custom-select-container {
                position: relative;
                width: 100%;
                max-width: 300px;
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
        </style>
    <div class="container">
        <div class="exams-panel">
            <h2 class="panel-title">📚 {{ __('questions.consultant.question_bank') }}</h2>
            @php
                $exams = \App\Models\QuestionBankType::all();
            @endphp
            @forelse($exams as $exam)
                <div class="exam-card" data-exam-id="{{ $exam->id }}">
                    <div class="exam-content">
                        <div class="exam-name">{{ $exam->getTranslation('name',app()->getLocale()) }}</div>
                        <div class="exam-meta">
                            <span>{{ $exam->questions_count ?? 0 }} Questions</span>
                        </div>
                        <button class="view-questions-btn" onclick="loadQuestions({{ $exam->id }}, '{{ $exam->getTranslation('name',app()->getLocale()) }}')">
                            View Questions
                        </button>
                    </div>
                </div>
            @empty
                <div class="no-content">
                    📝 No exams available
                </div>
            @endforelse
        </div>

        <!-- Questions Panel -->
        <div class="questions-panel">
            <div id="questions-content">
                <div class="no-content">
                    👈 Select an exam to view questions
                </div>
            </div>
        </div>
    </div>

    <div class="selected-count" id="selected-counter">
        <span id="selected-count-text">0 questions selected</span>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('change', function (e) {
            if (e.target.matches('input[type="checkbox"][id^="question-"]')) {
                const id = parseInt(e.target.id.replace('question-', ''), 10);
                toggleQuestion(id);
            }
        });
    </script>

    <script>


        const appLocale = "{{ app()->getLocale() }}";
        let selectedQuestions = [];

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function loadQuestions(examId, examName , valueQuestion = null) {
            updateSelectedCounter();

            document.querySelectorAll('.exam-card').forEach(card => {
                card.classList.remove('active');
            });

            document.querySelector(`[data-exam-id="${examId}"]`).classList.add('active');

            // Show loading state
            const questionsContent = document.getElementById('questions-content');
            questionsContent.innerHTML = '<div class="loading">Loading questions...</div>';

            try {
                const url = valueQuestion
                    ? `/exams/${examId}/questions/${valueQuestion}`
                    : `/exams/${examId}/questions`;

                const response = await fetch(url, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }


                const data = await response.json();
                console.log(data.questions)
                selectedQuestions = data.selected_questions || [];
                updateSelectedCounter();

                if (data.questions && data.questions.length > 0) {
                    const optionHtml = data.values
                        .map(value => {
                            const valueNameObj = JSON.parse(value.value_name);
                            return `
                                <div class="select-option"
                                            data-exam-id="${examId}"
                                            data-exame-name="${examName}"
                                            data-value-id="${value.value_id}"
                                            onclick="selectOption(this, '${value.id}')">
                                    ${valueNameObj[appLocale]}
                                </div>
                            `;
                        })
                        .join("");
                    const choose_value = "{{ __('questions.consultant.choose_value') }}" ;
                    const select_option = "{{ __('questions.consultant.select_option') }}" ;
                    const questions = "{{ __('questions.consultant.questions') }}" ;


                    let questionsHtml = `
                    <div class="questions-header">
                        <div class="exam-title">${examName}</div>
                        <div class="question-count">${data.questions.length} ${questions}</div>
                    </div>

                    <div class="custom-select-container">
                        <label class="select-label">${choose_value}:</label>
                        <div class="custom-select">
                            <div class="select-trigger" onclick="toggleSelect()">
                                <span class="select-text">${select_option}:</span>
                                <div class="select-arrow"></div>
                            </div>
                            <div class="select-options" id="selectOptions">
                                ${optionHtml}
                            </div>
                        </div>
                    </div>
                    `;

                    data.questions.forEach(question => {
                        const isSelected = selectedQuestions.includes(question.id) ? 'checked' : '';
                        const isItemSelected = selectedQuestions.includes(question.id) ? 'selected' : '';
                        questionsHtml += `
                        <div class="question-item ${isItemSelected}" data-question-id="${question.id}">
                            <div class="question-content">
                                <div class="custom-checkbox">
                            <input type="checkbox" id="question-${question.id}" value="${question.id}" ${isSelected} >
                            <label for="question-${question.id}" class="checkmark"></label>
                        </div>
                                <div class="question-text">${question.text[appLocale]}</div>
                            </div>
                        </div>
                        `;
                    });

                    questionsContent.innerHTML = questionsHtml;

                    const sortable = new Sortable(questionsContent, {
                        animation: 150,
                        handle: '.question-item',
                        onEnd: async () => {
                            const orderData = Array.from(questionsContent.querySelectorAll('.question-item')).map((item, index) => {
                                return {
                                    id: parseInt(item.getAttribute('data-question-id'), 10),
                                    order: index + 1
                                };
                            });

                            console.log('New order:', orderData);

                            try {
                                const response = await fetch('/questions/reorder', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json',
                                    },
                                    body: JSON.stringify({ order: orderData })
                                });

                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }

                                const result = await response.json();
                                console.log(result.message);
                            } catch (err) {
                                console.error('Failed to save order:', err);
                            }
                        }
                    });

                } else {
                    questionsContent.innerHTML = `
                    <div class="questions-header">
                        <div class="exam-title">${examName}</div>
                        <div class="question-count">0 Questions</div>
                    </div>
                    <div class="no-content">❌ No questions found for this exam</div>
                `;
                }
            } catch (error) {
                console.error('Error loading questions:', error);
                questionsContent.innerHTML = '<div class="no-content">❌ Error loading questions</div>';
            }
        }

        async function toggleQuestion(questionId) {
            const checkbox = document.getElementById(`question-${questionId}`);
            const questionItem = document.querySelector(`[data-question-id="${questionId}"]`);

            if (checkbox.checked) {
                selectedQuestions.push(questionId);
                questionItem.classList.add('selected');

                try {
                    const response =  await fetch('/questions/select', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            question_id: questionId,
                            action: 'select'
                        })

                    });
                    if (response.ok) {
                        console.log('✅ Selected questions:');
                    } else {
                        console.error('❌ Failed to select question. Status:', response.status);
                    }
                } catch (error) {
                    console.error('Error selecting question:', error);
                }
            } else {
                selectedQuestions = selectedQuestions.filter(id => id !== questionId);
                questionItem.classList.remove('selected');

                try {
                   const response =await fetch('/questions/select', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            question_id: questionId,
                            action: 'deselect'
                        })
                    });

                    if (response.ok) {
                        console.log('✅ Selected removed');
                    } else {
                        console.error('❌ Failed to select question. Status:', response.status);
                    }
                } catch (error) {
                    console.error('Error deselecting question:', error);
                }
            }

            updateSelectedCounter();
        }

        function updateSelectedCounter() {
            const counter = document.getElementById('selected-counter');
            const countText = document.getElementById('selected-count-text');

            if (selectedQuestions.length > 0) {
                countText.textContent = `${selectedQuestions.length} question${selectedQuestions.length > 1 ? 's' : ''} selected`;
                counter.classList.add('show');
            } else {
                counter.classList.remove('show');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const examCards = document.querySelectorAll('.exam-card');
            examCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });


</script>
<script>
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
        const examName = element.dataset.exameName;
        const valueId = element.dataset.valueId;

        // console.log(valueId)
        loadQuestions(examId , examName , valueId)

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

