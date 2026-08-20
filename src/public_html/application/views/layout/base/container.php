<div id="container">
	<div class="container-fluid">
		<div class="row" style="margin-top: 30px;">
			<div class="col-xs-12">
				<?php if ($this->config->item("service_termination") != ''  && time() >= strtotime($this->config->item("service_termination"))): ?>
				<div class="well" style="background: #fcf8e3; margin-bottom: 0px; box-shadow: unset;">
					<strong style="font-size: 12pt;"></strong>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?= isset($container) && ! empty($container) ? $container : '' ?>
</div>
