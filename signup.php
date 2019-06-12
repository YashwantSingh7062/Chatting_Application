<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MyChat signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
</head>
<body> 
    <div class="row main-container m-0">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 p-0">
            <div class="card detail-form">
                <div class="card-header text-center">
                    <h1><i>Sign Up</i></h1>
                    <p><i>Fill out this form and start chatting with your friend</i></p>
                </div>
                <div class="card-body">
                    <form action="Process?action=signup" method="post">
                        <div class="form-group">
                           <div class='row'>
                               <div class='col-6'>
                                   <label for="signup_firstname">First Name</label>
                                    <input type="text" name="signup_first_name" id="signup_firstname" class="form-control" placeholder="First Name" autocomplete="off" required>
                                </div>
                               <div class='col-6'>
                                   <label for="signup_lastname">Last Name</label>
                                    <input type="text" name="signup_last_name" id="signup_lastname" class="form-control" placeholder="Last Name" autocomplete="off" required>
                               </div>
                           </div>
                       </div>
                       <div class="form-group">
                            <label for="signup_email">Email Address</label>
                            <input type="email" name="signup_email" id="signup_email" class="form-control" placeholder="Someone@site.com" autocomplete="off" required>
                            <div class="signup_email_output"></div>
                       </div>
                       <div class="form-group">
                            <label for="signup_password">Password</label>
                            <input type="password" name="signup_password" id="signup_password" class="form-control" placeholder="password" required autocomplete="off">
                       </div>
                       <div class='from-group'>
                           <label for="signup_forgot_answer">What is your best friend's name?</label>
                           <input type="text" name="signup_forgot_answer" id="signup_forgot_answer" placeholder="Best friend's name" reqired class="form-control" autocomplete="off">
                           <small class='text-muted'>This question will be asked while recalling password.</small>
                       </div>
                       <div class="form-group">
                            <label for="signup_country">Country</label>
                            <select name="signup_country" class="form-control" id="signup_country" required>
                                <option disabled selected>Select country</option>
                                <option value="India">India</option>
                                <option value="U.S.A.">U.S.A.</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Australia">Australia</option>
                                <option value="England">England</option>
                                <option value="Afganisthan">Afganisthan</option>
                                <option value="Africa">Africa</option>
                                <option value="China">China</option>
                                <option value="Rissia">Russia</option>
                            </select>
                       </div>
                       <div class="form-group">
                            <label for="signup_gender">Gender</label>
                            <select name="signup_gender" class="form-control" id="signup_gender" required>
                                <option disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                           </select>
                       </div>
                       <div class='from-group'>
                           <label for="signup_birthday">Birthday</label>
                           <input type="date" name="signup_birthday" id="signup_birthday" reqired class="form-control">
                       </div>
                       <div class="form-group">
                           <input type="checkbox" name="signup_accept" class="mr-2" required>I accept the <a href="#">Terms of use</a> &amp; <a href="#">Privacy Policy</a>
                       </div>
                       <div class="form-group">
                           <button type="submit" id="signup_submit" name="signup_submit" class="btn btn-info btn-block">Submit</button>
                       </div>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <div class="text-muted">Already have an Account? <a href="SignIn" >SignIn</a></div>
                </div>
            </div>  
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#signup_submit").click(function(e){
                if($("#signup_password").val().length < 8){
                    alert("Password shouldn't be of less than 8 characters");
                    e.preventDefault();
                }
                if($(".signup_email_output").html() != ""){
                    alert("Email already exist. Please try another email.");
                    e.preventDefault();
                }
            });
            $('#signup_email').keyup(function(){
                let value = $(this).val();
                if(value.length > 2){
                    $.ajax({
                        url : 'ajax_request.php',
                        data : {action:'signup_username_validation',value:value},
                        dataType : 'HTML',
                        method : 'POST',
                        success : function(response){
                            $('.signup_email_output').html(response);
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