<?php
class Lingkaran {
    private $jari_jari;
    public function __construct($jari_jari) {
    $this->jari_jari = $jari_jari;
    }
    public function hitungLuas() {
    return pi() * $this->jari_jari * $this->jari_jari;
    }
    }
    class Persegi {
    private $sisi;
    public function __construct($sisi) {
    $this->sisi = $sisi;
    }
    public function hitungLuas() {
    return $this->sisi * $this->sisi;
    }
    }
    // Contoh penggunaan
    $persegi = new Persegi(6);
    echo "Luas persegi: " . $persegi->hitungLuas();
    echo "<br>------------------------------<br>";
    // Contoh penggunaan
    $lingkaran = new Lingkaran(5);
    echo "Luas lingkaran: " . $lingkaran->hitungLuas() . "<br>";
    ?>

 
