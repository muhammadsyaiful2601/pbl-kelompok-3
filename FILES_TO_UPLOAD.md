# FILES THAT MUST BE UPLOADED TO HOSTING SERVER

## IMPORTANT: Upload these files to fix the 403 Forbidden error

### Modified Files (replace existing files on hosting):

1. **app/Config/Filters.php**
   - Location: `app/Config/Filters.php`
   - Change: CSRF filter enabled globally

2. **app/Config/Security.php** ⚠️ UPLOAD AGAIN - CRITICAL FIX
   - Location: `app/Config/Security.php`
   - Changes: CSRF token regeneration disabled, cookie domain/path added (NOW NULLABLE)
   - **IMPORTANT**: Both cookieDomain and cookiePath are now nullable to prevent errors

3. **.env**
   - Location: `.env` (root directory)
   - Changes: CI_ENVIRONMENT = production, baseURL updated

### New Files (create these on hosting):

4. **public/uploads/.htaccess**
   - Location: `public/uploads/.htaccess`
   - Purpose: Allow public access to uploads directory

5. **public/uploads/sekolah/.htaccess**
   - Location: `public/uploads/sekolah/.htaccess`
   - Purpose: Allow public access to school photos

6. **public/uploads/user/.htaccess**
   - Location: `public/uploads/user/.htaccess`
   - Purpose: Allow public access to user photos

---

## CRITICAL STEP: Clear Cache After Upload

**You MUST clear the cache after uploading these files!**

### Method 1: Via FTP/File Manager (RECOMMENDED)
1. Connect to your hosting via FTP or File Manager
2. Navigate to: `writable/cache/`
3. **DELETE ALL FILES** in this folder
4. Look for and delete specifically: `FactoriesCache_config`

### Method 2: Via SSH/Terminal (if available)
```bash
cd /path/to/your/project
php spark cache:clear
```

---

## Step-by-Step Deployment:

1. **Upload the 3 modified files** to your hosting server
2. **Create the 3 new .htaccess files** in the uploads directories
3. **Clear the cache** (MOST IMPORTANT!)
4. **Test** by submitting a form with a photo

---

## Verification Checklist:

- [ ] app/Config/Filters.php uploaded
- [ ] app/Config/Security.php uploaded
- [ ] .env uploaded
- [ ] public/uploads/.htaccess created
- [ ] public/uploads/sekolah/.htaccess created
- [ ] public/uploads/user/.htaccess created
- [ ] Cache cleared in writable/cache/
- [ ] Tested form submission with photo

---

## If Error Still Persists:

1. **Double-check cache is cleared** - This is the #1 cause of continued errors
2. **Check file permissions** - Directories should be 755, files 644
3. **Clear browser cache** - Press Ctrl+Shift+R to hard refresh
4. **Check error logs** - Look in `writable/logs/` for detailed error messages

---

## Contact Your Hosting Provider If:

- You cannot access writable/cache/ directory
- You don't have SSH access to run `php spark cache:clear`
- File permissions cannot be changed
- Error logs show database connection issues