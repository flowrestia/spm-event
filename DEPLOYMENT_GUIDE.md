# 🚀 Deployment Guide - Sekolah Pasar Modal Financial Glow Up 2026

Guide lengkap untuk deploy aplikasi ke Railway atau Render (gratis 3-4 bulan).

---

## 📋 **Pre-Deployment Checklist**

- ✅ Database PostgreSQL Supabase terbentuk
- ✅ Admin user created (admin@gibei-polinema.ac.id / Admin@2026!)
- ✅ All migrations applied
- ✅ Code pushed to GitHub
- ✅ Cloudinary credentials ready

---

## 🎯 **Option 1: Deploy ke Render.com** (RECOMMENDED - Gratis 3 bulan)

### **Step 1: Persiapan**
1. Buat akun di [Render.com](https://render.com)
2. Login dengan GitHub
3. Go to Dashboard → New+ → Web Service

### **Step 2: Connect GitHub**
1. Klik "Build and deploy from GitHub"
2. Authorize Render untuk access GitHub
3. Select repository: `flowrestia/spm-event`
4. Branch: `main`

### **Step 3: Configure Service**
```
Name: spm-event
Environment: Ruby (Default)
Build Command: leave empty (automatic)
Start Command: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

### **Step 4: Environment Variables**
Di Render dashboard, set environment variables (klik "Add Environment Variable"):

```env
APP_NAME=Laravel
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:ao153sOd5L2nF5ARVFL2wgC41tEZ/lig+Jkz4K8gVlQ=
APP_URL=https://spm-event.onrender.com

DB_CONNECTION=pgsql
DB_HOST=db.wpdeyrvchcocwgrsoatm.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=xGHqrH7E9zGZdvPr
DB_SSLMODE=require

SESSION_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=debug

CACHE_STORE=file
MAIL_MAILER=log

CLOUDINARY_URL=cloudinary://116655597617299:Kv1Pdt0gA60GN6liiaacoBvrmNY@dkr1ohceb
```

### **Step 5: Deploy**
1. Klik "Create Web Service"
2. Render akan automatically git clone dan deploy
3. Tunggu sampai status "Live"
4. Live URL akan muncul di dashboard (semacam: `https://spm-event.onrender.com`)

### **Step 6: Post-Deployment**
```bash
# Jika perlu manual seed admin:
# SSH ke Render dan run:
php artisan db:seed --class=AdminSeeder
```

---

## 🎯 **Option 2: Deploy ke Railway.app** (Gratis dengan $5 credit/bulan)

### **Step 1: Persiapan**
1. Buat akun di [Railway.app](https://railway.app)
2. Login dengan GitHub
3. Klik "New Project"

### **Step 2: Connect GitHub**
1. Klik "Deploy from GitHub"
2. Authorize Railway
3. Select repository: `flowrestia/spm-event`

### **Step 3: Add PostgreSQL Database**
1. di Railway dashboard, klik "Add"
2. Pilih "PostgreSQL"
3. Railroad akan auto-generate `DATABASE_URL`
4. Update di service (lihat Step 4)

### **Step 4: Environment Configuration**
Di railway dashboard, edit `service/variables`:

```env
APP_NAME=SPM
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:ao153sOd5L2nF5ARVFL2wgC41tEZ/lig+Jkz4K8gVlQ=
APP_URL=https://your-railway-url.up.railway.app

# PostgreSQL Supabase (gunakan ini, jangan gunakan Railway's PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=db.wpdeyrvchcocwgrsoatm.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=xGHqrH7E9zGZdvPr
DB_SSLMODE=require

SESSION_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=debug

CLOUDINARY_URL=cloudinary://116655597617299:Kv1Pdt0gA60GN6liiaacoBvrmNY@dkr1ohceb
```

### **Step 5: Deploy**
1. Railway akan otomatis detect `composer.json` dan `package.json`
2. Auto-run migrations (jika ada `Procfile`)
3. Deploy ke Railway's cloud

### **Step 6: Procfile (Create if needed)**
Buat file `Procfile` di root project:
```
web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate --force && php artisan db:seed --class=AdminSeeder
```

---

## ⚠️ **Important Production Notes**

### **Database Connection Issues?**
Jika database tidak konek di production:
1. Verify PostgreSQL credentials di .env (DOUBLE CHECK!)
2. Add `DB_SSLMODE=require` for Supabase
3. Test locally dulu dengan `.env` yang sama

### **File Upload / Storage**
- Bukti pembayaran di-upload ke **Cloudinary** (aman, cloud-based)
- QR codes & PDFs di-store di **local filesystem** (`storage/app/public/`)
- Pastikan storage folder accessible di production

### **Sessions & Caching**
```env
SESSION_DRIVER=file          # File-based sessions (good for single server)
CACHE_STORE=file             # File-based cache
QUEUE_CONNECTION=sync        # Synchronous (no background jobs needed)
```

### **Logs**
Logs akan di-write ke `storage/logs/laravel.log`
- Monitor via SSH atau platform's log viewer

### **Email Sending**
Saat ini: `MAIL_MAILER=log` (untuk development)

Untuk production, set `MAIL_MAILER=smtp` dengan:
```env
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=a87ccc001@smtp-brevo.com
MAIL_PASSWORD=xkeysib-c8d6a623f8480d08d9a5f47b5ef943dbe7b387a776b27b4cc248a2135e66cff1
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=spm2026@gmail.com
MAIL_FROM_NAME="SPM Financial Glow Up"
```

---

## 🔍 **Verify Deployment**

### **1. Check Website is Running**
```
https://spm-event.onrender.com/
https://your-railway-url.up.railway.app/
```

### **2. Test Admin Login**
- URL: `/admin/login`
- Email: `admin@gibei-polinema.ac.id`
- Password: `Admin@2026!`

### **3. Test Form Submission**
- Go to home page
- Fill form
- Submit
- Verify success modal

### **4. Check Logs**
- Render: Logs tab
- Railway: Logs section
- Verify no errors

---

## 🆘 **Troubleshooting**

### **500 Error saat load admin pages?**
```
Kemungkinan: Database connection error
Solusi:
1. Verify DATABASE_URL / DB credentials
2. Check PostgreSQL is accepting connections
3. Run migrations manually via SSH
```

### **Cloudinary upload fails?**
```
Kemungkinan: CLOUDINARY_URL not set properly
Solusi:
1. Verify CLOUDINARY_URL environment variable
2. Check format: cloudinary://api_key:api_secret@cloud_name
3. Test locally with same credentials
```

### **Sessions tidak persist?**
```
Kemungkinan: SESSION_DRIVER=database tanpa session table
Solusi:
1. Keep SESSION_DRIVER=file
2. File-based is more reliable untuk single server
```

---

## 📌 **Quick Reference**

| Item | Value |
|------|-------|
| GitHub Repo | https://github.com/flowrestia/spm-event |
| Dev Server | http://127.0.0.1:8000 |
| Admin Email | admin@gibei-polinema.ac.id |
| Admin Password | Admin@2026! |
| Database | PostgreSQL (Supabase) |
| Storage | Cloudinary (images) + Local (QR/PDF) |
| Email | Log driver (dev) / SMTP (prod) |
| Free Duration | 3 months (Railway/Render free tier) |

---

## 📞 **Support**

Jika ada masalah:
1. Check logs (Render/Railway console)
2. Verify .env variables exact match
3. Test database connection locally
4. Clear caches: `php artisan cache:clear`

---

**Status**: ✅ Production Ready
**Last Updated**: April 18, 2026
**Maintained By**: AI Assistant
