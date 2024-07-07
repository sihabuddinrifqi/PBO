<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Manajemen Data Mahasiswa</h1>

    <!-- Form untuk Menambah Mahasiswa -->
    <div class="card mt-4">
        <div class="card-header">
            <h2>Tambah Mahasiswa</h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="nim">NIM:</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="prodi">Prodi:</label>
                    <input type="text" class="form-control" id="prodi" name="prodi" required>
                </div>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah Mahasiswa</button>
            </form>
        </div>
    </div>

    <!-- Form untuk Hapus Mahasiswa -->
    <div class="card mt-4">
        <div class="card-header">
            <h2>Hapus Mahasiswa</h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="hapus_nim">NIM:</label>
                    <input type="text" class="form-control" id="hapus_nim" name="hapus_nim" required>
                </div>
                <button type="submit" name="hapus" class="btn btn-danger">Hapus Mahasiswa</button>
            </form>
        </div>
    </div>

    <!-- Form untuk Update Mahasiswa -->
    <div class="card mt-4">
        <div class="card-header">
            <h2>Update Mahasiswa</h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="update_nim">NIM:</label>
                    <input type="text" class="form-control" id="update_nim" name="update_nim" required>
                </div>
                <div class="form-group">
                    <label for="update_nama">Nama Baru:</label>
                    <input type="text" class="form-control" id="update_nama" name="update_nama" required>
                </div>
                <div class="form-group">
                    <label for="update_prodi">Prodi Baru:</label>
                    <input type="text" class="form-control" id="update_prodi" name="update_prodi" required>
                </div>
                <button type="submit" name="update" class="btn btn-warning">Update Mahasiswa</button>
            </form>
        </div>
    </div>

    <!-- Form untuk Cari Mahasiswa -->
    <div class="card mt-4">
        <div class="card-header">
            <h2>Cari Mahasiswa</h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="search_nim">Cari NIM:</label>
                    <input type="text" class="form-control" id="search_nim" name="search_nim">
                </div>
                <div class="form-group">
                    <label for="search_kriteria">Cari Berdasarkan Kriteria (Nama/Prodi):</label>
                    <input type="text" class="form-control" id="search_kriteria" name="search_kriteria">
                </div>
                <button type="submit" name="search" class="btn btn-info">Cari Mahasiswa</button>
            </form>
        </div>
    </div>

    <!-- Output hasil operasional -->
    <div class="mt-4">
        <?php
        // CLASS
        class Database {
            public $servername;
            public $username;
            public $password;
            public $dbname;
            public $koneksi;

            // Konstruktor untuk inisialisasi properti dan membuat koneksi ke database
            public function __construct($servername, $username, $password, $dbname) {
                $this->servername = $servername;
                $this->username = $username;
                $this->password = $password;
                $this->dbname = $dbname;
                $this->koneksi = new mysqli($servername, $username, $password, $dbname);
                
                if ($this->koneksi->connect_error) {
                    die("Koneksi gagal: " . $this->koneksi->connect_error);
                }
            }

            // Method untuk menambah data mahasiswa
            public function tambahMhs($nim, $nama, $prodi) {
                $nim = (string)$nim;
                $sql = "INSERT INTO tm_mahasiswa (nim, nama, prodi) VALUES ('$nim', '$nama', '$prodi')";
                if ($this->koneksi->query($sql) === true) {
                    echo "<div class='alert alert-success'>Mahasiswa berhasil ditambahkan.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $this->koneksi->error . "</div>";
                }
            }

            // Method untuk menghapus data mahasiswa berdasar 1 kriteria pasti
            public function hapusMhs($cari) {
                $cari = (string)$cari;
                $sql = "DELETE FROM tm_mahasiswa WHERE nim = '$cari'";
                $result = $this->koneksi->query($sql);
                if ($result === TRUE && $this->koneksi->affected_rows > 0) {
                    echo "<div class='alert alert-success'>Data mahasiswa berhasil dihapus.</div>";
                } elseif ($result === TRUE && $this->koneksi->affected_rows == 0) {
                    echo "<div class='alert alert-warning'>Tidak ada data mahasiswa dengan NIM $cari yang dihapus.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $this->koneksi->error . "</div>";
                }
            }

            // Method untuk merubah data mahasiswa berdasar 1 kriteria
            public function ubahMhs($cari, $nama, $prodi) {
                $cari = (string)$cari;
                $sql = "UPDATE tm_mahasiswa SET nama='$nama', prodi='$prodi' WHERE nim='$cari'";
                if ($this->koneksi->query($sql) === true) {
                    echo "<div class='alert alert-success'>Data mahasiswa berhasil diperbarui.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $this->koneksi->error . "</div>";
                }
            }

            // Method untuk menampilkan semua data mahasiswa
            public function tampilMhs() {
                $sql = "SELECT * FROM tm_mahasiswa";
                $result = $this->koneksi->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='table table-striped mt-4'><thead><tr><th>NIM</th><th>Nama</th><th>Prodi</th></tr></thead><tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["nim"] . "</td><td>" . $row["nama"] . "</td><td>" . $row["prodi"] . "</td></tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-info'>Tidak ada data.</div>";
                }
            }

            // Method untuk menampilkan data mahasiswa berdasar 1 kriteria pasti
            public function tampilPasti($cari) {
                $cari = (string)$cari;
                $sql = "SELECT * FROM tm_mahasiswa WHERE nim = '$cari'";
                $result = $this->koneksi->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='table table-striped mt-4'><thead><tr><th>NIM</th><th>Nama</th><th>Prodi</th></tr></thead><tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["nim"] . "</td><td>" . $row["nama"] . "</td><td>" . $row["prodi"] . "</td></tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-info'>Tidak ada data dengan NIM tersebut.</div>";
                }
            }

            // Method untuk mencari data mahasiswa berdasar kriteria
            public function tampilKriteria($cari) {
                $cari = (string)$cari;
                $sql = "SELECT * FROM tm_mahasiswa WHERE nama LIKE '%$cari%' OR prodi LIKE '%$cari%'";
                $result = $this->koneksi->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='table table-striped mt-4'><thead><tr><th>NIM</th><th>Nama</th><th>Prodi</th></tr></thead><tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["nim"] . "</td><td>" . $row["nama"] . "</td><td>" . $row["prodi"] . "</td></tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-info'>Tidak ada data yang cocok dengan kriteria tersebut.</div>";
                }
            }
        }

        // Inisialisasi objek Database
        $db = new Database("localhost", "root", "", "db_perpus");

        // Handling form submissions
        if (isset($_POST['tambah'])) {
            $db->tambahMhs($_POST['nim'], $_POST['nama'], $_POST['prodi']);
        }
        if (isset($_POST['hapus'])) {
            $db->hapusMhs($_POST['hapus_nim']);
        }
        if (isset($_POST['update'])) {
            $db->ubahMhs($_POST['update_nim'], $_POST['update_nama'], $_POST['update_prodi']);
        }
        if (isset($_POST['search'])) {
            if (!empty($_POST['search_nim'])) {
                $db->tampilPasti($_POST['search_nim']);
            } else if (!empty($_POST['search_kriteria'])) {
                $db->tampilKriteria($_POST['search_kriteria']);
            } else {
                $db->tampilMhs();
            }
        }
        $db->tampilMhs();
        ?>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
