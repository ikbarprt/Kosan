<?php
include 'koneksi.php';

$result = mysqli_query($db, "SELECT * FROM penghuni ORDER BY id_penghuni ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penghuni</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Data Penghuni Kos</h1>
    <img src="logo.jpg" alt="Logo Kos">
  </header>

  <a href="tambah_penghuni.php" class="btn">+ Tambah Penghuni</a>

  <table>
    <tr>
      <th>ID Penghuni</th>
      <th>Nama</th>
      <th>No. KTP</th>
      <th>Pekerjaan</th>
      <th>Kamar</th>
      <th>Kontak Darurat</th>
      <th>Aksi</th>
    </tr>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $row['id_penghuni'] ?></td>
          <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
          <td><?= htmlspecialchars($row['nomor_ktp']) ?></td>
          <td><?= htmlspecialchars($row['pekerjaan']) ?></td>
          <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
          <td><?= htmlspecialchars($row['nama_kontak_darurat']) ?></td>
          <td>
            <a href="edit_penghuni.php?id=<?= $row['id_penghuni'] ?>" class="btn" style="background-color:#f0a500;">Edit</a>
            <a href="hapus_penghuni.php?id=<?= $row['id_penghuni'] ?>" class="btn" style="background-color:#d9534f;"
               onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="7" style="text-align:center;">Belum ada data penghuni.</td>
      </tr>
    <?php endif; ?>
  </table>
</body>
</html>