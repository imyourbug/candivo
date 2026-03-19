<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DI Tools Free Package - Welcome</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Inter",
                "Helvetica Neue", Arial, sans-serif;
            line-height: 1;
            background: linear-gradient(135deg, #0f3f76 0%, #0a2f5e 100%);
            padding: 20px;
        }

        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #c7d7ea;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #0f3f76 0%, #6db3d8 100%);
            padding: 50px 30px;
            color: white;
            position: relative;
            text-align: center;
        }

        .header h1 {
            margin: 0 0 12px 0;
            font-size: 42px;
            font-weight: 700;
        }

        .header p {
            font-size: 16px;
            opacity: 0.95;
            margin: 0;
        }

        .header-product-name {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 18px;
            background: rgba(255, 255, 255, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.45);
            border-radius: 999px;
            font-weight: 700;
            font-size: 1.25em;
            letter-spacing: 0.03em;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        }

        .product-name {
            color: #0a2f5e;
            font-weight: 700;
            font-size: 1.12em;
            letter-spacing: 0.025em;
            border-bottom: 2px solid #6db3d8;
            padding-bottom: 1px;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .section {
            margin-bottom: 35px;
            border: 1px solid #d7e3f1;
            border-radius: 10px;
            padding: 16px 18px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #0f3f76;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0f3f76;
            display: inline-block;
        }

        .features {
            list-style: none;
            margin: 15px 0;
        }

        .features li {
            padding: 10px 0;
            padding-left: 0;
            position: relative;
            color: #555;
            font-size: 15px;
            line-height: 1;
        }

        .features li:before {
            /* Most email clients do not reliably support pseudo-elements (:before). */
            content: "" !important;
            display: none !important;
        }

        .feature-check {
            display: inline-block;
            width: 20px;
            color: #0f3f76;
            font-weight: bold;
            font-size: 18px;
            line-height: 1;
            margin-right: 8px;
            vertical-align: middle;
        }

        .action-buttons {
            display: flex;
            justify-content: space-evenly !important;
            align-items: center;
            gap: 12px;
            margin-top: 25px;
            width: 100%;
            flex-wrap: wrap;
            color: #ffffff;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            flex: 1;
            min-width: 150px;
            max-width: 200px;
        }

        /* Prevent .btn flex stretching so space-between works as intended */
        .action-buttons .btn {
            flex: 0 0 auto !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0f3f76 0%, #0a2f5e 100%);
            color: white !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 63, 118, 0.4);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #0f3f76;
            border: 2px solid #0f3f76;
        }

        .btn-secondary:hover {
            background: #0f3f76;
            color: white;
        }

        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 30px 0;
        }

        .support-section {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #d7e3f1;
            border-radius: 8px;
            margin-top: 25px;
        }

        .support-section p {
            color: #666;
            font-size: 14px;
            line-height: 1.2;
        }

        .footer {
            background: #f5f5f5;
            padding: 30px;
            border-top: 1px solid #d7e3f1;
            text-align: center;
            color: #999;
            font-size: 12px;
            line-height: 1.2;
        }

        .footer-brand {
            color: #0f3f76;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .footer-links {
            margin-top: 15px;
        }

        .footer-links a {
            color: #0f3f76;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .emoji {
            margin: 0 5px;
        }

        @media (max-width: 600px) {
            .content {
                padding: 25px 20px;
            }

            .header {
                padding: 30px 20px;
            }

            .header-logo {
                width: 90px;
            }

            .header h1 {
                font-size: 28px;
            }

            .header p {
                font-size: 14px;
            }

            .action-buttons {
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .btn {
                padding: 12px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    @php
        $version = $firstItemPeriod ?: 'Latest';
    @endphp
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>🎉 Welcome to DI Tools</h1>
                <p>
                    <span class="header-product-name">{{ $firstItemName ?? '' }}</span>
                    <span style="opacity: 0.95"> for Autodesk Inventor</span>
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                <p>Hello <strong>{{ $customerName ?? '' }}</strong>,</p>
                <p style="margin-top: 15px">
                    Thank you for requesting the
                    <strong class="product-name">{{ $firstItemName ?? '' }}</strong>.
                    We have received your information and this email contains everything
                    you need to get started.
                </p>
            </div>

            <!-- What's Included -->
            <div class="section">
                <div class="section-title">📦 What's Included</div>
                <ul class="features">
                    <li>
                        <span class="feature-check">✓</span><span
                            class="product-name">{{ $firstItemName ?? 'DI Tools Free Package' }}</span> (compatible
                        with
                        Inventor {{ $version ?? '' }})
                    </li>
                    <li>
                        <span class="feature-check">✓</span>Quick setup and installation guide
                    </li>
                    <li>
                        <span class="feature-check">✓</span>Basic usage notes to help you get started
                    </li>
                </ul>
            </div>

            <div class="section">
                <div class="section-title">📝 Request Information</div>
                <ul class="features">
                    <li>
                        <span class="feature-check">✓</span>Customer name: {{ $customerName ?? 'Customer' }}
                    </li>
                    <li>
                        <span class="feature-check">✓</span>Selected item:
                        <span class="product-name">{{ $firstItemName ?? 'DI Tools Free Package' }}</span>
                    </li>
                    <li>
                        <span class="feature-check">✓</span>Selected version: Inventor {{ $version ?? '' }}
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="https://cadinvo.shop/di-products/di-tools/6monthsfree/" class="btn btn-primary">
                    <span class="emoji">⬇️</span> Download DI-Tools (6 months free)
                </a>
                <a href="https://cadinvo.shop/di-products/di-tools/schedule/" class="btn btn-secondary">
                    <span class="emoji">📅</span> Schedule a Meeting
                </a>
                <a href="https://www.youtube.com/playlist?list=PLY_JFFRWFisYI1TTPDkNcH3RIhkaj4e9t"
                    class="btn btn-secondary">
                    <span class="emoji">▶️</span> YouTube Instruction Playlist
                </a>
            </div>

            <!-- Support Section -->
            <div class="support-section">
                <p><strong>Need Help?</strong></p>
                <p style="margin-top: 10px">
                    If you have any questions during installation or use, feel free to
                    reply to this email. Our support team is happy to help.
                </p>
            </div>

            <div class="divider"></div>

            <!-- Closing -->
            <div style="text-align: left; color: #666; margin-top: 20px">
                <p><strong>Best regards,</strong></p>
                <p
                    style="
              margin-top: 10px;
              font-size: 16px;
              color: #667eea;
              font-weight: 600;
            ">
                    CADINVO Team
                </p>
                <p style="margin-top: 15px; font-size: 13px; color: #999">
                    DI Tools for Autodesk Inventor
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">🌐 cadinvo.com</div>
            <p>© 2026 CADINVO. All rights reserved.</p>
            <div class="footer-links">
                <a href="https://cadinvo.com">Website</a> |
                <a href="mailto:support@cadinvo.com">Support</a>
            </div>
        </div>
    </div>
</body>

</html>
