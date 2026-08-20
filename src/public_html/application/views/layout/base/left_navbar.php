<?php 
	$menu_items = $sys_user_profile->get_menu_items(); 
?>
<style>
	.right_nav_menu_1>.nav_1_item>ul>li>.tooltip{
		top:32px!important;
		width:auto;
		white-space: nowrap;
	}
	.right_nav_menu_1>.nav_1_item>ul>li{
		margin-left: 2%;
		float:left;
	}
	.right_nav_menu_1{
		display: none;
	}
</style>
<div class="sb-slidebar sb-left">
	
	<!-- First Layer -->
	<ul>
		<li class="right_nav_menu_1">
			<div class="nav_1_item">
				<ul class="nav navbar-nav" style="float:none;">
					<li><a href="<?= site_url($menu_items[0]->module_path) ?>" data-toggle="tooltip" data-placement="bottom" title="Home"><i class="fa fa-home" aria-hidden="true"></i></a></li>
					<li><a href="<?= base_url() ?>account" data-toggle="tooltip" data-placement="bottom" title="Account Settings"><i class="fa fa-user" aria-hidden="true"></i></a></li>
					<!--
					<li><a href="<?= base_url() ?>notification" data-toggle="tooltip" data-placement="bottom" title="Notification"><i class="fa fa-envelope" aria-hidden="true"></i><?php if (isset($notification_notread)) { ?> <span class="badge" <?= ($notification_notread == null || $notification_notread == 0) ? '' : 'style="background-color: #d9534f"' ?>><?= ($notification_notread == null || $notification_notread == 0) ? '0' : $notification_notread ?> </span><?php } ?></a></li>
					-->
					<li>
						<a href="<?= base_url() ?>login/logout" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
					</li>
				</ul>
			</div>
		</li>
		<?php foreach($menu_items as $i => $nav_1_item): ?>
		<li>
			<div class="nav_1_item">
				<a href="<?= $nav_1_item->module_path == "#" ? $nav_1_item->module_path : base_url().$nav_1_item->module_path ?>" class="nav_1_label">
					<?= $nav_1_item->module_name ?>
				
					<?php if ($nav_1_item->child_cnt > 0): ?>
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					<?php endif; ?>
					<div style="clear:both;"></div>
					
					<!--
					<?php if ($nav_1_item->child_cnt > 0): ?>
					<a href="#">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</a>
					<?php endif; ?>
					<div style="clear:both;"></div>
					-->
				</a>
			</div>
				
			<?php if (isset($nav_1_item->child_modules) && $nav_1_item->child_modules > 0): ?>
				<!-- Second Layer -->
				<ul style="max-height:400px;overflow:auto;">
					<?php foreach($nav_1_item->child_modules as $j => $nav_2_item): ?>
					<li>
						<!--
						<a href="<?= base_url().$nav_2_item->module_path ?>" class="nav_2_item"><?= $nav_2_item->module_name ?></a>
						-->
						
						<a href="<?= $nav_2_item->module_path == "#" ? $nav_2_item->module_path : base_url().$nav_2_item->module_path ?>" class="nav_2_item"><?= $nav_2_item->module_name ?></a>
							
						<?php if (isset($nav_2_item->child_modules) && $nav_2_item->child_modules > 0): ?>
						<!-- Third Layer -->
						<ul>
							<?php foreach($nav_2_item->child_modules as $k => $nav_3_item): ?>							
								<li><a href="<?= base_url().$nav_3_item->module_path ?>" class="nav_3_item"><?= $nav_3_item->module_name ?></a></li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ul>
	
	<!--	
	<ul>
		<li>
			<a href="<?= base_url() ?>application" class="nav_1_item">Application <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
			
			<ul class="nav_2">
				<li>
					<a href="#" class="nav_2_item">Layer 2 - 1</a>
					
					<ul>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="nav_2_item">Layer 2 - 2</a>
					
					<ul>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
					</ul>
				</li>
				<li><a href="#" class="nav_2_item">Layer 2 - 3</a></li>
			</ul>
		</li>
		<li>
			<a href="<?= base_url() ?>member" class="nav_1_item">Member <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
			
			<ul class="nav_2">
				<li>
					<a href="#" class="nav_2_item">Layer 2 - 1</a>
					
					<ul>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="nav_2_item">Layer 2 - 2</a>
					
					<ul>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
						<li><a href="#" class="nav_3_item">Layer 3 - 1</a></li>
					</ul>
				</li>
				<li><a href="#" class="nav_2_item">Layer 2 - 3</a></li>
			</ul>
		</li>
		<li><a href="<?= base_url() ?>logout" class="nav_1_item">Logout</a></li>
	</ul>
	
	-->
</div>