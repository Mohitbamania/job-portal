<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Notification Email</title>
</head>

<body style="margin:0; padding:0; font-family: 'Segoe UI', Arial, sans-serif; background-color:#f4f6fa; color:#333;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:40px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="650" cellpadding="0" cellspacing="0" border="0"
                    style="background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 8px 25px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #004aad, #0077ff); padding:30px;">
                            <h1 style="margin:0; font-size:24px; font-weight:600; color:#fff;">
                                📩 New Job Application Received
                            </h1>
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="padding:25px 35px; font-size:15px; line-height:1.7; color:#444;">
                            <p style="margin:0;">Hi <strong>{{$mailData['employer']->name}}</strong>,</p>
                            <p style="margin:12px 0 0;">Great news! A candidate has applied for one of your posted jobs.
                            </p>
                        </td>
                    </tr>

                    <!-- Job Details -->
                    <tr>
                        <td style="padding:0 35px 20px;">
                            <div
                                style="border:1px solid #e0e6f1; border-radius:10px; background:#f9fbff; padding:18px 22px; font-size:15px; color:#333;">
                                <strong style="color:#004aad;">💼 Job Title:</strong>
                                <span>{{$mailData['job']->title}}</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Applicant Details -->
                    <tr>
                        <td style="padding:0 35px 30px;">
                            <p style="margin:0 0 14px; font-size:16px; font-weight:600; color:#222;">👤 Applicant
                                Information</p>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="border:1px solid #e0e6f1; border-radius:10px; background:#fafafa;">
                                <tr>
                                    <td style="padding:14px 22px; font-size:15px; border-bottom:1px solid #eee;">
                                        <strong>Name:</strong> {{$mailData['user']->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 22px; font-size:15px; border-bottom:1px solid #eee;">
                                        <strong>Email:</strong> {{$mailData['user']->email}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 22px; font-size:15px;">
                                        <strong>📱 Mobile:</strong> {{$mailData['user']->mobile}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 22px; font-size:15px;">
                                        <strong>📄 Resume:</strong>
                                        <a href="{{ asset($mailData['user']->resume) }}" download
                                            style="background:#004aad; color:#fff; text-decoration:none; font-weight:600; padding:8px 14px; border-radius:6px; display:inline-block;"
                                            target="_blank">
                                            ⬇ Download Resume
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding:20px 30px; text-align:center; font-size:13px; color:#777; background:#f1f4f9; border-top:1px solid #e5e8ef;">
                            <p style="margin:0;">This is an automated email from <strong>Your Job Portal</strong>.</p>
                            <p style="margin:4px 0 0;">Please do not reply directly to this email.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>