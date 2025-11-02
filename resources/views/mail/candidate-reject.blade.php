<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Update</title>
</head>

<body style="margin:0; padding:0; font-family:'Segoe UI', Arial, sans-serif; background-color:#f7f9fc; color:#333;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:40px 0;">
        <tr>
            <td align="center">
                <!-- Main Card -->
                <table width="650" cellpadding="0" cellspacing="0" border="0"
                    style="background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 8px 28px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background: linear-gradient(135deg, #ff4d4d, #e63946); padding:35px 20px;">
                            <h1 style="margin:0; font-size:22px; font-weight:700; color:#fff;">
                                ❌ Application Update
                            </h1>
                            <p style="margin:10px 0 0; font-size:15px; color:#ffeaea;">
                                Thank you for applying with us
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px 40px; font-size:15px; line-height:1.7; color:#444;">
                            <p style="margin:0;">Hi <strong>{{ $mailData['candidate'] }}</strong>,</p>
                            <p style="margin:12px 0 0;">
                                We truly appreciate the time and effort you invested in applying for the role of
                                <strong>{{ $mailData['job'] }}</strong> at
                                <strong>{{ $mailData['employer'] }}</strong>.
                            </p>
                            <p style="margin:12px 0 0;">
                                After careful consideration, we regret to inform you that your application was not
                                selected for further process at this time.
                            </p>
                            <p style="margin:12px 0 0;">
                                Please don’t be discouraged — we encourage you to apply for future opportunities that
                                match your skills and experience.
                            </p>
                        </td>
                    </tr>

                    <!-- Closing -->
                    <tr>
                        <td style="padding:0 40px 30px; font-size:15px; color:#444;">
                            <p style="margin:0;">We wish you all the very best in your career journey. 🌟</p>
                            <p style="margin:12px 0 0;">Sincerely,<br>
                                <strong>{{ $mailData['employer'] }}</strong> Team
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding:20px 30px; text-align:center; font-size:13px; color:#888; background:#f5f6f9; border-top:1px solid #e6e8ef;">
                            <p style="margin:0;">This is an automated email from <strong>Your Job Portal</strong>.</p>
                            <p style="margin:4px 0 0;">Please do not reply directly to this message.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>