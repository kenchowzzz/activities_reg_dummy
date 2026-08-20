var panel = {
	toggle: function(panelId) {
		var panel = $("#" + panelId);
		var panelHeader = panel.children(".panel-heading");
		var panelBody = panel.children(".panel-body");
		if (panelBody.css("display") == "none") {
			panelHeader.children().switchClass("glyphicon-triangle-right", "glyphicon-triangle-bottom");
			panelBody.slideDown();
		} else {
			panelHeader.children().switchClass("glyphicon-triangle-bottom", "glyphicon-triangle-right");
			panelBody.slideUp();
		}	
	},
	show: function(panelId) {
		var panel = $("#" + panelId);
		var panelHeader = panel.children(".panel-heading");
		var panelBody = panel.children(".panel-body");
		if (panelBody.css("display") == "none") {
			panelHeader.children().switchClass("glyphicon-triangle-right", "glyphicon-triangle-bottom");
			panelBody.slideDown();
		}
	},
	hide: function(panelId) {
		var panel = $("#" + panelId);
		var panelHeader = panel.children(".panel-heading");
		var panelBody = panel.children(".panel-body");
		if (panelBody.css("display") == "block") {
			panelHeader.children().switchClass("glyphicon-triangle-bottom", "glyphicon-triangle-right");
			panelBody.slideUp();
		}
	}
	
};
