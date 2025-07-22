<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>شهادة مشاركة</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            direction: rtl;
            margin: 40px;
            padding: 20px;
            background-color: #f9fafb;
            color: #333;
        }

        .certificate {
            background: #fff;
            border: 4px solid #4F46E5;
            padding: 40px;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .logo img {
            width: 80px;
            height: auto;
        }

        h1 {
            text-align: center;
            font-size: 28px;
            margin-top: 20px;
            color: #4F46E5;
        }

        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: #6B7280;
        }

        p {
            text-align: center;
            font-size: 14px;
        }

        .student-name {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 20px 0;
            color: #111827;
            border-bottom: 2px solid #4F46E5;
            display: inline-block;
            padding-bottom: 5px;
        }

        .program {
            display: inline-block;
            background: #4F46E5;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 14px;
        }

        .trip-details {
            margin: 30px 0;
            text-align: right;
            font-size: 14px;
            border-top: 1px solid #E5E7EB;
            border-bottom: 1px solid #E5E7EB;
            padding: 10px 0;
        }

        .trip-details div {
            margin-bottom: 8px;
        }

        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .sign-box {
            width: 30%;
        }

        .line {
            border-top: 1px solid #4F46E5;
            margin: 10px auto;
            width: 80%;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #6B7280;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="certificate">
    <!-- Logo Top Right -->
    <div class="logo1">
        <img src="{{ public_path('assets/imgs/template/furass-logo.png') }}" alt="Logo" style="width: 100px; margin-bottom: 10px;">
    </div>

    <!-- Title -->
    <h1>شهادة مشاركة</h1>
    <h2>في الحدث الاستكشافي المهني</h2>

    <!-- Student Info -->
    <p>تشهد منصة فرص للتوجيه المهني بأن الطالب/الطالبة:</p>
    <div class="student-name">{{ $student->user->name }}</div>
    <p>من {{ $student->school->user->name ?? 'المدرسة' }}</p>

    <!-- Program -->
    <div class="program">
        برنامج: {{ $program->{app()->getLocale() == 'ar' ? 'title_ar' : 'title_en'} }}
    </div>

    <p style="margin-top: 20px;">
        قد شارك/ت بنجاح في الحدث التالى:
    </p>

    <!-- Trip Details -->
    <div class="trip-details">
        <div><strong>اسم الحدث:</strong> {{ $event->event_name }}</div>
        <div><strong>الجهة المستضيفة:</strong> {{ $event->company_name }}</div>
        <div><strong>الموقع:</strong> {{ $event->location }}</div>
        <div><strong>تاريخ الحدث:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</div>
        <div><strong>تاريخ الحضور:</strong> {{ \Carbon\Carbon::parse($attendance->recorded_at)->format('d/m/Y') }}</div>
    </div>

    <p>
        ونشهد بأن الطالب/ة قد حضر/ت الحدث والتزم/ت بالتعليمات.
    </p>

    <!-- Signatures -->
    <div class="signatures">
        <div class="sign-box">
            <div class="line"></div>
            <div>المشرف الأكاديمي</div>
        </div>
        <div class="sign-box">
            <div class="line"></div>
            <div>منسق البرنامج</div>
        </div>
        <div class="sign-box">
            <div class="line"></div>
            <div>إدارة المنصة</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        تاريخ إصدار الشهادة: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>
</div>
</body>
</html>
