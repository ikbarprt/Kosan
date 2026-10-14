<?php
include 'koneksi.php';

$error = "";

if (isset($_POST['simpan'])) {
    $nama        = $_POST['nama'];
    $ktp         = $_POST['ktp'];
    $pekerjaan   = $_POST['pekerjaan'];
    $hp          = $_POST['hp'];
    $kamar       = $_POST['kamar'];
    $kd_nama     = $_POST['kd_nama'];
    $kd_hubungan = $_POST['kd_hubungan'];
    $kd_hp       = $_POST['kd_hp'];

    $sql = "INSERT INTO penghuni
            (nama_lengkap, nomor_ktp, pekerjaan, nomor_hp, nomor_kamar,
             nama_kontak_darurat, hubungan, nomor_hp_kontak_darurat)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssss",
            $nama, $ktp, $pekerjaan, $hp, $kamar, $kd_nama, $kd_hubungan, $kd_hp);
        mysqli_stmt_execute($stmt);

        header("Location: index.php");
        exit;
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $error = "Nomor KTP sudah terdaftar.";
        } else {
            $error = "Data gagal disimpan: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Penghuni</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Tambah Penghuni Baru</h1>

  <?php if ($error != ""): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post" action="penghuni_kos.php">
    <h3>Data Pribadi</h3>
    <div class="form-group">
      <label for="nama">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" maxlength="100" required>
    </div>

    <div class="form-group">
      <label for="ktp">Nomor KTP</label>
      <input type="text" id="ktp" name="ktp" maxlength="16" minlength="16" pattern="[0-9]{16}" required>
    </div>

    <div class="form-group">
      <label for="pekerjaan">Pekerjaan</label>
      <input type="text" id="pekerjaan" name="pekerjaan" maxlength="50">
    </div>

    <div class="form-group">
      <label for="hp">Nomor HP</label>
      <input type="tel" id="hp" name="hp" maxlength="15" required>
    </div>

    <div class="form-group">
      <label for="kamar">Nomor Kamar</label>
      <input type="text" id="kamar" name="kamar" maxlength="10" required>
    </div>

    <h3>Kontak Darurat</h3>
    <div class="form-group">
      <label for="kd_nama">Nama Kontak Darurat</label>
      <input type="text" id="kd_nama" name="kd_nama" maxlength="100" required>
    </div>

    <div class="form-group">
      <label for="kd_hubungan">Hubungan</label>
      <select id="kd_hubungan" name="kd_hubungan" required>
        <option value="">Pilih</option>
        <option>Orang Tua</option>
        <option>Saudara Kandung</option>
        <option>Wali</option>
        <option>Lainnya</option>
      </select>
    </div>

    <div class="form-group">
      <label for="kd_hp">Nomor HP Kontak Darurat</label>
      <input type="tel" id="kd_hp" name="kd_hp" maxlength="15" required>
    </div>
    <br>
    <button type="submit" name="simpan" class="btn">Simpan Data</button>
    <a href="index.php" class="btn" style="background-color:#999999;">Batal</a>
  </form>
</body>
</html>