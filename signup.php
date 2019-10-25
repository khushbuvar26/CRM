<?php
session_start();
require 'dbconfig/config.php';
$_SESSION['username'] ="";
$_SESSION['email'] = "";
$_SESSION['phone_no'] = "";
$_SESSION['address'] = "";
$_SESSION['city'] = "";
$_SESSION['state']= "";
$_SESSION['country'] = "";
$_SESSION['code'] = "";
$_SESSION['password']= "";
$_SESSION['cpassword']="";
?>
<!DOCTYPE html>
<html>
    <head> 
        <title> CRM </title>
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
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
				right: 510px;
				font-size: 20px;
				top: 870px;
				cursor: pointer;
				/*bottom: 300px;*/
				color: #999;
				}
			.fa.active{
				color: dodgerblue;
			}
        </style>
		
        <script type="text/javascript">
            function PreviewImage() {
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("imglink").files[0]);
                
                oFReader.onload = function(oFREvent) {
                    document.getElementById("uploadPreview").src = oFREvent.target.result;
                };
            };
				
        </script>
    <!--    <script type="text/javascript">
			function phone() {
				if(document.myform.phone_no.value.length > 10)
					{
						alert("Enter Valid Contact no");
						return false;
					}
				if(document.myform.code.value.length>6)
					{
						alert("Enter Valid Pincode");
						return false;
					}
				return true;
			}
		</script>-->
    </head>  
    <body>
       
        <header id="header" class="alt">
				<div class="logo"><a href="index.html">
                    <img src="images/crm%20Logo.png" />
                    </a></div>
				<a href="#menu" id="mein">Menu</a>
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
        <?php
			if(isset($_POST['submit_btn']))
			{
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['email'] = $_POST['email'];	
                $_SESSION['address']= $_POST['address'];
				$_SESSION['city']= $_POST['city'];
                $_SESSION['state']= $_POST['state'];
				$_SESSION['country']= $_POST['country'];
				$_SESSION['password'] = $_POST['password'];
				$_SESSION['cpassword'] = $_POST ['con_password'];
                $captcha = $_SESSION['captcha'];
                $regx = '/[0-9]{10}/';
				//$regx = '/^\d{10}$/';
                if(preg_match($regx,$_POST['phone_no']))
                {
                    $_SESSION['phone_no']=$_POST['phone_no'];
                }
                else
                {
                    $phone_no= "";
                }
                $regx2 = '/[0-9]{6}/';
				//$regx2 = '/^\d{6}$/';
                if(preg_match($regx2,$_POST['code']))
                {
                    $_SESSION['code']=$_POST['code'];
                }
                else
                {
                    $code= "";
                }
				

				$img_name = $_FILES['imglink']['name'];
				$img_size = $_FILES['imglink']['size'];
				$_SESSION['img_tmp'] = $_FILES['imglink']['tmp_name'];
				$directory = 'uploads/';
				$email2 = $_SESSION['email'];
				$_SESSION['target_file'] = $directory.$img_name;
				if($_SESSION['password']==$_SESSION['cpassword'] && $_SESSION['phone_no']!= "" && $_SESSION['code']!= "" && $captcha == $_POST['captcha'])
				{
					$query = "select * from userinfotable WHERE email= '$email2'" ;
					$query_run = mysqli_query($con,$query);
					if($query_run)
					{	
						if(mysqli_num_rows($query_run)>0)
						{
							echo '<script type="text/javascript"> alert("Email already exist..try another email") </script>' ;
						}
						else if ($img_size>2097152)
						{
							echo '<script type="text/javascript"> alert("Image file size larger than 2MB... Try another image file")</script>';
						}
						else
						{
									$_SESSION['otp'] = mt_rand(10000, 99999);
									$to = $_SESSION['email'];
    					            $subject = 'localhost subject';
						            $message = 'Your OTP is:  '.$_SESSION['otp'];
						            $headers = 'From: onlyfortest17@gmail.com';
									 if(mail($to, $subject, $message, $headers))
									 {
										header('location: otp.php');
									 }
							
						}
					}
				}
				else
				{
					if($_SESSION['phone_no']=="" && $_SESSION['code']=="")
					{
						echo '<script type="text/javascript"> alert("Enter valid contact number and valid pincode")</script>';
					}
					else if($_SESSION['phone_no']=="")
					{
						echo '<script type="text/javascript"> alert("Enter valid contact number")</script>';
					}
					else if($_SESSION['code']=="")
					{
						echo '<script type="text/javascript"> alert("Enter valid pincode")</script>';
					}
				
					else if($_SESSION['password']!= $_SESSION['cpassword'])
					{
						echo '<script type="text/javascript"> alert("Password and confirm password does not match") </script>';
					}
                    else
                    {
                        echo '<script type="text/javascript"> alert("Captcha code not matched!")</script>';
                    }
				}
			}
		?>
        
        
        <div class="login-block">
            <form action="<?php echo ($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" name="myform">
               <h1>Registration Form</h1> 
                <center><img id="uploadPreview" src="images/user.png" class="avatar" /></center><br />
                <input type="file" id="imglink" name="imglink" accept=".jpg, .jpeg, .png" onchange="PreviewImage();">
                <!--<label style="color: white; font-size: 20px; font-weight: bold;">Name:</label>-->
                <input type ="text" name="username" placeholder="Name*" value="<?php echo $_SESSION['username'];?>" autofocus required>
                <input type="email" name="email" placeholder="email*" value="<?php echo $_SESSION['email'];?>" required>
                <input type="tel" name="phone_no" placeholder="Contact Number*" maxlength = 10 value="<?php echo $_SESSION['phone_no'];?>" required />
				
                <input type="text" name="address" placeholder="Address*" value="<?php echo $_SESSION['address'];?>" required />
               
                <input type="text" name="state" placeholder="State*" value="<?php  echo $_SESSION['state'];?>" required />
		
				 <input type="text" name="city" placeholder="City*" value="<?php echo $_SESSION['city'];?>" required />
          <input type="text" name="country" placeholder="Country*" value="<?php echo $_SESSION['country'];?>" required />
            
                <input type="text" name="code" placeholder="Pincode*" maxlength = 6 value="<?php echo $_SESSION['code'];?>" required />
			    <i class="fa fa-eye" id="eye"></i>
                <input type="password" name="password" placeholder="Password*" value="<?php echo $_SESSION['password'];?>" id="pwd" required>
				 <i class="fa fa-eye" id="eye2" style="top: 925px;"></i>
                <input type="password" name="con_password" placeholder="confirm Password*" value="<?php echo $_SESSION['cpassword'];?>" id = "pwd2" required>
                <img src="image.php" style="float: left; border-radius: 5px;">
                <input type="text" name="captcha" placeholder="Enter Captcha Code*" style="float: left; width: 202px; !important; margin-left: 5px;" required>
                <button name="submit_btn" type="submit" style="margin-top: 10px;">Signup</button>
				<script type="text/javascript">
					var pwd = document.getElementById('pwd');
					var pwd2 = document.getElementById('pwd2');
			        var eye = document.getElementById('eye');
					var eye2 = document.getElementById('eye2');
			        eye.addEventListener('click', togglePass);
					 eye2.addEventListener('click', togglePass2);
			        function togglePass() {
				       eye.classList.toggle('active');
					   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type ='password';
			        }
					function togglePass2() {
						eye2.classList.toggle('active');
						(pwd2.type == 'password') ? pwd2.type = 'text' : pwd2.type ='password';
					}
				</script>
                <a href="login.php" class="link">If you are already a user</a>
            </form>
            
        </div>
		
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script> 
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
    </body>
</html>