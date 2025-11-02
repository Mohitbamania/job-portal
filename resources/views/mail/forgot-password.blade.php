<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>

<body style="margin:0; padding:0; font-family: 'Segoe UI', Arial, sans-serif; background-color:#f4f6f9; color:#333;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:30px 0;">
        <tr>
            <td align="center">
                <!-- Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#004aad; padding:25px;">
                            <h1 style="margin:0; font-size:22px; color:#fff;">Password Reset Request</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px 30px; font-size:15px; line-height:1.6; color:#444;">
                            <p>Hello <strong>{{ $mailData['user']->name }}</strong>,</p>
                            <p>We received a request to reset your password. Click the button below to set a new
                                password:</p>
                        </td>
                    </tr>

                    <!-- Reset Button -->
                    <tr>
                        <td align="center" style="padding:20px 30px;">
                            <a href="{{ route('account.resetPassword', ['token' => $mailData['token']]) }}"
                                style="display:inline-block; padding:12px 24px; background:#004aad; color:#fff; text-decoration:none; font-size:15px; border-radius:6px; font-weight:500;">
                                Reset Password
                            </a>
                        </td>
                    </tr>

                    <!-- Extra Info -->
                    <tr>
                        <td style="padding:25px 30px; font-size:14px; color:#666;">
                            <p>If you did not request this, you can safely ignore this email. Your password will remain
                                unchanged.</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding:20px 30px; text-align:center; font-size:13px; color:#777; background:#f9f9f9; border-top:1px solid #eee;">
                            <p style="margin:0;">This email was sent by <strong>Your Application</strong>.</p>
                            <p style="margin:4px 0 0;">Please do not reply directly to this email.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>