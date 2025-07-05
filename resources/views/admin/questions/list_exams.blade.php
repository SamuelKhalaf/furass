<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
            min-height: 100vh;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .dashboard-title {
            color: #2c3e50;
            font-weight: 600;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .dashboard-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .exam-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .exam-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            text-align: center;
        }

        .exam-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .exam-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 1rem;
        }

        .exam-name {
            color: #2c3e50;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .exam-description {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .exam-button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            width: 100%;
        }

        .exam-button:hover {
            background: #0056b3;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }

        .exam-button:active {
            transform: translateY(0);
        }


        @media (max-width: 768px) {
            .dashboard-title {
                font-size: 2rem;
            }

            .exam-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 0 0.5rem;
            }

            .exam-card {
                padding: 1.5rem;
            }

            .exam-icon {
                font-size: 2.5rem;
            }

            .exam-name {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem 0;
            }

            .dashboard-header {
                margin-bottom: 2rem;
            }

            .dashboard-title {
                font-size: 1.8rem;
            }

            .exam-card {
                padding: 1.2rem;
            }

            .exam-button {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="dashboard-header">
        <h1 class="dashboard-title">
            <i class="fas fa-graduation-cap me-3"></i>
            My Exams
        </h1>
        <p class="dashboard-subtitle">Select an exam to start your evaluation</p>
    </div>

    <div class="exam-grid">
        @isset($banks)
            @foreach($banks as $bank)

                <div class="exam-card">
                    <div class="exam-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3 class="exam-name">{{$bank->name[app()->getLocale()] ?? ''}}</h3>
                    <a href="#" class="exam-button">
                        <i class="fas fa-play me-2"></i>
                        Start Exam
                    </a>
                </div>
            @endforeach
        @endisset
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>

    // Add some interactive feedback
    document.querySelectorAll('.exam-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.borderColor = '#007bff';
        });

        card.addEventListener('mouseleave', function() {
            this.style.borderColor = '#e9ecef';
        });
    });
</script>
</body>
</html>
