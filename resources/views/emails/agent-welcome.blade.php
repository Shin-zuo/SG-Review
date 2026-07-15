<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the SG-Review Ambassador Network</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7fb; color: #1e293b; margin: 0; padding: 0; }
        .email-wrapper { width: 100%; background-color: #f4f7fb; padding: 40px 15px; }
        .email-container { max-w: 600px; width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .email-header { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); padding: 35px 30px; text-align: center; color: #ffffff; }
        .email-header h1 { margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
        .email-header p { margin: 8px 0 0; font-size: 15px; opacity: 0.9; }
        .email-body { padding: 40px 35px; }
        .greeting { font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 16px; }
        .content-text { font-size: 15px; line-height: 1.7; color: #475569; margin-bottom: 24px; }
        .code-box { background-color: #eff6ff; border: 2px dashed #3b82f6; border-radius: 12px; padding: 25px; text-align: center; margin: 30px 0; }
        .code-label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #2563eb; margin-bottom: 8px; }
        .code-value { font-size: 28px; font-weight: 900; color: #1e3a8a; letter-spacing: 2px; font-family: monospace; }
        .commission-banner { background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 18px 22px; border-radius: 0 10px 10px 0; margin-bottom: 30px; }
        .commission-title { font-size: 16px; font-weight: 800; color: #15803d; margin-bottom: 6px; }
        .commission-text { font-size: 14px; color: #166534; margin: 0; line-height: 1.6; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .info-table th { text-align: left; padding: 12px 15px; background-color: #f8fafc; font-size: 13px; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; width: 35%; }
        .info-table td { padding: 12px 15px; font-size: 14px; color: #0f172a; font-weight: 600; border-bottom: 1px solid #e2e8f0; }
        .email-footer { background-color: #f8fafc; padding: 25px 35px; text-align: center; font-size: 13px; color: #64748b; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>SG-Review Partnership</h1>
                <p>Official Ambassador & Agent Network</p>
            </div>
            
            <div class="email-body">
                <div class="greeting">Hello {{ $agent->name }}, welcome to the team! 🎉</div>
                <p class="content-text">
                    Thank you for partnering with <strong>SG-Review</strong>! We are thrilled to welcome you as an official Ambassador. Together, we are committed to providing topnotch, high-yield PRC board exam review materials to aspiring professionals nationwide while helping you build a sustainable income stream.
                </p>
                
                <div class="code-box">
                    <div class="code-label">Your Official Referral Code</div>
                    <div class="code-value">{{ $agent->agent_code }}</div>
                </div>
                
                <div class="commission-banner">
                    <div class="commission-title">💰 Your Partnership Rate: 10% Direct Commission</div>
                    <p class="commission-text">
                        Every time a student enrolls in any of our comprehensive review courses and inputs or mentions your unique referral code (<strong>{{ $agent->agent_code }}</strong>) during checkout, you automatically earn a <strong>10% commission</strong> on their total tuition fee! Payouts are credited fast directly via GCash or bank transfer upon student verification.
                    </p>
                </div>

                <h3 style="font-size: 16px; color: #0f172a; margin-top: 30px; margin-bottom: 10px;">Your Registered Information</h3>
                <table class="info-table">
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $agent->name }}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>{{ $agent->email }}</td>
                    </tr>
                    <tr>
                        <th>Contact Number</th>
                        <td>{{ $agent->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Facebook Profile</th>
                        <td>{{ $agent->facebook_link ? $agent->facebook_link : 'Not provided' }}</td>
                    </tr>
                </table>
                
                <p class="content-text" style="margin-top: 30px;">
                    Start sharing your referral code today! If you have any questions, promotional material requests, or payment inquiries, simply reply directly to this email or reach out to our ambassador support team.
                </p>
                
                <p style="margin-top: 30px; font-size: 15px; color: #0f172a; font-weight: 700;">
                    To your success,<br>
                    <span style="color: #2563eb; font-weight: 800;">The SG-Review Team</span>
                </p>
            </div>
            
            <div class="email-footer">
                &copy; {{ date('Y') }} SG-Review. All rights reserved.<br>
                Ace Your PRC Exam on the First Try.
            </div>
        </div>
    </div>
</body>
</html>
