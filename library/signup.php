<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
{
// code for captcha verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    } 
else {    
// Code for student ID
$count_my_page = ("studentid.txt");
$hits = file($count_my_page);
$hits[0] ++;
$fp = fopen($count_my_page , "w");
fputs($fp , "$hits[0]");
fclose($fp); 
$StudentId= $hits[0];   
$fname=$_POST['fullanme'];
$mobileno=$_POST['mobileno'];
$email=$_POST['email']; 
$password=md5($_POST['password']); 
$role=$_POST['role']; // ✅ new role field
$status=1;

$sql="INSERT INTO  tblstudents(StudentId,FullName,MobileNumber,EmailId,Password,Role,Status) 
VALUES(:StudentId,:fname,:mobileno,:email,:password,:role,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':StudentId',$StudentId,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':role',$role,PDO::PARAM_STR); // ✅ bind role
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo '<script>alert("Your Registration successful and your student id is '.$StudentId.'")</script>';
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}
}
?>
