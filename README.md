# Aplikasi Perpustakaan Sederhana (PHP & MySQL)

## Identitas
- **Nama** : Puspa Dwi Setyorini  
- **NIM**  : 60324003  


## Deskripsi Aplikasi
Aplikasi Perpustakaan Sederhana berbasis PHP Native dan MySQL yang digunakan untuk mengelola data perpustakaan, khususnya data kategori.  
Aplikasi ini dibuat sebagai Project UTS dan mengimplementasikan konsep CRUD (Create, Read, Update, Delete).


## Fitur Aplikasi
- Menampilkan daftar kategori
- Menambah data kategori
- Mengedit data kategori
- Menghapus data kategori
- Koneksi database menggunakan MySQLi
- Struktur folder modular dan rapi


## Cara Instalasi dan Menjalankan Aplikasi
Pastikan perangkat telah terinstall:
- PHP 8
- MySQL
- Laragon
- Web Browser (Chrome / Firefox)


## Struktur Folder Project

```text
UTS-60324003/
├── config/
│   └── database.php        # Konfigurasi koneksi database MySQL
│
├── index.php               # Halaman list data anggota (READ)
├── create.php              # Form & proses tambah anggota (CREATE)
├── edit.php                # Form & proses edit anggota (UPDATE)
├── delete.php              # Proses hapus anggota (DELETE)
│
├── database_export.sql     # File export database
└── README.md               # Dokumentasi project
```

### Link Repository
Link repository menggunakan Git:
```bash
git clone https://github.com/username/UTS-60324003.git