    <?php

    $ShowAlert = false;
    $Showerror = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'partials/dbconnect.php';
        $username = $_POST["Username"];
        $password = $_POST['password'];
        $cpassword = $_POST["confirmpassword"];
    
        // Check if any field is empty
        if (empty($username) || empty($password) || empty($cpassword)) {
            $Showerror = "Please fill in all the fields.";
        } else {
            // Check if username already exists
            $existsql = "SELECT * FROM `users` WHERE username = '$username'";
            $result = mysqli_query($conn, $existsql);
            $numExistRows = mysqli_num_rows($result);
            if ($numExistRows > 0) {
                $Showerror = "Username already exists.";
            } else {
                // Check if password and confirm password match
                if ($password == $cpassword) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$hash', CURRENT_TIMESTAMP())";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        $ShowAlert = true;
                    }
                } else {
                    $Showerror = "Passwords do not match.";
                }
            }
        }
    }

    ?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Signup</title>
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
        if($ShowAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong>Your account is now created and you can login.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
        if($Showerror){
        echo '<div class="alert alert-danger     alert-dismissible fade show" role="alert">
            <strong>Error!</strong>'.$Showerror.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
        ?>
        
        <h1 class="text-center">Signup to our website</h1>
        <div class="container">
            <form action="/login/signup.php" method="Post">
                <div class="mb-3">
                    <label for="Username" class="form-label ">Username</label>
                    <input type="text" class="form-control" maxlength="11" id="Username" name="Username" aria-describedby="emailHelp">

                </div>
                <div class="mb-3 ">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" maxlength="23" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirmpassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                    <div id="emailHelp" class="form-text">Make sure to type the same password</div>
                </div>
                <div class="submit">
                    <button type="submit" class="btn btn-primary ">Signup</button>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
    </body>

    </html>