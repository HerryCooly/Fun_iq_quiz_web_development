<?php
$errorMessage = "";
$mysqli = mysqli_connect("localhost", "cs213user", "hY592836711@", "projectDB");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if (isset($_POST['submit'])) {
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname = filter_input(INPUT_POST, 'lastname');
    $age = filter_input(INPUT_POST, 'age');
    $gender = filter_input(INPUT_POST, 'gender');
    $email = filter_input(INPUT_POST, 'email');

    $targetname = filter_input(INPUT_POST, 'username');
    $_SESSION['uname'] = $targetname;
    $targetpasswd = filter_input(INPUT_POST, 'password');
    $sql = "SELECT username FROM user_table WHERE username = '" . $targetname . "'";
    $sql2 = "SELECT username FROM user_info WHERE username = '" . $targetname . "'";
    $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
    $result2 = mysqli_query($mysqli, $sql2);
//get the number of rows in the result set; should be 1 if a match
    if (mysqli_num_rows($result) == 1 || mysqli_num_rows($result2) == 1) {


        //if authorized, get the values of f_name l_name
        while ($info = mysqli_fetch_array($result)) {
            $u_name = stripslashes($info['username']);
        }
        //create display string
        $errorMessage = "The user " . $u_name . " have registered, please try again!";
    } else {
        $sql3 = "INSERT INTO user_table values('$username', SHA1('$password'))";
        $result3 = mysqli_query($mysqli, $sql3);

        $sql4 = "INSERT INTO user_info values('$username', '$firstname', '$lastname', '$age', '$gender', '$email')";
        $result4 = mysqli_query($mysqli, $sql4);
        echo "The user " . $u_name . " have registered successfully! You can now go back and log in!";
    }
}


mysqli_close($mysqli);
?>


<html>
    <head>
        <link href="stylesheet.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <style>
            body {
                background-image: url('stone.jpg');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: 100% 100%;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <form method="post" action="applyaccount.php">
                <fieldset><legend><h3> User information </h3></legend>
                    <p><strong>Username:</strong><br/>
                        <input type="text" name="username" required/></p>
                    <p style="color:red;"><?php echo $errorMessage ?></p>
                    <p><strong>Password:</strong><br>
                        <input type="password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                               title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    <div id="message">
                        <h3>Password must contain the following:</h3>
                        <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                        <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                        <p id="number" class="invalid">A <b>number</b></p>
                        <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                    </div>
                    <p><strong>First Name:</strong><br/>
                        <input type="text" name="firstname" required/></p>
                    <p><strong>Last Name:</strong><br/>
                        <input type="text" name="lastname" required/></p>
                    <p><strong>Email:</strong><br>
                        <input type="email" name="email" required/></p>
                    <p><strong>Age</strong><br>
                        <input type="number" name="age" step="1" min="0" required/></p>
                    <p id="gender"><strong>Gender</strong><br>
                        <label for="male">Male</label>
                        <input type="radio" id="male" name="gender" value="male"/>
                        <label for="female">Female</label>
                        <input type="radio" id="female" name="gender" value="female"/>
                        <label for="undefined">Prefer Not Say</label>
                        <input type="radio" id="undefined" name="gender" value="undefined"/>
                    </p>


                    <p><input type="submit" name="submit" value="Create Account"/></p>
                </fieldset>
            </form>
        </div>


        <script>
            var myInput = document.getElementById("psw");
            var letter = document.getElementById("letter");
            var capital = document.getElementById("capital");
            var number = document.getElementById("number");
            var length = document.getElementById("length");


            // When the user clicks on the password field, show the message box
            myInput.onfocus = function () {
                document.getElementById("message").style.display = "block";
            }


            // When the user clicks outside of the password field, hide the message box
            myInput.onblur = function () {
                document.getElementById("message").style.display = "none";
            }


            // When the user starts to type something inside the password field
            myInput.onkeyup = function () {
                // Validate lowercase letters
                var lowerCaseLetters = /[a-z]/g;
                if (myInput.value.match(lowerCaseLetters)) {
                    letter.classList.remove("invalid");
                    letter.classList.add("valid");
                } else {
                    letter.classList.remove("valid");
                    letter.classList.add("invalid");
                }


                // Validate capital letters
                var upperCaseLetters = /[A-Z]/g;
                if (myInput.value.match(upperCaseLetters)) {
                    capital.classList.remove("invalid");
                    capital.classList.add("valid");
                } else {
                    capital.classList.remove("valid");
                    capital.classList.add("invalid");
                }


                // Validate numbers
                var numbers = /[0-9]/g;
                if (myInput.value.match(numbers)) {
                    number.classList.remove("invalid");
                    number.classList.add("valid");
                } else {
                    number.classList.remove("valid");
                    number.classList.add("invalid");
                }


                // Validate length
                if (myInput.value.length >= 8) {
                    length.classList.remove("invalid");
                    length.classList.add("valid");
                } else {
                    length.classList.remove("valid");
                    length.classList.add("invalid");
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" 
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" 
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </body>
</html>
