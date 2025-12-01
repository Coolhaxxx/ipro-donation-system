# 🚀 Hostinger Deployment Guide - iPro Donation System

## 📋 Deployment to: laravel.freshnmore.com.pk

This guide will help you deploy your Laravel iPro Donation System to Hostinger for client review.

---

## 📦 Pre-Deployment Checklist

### ✅ What You Need:
- [ ] Hostinger account access
- [ ] Database credentials from Hostinger
- [ ] FTP/File Manager access
- [ ] Your project files ready
- [ ] Database backup from local

---

## 🎯 DEPLOYMENT STEPS

### **STEP 1: Prepare Your Local Project**

#### 1.1 Build Production Assets
```bash
cd d:\laravel\ipro
npm run build
```

#### 1.2 Optimize Laravel for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 1.3 Export Your Database
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Select `ipro` database
3. Click "Export" tab
4. Choose "Quick" export method
5. Format: SQL
6. Click "Export" button
7. Save as `ipro_database.sql`

---

### **STEP 2: Setup Hostinger Database**

#### 2.1 Create Database on Hostinger
1. Login to Hostinger control panel (hPanel)
2. Go to **"Databases"** → **"MySQL Databases"**
3. Click **"Create New Database"**
4. Database name: `u123456789_ipro` (or similar - Hostinger adds prefix)
5. Create database user with strong password
6. **SAVE THESE CREDENTIALS:**
   - Database Name: `_________________`
   - Database User: `_________________`
   - Database Password: `_________________`
   - Database Host: `localhost` (usually)

#### 2.2 Import Your Database
1. In hPanel, go to **"Databases"** → **"phpMyAdmin"**
2. Select your new database
3. Click **"Import"** tab
4. Choose file: `ipro_database.sql`
5. Click **"Import"** button
6. Wait for success message

---

### **STEP 3: Prepare Files for Upload**

#### 3.1 Create Production .env File
Create a new file called `.env.production` with these settings:

```env
APP_NAME="iPro Donation System"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://laravel.freshnmore.com.pk

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_ipro
DB_USERNAME=u123456789_ipro_user
DB_PASSWORD=YOUR_DATABASE_PASSWORD

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.freshnmore.com.pk

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your-email@freshnmore.com.pk
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@freshnmore.com.pk"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

**IMPORTANT:** 
- Replace `YOUR_APP_KEY_HERE` with your actual app key from local `.env`
- Update database credentials with Hostinger values
- Set `APP_DEBUG=false` for production

#### 3.2 Files to Upload
You need to upload these folders/files:
```
✅ app/
✅ bootstrap/
✅ config/
✅ database/
✅ public/
✅ resources/
✅ routes/
✅ storage/
✅ vendor/
✅ .htaccess (if exists in root)
✅ artisan
✅ composer.json
✅ composer.lock
✅ package.json
```

**DO NOT UPLOAD:**
```
❌ .env (you'll create this on server)
❌ node_modules/
❌ .git/
❌ tests/
❌ *.md files (optional)
```

---

### **STEP 4: Upload Files to Hostinger**

#### Option A: Using File Manager (Recommended for beginners)

1. **Login to hPanel**
2. Go to **"Files"** → **"File Manager"**
3. Navigate to `public_html/` directory
4. Create subdomain folder: `laravel/` (if needed)
5. **Upload all files** to the folder

#### Option B: Using FTP (Faster for large files)

1. **Get FTP Credentials:**
   - In hPanel → **"Files"** → **"FTP Accounts"**
   - Create FTP account or use existing
   - Note: Host, Username, Password, Port (21)

2. **Use FileZilla or WinSCP:**
   - Host: `ftp.freshnmore.com.pk`
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21
   - Upload to: `/public_html/laravel/` or `/domains/laravel.freshnmore.com.pk/public_html/`

---

### **STEP 5: Configure Subdomain**

#### 5.1 Setup Subdomain
1. In hPanel → **"Domains"** → **"Subdomains"**
2. Click **"Create Subdomain"**
3. Subdomain: `laravel`
4. Domain: `freshnmore.com.pk`
5. Document root: Point to `/public_html/laravel/public` (IMPORTANT!)
6. Click **"Create"**

**CRITICAL:** The document root MUST point to the `/public` folder of your Laravel project!

---

### **STEP 6: Configure Laravel on Server**

#### 6.1 Create .env File
1. In File Manager, navigate to your Laravel root (where `artisan` file is)
2. Create new file: `.env`
3. Copy contents from `.env.production` you created earlier
4. Save the file

#### 6.2 Set Folder Permissions
Using File Manager or FTP:
```
storage/ → 755 (and all subfolders)
bootstrap/cache/ → 755
```

Right-click folder → **"Permissions"** → Set to `755`

#### 6.3 Create Storage Link
You need to run this command via SSH or create manually:

**Via SSH (if available):**
```bash
cd /home/u123456789/domains/laravel.freshnmore.com.pk/public_html
php artisan storage:link
```

**Manually (if no SSH):**
1. In File Manager, go to `public/` folder
2. Create symbolic link or copy `storage/app/public` to `public/storage`

---

### **STEP 7: Update .htaccess (if needed)**

#### 7.1 Check public/.htaccess
Make sure `public/.htaccess` contains:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

### **STEP 8: Install Composer Dependencies (if needed)**

If Hostinger has SSH access:

```bash
cd /home/u123456789/domains/laravel.freshnmore.com.pk/public_html
composer install --optimize-autoloader --no-dev
```

**If NO SSH access:**
- Upload the entire `vendor/` folder from your local project
- This is why we included it in the upload list

---

### **STEP 9: Run Artisan Commands**

#### Via SSH (Recommended):
```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

#### Via Web (Alternative):
Create a file `deploy.php` in your `public/` folder:

```php
<?php
// REMOVE THIS FILE AFTER DEPLOYMENT!

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<pre>";

echo "Running migrations...\n";
$kernel->call('migrate', ['--force' => true]);

echo "\nClearing caches...\n";
$kernel->call('config:cache');
$kernel->call('route:cache');
$kernel->call('view:cache');

echo "\nCreating storage link...\n";
$kernel->call('storage:link');

echo "\nDeployment complete!\n";
echo "</pre>";

// DELETE THIS FILE AFTER RUNNING!
```

Visit: `https://laravel.freshnmore.com.pk/deploy.php`

**⚠️ IMPORTANT: DELETE `deploy.php` AFTER RUNNING!**

---

### **STEP 10: Create Admin User**

#### Via SSH:
```bash
php artisan tinker
```

Then run:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@ipro.com';
$user->password = bcrypt('admin123');
$user->is_admin = true;
$user->save();
exit
```

#### Via Web:
Create `create-admin.php` in `public/`:

```php
<?php
// REMOVE THIS FILE AFTER USE!

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@ipro.com';
$user->password = bcrypt('admin123');
$user->is_admin = true;
$user->save();

echo "Admin user created successfully!<br>";
echo "Email: admin@ipro.com<br>";
echo "Password: admin123<br>";
echo "<br><strong>DELETE THIS FILE NOW!</strong>";
```

Visit: `https://laravel.freshnmore.com.pk/create-admin.php`

**⚠️ DELETE IMMEDIATELY AFTER USE!**

---

### **STEP 11: Test Your Deployment**

#### 11.1 Test Public Form
1. Visit: `https://laravel.freshnmore.com.pk`
2. You should see the donation form
3. Try submitting a test donation

#### 11.2 Test Admin Panel
1. Visit: `https://laravel.freshnmore.com.pk/admin/login`
2. Login with:
   - Email: `admin@ipro.com`
   - Password: `admin123`
3. Check if dashboard loads
4. Verify test donation appears

#### 11.3 Test File Uploads
1. Make a donation with check payment
2. Upload a test image
3. Verify it appears in admin panel

---

## 🔧 Troubleshooting

### Issue: 500 Internal Server Error
**Solutions:**
1. Check `.env` file exists and has correct values
2. Check folder permissions (755 for storage/)
3. Check error logs in `storage/logs/laravel.log`
4. Make sure `APP_DEBUG=true` temporarily to see errors

### Issue: Database Connection Error
**Solutions:**
1. Verify database credentials in `.env`
2. Check database exists in phpMyAdmin
3. Verify database user has all privileges
4. Try `DB_HOST=localhost` or `DB_HOST=127.0.0.1`

### Issue: CSS/JS Not Loading
**Solutions:**
1. Check `APP_URL` in `.env` matches your domain
2. Run `npm run build` locally before upload
3. Upload `public/build/` folder
4. Clear browser cache

### Issue: Storage/Uploads Not Working
**Solutions:**
1. Check `storage/` permissions (755)
2. Run `php artisan storage:link`
3. Check `FILESYSTEM_DISK=local` in `.env`

### Issue: Routes Not Working (404)
**Solutions:**
1. Check `.htaccess` exists in `public/` folder
2. Verify mod_rewrite is enabled (ask Hostinger)
3. Check subdomain points to `/public` folder
4. Clear route cache: `php artisan route:clear`

---

## 📝 Post-Deployment Checklist

- [ ] Public form loads correctly
- [ ] Admin login works
- [ ] Test donation submission works
- [ ] File uploads work (check payment)
- [ ] Admin dashboard shows data
- [ ] All routes work (no 404s)
- [ ] CSS/JS loads properly
- [ ] Database connection works
- [ ] Email notifications work (if configured)
- [ ] SSL certificate active (https://)
- [ ] Delete temporary files (`deploy.php`, `create-admin.php`)
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Change admin password to something secure

---

## 🔐 Security Recommendations

### For Client Review:
1. **Keep current admin credentials** (admin@ipro.com / admin123)
2. **Set `APP_DEBUG=false`** in production
3. **Don't expose `.env` file** (should be protected by .htaccess)
4. **Use HTTPS** (Hostinger provides free SSL)

### For Production Launch:
1. Change admin password to strong password
2. Add more admin users if needed
3. Setup email notifications
4. Configure backup system
5. Setup monitoring/logging
6. Review all security settings

---

## 📞 Hostinger Support

If you encounter issues:
- **Live Chat:** Available 24/7 in hPanel
- **Email:** support@hostinger.com
- **Knowledge Base:** https://support.hostinger.com

Common questions to ask:
- "How do I enable SSH access?"
- "Where should I point my subdomain document root?"
- "How do I set folder permissions?"
- "Is mod_rewrite enabled on my hosting?"

---

## 🎉 Success!

Once deployed, share with your client:

**Public Donation Form:**
`https://laravel.freshnmore.com.pk`

**Admin Panel:**
`https://laravel.freshnmore.com.pk/admin/login`
- Email: admin@ipro.com
- Password: admin123

---

## 📋 Quick Command Reference

```bash
# Build assets
npm run build

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Create admin user
php artisan tinker
```

---

**Deployment Date:** _________________  
**Deployed By:** _________________  
**Client Review Period:** _________________  

**Good luck with your deployment! 🚀**
