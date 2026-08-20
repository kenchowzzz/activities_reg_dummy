<!DOCTYPE html>
<?php $CI =& get_instance(); ?>
<html>
<head> 
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" type="image/ico" href="<?= base_url() ?>assets/favicon.ico"/>
	
	<!-------------------- Plugin -------------------->
	<?= $CI->load->view("plugin", '', true) ?>
	
	<!-------------------- System -------------------->
	<link href="<?= base_url() ?>assets/css/style.css?_=<?=rand()?>" type="text/css" rel="stylesheet" media="screen" />
	<link href="<?= base_url() ?>assets/css/slidebars.css?_=<?=rand()?>" type="text/css" rel="stylesheet" media="screen" />
	<link href="<?= base_url() ?>assets/css/print_style.css?_=<?=rand()?>" type="text/css" rel="stylesheet" media="print" />
	
	<script src="<?= base_url() ?>assets/js/helper/validation.js?_=<?=rand()?>" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/modal.js?_=<?=rand()?>" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/dataTables.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/panel.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/ajax.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/image.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/utils.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/session.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/d3_helper.js?_=<?=rand()?>" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/app.js" type="text/javascript"></script>	
</head>

<body>

<div id="container">
	<?= isset($container) && ! empty($container) ? $container : '' ?>
</div>

</body>
