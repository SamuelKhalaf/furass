<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consultation Completed</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; margin:20px auto; border-collapse:collapse;">
                <!-- Header -->
                <tr>
                    <td align="center" bgcolor="#10b981" style="padding:20px; color:#ffffff;">
                        <h1 style="margin:0; font-size:24px;">Consultation Completed</h1>
                        <p style="margin:5px 0 0;">Your consultation session has been successfully completed</p>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:30px; background-color:#f9fafb; color:#333;">
                        <p>Dear {{ $studentName }},</p>
                        <p>We're pleased to inform you that your consultation session has been successfully completed. Below are the details and notes from your session:</p>

                        <!-- Session Details -->
                        <table width="100%" cellpadding="10" cellspacing="0" border="0" style="background-color:#ffffff; border-left:4px solid #10b981; margin:20px 0;">
                            <tr>
                                <td style="font-weight:bold; color:#10b981; width:140px;">Program:</td>
                                <td>{{ $programTitle }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold; color:#10b981;">Consultant:</td>
                                <td>{{ $consultantName }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold; color:#10b981;">Session Date:</td>
                                <td>{{ $scheduledDate }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold; color:#10b981;">Session Time:</td>
                                <td>{{ $scheduledTime }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold; color:#10b981;">Completed On:</td>
                                <td>{{ $completedDate }} at {{ $completedTime }}</td>
                            </tr>
                        </table>

                        <!-- Consultation Notes -->
                        <div style="background-color:#ffffff; border:1px solid #e5e7eb; border-radius:8px; padding:20px; margin:20px 0;">
                            <h3 style="margin:0 0 15px; color:#10b981; font-size:18px;">Consultation Notes</h3>
                            <div style="background-color:#f9fafb; padding:15px; border-radius:4px; border-left:3px solid #10b981; line-height:1.6;">
                                {!! nl2br(e($consultationNotes->notes)) !!}
                            </div>
                        </div>

                        @if($hasReportPdf)
                            <!-- PDF Report Notice -->
                            <table width="100%" cellpadding="15" cellspacing="0" border="0" style="background-color:#dbeafe; border:1px solid #3b82f6; border-radius:8px; margin:20px 0;">
                                <tr>
                                    <td style="color:#1e40af;">
                                        <strong>📋 Consultation Report:</strong> A detailed PDF report has been attached to this email containing your consultation summary and recommendations.
                                    </td>
                                </tr>
                            </table>
                        @endif

                        <!-- Action Buttons -->
                        <table width="100%" cellpadding="20" cellspacing="0" border="0">
                            <tr>
                                <td align="center">
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="padding-right:10px;">
                                                <a href="{{ $viewNotesUrl }}" style="background-color:#10b981; color:#ffffff; padding:12px 24px; text-decoration:none; border-radius:4px; display:inline-block; font-weight:bold;">View Full Details</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- Next Steps -->
                        <table width="100%" cellpadding="15" cellspacing="0" border="0" style="background-color:#ecfdf5; border:1px solid #10b981; border-radius:8px; margin:20px 0;">
                            <tr>
                                <td>
                                    <h4 style="margin:0 0 10px; color:#059669;">🎉 Congratulations!</h4>
                                    <p style="margin:0; color:#047857;">You have successfully completed this consultation step. Your progress has been updated and the next step in your learning path has been unlocked.</p>
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
