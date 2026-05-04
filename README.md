# UTS Pemrograman Web - Aplikasi Manajemen Kategori

Project ini dibuat untuk memenuhi syarat Ujian Tengah Semester (UTS) mata kuliah Pemrograman Website 2.

## 1. Identitas Mahasiswa
* **Nama** : Puspa Dwi Setyorini
* **NIM**  : 60324003
* **Kelas**: Pemprograman Website 2 - A


## 2. Deskripsi Aplikasi
Aplikasi **Manajemen Kategori** ini berfungsi untuk melakukan operasi CRUD (*Create, Read, Update, Delete*) pada data kategori produk. Aplikasi ini telah mengimplementasikan standar keamanan dasar seperti:
* **Sanitasi Input**: Menggunakan `htmlspecialchars()` dan `trim()` untuk mencegah XSS dan spasi liar.
* **Keamanan Database**: Menggunakan *Prepared Statements* (`mysqli_prepare`) untuk mencegah *SQL Injection*.
* **Validasi Server-Side**: Pengecekan format kode kategori (Regex/Substr), batas karakter, dan validasi duplikasi data.


## 3. Fitur Utama
* **Read**: Menampilkan data kategori dalam bentuk tabel Bootstrap yang rapi dengan penomoran otomatis.
* **Create**: Menambah kategori baru dengan validasi format `KAT-` (Panjang 4-10 karakter).
* **Update**: Mengubah seluruh informasi kategori yang sudah ada.
* **Delete**: Menghapus data dengan konfirmasi dan pengecekan `affected_rows` untuk memastikan data benar-benar terhapus.


## 4. Struktur Folder
uts-kategori/
├── config/
│   └── database.php       # Konfigurasi koneksi database MySQL
├── index.php              # Halaman utama (Menampilkan Tabel Data)
├── create.php             # Halaman form tambah kategori & logika insert
├── edit.php               # Halaman form edit kategori & logika update
├── delete.php             # Proses penghapusan data (tanpa interface)
├── database_export.sql    # Backup/Export struktur tabel dan data kategori
└── README.md              # Dokumentasi aplikasi

## 5. Link Repository Github
https://github.com/Puspa79/UTS-PWEB2-60324003.git