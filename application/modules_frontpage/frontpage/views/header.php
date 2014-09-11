<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
	
	<title><?php echo application_title(); ?></title>
	<meta charset="utf-8" />
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="{base_url}bootstrap/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" href="{base_url}css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="{base_url}css/ui-smoothness/jquery-ui-1.8.19.custom.css" type="text/css" />
    <link rel="stylesheet" href="{base_url}css/jquery-ui-timepicker-addon.css" type="text/css" />
    <link rel="stylesheet" href="{base_url}css/apprise.css" type="text/css" />
    
    <script type="text/javascript" src="{base_url}js/jquery-1.10.2.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="{base_url}js/jquery-ui-1.8.16.custom.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="{base_url}js/jquery-ui-timepicker-addons.js" charset="utf-8"></script>
    <script type="text/javascript" src="{base_url}js/modernizr.custom.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="{base_url}js/apprise-1.5.full.js" charset="utf-8"></script>
    
    <!--[if lt IE 9]>
    <script src="{base_url}js/css3-mediaqueries.min.js"></script>
    <![endif]-->
    
    
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo application_title(); ?></title>
		<link href="<?php echo base_url(); ?>assets/style/css/styles.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="<?php echo base_url(); ?>assets/style/css/superfish.css" rel="stylesheet" type="text/css" media="screen" />
		<!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/style/css/ie6.css" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/style/css/ie7.css" /><![endif]-->
		<link type="text/css" href="<?php echo base_url(); ?>assets/jquery/ui-themes/businessassistant/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery/jquery-ui-1.8.16.custom.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/jquery/jquery.maskedinput-1.2.2.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/jquery/superfish.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/jquery/supersubs.js" type="text/javascript"></script>
		
	</head>
	<body>

		<div id="header_wrapper">

			<div class="container_10" id="header_content">

				<h1><?php echo application_title(); ?></h1>

			</div>

		</div>

		<div id="navigation_wrapper">

			<ul class="sf-menu" id="navigation">

                <?php echo modules::run('ba_menu/display', array('view'=>'dashboard/header_menu')); ?>

			</ul>

		</div>

		<div class="container_10" id="center_wrapper">