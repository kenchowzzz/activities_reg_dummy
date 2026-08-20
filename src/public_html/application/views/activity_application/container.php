<?php if ( ! can_read($modulePermissions)): ?>
	<?php show_error_panel("Permission Denied", new Exception(sprintf("No permission to read [<b>%s</b>].", $module_name), ERROR_CODE_PERMISSION_DENIED)); ?>
<?php else: ?>

<div id="content_container_left">
	<?= isset($content_left) && ! empty($content_left) ? $content_left : '' ?>
</div>

<div id="content_container_right" style="display: none; height: 100%;">

</div>

<?php endif; ?>
