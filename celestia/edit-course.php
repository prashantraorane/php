<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit();
}

if (isset($_POST['Update'])) {
    $sid = intval($_GET['courseid']);
    $coursename = $_POST['coursename'];
    $duration = $_POST['duration'];
    $imagePath = '';

    // File upload handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];
        $filename = basename($file['name']);
        $filepath = "uploads/";
        $imagePath = $filepath . $filename;

        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $imagePath)) {
            // File uploaded successfully
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        // No new image uploaded, retain old image path
        $sql = "SELECT FilePath FROM tblcourses WHERE id=:sid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        $imagePath = $result->ImagePath;
    }

    // Update course details
    $sql = "UPDATE tblcourses SET CourseName=:coursename, Duration=:duration, FileName=:filename, FilePath=:imagePath WHERE id=:sid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':coursename', $coursename, PDO::PARAM_STR);
    $query->bindParam(':duration', $duration, PDO::PARAM_STR);
	$query->bindParam(':filename', $filename, PDO::PARAM_STR);
    $query->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
    $query->bindParam(':sid', $sid, PDO::PARAM_STR);
    if ($query->execute()) {
        $msg = "Course Info updated successfully";
    } else {
        $error = "Failed to update course info.";
    }
}

// Fetch existing course details
$sid = intval($_GET['courseid']);
$sql = "SELECT * FROM tblcourses WHERE id=:sid";
$query = $dbh->prepare($sql);
$query->bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Celestia Computer Institute | Update Course</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
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
                                <h2 class="title">Update Course</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Courses</li>
                                    <li class="active">Update Course</li>
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
                                            <h5>Update Course</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg): ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php elseif ($error): ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php endif; ?>

                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php foreach ($results as $result): ?>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Course Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="coursename" value="<?php echo htmlentities($result->CourseName); ?>" class="form-control" id="default" placeholder="Course Name" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Duration</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="duration" value="<?php echo htmlentities($result->Duration); ?>" class="form-control" id="default" placeholder="Duration" required="required">
                                                    </div>
                                                </div>
												<div class="form-group">
													 <label for="default" class="col-sm-2 control-label"></label>
													<div class="col-sm-10">
													<img src="<?php echo ($result->FilePath); ?>" alt="Image"width="100" height="100">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Change Image</label>
                                                    <div class="col-sm-10">
                                                        <input type="file" name="image" id="image">
                                                        <?php if ($result->ImagePath): ?>
                                                            <p>Current Image:</p> <a href="<?php echo htmlspecialchars($result->ImagePath); ?>" target="_blank"><img src="<?php echo htmlspecialchars($result->ImagePath); ?>" width="100" height="100" alt="Current Image"></a>
                                                        <?php endif; ?>
														
                                                    </div></div>
													
                                            <?php endforeach; ?>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="Update" class="btn btn-primary">Update</button>
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
