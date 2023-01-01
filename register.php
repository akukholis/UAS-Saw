<?php
include_once ('connection.php');
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
        $connection = DBConnection::get_instance()->get_connection();
        session_start();
        $fault_alert = '<div class="col-12"><div class="alert alert-danger">Falied Register!</div></div>';
        $fault_alert1 = '<div class="col-12"><div class="alert alert-danger">Falied Register! Username Has Been Taken</div></div>';
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //geting the values from user input form inde
            $email = htmlspecialchars($_POST['user_email']);
            $username=$_POST['user_name'];
            $password=md5($_POST['user_password']);
            $nama=$_POST['nama'];
            $nim=$_POST['nim'];

            if( cek_nama($username,$connection) == 0 ){
                $sql = "INSERT INTO login (email, username, password, nama, nim) VALUES ('$email','$username', '$password', '$nama', '$nim')";

                $result = mysqli_query($connection, $sql);
                //query
                if ($result) {
                    echo '<div class="col-12"><div class="alert alert-success">Register Success!</div></div>';
                    header( "Refresh:2; url=login.php", true, 303);
                } else {
                    echo $fault_alert;
                }
            }
            else{
                echo $fault_alert1;
            }
        }
        function cek_nama($username,$connection){
            $nama = mysqli_real_escape_string($connection, $username);
            $query = "SELECT * FROM login WHERE username = '$nama'";
            if( $result = mysqli_query($connection, $query) ) return mysqli_num_rows($result);
        }
        ?>

        <h1 class="text-center text-white pt-5">Register form</h1>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="register-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Resgiter</h3>
                            <div class="form-group">
                                <label for="user-email" class="text-info">Email:</label><br>
                                <input type="text" name="user_email" class="form-control" id="user-email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="user-name" class="text-info">Username:</label><br>
                                <input type="text" name="user_name" class="form-control" id="user-name" placeholder="User Name">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="user_password" class="form-control" id="user-password" placeholder="User password">
                            </div>
                            <div class="form-group">
                                <label for="nama" class="text-info">Nama :</label><br>
                                <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <label for="nim" class="text-info">Nim :</label><br>
                                <input type="text" name="nim" class="form-control" id="nim" placeholder="Nim">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Submit">
                            </div>
                            <div id="register-link" class="text-center">
                                <p>Already have an account ? <a href="login.php" class="text-right">Login here</a></p>
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