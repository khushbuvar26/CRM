<?php
session_start();
//if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
  //  echo "No session";
   // header('location')
//}
	
require 'dbconfig/config.php';
?>

<!doctype html>
<html>
    <head>
        <title> CRM </title>
         <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <style>
            body{
                background-attachment: fixed;
             /*   background-position: center;*/
                background-repeat: no-repeat;
                background-size: cover;
            }
            .logo{
                position: fixed;
                top: 0px;
                right: 0px;
                left: 0px;
                z-index: 2000;
                margin-top: 30px;
            }
            #mein{
                position: fixed;
                top: 0px;
                right: 0px;
                left: 0px;
                z-index: 2000;
                margin-top: 30px;
            }
			.fa {
	            position: absolute;
				right: 520px;
				font-size: 20px;
				top: 295px;
				cursor: pointer;
				/*bottom: 300px;*/
				color: #999;
				}
			.fa.active{
				color: dodgerblue;
			}
        </style>
    </head>
    <body>
       
        <header id="header" class="alt">
            <div class="logo">
                    <a href="index.html">
                        <img src="images/crm%20Logo.png" />
                    </a>
            </div>
				<a href="#menu">Menu</a>
			</header>
        <!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About us</a></li>
					<li><a href="signup.php">Sign Up</a></li>
					<li><a href="login.php">Login</a></li>
                    <li><a href="contact.php">Contact us</a></li>
                    <li><a href="offers.php">Offers</a></li>
                    <li><a href="faq.php">FAQs</a></li>
                   
				</ul>
			</nav> 
        <div class="login-block">
            <form action="" method="post">
                <h1>login</h1>
                <input type="email" name="email" placeholder="email" autofocus required>
				 <i class="fa fa-eye" id="eye"></i>
                <input type="password" name="password" placeholder="password" id="pwd" required>
				
                <img src="image.php" style="float: left; border-radius: 5px;">
	
					
                <input type="text" name="captcha" placeholder="Enter Captcha Code*" style="float: left; width: 202px; !important; margin-left: 5px;" required>
                <a href="forgotpassword.php" class="link float">forgot password?</a>
                <button type="submit" name="submit_btn">Login</button>
				<script type="text/javascript"> 
				    var pwd = document.getElementById('pwd');
			        var eye = document.getElementById('eye');
					 eye.addEventListener('click', togglePass);
					 function togglePass() {
				       eye.classList.toggle('active');
					   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type ='password';
			        }
				</script>
                <a href="signup.php" class="link">New user register here</a>
            </form>
        </div>
        <?php
			if(isset($_POST['submit_btn']))
			{
				$email = $_POST['email'] ;
				$password = $_POST['password'] ;
                $captcha = $_SESSION['captcha'];
				$query = "select * from userinfotable WHERE email='$email' AND password='$password'" ;
				$query_run = mysqli_query($con,$query);
				if($query_run)
				{
					if(mysqli_num_rows($query_run)>0 && $captcha == $_POST['captcha'])
					{
						$rows = mysqli_fetch_array($query_run,MYSQLI_ASSOC);
						$_SESSION['username'] = $rows['username'];
						$_SESSION['email'] = $rows['email'];
						$_SESSION['imglink'] = $rows['imglink'];
						header('location:profile.php');
					}
					else if(mysqli_num_rows($query_run)==0)
					{
						echo '<script type="text/javascript"> alert("invalid credentials") </script>' ;
					}
                    else
                    {
                        echo '<script type="text/javascript"> alert("Captcha code not matched!")</script>';
                    }
				}
				else
				{
					echo '<script type="text/javascript"> alert("Error in query")</script>';
				}
			}
		?>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/skel.min.js"></script> 
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>
        
    </body>
</html>