<div class="container-fluid">
	<div class="row" style="margin-bottom: 30px;">
		<div class="col-xs-12">
			<h2><?= $module_desc ?></h2>

			<div class="row">
				<div class="col-md-12">
					<div id="tabs_reports">
						<ul class="resp-tabs-list tab_identifier_reports">
							<?php foreach ($tab_items as $i => $tab_item): ?>
								<li id="tab_<?= $tab_item->module_id ?>"><?= $tab_item->module_name ?></li>
							<?php endforeach; ?>
						</ul>
						
						<div class="resp-tabs-container tab_identifier_reports">
							<?php foreach ($tab_items as $i => $tab_item): ?>
								<div id="tab_content_<?= $tab_item->module_id ?>">
									
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	 $(document).ready(function() {
	 	var selectedModuleId = "<?= $tab_items[0]->module_id ?>";
	 	
    	//=============================
    	// Responsive tabs
    	//=============================
        $('#tabs_reports').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'tab_identifier_reports', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                
                switch ($tab.text()) {
                	<?php foreach ($tab_items as $tab_item): ?>
		            	case "<?= $tab_item->module_name ?>":
		            		selectedModuleId = "<?= $tab_item->module_id ?>";
		            		ajax.post(
								"<?= base_url().$module_json_html_path ?>/load_rpt_list/<?= $tab_item->module_id ?>",
								null,
								function (data) {
									$("#tab_content_<?= $tab_item->module_id ?>").html(data);
								},
								null
							);
		            	break;
	            	<?php endforeach; ?>
	            	default:
	            		console.debug("Tab [" + $tab.text() + "] not found in reports tabs.");
	            	break;
                }
            }
        });
        
        /* Click the first tab in order to reset the responsive tab */
		$('#tab_' + selectedModuleId).click();
		
	});
	
</script>