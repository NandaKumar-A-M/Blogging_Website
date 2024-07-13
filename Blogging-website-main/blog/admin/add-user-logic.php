<?php

require 'config/database.php';


//get signup from data if submit button was clicked

if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'],
    FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    // validate input values
    if(!$firstname){
        $_SESSION['add-user'] = "please enter your first name";

    }elseif(!$lastname){
        $_SESSION['add-user'] = "please enter your last
         name";
    }
    elseif(!$username){
        $_SESSION['add-user'] = "please enter your user
        name";
    }
    elseif(!$email){
        $_SESSION['add-user'] = "please enter your valid
         email";
    }elseif(strlen($createpassword)<8 || strlen($confirmpassword)<8){
        $_SESSION['add-user'] = "password should be 8+ 
        characters";
    }elseif(!$avatar['name']){
        $_SESSION['add-user'] = "please add avatar";
    }else{
        //check if passwords dont match
        if($createpassword !== $confirmpassword){
            $_SESSION['add-user'] = "password do not match";

        }else{
            $hashed_password = password_hash($createpassword,
            PASSWORD_DEFAULT);
            
            // check if username or email already exists
            // in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection,$user_check_query);
            if(mysqli_num_rows($user_check_result)>0){
                $_SESSION['add-user'] = "username or email already exists";

            }else{
                // work on avatar
                //rename avatar
                $time = time();//make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_temp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;
                // make sure file is an image
                $allowed_files = ['png','jpg','jpeg'];
                $extension = explode('.',$avatar_name);
                $extension = end($extension);
                if(in_array($extension, $allowed_files)){
                    //make sure image is not too large(1mb+)
                    if($avatar['size'] < 1000000){
                        //upload avatar
                        move_uploaded_file($avatar_temp_name, $avatar_destination_path);

                    }
                    else{
                        $_SESSION['add-user'] = "file size is too big. should be less than 1mb";

                    }
                }else{
                    $_SESSION['add-user'] = "file should be png, jpg or jpeg";
                }

            }
        }
    }
    //readirect back to signup page if there was any problem
    if(isset($_SESSION['add-user'])){
        //pass from data back to signup page
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
    }else{
       //insert new user into user table 
       $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name',$is_admin)";
       $insert_user_result = mysqli_query($connection, $insert_user_query);       
       if(!mysqli_errno($connection)){
        //reduce to login page with success message
        $_SESSION['add-user-success'] = "New user $firstname $lastname added successfully";
        header('location: ' . ROOT_URL . 'admin/manage-user.php');
        die();
       }
    }

}else{
    header('location: '. ROOT_URL . 'admin/add-user.php');
    die();

}