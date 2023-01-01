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
        $fault_alert = '<div class="col-12"><div class="alert alert-danger">Falied Change!</div></div>';
        $fault_alert1 = '<div class="col-12"><div class="alert alert-danger">Falied Change Password! Password Must be New!</div></div>';
        $fault_alert2 = '<div class="col-12"><div class="alert alert-danger">Password and Repassword must be same@</div></div>';
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //geting the values from user input form inde
            $password=md5($_POST['user_password']);
            $repassword=md5($_POST['user_repassword']);
            if($password == $repassword){
                if( cek_nama($password,$connection) == 0 ){
                    $sql = "UPDATE login SET password='$password' WHERE email='$_SESSION[user_email]'";

                    $result = mysqli_query($connection, $sql);
                    //query
                    if ($result) {
                        echo '<div class="col-12"><div class="alert alert-success">Change Password Success!</div></div>';
                        header( "Refresh:2; url=login.php", true, 303);
                    } else {
                        echo $fault_alert;
                    }
                }
                else{
                    echo $fault_alert1;
                }
            } else {
                echo $fault_alert2;
            }
        }
        function cek_nama($password,$connection){
            $password = mysqli_real_escape_string($connection, $password);
            $query = "SELECT * FROM login WHERE password = '$password'";
            if( $result = mysqli_query($connection, $query) ) return mysqli_num_rows($result);
        }
        ?>

        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="register-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Change Password</h3>
                            <?php if (isset($_SESSION['user_email'])) : ?>
                                <p style="text-align: center">Your Email :  <strong><?php echo $_SESSION['user_email']; ?></strong></p>
                            <?php endif ?>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="user_password" class="form-control" id="user-password" placeholder="User password">
                            </div>
                            <div class="form-group">
                                <label for="repassword" class="text-info">Re-Password:</label><br>
                                <input type="password" name="user_repassword" class="form-control" id="user-repassword" placeholder="User repassword">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Submit">
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