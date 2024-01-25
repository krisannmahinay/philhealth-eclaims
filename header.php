<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"><!-- savr 2015-11-11 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="viewport" content="width=device-width, initial-scale=1"><!-- savr 2015-11-11 -->
<title>CF4Generator</title>

<link href="res/ico/favicon.png" rel="shortcut icon" type="image/x-icon" />
<link href="res/css/normalize.css" rel="stylesheet" type="text/css" />
<link href="res/css/omis.css" rel="stylesheet" type="text/css" />
<link href="res/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="res/css/styles.css" rel="stylesheet" type="text/css" />
<link href="res/css/jquery-ui-1.11.4.css" rel="stylesheet"><!--added by marv 01302018-->

<link href="res/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="res/js/jquery.js"></script>
<script type="text/javascript" src="res/js/jquery.min.js"></script>
<script type="text/javascript" src="res/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="res/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="res/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="res/js/scripts.js"></script>

<script type="text/javascript" src="res/datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="res/datatable/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="res/datatable/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="res/datatable/buttons.flash.min.js"></script>
<script type="text/javascript" src="res/datatable/jszip.min.js"></script>
<script type="text/javascript" src="res/datatable/pdfmake.min.js"></script>
<script type="text/javascript" src="res/datatable/vfs_fonts.js"></script>
<script type="text/javascript" src="res/datatable/buttons.html5.min.js"></script>
<script type="text/javascript" src="res/datatable/buttons.print.min.js"></script>
<script type="text/javascript" src="res/datatable/buttons.colVis.min.js"></script>
<script type="text/javascript" src="res/js/jquery.maskedinput-1.3.min.js"></script>

</head>
<script type="text/javascript">
    $(window).load(function() {
        $("#wait_image").fadeOut("slow");
    });
</script>
<?php
    include('function.php');
    include('function_global.php');
    connDB();
    session_start();
    $pUserId = $_SESSION['pUserID'];
    $pHospName = $_SESSION['pHospName'];
    $pHciNo = $_SESSION['pHciNum'];
    $pAccreNo = $_SESSION['pAccreNum'];
    $pPmccNo = $_SESSION['pPmccNum'];
    $pEmrId = $_SESSION['pEmrId'];
?>

<body>

    <div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
                    <p class="systtl" style="">CF4 Generator</p>
				<a class="brand" href="index.php"><img src="res/img/ph_logo.png" alt="PhilHealth Logo"></a>
			</div>
		</div>
	</div>

    <div class="container">
        <br/>
        <?php if ($page != 'login') { ?>
<!--        <div class="row" style="margin-bottom: 5px;">-->
<!--            <div class="col-sm-8 col-xs-8">-->
<!--                <!--<h1>SYSTEM HEADER LOGO</h1>-->
<!--                <img src="res/images/epcb_bnnr.png" style="margin-top: 20px;" alt="">-->
<!--            </div>-->
<!--            <div class="col-sm-4 col-xs-4" align="center" style="margin-top:40px;">-->
<!--                Logged in as:-->
<!--                <div style="font-size:17px;color:green;text-align:center;text-transform: uppercase;font-weight:bold;">-->
<!--                   --><?php //echo $pUserId; ?>
<!--                </div>-->
<!--                <div style="font-size:13px;color:green;text-align:center;text-transform: uppercase;">--><?php //echo $pHospName; ?><!--</div>-->
<!--            </div>-->
<!--        </div>-->
        <?php } ?>