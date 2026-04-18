# 🚀 Quick Start - Testing Email & PDF Ticket System

## Prerequisites
- PHP 8.1+
- Composer
- SQLite atau MySQL
- Laravel 11
- SMTP access (Gmail configured)

---

## 1️⃣ First Time Setup

### Step 1: Clear Caches & Rebuild
```bash
cd "c:\Users\SONNY\Downloads\spm-financial-glow-up\spm-app\spm-app"
php artisan cache:clear
composer dump-autoload
```

### Step 2: Run Migrations & Seed
```bash
php artisan migrate:fresh --seed
```

**Output yang diharapkan:**
```
INFO  Migrating: ...create_participants_table
INFO  Migrating: ...create_attendances_table
INFO  Migrating: ...create_event_settings_table
INFO  Migrating: ...create_admins_table
INFO  Seeding database.
Admin user created:
  Email   : admin@gibei-polinema.ac.id
  Password: Admin@2026!
```

### Step 3: Start Server
```bash
php artisan serve
```

Server akan berjalan di `http://127.0.0.1:8000`

---

## 2️⃣ Test Registration Form

1. Open: `http://127.0.0.1:8000/`
2. Fill form with test data:
   - Name: `Ari Budiman`
   - Age: `21-25`
   - Phone: `081234567890`
   - Institution: `SMK Satu`
   - Info Source: `Sosial Media`
   - Email: `test@example.com`
   - Payment Proof: Upload any JPG/PNG file
3. Submit form
4. Expected: Success message "Pendaftaran berhasil!"

**Verify in Database:**
```bash
php artisan tinker
>>> \App\Models\Participant::latest()->first()
# Check: status should be 'pending'
```

---

## 3️⃣ Test Admin Panel

1. Open: `http://127.0.0.1:8000/admin/login`
2. Login with:
   - Email: `admin@gibei-polinema.ac.id`
   - Password: `Admin@2026!`
3. Navigate to: `http://127.0.0.1:8000/admin/participants`

**Expected:**
- See the participant you just registered (status: Menunggu/Pending)
- Click button "Terima" to approve

---

## 4️⃣ Test Email Sending (IMPORTANT!)

### Option A: Test Email Sending in Tinker
```php
php artisan tinker

// Test 1: Send test mail
Mail::raw('Test email', function($msg) {
    $msg->to('admin@gibei-polinema.ac.id')->subject('Test');
});
// Output: Should show success

// Test 2: Check participant
$p = Participant::first();

// Test 3: Generate QR
$qr = app(QRCodeService::class)->generate($p->ticket_code);
$p->update(['qr_code_path' => $qr, 'status' => 'accepted']);

// Test 4: Generate PDF
$pdf = app(PDFService::class)->generate($p->fresh());
$p->update(['pdf_path' => $pdf]);

// Test 5: Send actual email with attachment
Mail::to($p->email)->send(new TicketMail($p, app(PDFService::class)->path($pdf)));

// Check result
$p->fresh()->ticket_sent  // Should be true
```

### Option B: Test via Admin UI (Visual)
1. Go to participants list
2. Find the pending participant
3. Click "Terima" button
4. Expected: ✅ Success message
5. Check email inbox/spam folder after 5-10 seconds

---

## 5️⃣ Email Configuration Verification

### Check MAIL settings in .env
```bash
cat .env | grep MAIL_
```

Expected output:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=spm2026@gmail.com
MAIL_PASSWORD=yknnszcktqojugad
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=spm2026@gmail.com
MAIL_FROM_NAME="SPM Financial Glow Up"
```

### Test SMTP Connection
```bash
php artisan mail:test spm2026@gmail.com
```

---

## 6️⃣ Verify Generated Files

After approval, check if files are created:

### QR Code
```bash
# Should exist:
storage/app/public/qrcodes/SPM-2026-0001.png
ls storage/app/public/qrcodes/
```

### PDF Ticket
```bash
# Should exist:
storage/app/public/tickets/SPM-2026-0001.pdf
ls storage/app/public/tickets/
```

### Email Logs
```bash
tail -20 storage/logs/laravel.log
# Look for "TicketMail" or sending confirmations
```

---

## 7️⃣ Common Issues & Solutions

### Issue 1: "Mail not sending"
```bash
# Solution 1: Check if running synchronously
# In .env, ensure QUEUE_CONNECTION=sync for testing

# Solution 2: Enable mail logging
# In .env, set LOG_LEVEL=debug

# Solution 3: Test with Mailtrap (temporary)
# Use Mailtrap.io for testing without real email
```

### Issue 2: "PDF not generating"
```bash
# Solution: Check permissions
chmod -R 755 storage/app/public
chmod -R 755 public/storage

# Verify QR exists before PDF generation
php artisan tinker
>>> \App\Models\Participant::first()->qr_code_path
```

### Issue 3: "Attachment missing from email"
```bash
# Check PDF file path exists:
php artisan tinker
>>> $p = \App\Models\Participant::where('ticket_sent', true)->first();
>>> file_exists(app('App\Services\PDFService')->path($p->pdf_path))
# Should return: true
```

### Issue 4: "Gmail says 'Less secure apps' blocked"
```
Solution:
1. Go: https://myaccount.google.com/security
2. Enable "Less secure app access" OR
3. Create App Password (recommended):
   - Go: https://myaccount.google.com/apppasswords
   - Select: Mail + Windows Computer
   - Copy 16-char password
   - Paste in .env MAIL_PASSWORD
```

---

## 8️⃣ Email Content Customization

### Email Template
**File:** `resources/views/emails/ticket.blade.php`

Example customization:
```blade
<p>Halo, <strong>{{ $participant->name }}</strong>!</p>
<p>Kode Tiket: <code>{{ $participant->ticket_code }}</code></p>

<!-- Add custom message here -->
<p>Acara: [EVENT NAME]</p>
<p>Tanggal: [DATE]</p>
<p>Lokasi: [LOCATION]</p>
```

### PDF Template
**File:** `resources/views/pdf/ticket.blade.php`

Contains:
- Participant name & ticket code
- QR code image (embedded)
- Event details
- Campaign info

---

## 9️⃣ Advanced: Async Email Processing

For high-volume sending, use queue:

### Option 1: Use Sync Queue (Testing)
```bash
# In .env
QUEUE_CONNECTION=sync
```

### Option 2: Use File Queue
```bash
# In .env
QUEUE_CONNECTION=file

# Process queue:
php artisan queue:work
```

### Option 3: Use Database Queue
```bash
# In .env
QUEUE_CONNECTION=database

# Create table:
php artisan queue:table
php artisan migrate

# Process queue:
php artisan queue:work
```

---

## 🔟 Production Checklist Before Launch

- [ ] Test form submission with real payment proof
- [ ] Test admin approval process
- [ ] Test email delivery (check spam folder)
- [ ] Test PDF download & print quality
- [ ] Verify QR code scans correctly
- [ ] Test with multiple participants
- [ ] Verify ticket_sent flag updates
- [ ] Check storage space available
- [ ] Backup database
- [ ] Setup monitoring/logging
- [ ] SSL certificate configured
- [ ] Rate limiting enabled

---

## 📊 Database Schema (Reference)

### participants table
```
id, ticket_code, name, email, phone, institution, 
age_range, info_source, payment_proof, status, 
qr_code_path, pdf_path, ticket_sent, created_at, updated_at
```

### Key Fields
- `ticket_code` - Unique (e.g., SPM-2026-0001)
- `status` - [pending, accepted, rejected]
- `qr_code_path` - Path after approval
- `pdf_path` - Path after PDF generation
- `ticket_sent` - Boolean timestamp

---

## 🎯 Expected Result After Approval

1. **Participant Record Updated:**
   - status: pending → accepted
   - qr_code_path: [storage path]
   - pdf_path: [storage path]
   - ticket_sent: false → true

2. **Files Created:**
   - storage/app/public/qrcodes/SPM-*.png
   - storage/app/public/tickets/SPM-*.pdf

3. **Email Sent:**
   - To: participant@email.com
   - Subject: 🎟️ Tiket Anda - Sekolah Pasar Modal...
   - Attachment: SPM-*-Tiket.pdf

4. **Database Logged:**
   - storage/logs/laravel.log

---

**Happy Testing! 🎉**

If any issues, check `storage/logs/laravel.log` for detailed error messages.
