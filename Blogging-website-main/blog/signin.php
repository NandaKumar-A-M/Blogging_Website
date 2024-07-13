<?php

require 'config/constants.php';
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;
unset($_SESSION['signin-data']);





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogStein</title>
    <!--CUSTOM STYLESHEET-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/bb.css">
    <!--Icon scout CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!--Google fonts montserrat-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- <style>
        .success{
            background-color:darkgreen;
            color:greenyellow;
            padding:10px;
        }
    </style> -->
</head>
<body>

<section class="form_section">
    <div class="container form section-container">
    <h2>Sign IN</h2>
    <?php if(isset($_SESSION['signup-success'])) : ?>
        <div class="alert__message success"> 
        <p>
            <?= $_SESSION['signup-success'];
            unset($_SESSION['signup-success']);
            ?>
        </p>
        </div>
    <?php elseif (isset($_SESSION['signin'])) : ?>
        <div class="alert__message error"> 
          <p>
              <?= $_SESSION['signin'];
              unset($_SESSION['signin']);
              ?>
          </p>
        </div>
    <?php endif ?>
    <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
    <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or email">
    <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
    <!-- <div class="form_control">
    <label for="avatar" >User Avatar</label>
    <input type="file" id="avatar">
    </div> -->
    <button type="submit" name="submit" class="btn">Sign In</button>
    <small>Don't have a account?<a href="signup.php">Sign up</a></small>
    </form>
    </div>
    
</section>
</body>
</html>
