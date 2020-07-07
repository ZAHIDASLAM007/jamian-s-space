<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
include('connection.php');

$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users1 WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQL_ASSOC); 
    $username = $row['username'];
    $email = $row['email']; 
}else{
    echo "There was an error retrieving the username and email from the database";   
}
?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css" rel="stylesheet">
    <style>
        #container{
            margin-top: 100px;
        }  
        #allNotes,#done,#notePad{
            display: none;
        }
        .buttons{
            margin-bottom: 20px;
        }
        textarea{
            width: 100%;
            max-width: 100%;
            font-size: 16px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #CA3DD9;
            color: #CA3DD9;
            background-color: #FBEFFF;
            padding: 10px;
        }
      
        tr{
            cursor: pointer;
        }
    </style>

     </head>
  <body>
<!--Navigation Bar -->
      
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top" >
          <div class="container-fluid">
              <div class="navbar-header">
                <a class="navbar-brand">Jamian's Space</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                    <span class="sr-only">Toggle Navigations</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
              </div>
              <div class="navbar-collapse collapse" id="navbarCollapse">
                     <ul class="nav navbar-nav">
                       <li ><a href="#">Profile</a></li>
                       <li><a href="#">Help</a></li>
                       <li><a href="#">Contact us</a></li>
                       <li class="active"><a href="mainpageloggedin.php">My Notes</a></li>
                         
                     </ul>
                     <ul class="nav navbar-nav navbar-right">
                       <li><a href="#"> Logged in as <b><?php echo $_SESSION['username'] ?></b></a></li>
                       <li><a href="index.php?logout=1"> Log out</a></li>
                         
                     </ul>
              
              
              </div>

          </div>

      
      </nav>
           <!--     container      -->
             <div class="container" id="container">
                 <div class="row">
                     <div class="col-mid-offset-3 col-mid-6">
                           <h2>General Account Settings:</h2>
                             <div class="table-responsive">
                              <table class="table table-hover table-condensed table-bordered">
                                  <tr data-target="#updateusername" data-toggle="modal">
                                      <td>Username</td>
                                      <td><?php echo $_SESSION['username']?></td>
                                  </tr>
                                  <tr data-target="#updateemail" data-toggle="modal">
                                      <td>Email</td>
                                      <td><?php echo $_SESSION['email']?></td>
                                  </tr>
                                  <tr data-target="#updatepassword" data-toggle="modal">
                                      <td>Password</td>
                                      <td>hidden</td>
                                  </tr>
                                 
                              </table>
                             </div>
                           
                     </div>
                 
                 </div>
      
      
             </div>
      
            <!--Update username form-->
      <form method="post" id="updateusernameform">
     <div class="modal" id="updateusername" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
                &times;
              </button>
              <h4 id="myModalLabel">
              Edit Username:
              </h4>
          </div>
          <div class="modal-body">
           <!-- Login message from php file -->
           <div id="loginmessage">
              
              
           </div>
              
           <div class="form-group">
           <label for="loginemail">Username:</label>
           <input class="form-control" type="text" name="username" maxlength="30" id="username" value="username value">
            </div>
              
           
          </div>
          <div class="modal-footer">
            <input class="btn green" name="updateusername" type="submit" value="Submit">
              
            <button type="button" class="btn btn-default" data-dismiss="modal">
              Cancel
            </button>
          </div>
      </div>
  </div>
        </div> 
      
    </form>
      
<!--      Update email-->
      <form method="post" id="updateemailform">
     <div class="modal" id="updateemail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
                &times;
              </button>
              <h4 id="myModalLabel">
              Enter new email:
              </h4>
          </div>
          <div class="modal-body">
           <!-- Login message from php file -->
           <div id="loginmessage">
              
              
           </div>
              
           <div class="form-group">
           <label for="loginemail">Email:</label>
           <input class="form-control" type="email" name="email" maxlength="50" id="email" value="email value">
            </div>
              
           
          </div>
          <div class="modal-footer">
            <input class="btn green" name="updateusername" type="submit" value="Submit">
              
            <button type="button" class="btn btn-default" data-dismiss="modal">
              Cancel
            </button>
          </div>
      </div>
  </div>
        </div> 
      
    </form>

<!--      Update password-->
      <form method="post" id="updatepasswordform">
     <div class="modal" id="updatepassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
                &times;
              </button>
              <h4 id="myModalLabel">
              Enter Current and New Password:
              </h4>
          </div>
          <div class="modal-body">
           <!-- Login message from php file -->
           <div id="loginmessage">
              
              
           </div>
              
           <div class="form-group">
           <label for="currentpassword" class="sr-only">Your current Password:</label>
           <input class="form-control" type="password" name="currentpassword" maxlength="30" id="currentpassword" placeholder="Your current Password">
            </div>
           <div class="form-group">
           <label for="password" class="sr-only">Choose a Password:</label>
           <input class="form-control" type="password" name="password" maxlength="30" id="password" placeholder="Choose a password">
            </div>
           <div class="form-group">
           <label for="password2" class="sr-only">Confirm Password:</label>
           <input class="form-control" type="password" name="password2" maxlength="30" id="password2" placeholder="Confirm password">
            </div>
              
           
          </div>
          <div class="modal-footer">
            <input class="btn green" name="updateusername" type="submit" value="Submit">
              
            <button type="button" class="btn btn-default" data-dismiss="modal">
              Cancel
            </button>
          </div>
      </div>
  </div>
        </div> 
      
    </form>

      

      

      
      
<!--Footer-->
      <div class="footer">
         <div class="container">
           <p>Jamian'sSpace.com  Copyright&copy; <?php $today = date("Y"); echo $today  ?>.</p>
         </div>
      
      
      </div>
      
      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="profile.js"></script>
  </body>
</html>
