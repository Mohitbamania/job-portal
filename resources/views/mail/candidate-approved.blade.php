<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Approved</title>
</head>

<body style="margin:0; padding:0; font-family:'Segoe UI', Arial, sans-serif; background-color:#f4f7fb; color:#333;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:40px 0;">
        <tr>
            <td align="center">
                <!-- Main Card -->
                <table width="650" cellpadding="0" cellspacing="0" border="0"
                    style="background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 8px 28px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background: linear-gradient(135deg, #00c853, #4caf50); padding:35px 20px;">
                            <h1 style="margin:0; font-size:22px; font-weight:700; color:#fff;">
                                🎉 Congratulations, {{ $mailData['candidate'] }}!
                            </h1>
                            <p style="margin:10px 0 0; font-size:15px; color:#eaffea;">
                                Your application has been approved 🚀
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px 40px; font-size:15px; line-height:1.7; color:#444;">
                            <p style="margin:0;">Hi <strong>{{ $mailData['candidate'] }}</strong>,</p>
                            <p style="margin:12px 0 0;">
                                We’re thrilled to inform you that your job application has been
                                <strong style="color:#28a745;">Shortlisted</strong> by
                                <strong>{{ $mailData['employer'] }}</strong> for the role of
                                <strong>{{ $mailData['job'] }}</strong>.
                            </p>
                        </td>
                    </tr>

                    <!-- Interview Card -->
                    <tr>
                        <td style="padding:0 40px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="border:1px solid #e0e6f1; border-radius:12px; background:#fdfefe;">
                                <tr>
                                    <td
                                        style="padding:16px 22px; font-size:16px; font-weight:600; color:#222; background:#f5f9ff; border-bottom:1px solid #e6ecf5; border-radius:12px 12px 0 0;">
                                        📅 Interview Schedule
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 22px; font-size:15px; border-bottom:1px solid #f0f0f0;">
                                        <strong>Date:</strong> {{ $mailData['interview_date'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 22px; font-size:15px; border-bottom:1px solid #f0f0f0;">
                                        <strong>Time:</strong> {{ $mailData['interview_time'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 22px; font-size:15px;">
                                        <strong>Location / Mode:</strong> {{ $mailData['interview_mode'] }}
                                    </td>
                                </tr>
                            </table>
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