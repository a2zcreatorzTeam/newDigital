<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - State Life</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend\images\favicon.jpg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
    /* Custom Properties for Consistency */
    :root {
        --primary-blue: #0056b3;
        --light-blue: #eef4fb;
        --text-dark: #333333;
        --text-muted: #666666;
        --success-green: #28a745;
        --white: #ffffff;
        --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    body {
        margin: 0;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background: var(--bg-gradient);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: var(--text-dark);
    }

    .page-wrapper {
        width: 100%;
        padding: 20px;
    }

    .success-container {
        max-width: 550px;
        margin: 0 auto;
    }

    .success-card {
        background: var(--white);
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    /* Icon Animation */
    .icon-circle {
        width: 80px;
        height: 80px;
        background-color: var(--success-green);
        color: white;
        font-size: 40px;
        line-height: 80px;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        animation: scaleUp 0.5s ease-out;
    }

    @keyframes scaleUp {
        0% {
            transform: scale(0);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    h1 {
        color: var(--primary-blue);
        margin-bottom: 10px;
        font-size: 28px;
    }

    .divider {
        border: none;
        border-top: 1px solid #eeeeee;
        margin: 25px 0;
    }

    /* Details Grid */
    .details-section {
        text-align: left;
        margin-bottom: 30px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #f0f0f0;
    }

    .detail-row span {
        color: var(--text-muted);
    }

    .amount {
        color: var(--primary-blue);
        font-size: 1.1em;
    }

    /* Buttons matching the theme */
    .button-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 20px;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background-color: var(--primary-blue);
        color: white;
    }

    .btn-primary:hover {
        background-color: #004494;
    }

    .btn-secondary {
        background-color: #f0f0f0;
        color: var(--text-dark);
    }

    .btn-secondary:hover {
        background-color: #e2e2e2;
    }

    .footer-note {
        font-size: 0.9em;
        color: var(--text-muted);
    }
</style>

<body>

    <div class="page-wrapper">
        <main class="success-container">
            <div class="success-card">

                <div class="card-header">
                    <div class="icon-circle">
                        <i class="fas fa-check"></i>
                    </div>
                    <h1>Payment Successful!</h1>
                    <p>Thank you for choosing the {{ $policy->product->name }}</p>
                </div>

                <hr class="divider">

                <div class="details-section">
                    <div class="detail-row">
                        <span>Transaction ID:</span>
                        <strong>#SLIC-992837465</strong>
                    </div>
                    <div class="detail-row">
                        <span>Date & Time:</span>
                        <strong>{{ \Carbon\Carbon::parse($policy->created_at)->format('M d, Y') }}</strong>
                    </div>
                    <div class="detail-row">
                        <span>Amount Paid:</span>
                        <strong class="amount">PKR 25,000.00</strong>
                    </div>
                    <div class="detail-row">
                        <span>Policy Holder:</span>
                        <strong>Shoaib Nasir</strong>
                    </div>
                </div>

                <div class="button-group">
                    <button class="btn btn-primary" onclick="window.print()">Download Receipt</button>
                    <a href="{{route('frontend.index')}}" class="btn btn-secondary">Back to Website</a>
                </div>

                <p class="footer-note">A confirmation email has been sent to your registered address.</p>
            </div>
        </main>
    </div>

</body>

</html>