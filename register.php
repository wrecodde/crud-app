<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a superhuman</title>

    <!-- using for 'minimal' styling -->
    <link rel="stylesheet" href="https://taniarascia.github.io/primitive/css/main.css">
</head>
<body>
    <?php
        include 'database.php';

        $error_message = "";
        $username = "";
        $email = "";
        $password = "";

        if (isset($_POST["submit"])){
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            $user = select_user($conn, $username);

            if ($user){
                $error_message = "An account with username '$username' has already been created";;
            } else {
                $new_user = [
                    "username" => $username,
                    "email" => $email,
                    "password" => $password
                ];
                
                insert_user($conn, $new_user);
                $_SESSION["logged_in"] = $username;
                header("Location: index.php");
            }
        }
    ?>

    <?php
    if (!isset($_SESSION["logged_in"])){
        echo('
        <div class="small-container">
            <div class="flex-row">
                <div class="flex-small">
                    <h4>Hello human,</h4>
                    <p>Create an account to become a <b>superhuman</b></p>

                    <form action="register.php" method="post">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="your superhuman name" value="'.$username.'">

                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="your superhuman email" value="'.$email.'">

                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="your access key" value="'.$password.'">
                        
                        <p style="color: red">'.$error_message.'</p>

                        <input type="submit" name="submit" value="Register" class="full-button">
                    </form>
                </div>
            </div>
        </div>
        ');
    } else {
        echo('
        <div class="small-container">
            <div class="flex-row">
                <div class="flex-small">
                    <h4>Hello superhuman,</h4>
                    <p>You\'re already logged in, <b>'.$_SESSION["logged_in"].'</b></p>
                    <p><a href="logout.php">Logout</a> to create another account</p>
                </div>
            </div>
        </div>
        ');
    }
    ?>
    
</body>
</html>
