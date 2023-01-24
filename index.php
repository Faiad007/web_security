

<html>

    
   
    
<style>

.center {
text-align: center;
color: red;
}
*{margin: 0; padding: 0;}
    body{background: #ecf1f4; font-family: sans-serif;}
    
    .form-wrap{ width: 320px; background: #3e3d3d; padding: 40px 20px; box-sizing: border-box; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%);}
    h1{text-align: center; color: #fff; font-weight: normal; margin-bottom: 20px;}
    
    input{width: 100%; background: none; border: 1px solid #fff; border-radius: 3px; padding: 6px 15px; box-sizing: border-box; margin-bottom: 20px; font-size: 16px; color: #fff;}
    
    input[type="button"]{ background: #bac675; border: 0; cursor: pointer; color: #3e3d3d;}
    input[type="button"]:hover{ background: #a4b15c; transition: .6s;}
    
    ::placeholder{color: #fff;}

</style>

<body>

    <div class="form-wrap">
    
        <form action="" method="POST">
        
            <h1>login</h1>

            <input type="email" placeholder=email  name="email">

           <input type="password" placeholder=password  name="password">



<input type="submit" placeholder=submit value="login">

        
        </form>
    
    </div>



</body>



</html>


<?php
 use PHPMailer\PHPMailer\PHPMailer;
session_start();
$hostname='localhost';
$username='root';
$password='';
$dbname='block';
$con=mysqli_connect($hostname,$username,$password,$dbname);
if($con)
{
	echo"";
}
else
{
	echo"conn false";
} 

$datetime = date("H:i:s");

// Convert datetime to Unix timestamp
$timestamp = strtotime($datetime);

// Subtract time from datetime
$time = $timestamp - (3 * 60);

// Date and time after subtraction
$datetime = date("H:i:s", $time);
//echo"$datetime";


if (isset($_POST) and !empty($_POST)){
    $email = $_POST['email'];
    $email=mysqli_real_escape_string($con,$email);
$sql="SELECT * FROM  user WHERE email='$email'";
$password = $_POST['password'];
$password=mysqli_real_escape_string($con,$password);
    $r=mysqli_query($con,$sql);
    $data=mysqli_fetch_assoc($r);
    $e=$data['error'];
    $t=$data['p_time'];
    $tp=strtotime($t);
    if($e > 1){
    ?>
<script>location.assign('block.php')</script>
<?php
    }

 
  $q = "SELECT * FROM `user` WHERE email='$email' and password='$password'";
  $r = mysqli_query($con, $q) or die(mysqli_error($con));
  $count = mysqli_num_rows($r);
  
  if ($count == 1){
    $_SESSION['email']=$email;

$otp=rand(11111,99999);
$r="update user set otp='$otp' where email='$email'";
$re = mysqli_query($con, $r);
if($re)
echo"true";

else 
echo"fff";
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

$mail = new PHPMailer();

//SMTP Settings
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "fchowdhury192066@bscse.uiu.ac.bd"; //enter you email address
$mail->Password = '123faiad@uiu'; //enter you email password
$mail->Port = 465;
$mail->SMTPSecure = "ssl";

//Email Settings
$mail->isHTML(true);
$mail->setFrom($email);
$mail->addAddress($email); //enter you email address
$mail->Subject = ("$email");
$mail->Body = 'your otp number : '.$otp;
$mail->send();
?>
<script>location.assign('otp.php')</script>
<?php
}else{
  $time = date("H:i:s");
  $tn=strtotime($time);
  $sql="UPDATE user set p_time='$time' WHERE email='$email'";
  $r=mysqli_query($con,$sql);
  $c=$tn-$tp;
  echo"$c";
  if($c < 300){
  $e=$data['error']+1;
  $sql="UPDATE user set error='$e' WHERE email='$email'";
  $r=mysqli_query($con,$sql);
  }

echo"<h1 style='color: white; background-color: red';>Please enter correct passwordr </h1>";
  }
}
?>