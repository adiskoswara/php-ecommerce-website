<?php
session_start();
require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #1c1c1c;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #2e2e2e;
            width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            padding: 30px;
        }

        .login-box h2 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 20px;
            font-size: 28px;
            color: #f8f8f8;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-control {
            background-color: #3c3c3c;
            border: 1px solid #555;
            color: #fff;
            border-radius: 25px;
            padding: 12px 15px;
            font-size: 14px;
        }

        .form-control:focus {
            background-color: #444;
            border-color: #777;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
        }

        .btn-login {
            background-color: #444;
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-login:hover {
            background-color: #555;
            transform: translateY(-3px);
        }

        .alert {
            margin-top: 10px;
            font-size: 14px;
            border-radius: 10px;
            padding: 10px;
        }

        .alert-warning {
            background-color: #f0ad4e;
            color: black;
        }

        .alert-danger {
            background-color: #ff4d4d;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Login Admin</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button class="btn btn-login w-100" type="submit" name="loginbtn">Login</button>
        </form>

        <div class="mt-3">
            <?php
            if (isset($_POST['loginbtn'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = md5(htmlspecialchars($_POST['password'])); // sesuaikan dengan penyimpanan md5 di DB

                // ✅ gunakan tabel admin, bukan users
                $query = mysqli_prepare($con, "SELECT * FROM admin WHERE username = ? AND password = ?");
                mysqli_stmt_bind_param($query, "ss", $username, $password);
                mysqli_stmt_execute($query);
                $result = mysqli_stmt_get_result($query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $data = mysqli_fetch_assoc($result);
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['login'] = true;

                    // ✅ redirect ke halaman index adminpanel
                    header("Location: index.php");
                    exit();
                } else {
                    echo '<div class="alert alert-danger">Username atau Password salah.</div>';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>
