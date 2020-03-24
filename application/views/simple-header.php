<?php 
$vendor_dir = get_cfg_var('libs_resoure_url');
if ($vendor_dir === false) $vendor_dir = 'assets/vendor/';
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="<?php echo base_url(); ?>">

    <title><?php echo $title; ?></title>


    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- vendor -->
    <!-- fontawesome -->
    <link href="<?php echo $vendor_dir; ?>fontawesome/css/all.min.css" rel="stylesheet">
    <!-- dataTables -->
    <link href="<?php echo $vendor_dir; ?>dataTables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- custom style -->
    <link href="assets/css/style.min.css" rel="stylesheet">

    <!-- vendor -->
    <!-- jQuery -->
    <script src="<?php echo $vendor_dir; ?>jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo $vendor_dir; ?>popper.min.js"></script>
    <script src="<?php echo $vendor_dir; ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $vendor_dir; ?>jquery-ui/jquery-ui.js"></script>
    <!-- dataTables -->
    <script src="<?php echo $vendor_dir; ?>dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo $vendor_dir; ?>dataTables/dataTables.bootstrap4.min.js"></script>

    <!-- custom script -->
    <script src="assets/js/script.js"></script>
</head>
<body>
