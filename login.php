<?php

include_once('connection.php');

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
</head>
<body background="bg.jpg" link="#000" alink="#017bf5" vlink="#000">
	<div class="container">
		<div class="row">

			<?php
			$fault_alert = '<div class="col-12"><div class="alert alert-danger">Falied Login</div></div>';
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				if (isset($_POST['user_name']) && isset($_POST['user_password'])) {
					$username = htmlspecialchars($_POST['user_name']);
					$password = htmlspecialchars($_POST['user_password']);

					$connection = DBConnection::get_instance()->get_connection();
					$sql = "SELECT * FROM login WHERE username = '" . $username . "' AND password = '" . md5($password) . "'";

					$result = mysqli_query($connection, $sql);
                    if(!empty($_POST['remember_me'])) {
                        if ($result != false) {
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                session_start();
                                $_SESSION["id"] = $row["id"];
                                $_SESSION["username"] = $username;

                                $_SESSION["logged_in"] = true;

                                setcookie("username", $username, time() + (86400 * 30), "/");

                                header('Location: content.php');
                            } else {
                                echo $fault_alert;
                            }
                        } else {
                            echo $fault_alert;
                        }
                    } else {
                        if ($result != false) {
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                session_start();
                                $_SESSION["id"] = $row["id"];
                                $_SESSION["username"] = $username;

                                $_SESSION["logged_in"] = false;

                                header('Location: content.php');
                            } else {
                                echo $fault_alert;
                            }
                        } else {
                            echo $fault_alert;
                        }
                    }
				} else {
					echo $fault_alert;
				}
			}
			?>

            <h1 class="text-center text-white pt-5">Login form</h1>
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="" method="post">
                                <h1 class="text-center text-info">Selamat Datang!</h1>
                                <h6 class="text-center text-info">silahkan login terlebih dahulu.</h6>
                                <div class="form-group">
                                    <label for="user-name" class="text-info">Username:</label><br>
                                    <input type="text" name="user_name" class="form-control" id="user-name" placeholder="User Name">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Password:</label><br>
                                    <input type="password" name="user_password" class="form-control" id="user-password" placeholder="User password">
                                </div>
                                <div class="form-group">
                                    <label for="remember" class="text-info"><span>Ingat saya</span> <span><input id="remember_me" name="remember_me" type="checkbox"></span></label>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                                <div id="register-link" class="text-center">
                                    <p>Lupa password ? <a href="forgot.php" class="text-right" style="text-align: right">Reset.</a></p>
                                    <p>Belum mempunyai akun ? <a href="register.php" class="text-right">Registrasi.</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</body>
</html>