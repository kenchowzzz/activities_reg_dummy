<div class="container-fluid">
	<div class="row" style="margin-bottom: 30px;">
		<div class="col-xs-12">
			<h2><?= $module_desc ?></h2>

			<?php if (can_create($modulePermissions)): ?>
			<div class="row">
				<div class="col-md-12 space_bottom_btn">
					<button type="button" class="btn btn-default" id="btn_create_activity">Create Activity</button>
				</div>
			</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-12">
					<table id="dt_activity" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Activity Name</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Language</th>
								<th>Organiser</th>
								<th>Created By</th>
								<th>Created Date</th>
								<th></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><input type="text" placeholder="Activity Name" /></th>
								<th><input type="text" placeholder="Start Date" /></th>
								<th><input type="text" placeholder="End Date" /></th>
								<th><input type="text" placeholder="Language" /></th>
								<th><input type="text" placeholder="Organiser" /></th>
								<th><input type="text" placeholder="Created By" /></th>
								<th><input type="text" placeholder="Created Date" /></th>
								<th></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var table_activity;
	var tableId_activity = "dt_activity";

	$(document).ready(function() {
		//==============================================================================
		//	Datatable
		//==============================================================================
		table_activity = $("#" + tableId_activity).DataTable({
			"stateSave": false,
			"processing": true,
			"ajax":
			{
				"url": '<?= base_url().$module_json_api_path ?>/load_activity',
				"dataSrc": function(json) {
					if (!session.is_expired_by_json(json)) {
						return json.data;
					}
				}
			},
			"columns": [
				{ "data": "activity_name" },
				{ "data": "start_date" },
				{ "data": "end_date" },
				{ "data": "language" },
				{ "data": "organiser" },
				{ "data": "create_by" },
				{ "data": "create_dt" },
				{ "defaultContent": "" }
			],
			"order": [[0, 'asc']],
			'columnDefs': [
				{
					'className': 'control',
					'orderable': false,
					'targets': -1
				}
			],
			responsive: {
				details: {
					type: 'column',
					target: -1
				}
			},
			dom: "<'row'<'col-md-3'l><'col-md-6'B><'col-md-3'f>>rtip",
			buttons: [
				'copy', 'csv', 'print'
			],
			processing: true,
			"language": {
				"search": "Filter:"
				,"emptyTable": "No record retrieved"
				,"processing": "<div id='dt_loader'></div>"
			}
		});

		/* Apply search to datatable footer */
		$.fn.dataTable.ext.errMode = 'none';
		table_activity.columns().every( function () {
			var that = this;

			$( 'input[type="text"]', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) {
					that.search( this.value ).draw();
				}
			});
		});
	});

	<?php if (can_create($modulePermissions)): ?>
	//=============================
	// Create Button
	//=============================
	$("#btn_create_activity").click(function() {
		ajax.post(
			"<?= base_url().$module_json_html_path ?>/load_create_form",
			{ },
			function (data) {
				$("#content_container_right").html(data);
				app.container.slideHorizontally(
					"content_container_left",
					"content_container_right",
					"content_container_right");
			},
			null
		);
	});
	<?php endif; ?>
</script>
