<?php $CI =& get_instance(); ?>

<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?= get_instance()->config->item("system_name") ?> - <?= $page_title ?></title>
	<link rel="icon" type="image/ico" href="<?= base_url() ?>assets/favicon.ico"/>
	
	<!-------------------- Plugin -------------------->
	<?= $CI->load->view("plugin", '', true) ?>
	
	<!-------------------- System -------------------->
	<link href="<?= base_url() ?>assets/css/style.css?_=<?=rand()?>" type="text/css" rel="stylesheet" media="screen" />
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
	<!-- Base Url -->
	<input id="base_url" type="hidden" value="<?=base_url()?>" />
	
	<!-- Navbar -->
	<?= $CI->load->view("layout/base/top_navbar", '', true) ?>
	
	<div id="sb-site">
		<!-- Container -->
		<?= $CI->load->view("layout/base/container", '', true) ?>
		
		<!-- Footer -->	
		<?= $CI->load->view("layout/base/footer", '', true) ?>
	</div>
	
	<!-- Scroll To Top Button -->
	<a href="#" class="scrollToTop btn" title="Scroll To Top"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true" style="font-size: 19px;"></span></a>

	<!-- Popup System Alert -->
	<?php
		$CI =& get_instance();
		$first_login = $this->session->flashdata('first_login');
		$notification_permssion = get_user_module_permissions($current_user_id, $current_role_dept_unit_code, TAM_MODULE_ID_NOTIFICATION);
		if (can_read($notification_permssion) && isset($notification_popup) && $notification_popup == true && isset($first_login)):
	?>
	<script>
		$(document).ready(function() {
			modal.notification.open(
				"Reminder",
				"You have <strong><?= $notification_notread ?></strong> unread notification(s).",
				"Go to Notification page",
				function() {
					location.href = "<?= base_url() ?>notification";
				},
				function() {

				}
			)
		});
	</script>
	<?php endif; ?>
	
	<script>
		$(document).ready(function() {
			$(window).scroll(function(){
				if ($(this).scrollTop() > 50) {
					$('.scrollToTop').fadeIn();
				} else {
					$('.scrollToTop').fadeOut();
				}
			});
			
			// Click event to scroll to top
			$('.scrollToTop').click(function(){
				$('html, body').animate({scrollTop : 0}, 700);
				return false;
			});
			
			//============================= 
			// Bootstrap tooltip
			//=============================
			$('[data-toggle="tooltip"]').tooltip();
		});

        function openMenuModal() {
            $(".menu_modal").fadeIn();
            //$("body").addClass('body_modal_open');
        }

        function closeMenuModal() {
            $(".menu_modal").fadeOut();
            //$("body").removeClass('body_modal_open');
        }
	</script>
</body>

</html>
