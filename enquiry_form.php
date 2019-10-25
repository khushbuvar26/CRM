<?php
require "dbconfig/config.php";
session_start();
if(empty($_SESSION["imglink"])) {
header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRM</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/userstyle.css" />
</head>
    <body>
        <div class="bar">
            <img src="images/crm%20Logo.png" class="logo" alt="" />
            <div class="box">
                <?php 
			     if($_SESSION['imglink']=="uploads/")
			     {
				    echo '<img src="images/pic.png" class="image" alt="" />';
                 }
			     else	
			     {				 
				    echo '<img src="'.$_SESSION['imglink'].'" class="image" alt="" />';
			     }
                ?> 
                <ul class="text">
                    <li><a href=""><?php echo $_SESSION['username'] ?></a>
                        <ul>
                            <li><a href="profile.php">My Profile</a></li>
                            <li><a href="enquiry_details.php">Enquiries</a></li>
                            <li><a href="change_profile_picture.php">Change Profile Picture</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="login-block">
            <form action="" method="post">
                <h1>Enquiry Form</h1>
               <textarea id = "description" placeholder="*Enter your Enquiry" name="description" rows="15" required></textarea>
		<input type="text" name="enquiry" placeholder="enter your enquiry*" />
                <input type="checkbox" name="" id="check" checked />
                <p style="color: white;">for new details uncheck the box</p>
                <input type="tel" name="contact_no." placeholder="Contact no*" />
                 <input type="text" name="address" placeholder="Address*"/>
                <input type="text" name="city" placeholder="City*" />
                <input type="text" name="state" placeholder="State*" />
                <input type="text" name="country" placeholder="Country" />   
                <input type="text" name="pincode" placeholder="Pincode*" />
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
        <?php
           if(isset($_POST['submit']))
           {
               $description= $_POST['description'];
               $code = mt_rand(100000, 999999);
               $status = 1;
              // $eng_id = 0;
               $email = $_SESSION['email'];
               $query = "select * from userinfotable where email= '$email'";
               $query_run = mysqli_query($con, $query);
               if($query_run)
               {
                   if(mysqli_num_rows($query_run)>0)
                   {
                       $rows = mysqli_fetch_array($query_run, MYSQLI_ASSOC);
                       $customer_id = $rows['customer_id'];
					   $pincode = $rows['pin_code'];
					   $query2 = "select * from engineer where pincode = '$pincode'";   
					   $run = mysqli_query($con, $query2);
					   $row = mysqli_fetch_array($run, MYSQLI_ASSOC);
					   if(mysqli_num_rows($run)>0)
					   {
						   $eng_no = mysqli_num_rows($run);
						   $i =0;
						  // $array = [];
						   while($i< $eng_no && $row = mysqli_fetch_array($run, MYSQLI_ASSOC))
						   {
							 $array[$i] = $row['engineer_id'];  
							 $i++;
						   }
						  // $eng_id = [];
						   $j = rand(0, $i-1);
					       $eng_id = mysqli_real_escape_string($con, $array[$j]);
						  //$eng_id = $array[$j];
					   }
					   
                       $query = "insert into enquiry_table(customer_id, description, code, engineer_id, status) values($customer_id, '$description','$code',$eng_id, $status)";
                       $query_run = mysqli_query($con, $query);
                       if($query_run)
                       {
                           echo '<script type="text/javascript">alert("Your Enquiry Submitted Successfully!")</script>';
                       }
                       else
                       {
                            echo '<script type="text/javascript">alert("'.mysqli_error($con).'")</script>';
                       }
                       
                   }
                   else
                   {
                        echo '<script type="text/javascript">alert("No record found!")</script>';
                   }
               }
               else
               {
                   echo '<script type="text/javascript"> alert("Error in query!")</script>';
               }
           }
        ?>
    </body>
</html>
