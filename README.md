# E-PKP (Elektronik Penilaian Capaian Kinerja Pegawai)

Aplikasi E-PKP adalah sistem berbasis web yang dirancang untuk mempermudah proses penyusunan, penilaian, dan pelaporan Sasaran Kinerja Pegawai (SKP) di lingkungan Pengadilan Tinggi Agama Gorontalo. Aplikasi ini menggantikan proses manual berbasis Excel menjadi sistem terpusat yang efisien.

## Spesifikasi Teknis

*   **Framework**: CodeIgniter 3 (PHP)
*   **Database**: MySQL
*   **Template Admin**: AdminLTE 3
*   **Frontend Libraries**:
    *   jQuery
    *   Bootstrap 4
    *   DataTables (untuk tabel interaktif)
    *   SweetAlert2 & Toastr (untuk notifikasi)
    *   FontAwesome (untuk ikon)

## Fitur Utama

### Modul Administrator
1.  **Manajemen Data Master**:
    *   Tahun Anggaran (Fiscal Years)
    *   Satuan Kerja (Units)
    *   Pangkat/Golongan (Ranks)
    *   Jabatan (Positions)
2.  **Manajemen Pengguna**:
    *   Tambah, Edit, Hapus Data Pegawai
    *   Import Data Pegawai dari Excel/CSV
3.  **Dashboard Monitoring**:
    *   Statistik jumlah pegawai, unit kerja, dan tahun aktif.
    *   Monitoring jumlah pegawai yang sudah melaporkan kinerja bulan lalu.

### Modul Pegawai
1.  **Perencanaan Tahunan (Target SKP)**:
    *   Input target kinerja tahunan (Kuantitas, Kualitas, Satuan).
    *   Pemilihan periode target (Bulanan, Triwulan, Tahunan).
2.  **Realisasi Bulanan**:
    *   Input capaian realisasi bulanan berdasarkan target.
    *   Input data Pejabat Penilai untuk laporan.
3.  **Pelaporan**:
    *   Cetak Laporan Capaian Kinerja Bulanan.
    *   Cetak Rekapitulasi Capaian Kinerja.
    *   Fitur sembunyikan baris target yang tidak memiliki realisasi (nihil).

## Instalasi

1.  **Persiapan Database**:
    *   Buat database baru bernama `db_epkp` di phpMyAdmin atau MySQL client.
    *   Import file database SQL yang disertakan (jika ada) atau biarkan aplikasi membuat tabel (jika menggunakan migrasi).
2.  **Konfigurasi Aplikasi**:
    *   Buka `application/config/database.php` dan sesuaikan username/password database.
    *   Buka `application/config/config.php` dan atur `base_url` sesuai alamat server lokal Anda (misal: `http://localhost/aplikasi-pkp/`).
3.  **Akses Aplikasi**:
    *   Buka browser dan akses URL aplikasi.
    *   Login default Admin:
        *   **NIP**: `admin`
        *   **Password**: `admin123` (atau sesuai data awal)

## Alur Penggunaan (User Guide)

### 1. Administrator
1.  **Login** sebagai Admin.
2.  **Setup Awal**:
    *   Masuk ke menu **Data Master > Tahun Anggaran**. Pastikan tahun aktif sudah diset (misal: 2025).
    *   Lengkapi data **Unit Kerja**, **Pangkat**, dan **Jabatan** jika diperlukan.
3.  **Manajemen Pegawai**:
    *   Masuk ke menu **Data Pegawai**.
    *   Klik **Tambah Baru** untuk mendaftarkan pegawai satu per satu, atau **Import** untuk upload data massal via CSV.

### 2. Pegawai
1.  **Login** menggunakan NIP dan Password yang diberikan Admin.
2.  **Input Target Tahunan**:
    *   Masuk ke menu **Target SKP**.
    *   Klik **Tambah Target**.
    *   Isi detail kegiatan, target kuantitas, kualitas, dan pilih periode target (Bulanan/Triwulan/Tahunan).
    *   Simpan data. Ulangi untuk semua kegiatan tahunan.
3.  **Laporan Bulanan**:
    *   Masuk ke menu **Realisasi SKP**.
    *   Pilih Bulan yang akan dilaporkan (misal: Januari).
    *   Isi kolom **Realisasi** (Kuantitas & Kualitas) pada setiap baris kegiatan.
    *   Pada bagian bawah, isi data **Pejabat Penilai** (Atasan Langsung).
    *   Klik **Simpan Tanda Tangan** untuk menyimpan data penilai.
    *   Klik tombol **Simpan** (ikon disket) pada setiap baris kegiatan yang diupdate.
4.  **Cetak Laporan**:
    *   Klik tombol **Cetak Laporan** untuk melihat preview laporan bulanan.
    *   Gunakan opsi "Sembunyikan Baris Nihil" jika ingin mencetak hanya kegiatan yang ada realisasinya.
    *   Klik **Cetak Rekap** untuk melihat ringkasan capaian kinerja.

## Catatan Penting
*   Pastikan **Tahun Anggaran Aktif** selalu diset oleh Admin agar Pegawai bisa menginput data.
*   Jika layout berantakan saat dicetak, pastikan opsi "Background Graphics" dicentang pada pengaturan print browser.
