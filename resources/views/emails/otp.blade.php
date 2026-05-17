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

                            <h2 style="color:#ffffff; margin:0;">
                                State Life Insurance
                            </h2>

                            <p style="color:#dcdde1; margin:5px 0 0;">
                                Email Verification OTP
                            </p>

                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333;">

                            <h3>
                                Hi {{ $user->name }}
                            </h3>

                            <p>
                                Thank you for registering with
                                <b>State Life Insurance Corporation</b>.
                            </p>

                            <p>
                                Please use the following One-Time Password (OTP)
                                to verify your email address and activate your account.
                            </p>

                            <p>
                                Registered Email:
                                <b>{{ $user->email }}</b>
                            </p>

                            <!-- OTP BOX -->
                            <div style="
                                background:#f1f2f6;
                                border:2px dashed #0a3d62;
                                padding:25px;
                                border-radius:10px;
                                text-align:center;
                                margin-top:30px;
                            ">

                                <p style="
                                    margin:0;
                                    font-size:14px;
                                    color:#555;
                                    letter-spacing:1px;
                                ">
                                    YOUR VERIFICATION OTP
                                </p>

                                <h1 style="
                                    margin:15px 0 0;
                                    color:#0a3d62;
                                    font-size:40px;
                                    letter-spacing:8px;
                                ">
                                    {{ $otp }}
                                </h1>

                            </div>

                            <!-- Info -->
                            <div style="
                                background:#f8f9fa;
                                padding:15px;
                                border-radius:8px;
                                margin-top:25px;
                                font-size:14px;
                                color:#555;
                            ">

                                ✔ OTP valid for 5 minutes<br>
                                ✔ Do not share this OTP with anyone<br>
                                ✔ Required to activate your account

                            </div>

                            <p style="
                                margin-top:25px;
                                font-size:13px;
                                color:#888;
                            ">
                                If you did not create this account,
                                you can safely ignore this email.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="
                            background:#ecf0f1;
                            text-align:center;
                            padding:15px;
                            font-size:12px;
                            color:#555;
                        ">

                            © {{ date('Y') }}
                            State Life Insurance Corporation of Pakistan.
                            All rights reserved.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>