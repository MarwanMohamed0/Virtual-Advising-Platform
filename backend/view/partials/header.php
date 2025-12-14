<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - MashouraX' : 'MashouraX - Virtual Advising Platform'; ?></title>
    <link rel="stylesheet" href="<?php echo isset($cssFile) ? $cssFile : 'index.css'; ?>">
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <?php if (isset($showNavigation) && $showNavigation): ?>
        <?php 
        require_once __DIR__ . '/../../includes/navigation.php';
        // Navigation will be included from includes/navigation.php
        ?>
    <?php endif; ?>

