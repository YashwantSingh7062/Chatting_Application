<?php
    session_start();
    include 'include/connection.php';
    if(!isset($_SESSION['forgot_password'])){
        header("location:signin.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
</head>
<body> 
    <div class="row main-container signin_row m-0">
        <div class="col-12 col-sm-6 offset-sm-3 col-md-4 offset-sm-4 p-0">
            <div class="card detail-form">
                <div class="card-header text-center">
                    <h1><i>Change Password</i></h1>
                </div>
                <div class="card-body">
                    <form action="Process?action=forgot_password" method="post" id="forgot_form">
                      <div class="forgot_form_output"></div>
                       <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New password" required autocomplete="off">
                       </div>
                       <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required autocomplete="off">
                       </div>
                       <input type="hidden" value="<?php echo $_POST['forgot_username']; ?>" name="forgot_username"> 
                       <div class="form-group">
                           <button type="button" id="forgot_submit" name="forgot_submit" class="btn btn-info btn-block">Submit</button>
                       </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#forgot_submit").click(function(){
                let new_password = $("#new_password").val();
                let confirm_password = $("#confirm_password").val();
                if(new_password =="" && confirm_password == ""){
                    $(".forgot_form_output").html("<small class='text-danger'>New password and Confirm password should not be empty.</small>");
                }
                else if(new_password =="" && confirm_password != ""){
                    $(".forgot_form_output").html("<small class='text-danger'>New password should not be empty.</small>");
                }
                else if(new_password !="" && confirm_password == ""){
                    $(".forgot_form_output").html("<small class='text-danger'>Confirm password should not be empty.</small>");
                }
                else if(new_password != confirm_password){
                    $(".forgot_form_output").html("<small class='text-danger'>New password and Confirm password field values didn't matched.</small>");
                    $("#forgot_form").trigger("reset");
                }
                else if(confirm_password.length < 8){
                    $(".forgot_form_output").html("<small class='text-danger'>Password's length should not be less than 8 characters.</small>");
                    $("#forgot_form").trigger("reset");
                }
                else{
                    $("#forgot_form").trigger("submit");
                }
            });
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>