<?php
/**
 * Automated Social Links Update Script
 * This script will update all footer social media links across your project
 * 
 * INSTRUCTIONS:
 * 1. Save this file as "update_social_links.php" in your project root
 * 2. Run it once by visiting: http://localhost/update_social_links.php
 * 3. The script will backup and update all files automatically
 * 4. Delete this file after running it successfully
 */

// The new social links HTML to replace the old one
$newSocialLinks = <<<'HTML'
                <div class="social-links">
                    <!-- X (Twitter) Link -->
                    <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="social-link" title="Follow us on X (Twitter)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    
                    <!-- LinkedIn Link -->
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-link" title="Connect on LinkedIn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    
                    <!-- Facebook Link -->
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-link" title="Like us on Facebook">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    
                    <!-- YouTube Link -->
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="social-link" title="Subscribe on YouTube">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
HTML;

// Files to update
$filesToUpdate = [
    'index.php',
    'about.php',
    'contact.php',
    'pricing.php',
    'security.php',
    'trial.php',
    'ai-features.php',
    'analytics-dashboard.php',
    'chat-support.php',
    'mobile.php',
    'case-studies.php',
    'documentation.php',
    'webinars.php',
    'help-center.php',
    'privacy.php',
    'demo.php',
    'solutions-virtual-advising.php',
    'solutions-student-success.php',
    'solutions-academic-planning.php',
    'solutions-career-services.php'
];

// Pattern to match the old social links
$oldPattern = '/<div class="social-links">.*?<a href="#" class="social-link">𝕏<\/a>.*?<a href="#" class="social-link">in<\/a>.*?<a href="#" class="social-link">f<\/a>.*?<a href="#" class="social-link">▶<\/a>.*?<\/div>/s';

echo "<!DOCTYPE html>";
echo "<html><head><title>Social Links Update Script</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 1200px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
    .file-result { background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #007bff; border-radius: 5px; }
    h1 { color: #333; }
    .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin: 20px 0; }
    .stat-card { background: white; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .stat-number { font-size: 36px; font-weight: bold; color: #007bff; }
    .stat-label { color: #666; margin-top: 5px; }
</style>";
echo "</head><body>";

echo "<h1>🔄 Social Links Update Script</h1>";
echo "<div class='info'><strong>Starting update process...</strong></div>";

$totalFiles = 0;
$updatedFiles = 0;
$skippedFiles = 0;
$errorFiles = 0;

foreach ($filesToUpdate as $filename) {
    $totalFiles++;
    
    if (!file_exists($filename)) {
        echo "<div class='file-result'>";
        echo "<strong>⏭️ Skipped:</strong> {$filename} (file not found)";
        echo "</div>";
        $skippedFiles++;
        continue;
    }
    
    // Read the file
    $content = file_get_contents($filename);
    
    // Backup the original file
    $backupFilename = $filename . '.backup_' . date('Y-m-d_H-i-s');
    file_put_contents($backupFilename, $content);
    
    // Count occurrences
    $matches = preg_match_all($oldPattern, $content, $found);
    
    if ($matches > 0) {
        // Replace old social links with new ones
        $newContent = preg_replace($oldPattern, $newSocialLinks, $content);
        
        // Write the updated content
        if (file_put_contents($filename, $newContent)) {
            echo "<div class='file-result'>";
            echo "<strong>✅ Updated:</strong> {$filename}<br>";
            echo "<small>Found and replaced {$matches} social links section(s)</small><br>";
            echo "<small>Backup saved as: {$backupFilename}</small>";
            echo "</div>";
            $updatedFiles++;
        } else {
            echo "<div class='file-result'>";
            echo "<strong>❌ Error:</strong> {$filename} (failed to write)";
            echo "</div>";
            $errorFiles++;
        }
    } else {
        echo "<div class='file-result'>";
        echo "<strong>⏭️ Skipped:</strong> {$filename} (no matching pattern found)";
        echo "</div>";
        $skippedFiles++;
    }
}

// Display statistics
echo "<h2>📊 Update Summary</h2>";
echo "<div class='stats'>";
echo "<div class='stat-card'>";
echo "<div class='stat-number'>{$totalFiles}</div>";
echo "<div class='stat-label'>Total Files</div>";
echo "</div>";
echo "<div class='stat-card'>";
echo "<div class='stat-number' style='color: #28a745;'>{$updatedFiles}</div>";
echo "<div class='stat-label'>Updated</div>";
echo "</div>";
echo "<div class='stat-card'>";
echo "<div class='stat-number' style='color: #ffc107;'>{$skippedFiles}</div>";
echo "<div class='stat-label'>Skipped</div>";
echo "</div>";
echo "</div>";

if ($updatedFiles > 0) {
    echo "<div class='success'>";
    echo "<h3>✅ Update Completed Successfully!</h3>";
    echo "<p><strong>{$updatedFiles}</strong> file(s) have been updated with working social media links.</p>";
    echo "<p>All social media icons now link to:</p>";
    echo "<ul>";
    echo "<li>🔵 X (Twitter): https://twitter.com</li>";
    echo "<li>🔵 LinkedIn: https://linkedin.com</li>";
    echo "<li>🔵 Facebook: https://facebook.com</li>";
    echo "<li>🔵 YouTube: https://youtube.com</li>";
    echo "</ul>";
    echo "<p><strong>⚠️ Important:</strong> Backup files have been created for all updated files. You can delete them once you verify everything works correctly.</p>";
    echo "</div>";
}

if ($errorFiles > 0) {
    echo "<div class='error'>";
    echo "<h3>⚠️ Some Errors Occurred</h3>";
    echo "<p>{$errorFiles} file(s) encountered errors during the update process.</p>";
    echo "</div>";
}

echo "<div class='info'>";
echo "<h3>📝 Next Steps:</h3>";
echo "<ol>";
echo "<li>Test your website to ensure all social links work correctly</li>";
echo "<li>Click on each social icon to verify they open the correct platforms</li>";
echo "<li>Once verified, you can delete all .backup files</li>";
echo "<li>Delete this update_social_links.php script file</li>";
echo "</ol>";
echo "</div>";

echo "<div style='margin-top: 30px; padding: 20px; background: #fff; border-radius: 8px;'>";
echo "<h3>🔗 Test Your Links:</h3>";
echo "<p>Visit any page on your site and check the footer. The social icons should now:</p>";
echo "<ul>";
echo "<li>Have proper icons (SVG graphics instead of text)</li>";
echo "<li>Show tooltips on hover</li>";
echo "<li>Open in new tabs when clicked</li>";
echo "<li>Link to the correct social media platforms</li>";
echo "</ul>";
echo "</div>";

echo "</body></html>";
?>