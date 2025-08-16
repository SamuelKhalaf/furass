@extends('admin.layouts.master')
@section('title', __('questions.title'))

@section('content')
        <style>
            .container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                padding: 20px;
                height: auto;
            }
            .exams-panel {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                width: 100%;
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

            @media (max-width: 1200px) {
                .exam-card {
                    flex: 1 1 calc(33.33% - 10px);
                }
            }

            @media (max-width: 900px) {
                .exam-card {
                    flex: 1 1 calc(50% - 10px);
                }
            }

            @media (max-width: 600px) {
                .exam-card {
                    flex: 1 1 100%;
                }
            }


            .exam-card {
                flex: 1 1 calc(25% - 10px);
                min-width: 200px;
                max-width: 300px;
                height: 250px;
                margin-right: 10px;
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

        </style>
    <div class="container">
        <div class="exams-panel">
            @php
                $exams = \App\Models\QuestionBankType::all();
            @endphp
            @forelse($exams as $exam)
                <div class="exam-card" data-exam-id="{{ $exam->id }}">
                    <div class="exam-content">
                        <div class="exam-name">{{ $exam->name[app()->getLocale()] }}</div>
                        <div class="exam-meta">
                            <span>{{ $exam->questions_count ?? 0 }} Questions</span>
                        </div>
                        <a href="{{ route('admin.evaluation.result' , $exam->id ) }}" class="view-questions-btn" >
                            View Questions
                        </a>
                    </div>
                </div>
            @empty
                <div class="no-content">
                    📝 No exams available
                </div>
            @endforelse

        </div>
    </div>
@endsection

