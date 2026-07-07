<?php

/**
 * Permission Fix Script for Upload Directories
 * This script will automatically set correct permissions for upload directories
 * Run this file by accessing: https://yourdomain.com/fix_permissions.php
 * DELETE THIS FILE AFTER USE FOR SECURITY!
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Upload Permissions</title>
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

        pre {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <h1>🔧 Fix Upload Permissions</h1>
    <p class="warning">⚠️ <strong>DELETE THIS FILE AFTER USE!</strong></p>

    <?php
    $basePath = FCPATH;

    echo "<div class='box'>";
    echo "<h2>📋 Server Information</h2>";
    echo "<p><strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
    echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
    echo "<p><strong>Current User:</strong> " . get_current_user() . "</p>";
    echo "<p><strong>Base Path (FCPATH):</strong> " . $basePath . "</p>";
    echo "</div>";

    // Check if running via POST (form submission)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<div class='box'>";
        echo "<h2>⚙️ Applying Permissions...</h2>";

        $dirs = [
            'uploads' => $basePath . 'uploads',
            'uploads/sekolah' => $basePath . 'uploads/sekolah',
            'uploads/user' => $basePath . 'uploads/user',
            'writable' => $basePath . 'writable',
            'writable/cache' => $basePath . 'writable/cache',
            'writable/logs' => $basePath . 'writable/logs',
            'writable/session' => $basePath . 'writable/session',
            'writable/uploads' => $basePath . 'writable/uploads',
        ];

        $permission = isset($_POST['permission']) ? $_POST['permission'] : '755';
        $results = [];

        foreach ($dirs as $name => $path) {
            echo "<h3>{$name}</h3>";

            // Create directory if it doesn't exist
            if (!file_exists($path)) {
                if (mkdir($path, octdec($permission), true)) {
                    echo "<p class='success'>✓ Directory created: {$path}</p>";
                    $results[] = "Created: {$name}";
                } else {
                    echo "<p class='error'>✗ Failed to create directory: {$path}</p>";
                    $results[] = "Failed to create: {$name}";
                    continue;
                }
            } else {
                echo "<p class='info'>Directory exists: {$path}</p>";
            }

            // Set permissions
            if (chmod($path, octdec($permission))) {
                echo "<p class='success'>✓ Permissions set to {$permission}</p>";
                $results[] = "Fixed: {$name}";
            } else {
                echo "<p class='error'>✗ Failed to set permissions to {$permission}</p>";
                echo "<p class='warning'>You may need to set permissions manually via SSH/File Manager</p>";
                $results[] = "Failed: {$name}";
            }

            // Set permissions for subdirectories if they exist
            if (is_dir($path)) {
                $items = scandir($path);
                foreach ($items as $item) {
                    if ($item === '.' || $item === '..') continue;
                    $itemPath = $path . '/' . $item;
                    if (is_dir($itemPath)) {
                        @chmod($itemPath, octdec($permission));
                    }
                }
            }

            echo "<hr>";
        }

        echo "<div class='box " . (in_array('Failed', $results) ? 'warning-box' : 'success-box') . "'>";
        echo "<h3>📊 Summary</h3>";
        echo "<p><strong>Permission applied:</strong> {$permission}</p>";
        echo "<p><strong>Total directories:</strong> " . count($dirs) . "</p>";
        echo "<p><strong>Successful:</strong> " . substr_count(implode('', $results), 'Fixed') . "</p>";
        echo "<p><strong>Created:</strong> " . substr_count(implode('', $results), 'Created') . "</p>";
        echo "<p><strong>Failed:</strong> " . substr_count(implode('', $results), 'Failed') . "</p>";

        if (in_array('Failed', $results)) {
            echo "<div class='warning-box'>";
            echo "<h4>⚠️ Some operations failed</h4>";
            echo "<p>This is common on shared hosting. Please try the following:</p>";
            echo "<ol>";
            echo "<li>Use cPanel File Manager to set permissions manually</li>";
            echo "<li>Contact your hosting provider to set correct permissions</li>";
            echo "<li>Try using SSH if available: <code>chmod {$permission} -R uploads/ writable/</code></li>";
            echo "</ol>";
            echo "</div>";
        } else {
            echo "<p class='success'>✓ All permissions set successfully!</p>";
        }
        echo "</div>";

        echo "<div class='box'>";
        echo "<h2>🧪 Test Upload</h2>";
        echo "<p>Test if upload is working now:</p>";
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
                    @unlink($testPath);
                    echo "<p class='success'>✓ Test file cleaned up</p>";
                } else {
                    echo "<p class='error'>✗ Upload failed! Could not move file.</p>";
                    echo "<p class='warning'>Error: " . error_get_last()['message'] . "</p>";
                }
            } else {
                echo "<p class='error'>✗ Upload error: " . upload_error_message($testFile['error']) . "</p>";
            }
        }
        echo "</div>";
    } else {
        // Show form
        echo "<div class='box'>";
        echo "<h2>⚙️ Select Permission to Apply</h2>";
        echo "<p>Choose the permission level you want to apply to upload directories:</p>";
        echo "<form method='POST'>";
        echo "<div style='margin: 15px 0;'>";
        echo "<input type='radio' id='perm755' name='permission' value='755' checked> ";
        echo "<label for='perm755'><strong>755</strong> (Recommended - Most secure)</label><br>";
        echo "<input type='radio' id='perm775' name='permission' value='775'> ";
        echo "<label for='perm775'><strong>775</strong> (If 755 doesn't work)</label><br>";
        echo "<input type='radio' id='perm777' name='permission' value='777'> ";
        echo "<label for='perm777'><strong>777</strong> (Last resort - Less secure)</label>";
        echo "</div>";
        echo "<button type='submit' style='padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;'>";
        echo "🔧 Apply Permissions";
        echo "</button>";
        echo "</form>";
        echo "</div>";

        echo "<div class='box warning-box'>";
        echo "<h3>⚠️ Important Notes</h3>";
        echo "<ul>";
        echo "<li><strong>755</strong> is the most secure option and should work on most servers</li>";
        echo "<li><strong>775</strong> may be needed on some shared hosting environments</li>";
        echo "<li><strong>777</strong> should only be used as a last resort (security risk)</li>";
        echo "<li>After applying permissions, test the upload functionality</li>";
        echo "<li><strong>DELETE THIS FILE AFTER USE!</strong></li>";
        echo "</ul>";
        echo "</div>";

        echo "<div class='box'>";
        echo "<h2>📋 Current Directory Status</h2>";

        $dirs = [
            'uploads' => $basePath . 'uploads',
            'uploads/sekolah' => $basePath . 'uploads/sekolah',
            'uploads/user' => $basePath . 'uploads/user',
            'writable' => $basePath . 'writable',
            'writable/cache' => $basePath . 'writable/cache',
            'writable/logs' => $basePath . 'writable/logs',
            'writable/session' => $basePath . 'writable/session',
            'writable/uploads' => $basePath . 'writable/uploads',
        ];

        foreach ($dirs as $name => $path) {
            echo "<p><strong>{$name}:</strong> ";
            if (file_exists($path)) {
                $perms = fileperms($path);
                $octal = substr(sprintf('%o', $perms), -4);
                if (is_writable($path)) {
                    echo "<span class='success'>✓ Writable ({$octal})</span>";
                } else {
                    echo "<span class='error'>✗ Not writable ({$octal})</span>";
                }
            } else {
                echo "<span class='warning'>⚠ Does not exist</span>";
            }
            echo "</p>";
        }
        echo "</div>";
    }
    ?>

    <div class="box error-box">
        <h3>⚠️ Security Notice</h3>
        <p><strong>IMPORTANT: Delete this file (fix_permissions.php) after you're done!</strong></p>
        <p>This file can modify file permissions and should not be left accessible on a production server.</p>
        <p>To delete: <code>unlink('fix_permissions.php');</code> or delete via FTP/File Manager</p>
    </div>
</body>

</html>

<?php
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