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
                    <tr>
                        <td style="padding: 40px 40px 30px; text-align: center; border-bottom: 1px solid rgba(218, 165, 32, 0.2);">
                            <h1 style="margin: 0; color: #DAA520; font-size: 28px; font-weight: 700;">MashouraX</h1>
                            <p style="margin: 8px 0 0; color: #888; font-size: 14px;">Virtual Advising Platform</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 40px; color: #ffffff;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <div style="display: inline-block; padding: 12px 24px; background: rgba(34, 197, 94, 0.2); border-radius: 50px; border: 1px solid rgba(34, 197, 94, 0.4);">
                                    <span style="color: #22c55e; font-size: 14px; font-weight: 600;">✓ CONFIRMED</span>
                                </div>
                            </div>
                            
                            <h2 style="margin: 0 0 20px; color: #DAA520; font-size: 24px; text-align: center;">Meeting Confirmed</h2>
                            
                            <p style="margin: 0 0 30px; color: #cccccc; line-height: 1.6; font-size: 16px;">
                                Hi <?php echo htmlspecialchars($user_name); ?>,
                            </p>
                            
                            <p style="margin: 0 0 30px; color: #cccccc; line-height: 1.6; font-size: 16px;">
                                Your advising session has been confirmed. We look forward to helping you succeed!
                            </p>
                            
                            <!-- Meeting Details Card -->
                            <div style="margin: 30px 0; padding: 25px; background: linear-gradient(135deg, rgba(218, 165, 32, 0.1), rgba(218, 165, 32, 0.05)); border-radius: 10px; border: 1px solid rgba(218, 165, 32, 0.3);">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding: 12px 0; border-bottom: 1px solid rgba(218, 165, 32, 0.2);">
                                            <p style="margin: 0; color: #888; font-size: 13px;">TITLE</p>
                                            <p style="margin: 5px 0 0; color: #fff; font-size: 16px; font-weight: 600;"><?php echo htmlspecialchars($meeting_title); ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px 0; border-bottom: 1px solid rgba(218, 165, 32, 0.2);">
                                            <p style="margin: 0; color: #888; font-size: 13px;">DATE & TIME</p>
                                            <p style="margin: 5px 0 0; color: #DAA520; font-size: 16px; font-weight: 600;">📅 <?php echo htmlspecialchars($meeting_date); ?> at <?php echo htmlspecialchars($meeting_time); ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px 0;">
                                            <p style="margin: 0; color: #888; font-size: 13px;">ADVISOR</p>
                                            <p style="margin: 5px 0 0; color: #fff; font-size: 16px; font-weight: 600;">👤 <?php echo htmlspecialchars($advisor_name); ?></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <?php if (!empty($meeting_link)): ?>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 20px 0;">
                                        <a href="<?php echo htmlspecialchars($meeting_link); ?>" 
                                           style="display: inline-block; padding: 16px 40px; background-color: #DAA520; color: #000; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">
                                            Join Meeting
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <?php endif; ?>
                            
                            <div style="margin: 30px 0; padding: 20px; background-color: #0f0f0f; border-radius: 8px; border: 1px solid rgba(218, 165, 32, 0.2);">
                                <h4 style="margin: 0 0 12px; color: #DAA520; font-size: 16px;">📝 Before Your Meeting</h4>
                                <ul style="margin: 0; padding-left: 20px; color: #aaa; line-height: 1.8;">
                                    <li>Prepare any questions you'd like to discuss</li>
                                    <li>Review your academic progress</li>
                                    <li>Test your internet connection and camera</li>
                                </ul>
                            </div>
                            
                            <p style="margin: 30px 0 0; color: #888; text-align: center; font-size: 13px;">
                                Need to reschedule? <a href="<?php echo $website_url; ?>/meetings/manage.php?id=<?php echo $meeting_id; ?>" style="color: #DAA520; text-decoration: none;">Manage this meeting</a>
                            </p>
                        </td>
                    </tr>
                    
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