<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="panel panel-default">
	<div class="panel-heading"><strong>Attendance Reports</strong></div>
	<div class="panel-body">
		<div class="list-group">
			<?php foreach ($rpt_list as $rpt): ?>
				<?php $download_url = base_url() . $rpt->controller . '/' . $rpt->method; ?>
				<a class="list-group-item" href="<?= htmlspecialchars($download_url, ENT_QUOTES, 'UTF-8') ?>">
					<strong><?= htmlspecialchars($rpt->name, ENT_QUOTES, 'UTF-8') ?></strong>
					<br>
					<small><?= htmlspecialchars($rpt->description, ENT_QUOTES, 'UTF-8') ?></small>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
