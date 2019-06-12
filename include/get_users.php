<?php
    $query ="select * from users where user_email !='".$_SESSION['user']."'";
    $result = mysqli_query($conn,$query);
    while($row = mysqli_fetch_array($result)){
        echo "<li>
            <div class='row'>
                <div class='col-3 left-chat-bar-images'>
                    <a href='Process?action=view_profile&user_email=".$row['user_email']."'>";
                  if(!empty($row['user_profile']) || $row['user_profile'] != NULL){
                      echo"<img src='data:image;base64,".$row['user_profile']."' alt='Profile_image' height='50px' width='50px' style='border-radius:50%;'>";
                  }
                  else{
                      if($row['user_gender'] == "Male"){
                         echo"<img src='images/user_male.jpg' alt='Profile_image' height='50px' width='50px' style='border-radius:50%;'>"; 
                      }
                      else{
                         echo"<img src='images/user_female.jpg' alt='Profile_image' height='50px' width='50px' style='border-radius:50%;'>"; 
                      }
                  }  
    echo"      </a> </div>
                <div class='col-9 left-chat-bar-details'>
                    <a href='Home?email=".$row['user_email']."'>".$row['user_first_name']." ".$row['user_last_name']."</a><br>";
         if($row['user_login'] == "Online"){
            echo "<small><i class='fas fa-circle text-success'></i> Online</small>";
        }else{
            echo "<small><i class='fas fa-circle'></i> Offline</small>";
        }
    echo"       </div>
            </div>
        </li>";
    }
?>