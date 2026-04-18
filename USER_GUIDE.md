# 📖 Panduan Pengguna - Sistem Pendaftaran SPM Financial Glow Up 2026

---

## 📋 Daftar Isi

1. [Panduan untuk Peserta (Role User)](#panduan-untuk-peserta)
2. [Panduan untuk Admin](#panduan-untuk-admin)
3. [Troubleshooting](#troubleshooting)

---

# 🎫 Panduan untuk Peserta (Role User)

## Login/Akses Website

Peserta **TIDAK PERLU LOGIN**. Website langsung bisa diakses tanpa akun.

### Cara Akses:
1. Buka browser (Chrome, Firefox, Safari, Edge)
2. Ketik URL: `http://127.0.0.1:8000/` (untuk lokal) atau domain website yang sudah deploy
3. Halaman pendaftaran akan langsung ditampilkan

---

## 📝 Proses Pendaftaran Peserta

### Langkah 1: Isi Formula Pendaftaran

Peserta akan melihat form dengan field berikut:

| Field | Tipe | Contoh |
|-------|------|--------|
| **Nama Lengkap** | Text | Silvia Zahrani Firdaus |
| **Umur** | Dropdown | 21-25 tahun |
| **Nomor WhatsApp** | Text | 081234567890 |
| **Asal Institusi** | Text | SMA Negeri 1 Jakarta |
| **Sumber Informasi** | Dropdown | Sosial Media / Teman / Poster |
| **Email** | Text | silvia@example.com |
| **Bukti Pembayaran** | Upload File | Photo/image dari transfer bank |

### Langkah 2: Upload Bukti Pembayaran

Peserta harus upload **bukti transfer bank** (screenshot transfer):
- Format yang diterima: JPG, PNG, PDF
- Ukuran maksimal: Tergantung konfigurasi server
- Cara upload:
  1. **Click atau drag** file ke area upload
  2. Atau klik tombol **"Pilih File"** dan select file dari komputer
  3. File akan langsung terupload ke Cloudinary (cloud storage)

**Tanda Sukses Upload:**
- Nama file muncul di bawah area upload
- Area upload berubah warna menjadi hijau

### Langkah 3: Submit Form

1. Pastikan semua field sudah diisi dengan benar
2. Pastikan bukti pembayaran sudah terupload
3. Klik tombol **"Daftar Sekarang"** (warna hijau)

**Yang Terjadi Setelah Submit:**

✅ **Jika Berhasil:**
- Akan muncul modal popup bertuliskan "Pendaftaran Berhasil!"
- Peserta akan mendapatkan **Kode Tiket** (contoh: SPM-2026-0001)
- Pesan instruksi akan ditampilkan:
  > "Anda telah terdaftar. Admin akan meninjau dan mengirimkan tiket ke email Anda."

❌ **Jika Ada Error:**
- Akan muncul modal popup berwarna merah bertuliskan pesan error
- Biasanya error karena:
  - Ada field yang kosong
  - Email tidak valid
  - File tidak berhasil terupload
- Tombol **"Hubungi Admin via WhatsApp"** akan membantu kirim pesan error ke admin

### Langkah 4: Tunggu Konfirmasi dari Admin

Setelah submit:
1. **Status peserta**: "Menunggu" (pending)
2. **Admin akan meninjau** bukti pembayaran
3. Admin akan **"Terima" atau "Tolak"** pendaftaran
4. Jika diterima, admin akan mengirim **tiket PDF ke email**

---

## 📧 Menerima & Menggunakan Tiket

### Yang Akan Diterima di Email:

Peserta akan menerima email dengan:
- **Subject**: "🎟️ Tiket Anda - Sekolah Pasar Modal Financial Glow Up 2026"
- **Isi Email**: 
  - Kode tiket (SPM-2026-0001)
  - QR Code untuk scan saat acara
  - Informasi acara (waktu, tempat, dll)
  - **PDF Attachment**: Tiket lengkap dengan QR Code

### Cara Menggunakan Tiket:

**Saat Registrasi/Masuk Acara:**
1. Buka email dan download attachment PDF tiket
2. Atau akses langsung dari email
3. **Tunjukkan QR Code** di tiket ke panitia saat masuk acara
4. Panitia akan scan QR Code dengan aplikasi di website
5. Sistem akan otomatis mencatat kehadiran Anda (Status = "Hadir")

---

## 📊 Melacak Status Pendaftaran

Peserta **TIDAK ADA HALAMAN KHUSUS** untuk melacak status. Status hanya dilihat oleh admin.

Jika ingin tahu status:
- 📧 Kontak admin via email
- 💬 Hubungi admin via WhatsApp (jika ada error di form)

---

# 🔐 Panduan untuk Admin

## Login Admin

### URL Login:
```
http://127.0.0.1:8000/admin/login
```

### Kredensial Login:
| Field | Value |
|-------|-------|
| Email | admin@gibei-polinema.ac.id |
| Password | Admin@2026! |

### Cara Login:
1. Masukkan email di field **"Email"**
2. Masukkan password di field **"Password"**
3. **Optional**: Centang **"Remember me"** untuk tetap login di device ini
4. Klik tombol **"Login"** (berwarna hijau)

**Setelah Login:**
- Akan redirect ke halaman Dashboard
- Tersimpan dalam session (aman)

---

## 📊 Dashboard Admin

URL: `http://127.0.0.1:8000/admin/dashboard`

### Informasi yang Ditampilkan:

#### 1. **Statistik Pendaftaran**
- 📥 **Total Peserta**: Total semua pendaftar
- ⏳ **Menunggu (Pending)**: Belum direview admin
- ✅ **Diterima**: Sudah di-approve, tiket sudah dibuat
- ❌ **Ditolak**: Ditolak oleh admin
- 👋 **Hadir**: Peserta yang sudah scan QR saat acara
- 🚪 **Belum Hadir**: Peserta yang belum scan QR

#### 2. **Grafik Umur Peserta**
- Distribusi peserta berdasarkan range umur
- Membantu admin memahami demografis peserta

#### 3. **Grafik Sumber Informasi**
- Dari mana peserta mengetahui acara ini
- Membantu evaluasi marketing

### Tombol Cepat:
- **📋 Kelola Peserta** → Ke halaman daftar peserta
- **📱 Scan QR** → Ke halaman scanning untuk saat acara
- **⚙️ Pengaturan** → Ke halaman settings event

---

## 👥 Kelola Peserta (Participants)

URL: `http://127.0.0.1:8000/admin/participants`

### Tampilan Daftar Peserta:

Tabel yang menampilkan semua peserta dengan kolom:
| Kolom | Keterangan |
|-------|-----------|
| **No** | Nomor urut |
| **Kode Tiket** | ID tiket peserta (SPM-2026-0001) |
| **Nama** | Nama lengkap peserta |
| **Email** | Email peserta |
| **No HP** | Nomor WhatsApp/telpon |
| **Institusi** | Nama sekolah/universitas |
| **Status** | Menunggu / Diterima / Ditolak |
| **Aksi** | Tombol action |

### Filter & Pencarian:

#### Filter by Status:
- Dropdown **"Filter Status"** di atas tabel
- Pilih: Semua / Menunggu / Diterima / Ditolak
- Klik **"Filter"** untuk menampilkan hanya peserta dengan status tersebut

#### Pencarian:
- Input field **"Cari Peserta"**
- Ketik nama, email, atau kode tiket
- Hasil pencarian akan real-time update

### Tombol Aksi untuk Setiap Peserta:

#### 1️⃣ **Tombol "Lihat Bukti"** 🧾
- **Fungsi**: Melihat bukti pembayaran yang di-upload peserta
- **Tampilan**: Gambar atau PDF dari Cloudinary
- Membuka halaman khusus untuk melihat file bukti

#### 2️⃣ **Tombol "Terima"** ✅
- **Fungsi**: Approve/terima pendaftaran peserta
- **Yang Terjadi**:
  1. Status berubah dari "Menunggu" → "Diterima"
  2. Otomatis generate QR Code untuk peserta
  3. Otomatis generate PDF tiket dengan QR Code embedded
  4. Redirect ke halaman **"Konfirmasi Email"**
  5. Admin bisa copy subject & body email
  6. Admin bisa buka Gmail untuk mengirim email manual

#### 3️⃣ **Tombol "Tolak"** ❌
- **Fungsi**: Reject/tolak pendaftaran peserta
- **Yang Terjadi**:
  1. Status berubah menjadi "Ditolak"
  2. Email tidak akan dikirim
  3. Peserta tidak mendapat tiket

#### 4️⃣ **Tombol "Download PDF"** ⬇️
- **Fungsi**: Download tiket PDF peserta (hanya untuk yang sudah diterima)
- **Format**: Ukuran A5 Landscape dengan QR Code embedded
- Bisa langsung print atau dikirim ke peserta

---

## 📧 Alur Email Setelah Approval

### Langkah-Langkah Manual:

Setelah klik **"Terima"**, admin akan masuk ke halaman **"Konfirmasi Email"** dengan:

```
📨 Email akan dikirim ke: peserta@example.com
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
From: admin@gibei-polinema.ac.id
Subject: 🎟️ Tiket Anda - Sekolah Pasar Modal Financial Glow Up 2026

📋 Detail Email:
[Preview email body ditampilkan di halaman]

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

### Opsi Pengiriman Tersedia:

#### **Opsi 1: Copy & Paste ke Gmail** (Paling mudah ⭐)

1. **Klik tombol "Copy Subject"**
   - Subject berhasil di-copy ke clipboard
   - Akan muncul notifikasi "✅ Subject di-copy!"

2. **Klik tombol "Copy Body"**
   - Isi email berhasil di-copy
   - Akan muncul notifikasi "✅ Body di-copy!"

3. **Klik tombol "Buka Gmail"**
   - Akan membuka Gmail compose window (otomatis pre-fill email recipient & subject)
   - Paste body email yang sudah di-copy
   - Klik **"Kirim"** di Gmail

4. **Kembali ke website dan klik "Confirm Email Sent"**
   - Ini menandakan email sudah berhasil dikirim
   - Database akan update: `ticket_sent = true`
   - Status peserta bisa ditampilkan "Tiket sudah dikirim"

#### **Opsi 2: Upgrade ke SMTP** (Untuk production)

Jika ingin otomatis mengirim email tanpa copy-paste:
- Konfigurasi `.env` dengan SMTP provider (Brevo, SendGrid, dll)
- Update `MAIL_MAILER=smtp`
- Email akan otomatis terkirim saat klik "Terima"
- Lihat file `DEPLOYMENT_GUIDE.md` untuk setup SMTP production

---

## 🔍 Lihat Bukti Pembayaran

URL: `/admin/participants/{id}/proof`

### Cara Akses:
1. Dari halaman daftar peserta, klik tombol **"Lihat Bukti"**
2. Atau akses langsung URL

### Tampilan Halaman:

- **Header**: Nama peserta & "Bukti Pembayaran"
- **Info Peserta**: Nama, Email, Kode Tiket, Status
- **Proof Container**: 
  - Jika **gambar** (JPG/PNG): Display gambar langsung
  - Jika **PDF**: Show icon PDF dengan tombol "Buka/Download PDF"
  - Jika gagal load: Show pesan error dengan fallback
- **Tombol Action**:
  - **← Kembali**: Kembali ke daftar peserta
  - **⬇️ Download File**: Download bukti pembayaran

---

## 📱 Scan QR Code (Saat Acara)

URL: `http://127.0.0.1:8000/admin/scan`

### Tujuan:
Mencatat kehadiran peserta dengan scan QR Code dari tiket mereka.

### Cara Menggunakan:

#### **Setup Device:**
1. Siapkan 1-2 device (laptop/tablet) untuk scanning
2. Akses halaman: `http://127.0.0.1:8000/admin/scan`
3. Pastikan kamera/webcam aktif (jika pake laptop)
4. Atau gunakan barcode scanner (jika pake scanner device)

#### **Proses Scanning:**

1. **Peserta datang** dengan membawa/menampilkan tiket PDF (di HP atau print)
2. **Admin scan** QR Code menggunakan:
   - Kamera laptop/webcam (dengan aplikasi web camera)
   - Atau scanner barcode khusus
3. **Sistem otomatis**:
   - Detect QR Code → Baca kode tiket
   - Find peserta dari database
   - Update status attendance: `status = 'hadir'`
   - Catat waktu scan: `scanned_at = timestamp`
   - Catat admin yang scan: `scanned_by = admin_name`
4. **Hasil**:
   - Halaman menampilkan: "Peserta: [Nama] - Kode: SPM-2026-0001 ✅ Kehadiran dicatat"
   - Bisa scan peserta berikutnya

#### **Error Handling:**
- Jika QR tidak terdeteksi → "QR Code tidak terdeteksi, coba lagi"
- Jika kode tidak valid → "Peserta tidak ditemukan"
- Jika sudah scan 2x → "Peserta sudah tercatat hadir sebelumnya"

---

## 📊 Lihat Absensi/Attendance

URL: `http://127.0.0.1:8000/admin/attendance`

### Tampilan:

Tabel yang menampilkan semua log kehadiran dengan kolom:

| Kolom | Keterangan |
|-------|-----------|
| **No** | Nomor urut |
| **Kode Tiket** | SPM-2026-0001 |
| **Nama Peserta** | Nama dari database |
| **Status** | Hadir / Belum Hadir |
| **Waktu Scan** | Tanggal & jam scan QR |
| **Di-scan oleh** | Nama admin yang scan |

### Informasi Berguna:
- **Filter**: Bisa filter hanya peserta yang "Hadir" atau "Belum Hadir"
- **Export**: Bisa download tabel (jika fitur ada)
- **Statistics**: Total hadir vs belum hadir

---

## ⚙️ Pengaturan Event (Settings)

URL: `/admin/dashboard` → Klik **"Pengaturan"**

### Fitur yang Tersedia:

#### 1️⃣ **Toggle Form Pendaftaran** 🔄
- **Tombol**: "Tutup Form" atau "Buka Form"
- **Fungsi**: 
  - **Buka**: Peserta bisa mengakses dan submit form
  - **Tutup**: Form tidak bisa diakses peserta (halaman error 403)
- **Kegunaan**: Untuk pembukaan/penutupan waktu pendaftaran
- **Contoh**: 
  - Hari H-7: Buka form untuk pendaftaran
  - Hari H-1: Tutup form, tidak ada lagi pendaftaran baru

#### 2️⃣ **Upload Header Image** 📸
- **Fungsi**: Mengupload gambar header untuk halaman form peserta
- **Lokasi**: Gambar akan ditampilkan di bagian atas form registrasi peserta
- **Format**: JPG, PNG
- **Kegunaan**: Branding event, gambar sponsor, banner promosi

**Cara Upload:**
1. Klik **"Pilih File"**
2. Select gambar dari komputer
3. Klik **"Upload"**
4. Gambar akan otomatis tersimpan dan tampil di halaman form peserta

---

## 🔓 Logout Admin

### Cara Logout:
1. Klik menu **"Logout"** atau **"Keluar"** (biasanya di kanan atas)
2. Admin akan di-redirect ke halaman login
3. Session berakhir, harus login lagi untuk akses admin panel

---

# 🆘 Troubleshooting

## Masalah & Solusi

### ❓ **Peserta**: Tidak bisa submit form
**Solusi:**
1. Pastikan semua field sudah diisi
2. Email harus format valid (contoh: nama@domain.com)
3. File bukti pembayaran sudah terupload (cek nama file muncul)
4. Ukuran file tidak terlalu besar
5. Coba refresh halaman atau clear browser cache

### ❓ **Peserta**: Upload file gagal
**Solusi:**
1. Pastikan format file: JPG, PNG, atau PDF
2. Ukuran file < 10MB (atau sesuai konfigurasi)
3. Koneksi internet stabil
4. Coba drag-drop atau klik "Pilih File"
5. Gunakan browser yang lebih baru (Chrome, Firefox, Edge)

### ❓ **Peserta**: Error saat submit, bagaimana hubungi admin?
**Solusi:**
1. Akan muncul modal berwarna merah dengan pesan error
2. Klik tombol **"Hubungi Admin via WhatsApp"**
3. WhatsApp akan terbuka dengan pesan error otomatis
4. Send pesan ke admin dengan detail error

### ❓ **Admin**: Lupa password login
**Solusi:**
1. Hubungi super admin/developer
2. Password bisa direset via database atau command artisan:
   ```bash
   php artisan tinker
   >>> $admin = App\Models\Admin::first();
   >>> $admin->password = Hash::make('password_baru');
   >>> $admin->save();
   ```

### ❓ **Admin**: Tidak bisa login (email/password salah)
**Solusi:**
1. Pastikan email benar: `admin@gibei-polinema.ac.id`
2. Pastikan caps lock OFF (keyboard case-sensitive)
3. Password default: `Admin@2026!` (ada simbol ! di akhir)
4. Coba clear browser cache & cookies
5. Coba browser lain

### ❓ **Admin**: QR scan tidak bekerja
**Solusi:**
1. Pastikan kamera/webcam aktif dan terakses di browser
2. Izinkan akses kamera di browser settings
3. QR Code di tiket harus jelas visible (tidak terputus)
4. Lighting harus cukup terang
5. Coba lakukan manual entry jika scanner tidak support

### ❓ **Admin**: Email tidak terkirim ke peserta
**Solusi:**
- **Jika menggunakan manual workflow (copy-paste)**:
  1. Pastikan sudah copy subject & body
  2. Pastikan sudah paste ke Gmail
  3. Pastikan email peserta benar
  4. Cek folder Gmail (spam, inbox, dll)
  5. Setelah kirim manual, klik "Confirm Email Sent" di website

- **Jika SMTP mode configuration**:
  1. Cek `.env` file SMTP settings
  2. Pastikan MAIL_MAILER=smtp
  3. Cek credential SMTP provider (username, password)
  4. Cek log file: `storage/logs/laravel.log`

### ❓ **Admin**: Peserta tidak muncul di daftar
**Solusi:**
1. Pastikan peserta sudah submit form (cek status "Menunggu")
2. Coba filter ulang atau refresh halaman
3. Gunakan search pencarian dengan nama/email
4. Cek database via tinker:
   ```bash
   php artisan tinker
   >>> App\Models\Participant::count() // total peserta
   ```

### ❓ **General**: Halaman error 500 Internal Server Error
**Solusi:**
1. Cek error log: `storage/logs/laravel.log`
2. Pastikan `.env` file sudah benar
3. Pastikan database connection aktif
4. Jalankan commands:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```
5. Restart server: `php artisan serve`

---

## 📞 Kontak Support

Jika ada pertanyaan atau error yang tidak bisa diselesaikan:

- **Email**: admin@gibei-polinema.ac.id
- **WhatsApp**: 085731932717 (untuk emergency/error)
- **GitHub Issues**: https://github.com/flowrestia/spm-event/issues

---

**Dokumentasi dibuat**: April 18, 2026  
**Versi Sistem**: 1.0  
**Last Updated**: Post-deployment verification
