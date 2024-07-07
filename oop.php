<?php
// CLASS
class Database {
    // Properti
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $koneksi;
    public $nim;
    public $nama;
    public $prodi;
    public $cari;

    // Konstruktor untuk inisialisasi properti dan membuat koneksi ke database
    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->koneksi = new mysqli($servername, $username, $password, $dbname);
        
        // Cek koneksi
        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }

    // Method untuk menambah data mahasiswa
    public function tambahMhs($nim, $nama, $prodi) {
        $this->nim = $nim;
        $this->nama = $nama;
        $this->prodi = $prodi;

        // Pastikan $nim adalah string
        $nim = (string)$nim;

        $sql = "INSERT INTO tm_mahasiswa (nim, nama, prodi) VALUES ('$nim', '$nama', '$prodi')";
        if ($this->koneksi->query($sql) === true) {
            echo "Mahasiswa berhasil ditambahkan.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->koneksi->error;
        }
    }

    // Method untuk menampilkan semua data mahasiswa
    public function tampilMhs() {
        $sql = "SELECT * FROM tm_mahasiswa";
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<br/>NIM = " . $row["nim"] . " - NAMA = " . $row["nama"] . " - PRODI = " . $row["prodi"] . "<br/>";
            }
        } else {
            echo "Tidak ada data.";
        }
    }

    // Method untuk menampilkan data mahasiswa berdasar 1 kriteria pasti
    public function tampilPasti($cari) {
        echo "<br>Tampil mahasiswa dengan 1 kriteria Pasti.<br>";
        $this->cari = $cari;

        // Pastikan $cari adalah string
        $cari = (string)$cari;

        echo "Kriteria NIM: " . $this->cari . "<br>";
        $sql = "SELECT * FROM tm_mahasiswa WHERE nim = '$cari'";
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "NIM = " . $row["nim"] . " – NAMA = " . $row["nama"] . " – PRODI = " . $row["prodi"] . "<br/>";
            }
        } else {
            echo "Tidak ada data mahasiswa dengan kriteria NIM tersebut.<br>";
        }
    }

    // Method untuk menampilkan data mahasiswa berdasar lebih dari 1 kriteria kemiripan
    public function tampilMirip($cari) {
        echo "<br>Tampil mahasiswa dengan lebih dari 1 kriteria Kemiripan.<br>";
        $this->cari = $cari;

        // Pastikan $cari adalah string
        $cari = (string)$cari;

        echo "Kriteria Kemiripan: " . $this->cari . "<br>";
        $sql = "SELECT * FROM tm_mahasiswa WHERE nim LIKE '%$cari%' OR nama LIKE '%$cari%' OR prodi LIKE '%$cari%'";
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "NIM = " . $row["nim"] . " – NAMA = " . $row["nama"] . " – PRODI = " . $row["prodi"] . "<br/>";
            }
        } else {
            echo "Tidak ada data mahasiswa dengan kriteria mendekati NIM tersebut.<br>";
        }
    }

    // Method untuk merubah data mahasiswa berdasar 1 kriteria
    public function ubahMhs($cari, $nama, $prodi) {
        echo "<br>Ubah data mahasiswa dengan 1 kriteria<br>";
        $this->cari = $cari;

        // Pastikan $cari adalah string
        $cari = (string)$cari;

        echo "Kriteria (NIM): " . $this->cari . "<br>";
        $this->nama = $nama;
        $this->prodi = $prodi;
        $sql = "UPDATE tm_mahasiswa SET nama='$nama', prodi='$prodi' WHERE nim='$cari'";
        if ($this->koneksi->query($sql) === true) {
            echo "Data mahasiswa berhasil diperbarui.<br/>";
        } else {
            echo "Error: " . $this->koneksi->error;
        }
    }

    // Method untuk menghapus data mahasiswa berdasar 1 kriteria pasti
    public function hapusMhs($cari) {
        echo "<br>Menghapus data mahasiswa dengan 1 kriteria (pasti)<br>";
        $this->cari = $cari;

        // Pastikan $cari adalah string
        $cari = (string)$cari;

        echo "Kriteria (NIM): " . $this->cari . "<br>";
        $sql = "DELETE FROM tm_mahasiswa WHERE nim = '$cari'";
        $result = $this->koneksi->query($sql);
        if ($result === TRUE && $this->koneksi->affected_rows > 0) {
            echo "<br>Data mahasiswa berhasil dihapus.<br>";
        } elseif ($result === TRUE && $this->koneksi->affected_rows == 0) {
            echo "<br>Tidak ada data mahasiswa dengan NIM $cari yang dihapus.<br>";
        } else {
            echo "Error: " . $this->koneksi->error;
        }
    }
}

// OBJEK
// Pembentukan objek dan koneksi ke database
$db = new Database("localhost", "root", "", "db_perpus");

// Penggunaan objek
// Tambah mahasiswa
$db->tambahMhs("003", "Sihabuddin Rifqi", "Teknik Informatika");
$db->tampilMhs();

// Tampil mahasiswa dengan 1 kriteria pasti
$db->tampilPasti("003");

// Tampil mahasiswa dengan lebih dari 1 kriteria mirip
$db->tampilMirip("Informatika");
$db->tampilMirip("01");

// Ubah data mahasiswa
$db->ubahMhs("001", "Taufiq Arrohman", "Sastra Mesin");
$db->tampilMhs();

// Hapus data mahasiswa
$db->hapusMhs("001");
$db->tampilMhs();
?>
