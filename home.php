<?php
session_start();
$email = $_SESSION['email'];
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
$sql="SELECT * FROM  user WHERE email='$email'";
 $r=mysqli_query($con,$sql);
 $data=mysqli_fetch_assoc($r);
$email=$data['email'];echo"<h2 style='text-align:center;color:black;'>Welcome:".$email."</h2>";
?>
<html>
    <body>
        <a href="logout.php">logout</a>
</body>
</html>