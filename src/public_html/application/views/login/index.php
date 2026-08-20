<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$CI =& get_instance();
$error = $this->session->flashdata('error');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= get_instance()->config->item("system_name_short") ?></title>
	<link rel="icon" type="image/ico" href="<?= base_url() ?>assets/favicon.ico"/>

	<!-------------------- Plugin -------------------->
	<?= $CI->load->view("plugin", '', true) ?>

	<!-------------------- System -------------------->
	<link href="<?= base_url() ?>assets/css/style.css?20211011" type="text/css" rel="stylesheet" media="screen" />

	<script src="<?= base_url() ?>assets/js/helper/validation.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/helper/modal.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/app.js" type="text/javascript"></script>

	<style>
		body {
			background-color: #00417c;
		}
	</style>

	<script>
		$(document).ready(function() {
			<?php if (! empty($error)): ?>
				// Show error msg in modal
				modal.error.open("<?= $error['msg'].' [Error Code: '.$error['code'].']' ?>");
			<?php endif; ?>

			//===========================================
			// Manual login (username only)
			//===========================================
			// Press "Enter" or click the button to submit the form
			$(document).keypress(function(e) {
				if (e.which == 13) {
					$("#form_login").submit();
				}
			});

			$("#btn_login").on("click", function() {
				$("#form_login").submit();
			});
		});
	</script>

</head>

<body>

<div class="container" style="margin-top: 100px;">
	<div class="row" style="padding: 5px 0 15px;">
		<div class="col-md-4 col-md-offset-4 text-center">
			<div class="text-center" style="font-size: 18px; padding: 10px; color: #fff;">
				<?= get_instance()->config->item("system_name_style") ?>
			</div>
		</div>
	</div>

	<div class="row space_bottom_header">
		<div class="col-md-4 col-md-offset-4">

			<div style="padding: 15px;">
				<div style="margin: 20px 0 20px 0;">
					<form id="form_login" method="post" action="<?= base_url() ?>login/manual_login">
						<div class="form-group">
							<input type="text" class="form-control" id="username" name="username" placeholder="Username" style="margin-bottom: 10px;">
							<button type="button" id="btn_login" class="btn btn-default" style="width: 100%;">Login</button>
						</div>
					</form>
					<div style="clear: both"></div>
				</div>
			</div>

		</div>
	</div>
</div>

</body>
</html>
