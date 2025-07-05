<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .question-item {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #667eea;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .question-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .question-number {
            background: #667eea;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .question-text {
            flex: 1;
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 500;
            margin: 0;
        }

        .rating-section {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #ecf0f1;
        }

        .rating-input {
            width: 60px;
            height: 45px;
            border: 2px solid #bdc3c7;
            border-radius: 10px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .rating-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
            outline: none;
        }

        .rating-input:valid {
            border-color: #27ae60;
            background: #e8f5e8;
        }

        .rating-label {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-top: 0.5rem;
        }

        .rating-scale {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #95a5a6;
        }

        .submit-section {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #ecf0f1;
        }

        .submit-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            padding: 12px 40px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            background: linear-gradient(45deg, #764ba2, #667eea);
        }

        .progress-bar-container {
            margin-bottom: 2rem;
        }

        .progress-bar {
            height: 8px;
            border-radius: 10px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        @media (max-width: 768px) {
            .test-container {
                margin: 0 1rem;
                padding: 1.5rem;
            }

            .test-title {
                font-size: 2rem;
            }

            .question-item {
                padding: 1rem;
            }

            .question-number {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }

            .question-text {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .test-title {
                font-size: 1.5rem;
            }

            .rating-input {
                width: 50px;
                height: 40px;
                font-size: 1rem;
            }
        }
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
            <p class="test-subtitle">Please rate each item from 1 to 5 based on your assessment</p>
        </div>

        <div class="progress-bar-container">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%" id="progressBar"></div>
            </div>
            <small class="text-muted mt-1 d-block">Progress: <span id="progressText">0/10</span></small>
        </div>

        <form id="evaluationForm">
            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">1</div>
                    <p class="question-text">How would you rate the overall quality of the presentation?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q1" id="q1">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Poor</span>
                                <span>3 - Average</span>
                                <span>5 - Excellent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">2</div>
                    <p class="question-text">How clear and understandable was the content delivery?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q2" id="q2">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Very Unclear</span>
                                <span>3 - Moderate</span>
                                <span>5 - Very Clear</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">3</div>
                    <p class="question-text">How engaging was the speaker's delivery style?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q3" id="q3">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Boring</span>
                                <span>3 - Neutral</span>
                                <span>5 - Very Engaging</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">4</div>
                    <p class="question-text">How relevant was the content to your needs?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q4" id="q4">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Not Relevant</span>
                                <span>3 - Somewhat</span>
                                <span>5 - Highly Relevant</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">5</div>
                    <p class="question-text">How would you rate the visual aids and materials used?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q5" id="q5">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Poor Quality</span>
                                <span>3 - Adequate</span>
                                <span>5 - Excellent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">6</div>
                    <p class="question-text">How well did the session meet your expectations?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q6" id="q6">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Below Expectations</span>
                                <span>3 - Met Expectations</span>
                                <span>5 - Exceeded</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">7</div>
                    <p class="question-text">How organized and structured was the content?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q7" id="q7">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Disorganized</span>
                                <span>3 - Moderately</span>
                                <span>5 - Well Organized</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">8</div>
                    <p class="question-text">How would you rate the time management of the session?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q8" id="q8">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Poor Timing</span>
                                <span>3 - Adequate</span>
                                <span>5 - Perfect Timing</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">9</div>
                    <p class="question-text">How effective was the interaction and Q&A session?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q9" id="q9">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Ineffective</span>
                                <span>3 - Moderate</span>
                                <span>5 - Very Effective</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question-item">
                <div class="d-flex align-items-center">
                    <div class="question-number">10</div>
                    <p class="question-text">How likely are you to recommend this to others?</p>
                </div>
                <div class="rating-section">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <input type="number" class="form-control rating-input" min="1" max="5" name="q10" id="q10">
                        </div>
                        <div class="col">
                            <div class="rating-label">Rating (1-5)</div>
                            <div class="rating-scale">
                                <span>1 - Never</span>
                                <span>3 - Maybe</span>
                                <span>5 - Definitely</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="submit-section">
                <button type="submit" class="btn submit-btn">
                    <i class="fas fa-paper-plane me-2"></i>
                    Submit Evaluation
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('evaluationForm');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const inputs = form.querySelectorAll('.rating-input');

        function updateProgress() {
            const filledInputs = Array.from(inputs).filter(input => input.value !== '');
            const progress = (filledInputs.length / inputs.length) * 100;
            progressBar.style.width = progress + '%';
            progressText.textContent = filledInputs.length + '/' + inputs.length;
        }

        inputs.forEach(input => {
            input.addEventListener('input', updateProgress);

            input.addEventListener('input', function() {
                if (this.value < 1 || this.value > 5) {
                    this.setCustomValidity('Please enter a rating between 1 and 5');
                } else {
                    this.setCustomValidity('');
                }
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let allFilled = true;
            let totalScore = 0;

            inputs.forEach(input => {
                if (!input.value || input.value < 1 || input.value > 5) {
                    allFilled = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                    totalScore += parseInt(input.value);
                }
            });

            if (allFilled) {
                const averageScore = (totalScore / inputs.length).toFixed(1);
                alert(`Evaluation submitted successfully!\nTotal Score: ${totalScore}/50\nAverage Rating: ${averageScore}/5`);
            } else {
                alert('Please fill in all ratings with values between 1 and 5.');
            }
        });
    });
</script>
</body>
</html>



