# 🏠 Back to Local Development

You are now ready to resume local development!

## ✅ Steps Completed
- Cleared all production caches (`optimize:clear`)
- Verified project structure

## 🚀 How to Start

You need to run **two** commands in separate terminal windows:

### Terminal 1: Laravel Server
```bash
php artisan serve
```
*Runs at: http://localhost:8000*

### Terminal 2: Vite (Frontend Assets)
```bash
npm run dev
```
*Compiles CSS/JS in real-time*

---

## 🧹 Cleanup (Optional)
If you are done with deployment, you can delete these files to keep your project clean:
- `ipro-deployment.zip`
- `ipro.zip`
- `deploy.php`
- `create-admin.php`
- `env.production.txt`
- `diagnose-server.php`
- `deploy-update.php`
- `fix-500-error.php`
- `fix-permissions.php`
- `*_GUIDE.md` (if you don't need the docs anymore)

## ⚠️ Troubleshooting
If you see errors:
1. **Database:** Check your `.env` file ensures `DB_HOST=127.0.0.1` and correct credentials.
2. **Styles Missing:** Make sure `npm run dev` is running.
3. **Permission Error:** If you get a PowerShell error running npm, try running in Command Prompt (cmd) or Git Bash.
