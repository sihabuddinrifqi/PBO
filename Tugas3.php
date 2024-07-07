<?php
class Buku {
// Properti dari kelas Buku
public $judul;
public $pengarang;
public $tahunTerbit;
public $penerbit;
// Konstruktor untuk inisialisasi Buku
public function __construct($judul, $pengarang, $tahunTerbit, $penerbit) {
$this->judul = $judul;
$this->pengarang = $pengarang;
   $this->tahunTerbit = $tahunTerbit;
$this->penerbit = $penerbit;
 }
 // Metode untuk menampilkan informasi buku
 public function tampilkanInfo() {
 echo "Judul: " . $this->judul . "\n";
 echo "Pengarang: " . $this->pengarang . "\n";
 echo "Tahun Terbit: " . $this->tahunTerbit . "\n";
 echo "Penerbit: " . $this->penerbit . "\n";
 }
}
// Membuat objek Buku
$buku1 = new Buku("Harry Potter", "J.K. Rowling", 1997, "Bloomsbury<br>");
$buku2 = new Buku("Lord of the Rings", "J.R.R. Tolkien", 1954, "Allen & Unwin");
// Menampilkan informasi buku
$buku1->tampilkanInfo();
echo "\n"; // Baris baru untuk pemisah
$buku2->tampilkanInfo();
?>

