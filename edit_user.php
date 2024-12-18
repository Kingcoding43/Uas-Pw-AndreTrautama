<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Pengguna tidak ditemukan.";
        exit();
    }
} else {
    echo "ID tidak ditemukan.";
    exit();
}

if (isset($_POST['edit_user'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/" . $gambar);
        $sql_update = "UPDATE users SET nama = '$nama', email = '$email', alamat = '$alamat', telepon = '$telepon', gambar = '$gambar' WHERE id = $id";
    } else {
        
        $sql_update = "UPDATE users SET nama = '$nama', email = '$email', alamat = '$alamat', telepon = '$telepon' WHERE id = $id";
    }

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Pengguna berhasil diupdate!'); window.location.href='crud.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .image-preview {
            max-width: 100px;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Pengguna</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama Pengguna</label>
            <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="telepon">Telepon</label>
            <input type="text" id="telepon" name="telepon" value="<?php echo $row['telepon']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar</label>
            <input type="file" id="gambar" name="gambar" class="form-control">
        </div>

        <div class="form-group">
            <label>Preview Gambar:</label><br>
            <img src="uploads/<?php echo $row['gambar']; ?>" class="image-preview" alt="Gambar Pengguna">
        </div>

        <button type="submit" name="edit_user" class="btn btn-primary">Update Pengguna</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
