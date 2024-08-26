<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['submit']))
{
$rollid=$_POST['rollidh'];
$sname=$_POST['snameh'];
$smname=$_POST['smnameh'];
$gender=$_POST['genderh'];
$dob=$_POST['dobh'];
$saddress=$_POST['saddressh'];
$scontact=$_POST['scontacth'];
$semail=$_POST['semailh'];
$quali=$_POST['qualih'];
$schoolname=$_POST['schoolnameh'];
$category=$_POST['categoryh'];
$ashine=$_POST['ashineh'];
$courseid=$_POST['courseidh'];
$subjectid=$_POST['subjectidh'];
$amount=$_POST['amounth'];
$batch=$_POST['batchh'];
$time=$_POST['timeh'];
$strack=$_POST['strackh'];
$counselor=$_POST['counselorh'];
$status=1;
$sql="INSERT INTO  tblstudents(RollId, SName, SMName, Gender, DOB,SAddress,SContact,SEmail, Qualification, SchoolName,Category, AboutShine,CourseId, SubjectId, Amount, Batch, Time, StudyTrack,Counselor, Status) 
VALUES(:rollid,:sname,:smname,:gender,:dob,:saddress,:scontact,:semail,:quali,:schoolname,:category,:ashine,:courseid,:subjectid,:amount,:batch,:time,:strack,:counselor,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':rollid',$rollid,PDO::PARAM_STR);
$query->bindParam(':sname',$sname,PDO::PARAM_STR);
$query->bindParam(':smname',$smname,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':saddress',$saddress,PDO::PARAM_STR);    
$query->bindParam(':scontact',$scontact,PDO::PARAM_STR);
$query->bindParam(':semail',$semail,PDO::PARAM_STR);
$query->bindParam(':quali',$quali,PDO::PARAM_STR);
$query->bindParam(':schoolname',$schoolname,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':ashine',$ashine,PDO::PARAM_STR);
$query->bindParam(':courseid',$courseid,PDO::PARAM_STR);
$query->bindParam(':subjectid',$subjectid,PDO::PARAM_STR);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->bindParam(':batch',$batch,PDO::PARAM_STR);
$query->bindParam(':time',$time,PDO::PARAM_STR);
$query->bindParam(':strack',$strack,PDO::PARAM_STR);
$query->bindParam(':counselor',$counselor,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="   Student info added successfully";
}
else 
{
$error="   Something went wrong. Please try again";
}

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Celestia Computer Institute | Admin | Re-exam Form </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
		<link rel="icon" href="images/favicon.png" type="image/png" sizes="32x32"> 
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Re-Exam Form</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                
                                        <li class="active">Re-Exam Form</li>
                                    </ul>
                                </div>
                             <!-- /.col-md-6 -->
                            </div>
                            <!-- row breadcrumb_div -->
                        </div>
                        <!-- counteriner fluid -->
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Fill the Student info</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!  </strong> <?php echo htmlentities($error); ?>
    </div>
                                        <?php } ?>
<form class="form-horizontal" method="post">

<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Registration No</label>
        <div class="col-sm-4">
            <input type="text" name="rollidh" class="form-control" id="rollidh" value="<?php echo htmlentities($result->RollId)?>" readonly>
        </div>
    <label for="default" class="col-sm-2 control-label">Reg Date: </label>
        <div class="col-sm-4">
            <input type="text" name="" class="form-control" id="" value="<?php echo htmlentities($result->RegDate)?>" readonly>
        </div>
</div>
    
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Full Name</label>
        <div class="col-sm-4">
            <input type="text" name="snameh" class="form-control" id="snameh" required="required" autocomplete="off">
        </div>
    <label for="default" class="col-sm-2 control-label">Mother Name</label>
        <div class="col-sm-4">
            <input type="text" name="smnameh" class="form-control" id="smnameh" required="required" autocomplete="off">
        </div>
</div>
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Gender</label>
        <div class="col-sm-4">
            <input type="radio" name="genderh" value="Male" required="required" checked="">&nbsp;&nbsp;Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="genderh" value="Female" required="required">&nbsp;&nbsp;Female
        </div>
    <label for="date" class="col-sm-2 control-label">Date Of Birth</label>
        <div class="col-sm-4">
            <input type="date"  name="dobh" class="form-control" id="date">
        </div>
</div>
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Address</label>
        <div class="col-sm-10">
            <input type="text" name="saddressh" class="form-control" id="saddressh"  required="required" autocomplete="off">
        </div>
</div>
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Contact</label>
        <div class="col-sm-4">
            <input type="text" name="scontacth" class="form-control" id="scontacth" maxlength="10" required="required" autocomplete="off">
        </div>
    <label for="default" class="col-sm-2 control-label">Email id</label>
<div class="col-sm-4">
<input type="email" name="semailh" class="form-control" id="email" required="required" autocomplete="off">
</div>
</div>
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Qualification</label>
        <div class="col-sm-4">
            <input type="text" name="qualih" class="form-control" id="qualih" required="required" autocomplete="off">
        </div>
    <label for="default" class="col-sm-2 control-label">Category</label>
        <div class="col-sm-4">
<select name="categoryh" class="form-control" id="default" required="required">
<option value="">Select Category</option>
<option value="School Student">School Student</option>
<option value="College Student">College Student</option>
<option value="P.G Student">P.G Student</option>
<option value="Govt. Employee">Govt. Employee</option>
<option value="Housewife">Housewife</option>
<option value="Other">Other</option>
</select>
        </div>
    </div>
<div class="form-group">
     <label for="default" class="col-sm-2 control-label">School/College </label>
        <div class="col-sm-10">
            <input type="text" name="schoolnameh" class="form-control" id="schoolnameh"  required="required" autocomplete="off">
        </div>
</div>
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">I come to know about SHINE Computer</label>
        <div class="col-sm-10">
            <select name="ashineh" class="form-control" id="default" required="required">
<option value="">Select Option</option>
<option value="Handbills">Handbills</option>
<option value="Banners">Banners</option>
<option value="Friend/Ex Student">Friend/Ex Student</option>
<option value="Wall Advertising">Wall Advertising</option>
<option value="Cable Ads">Cable Ads</option>
<option value="Other">Other</option>
</select>
        </div>
</div>
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Course Name</label>
        <div class="col-sm-2">
            <select name="courseidh" class="form-control" id="default" required="required">
                <option value="">Select Course</option>
<?php $sql = "SELECT * from tblcourses";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->CourseName); ?></option>
<?php }} ?>
            </select>
</div>
<label for="default" class="col-sm-2 control-label">Subject Name</label>
        <div class="col-sm-2">
            <select name="subjectidh" class="form-control" id="default" required="required">
                <option value="">Select Subject</option>
<?php $sql = "SELECT * from tblsubjects";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->SubjectName); ?></option>
<?php }} ?>
            </select>
    </div>
<label for="default" class="col-sm-2 control-label">Amount</label>
        <div class="col-sm-2">
            <select name="amounth" class="form-control" id="default" required="required">
                <option value="">Select Amount</option>
<?php $sql = "SELECT * from tblsubjects";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->Amount); ?></option>
<?php }} ?>
            </select>
    </div>
</div>
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Batch</label>
        <div class="col-sm-4">
            <input type="radio" name="batchh" value="MWF" required="required" checked="">&nbsp;&nbsp;MWF &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="batchh" value="TTS" required="required">&nbsp;&nbsp;TTS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    <label for="default" class="col-sm-2 control-label">Time</label>
        <div class="col-sm-4">
            <select name="timeh" class="form-control" id="default" required="required">
<option value="">Select Time</option>
<option value="08:00 AM To 09:00 AM">08:00 AM To 09:00 AM</option>
<option value="09:00 AM To 10:00 AM">09:00 AM To 10:00 AM</option>
<option value="10:00 AM To 11:00 AM">10:00 AM To 11:00 AM</option>
<option value="11:00 AM To 12:00 AM">11:00 AM To 12:00 AM</option>
<option value="12:00 PM To 01:00 PM">12:00 PM To 01:00 PM</option>
<option value="01:00 PM To 02:00 PM">01:00 PM To 02:00 PM</option>
<option value="02:00 PM To 03:00 PM">02:00 PM To 03:00 PM</option>
<option value="03:00 PM To 04:00 PM">03:00 PM To 04:00 PM</option>
<option value="04:00 PM To 05:00 PM">04:00 PM To 05:00 PM</option>
<option value="05:00 PM To 06:00 PM">05:00 PM To 06:00 PM</option>
<option value="06:00 PM To 07:00 PM">06:00 PM To 07:00 PM</option>
<option value="07:00 PM To 08:00 PM">07:00 PM To 08:00 PM</option>
<option value="08:00 PM To 09:00 PM">08:00 PM To 09:00 PM</option>

            
            </select>
        </div>
</div>

<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Study Track</label>
        <div class="col-sm-4">
            <input type="radio" name="strackh" value="Normal" required="required" checked="">&nbsp;&nbsp;Normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="strackh" value="Fast" required="required">&nbsp;&nbsp;Fast&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
     <label for="default" class="col-sm-2 control-label">Counselor</label>
        <div class="col-sm-4">
            <input type="text" name="counselorh" class="form-control" id="counselorh" maxlength="25" required="required" autocomplete="off">
        </div>
</div>
<div class="form-group">
     <div class="col-sm-offset-2 col-sm-8">
         <button type="reset"  class="btn btn-warning">Reset</button>
         <div class="col-sm-offset-2 col-sm-8">
                     <button type="submit" name="submit" class="btn btn-primary">Register</button>
    </div></div>
</div>
    </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                            <!-- row -->
                    </div>
                        <!-- counter flouid -->
                </div>
                    <!-- main-page -->
                 </div>   
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    </body>
</html>
<?PHP } ?>
