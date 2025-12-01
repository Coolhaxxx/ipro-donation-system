# ✅ Hostinger Deployment Checklist

## 📦 Before You Start

- [ ] Hostinger account credentials ready
- [ ] Database name, user, password noted down
- [ ] FTP credentials available
- [ ] Project tested locally

---

## 🎯 Step-by-Step Checklist

### Local Preparation
- [ ] Run `npm run build`
- [ ] Export database from phpMyAdmin → Save as `ipro_database.sql`
- [ ] Copy your local `.env` APP_KEY value
- [ ] Test project one final time locally

### Hostinger Setup
- [ ] Login to Hostinger hPanel
- [ ] Create MySQL database
- [ ] Note database credentials:
  - DB Name: `_________________`
  - DB User: `_________________`
  - DB Pass: `_________________`
- [ ] Import `ipro_database.sql` via phpMyAdmin
- [ ] Verify import successful (check tables exist)

### Subdomain Configuration
- [ ] Create subdomain: `laravel.freshnmore.com.pk`
- [ ] Point document root to `/public` folder
- [ ] Verify subdomain is active (may take 5-10 minutes)

### File Upload
- [ ] Upload all project files via File Manager or FTP
- [ ] Verify all folders uploaded:
  - [ ] app/
  - [ ] bootstrap/
  - [ ] config/
  - [ ] database/
  - [ ] public/
  - [ ] resources/
  - [ ] routes/
  - [ ] storage/
  - [ ] vendor/
  - [ ] artisan
  - [ ] composer.json

### Server Configuration
- [ ] Create `.env` file on server
- [ ] Update `.env` with production settings:
  - [ ] APP_ENV=production
  - [ ] APP_DEBUG=false
  - [ ] APP_URL=https://laravel.freshnmore.com.pk
  - [ ] Database credentials
- [ ] Set folder permissions:
  - [ ] storage/ → 755
  - [ ] bootstrap/cache/ → 755
- [ ] Create storage link (via SSH or manually)

### Laravel Setup
- [ ] Run migrations (via SSH or deploy.php)
- [ ] Run cache commands:
  - [ ] php artisan config:cache
  - [ ] php artisan route:cache
  - [ ] php artisan view:cache
- [ ] Create admin user (via tinker or create-admin.php)
- [ ] Delete temporary files (deploy.php, create-admin.php)

### Testing
- [ ] Visit: https://laravel.freshnmore.com.pk
- [ ] Public form loads correctly
- [ ] CSS/JS loads properly
- [ ] Submit test donation
- [ ] Upload test check image
- [ ] Visit: https://laravel.freshnmore.com.pk/admin/login
- [ ] Login with admin credentials
- [ ] Dashboard loads
- [ ] Test donation appears
- [ ] All admin features work

### Security
- [ ] Set APP_DEBUG=false in .env
- [ ] Verify .env is not publicly accessible
- [ ] SSL certificate active (https)
- [ ] Remove any test/debug files

### Client Handoff
- [ ] Document admin credentials
- [ ] Test all features one final time
- [ ] Share URLs with client:
  - Public: https://laravel.freshnmore.com.pk
  - Admin: https://laravel.freshnmore.com.pk/admin/login
- [ ] Provide admin login details

---

## 📝 Credentials to Share with Client

**Website URL:**
https://laravel.freshnmore.com.pk

**Admin Panel:**
https://laravel.freshnmore.com.pk/admin/login

**Admin Login:**
- Email: admin@ipro.com
- Password: admin123

**Note:** Recommend changing password after review

---

## 🆘 If Something Goes Wrong

1. Check `storage/logs/laravel.log` for errors
2. Temporarily set `APP_DEBUG=true` to see detailed errors
3. Contact Hostinger support via live chat
4. Refer to HOSTINGER_DEPLOYMENT_GUIDE.md troubleshooting section

---

**Deployment Date:** _________________  
**Status:** ⬜ Not Started | ⬜ In Progress | ⬜ Complete
