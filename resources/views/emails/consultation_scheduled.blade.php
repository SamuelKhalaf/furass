<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consultation Scheduled</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; margin:20px auto; border-collapse:collapse;">
                <!-- Header -->
                <tr>
                    <td align="center" bgcolor="#4f46e5" style="padding:20px; color:#ffffff;">
                        <h1 style="margin:0; font-size:24px;">Consultation Scheduled</h1>
                        <p style="margin:5px 0 0;">Your consultation session has been scheduled successfully</p>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:30px; background-color:#f9fafb; color:#333;">
                        <p>Dear {{ $studentName }},</p>
                        <p>We're pleased to inform you that your consultation session has been scheduled. Please find the details below:</p>

                        <table width="100%" cellpadding="10" cellspacing="0" border="0" style="background-color:#ffffff; border-left:4px solid #4f46e5; margin:20px 0;">
                            <tr>
                                <td style="font-weight:bold; color:#4f46e5; width:140px;">Program:</td>
                                <td>{{ $programTitle }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold; color:#4f46e5;">Consultant:</td>
                                <td>{{ $consultantName }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold; color:#4f46e5;">Date:</td>
                                <td>{{ $scheduledDate }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold; color:#4f46e5;">Time:</td>
                                <td>{{ $scheduledTime }}</td>
                            </tr>
                            @if($meetingPassword)
                            <tr>
                                <td style="font-weight:bold; color:#4f46e5;">Password:</td>
                                <td>{{ $meetingPassword }}</td>
                            </tr>
                            @endif
                        </table>

                        <!-- Important Note -->
                        <table width="100%" cellpadding="10" cellspacing="0" border="0" style="background-color:#fef3c7; border:1px solid #f59e0b; margin:20px 0;">
                            <tr>
                                <td><strong>Important:</strong> You can join the meeting 15 minutes before the scheduled time.</td>
                            </tr>
                        </table>

                        <!-- Join Button -->
                        <table width="100%" cellpadding="10" cellspacing="0" border="0">
                            <tr>
                                <td align="center">
                                    <a href="{{ $joinUrl }}" style="background-color:#10b981; color:#ffffff; padding:12px 24px; text-decoration:none; border-radius:4px; display:inline-block; font-weight:bold;">Join Consultation Meeting</a>
                                </td>
                            </tr>
                        </table>

                        <p>Best regards,<br>The Consultation Team</p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="padding:20px; font-size:12px; color:#6b7280; border-top:1px solid #e5e7eb;">
                        <p style="margin:0;">This is an automated message. Please do not reply to this email.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
