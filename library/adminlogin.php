<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- ✅ Simple CSS styling for better UI -->
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 {
            margin-bottom: 20px;
        }
        .btn {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container" style="margin-top: 100px; max-width: 400px;">
    <h3 class="text-center">Admin Login</h3>
    
    <!-- Form -->
    <form role="form" method="post">
        <fieldset>
            <div class="form-group">
                <input class="form-control" placeholder="Enter E-mail" name="email" type="email" required>
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="Password" name="password" type="password" required>
            </div>
            <input type="submit" class="btn btn-success btn-block" name="login" value="Login">
        </fieldset>
    </form>

    <!-- PHP Login Logic -->
    <?php
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Demo credentials for testing
        $demo_email = "admin@example.com";
        $demo_password = "admin123";

        if ($email === $demo_email && $password === $demo_password) {
            echo "<div class='alert alert-success mt-3'>Login successful! Welcome, Admin.</div>";
            // Redirect to dashboard if needed
            // header("Location: dashboard.php");
        } else {
            echo "<div class='alert alert-danger mt-3'>Invalid email or password.</div>";
        }
    }
    ?>
</div>

</body>
</html>
