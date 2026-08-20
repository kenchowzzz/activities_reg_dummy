<div class="row">
	<div class="col-md-12">
		<div class="panel panel-danger" style="margin-top: 25px;">
			<div class="panel-heading">
				<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span> 
				<?= $heading ?> 
				<?php if ( ! empty($exception->getCode()) || $exception->getCode() !== 0): ?>
					[Error Code: <?= $exception->getCode() ?>]
				<?php endif; ?>
			</div>
			<div class="panel-body">
				<?= $exception->getMessage() ?>
			</div>
		</div>
	</div>
</div>