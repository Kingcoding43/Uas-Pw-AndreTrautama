<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daftar_perpus";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id, nama FROM users WHERE email = ? AND nama = ?");
    $stmt->bind_param("ss", $email, $nama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        session_start();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['nama'];
        header("Location: crud.php");
        exit();
    } else {
        $error = "Email atau nama salah!";
    }

    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna Perpustakaan</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form label {
            font-size: 14px;
            color: #333;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .login-form input:focus {
            border-color: #0066cc;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #005bb5;
        }

        p {
            text-align: center;
            margin-top: 10px;
            color: #555;
        }

        a {
            text-decoration: none;
            color: #0066cc;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsiveness */
        @media screen and (max-width: 500px) {
            .container {
                padding: 20px;
                max-width: 90%;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Pengguna Perpustakaan</h2>
        <form action="" method="POST" class="login-form">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required placeholder="Masukkan Nama">
            </div>

            <div class="form-group">
                <label for="email">Email:</label> 
                <input type="email" id="email" name="email" required placeholder="Masukkan Email">
            </div>

            <div class="form-group">
                <button type="submit" class="submit-btn">Login</button>
            </div>

            <?php
            // Menampilkan error jika ada
            if (!empty($error)) {
                echo "<p style='color:red; text-align:center;'>$error</p>";
            }
            ?>
            <a href="crud.php"></a>

            <p>Belum punya akun? <a href="register.php">Registrasi di sini</a></p>
        </form>
    </div>
</body>
</html>
