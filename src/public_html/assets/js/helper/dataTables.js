var dataTables = {
	checkbox: {
		click: function(dataTable, tableId, tableKey, checkbox, selectAllCheckboxName, selectedCheckboxIds) {
			
			var tr = $(checkbox).parent();
			var rowData = dataTable.row(tr).data();
			var selectedCheckboxId = rowData[tableKey];
			
			if (checkbox.checked) {
				// Insert into selectedCheckboxIds				
				if ($.inArray(selectedCheckboxId, selectedCheckboxIds) == -1) {
					selectedCheckboxIds.push(selectedCheckboxId);
				}
			} else {
				// If "Select all" control is checked and has 'indeterminate' property
				$('#' + tableId + ' input[name="' + selectAllCheckboxName + '"]').each(function() {
					if (this && this.checked && ('indeterminate' in this)) {
						// Set visual state of "Select all" control as 'indeterminate'
						this.indeterminate = true;
					}
				});
				
				// Remove from selectedCheckboxIds
				selectedCheckboxIds.splice($.inArray(selectedCheckboxId, selectedCheckboxIds), 1);
			}
			
			return selectedCheckboxIds;
		},
		//edit by Jacky 11/7/2016 
		// remark: faster getting data 4.3s->0.5s in 10778 records
		selectAll: function(dataTable, tableId, tableKey, checkbox, selectAllCheckboxName,searchApplied) {
			var ini_time = new Date().getTime();
			var selectedCheckboxIds = [];
			var rows_option = {};
			
			if(typeof searchApplied === "undefined")
			{
				rows_option = { 'search': 'applied' };
			}
			else
			{
				if(searchApplied)
				{
					rows_option = { 'search': 'applied' };
				}
				else
				{
					rows_option = {};
				}
			}
			
			// Get all rows with search applied
			var rows = dataTable.rows(rows_option).nodes();
			
			
			// Check/uncheck checkboxes for all rows in the table
			
			
			//edit by Jacky 11/7/2016 
			// remark: faster getting data 1.827s->0.0665s in 10778 records
			for(var i=0; i<rows.length;i++)
			{
				var nodeList = rows[i].getElementsByTagName('input');
				for(item in nodeList) 
				{
					if(typeof nodeList[item].attributes != "undefined")
					{
						if(nodeList[item].getAttribute("type") == "checkbox" && nodeList[item].disabled != true) 
						{
							nodeList[item].checked = checkbox.checked;
						}
					}
				}
			}
			
			// $('input[type="checkbox"]', rows).prop('checked', checkbox.checked);
			
			
			// Check/uncheck select_all checkboxs in thead and tfoot
			$('#' + tableId + ' thead input[name="' + selectAllCheckboxName + '"]').prop('checked', checkbox.checked);
			$('#' + tableId + ' tfoot input[name="' + selectAllCheckboxName + '"]').prop('checked', checkbox.checked);
			// Remove indeterminate if exist
			
			//edit by Jacky 11/7/2016 
			//remark: no big difference
			var selected_boxes = $('#' + tableId + ' input[name="'+ selectAllCheckboxName + '"]');
			for(var i=0; i<selected_boxes.length;i++)
			{
				if(selected_boxes[i] && ('indeterminate' in selected_boxes[i]))
				{
					selected_boxes[i].indeterminate = false;
				}
		
			}
			// $('#' + tableId + ' input[name="'+ selectAllCheckboxName + '"]').each(function() {
				// console.log(this);
				// if (this && ('indeterminate' in this)) {
					// this.indeterminate = false;
				// }
			// });
			
			// Put all checkbox ids to selectedCheckboxIds 
			if (checkbox.checked) {
				
				//edit by Jacky 11/7/2016 
				// remark: faster getting data 4s->2s in 10778 records
				var curr_data = dataTable.rows({ 'search': 'applied' }).data();
				for(var i=0;i<curr_data.length;i++)
				{
					var d = curr_data[i];
					if(typeof d[tableKey] != "object")
					{
						if(typeof  d[tableKey] == "string")
						{
							var parts = d[tableKey].split("/");
							if(parts.length > 1)
							{
								if ($("#" + tableId).find('input[id="'+d[tableKey]+'"][type="checkbox"]:disabled').length > 0) {
									continue;
								}
							}
							else
							{
								if ($("#" + tableId).find('input[type="checkbox"]#' + d[tableKey] + ':disabled').length > 0) {
									continue;
								}
							}
						}
						else
						{
							if ($("#" + tableId).find('input[type="checkbox"]#' + d[tableKey] + ':disabled').length > 0) {
									continue;
								}
						}
						
					}
					
					
					selectedCheckboxIds.push(d[tableKey]);
				}
				// dataTable.rows({ 'search': 'applied' }).every(function() {
					// var rowData = this.data();
					// selectedCheckboxIds.push(rowData[tableKey]);
				// });
				
			};
			var fin_time = new Date().getTime();
			var seconds = (fin_time - ini_time)/1000;
			console.log(seconds+"s");
			return selectedCheckboxIds;
		}
	}
	,print:{
			setting:{
			extend: 'print',
	        customize: function ( win ) {
	    		$(win.document.body).find("td,th")
	            .css( 'border', '1px' );
	            $(win.document.body).find("td,th")
	            .css( 'border-color', 'black' );
	             $(win.document.body).find("td,th")
	            .css( 'border-style', 'solid' );
	             $(win.document.body).find("table")
	            .css( 'border-collapse', 'collapse' );
	    	}
		}
	}
};
