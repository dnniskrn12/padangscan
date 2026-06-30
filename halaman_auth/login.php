<?php
session_start();
include_once "../database/koneksi.php";
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "
		SELECT 
			user.*, 
			pegawai.id AS id_pegawai, 
			pegawai.nama, 
			pegawai.gambar 
		FROM 
			user 
		LEFT JOIN 
			pegawai 
		ON 
			user.id=pegawai.id_user 
		WHERE 
			user.username='$username' 
			AND 
			user.password='$password'";
    if ($result = $mysqli->query($sql)) {
        if ($result->num_rows) {
            $_SESSION['user'] = $result->fetch_assoc();
            echo "<script>window.location.replace('../index.php');</script>";
        } else
            echo "<script>alert('Username atau Password Salah!');</script>";
    } else
        echo "Error: " . $sql . "<br>" . $mysqli->error;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/adminlte.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: right;
            align-items: center;
            min-height: 100vh;
            background: url('background.jpg') no-repeat;
            background-size: cover;
            background-position: center;

        }

        .wrapper {
            position: relative;
            left: -10%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 400px;
            height: 520px;
            box-shadow: 0 0 60px #000;
            border-radius: 10px;
            background-color: #ffdcc2;
            padding: 37px;
        }

        .logo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 170px;
            height: auto;
            margin-bottom: 10px;
        }

        .test-img {
            max-width: 100%;
            height: auto;
        }

        h2 {
            font-size: 2em;
            color: #a02c2c;
            text-align: center;
        }

        .input-group {
            position: relative;
            width: 320px;
            margin: 30px 0;
        }

        .input-group input {
            width: 100%;
            height: 40px;
            font-size: 1em;
            color: #000000;
            padding: 0 10px 0 35px;
            background: transparent;
            border: 1px solid #000000;
            outline: none;
            border-radius: 20px;
        }

        .input-group input::placeholder {
            color: rgba(219, 16, 16, 0.3);
        }

        .input-group .icon {
            position: absolute;
            display: block;
            left: 10px;
            color: #776d6d;
            font-size: 1.2em;
            line-height: 45px;
        }

        .forgot-pass {
            margin: -15px 0 15px;
        }

        .btn {
            position: relative;
            width: 100%;
            height: 45px;
            background: #b95e3a;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .4);
            font-size: 1em;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            outline: none;
            transition: .5s;
            border-radius: 20px;
        }

        .btn:hover {
            background: #fff;
            color: #b95e3a;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <form action="" method="POST">
            <div class="logo-wrapper">
                <img src="logo2.png" class="logo" alt="Logo">
                <img src="test.png" class="test-img" alt="Test Image">
            </div>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="person"></ion-icon>
                </span>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="submit" class="btn">Login</button>
        </form>
    </div>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>