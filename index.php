<?php
    session_start();
    include 'include/connection.php';
    if(isset($_COOKIE['user_email'])){
        $_SESSION['user']=$_COOKIE['user_email'];
    }
    if(!isset($_SESSION['user'])){
        header("location:signin.php");
    }
//DETAILS OF THE SENDER 
    $query = "select * from users where user_email ='".$_SESSION['user']."'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);

    $sender_username = $row['user_first_name']." ".$row['user_last_name'];
    $sender_email = $row['user_email'];
    $sender_gender = $row['user_gender'];
    $sender_profile = $row['user_profile'];
//DETAILS OF THE RECEIVER
    $query1 = "select * from users where user_email='".$_GET['email']."'";
    $result1 = mysqli_query($conn,$query1);
    $row1 = mysqli_fetch_array($result1);

    $receiver_username = $row1['user_first_name']." ".$row1['user_last_name'];
    $receiver_email = $row1['user_email'];

//MESSAGES COUNT
    $query2 = "select * from users_chat where (sender_email ='$sender_email' AND receiver_email = '$receiver_email') OR ( sender_email='$receiver_email' AND receiver_email ='$sender_email')";
    $result2 = mysqli_query($conn,$query2);
    $total_messages = 0;
    while($row2 = mysqli_fetch_array($result2)){
        $total_messages++;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.0.js" integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo=" crossorigin="anonymous"></script>
</head>

<body style="overflow-x:hidden;">
    <div class='row m-0 main-section'>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Left Section
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
        <div class="col-12 col-sm-4 col-md-3 p-0 left">
           <div class="row m-0 p-0 left-header">
               <div class="col-10 p-0">
                   <a href="Process?action=change_profile" title="<?php echo $sender_username; ?>">
                     <div class='row text-light m-0 py-sm-1'>
                         <div class='col-3 col-sm-4 p-0 px-1 px-sm-0'>

                      <?php
                        if(!empty($row['user_profile']) || $row['user_profile'] != NULL){
                            echo"<img src='data:image;base64,".$row['user_profile']."' alt='Profile_image' width='60px' height='60px' style='border-radius:50%;box-shadow:1px 1px 2px rgba(255, 255, 255, 0.3);'>";
                        }
                        else{
                            if($row['user_gender'] == "Male"){
                               echo"<img src='images/user_male.jpg' alt='Profile_image' height='60px' width='60px' style='border-radius:50%;'>"; 
                            }
                            elseif($row['user_gender'] =="Female"){
                               echo"<img src='images/user_female.jpg' alt='Profile_image' height='60px' width='60px' style='border-radius:50%;'>"; 
                            }
                        }
                        ?>
                         </div>
                             <div class='col-9 col-sm-8 p-0'>
                                 <h5 class='mt-3 mt-sm-3' ><?php echo $sender_username; ?></h5>
                            </div>
                       </div>
                    </a>
               </div>
               <div class="col-2 p-0">
                    <a href='Process?action=logout' title="Logout" class='btn btn-block left-logout'><i class='fas fa-power-off'></i></a>
               </div>
           </div>
            <div class="left-chat-bar">
                <ul>
                    <?php include 'include/get_users.php' ;?>
                </ul>
            </div>
            
        </div>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Right Section
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
        <div class="col-12 col-sm-8 col-md-9 p-0 right">
            <div class="row m-0">
              <?php
               if(isset($_GET['email'])){
                   ?>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Right Header Section
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
                   <div class="col-12 right-header p-1">
                   <div class="row m-0">
                        <div class='col-3 col-sm-2 right-header-img p-0 text-center'>
                            <?php
                                echo"<a href='Process?action=view_profile&user_email=".$row1['user_email']."'>";
                                    if(!empty($row1['user_profile']) || $row1['user_profile'] != NULL){
                                        echo"<img src='data:image;base64,".$row1['user_profile']."' alt='Profile_image' style='height:60px;width:60px;border-radius:50%;'>";
                                    }
                                    else{
                                        if($row1['user_gender'] == "Male"){ 
                                           echo"<img src='images/user_male.jpg' alt='Profile_image' style='height:60px;width:60px;border-radius:50%;'>"; 
                                        }
                                        elseif($row1['user_gender'] =="Female"){ 
                                           echo"<img src='images/user_female.jpg' alt='Profile_image' style='height:60px;width:60px;border-radius:50%;'>"; 
                                        }
                                    }
                                echo"</a>";
                        ?>
                        </div>
                        <div class='col-9 col-sm-10 right-header-details p-0'>
                            <h5 class='text-light'><?php echo $receiver_username; ?></h5>
                            <small class="text-muted">
                                <?php
                                    echo $total_messages;
                                ?> Messages
                            </small>
                        </div>
                    </div>
                </div>
                   <?php
               }
                ?>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Right ContentChat Section
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>                
            <div class='col-12 right-contentchat'<?php if(!isset($_GET['email'])){echo"style='height:100vh;'";}?>>
                    
                  <?php
                        if(isset($_GET['email'])){
                            ?>
                            <ul class='list-unstyled'>
                    <?php
                        //UPDATING READ STATUS
                           mysqli_query($conn,"UPDATE users_chat SET msg_status = 'read' WHERE sender_email ='$sender_email' AND receiver_email = '$receiver_email'");
                        
                        //SELECTING MESSAGES
                        $query3 = "select * from users_chat where (sender_email ='$sender_email' AND receiver_email = '$receiver_email') OR ( sender_email='$receiver_email' AND receiver_email ='$sender_email') ORDER by 1 ASC";
                    
                        $result3 = mysqli_query($conn,$query3);
                        if($row_count = mysqli_num_rows($result3) > 0){
                            echo"<a href='#hidden_contentchat_button' >Go Down <i class='fas fa-arrow-down'></i></a>";
                            while($row3 = mysqli_fetch_array($result3)){
                                $sender = $row3['sender_email'];
                                $receiver = $row3['receiver_email'];
                                $msg_content = $row3['msg_content'];
                                $msg_date = $row3['msg_date'];
                                ?>

                                        <?php if($sender_email == $sender && $receiver_email == $receiver){
                                    echo"<li>
                                        <div class='right-content-right-chat'>
                                            <span>$sender_username</span><small class='text-muted'>$msg_date</small>
                                            <p>$msg_content</p>
                                        </div>
                                    </li>";
                                }
                                elseif($sender_email == $receiver && $receiver_email == $sender){
                                    echo"<li>
                                        <div class='right-content-left-chat'>
                                            <span>$receiver_username</span><small class='text-muted'>$msg_date</small>
                                            <p>$msg_content</p>
                                        </div>
                                    </li>";
                                }
                                ?>

                                <?php
                            }
                        }
                            else{
                                ?>
                                <div class='right-contentchat-emptychat'>
                                   <span style="font-size:80px;"><i class="far fa-grin-stars"></i></span>
                                    <h4>There is not chat to show</h4>
                                    <small class='text-muted'>Leave a message to start a conversation</small>
                                </div>
                                <?php
                            }
                    ?>
                    </ul>
                            <?php
                        }
                    else{
                        ?>
                            <div class='right-contentchat-empty'>
                              <?php
                                if(!empty($sender_profile) || $sender_profile != NULL){
                                    echo"<img src='data:image;base64,".$sender_profile."' alt='Profile_image' height='250px' width='250px' style='border-radius:50%;'>";
                                }
                                else{
                                    if($sender_gender != "Female"){
                                       echo"<img src='images/user_male.jpg' alt='Profile_image' height='250px' width='250px' style='border-radius:50%;'>"; 
                                    }
                                    else{
                                       echo"<img src='images/user_female.jpg' alt='Profile_image'height='250px' width='250px' style='border-radius:50%;'>"; 
                                    }
                                }
                                ?>
                               <h3>Hello! <?php echo $sender_username ;?></h3>
                                <small class='text-muted'>Start chatting with your friends.</small><br>
                                <span style='font-size:25px;'><i class="fas fa-thumbs-up"></i> <i class="fas fa-heart"></i> <i class="far fa-laugh-beam"></i> <i class="far fa-grin-tongue-wink"></i> <i class="far fa-grin-tears"></i> <i class="far fa-grin-squint-tears"></i></span>
                            </div>
                        <?php
                    }
                    ?>
                    <button type="button" id="hidden_contentchat_button">Hidden contentchat button</button>
                </div>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Right MessageBox Section
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
                <?php
                if(isset($_GET['email'])){
                ?>
                <div class='col-12 right-message-box py-3'>
                    <form method="post">
                        <div class='form-group'>
                            <div class="row m-0">
                                <div class='col-9 col-sm-10 p-0'>
                                    <input type="text" id="msg_content" name="msg_content" autocomplete="off" placeholder="Write your message...." class="form-control">
                                    <small class="message_output"></small>
                                </div>
                                <div class='col-3 col-sm-2'>
                                    <button type="button" name="msg_submit" id="msg_submit" class="btn btn-primary btn-block" title="Send"><i class="fab fa-telegram-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                 <script>
                    $(document).ready(function(){
                        $("#msg_submit").click(function(){
                            $.ajax({
                                url:"ajax_request.php",
                                data:{
                                    action:"send_message",
                                    msg_content:$("#msg_content").val(),
                                    sender_email:'<?php echo $sender_email; ?>',
                                    receiver_email:'<?php  echo $_GET['email']; ?>'
                                },
                                dataType : 'HTML',
                                method : 'POST',
                                success : function(response){
                                    $(".message_output").html(response);
                                    if(response == "<span class='text-light'>Message sent</span>"){
                                        setTimeout(window.location.reload(true),1000);
                                    }
                                }
                            });
                        });
                    });
                </script>
                <?php
                }
                    ?>
               <script>
                   $(document).ready(function(){
                        $("#click_hidden_contentchat_button").trigger('click');  
                   });
             </script>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>