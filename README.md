# Kelola Keuangan

Aplikasi untuk mencatat pemasukan & pengeluaran, menampilkan ringkasan keuangan, serta visualisasi data keuangan dengan grafik. Setiap user memiliki data terpisah melalui sistem login.

---

## Fitur Utama

### 1. Autentikasi
- Registrasi user
- Login & Logout
- Profil pengguna

### 2. Manajemen Transaksi
- Tambah pemasukan & pengeluaran
- Edit/hapus transaksi
- Kategori transaksi (misal: makan, transport, gaji, dll.)

### 3. Ringkasan Keuangan
- Total saldo saat ini
- Total pemasukan per bulan
- Total pengeluaran per bulan

### 4. Visualisasi
- Grafik pemasukan vs pengeluaran (menggunakan Chart.js)
- Filter grafik berdasarkan bulan/tahun

---

## Struktur Tabel MySQL (Contoh) (ULID)

### users
- id
- name
- email
- password

### categories
- id
- name (misal: "Makan", "Gaji")
- type (income / expense)
- user_id (kategori tiap user bisa berbeda)

### transactions
- id
- user_id
- category_id
- amount (jumlah uang)
- type (income / expense)
- date
- description

---

## Halaman yang Dibutuhkan
- Login/Register
- Dashboard (ringkasan & grafik)
- Daftar transaksi
- Form tambah/edit transaksi
- Manajemen kategori
- Profil pengguna

---

## Library / Tools yang Digunakan
- **Laravel Breeze** atau **Laravel UI**: Autentikasi cepat
- **Chart.js**: Grafik
- **Carbon**: Manipulasi tanggal
- **Bootstrap**