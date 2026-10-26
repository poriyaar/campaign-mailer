<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
        style="background-color: #f3f4f6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); overflow: hidden;">

                    {{-- هدر --}}
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700;">
                                Campaign Mailer
                            </h1>
                        </td>
                    </tr>

                    {{-- محتوا --}}
                    <tr>
                        <td style="padding: 40px 30px;">

                            {{-- آیکون --}}
                            <div style="text-align: center; margin-bottom: 24px;">
                                <div
                                    style="display: inline-block; width: 64px; height: 64px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 50%; line-height: 64px; font-size: 32px;">
                                    ✉️
                                </div>
                            </div>

                            {{-- عنوان --}}
                            <h2
                                style="margin: 0 0 16px; color: #111827; font-size: 22px; font-weight: 700; text-align: center;">
                                Verify Your Email
                            </h2>

                            {{-- توضیح --}}
                            <p
                                style="margin: 0 0 32px; color: #6b7280; font-size: 15px; line-height: 1.6; text-align: center;">
                                Thanks for signing up! Use the code below to verify your email address.
                            </p>

                            {{-- کد --}}
                            <div style="text-align: center; margin-bottom: 32px;">
                                <div style="display: inline-block; background: #fef3c7; border: 2px dashed #f59e0b; border-radius: 12px; padding: 24px 32px; cursor: pointer;"
                                    title="Click to select, then Ctrl+C to copy">
                                    <div
                                        style="font-size: 42px; font-weight: 700; letter-spacing: 12px; color: #d97706; font-family: 'Courier New', monospace; user-select: all; -webkit-user-select: all; -moz-user-select: all; -ms-user-select: all; padding-left: 12px;">
                                        {{ $code }}
                                    </div>
                                </div>
                                <p style="margin: 12px 0 0; color: #9ca3af; font-size: 12px;">
                                    👆 Click the code to select it, then press <strong>Ctrl+C</strong> to copy
                                </p>
                            </div>

                            {{-- هشدار --}}
                            <p
                                style="margin: 0 0 32px; color: #9ca3af; font-size: 13px; text-align: center; line-height: 1.6;">
                                ⏱ This code will expire in <strong style="color: #f59e0b;">10 minutes</strong>.
                            </p>

                            {{-- متن پایانی --}}
                            <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                If you didn't request this code, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>

                    {{-- فوتر --}}
                    <tr>
                        <td
                            style="background-color: #f9fafb; padding: 24px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                © {{ date('Y') }} Campaign Mailer. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
