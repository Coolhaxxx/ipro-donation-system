# 🚀 Quick Deployment Reference Card

## 📍 Your Deployment Info

**Subdomain:** laravel.freshnmore.com.pk  
**Purpose:** Client Review  
**Project:** iPro Donation System

---

## ⚡ Quick Steps (TL;DR)

1. **Export database** from phpMyAdmin → Save as `ipro_database.sql`
2. **Build assets:** `npm run build`
3. **Create database** on Hostinger
4. **Import database** via Hostinger phpMyAdmin
5. **Upload files** via File Manager/FTP
6. **Create subdomain** pointing to `/public` folder
7. **Create `.env`** file with production settings
8. **Upload `deploy.php`** to `public/` folder
9. **Visit** `https://laravel.freshnmore.com.pk/deploy.php`
10. **Upload `create-admin.php`** to `public/` folder
11. **Visit** `https://laravel.freshnmore.com.pk/create-admin.php`
12. **Delete** both PHP files
13. **Test** everything works

---

## 📁 Files to Upload

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
✅ artisan
✅ composer.json
✅ composer.lock
```

**Don't upload:**
```
❌ .env
❌ node_modules/
❌ .git/
❌ tests/
```

---

## 🔧 Production .env Settings

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://laravel.freshnmore.com.pk

DB_HOST=localhost
DB_DATABASE=u123456789_ipro
DB_USERNAME=u123456789_ipro_user
DB_PASSWORD=your_password_here
```

**Get your APP_KEY from local `.env` file!**

---

## 🎯 Important URLs

**Public Form:**  
https://laravel.freshnmore.com.pk

**Admin Login:**  
https://laravel.freshnmore.com.pk/admin/login

**Deploy Script (run once):**  
https://laravel.freshnmore.com.pk/deploy.php

**Create Admin (run once):**  
https://laravel.freshnmore.com.pk/create-admin.php

---

## 🔑 Default Admin Credentials

**Email:** admin@ipro.com  
**Password:** admin123

---

## ⚠️ Critical Reminders

1. **Document root** MUST point to `/public` folder
2. **Set permissions** 755 on `storage/` and `bootstrap/cache/`
3. **Delete** `deploy.php` and `create-admin.php` after use
4. **Set** `APP_DEBUG=false` in production
5. **Copy** APP_KEY from local .env to production .env

---

## 🆘 Common Issues

**500 Error:**
- Check .env file exists
- Check database credentials
- Check folder permissions
- Check error logs

**Database Error:**
- Verify credentials in .env
- Check database imported successfully
- Try DB_HOST=127.0.0.1

**CSS Not Loading:**
- Run `npm run build` locally
- Upload `public/build/` folder
- Check APP_URL in .env

**Routes 404:**
- Verify subdomain points to `/public`
- Check .htaccess exists
- Clear route cache

---

## 📞 Need Help?

**Hostinger Support:** 24/7 Live Chat in hPanel  
**Documentation:** See `HOSTINGER_DEPLOYMENT_GUIDE.md`  
**Checklist:** See `DEPLOYMENT_CHECKLIST.md`

---

## ✅ Final Checklist

- [ ] Database imported
- [ ] Files uploaded
- [ ] .env configured
- [ ] deploy.php run
- [ ] Admin created
- [ ] Temp files deleted
- [ ] Public form tested
- [ ] Admin panel tested
- [ ] Client notified

---

**Good luck! 🎉**
