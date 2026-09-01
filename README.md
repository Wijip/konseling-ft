# Konseling FT — Sistem Konseling Fakultas Teknik UNESA

Aplikasi web konseling internal untuk karyawan, mahasiswa, dan Dosen Fakultas Teknik UNESA. Menyediakan layanan konseling melalui **Chat Online** dan **Pertemuan Langsung (Tatap Muka / Zoom)** dengan dukungan fitur anonimitas, tracking, dan **notifikasi email otomatis**.

---

## Fitur Utama

### Sisi Karyawan (Public)
- **Pilih Mode Konseling** — Chat Online atau Jadwalkan Pertemuan (Langsung / Zoom)
- **Pilih Identitas** — Non-Anonim (dengan data diri) atau Anonim (privasi penuh)
- **Chat Online** — Sampaikan keluhan secara tertulis dengan sistem pesan real-time (polling)
- **Booking Pertemuan** — Pilih jadwal, tentukan tipe pertemuan (Langsung/Zoom), dan ajukan booking
- **Tracking** — Lacak status konseling/booking menggunakan kode tracking unik
- **Notifikasi Email** — Menerima email otomatis saat admin membalas chat atau mengubah status booking

### Sisi Admin (Dashboard)
- **Dashboard** — Statistik real-time: total konseling, konseling aktif, total booking, booking mendatang
- **Manajemen Konseling** — Lihat daftar sesi konseling, baca pesan, balas melalui chat (otomatis kirim email), dan **Export ke Excel / PDF**
- **Manajemen Booking** — Review booking pertemuan, setujui/tolak dengan modal popup (otomatis kirim email), dan **Export ke Excel / PDF**
- **Manajemen Jadwal** — Buat dan kelola jadwal pertemuan konselor
- **Manajemen Konselor** — Kelola akun dan data konselor Fakultas Teknik

### Notifikasi Email
| Event | Email Class | Deskripsi |
|-------|-------------|-----------|
| **Admin membalas chat** | `CounselingReplyMail` | Karyawan menerima email berisi balasan admin |
| **Status booking diupdate** | `MeetingStatusMail` | Karyawan menerima email status booking (Disetujui / Ditolak) |

### Status Booking Otomatis
| Status | Keterangan |
|--------|------------|
| **Pending** | Belum dibalas admin |
| **Disetujui** | Admin menyetujui booking |
| **Ditolak** | Admin menolak booking |
| **Selesai** | Otomatis — jika disetujui & sudah melewati jadwal |

---

## Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| **Framework** | Laravel 11 |
| **PHP** | ^8.2 |
| **Database** | MySQL |
| **Frontend** | Blade Templates + Tailwind CSS (via Vite) |
| **Interaktivitas** | Alpine.js |
| **Email** | SMTP (Gmail / lainnya) |
| **Testing** | PHPUnit + Laravel Enlightn |
| **Security** | CSP Headers, Login Throttling, CSRF, x-cloak FOUC prevention |
| **Server** | PHP Artisan Serve (development) |

---

## 📁 Struktur Project

```
konseling-ft/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                         # Controller admin
│   │   │   │   ├── CounselingController.php    # Manajemen konseling + reply + email + export
│   │   │   │   ├── DashboardController.php     # Statistik dashboard
│   │   │   │   ├── MeetingBookingController.php # Manajemen booking pertemuan + email + export
│   │   │   │   ├── MeetingScheduleController.php # Manajemen jadwal
│   │   │   │   └── CounselorController.php      # Kelola data konselor
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php         # Login / logout admin
│   │   │   ├── CounselingController.php        # Public counseling flow
│   │   │   ├── MeetingController.php           # Public meeting booking flow
│   │   │   ├── HomeController.php              # Landing page
│   │   │   └── TrackingController.php          # Tracking system
│   │   └── Middleware/
│   │       └── SecurityHeaders.php             # CSP, X-Frame, XSS Protection headers
│   ├── Mail/
│   │   ├── CounselingReplyMail.php             # Email balasan konseling
│   │   └── MeetingStatusMail.php               # Email status booking
│   ├── Models/
│   │   ├── User.php
│   │   ├── CounselingSession.php
│   │   ├── CounselingMessage.php
│   │   ├── MeetingBooking.php
│   │   └── MeetingSchedule.php
│   └── Providers/
├── config/
│   └── enlightn.php                            # Konfigurasi Laravel Enlightn
├── database/
│   ├── migrations/                             # Migration files
│   ├── factories/                              # Model factories untuk testing
│   │   ├── CounselingSessionFactory.php
│   │   ├── CounselingMessageFactory.php
│   │   ├── MeetingScheduleFactory.php
│   │   ├── MeetingBookingFactory.php
│   │   └── UserFactory.php
│   └── seeders/
│       └── DatabaseSeeder.php                  # Seed admin, konselor, dan jadwal
├── public/
│   ├── build/                                  # Hasil kompilasi Tailwind CSS & JS (Vite)
│   └── images/                                 # Logo dan gambar hero
├── resources/
│   ├── css/                                    # Stylesheet utama (Tailwind CSS)
│   ├── js/                                     # Entry point JavaScript & Alpine.js
│   └── views/
│       ├── admin/                              # Views admin panel
│       ├── emails/                             # Email templates
│       ├── errors/                             # Custom error pages
│       │   ├── 403.blade.php
│       │   ├── 404.blade.php
│       │   └── 500.blade.php
│       ├── public/                             # Views public (karyawan)
│       ├── layouts/                            # Layout templates (app, public)
│       └── components/                         # Blade components
├── routes/
│   ├── web.php                                 # Semua route definitions
│   └── console.php                             # Console commands
├── tests/
│   ├── Feature/                                # Feature tests (69 tests)
│   │   ├── AdminFilterTest.php                 # Filter konseling & booking
│   │   ├── AdminTest.php                       # Dashboard, CRUD, reply, schedule
│   │   ├── AuthTest.php                        # Login, logout, role access
│   │   ├── CounselingTest.php                  # Form, validasi, chat, pesan
│   │   ├── MeetingTest.php                     # Calendar, booking, slot check
│   │   └── TrackingTest.php                    # Tracking code lookup
│   └── Unit/
├── composer.json
├── package.json                                # Konfigurasi Vite & Tailwind CSS
├── vite.config.js                              # Build tool configuration
└── .env                                        # Environment configuration
```

---

## Instalasi & Setup

### Prasyarat

Pastikan software berikut sudah terinstall di komputer Anda:

| Software | Versi Minimum | Keterangan |
|----------|---------------|------------|
| **PHP** | >= 8.2 | Cek: `php -v` |
| **Composer** | >= 2.x | Cek: `composer -V` |
| **Node.js & NPM** | Node >= 18.x, NPM >= 9.x | Cek: `node -v` & `npm -v` |
| **MySQL** | >= 5.7 (atau MariaDB >= 10.3) | Cek: `mysql --version` |
| **Git** | Terbaru | Cek: `git --version` |

> [!TIP]
> Gunakan **XAMPP** atau **Laragon** untuk kemudahan setup PHP & MySQL sekaligus.
> - **XAMPP**: [https://www.apachefriends.org](https://www.apachefriends.org)
> - **Laragon**: [https://laragon.org](https://laragon.org) *(Rekomendasi untuk Windows)*

---

### Langkah Instalasi

#### 1️ Clone Repository

```bash
git clone <repository-url>
cd konseling-ft
```

#### 2️ Install Dependencies PHP

```bash
composer install
```

#### 3️ Install Dependencies JavaScript & CSS (Node.js)

```bash
npm install
```

#### 4️ Konfigurasi Environment

Copy file `.env.example` menjadi `.env`:

```bash
# Linux / macOS
cp .env.example .env

# Windows (Command Prompt)
copy .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env
```

#### 5️ Generate Application Key

```bash
php artisan key:generate
```

#### 6️ Buat Database MySQL

Buat database baru dengan nama `konseling_ft`. Pilih salah satu cara:

**Cara 1 — Via Terminal MySQL:**
```sql
mysql -u root -p
CREATE DATABASE konseling_ft CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

**Cara 2 — Via phpMyAdmin (XAMPP):**
1. Buka `http://localhost/phpmyadmin`
2. Klik tab **"Databases"**
3. Isi nama database: `konseling_ft`
4. Pilih collation: `utf8mb4_unicode_ci`
5. Klik **"Create"**

#### 7️ Sesuaikan Konfigurasi `.env`

Buka file `.env` dan sesuaikan bagian database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=konseling_ft
DB_USERNAME=root
DB_PASSWORD=
```

> [!NOTE]
> Jika menggunakan XAMPP, biasanya `DB_USERNAME=root` dan `DB_PASSWORD=` (kosong).
> Jika menggunakan Laragon, sama: `root` tanpa password.

#### 8️ Konfigurasi Email SMTP *(Opsional)*

Untuk mengaktifkan fitur notifikasi email, edit bagian `MAIL_*` di file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD="your-app-password"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

> [!IMPORTANT]
> Lihat bagian **[📧 Konfigurasi Email (Gmail SMTP)](#-konfigurasi-email-gmail-smtp)** di bawah untuk panduan lengkap mendapatkan App Password Gmail.

#### 9️ Jalankan Migrasi & Seeder Database

```bash
php artisan migrate --seed
```

Perintah ini akan membuat seluruh tabel beserta data awal:
- **1 akun Admin** — `admin@unesa.ac.id` (password: `password`)
- **4 akun Konselor** — Erlinda, Saskia, Ekin, Joko
- **Jadwal contoh** — 2 hari ke depan (hari kerja)

#### 10 Kompilasi Aset Frontend (Tailwind CSS)

Sebelum menjalankan server, kompilasi aset Tailwind CSS menggunakan perintah berikut:

```bash
# Untuk Production / Testing (Satu Kali Build)
npm run build

# Untuk Development (Hot Reloading / Edit Kode Aktif)
npm run dev
```

#### 11 Jalankan Server Development

- **Akses Lokal Komputer Ini saja:**
  ```bash
  php artisan serve
  ```
  Aplikasi akan berjalan di: **http://127.0.0.1:8000** 🎉

- **Akses dari Perangkat Lain (HP / Laptop Lain dalam 1 Jaringan Wi-Fi):**
  ```bash
  php artisan serve --host=0.0.0.0 --port=8000
  ```

---

### 📲 Cara Mengakses Aplikasi dari Perangkat Lain (Network Sharing)

Jika Anda menjalankan server dengan perintah `php artisan serve --host=0.0.0.0 --port=8000`, aplikasi dapat diakses oleh HP/laptop lain yang terhubung ke jaringan Wi-Fi yang sama.

#### Cara Mengecek IP Address di Windows:
1. Buka **Task Manager** (`Ctrl + Shift + Esc`).
2. Setelah terbuka, buka tab **Performance**.
3. Kemudian buka bagian tab **Wi-Fi** atau **Ethernet**.
4. Akan terdapat **IPv4 address** (contoh format: `192.168.1.15` atau `192.168.xx.xx`).
5. Buka browser di perangkat lain lalu ketik alamat IP tersebut diikuti dengan port `:8000`.
   > **Contoh Akses:** `http://192.168.1.15:8000`

---

### ⚠️ Troubleshooting

| Masalah | Solusi |
|---------|--------|
| `SQLSTATE[HY000] [1049] Unknown database` | Pastikan database `konseling_ft` sudah dibuat (Langkah 6) |
| `SQLSTATE[HY000] [2002] Connection refused` | Pastikan MySQL sudah berjalan (start XAMPP/Laragon) |
| `No application encryption key has been specified` | Jalankan `php artisan key:generate` |
| Tampilan website berantakan / CSS tidak muncul | Jalankan perintah `npm run build` terlebih dahulu |
| `composer install` / `npm install` gagal | Pastikan versi PHP >= 8.2 dan Node.js >= 18.x terpasang |
| Email tidak terkirim | Periksa konfigurasi SMTP di `.env` dan pastikan App Password benar |

---

## 📧 Konfigurasi Email (Gmail SMTP)

Untuk mengirim notifikasi email melalui Gmail:

1. **Aktifkan 2-Step Verification** di akun Google Anda.
2. **Buat App Password**:
   - Google Account → Security → 2-Step Verification → App passwords
   - Generate password baru untuk "Mail"
3. **Edit file `.env`**, masukkan:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD="generated-app-password"
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your-email@gmail.com"
   MAIL_FROM_NAME="Konseling FT"
   ```

> ⚠️ **Penting:** Jangan gunakan password utama Gmail. Gunakan **App Password** yang digenerate dari Google.

---

## 🔑 Akun Default

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@unesa.ac.id` | `password` |
| **Konselor** | `budi@unesa.ac.id` | `password` |

> 🔑 **Penting:** Ganti password default sebelum deploy ke production!

---

## 🔄 Alur Aplikasi

### Alur Karyawan
```
Landing Page → Pilih Mode Konseling
  ├── Chat Online → Pilih Identitas → Isi Form (+ Email) → Konfirmasi (Tracking Code) → Chat
  └── Pertemuan (Langsung/Zoom) → Pilih Tanggal → Pilih Slot → Isi Form (+ Email) → Konfirmasi (Tracking Code)
```

### Alur Admin
```
Login → Dashboard
  ├── Konseling → Lihat Daftar → Baca & Balas Chat → (Email notifikasi terkirim otomatis)
  ├── Booking → Lihat Daftar → Setujui / Tolak (Modal Popup) → (Email notifikasi terkirim otomatis)
  ├── Jadwal → Lihat Daftar → Tambah Jadwal Baru
  └── Konselor → Lihat Daftar → Tambah / Hapus Konselor Baru
```

---

## 🛣️ Route Utama

### Public Routes (Karyawan)

| URL | Method | Deskripsi |
|-----|--------|-----------|
| `/` | GET | Landing page |
| `/counseling/mode` | GET | Pilih mode konseling |
| `/counseling/identity` | GET | Pilih identitas (anonim/non-anonim) |
| `/counseling/form/{type}` | GET | Form konseling chat |
| `/counseling` | POST | Submit form konseling |
| `/counseling/{code}/confirmation` | GET | Halaman konfirmasi & tracking code |
| `/counseling/{code}/chat` | GET | Halaman chat konseling |
| `/counseling/{code}/message` | POST | Kirim pesan chat |
| `/counseling/{code}/messages` | GET | Polling pesan baru (API) |
| `/meeting/calendar` | GET | Kalender booking pertemuan |
| `/meeting/book/{schedule}` | GET | Form booking pertemuan |
| `/meeting` | POST | Submit booking pertemuan |
| `/tracking` | GET | Halaman tracking |
| `/tracking` | POST | Cek tracking code |
| `/tracking/{code}` | GET | Hasil tracking |

### Admin Routes (Protected — require login)

| URL | Method | Deskripsi |
|-----|--------|-----------|
| `/admin/login` | GET/POST | Login admin |
| `/admin` | GET | Dashboard admin |
| `/admin/counseling` | GET | Daftar konseling |
| `/admin/counseling/{id}` | GET | Detail & reply konseling |
| `/admin/counseling/{id}/reply` | POST | Kirim balasan (+ email) |
| `/admin/bookings` | GET | Daftar booking pertemuan |
| `/admin/bookings/{id}` | PUT | Update status booking (+ email) |
| `/admin/bookings/export` | GET | Export data booking (Excel / PDF) |
| `/admin/schedules` | GET | Daftar jadwal |
| `/admin/schedules/create` | GET/POST | Tambah jadwal baru |
| `/admin/counselors` | GET/POST/DELETE | Kelola data konselor |

---

## 📖 Manual Book — Panduan Penggunaan Website

### 👤 Panduan untuk Karyawan (User)

#### 1. Mengakses Website
1. Buka browser dan akses alamat website Konseling FT.
2. Anda akan melihat **halaman utama (Landing Page)** dengan dua tombol:
   - **Mulai Konseling** — untuk memulai sesi konseling.
   - **Cek Status** — untuk melacak status konseling atau booking yang sudah diajukan.

#### 2. Memulai Konseling Chat Online
1. Klik tombol **"Mulai Konseling"** di halaman utama.
2. Pada halaman **Pilih Mode Konseling**, pilih **"Chat Online"**.
3. Pada halaman **Pilih Identitas**, pilih salah satu:
   - **Non-Anonim (Open)** — Anda mengisi data diri lengkap (nama, NIP, divisi, jabatan).
   - **Anonim** — Identitas Anda dirahasiakan sepenuhnya.
4. Isi **Form Konseling**:
   - Jika memilih **Non-Anonim**: isi Nama, NIP/NPP, Divisi, Jabatan, Email (opsional), Topik Masalah, Lama Masalah, dan Deskripsi.
   - Jika memilih **Anonim**: isi Email (opsional), Topik Masalah, Lama Masalah, dan Deskripsi saja.
5. Klik **"Kirim"**.
6. Anda akan diarahkan ke halaman **Konfirmasi** yang menampilkan **Kode Tracking** unik.
   > **Penting:** Simpan kode tracking ini! Kode ini digunakan untuk melacak status dan mengakses chat.
7. Klik **"Masuk ke Chat"** untuk mulai mengirim pesan ke konselor.
8. Jika mengisi email, Anda akan menerima **notifikasi email** setiap kali admin membalas.

#### 3. Booking Pertemuan (Langsung / Zoom)
1. Klik tombol **"Mulai Konseling"** di halaman utama.
2. Pada halaman **Pilih Mode Konseling**, pilih **"Jadwalkan Pertemuan"**.
3. Pada halaman **Kalender**, pilih tanggal yang tersedia (ditandai dengan indikator).
4. Pilih **slot waktu** yang tersedia dari daftar di bawah kalender.
5. Isi **Form Booking Pertemuan**:
   - **Nama Lengkap** — nama lengkap Anda.
   - **NIP** — nomor identitas pegawai.
   - **Divisi** — pilih divisi Anda dari dropdown.
   - **Jabatan** — pilih jabatan (Struktural / Fungsional / Staff).
   - **Email** — alamat email untuk menerima notifikasi status.
   - **Tipe Pertemuan** — pilih salah satu:
     - 🏢 **Pertemuan Langsung** — hadir di ruangan konseling.
     - 💻 **Online (Zoom)** — via video conference (link akan dikirim melalui tracking).
   - **Topik yang Ingin Dibahas** — jelaskan secara singkat masalah Anda.
6. Klik **"Booking Sekarang"**.
7. Anda akan diarahkan ke halaman tracking dengan **Kode Tracking** unik.
   > ⚠️ **Penting:** Simpan kode tracking ini untuk memantau status booking Anda.
8. Jika mengisi email, Anda akan menerima **notifikasi email** saat admin mengubah status booking.

#### 4. Melacak Status (Tracking)
1. Klik **"Cek Status"** di halaman utama, atau akses menu **Cek Status** di navbar.
2. Masukkan **Kode Tracking** yang diberikan saat mengajukan konseling/booking.
3. Klik **"Cek Status"**.
4. Halaman hasil tracking akan menampilkan:
   - **Status** pengajuan Anda (Pending / Disetujui / Selesai / Ditolak).
   - **Detail** informasi booking atau konseling.
   - **Catatan Admin** — balasan atau instruksi dari admin (jika ada).
   - Untuk konseling chat: tombol **"Masuk ke Chat"** untuk melanjutkan percakapan.

---

### 🛡️ Panduan untuk Admin

#### 1. Login ke Dashboard Admin
1. Akses halaman `/admin/login` atau klik **"Admin Login"** di navbar.
2. Masukkan **Email** dan **Password** akun admin.
3. Klik **"Login"**.
4. Anda akan diarahkan ke **Dashboard Admin**.

#### 2. Dashboard
- Setelah login, Anda melihat ringkasan statistik:
  - **Total Konseling** — jumlah total sesi konseling yang masuk.
  - **Konseling Aktif** — sesi yang sedang berlangsung atau menunggu balasan.
  - **Total Booking** — jumlah total booking pertemuan.
  - **Booking Mendatang** — booking yang sudah disetujui dan belum melewati jadwal.
- Di bagian bawah terdapat **daftar terbaru** konseling dan booking.

#### 3. Mengelola Konseling
1. Klik menu **"Konseling Chat"** di sidebar.
2. Anda akan melihat **tabel daftar konseling** dengan informasi:
   - Identitas (Open / Anonim), Nama, Jabatan, Divisi, Topik Masalah, Status.
3. Klik **"Detail / Reply"** pada baris yang diinginkan.
4. Pada halaman detail, Anda bisa:
   - **Membaca pesan** dari karyawan.
   - **Membalas chat** menggunakan kolom input di bawah.
   - **Mengubah status** konseling (Pending → In Progress → Completed / Rejected).
   - **Menghapus sesi** jika diperlukan.
5. Saat membalas, jika karyawan mengisi email maka **email notifikasi otomatis terkirim**.

#### 4. Mengelola Booking Pertemuan
1. Klik menu **"Konseling Pertemuan" → "Kelola Booking"** di sidebar.
2. Anda akan melihat **tabel daftar booking** dengan informasi:
   - Kode Tracking, Tipe (Langsung/Online), Jadwal, Konselor, Nama, Jabatan, Divisi, Tujuan, Status.
3. Klik **"Update"** pada baris yang ingin diproses.
4. Pada modal popup yang muncul:
   - Pilih **Status**:
     - ✅ **Disetujui** — menyetujui permintaan booking.
     - ❌ **Ditolak** — menolak permintaan booking.
   - Tulis **Balasan / Catatan** untuk karyawan (opsional, tapi sangat disarankan).
     > 💡 **Tips:** Jika tipe pertemuan adalah **Online (Zoom)**, tuliskan link Zoom di kolom catatan agar karyawan bisa melihatnya melalui tracking.
   - Klik **"💾 Simpan"** untuk menyimpan perubahan.
5. Saat mengubah status, jika karyawan mengisi email maka **email notifikasi otomatis terkirim**.
6. Anda juga dapat melakukan **Export Data** ke format **Excel** atau **PDF**.

#### 5. Mengelola Jadwal Pertemuan & Konselor
1. Klik menu **"Konseling Pertemuan" → "Kelola Slot Jadwal"** di sidebar untuk mengatur ketersediaan tanggal & waktu konselor.
2. Klik menu **"Konseling Pertemuan" → "Kelola Konselor"** untuk menambah atau menghapus data akun konselor Fakultas Teknik.

---

## 🗄️ Database Schema

### Tabel Utama

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Admin & konselor accounts |
| `counseling_sessions` | Sesi konseling (tracking code, identitas, topik, status, email) |
| `counseling_messages` | Pesan-pesan dalam sesi konseling |
| `meeting_schedules` | Jadwal pertemuan yang tersedia |
| `meeting_bookings` | Booking pertemuan karyawan (tracking code, tipe, status, email) |
| `sessions` | Laravel session storage |
| `cache` | Laravel cache storage |
| `jobs` | Laravel queue jobs |

### Migrasi (14 files)
| Migration | Deskripsi |
|-----------|-----------|
| `create_users_table` | Tabel users dasar |
| `create_cache_table` | Tabel cache Laravel |
| `create_jobs_table` | Tabel jobs (queue) |
| `create_counseling_sessions_table` | Sesi konseling |
| `create_counseling_messages_table` | Pesan konseling |
| `create_meeting_schedules_table` | Jadwal pertemuan |
| `create_meeting_bookings_table` | Booking pertemuan |
| `add_konselor_name_to_meeting_schedules` | Nama konselor di jadwal |
| `add_topic_duration_to_counseling_sessions` | Topik & durasi di sesi |
| `fix_sender_type_in_counseling_messages` | Fix sender type pesan |
| `update_counselors_list` | Update daftar konselor |
| `add_jabatan_to_counseling_and_bookings` | Kolom jabatan |
| `add_meeting_type_to_meeting_bookings_table` | Kolom tipe pertemuan (Langsung/Zoom) |
| `add_email_columns_to_bookings_and_sessions` | Kolom email untuk notifikasi |

---

## 🧪 Testing & Quality Assurance

### Menjalankan Test

```bash
php artisan test
```

**Total: 69 tests, 159 assertions — semua PASS ✅**

---

### 1. AuthTest (6 tests) — Autentikasi & Otorisasi

| # | Test | Deskripsi | Yang Diverifikasi |
|---|------|-----------|-------------------|
| 1 | `admin_can_login_with_valid_credentials` | Admin login dengan email & password benar | Redirect ke dashboard, user terotentikasi |
| 2 | `konselor_can_login` | Konselor login dengan kredensial valid | Redirect ke dashboard, role konselor diterima |
| 3 | `login_fails_with_wrong_password` | Login gagal jika password salah | Session error, tetap sebagai guest |
| 4 | `non_admin_user_cannot_login` | User biasa (role 'user') tidak bisa login | Session error, akses ditolak |
| 5 | `admin_routes_require_authentication` | Akses halaman admin tanpa login | Redirect ke halaman login |
| 6 | `user_can_logout` | Admin logout dari sistem | Redirect ke beranda, session berakhir |

---

### 2. CounselingTest (14 tests) — Alur Konseling Karyawan

| # | Test | Deskripsi | Yang Diverifikasi |
|---|------|-----------|-------------------|
| 1 | `it_shows_counseling_mode_page` | Tampilkan halaman pilih mode konseling | HTTP 200 |
| 2 | `it_shows_identity_selection_page` | Tampilkan halaman pilih identitas | HTTP 200 |
| 3 | `it_shows_open_identity_form` | Tampilkan form identitas terbuka (non-anonim) | HTTP 200 |
| 4 | `it_shows_anonymous_identity_form` | Tampilkan form identitas anonim | HTTP 200 |
| 5 | `it_returns_404_for_invalid_identity_type` | Akses form dengan tipe identitas tidak valid | HTTP 404 |
| 6 | `it_can_submit_open_counseling_form` | Submit form konseling non-anonim lengkap | Data tersimpan di DB, tracking code tergenerate, redirect ke konfirmasi |
| 7 | `it_can_submit_anonymous_counseling_form` | Submit form konseling anonim | Data tersimpan tanpa nama/email, redirect ke konfirmasi |
| 8 | `it_validates_required_fields_for_open_identity` | Submit form non-anonim tanpa nama, email, dll | Validasi error untuk field wajib |
| 9 | `it_validates_issue_description_is_required` | Submit form tanpa deskripsi masalah | Validasi error: issue_description wajib |
| 10 | `it_shows_confirmation_page_with_valid_code` | Akses halaman konfirmasi dengan kode valid | HTTP 200, tracking code ditampilkan |
| 11 | `it_returns_404_for_invalid_confirmation_code` | Akses konfirmasi dengan kode tidak valid | HTTP 404 |
| 12 | `it_shows_chat_page` | Tampilkan halaman chat untuk sesi yang ada | HTTP 200 |
| 13 | `user_can_send_message` | Karyawan mengirim pesan chat | Pesan tersimpan di DB, sender_type = 'user' |
| 14 | `user_cannot_send_message_to_completed_session` | Kirim pesan ke sesi yang sudah selesai | HTTP 403 (diblokir) |

---

### 3. MeetingTest (11 tests) — Alur Booking Pertemuan

| # | Test | Deskripsi | Yang Diverifikasi |
|---|------|-----------|-------------------|
| 1 | `meeting_index_redirects_to_calendar` | Akses `/meeting` redirect ke kalender | Redirect ke halaman kalender |
| 2 | `it_shows_calendar_page` | Tampilkan halaman kalender | HTTP 200 |
| 3 | `calendar_shows_available_slots` | Kalender menampilkan slot yang tersedia | HTTP 200, view data `selectedDateSlots` |
| 4 | `it_shows_booking_form_for_available_slot` | Tampilkan form booking untuk slot tersedia | HTTP 200 |
| 5 | `it_redirects_if_slot_is_full` | Akses form booking untuk slot penuh | Redirect ke kalender |
| 6 | `it_redirects_if_slot_is_unavailable` | Akses form booking untuk slot tidak tersedia | Redirect ke kalender |
| 7 | `it_can_submit_meeting_booking` | Submit booking pertemuan lengkap | Booking tersimpan, `booked_slots` bertambah, tracking code `MB-XXXXX` |
| 8 | `it_prevents_booking_when_slot_is_full` | Submit booking saat slot sudah penuh | Validasi error, booking tidak tersimpan |
| 9 | `it_validates_booking_form_fields` | Submit booking tanpa field wajib | Validasi error untuk semua field |
| 10 | `auto_complete_changes_approved_booking_to_completed` | Booking approved yang sudah lewat jadwal | Status otomatis berubah ke 'completed' |
| 11 | `auto_complete_does_not_change_future_bookings` | Booking approved yang belum lewat jadwal | Status tetap 'approved' |

---

### 4. TrackingTest (7 tests) — Sistem Pelacakan

| # | Test | Deskripsi | Yang Diverifikasi |
|---|------|-----------|-------------------|
| 1 | `it_shows_tracking_search_page` | Tampilkan halaman input tracking code | HTTP 200 |
| 2 | `it_redirects_for_valid_counseling_tracking_code` | Submit kode tracking konseling valid | Redirect ke halaman hasil tracking |
| 3 | `it_redirects_for_valid_booking_tracking_code` | Submit kode tracking booking valid | Redirect ke halaman hasil tracking |
| 4 | `it_returns_error_for_invalid_tracking_code` | Submit kode tracking yang tidak ada | Session error |
| 5 | `it_shows_counseling_tracking_result` | Tampilkan hasil tracking konseling | HTTP 200, type = 'counseling' |
| 6 | `it_shows_booking_tracking_result` | Tampilkan hasil tracking booking | HTTP 200, type = 'meeting' |
| 7 | `it_redirects_for_nonexistent_tracking_show` | Akses halaman tracking dengan kode tidak ada | Redirect ke halaman tracking |

---

### 5. AdminTest (18 tests) — Dashboard & Manajemen Admin

| # | Test | Deskripsi | Yang Diverifikasi |
|---|------|-----------|-------------------|
| 1 | `it_shows_dashboard_with_stats` | Dashboard menampilkan statistik | HTTP 200, data: totalCounseling, activeCounseling, totalBookings, upcomingBookings |
| 2 | `it_shows_counseling_sessions_list` | Daftar sesi konseling | HTTP 200, data sessions tersedia |
| 3 | `it_shows_single_counseling_session` | Detail satu sesi konseling | HTTP 200, data session & messages |
| 4 | `admin_can_update_counseling_status` | Update status konseling (pending → in_progress) | Status berubah di DB |
| 5 | `admin_cannot_set_invalid_counseling_status` | Update status ke nilai tidak valid | Validasi error |
| 6 | `admin_can_reply_to_counseling_session` | Admin membalas chat konseling | Pesan tersimpan, sender_type = 'admin' |
| 7 | `replying_auto_updates_pending_status_to_in_progress` | Reply otomatis ubah status pending → in_progress | Status auto-update |
| 8 | `admin_cannot_reply_to_completed_session` | Reply ke sesi yang sudah selesai | HTTP 403 (diblokir) |
| 9 | `admin_can_delete_counseling_session` | Hapus sesi konseling beserta pesannya | Data terhapus dari DB (cascade) |
| 10 | `it_shows_booking_list` | Daftar semua booking pertemuan | HTTP 200, data bookings tersedia |
| 11 | `admin_can_approve_booking` | Admin menyetujui booking | Status → 'approved', catatan admin tersimpan |
| 12 | `admin_can_reject_booking` | Admin menolak booking | Status → 'rejected', catatan admin tersimpan |
| 13 | `booking_status_must_be_valid` | Update status booking ke nilai tidak valid | Validasi error |
| 14 | `it_shows_schedule_list` | Daftar jadwal pertemuan | HTTP 200, data schedules |
| 15 | `it_shows_schedule_create_form` | Form tambah jadwal baru | HTTP 200 |
| 16 | `admin_can_create_new_schedule` | Buat jadwal baru lengkap | Jadwal tersimpan di DB |
| 17 | `schedule_validates_date_not_in_past` | Buat jadwal dengan tanggal lampau | Validasi error |
| 18 | `schedule_validates_end_time_after_start_time` | Waktu selesai sebelum waktu mulai | Validasi error |

---

### 6. AdminFilterTest (5 tests) — Filter Data Admin

| # | Test | Deskripsi | Yang Diverifikasi |
|---|------|-----------|-------------------|
| 1 | `it_can_filter_counseling_sessions_by_status` | Filter konseling berdasarkan status | Hanya data dengan status yang dipilih |
| 2 | `it_can_filter_counseling_sessions_by_identity` | Filter konseling berdasarkan tipe identitas | Hanya data open/anonymous yang dipilih |
| 3 | `it_can_filter_bookings_by_status` | Filter booking berdasarkan status | Hanya booking dengan status yang dipilih |
| 4 | `it_can_filter_bookings_by_type` | Filter booking berdasarkan tipe (online/offline) | Hanya booking dengan tipe yang dipilih |
| 5 | `it_can_filter_bookings_by_konselor` | Filter booking berdasarkan nama konselor | Hanya booking dari konselor yang dipilih |

---

### Laravel Enlightn (Skor: 89%)

```bash
php artisan enlightn
```

| Kategori | Skor |
|----------|------|
| **Performance** | 75% (0 failed) ✅ |
| **Reliability** | 100% (0 failed) ✅ |
| **Security** | 84% (1 failed) |
| **Total** | **89% passed** |

---

## 🔒 Security

| Fitur | Deskripsi |
|-------|-----------|
| **Content-Security-Policy** | Header CSP untuk mencegah XSS |
| **X-Frame-Options** | Mencegah clickjacking via iframe |
| **X-XSS-Protection** | Browser XSS filtering |
| **Login Throttling** | Max 5x percobaan login per menit |
| **CSRF Protection** | Token CSRF di semua form |
| **Custom Error Pages** | 403, 404, 500 (mencegah fingerprinting) |
| **FOUC Prevention** | Penggunaan `x-cloak` pada Alpine.js untuk mencegah elemen ter-render sekejap saat pemuatan |
| **HttpOnly Cookies** | Cookie tidak bisa diakses via JavaScript |

---

## 📝 Lisensi

Project ini dikembangkan untuk keperluan internal **Fakultas Teknik UNESA**.
```

---

