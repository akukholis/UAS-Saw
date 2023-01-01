<?php
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == false) {
    session_destroy();
    }
else {
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body background="bg.jpg">
<div class="homeheader">
    <h2>Home Page</h2>
</div>

<div class="homecontent">
    <!--  notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success">
            <h3>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif ?>

    <!-- logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p><a href="logout.php" style="color: red;">Logout</a></p>
    <?php endif ?>

    <?php if (!isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p><a href="logout.php" style="color: red;">Logout</a></p>
    <?php endif ?>
    <?php
    include('connection.php');
    $connection = DBConnection::get_instance()->get_connection();
    $query = "SELECT email, username, nama, nim FROM login";
    $result = $connection->query($query);
    ?>
<!--    <table border="1" cellspacing="0" cellpadding="10">-->
<!--        <tr>-->
<!--            <th>No.</th>-->
<!--            <th>Email</th>-->
<!--            <th>Username</th>-->
<!--            <th>Nama</th>-->
<!--            <th>NIM</th>-->
<!--        </tr>-->
<!--        --><?php
//        if ($result->num_rows > 0) {
//            $sn=1;
//            while($data = $result->fetch_assoc()) {
//                ?>
<!--                <tr>-->
<!--                    <td>--><?php //echo $sn; ?><!-- </td>-->
<!--                    <td>--><?php //echo $data['email']; ?><!-- </td>-->
<!--                    <td>--><?php //echo $data['username']; ?><!-- </td>-->
<!--                    <td>--><?php //echo $data['nama']; ?><!-- </td>-->
<!--                    <td>--><?php //echo $data['nim']; ?><!-- </td>-->
<!--                <tr>-->
<!--                --><?php
//                $sn++;}} else { ?>
<!--            <tr>-->
<!--                <td colspan="8">No data found</td>-->
<!--            </tr>-->
<!---->
<!--        --><?php //} ?>
<!--    </table>-->
    <div style="text-align: center">
        <h2>Profile User</h2>
        <?php
        $query = "SELECT email, username, nama, nim FROM login where username = '".$_SESSION['username']."'";
        $result = $connection->query($query);
        $data = $result->fetch_assoc();
        ?>
        <h1><?php echo $data['nama']; ?></h1>
        <h2><?php echo $data['nim']; ?></h2>
        <h3><?php echo $data['email']; ?></h3>
        <h3>Teknik Informatika</h3>
        <p>Never stop learn!</p>
    </div>
</div>

</body>
</html>