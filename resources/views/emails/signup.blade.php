<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>State Life Email Verification</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0a3d62; padding:20px; text-align:center;">

                            <img src="{{ asset('frontend/images/logo.png') }}"
                                width="120"
                                style="margin-bottom:10px;">

                            <h2 style="color:#ffffff; margin:0;">State Life Insurance</h2>
                            <p style="color:#dcdde1; margin:5px 0 0;">Email Verification Required</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333;">

                            <h3>Hi {{ $user->name }}</h3>

                            <p>
                                Thank you for registering with <b>State Life Insurance Corporation</b>.
                                Please verify your email address to activate your account.
                            </p>

                            <p>
                                Your registered email:
                                <b>{{ $user->email }}</b>
                            </p>

                            <!-- Info Box -->
                            <div style="background:#f1f2f6; padding:15px; border-radius:8px; margin-top:20px;">
                                <p style="margin:0;">
                                    ✔ Secure your account<br>
                                    ✔ Activate full access<br>
                                    ✔ Required for login confirmation
                                </p>
                            </div>

                            <!-- VERIFY BUTTON -->
                            <div style="text-align:center; margin-top:30px;">
                                <a href="{{ $url }}"
                                    style="background:#0a3d62; color:#fff; padding:12px 25px; 
                    text-decoration:none; border-radius:5px; display:inline-block;">
                                    Verify Email Address
                                </a>
                            </div>

                            <p style="margin-top:25px; font-size:13px; color:#888;">
                                If you did not create this account, you can ignore this email.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#ecf0f1; text-align:center; padding:15px; font-size:12px; color:#555;">
                            © {{ date('Y') }} State Life Insurance Corporation of Pakistan. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>