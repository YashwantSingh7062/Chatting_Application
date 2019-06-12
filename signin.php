<?php
    session_start();
    if(isset($_SESSION['successful'])){
        echo"<script>alert('Congratulations!! Your account is successfully created');</script>";
        unset($_SESSION['successful']);
    }
    if(isset($_SESSION['change_password'])){
        echo"<script>alert('Your Password is successfully changed');</script>";
        unset($_SESSION['change_password']);
    }
    if(isset($_SESSION['account_destoryed'])){
        echo"<script>alert('Your Account is successfully deleted');</script>";
        unset($_SESSION['account_destoryed']);
    }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MyChat signin</title>
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
                <div class="user-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-header text-center">
                    <h1><i>Sign In</i></h1>
                    <p><i>Sign In to My chat</i></p>
                </div>
                <div class="card-body">
                    <form action="Home" method="post" id="signin_form">
                       <div class="signin_form_output"></div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Someone@site.com" autocomplete="off" required>
                       </div>
                       <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="password" required autocomplete="off">
                       </div>
                       <div class="form-group">
                           <button type="button" id="signin_submit" name="signin_submit" class="btn btn-info btn-block">Submit</button>
                       </div>
                       <div class='text-center'><a href="#forgot_modal" data-toggle="modal">Forgot Password?</a></div>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <div class="text-muted">Don't have an account? <a href="SignUp" >SignUp</a></div>
                </div>
        </div> 
    </div>
    </div>
    <div class="modal fade" id="forgot_modal">
        <div class="modal-dialog">
            <div class='modal-content'>
                <div class="modal-header">
                    <h1><i class="fas fa-undo"></i> <i>Forgot Password</i></h1>
                    <span class='close' style="cursor:pointer;" data-dismiss="modal">&times;</span>
                </div>
                <div class="modal-body">
                   <form action="Forgot_Password" method="post" id="forgot_form">
                     <div class="forgot_form_output"></div>
                      <div class='form-group'>
                         <label for="forgot_username">Enter your Email:</label>
                          <input type="text" name="forgot_username" class='form-control' id="forgot_username" placeholder="Username" autocomplete="off">
                      </div>
                       <div class='form-group'>
                         <p><i>What is your best friend's name?</i></p>
                          <input type="text" name="forgot_answer" class='form-control' id="forgot_answer" placeholder="Best Friend Name" autocomplete="off">
                      </div>
                      <button type="button" id="forgot_submit" name="forgot_submit" class="btn btn-info btn-block">Submit</button>
                   </form> 
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
           $("#signin_submit").click(function(e){
               let email = $("#email").val();
               let password = $("#password").val();
               let signin_form_output = $(".signin_form_output");
                if(email == '' && password ==''){
                    signin_form_output.html("<small class='text-danger'>Password and Email should not be empty</small>");
                }
                else if(email == "" && password != ""){
                    signin_form_output.html("<small class='text-danger'>Email should not be Empty</small>");
                }
                else if(email != "" && password == ""){
                    signin_form_output.html("<small class='text-danger'>Password should not be Empty</small>");
                }
               else{
                    $.ajax({
                        url : "ajax_request.php",
                        data : 
                            {
                                action : "signin_validation",
                                email : email,
                                password : password
                            },
                        dataType : "HTML",
                        method : "POST",
                        success : function(response){
                            $(".signin_form_output").html(response);
                            if(response == "<small class='text-success'>Account Verified</small>"){
                                $("#signin_form").trigger('submit');
                            }
                            else{
                                $("#signin_form").trigger('reset');
                            }
                        }
                    });
               }
           });
            $("#forgot_submit").click(function(e){
               let forgot_username = $("#forgot_username").val();
               let forgot_answer = $("#forgot_answer").val();
               let forgot_form_output = $(".forgot_form_output");
                if(forgot_username == '' && forgot_answer ==''){
                    forgot_form_output.html("<small class='text-danger'>Email and Answer field should not be empty</small>");
                }
                else if(forgot_username == "" && forgot_answer != ""){
                    forgot_form_output.html("<small class='text-danger'>Email field should not be Empty</small>");
                }
                else if(forgot_username != "" && forgot_answer == ""){
                    forgot_form_output.html("<small class='text-danger'>Answer field should not be Empty</small>");
                }
               else{
                    $.ajax({
                        url : "ajax_request.php",
                        data : 
                            {
                                action : "forgot_validation",
                                email : forgot_username,
                                answer : forgot_answer
                            },
                        dataType : "HTML",
                        method : "POST",
                        success : function(response){
                            $(".forgot_form_output").html(response);
                            if(response == "<small class='text-success'>Answer Verified</small>"){
                                $("#forgot_form").trigger('submit');
                            }
                            else{
                                $("#forgot_form").trigger('reset');
                            }
                        }
                    });
               }
           });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>