var session = {
	is_expired_by_json:function(json)
	{
		var isExpired = false;
		if(typeof json != "undefinded")
		{
			if(json != "" && json != null)
			{
				if(typeof json =='object')
				{
				  // var response = $.parseJSON(json);
					if(typeof json.isSessionExpired != "undefinded")
					{
						if (json.isSessionExpired != null && json.isSessionExpired === true) {
							isExpired = true;
							
							if (json.requireRedirect != null && json.requireRedirect === true) {
								window.location = utils.base_url() + "login/expired";
							} else {
								modal.error.open(
									"Session Expired. You will be redirected to the login page when you close this dialog.",
									function () {
										window.location = utils.base_url() + "login";
									}	
								);
							}
							
						}
					}
				}
			}
		}
		
		return isExpired;
	}
};
