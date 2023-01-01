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
<body background="bg.jpg">
<div class="container">
    <div class="row">

        <?php
        $fault_alert = '<div class="col-12"><div class="alert alert-danger">Email not decided</div></div>';

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['user_email'])) {
                $email = htmlspecialchars($_POST['user_email']);

                $connection = DBConnection::get_instance()->get_connection();
                $sql = "SELECT * FROM login WHERE email = '" . $email . "'";

                $result = mysqli_query($connection, $sql);
                if ($result != false) {
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        session_start();
                        $_SESSION["id"] = $row["id"];
                        $_SESSION["user_email"] = $email;

                        setcookie("user_email", $email, time() + (86400 * 30), "/");

                        header('Location: change_password.php');
                    } else {
                        echo $fault_alert;
                    }
                } else {
                    echo $fault_alert;
                }
            } else {
                echo $fault_alert;
            }
        }
        ?>
        <h3 class="text-center text-white pt-5">Forgot Password Form</h3>
        <div class="container">
            <p class="text-left"><a href="login.php"><- Back </a></p>
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Forgot Password</h3>
                            <div class="form-group">
                                <label for="user-email" class="text-info">Enter your Email :</label><br>
                                <input type="text" name="user_email" class="form-control" id="user-email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
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