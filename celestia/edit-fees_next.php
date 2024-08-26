<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

$stid=intval($_GET['stid']);


if(isset($_POST['submit']))
{
$rollid=$_POST['rollidh'];
$sname=$_POST['snameh'];
$courseid=$_POST['courseidh'];
$amount=$_POST['amount'];
$advance=$_POST['advance'];
$balance=$_POST['balance'];
$remark=$_POST['remark'];
$sql="update  tblfees set FRollId=:rollid, FName=:sname, FCourseId=:courseid, FAmount=:amount, FBalance=:balance where Fid=:stid";
$query = $dbh->prepare($sql);
$query->bindParam(':rollid',$rollid,PDO::PARAM_STR);
$query->bindParam(':sname',$sname,PDO::PARAM_STR);
$query->bindParam(':courseid',$courseid,PDO::PARAM_STR);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->bindParam(':balance',$balance,PDO::PARAM_STR);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->execute();


$sql="INSERT INTO fees_trans(FRollId,paid,transcation_remark)VALUES(:rollid,:advance,:remark)";

$query1 = $dbh->prepare($sql);
$query1->bindParam(':rollid',$rollid,PDO::PARAM_STR);
$query1->bindParam(':advance',$advance,PDO::PARAM_STR);
$query1->bindParam(':remark',$remark,PDO::PARAM_STR);
$query1->execute();
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
        <title>Celestia Computer Institute | Edit Fee's  </title>
		<script type="text/javascript">
function sum() {
            var txtFirstNumberValue = document.getElementById('amoun').value;
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
                                    <h2 class="title">Update Fees</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li>Students</li>
                                        <li class="active">Update Fees</li>
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
                                                    <h5>Edit Fees info</h5>
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
$sql = "SELECT tblfees.FRollId,tblfees.FName, tblfees.FCourseId, tblfees.FAmount, tblfees.UpdationDate, tblfees.FBalance, tblfees.FId 
FROM tblfees
WHERE
tblfees.FId=:stid";  
   
        
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
            <input type="text" name="rollidh" class="form-control" id="rollidh" value="<?php echo htmlentities($result->FRollId)?>" readonly>
        </div>
    <label for="default" class="col-sm-2 control-label">Reg Date: </label>
        <div class="col-sm-4">
            <input type="text" name="" class="form-control" id="" value="<?php echo htmlentities($result->UpdationDate)?>" readonly>
        </div>
</div>
<div class="form-group">
    <label for="default" class="col-sm-2 control-label">Full Name</label>
        <div class="col-sm-4">
            <input type="text" name="snameh" class="form-control" id="snameh" value="<?php echo htmlentities($result->FName)?>" required="required" autocomplete="off">
        </div>
		 <label for="default" class="col-sm-2 control-label">Contact</label>
        <div class="col-sm-4">
            <input type="text" name="scontacth" class="form-control" id="scontacth" readonly>
        </div>
</div>   
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Course Name</label>
    <div class="col-sm-4">
		<input type="text" name="courseidh" class="form-control" id="courseidh" value="<?php echo htmlentities($result->FCourseId)?>" readonly>
    </div>

	<label for="default" class="col-sm-2 control-label">Amount </label>
        <div class="col-sm-4">
            <input type="text" name="amount" class="form-control" id="amount" value="<?php echo htmlentities($result->FAmount)?>">
        </div>
     
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Remaning Fee </label>
        <div class="col-sm-2">
            <input type="text" name="amoun" class="form-control" id="amoun" onkeyup="sum();" value="<?php echo htmlentities($result->FBalance)?>">
        </div>
		
<label for="default" class="col-sm-2 control-label">Advance Fee </label>
        <div class="col-sm-2">

            <input type="text" name="advance" class="form-control" id="advance" onkeyup="sum();"  required="required" autocomplete="off">
        </div>
<label for="default" class="col-sm-2 control-label">Balance Fee </label>
        <div class="col-sm-2">
            <input type="text" name="balance" class="form-control" id="balance"  required="required" autocomplete="off" readonly>
        </div>
		
<label for="default" class="col-sm-2 control-label">Fee Remark </label>
        <div class="col-sm-2">
            <input type="text" name="remark" class="form-control" id="remark" required="required" autocomplete="off">
        </div>
		
		
		
 </div>
     
     
     
     <?php }?>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" name="submit" class="btn btn-primary">Add</button>
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
            <!-- /.main-page -->
            </div>
                <!-- /.content-container -->
        </div> </div>
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
	<?PHP }} ?>
