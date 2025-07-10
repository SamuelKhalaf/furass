<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Evaluation Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .test-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 0 auto;
            max-width: 800px;
            min-height: 500px;
        }

        .test-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid #667eea;
        }

        .test-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2.5rem;
        }

        .test-subtitle {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        .question-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #667eea;
            min-height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .question-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .question-number {
            background: #667eea;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1.5rem;
            flex-shrink: 0;
            font-size: 1.2rem;
        }

        .question-text {
            flex: 1;
            font-size: 1.3rem;
            color: #2c3e50;
            font-weight: 500;
            margin: 0;
        }

        .rating-section {
            text-align: center;
        }

        .rating-options {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }

        .rating-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 1rem;
            border-radius: 10px;
        }

        .rating-option:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
        }

        .rating-option.selected {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .rating-circle {
            width: 60px;
            padding: 40px;
            height: 60px;
            border: 3px solid #bdc3c7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .rating-option:hover .rating-circle {
            border-color: #667eea;
        }

        .rating-option.selected .rating-circle {
            border-color: white;
            background: rgba(255, 255, 255, 0.2);
        }

        .rating-label {
            font-size: 0.9rem;
            font-weight: 500;
            text-align: center;
            margin-top: 0.5rem;
        }

        .rating-scale {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #95a5a6;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .navigation-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #ecf0f1;
        }

        .nav-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            background: linear-gradient(45deg, #764ba2, #667eea);
        }

        .nav-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .submit-btn {
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            border: none;
            padding: 12px 40px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
            background: linear-gradient(45deg, #2ecc71, #27ae60);
        }

        .progress-bar-container {
            margin-bottom: 2rem;
        }

        .progress-bar {
            height: 8px;
            border-radius: 10px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.5s ease;
        }

        .question-counter {
            text-align: center;
            color: #7f8c8d;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .completion-screen {
            text-align: center;
            padding: 3rem 2rem;
        }

        .completion-icon {
            font-size: 4rem;
            color: #27ae60;
            margin-bottom: 1rem;
        }

        .completion-title {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .completion-score {
            font-size: 1.5rem;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .test-container {
                margin: 0 1rem;
                padding: 1.5rem;
            }

            .test-title {
                font-size: 2rem;
            }

            .question-text {
                font-size: 1.1rem;
            }

            .rating-options {
                gap: 0.5rem;
            }

            .rating-circle {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .rating-option {
                padding: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .test-title {
                font-size: 1.5rem;
            }

            .rating-options {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .rating-circle {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }

            .navigation-section {
                flex-direction: column;
                gap: 1rem;
            }
        }
        #ratingOptionsTF { display: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="test-container">
        <div class="test-header">
            <h1 class="test-title">
                <i class="fas fa-clipboard-list me-3"></i>
                Evaluation Test
            </h1>
            <p class="test-subtitle">Please answer each question by either rating it from 1 to 5 or selecting whether it is true or false.
                @if(isset($program) && isset($pathPoint))
                    <br><small class="text-muted">
                        Program: {{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }} |
                        Activity: {{ $pathPoint->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}
                    </small>
                @endif
            </p>
        </div>

        <form id="evaluationForm" action="{{ route('admin.evaluation.submit') }}" method="POST">
            @csrf
            @if(isset($program_id) && isset($path_point_id))
                <input type="hidden" name="program_id" value="{{ $program_id }}">
                <input type="hidden" name="path_point_id" value="{{ $path_point_id }}">
            @endif
            <div class="progress-bar-container">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%" id="progressBar"></div>
                </div>
                <small class="text-muted mt-1 d-block">Progress: <span id="progressText">0/{{ $questions->count() }}</span></small>
            </div>

            <div id="questionScreen">
                <div class="question-counter">
                    Question <span id="currentQuestion">1</span> of <span id="totalQuestions">{{ $questions->count() }}</span>
                </div>

                <div class="question-container">
                    <div class="question-header">
                        <div class="question-number" id="questionNumber">1</div>
                        <p class="question-text" id="questionText"></p>
                    </div>


                    <div class="rating-section">
                        <div class="rating-options" id="ratingOptionsScale">
                            <div class="rating-option" data-value="1"><div class="rating-circle">1</div></div>
                            <div class="rating-option" data-value="2"><div class="rating-circle">2</div></div>
                            <div class="rating-option" data-value="3"><div class="rating-circle">3</div></div>
                            <div class="rating-option" data-value="4"><div class="rating-circle">4</div></div>
                            <div class="rating-option" data-value="5"><div class="rating-circle">5</div></div>
                        </div>

                        <div class="rating-options" id="ratingOptionsTF">
                            <div class="rating-option" data-value="0"><div class="rating-circle">True</div></div>
                            <div class="rating-option" data-value="-1"><div class="rating-circle">False</div></div>
                        </div>
                        <div class="rating-scale" id="ratingScale"></div>
                    </div>
                </div>

                <div class="navigation-section">
                    <button type="button" class="nav-btn" id="prevBtn" disabled>
                        <i class="fas fa-chevron-left me-2"></i>
                        Previous
                    </button>
                    <button type="button" class="nav-btn" id="nextBtn" disabled>
                        Next
                        <i class="fas fa-chevron-right ms-2"></i>
                    </button>
                    <button type="submit" class="submit-btn" id="submitBtn" style="display: none;">
                        <i class="fas fa-paper-plane me-2"></i>
                        Submit Evaluation
                    </button>
                </div>
            </div>
        </form>

        <div id="completionScreen" style="display: none;" class="completion-screen">
            <div class="completion-icon">
                <i class="fas fa-check-circle"></i>

            </div>
            <h2 class="completion-title">Evaluation Completed!</h2>
            <p class="text-muted">Thank you for your feedback!</p>
            @if(isset($program_id) && isset($path_point_id))
                <a href="{{ route('admin.student.path-point.show', ['program' => $program_id, 'pathPoint' => $path_point_id]) }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Activity
                </a>
            @endif
        </div>

        <div id="noThinkQuestion" style="display: none;" class="completion-screen">
            <div class="completion-icon">
                <i class="fas fa-times-circle"></i>

            </div>
            <h2 class="completion-title">NO Question Here</h2>
            <p class="text-muted">Come Again In Another Time</p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const checkquestions = {!! json_encode($questions) !!};

        if (!checkquestions || checkquestions.length === 0) {
            document.getElementById('questionScreen').style.display = 'none';
            document.getElementById('noThinkQuestion').style.display = 'block';
        }

        const questions = {!! json_encode(
        $questions->map(function ($question) {
            return [
                'id' => $question->id,
                'text' => $question->text[app()->getLocale()],
                'type' => $question->type,
                'scale' => [
                    '1 - ' . $question->scale_low_label,
                    '3 - ' . $question->scale_mid_label,
                    '5 - ' . $question->scale_high_label,
                ],
            ];
        })->values()->toArray()
    ) !!};


        let currentQuestionIndex = 0;
        let answers = {};

        const questionScreen = document.getElementById('questionScreen');
        const completionScreen = document.getElementById('completionScreen');
        const currentQuestionSpan = document.getElementById('currentQuestion');
        const totalQuestionsSpan = document.getElementById('totalQuestions');
        const questionNumber = document.getElementById('questionNumber');
        const questionText = document.getElementById('questionText');
        const ratingScale = document.getElementById('ratingScale');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const evaluationForm = document.getElementById('evaluationForm');

        const ratingOptionsScale = document.getElementById('ratingOptionsScale');
        const ratingOptionsTF = document.getElementById('ratingOptionsTF');

        questions.forEach((question) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `answers[${question.id}]`;
            input.id = `answer_${question.id}`;
            input.value = '';
            evaluationForm.appendChild(input);
        });


        function updateProgress() {
            const answeredCount = Object.keys(answers).length;
            const progress = (answeredCount / questions.length) * 100;
            progressBar.style.width = progress + '%';
            progressText.textContent = answeredCount + '/' + questions.length;
        }

        function displayQuestion(index) {
            const question = questions[index];

            currentQuestionSpan.textContent = index + 1;
            questionNumber.textContent = index + 1;
            questionText.textContent = question.text;

            if (question.type === 'rating') {
                ratingOptionsScale.style.display = 'flex';
                ratingOptionsTF.style.display = 'none';
                ratingScale.innerHTML = question.scale.map(item => `<span></span>`).join('');
            } else if (question.type === 'true_and_false') {
                ratingOptionsScale.style.display = 'none';
                ratingOptionsTF.style.display = 'flex';
                ratingScale.innerHTML = '';
            }

            ['ratingOptionsScale', 'ratingOptionsTF'].forEach(id => {
                document.getElementById(id).querySelectorAll('.rating-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
            });

            if (answers[question.id] !== undefined) {
                const containerId = (question.type === 'rating') ? 'ratingOptionsScale' : 'ratingOptionsTF';
                const container = document.getElementById(containerId);
                const selectedOption = container.querySelector(`[data-value="${answers[question.id]}"]`);
                if (selectedOption) {
                    selectedOption.classList.add('selected');
                }
                nextBtn.disabled = false;
                submitBtn.disabled = false;
            } else {
                nextBtn.disabled = true;
                submitBtn.disabled = true;
            }

            prevBtn.disabled = index === 0;

            if (index === questions.length - 1) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-block';
            } else {
                nextBtn.style.display = 'inline-block';
                submitBtn.style.display = 'none';
            }
        }

        function attachClickHandlers(container) {
            container.addEventListener('click', function(e) {
                const option = e.target.closest('.rating-option');
                if (option) {
                    const value = parseInt(option.dataset.value);
                    const currentQuestion = questions[currentQuestionIndex];
                    answers[currentQuestion.id] = value;

                    document.getElementById(`answer_${currentQuestion.id}`).value = value;

                    container.querySelectorAll('.rating-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    option.classList.add('selected');

                    nextBtn.disabled = false;
                    submitBtn.disabled = false;

                    updateProgress();
                }
            });
        }

        attachClickHandlers(ratingOptionsScale);
        attachClickHandlers(ratingOptionsTF);

        prevBtn.addEventListener('click', function() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                displayQuestion(currentQuestionIndex);
            }
        });

        nextBtn.addEventListener('click', function() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                displayQuestion(currentQuestionIndex);
            }
        });

        evaluationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (Object.keys(answers).length === questions.length) {
                questionScreen.style.display = 'none';
                completionScreen.style.display = 'block';

                fetch(evaluationForm.action, {
                    method: 'POST',
                    body: new FormData(evaluationForm),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // alert('Evaluation submitted successfully!');
                        } else {
                            // alert('Submission failed: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting evaluation:', error);
                        alert('Error submitting evaluation: ' + error.message);
                    });
            }
        });

        displayQuestion(0);
        updateProgress();
    });
</script>

</body>
</html>
