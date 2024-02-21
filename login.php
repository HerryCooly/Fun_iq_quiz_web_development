<?php
session_start();

$mysqli = mysqli_connect("localhost", "cs213user", "hY592836711@", "projectDB");
$targetname = filter_input(INPUT_POST, 'username');
$targetpasswd = filter_input(INPUT_POST, 'password');
$sql = "SELECT username, password FROM user_table WHERE username = '" . $targetname .
        "' AND password = SHA1('" . $targetpasswd . "')";
$sql2 = "SELECT ui.f_name, ui.l_name, ui.age, ui.gender, ui.email FROM user_info ui, user_table ut WHERE ut.username = '" . $targetname . "' AND ui.username = ut.username ";
$result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
$result2 = mysqli_query($mysqli, $sql2);
if (mysqli_num_rows($result) == 1) {
    while ($info = mysqli_fetch_array($result2)) {
        $f_name = stripslashes($info['f_name']);
        $l_name = stripslashes($info['l_name']);
        $age = stripslashes($info['age']);
        $gender = stripslashes($info['gender']);
        $email = stripslashes($info['email']);
    }
    setcookie("auth", session_id(), time() + 60 * 30, "/", "", 0);
} else {
    header("Location: index.html");
    echo "You have entered a invaild data, please try again!";
    exit;
    
}



?>
<html>
    <head>
        <link href="stylesheet.css" rel="stylesheet">
        <title>Fun IQ Quizzes</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <style>
            body {
                background-image: url('lake.jpg');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: 100% 100%;
            }
        </style>
    </head>
    <body>
        <h2>Welcome <i><?php echo $targetname;?></i>, to our fun IQ games</h2><br>
        <h3>Your Personal Info:</h3><br>
        <div class="shadow-lg p-2 mb-5 bg-body rounded"><b>First name : </b><?php echo $f_name; ?></div>
        <div class="shadow-lg p-2 mb-5 bg-body rounded"><b>Last name : </b><?php echo $l_name; ?></div>
        <div class="shadow-lg p-2 mb-5 bg-body rounded"><b>Age : </b><?php echo $age; ?></div>
        <div class="shadow-lg p-2 mb-5 bg-body rounded"><b>Gender : </b><?php echo $gender; ?></div>
        <div class="shadow-lg p-2 mb-5 bg-body rounded"><b>Email : </b><?php echo $email; ?></div>
        <a class="btn btn-primary btn-lg" href="q1.html" role="button">Play our fun-ish IQ game!</a><br><br>
        <a class="btn btn-primary btn-lg" href="index.html" role="button">Log Out</a>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" 
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" 
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </body>
</html>