<p align="center">
    <a href="https://medpres.mrifqia.my.id" target="_blank">
        <img src="https://medpres.mrifqia.my.id/assets/img/logos/medpres.png" width="220" alt="MedPres Logo">
    </a>
</p>

<p align="center">
    <strong>MedPres – Medical Prescription System</strong>
</p>

<p align="center">
    Sistem informasi rumah sakit untuk manajemen pemeriksaan pasien dan resep obat berbasis role.
</p>

---

## About MedPres

**MedPres** adalah aplikasi berbasis web yang dirancang untuk mendukung alur pelayanan rumah sakit,
mulai dari pendaftaran pasien, pemeriksaan oleh dokter, pembuatan resep, hingga proses penyiapan
obat oleh apoteker.

Aplikasi ini menerapkan **role-based access control** sehingga setiap pengguna hanya dapat
mengakses fitur sesuai dengan tanggung jawabnya.

MedPres dikembangkan untuk meningkatkan:
- Efisiensi pelayanan pasien
- Akurasi data medis
- Integrasi antar unit pelayanan (Admin, Dokter, Apoteker)

---

## User Roles & Responsibilities

### Super Admin
- Mengelola seluruh data master rumah sakit
- Mengatur pengguna dan role
- Konfigurasi sistem dan poli

### Admin
- Melakukan screening awal pasien
- Mengelola tiket berobat pasien
- Mengatur aktivitas unit pelayanan di masing-masing poli  
  *(Setiap poli minimal memiliki 1 Admin dan 1 Dokter)*

### Dokter
- Melakukan pemeriksaan pasien
- Memberikan diagnosa
- Membuat resep obat
- Menentukan dosis dan aturan pemakaian obat

### Apoteker
- Menerima resep dari dokter
- Menyiapkan dan meracik obat
- Mengonfirmasi proses pembayaran pasien

---

## Application Flow

1. Pasien didaftarkan dan disaring oleh **Admin**
2. Pasien diperiksa oleh **Dokter**
3. Dokter membuat diagnosa dan resep obat
4. Resep dikirim ke **Apoteker**
5. Apoteker menyiapkan obat dan menyelesaikan proses pelayanan

Setiap proses tercatat secara sistematis dan terintegrasi dalam sistem.

---

## Live Demo

Aplikasi MedPres dapat diakses dan diuji coba secara langsung melalui tautan berikut:

🔗 **https://medpres.mrifqia.my.id/**

---

## Technology Stack

- **Backend**: Laravel
- **Frontend**: Blade Template, Bootstrap, JavaScript
- **Database**: MySQL
- **Real-time Feature**: Laravel Event & Broadcasting
- **External API**: Data obat (Medicine) diambil dari API eksternal

---

## Purpose of Development

Aplikasi ini dikembangkan sebagai:
- Project sistem informasi kesehatan
- Implementasi sistem resep digital
- Simulasi alur kerja rumah sakit berbasis teknologi web

---

## Developer

**Muhammad Rifqi Aminuddin**  
Web Developer  

---

## License

Project ini dikembangkan untuk keperluan pembelajaran dan demonstrasi sistem.  
Penggunaan lebih lanjut dapat disesuaikan dengan kebutuhan institusi.