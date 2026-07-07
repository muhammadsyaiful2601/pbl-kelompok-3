<?php

/**
 * Diagnostic Script for Upload Permission Issues
 * Run this file by accessing: https://yourdomain.com/diagnose_upload.php
 * DELETE THIS FILE AFTER DIAGNOSIS FOR SECURITY!
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnostic Upload Permission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .warning {
            color: orange;
            font-weight: bold;
        }

        .info {
            color: blue;
        }

        .box {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .success-box {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .error-box {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .warning-box {
            background-color: #fff3cd;
            border-color: #ffeaa7;
        }
    </style>
</head>

<body>
    <h1>🔍 Diagnostic Upload Permission</h1>
    <p class="warning">⚠️ <strong>DELETE THIS FILE AFTER DIAGNOSIS!</strong></p>

    <?php
    $basePath = FCPATH;
    $uploadDirs = [
        'uploads' => $basePath . 'uploads',
        'uploads/sekolah' => $basePath . 'uploads/sekolah',
        'uploads/user' => $basePath . 'uploads/user',
        'writable' => $basePath . 'writable',
        'writable/cache' => $basePath . 'writable/cache',
        'writable/logs' => $basePath . 'writable/logs',
        'writable/session' => $basePath . 'writable/session',
        'writable/uploads' => $basePath . 'writable/uploads',
    ];

    echo "<div class='box'>";
    echo "<h2>📋 Server Information</h2>";
    echo "<p><strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
    echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
    echo "<p><strong>Current User:</strong> " . get_current_user() . "</p>";
    echo "<p><strong>Base Path (FCPATH):</strong> " . $basePath . "</p>";
    echo "</div>";

    echo "<div class='box'>";
    echo "<h2>📁 Directory Permission Check</h2>";

    $allOk = true;
    foreach ($uploadDirs as $name => $path) {
        echo "<h3>{$name}</h3>";
        echo "<p>Path: <code>{$path}</code></p>";

        if (!file_exists($path)) {
            echo "<p class='error'>✗ Directory does not exist</p>";
            $allOk = false;
            continue;
        }

        echo "<p class='success'>✓ Directory exists</p>";

        // Check if readable
        if (is_readable($path)) {
            echo "<p class='success'>✓ Readable</p>";
        } else {
            echo "<p class='error'>✗ Not readable</p>";
            $allOk = false;
        }

        // Check if writable
        if (is_writable($path)) {
            echo "<p class='success'>✓ Writable</p>";
        } else {
            echo "<p class='error'>✗ NOT WRITABLE - This is the problem!</p>";
            $allOk = false;
        }

        // Get permissions
        $perms = fileperms($path);
        $octal = substr(sprintf('%o', $perms), -4);
        echo "<p class='info'>Current Permissions: <code>{$octal}</code></p>";

        // Get owner info
        $owner = posix_getpwuid(fileowner($path));
        $group = posix_getgrgid(filegroup($path));
        if ($owner && $group) {
            echo "<p class='info'>Owner: {$owner['name']} (UID: " . fileowner($path) . ")</p>";
            echo "<p class='info'>Group: {$group['name']} (GID: " . filegroup($path) . ")</p>";
        }

        echo "<hr>";
    }
    echo "</div>";

    echo "<div class='box'>";
    echo "<h2>🔧 Recommended Fix</h2>";

    if (!$allOk) {
        echo "<div class='error-box'>";
        echo "<h3>❌ Problem Detected!</h3>";
        echo "<p>One or more directories are not writable. This is causing the 403 Forbidden error.</p>";
        echo "</div>";

        echo "<div class='warning-box'>";
        echo "<h3>⚠️ Solution Steps:</h3>";
        echo "<ol>";
        echo "<li><strong>Via SSH (if available):</strong>";
        echo "<pre>cd " . $basePath . "
chmod 755 uploads uploads/sekolah uploads/user
chmod 755 writable writable/cache writable/logs writable/session writable/uploads

# If 755 doesn't work, try 775:
chmod 775 uploads uploads/sekolah uploads/user
chmod 775 writable writable/cache writable/logs writable/session writable/uploads

# If still doesn't work (last resort):
chmod 777 uploads uploads/sekolah uploads/user
chmod 777 writable writable/cache writable/logs writable/session writable/uploads</pre>";
        echo "</li>";

        echo "<li><strong>Via File Manager (cPanel/DirectAdmin):</strong>";
        echo "<ul>";
        echo "<li>Right-click on each folder</li>";
        echo "<li>Select 'Change Permissions' or 'CHMOD'</li>";
        echo "<li>Set to 755 (or 775 if 755 doesn't work)</li>";
        echo "<li>Check 'Recurse into subdirectories' if available</li>";
        echo "</ul>";
        echo "</li>";

        echo "<li><strong>Via FTP Client (FileZilla/WinSCP):</strong>";
        echo "<ul>";
        echo "<li>Right-click folder → File permissions</li>";
        echo "<li>Set to 755 or 775</li>";
        echo "<li>Apply to subdirectories</li>";
        echo "</ul>";
        echo "</li>";

        echo "<li><strong>If using LiteSpeed Web Server:</strong>";
        echo "<ul>";
        echo "<li>LiteSpeed may have additional security restrictions</li>";
        echo "<li>Check LiteSpeed WebAdmin → Security → AllowOverride</li>";
        echo "<li>Ensure 'All' is selected for the uploads directory</li>";
        echo "<li>Check if there's a mod_security rule blocking uploads</li>";
        echo "</ul>";
        echo "</li>";
        echo "</ol>";
        echo "</div>";
    } else {
        echo "<div class='success-box'>";
        echo "<h3>✓ All Directories Are Writable!</h3>";
        echo "<p>If you're still getting 403 errors, the issue might be:</p>";
        echo "<ul>";
        echo "<li><strong>LiteSpeed Security:</strong> Check LiteSpeed WebAdmin for mod_security rules</li>";
        echo "<li><strong>PHP open_basedir restriction:</strong> Check phpinfo() for open_basedir settings</li>";
        echo "<li><strong>File ownership:</strong> Ensure files are owned by the correct user (usually 'nobody' or 'www-data')</li>";
        echo "<li><strong>SELinux:</strong> If using SELinux, run: <code>chcon -R -t httpd_sys_rw_content_t uploads/ writable/</code></li>";
        echo "</ul>";
        echo "</div>";
    }
    echo "</div>";

    echo "<div class='box'>";
    echo "<h2>🧪 Test Upload</h2>";
    echo "<p>You can test file upload functionality here:</p>";
    echo "<form method='POST' enctype='multipart/form-data'>";
    echo "<input type='file' name='test_file' required>";
    echo "<button type='submit' name='test_upload'>Test Upload</button>";
    echo "</form>";

    if (isset($_POST['test_upload']) && isset($_FILES['test_file'])) {
        echo "<h3>Upload Test Result:</h3>";
        $testFile = $_FILES['test_file'];
        $testPath = $basePath . 'uploads/test_' . time() . '.jpg';

        echo "<p>File name: {$testFile['name']}</p>";
        echo "<p>File size: {$testFile['size']} bytes</p>";
        echo "<p>Error code: {$testFile['error']}</p>";

        if ($testFile['error'] === 0) {
            if (move_uploaded_file($testFile['tmp_name'], $testPath)) {
                echo "<p class='success'>✓ Upload successful! File saved to: {$testPath}</p>";
                // Clean up test file
                @unlink($testPath);
            } else {
                echo "<p class='error'>✗ Upload failed! Could not move file.</p>";
                echo "<p class='warning'>Error: " . error_get_last()['message'] . "</p>";
            }
        } else {
            echo "<p class='error'>✗ Upload error: " . upload_error_message($testFile['error']) . "</p>";
        }
    }
    echo "</div>";

    function upload_error_message($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                return 'File exceeds upload_max_filesize in php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'File exceeds MAX_FILE_SIZE in form';
            case UPLOAD_ERR_PARTIAL:
                return 'File was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing temporary directory';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'File upload stopped by extension';
            default:
                return 'Unknown error';
        }
    }
    ?>

    <div class="box error-box">
        <h3>⚠️ Security Notice</h3>
        <p><strong>IMPORTANT: Delete this file (diagnose_upload.php) after you're done diagnosing!</strong></p>
        <p>This file exposes sensitive server information and could be a security risk if left accessible.</p>
    </div>
</body>

</html>