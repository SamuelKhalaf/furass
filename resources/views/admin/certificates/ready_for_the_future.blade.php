<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Completion</title>
    <style type="text/css">
        /* PDF-compatible font stack */
        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .certificate-container {
            width: 247mm;
            height: 160mm;
            max-height: 100%;
            padding: 15mm;
            border: 10mm solid #30197a;
            background-color: white;
            box-sizing: border-box;
            background-image: linear-gradient(to right, rgba(106, 13, 173, 0.05), rgba(0, 87, 184, 0.05));
            page-break-after: avoid;
        }
        .header {
            text-align: center;
            /*margin-bottom: 15mm;*/
            /*padding-top: 10mm;*/
        }
        .title {
            font-size: 19mm;
            color: #2f187a;
            text-transform: uppercase;
            line-height: 1.2;
            letter-spacing: 5px;
        }
        .subtitle {
            position: relative;
            font-size: 5mm;
            color: #fff;
            background-color: #a5b3f6;
            margin: 0 300px;
            padding: 10px 0;
            text-transform: uppercase;
            line-height: 0.8;
            letter-spacing: 5px;
        }
        /* Left triangle */
        .subtitle::before {
            content: "";
            position: absolute;
            top: 1.6%;
            left: -1px;
            transform: translateY(-50%);
            width: 0;
            height: 15px;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-left: 15px solid #fdfdfd;
        }

        /* Right triangle */
        .subtitle::after {
            content: "";
            position: absolute;
            top: 1.6%;
            right: -1px;
            transform: translateY(-50%);
            width: 0;
            height: 15px;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-right: 15px solid #FDFDFDFF;
        }
        .content {
            text-align: center;
        }
        .presented-to {
            font-size: 5mm;
            color: #52387f;
            margin-top: 50px;
        }
        .recipient-name {
            font-size: 8mm;
            font-weight: bold;
            color: #2f187a;
            margin: 30px 0 60px 0;
            display: inline-block;
            line-height: 1;
        }
        .custom-hr {
            height: 0.6mm;
            background-color: #bac5f7;
            border: none;
            margin: 0 180px 10px 180px;
        }
        .description {
            font-size: 18px;
            color: #52387f;
            text-align: center;
            line-height: 1;
        }
        .signatures-table {
            margin-top: 60px;
            width: 100%;
            /*padding: 0 25mm;*/
        }

        .signature {
            text-align: center;
            vertical-align: top;
            width: 50%;
        }

        .signature-line {
            width: 60mm;
            border-top: 0.5mm solid #bac5f7;
            margin: 10px auto 0;
        }

        .signature-title {
            margin-top: 10px;
            font-size: 5mm;
            color: #52387f;
        }

        .logo {
            position: absolute;
            top: 20mm;
            left: 20mm;
            max-width: 40mm;
            max-height: 40mm;
        }
        .page-break {
            page-break-after: always;
        }
        .avoid-break {
            page-break-inside: avoid;
        }
        @page {
            size: landscape;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="certificate-container avoid-break">
    <img src="{{ public_path('assets/imgs/template/furass-logo.png') }}" alt="Logo" class="logo">

    <div class="header">
        <div class="title">Certificate</div>
        <div class="subtitle">of Completion</div>
    </div>

    <div class="content">
        <div class="presented-to">presented to:</div>
        <div class="recipient-name">{{ $student->user->name }}</div>
        <hr class="custom-hr">
        <div class="description">
            For successfully completing the<span style="white-space: nowrap; font-weight: bold;font-size: 4mm;color: #2f187a;"> {{ $program->title_en }} </span>program,
        </div>
        <div class="description">
            gaining life skills in communication, confidence, and readiness
        </div>
        <div class="description">
            to navigate future challenges.
        </div>
    </div>

    <table class="signatures-table" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td class="signature" align="left" style="padding-right: 50px;">
                <div class="signature-line"></div>
                <div class="signature-title">Career Advisor</div>
            </td>
            <td align="center" style="width: 60px;">
                <div style="
                position: relative;
                bottom: 30px;
                right: 30px;
                width: 100px;
                height: 100px;
                border: 2px solid #fff;
                background-color: #52387f;
                border-radius: 50%;
                margin: auto;
            "></div>
            </td>
            <td class="signature" align="right" style="padding-left: 50px;">
                <div class="signature-line"></div>
                <div class="signature-title">CEO</div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
