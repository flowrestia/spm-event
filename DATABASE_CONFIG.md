# 🗄️ Database Configuration Guide

## Quick Summary

| Environment | Database | Connection | When to Use |
|------------|----------|-----------|-----------|
| **Local Development** | SQLite | File-based | Testing, developing locally |
| **Production** | PostgreSQL | Supabase | Live deployment on server |

---

## 🖥️ LOCAL DEVELOPMENT (SQLite)

### Setup

1. **Update `.env`:**
```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
```

2. **Create SQLite database:**
```bash
rm database/database.sqlite  # Remove old one if exists
php artisan migrate:fresh --seed
```

3. **Run server:**
```bash
php artisan serve
```

✅ **Advantages:**
- No internet required
- No external service needed
- Fast local testing
- Easy debugging
- Perfect for development

---

## 🚀 PRODUCTION (PostgreSQL Supabase)

### Setup

1. **Update `.env` with Supabase credentials:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://daftarspm2026.onrender.com

DB_CONNECTION=pgsql
DB_HOST=db.wpdeyrvchcocwgrsoatm.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=xGHqrH7E9zGZdvPr
```

2. **Or use environment variables on hosting:**
Set these as environment variables in Render/Railway dashboard:
- `DB_CONNECTION=pgsql`
- `DB_HOST=...`
- `DB_PORT=5432`
- `DB_DATABASE=...`
- etc.

3. **Run migrations on production:**
```bash
# On server via SSH/console
php artisan migrate --force
php artisan db:seed --force (opsional)
```

✅ **Advantages:**
- Reliable for production
- Remote backup & recovery
- High availability
- Professional hosting option
- Data persistence

---

## 📋 When Connection Fails

### Error: "could not translate host name" or "Name or service not known"
**Cause**: Trying to connect to remote Supabase but no internet or unreachable server

**Solution**: 
- Switch to SQLite for local testing
- Or fix internet connection for production

### Error: "SQLite database file not found"
**Solution**:
```bash
# Create fresh database
php artisan migrate:fresh --seed
```

### Error: "SQLSTATE[HY000]"
**Solution**:
1. Check `.env` file is correct
2. Clear cache: `php artisan config:clear`
3. Restart server: `php artisan serve`

---

## 📝 `.env.example` Reference

Copy this file to `.env` and update with your values:

```env
# Local Development
DB_CONNECTION=sqlite

# OR Production
# DB_CONNECTION=pgsql
# DB_HOST=your-host.com
# DB_PORT=5432
# DB_DATABASE=database_name
# DB_USERNAME=username
# DB_PASSWORD=password
```

---

## 🔄 Switching Databases

### From PostgreSQL → SQLite (Local Testing)
```bash
# 1. Update .env
# DB_CONNECTION=sqlite

# 2. Clear cache
php artisan config:clear
php artisan cache:clear

# 3. Create new database
rm database/database.sqlite
php artisan migrate:fresh --seed

# 4. Restart
php artisan serve
```

### From SQLite → PostgreSQL (Production)
```bash
# 1. Update .env with PostgreSQL credentials
# DB_CONNECTION=pgsql
# DB_HOST=...
# etc.

# 2. Clear cache
php artisan config:clear
php artisan cache:clear

# 3. Run migrations on PostgreSQL
php artisan migrate --force

# 4. Seed if needed
php artisan db:seed --force

# 5. Restart server
```

---

## ✅ Testing Database Connection

### Check if database works:
```bash
php artisan db:show
```

### Direct PHP test:
```bash
php artisan tinker
>>> App\Models\Admin::count()  // Should return number of admins
>>> exit
```

---

## 🔐 Security Notes

- **Never commit `.env` file** to Git (already in `.gitignore`)
- **Use `.env.example`** for reference only
- **Production passwords** should be set via environment variables on hosting
- **SQLite database file** should not be in public folder
- **Regular backups** for production PostgreSQL

---

**Current Setup**: Both configurations are ready!
- ✅ Local: SQLite (stored in `database/database.sqlite`)
- ✅ Production: PostgreSQL Supabase (credentials in `.env.production`)
