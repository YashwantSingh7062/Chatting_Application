<?php
if(isset($_POST['action'])){
    session_start();
    include 'include/connection.php';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Signup Username Validation
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   if($_POST['action'] == 'signup_username_validation'){
       $query = "select * from users where user_email = '".$_POST['value']."'";
       $result = mysqli_query($conn,$query);
       if($row_count = mysqli_num_rows($result) > 0){
           echo "<span class='text-danger'>Email already exist</span>";
       }
       else{
           echo"";
       }
   }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Signin Validation
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    elseif($_POST['action'] == 'signin_validation'){
        $query = "select * from users where user_email = '".$_POST['email']."' AND user_pass = '".md5($_POST['password'])."'";
        $result = mysqli_query($conn,$query);
        if($row_count = mysqli_num_rows($result) > 0){
            $_SESSION['user'] = $_POST['email'];
            setcookie("user_email",$_POST['email'],time()+60*60*24*30);
            mysqli_query($conn,"UPDATE `users` SET `user_login`='Online' WHERE `user_email`='".$_POST['email']."'");
            echo"<small class='text-success'>Account Verified</small>";
        }
        else{
            echo "<small class='text-danger'>Password or Username is incorrect</small>";
        }
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Forgot Validation
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    elseif($_POST['action'] == 'forgot_validation'){
        $query = "select * from users where user_email = '".$_POST['email']."' AND forgot_answer = '".$_POST['answer']."'";
        $result = mysqli_query($conn,$query);
        if($row_count = mysqli_num_rows($result) > 0){
            $_SESSION['forgot_password'] = "successful";
            echo"<small class='text-success'>Answer Verified</small>";
        }
        else{
            echo "<small class='text-danger'>Email or Answer incorrect</small>";
        }
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Send_Message
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    elseif($_POST['action'] == 'send_message'){
        extract($_POST);
        if($msg_content == ''){
            echo "<span class='text-danger'>Message content should not be empty.</span>";
        }
        elseif(strlen($msg_content) > 500 ){
            echo"<span class='text-danger'>Message length should not be grater than 400 characters.</span>";
        }
        else{
            $msg_content = htmlentities($msg_content);
            $query = "INSERT INTO `users_chat`(`sender_email`, `receiver_email`, `msg_content`, `msg_status`, `msg_date`) VALUES (\"$sender_email\",\"$receiver_email\",\"$msg_content\",\"unread\",Now())";
            if($result = mysqli_query($conn,$query)){
                echo"<span class='text-light'>Message sent</span>";
            }
            else{
                echo "<span class='text-light'>Message not sent <br>$receiver_email</span>";
            }
        }
    }
    else{
        header("location:index.php");
    }
}
else{
    header("location:signin.php");
}
?>