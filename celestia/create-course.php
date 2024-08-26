<?php
session_start();

// Regenerate session ID to prevent session fixation
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

// Error reporting should be enabled for development and logged in production
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'path/to/error.log');

// Include configuration file
include('includes/config.php');

// Check if user is logged in
if (!isset($_SESSION['alogin']) || empty($_SESSION['alogin'])) {
    header("Location: index.php");
    exit();
}

// Initialize variables for messages
$msg = '';
$error = '';

// Handle form submission
if (isset($_POST['submit'])) {
    $coursename = $_POST['coursename'];
    $duration = $_POST['duration'];
    
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $filename = $file['name'];
            $filepath = 'uploads/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                $sql = "INSERT INTO tblcourses(Coursename, Duration, FileName, FilePath) 
                        VALUES (:coursename, :duration, :filename, :filepath)";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':coursename', $coursename, PDO::PARAM_STR);
                $stmt->bindParam(':duration', $duration, PDO::PARAM_STR);
                $stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
                $stmt->bindParam(':filepath', $filepath, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $msg = "Course created and file uploaded successfully.";
                } else {
                    $error = "Error storing data in database: " . $stmt->errorInfo()[2];
                }
            } else {
                $error = "Failed to move uploaded file.";
            }
        } else {
            $error = "File upload error: " . $file['error'];
        }
    } else {
        $error = "No file uploaded.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Celestia Computer Institute | Create Course</title>
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
                                <h2 class="title">Course Creation</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Courses</li>
                                    <li class="active">Create Course</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Create Course</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
<?php if($msg){ ?>
<div class="alert alert-success left-icon-alert" role="alert">
    <strong>Well done!</strong><?php echo $msg; ?>
</div>
<?php } else if($error){ ?>
<div class="alert alert-danger left-icon-alert" role="alert">
    <strong>Oh snap!</strong> <?php echo $error; ?>
</div>
<?php } ?>
                                       
										<form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Course Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="coursename" class="form-control" id="default" placeholder="Course Name" required="required">
                                                </div>
                                            </div>  
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Duration</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="duration" class="form-control" id="default" placeholder="Duration" required="required">
                                                </div>
                                            </div> 	
<div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Course File</label>
                                                <div class="col-sm-10">
                 
        <input type="file" name="file" id="file" required>
                                                </div>
                                            </div>											
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

