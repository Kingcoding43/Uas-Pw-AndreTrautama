<?php
include('db.php');

if (isset($_POST['add_user'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $level_id = $_POST['level_id']; 
    $gambar = $_FILES['gambar']['name'];

    move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/".$gambar);

    $sql = "INSERT INTO users (nama, email, alamat, telepon, level_id, gambar) 
            VALUES ('$nama', '$email', '$alamat', '$telepon', '$level_id', '$gambar')";

    if ($conn->query($sql) === TRUE) {
        echo "Pengguna baru berhasil ditambahkan!<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['add_book'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $gambar = $_FILES['gambar']['name'];

    move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/".$gambar);

    $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, kategori, stok, gambar) 
            VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$kategori', '$stok', '$gambar')";

    if ($conn->query($sql) === TRUE) {
        echo "Buku baru berhasil ditambahkan!<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

$sql_books = "SELECT * FROM buku"; 
$result_books = $conn->query($sql_books);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Pengguna dan Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="my-4">Sistem CRUD Pengguna dan Buku</h2>
     
    <h3>Tambah Pengguna</h3>
    <form method="POST" enctype="multipart/form-data">
        Nama: <input type="text" name="nama" class="form-control" required><br>
        Email: <input type="email" name="email" class="form-control" required><br>
        Alamat: <textarea name="alamat" class="form-control" required></textarea><br>
        Telepon: <input type="text" name="telepon" class="form-control" required><br>
        Level: 
        <select name="level_id" class="form-control" required>
            <option value="pimpinan">Pimpinan</option>
        </select><br>
        Gambar: <input type="file" name="gambar" class="form-control"><br><br>
        <button type="submit" name="add_user" class="btn btn-primary">Tambah Pengguna</button>
    </form>
    <hr>
    
    <h3>Daftar Pengguna</h3>
    <?php if ($result_users->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Level</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['telepon']; ?></td>
                        <td>
                            <?php 
                                switch ($row['level_id']) {
                                   case 1:
                                        echo 'Admin';
                                        break;
                                   case 2:
                                        echo 'Staff';
                                        break;
                                    case 3:
                                        echo 'Pimpinan';
                                        break;
                                    default:
                                        echo 'Tidak diketahui';
                                        break;
                               }
                           ?>
                       </td>

                        <td><img src="uploads/<?php echo $row['gambar']; ?>" width="50" height="50"></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada pengguna.</p>
    <?php endif; ?>

    <hr>

    <h3>Tambah Buku</h3>
    <form method="POST" enctype="multipart/form-data">
        Judul: <input type="text" name="judul" class="form-control" required><br>
        Penulis: <input type="text" name="penulis" class="form-control" required><br>
        Penerbit: <input type="text" name="penerbit" class="form-control" required><br>
        Tahun Terbit: <input type="number" name="tahun_terbit" class="form-control" required><br>
        Kategori: <input type="text" name="kategori" class="form-control" required><br>
        Stok: <input type="number" name="stok" class="form-control" required><br>
        <select name="level_id" class="form-control" required>
            <option value="admin">Admin</option>
        </select><br>
        Gambar: <input type="file" name="gambar" class="form-control"><br><br>
        <button type="submit" name="add_book" class="btn btn-primary">Tambah Buku</button>
    </form>

    <hr>

    <h3>Daftar Buku</h3>
    <?php if ($result_books->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_books->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['judul']; ?></td>
                        <td><?php echo $row['penulis']; ?></td>
                        <td><?php echo $row['penerbit']; ?></td>
                        <td><?php echo $row['tahun_terbit']; ?></td>
                        <td><?php echo $row['kategori']; ?></td>
                        <td><?php echo $row['stok']; ?></td>
                        <td><img src="uploads/<?php echo $row['gambar']; ?>" width="50" height="50"></td>
                        <td>
                            <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada buku.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
