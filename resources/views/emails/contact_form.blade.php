<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You for Contacting Us</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; margin:20px auto; border-collapse:collapse;">
                <!-- Header -->
                <tr>
                    <td align="center" bgcolor="#5b3c88" style="padding:20px; color:#ffffff;">
                        <h1 style="margin:0; font-size:24px;">Thank You for Contacting Us</h1>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:30px; background-color:#f9fafb; color:#333;">
                        <p>Dear {{ $name }},</p>
                        <p>Thank you for reaching out to us through our contact form. We have successfully received your message and appreciate you taking the time to get in touch with Furass.</p>

                        <p>Our team will review your inquiry and get back to you as soon as possible. We typically respond within 24-48 hours during business days.</p>

                        @if($userMessage)
                        <div style="background-color:#ffffff; border-left:4px solid #5b3c88; padding:15px; margin:20px 0; border-radius:4px;">
                            <p style="margin:0 0 10px 0; color:#5b3c88; font-weight:bold;">Your Message:</p>
                            <p style="margin:0; color:#333; white-space:pre-wrap;">{{ $userMessage }}</p>
                        </div>
                        @endif

                        <p>If you have any urgent questions or concerns, please feel free to contact us directly.</p>

                        <p>Best regards,<br><strong>Furass Team</strong></p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="padding:20px; font-size:12px; color:#6b7280; border-top:1px solid #e5e7eb;">
                        <p style="margin:0;">This is an automated confirmation email. Please do not reply to this message.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

