<?php
session_start();
include 'include/connection.php';
    if(isset($_GET['action'])){
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Sign Up 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($_GET['action'] == 'signup' && isset($_POST['signup_submit'])){
            extract($_POST);
            $signup_password = md5($signup_password);
            
            $query = "INSERT INTO `users`(`user_first_name`, `user_last_name`, `user_pass`, `user_email`,`user_country`, `user_gender`, `user_birthdate`, `forgot_answer`) VALUES ('$signup_first_name','$signup_last_name','$signup_password','$signup_email','$signup_country','$signup_gender','$signup_birthday','$signup_forgot_answer')";

            $result = mysqli_query($conn,$query);
            $_SESSION['successful']="successful";
            header("location:SignIn");
            exit();
        }
        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Logout
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif($_GET['action'] == 'logout'){
            mysqli_query($conn,"UPDATE users SET user_login ='Offline' WHERE user_email ='".$_SESSION['user']."'");
            session_destroy();
            setcookie("user_email","",time()-55500);
            header("location:SignIn");
            exit();
        }
        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Account Settings
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif($_GET['action'] == "change_profile"){
            $query="select * from users where user_email ='".$_SESSION['user']."'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_array($result);
           echo"<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                    <title>Change Settings</title>
                    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
                    <link href='https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i' rel='stylesheet'>
                    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' integrity='sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf' crossorigin='anonymous'>
                    <link rel='stylesheet' type='text/css' href='css/style.css'>
                    <script src='https://code.jquery.com/jquery-3.4.0.js' integrity='sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=' crossorigin='anonymous'></script>
                </head>
                <body style='overflow-x:hidden;'>
                <div class='row m-0'>
                    <div class='col-12 col-sm-8 offset-sm-2 p-0'>
                        <div class='cover_photo'>";
                        if(!empty($row['user_cover_profile']) || $row['user_cover_profile'] != NULL){
                            echo"<label for='upload_cover'><img src='data:image;base64,".$row['user_cover_profile']."' alt='cover_profile_image'></label>";
                        }
                        else{
                            echo"<label for='upload_cover'><img src='images/upload_cover.png' alt='cover_photo'></label>";
                        }
                    echo"<div class='account_profile_image'>";
                       if(!empty($row['user_profile']) || $row['user_profile'] != NULL){
                            echo"<label for='upload_profile'><img src='data:image;base64,".$row['user_profile']."' alt='Profile_image' class='img-fluid'></label>";
                        }
                        else{
                            if($row['user_gender'] != "Female"){
                               echo"<label for='upload_profile'><img src='images/user_male.jpg' alt='Profile_image' class='img-fluid'></label>"; 
                            }
                            else{
                               echo"<label for='upload_profile'><img src='images/user_female.jpg' alt='Profile_image'class='img-fluid'></label>"; 
                            }
                        }
                    echo"</div>
            <form action='Process?action=upload_cover' method='post' enctype='multipart/form-data' >
                <input type='file' name='cover' id='upload_cover' accept='image/jpg,image/png,image/jpeg' hidden>
                <input type='submit' name='upload_cover_submit' value='submit' hidden>
            </form>
            <form action='Process?action=upload_profile' method='post' enctype='multipart/form-data'>
                <input type='file' name='profile' id='upload_profile' accept='image/jpg,image/png,image/jpeg' hidden>
                <input type='submit' name='upload_profile_submit' value='submit' hidden>
            </form>
            <script>
                $(document).ready(function(){
                    $('#upload_cover , #upload_profile').change(function(){
                    if(this.files[0].size/1024/1024 > 0.9){
                        alert('File size should not be greater than 1 MB');
                    }
                    else{
                         $(this).siblings().trigger('click');
                    }
                       
                    });
                });
            </script>
                </div>
            </div>
            <div class='col-12 mt-4'>
                <h2 class='display-4 text-center'>Account Settings</h2>
            </div>
            <div class='col-12 col-sm-8 offset-sm-2'>
            <button type='button' class='btn btn-primary mb-1' id='edit'>Edit Account</button><br>
            <a href='Process?action=deactivate_account' id='deactivate_account'>Deactivate Account</a>
            <script>
                $(document).ready(function(){
                    $('#deactivate_account').click(function(e){
                        if(!confirm('Do you really want to delete this account')){
                            e.preventDefault();
                        }
                    });
                });
            </script>
                <form action='Process?action=edit_profile' method='post' enctype='multipart/form-data' class='my-4'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-6'>
                                <label for='first_name'>First Name</label>
                                <input type='text' name='first_name' id='first_name' value='".$row['user_first_name']."' class='form-control' disabled='true'>
                            </div>
                            <div class='col-6'>
                                <label for='first_name'>Last Name</label>
                                <input type='text' name='last_name' id='last_name' value='".$row['user_last_name']."' class='form-control' disabled='true'>
                        </div>
                    </div>
                    
                    <div class='form-group mt-2'>
                        <label for='country'>Country</label>
                        <select class='form-control' id='country' name='country' disabled='true'>
                            <option selected value='".$row['user_country']."'>".$row['user_country']."</option>
                            <option value='India'>India</option>
                            <option value='U.S.A.'>U.S.A.</option>
                            <option value='New Zealand'>New Zealand</option>
                            <option value='Australia'>Australia</option>
                            <option value='England'>England</option>
                            <option value='Afganisthan'>Afganisthan</option>
                            <option value='Africa'>Africa</option>
                            <option value='China'>China</option>
                            <option value='Rissia'>Russia</option>
                        </select>
                    </div>
                    <div class='form-group'>
                            <label for='gender'>Gender</label>
                            <select class='form-control' name='gender' id='gender' disabled='true'>
                                <option selected value='".$row['user_gender']."'>".$row['user_gender']."</option>
                                <option value='Male'>Male</option>
                                <option value='Female'>Female</option>
                                <option value='Others'>Others</option>
                           </select>
                    </div>
                    <div class='form-group'>
                        <label for='birthday'>Birthdate</label>
                        <input type='date' value='".$row['user_birthdate']."' name='birthdate' id='birthday' class='form-control' disabled='true'>
                    </div>
                    <input type='submit' name='edit_submit' class='btn btn-info form-control' disabled='true'>
                </div> 
            </form>
            <script>
                $(document).ready(function(){
                    $('#edit').click(function(){
                        if($('.form-control').attr('disabled') == 'disabled'){
                            $('.form-control').removeAttr('disabled');
                            $(this).html('Cancel');
                        }
                        else{
                            $('.form-control').attr('disabled','disabled');
                            $(this).html('Edit Account');
                        }
                    });
                });
            </script>
        </div>
        <div class='col-12 text-center mb-5'>
            <a href='Home'class='btn btn-outline-info'><i class='fas fa-arrow-left'></i> Go Back</a>
            <a href='Process?action=logout' class='btn btn-info'><i class='fas fa-power-off'></i> Logout </a>
        </div>
    </div>
           <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'></script>
        </body>
        </html>";
        }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Deactivate Account 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif($_GET['action'] == 'deactivate_account'){
            session_start();
            $query = "delete from users where user_email ='".$_SESSION['user']."'";
            mysqli_query($conn,$query);
            unset($_SESSION['user']);
            $_SESSION['account_destoryed'] = "true";
            setcookie("user_email","",time()-55500);
            header("location:SignIn");
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// upload cover 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif($_GET['action'] == 'upload_cover'){
            $image = addslashes($_FILES['cover']['tmp_name']);
            $image = file_get_contents($image);
            $image = base64_encode($image);
                       
            $query = "UPDATE `users` SET `user_cover_profile`= '$image' WHERE user_email = '".$_SESSION['user']."'";
            if(mysqli_query($conn,$query)){
                echo "cover uploaded";
                header("location:Process?action=change_profile");
            }
            else{
                echo"uploading unsuccessful";
                header("location:Process?action=change_profile");
            }
        }
        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// upload profile
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif($_GET['action'] == 'upload_profile'){
            $image = addslashes($_FILES['profile']['tmp_name']);
            $image = file_get_contents($image);
            $image = base64_encode($image);
                       
            $query = "UPDATE `users` SET `user_profile`= '$image' WHERE user_email = '".$_SESSION['user']."'";
            if(mysqli_query($conn,$query)){
                echo "profile uploaded";
                header("location:Process?action=change_profile");
            }
            else{
                echo"uploading unsuccessful";
                header("location:Process?action=change_profile");
            }
        }
        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Edit profile
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif($_GET['action'] == 'edit_profile'){
            extract($_POST);
            $query = "UPDATE `users` SET `user_first_name`='$first_name',`user_last_name`='$last_name',`user_country`='$country',`user_gender`='$gender',`user_birthdate`='$birthdate' WHERE user_email = '".$_SESSION['user']."'";
            if(mysqli_query($conn,$query)){
                echo "profile uploaded";
                header("location:Process?action=change_profile");
            }
            else{
                echo"uploading unsuccessful";
                header("location:Process?action=change_profile");
            }
        }
        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// forgot_password
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif($_GET['action'] == 'forgot_password'){
            extract($_POST);
            $confirm_password = md5($confirm_password);
            $query ="UPDATE `users` SET `user_pass`='$confirm_password' WHERE user_email ='$forgot_username'";
            mysqli_query($conn,$query);
            $_SESSION['change_password']="successful";
            unset($_SESSION['forgot_password']);
            header("location:SignIn");
        }
        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// View Profile
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        elseif($_GET['action'] == 'view_profile'){
           $query="select * from users where user_email ='".$_GET['user_email']."'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_array($result);
           echo"<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                    <title>View Profile</title>
                    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
                    <link href='https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i' rel='stylesheet'>
                    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' integrity='sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf' crossorigin='anonymous'>
                    <link rel='stylesheet' type='text/css' href='css/style.css'>
                    <script src='https://code.jquery.com/jquery-3.4.0.js' integrity='sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=' crossorigin='anonymous'></script>
                </head>
                <body style='overflow-x:hidden;background-image:url('images/right-content-background-image.png');'>
                <div class='row m-0'>
                    <div class='col-12 col-sm-8 offset-sm-2 p-0'>
                        <div class='cover_photo_view_profile'>";
                        if(!empty($row['user_cover_profile']) || $row['user_cover_profile'] != NULL){
                            echo"<img src='data:image;base64,".$row['user_cover_profile']."' alt='cover_profile_image'>";
                        }
                        else{
                            echo"<img src='images/upload_cover.png' alt='cover_photo'>";
                        }
                    echo"<div class='account_profile_image_view_profile'>";
                       if(!empty($row['user_profile']) || $row['user_profile'] != NULL){
                            echo"<img src='data:image;base64,".$row['user_profile']."' alt='Profile_image' class='img-fluid'>";
                        }
                        else{
                            if($row['user_gender'] != "Female"){
                               echo"<img src='images/user_male.jpg' alt='Profile_image' class='img-fluid'>"; 
                            }
                            else{
                               echo"<img src='images/user_female.jpg' alt='Profile_image'class='img-fluid'>"; 
                            }
                        }
                    echo"   </div>
                        </div>
                    </div>
                    <div class='col-12 col-sm-8 offset-sm-2 p-0 text-center mt-5'>
                        <h2 class='display-4 mt-3'>".$row['user_first_name']." ".$row['user_last_name']."</h2>
                    </div>
                    <div class='col-12 col-sm-6 offset-sm-3 p-0 mt-3'>
                        <div class='row m-0'>
                            <div class='col-4 col-sm-6 p-0'>
                                <h4>Email:</h4>
                            </div>
                            <div class='col-8 col-sm-6 p-0'>
                                <h5><i>".$row['user_email']."</i></h5>
                            </div>
                        </div>
                        <div class='row m-0'>
                            <div class='col-4 col-sm-6 p-0'>
                                <h4>Country:</h4>
                            </div>
                            <div class='col-8 col-sm-6 p-0'>
                                <h5>".$row['user_country']."</h5>
                            </div>
                        </div>
                        <div class='row m-0'>
                            <div class='col-4 col-sm-6 p-0'>
                                <h4>Gender:</h4>
                            </div>
                            <div class='col-8 col-sm-6 p-0'>
                                <h5>".$row['user_gender']."</h5>
                            </div>
                        </div>
                        <div class='row m-0'>
                            <div class='col-4 col-sm-6 p-0'>
                                <h4>Birthdate:</h4>
                            </div>
                            <div class='col-8 col-sm-6 p-0'>
                                <h5>".$row['user_birthdate']."</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-12 col-sm-8 offset-sm-2 p-0 text-center my-3 mb-5'>
                    <a href='Home' style='font-size:25px;'><i class='fas fa-arrow-left'></i> Back</a>
                </div>
            </div>
           <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'></script>
        </body>
        </html>";
        }
        
        else{
            header("location:Home");
        } 
    }
else{
    header("location:SignIn");
}
?>