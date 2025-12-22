<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #0a0a0a;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #0a0a0a; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #1a1a1a; border-radius: 12px; overflow: hidden; border: 1px solid rgba(218, 165, 32, 0.2);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 30px; text-align: center; border-bottom: 1px solid rgba(218, 165, 32, 0.2);">
                            <h1 style="margin: 0; color: #DAA520; font-size: 28px; font-weight: 700;">MashouraX</h1>
                            <p style="margin: 8px 0 0; color: #888; font-size: 14px;">Virtual Advising Platform</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px; color: #ffffff;">
                            <h2 style="margin: 0 0 20px; color: #DAA520; font-size: 24px;">Verify Your Email Address</h2>
                            
                            <p style="margin: 0 0 20px; color: #cccccc; line-height: 1.6; font-size: 16px;">
                                Hi <?php echo htmlspecialchars($user_name); ?>,
                            </p>
                            
                            <p style="margin: 0 0 30px; color: #cccccc; line-height: 1.6; font-size: 16px;">
                                Welcome to MashouraX! Please verify your email address to activate your account and start your journey with us.
                            </p>
                            
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 20px 0;">
                                        <a href="<?php echo htmlspecialchars($verify_url); ?>" 
                                           style="display: inline-block; padding: 16px 40px; background-color: #DAA520; color: #000; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">
                                            Verify Email Address
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 30px 0 20px; color: #888; line-height: 1.6; font-size: 14px;">
                                Or copy and paste this link into your browser:
                            </p>
                            
                            <p style="margin: 0 0 30px; padding: 12px; background-color: #0f0f0f; border-radius: 6px; color: #DAA520; font-size: 13px; word-break: break-all; border: 1px solid rgba(218, 165, 32, 0.2);">
                                <?php echo htmlspecialchars($verify_url); ?>
                            </p>
                            
                            <p style="margin: 0; color: #888; line-height: 1.6; font-size: 14px;">
                                This link will expire in <?php echo $expiry_hours; ?> hours. If you didn't create an account with MashouraX, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; text-align: center; border-top: 1px solid rgba(218, 165, 32, 0.2); background-color: #0f0f0f;">
                            <p style="margin: 0 0 10px; color: #666; font-size: 12px;">
                                © 2025 MashouraX. All rights reserved.
                            </p>
                            <p style="margin: 0; color: #666; font-size: 12px;">
                                <a href="<?php echo $website_url; ?>/privacy.php" style="color: #DAA520; text-decoration: none;">Privacy Policy</a> | 
                                <a href="<?php echo $website_url; ?>/contact.php" style="color: #DAA520; text-decoration: none;">Contact Support</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>