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
$courseid=$_POST['courseidh'];
$amount=$_POST['amounth'];
$advance=$_POST['advance'];


$sql="INSERT INTO  tblfees(FRollId,FName,FCourseId,FAmount,FBalance) VALUES
(:rollid,:sname,:courseid,:amount,:advance)";
$query = $dbh->prepare($sql);
$query->bindParam(':rollid',$rollid,PDO::PARAM_STR);
$query->bindParam(':sname',$sname,PDO::PARAM_STR);
$query->bindParam(':courseid',$courseid,PDO::PARAM_STR);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->bindParam(':balance',$amount-$advance,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Fee update successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Celestia Computer Institute | Fee Mangement</title>
		<script type="text/javascript">
function sum() {
            var txtFirstNumberValue = document.getElementById('amount').value;
            var txtSecondNumberValue = document.getElementById('advance').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('balance').value = result;
            }
        }
		
		
	</script>
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
                                    <h2 class="title">Fee Management</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Fees</li>
                                        <li class="active">Fees Managemt</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Add Fee</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
       <form class="form-horizontal" method="post">
	   
	
<?php 
$sql = "SELECT tblstudents.RollId,tblstudents.SName, tblstudents.SContact, tblstudents.Amount, tblstudents.RegDate, tblstudents.SId, tblcourses.CourseName 
FROM tblstudents 
INNER JOIN tblcourses ON tblcourses.id=tblstudents.CourseId 
WHERE
tblstudents.SId=:stid";        
        
$query = $dbh->prepare($sql);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>


                                                  
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
            <input type="text" name="snameh" class="form-control" id="snameh" value="<?php echo htmlentities($result->SName)?>" required="required" autocomplete="off">
        </div>
		 <label for="default" class="col-sm-2 control-label">Contact</label>
        <div class="col-sm-4">
            <input type="text" name="scontacth" class="form-control" id="scontacth" value="<?php echo htmlentities($result->SContact)?>" maxlength="10" required="required" autocomplete="off">
        </div>
</div>   


   
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Course Name</label>
    <div class="col-sm-2">
		<input type="text" name="courseidh" class="form-control" id="courseidh" value="<?php echo htmlentities($result->CourseName)?>" readonly>
    </div>
	<label for="default" class="col-sm-2 control-label">Amount </label>
        <div class="col-sm-2">
            <input type="text" name="amounth" class="form-control" id="amount" onkeyup="sum();" value="<?php echo htmlentities($result->Amount)?>">
        </div>
     
</div>
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Advance Fee </label>
        <div class="col-sm-2">

            <input type="text" name="advancefeeh" class="form-control" id="advance" onkeyup="sum();" required="required" autocomplete="off">
        </div>
<label for="default" class="col-sm-2 control-label">Balance Fee </label>
        <div class="col-sm-2">
            <input type="text" name="Balancefeeh" class="form-control" id="balance" required="required" autocomplete="off" readonly>
        </div>
		
<label for="default" class="col-sm-2 control-label">Fee Remark </label>
        <div class="col-sm-2">
            <input type="text" name="feeremarkh" class="form-control" id="feeremarkh" required="required" autocomplete="off">
        </div>
		
		
		
 </div>    
	<?PHP }} ?> 
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
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