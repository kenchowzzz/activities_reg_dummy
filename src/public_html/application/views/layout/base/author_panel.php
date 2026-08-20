<div class="panel panel-default panel_author">
	<div class="panel-heading">
		Author / Editor
	</div>
	<div class="panel-body">
		<?php //if (isset($create_by)): ?>
		<div class="item_group">
			<b>Created By</b>
			<p class="panel-create-author"><?= ! empty($create_by) ? $create_by : VALUE_EMPTY ?></p>
		</div>
		<?php //endif; ?>
		
		<?php //if (isset($create_dt)): ?>
		<div class="item_group">
			<b>Created Datetime</b>
			<p class="panel-create-datetime"><?= ! empty($create_dt) ? $create_dt : VALUE_EMPTY ?></p>
		</div>
		<?php //endif; ?>
		
		<?php //if (isset($update_by)): ?>
		<div class="item_group">
			<b>Last Modified By</b>
			<p class="panel-update-author"><?= ! empty($update_by) ? $update_by : VALUE_EMPTY ?></p>
		</div>
		<?php //endif; ?>
		
		<?php //if (isset($update_dt)): ?>
		<div class="item_group">
			<b>Last Modified Datetime</b>
			<p class="panel-update-datetime"><?= ! empty($update_dt) ? $update_dt : VALUE_EMPTY ?></p>
		</div>
		<?php //endif; ?>
	</div>
</div>