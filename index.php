<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_perpus";
$koneksi = new mysqli($servername, $username, $password, $dbname);
$nim = "003";
$nama = "Sihabuddin Rifqi";
$prodi = "Teknik Informatika";
$sql = "INSERT INTO tm_mahasiswa (nim, nama, prodi) VALUES ('$nim', '$nama',
'$prodi')";
if ($koneksi->query($sql) == TRUE) {
echo "Mahasiswa berhasil ditambahkan.<br>";
} else {
echo "Error: " . $sql . "<br>" . $koneksi->error;
}
//menampilkan data
$sql = "SELECT * FROM tm_mahasiswa";
$result = $koneksi->query($sql);
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
echo "NIM = ".$row["nim"] ." - NAMA = " . $row ["nama"] . " - PRODI = " .
$row ["prodi"] . "<br/>"; //nama kolom
}
} else {
echo "Tidak ada data.";
}
//mencari data pasti
echo "<br/>Tampilan data mahasiswa berdasar 1 kriteria Pasti<br>";
$cari = "011";
echo "Kriteria NIM : ".$cari."<br>";
$sql = "SELECT * FROM tm_mahasiswa WHERE nim ='$cari'";
$result = $koneksi->query($sql);
if($result->num_rows>0) {
while($row = $result->fetch_assoc()) {
echo "NIM = ".$row["nim"] ." - NAMA = " . $row ["nama"] . " - PRODI = " .
$row ["prodi"] . "<br/>";
}
} else {
echo "Tidak ada data mahasiswa dengan kriteria nim tersebut.<br>";
}
//mencari data yang mirip
echo "<br/>Tampilan data mahasiswa berdasar 1 kriteria Kemiripan<br>";
$cari = "002";
echo "Kriteria NIM : ".$cari."<br>";
$sql = "SELECT * FROM tm_mahasiswa WHERE nim LIKE '%$cari%'";
$result = $koneksi->query($sql);
if($result->num_rows>0) {
while($row = $result->fetch_assoc()) {
echo "NIM = ".$row["nim"] ." - NAMA = " . $row ["nama"] . " - PRODI = " .
$row ["prodi"] . "<br/>";
}
} else {
echo "Tidak ada data mahasiswa dengan kriteria mendekati nim tersebut.<br>";
}
//Mencari data yang mirip
echo "<br/>Tampilan data mahasiswa berdasar lebih dari 1 kriteria Kemiripan<br>";
$cari = "03";
echo "Kriteria NIM : ".$cari."<br>";
$sql = "SELECT * FROM tm_mahasiswa WHERE nim LIKE '%$cari%' OR nama LIKE
'%$cari%' OR prodi LIKE '%$cari%'";
$result = $koneksi->query($sql);
if ($result->num_rows > 0) {
 while($row = $result->fetch_assoc()) {
 echo "NIM = " . $row["nim"] . " – NAMA = " . $row["nama"] . " – PRODI = " . $row["prodi"] .
"<br/>";
 }
} else {
 echo "Tidak ada data mahasiswa dengan kriteria nim tersebut<br>";
}

//mengubah data
echo "<br>Mengubah data mahasiswa berdasar 1 kriteria.<br>";
$cari = "001";
$nama = "Andi";
$prodi = "TI";
$sql = "UPDATE tm_mahasiswa SET nama='$nama', prodi='$prodi' WHERE nim='$cari'";
$result = $koneksi->query($sql);
if ($koneksi->query($sql) == TRUE) {
 echo "Data mahasiswa berhasil diperbarui.<br>";
 } else {
 echo "Error: " . $koneksi->error;
 }

//tampilan setelah diubah
echo "Tampilan data mahasiswa setelah diubah :<br>";
$sql = "SELECT * FROM tm_mahasiswa";
$result = $koneksi->query($sql);
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
echo "NIM = ".$row["nim"] ." - NAMA = " . $row ["nama"] . " - PRODI = " .
$row ["prodi"] . "<br/>";
}
} else {
echo "Tidak ada data.";
}
//menghapus data
$cari = "002";
$sql = "DELETE FROM tm_mahasiswa WHERE nim = '$cari'";
$result = $koneksi->query($sql);

if ($result === TRUE && $koneksi->affected_rows > 0) {
    echo "<br>Data mahasiswa berhasil dihapus.<br>";
} elseif ($result === TRUE && $koneksi->affected_rows == 0) {
    echo "<br>Tidak ada data mahasiswa dengan NIM $cari yang dihapus.<br>";
} else {
    echo "Error: " . $koneksi->error;
}

?>