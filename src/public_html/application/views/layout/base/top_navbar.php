<?php 
	if (isset($tam_user_profile) && $tam_user_profile != null):
	$menu_items = $tam_user_profile->get_menu_items();

	$notification_permssion = get_user_module_permissions($current_user_id, $current_role_dept_unit_code, TAM_MODULE_ID_NOTIFICATION);
?>
<div class="menu_modal">
	<button class="navbar-toggler" type="button" style="float: right;" onclick="closeMenuModal();">
		<i class="fas fa-times" style="font-size: 30px; color: #fff;"></i>
	</button>
	<div style="overflow: auto;">
		<?php foreach ($menu_items as $menu_item): ?>
			<?php if ($menu_item->child_cnt > 0 && sizeof($menu_item->child_modules) != 0): ?>
				<div class="menu_modal_link" style="color: #fff; margin-bottom: 0px; text-decoration: underline;"><?= $menu_item->module_name ?></div>
				<?php foreach ($menu_item->child_modules as $child_menu_item): ?>
					<a class="menu_modal_link" href="<?= base_url() . $child_menu_item->module_path ?>"><small><i class="fas fa-caret-right"></i> <?= $child_menu_item->module_name ?></small></a>
				<?php endforeach; ?>
			<?php else: ?>
				<a class="menu_modal_link" href="<?= base_url() . $menu_item->module_path ?>" onclick="closeMenuModal();"><?= $menu_item->module_name ?></a>
			<?php endif; ?>
		<?php endforeach; ?>

		<hr>
		<br>

		<?php if (can_read($notification_permssion)): ?>
		<a class="menu_modal_link" href="<?= base_url() ?>notification">Notification<?php if (isset($notification_notread)) { ?> <span class="badge" <?= ($notification_notread == null || $notification_notread == 0) ? '' : 'style="background-color: #d9534f"' ?>><?= ($notification_notread == null || $notification_notread == 0) ? '0' : $notification_notread ?> </span><?php } ?></a>
		<?php endif; ?>
		<a class="menu_modal_link" href="<?= base_url() ?>login/logout" style="color: orange;">Logout (<?= $current_username ?>)</a>

		<br>
		<br>

	</div>
</div>

<div class="header fixed_header">
	<div class="menu fixed_menu">
		<nav class="navbar navbar-expand-md inner_menu">
			<div style="height: 50px; background-color: #00417c;">
				<span class="hidden-xs hidden-sm" style="display: inline-block; line-height: 50px; color: #fff; font-size: 20px; font-weight: bold;"><?= get_instance()->config->item("system_name_style") ?></span>
				<span class="hidden-md hidden-lg" style="display: inline-block; line-height: 50px; color: #fff; font-size: 20px; font-weight: bold;"><?= get_instance()->config->item("system_name_short") ?></span>
				<button class="navbar-toggle navbar-toggler collapsed" type="button" onclick="openMenuModal();">
					<i class="fas fa-bars" style="font-size: 30px; color: #fff;"></i>
				</button>
			</div>

			<div class="collapse navbar-collapse" id="navbarSupportedContent" style="height: 50px;">
				<ul class="nav navbar-nav mr-auto" style="width: 100%;">
					<?php foreach ($menu_items as $menu_item): ?>
						<?php if ($menu_item->child_cnt > 0 && sizeof($menu_item->child_modules) != 0): ?>
							<li class="nav-item dropdown">
								<a class="nav-link" href="<?= base_url() . $menu_item->module_path ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $menu_item->module_name ?> <small><i class="fas fa-caret-down"></i></small></a>
								<ul class="dropdown-menu">
									<?php foreach ($menu_item->child_modules as $child_menu_item): ?>
										<li><a class="dropdown-item" href="<?= base_url() . $child_menu_item->module_path ?>"><?= $child_menu_item->module_name ?></a></li>
									<?php endforeach; ?>
								</ul>
							</li>
						<?php else: ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url() . $menu_item->module_path ?>"><?= $menu_item->module_name ?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>

					<li class="nav-item" style="float: right;">
						<a class="nav-link" href="<?= base_url() ?>login/logout" style="color: orange;" data-toggle="tooltip" data-placement="bottom" title="Logout (<?= $current_username ?>)"><i class="fas fa-sign-out-alt" style="font-size: 20px;"></i></a>
					</li>
					<?php if (can_read($notification_permssion)): ?>
					<li class="nav-item" style="float: right;">
						<a class="nav-link" href="<?= base_url() ?>notification" style="font-size: 20px;" data-toggle="tooltip" data-placement="bottom" title="Notification"><i class="fas fa-envelope"></i><?php if (isset($notification_notread)) { ?> <span class="badge" <?= ($notification_notread == null || $notification_notread == 0) ? '' : 'style="background-color: #d9534f"' ?>><?= ($notification_notread == null || $notification_notread == 0) ? '0' : $notification_notread ?> </span><?php } ?></a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
	</div>
</div>

<?php endif; ?>