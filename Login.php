<?php

$login = false;
$Showerror = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/dbconnect.php';
    $username = $_POST["Username"];
    $password = $_POST['password'];

    // $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while($row = mysqli_fetch_assoc($result)){
            if(password_verify($password,$row['password'])){
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: welcome.php");
            }
            else {    
                $Showerror = "Invalid password";
            }
            }
    } else {    
        $Showerror = "Invalid password";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        .container {
            display: flex;
            justify-content: center;

            /* align-items: center; */
            /* border: 0.5px solid black; */

        }

        .mb-3 {
            width: 350px;
            margin: 40px;

        }

        form {
            border: 2px solid black;
        }

        .submit {
            margin: auto;
            width: 150px;
        }
    </style>
</head>

<body>
    <?php require 'partials/_nav.php' ?>
    <?php
    if ($login) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> You are logged in.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($Showerror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . $Showerror . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>
    
    <h1 class="text-center">Login to our website</h1>
    <div class="container">
        <form action="/login/Login.php" method="Post">
            <div class="mb-3">
                <label for="Username" class="form-label ">Username</label>
                <input type="text" class="form-control" id="Username" name="Username" aria-describedby="emailHelp">

            </div>
            <div class="mb-3 ">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
          
            <div class="submit">
                <button type="submit" class="btn btn-primary ">Login</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>