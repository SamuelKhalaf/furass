<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Verification Code</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; margin:20px auto; border-collapse:collapse;">
                <!-- Header -->
                <tr>
                    <td align="center" bgcolor="#5b3c88" style="padding:20px; color:#ffffff;">
                        <h1 style="margin:0; font-size:24px;">Email Verification Code</h1>
                        <p style="margin:5px 0 0;">Partnership Request Verification</p>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:30px; background-color:#f9fafb; color:#333;">
                        @if($name)
                        <p>Dear {{ $name }},</p>
                        @else
                        <p>Hello,</p>
                        @endif
                        <p>Thank you for requesting a partnership with us. Please use the verification code below to verify your email address:</p>

                        <!-- Verification Code Box -->
                        <table width="100%" cellpadding="20" cellspacing="0" border="0" style="background-color:#ffffff; border:2px solid #5b3c88; margin:20px 0; border-radius:8px;">
                            <tr>
                                <td align="center">
                                    <div style="font-size:32px; font-weight:bold; color:#5b3c88; letter-spacing:8px; font-family:'Courier New', monospace;">
                                        {{ $verificationCode }}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <!-- Important Note -->
                        <table width="100%" cellpadding="10" cellspacing="0" border="0" style="background-color:#fef3c7; border:1px solid #f59e0b; margin:20px 0;">
                            <tr>
                                <td><strong>Important:</strong> This verification code will expire in 10 minutes. Please do not share this code with anyone.</td>
                            </tr>
                        </table>

                        <p>If you did not request this verification code, please ignore this email.</p>

                        <p>Best regards,<br>Furass Team</p>
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


