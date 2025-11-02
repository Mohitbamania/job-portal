<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Contact Message</title>
</head>

<body style="margin:0; padding:0; font-family: 'Segoe UI', Arial, sans-serif; background-color:#f4f6f9; color:#333;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:30px 0;">
    <tr>
      <td align="center">
        <!-- Main Container -->
        <table width="600" cellpadding="0" cellspacing="0" border="0"
          style="background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.07);">

          <!-- Header -->
          <tr>
            <td align="center" style="background:linear-gradient(135deg, #004aad, #007bff); padding:25px;">
              <h2 style="margin:0; font-size:22px; color:#fff; font-weight:600;">
                📩 You’ve Got a New Contact Message
              </h2>
            </td>
          </tr>

          <!-- Info Section -->
          <tr>
            <td style="padding:25px 30px; font-size:15px; line-height:1.6; color:#444;">
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e5e5e5; border-radius:8px; background:#fafafa;">
                <tr>
                  <td style="padding:12px 20px; border-bottom:1px solid #eee;">
                    <strong style="color:#004aad;">Name:</strong> {{ $mailData['name'] }}
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 20px; border-bottom:1px solid #eee;">
                    <strong style="color:#004aad;">Email:</strong> {{ $mailData['email'] }}
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 20px;">
                    <strong style="color:#004aad;">Subject:</strong> {{ $mailData['subject'] }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Message Section -->
          <tr>
            <td style="padding:0 30px 25px; font-size:15px; line-height:1.6; color:#444;">
              <p style="margin:0 0 8px; font-weight:600; color:#222;">Message:</p>
              <div style="background:#f8faff; padding:18px; border-left:4px solid #004aad; border-radius:6px; font-size:14px; line-height:1.6;">
                {{ $mailData['message'] }}
              </div>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:18px 30px; text-align:center; font-size:13px; color:#777; background:#f9f9f9; border-top:1px solid #eee;">
              <p style="margin:0;">This message was submitted via the <strong>Contact Form</strong> on your website.</p>
              <p style="margin:4px 0 0;">Please do not reply directly to this email.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
