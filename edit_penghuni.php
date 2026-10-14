<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = "";

// Ambil data lama
$stmt = mysqli_prepare($db, "SELECT * FROM penghuni WHERE id_penghuni = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama        = $_POST['nama'];
    $ktp         = $_POST['ktp'];
    $pekerjaan   = $_POST['pekerjaan'];
    $hp          = $_POST['hp'];
    $kamar       = $_POST['kamar'];
    $kd_nama     = $_POST['kd_nama'];
    $kd_hubungan = $_POST['kd_hubungan'];
    $kd_hp       = $_POST['kd_hp'];

    $sql = "UPDATE penghuni SET
              nama_lengkap = ?, nomor_ktp = ?, pekerjaan = ?, nomor_hp = ?,
              nomor_kamar = ?, nama_kontak_darurat = ?, hubungan = ?,
              nomor_hp_kontak_darurat = ?
            WHERE id_penghuni = ?";

    try {
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssssi",
            $nama, $ktp, $pekerjaan, $hp, $kamar, $kd_nama, $kd_hubungan, $kd_hp, $id);
        mysqli_stmt_execute($stmt);

        header("Location: index.php");
        exit;
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $error = "Nomor KTP sudah terdaftar.";
        } else {
            $error = "Data gagal diperbarui: " . $e->getMessage();
        }
        // pertahankan isian terakhir pengguna
        $data['nama_lengkap'] = $nama;
        $data['nomor_ktp'] = $ktp;
        $data['pekerjaan'] = $pekerjaan;
        $data['nomor_hp'] = $hp;
        $data['nomor_kamar'] = $kamar;
        $data['nama_kontak_darurat'] = $kd_nama;
        $data['hubungan'] = $kd_hubungan;
        $data['nomor_hp_kontak_darurat'] = $kd_hp;
    }
}

$opsi_hubungan = ["Orang Tua", "Saudara Kandung", "Wali", "Lainnya"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Penghuni</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Edit Data Penghuni</h1>

  <?php if ($error != ""): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post">
    <h3>Data Pribadi</h3>
    <div class="form-group">
      <label for="nama">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" maxlength="100" required
             value="<?= htmlspecialchars($data['nama_lengkap']) ?>">
    </div>

    <div class="form-group">
      <label for="ktp">Nomor KTP</label>
      <input type="text" id="ktp" name="ktp" maxlength="16" minlength="16" pattern="[0-9]{16}" required
             value="<?= htmlspecialchars($data['nomor_ktp']) ?>">
    </div>

    <div class="form-group">
      <label for="pekerjaan">Pekerjaan</label>
      <input type="text" id="pekerjaan" name="pekerjaan" maxlength="50"
             value="<?= htmlspecialchars($data['pekerjaan']) ?>">
    </div>

    <div class="form-group">
      <label for="hp">Nomor HP</label>
      <input type="tel" id="hp" name="hp" maxlength="15" required
             value="<?= htmlspecialchars($data['nomor_hp']) ?>">
    </div>

    <div class="form-group">
      <label for="kamar">Nomor Kamar</label>
      <input type="text" id="kamar" name="kamar" maxlength="10" required
             value="<?= htmlspecialchars($data['nomor_kamar']) ?>">
    </div>

    <h3>Kontak Darurat</h3>
    <div class="form-group">
      <label for="kd_nama">Nama Kontak Darurat</label>
      <input type="text" id="kd_nama" name="kd_nama" maxlength="100" required
             value="<?= htmlspecialchars($data['nama_kontak_darurat']) ?>">
    </div>

    <div class="form-group">
      <label for="kd_hubungan">Hubungan</label>
      <select id="kd_hubungan" name="kd_hubungan" required>
        <option value="">Pilih</option>
        <?php foreach ($opsi_hubungan as $opsi): ?>
          <option <?= $data['hubungan'] === $opsi ? 'selected' : '' ?>><?= $opsi ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="kd_hp">Nomor HP Kontak Darurat</label>
      <input type="tel" id="kd_hp" name="kd_hp" maxlength="15" required
             value="<?= htmlspecialchars($data['nomor_hp_kontak_darurat']) ?>">
    </div>
    <br>
    <button type="submit" name="update" class="btn">Perbarui Data</button>
    <a href="index.php" class="btn" style="background-color:#999999;">Batal</a>
  </form>
</body>
</html>