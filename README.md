<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MedPres - Medical Prescription System</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            margin: 40px;
            color: #333;
        }

        h1, h2, h3 {
            color: #1a1a1a;
        }

        h1 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        ul {
            margin-left: 20px;
        }

        li {
            margin-bottom: 8px;
        }

        .section {
            margin-top: 30px;
        }

        .footer {
            margin-top: 50px;
            font-style: italic;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>MedPres – Medical Prescription System</h1>

    <p>
        <strong>MedPres</strong> adalah aplikasi sistem informasi rumah sakit
        yang dirancang untuk mengelola proses pemeriksaan pasien, pembuatan resep,
        serta alur pelayanan antar unit secara terintegrasi dan berbasis role.
    </p>

    <div class="section">
        <h2>Tutorial Penggunaan</h2>

        <ol>
            <li>
                Login menggunakan akun sesuai dengan role yang terdaftar:
                <strong>Super Admin</strong>, <strong>Admin</strong>,
                <strong>Dokter</strong>, dan <strong>Apoteker</strong>.
            </li>

            <li>
                <strong>Super Admin</strong> bertugas mengelola seluruh data master
                rumah sakit, termasuk data pengguna, poli, dan konfigurasi sistem.
            </li>

            <li>
                <strong>Admin</strong> bertugas melakukan screening awal pasien,
                mengelola tiket berobat, serta mengatur aktivitas unit pelayanan
                pada masing-masing poli.
                <br>
                <em>Catatan:</em> Setiap poli minimal memiliki 1 Admin dan 1 Dokter.
            </li>

            <li>
                <strong>Dokter</strong> bertugas melakukan pemeriksaan pasien,
                memberikan diagnosa, membuat resep obat, serta menentukan dosis
                dan aturan pemakaian obat.
            </li>

            <li>
                <strong>Apoteker</strong> bertugas menerima resep dari dokter,
                menyiapkan dan meracik obat sesuai resep, serta mengonfirmasi
                proses pembayaran pasien.
            </li>

            <li>
                Setiap role memiliki hak akses dan fitur yang berbeda sesuai
                dengan tanggung jawab masing-masing.
            </li>
        </ol>
    </div>

    <div class="section">
        <h2>Demo Aplikasi</h2>
        <p>
            Aplikasi MedPres dapat diakses dan diuji coba secara langsung melalui tautan berikut:
        </p>
        <p>
            <a href="https://medpres.mrifqia.my.id/" target="_blank">
                https://medpres.mrifqia.my.id/
            </a>
        </p>
    </div>

    <div class="footer">
        <p>
            Dikembangkan oleh:<br>
            <strong>Muhammad Rifqi Aminuddin</strong>
        </p>
    </div>

</body>
</html>
