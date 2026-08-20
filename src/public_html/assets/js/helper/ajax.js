var ajax = {
	get: function(url, data, async, fnOnSuccess, fnOnError) {
		$.ajax({
			url: url,
			type: 'GET',
			data: data,
			//async: async,
			success: function(data) {
				
				// Check whether the session is expired
				if (session.is_expired_by_json(data)) {
					return;
				}
				
				if (data.isSuccess == null || data.isSuccess === true) {
					if (fnOnSuccess != null && typeof fnOnSuccess === "function") {
						fnOnSuccess(data);
					}
				} else if (data != null && data.isSuccess === false) {
					if (fnOnError != null && typeof fnOnError === "function") {
			        	fnOnError(data);
					} else {
						modal.error.open("Error occurred.");
					}
				}
					
			},
			error: function(xhr, textStatus, errorThrown) {
				modal.error.open("Error occurred.");
				
		        console.log(xhr.responseText);
		        console.log(textStatus);
		        console.log(errorThrown);
			}
		});
	},
	post: function(url, data, fnOnSuccess, fnOnError) {
		this.postWithOption(url, data, fnOnSuccess, fnOnError, true);
	},
	postWithoutLoadingDialog: function(url, data, fnOnSuccess, fnOnError) {
		this.postWithOption(url, data, fnOnSuccess, fnOnError, false);
	},
	postWithOption: function(url, data, fnOnSuccess, fnOnError, showLoadingModal) {
		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			beforeSend: function() {
				if (showLoadingModal == true) {
					modal.loading.open();
				}
			},
			success: function(data) {
				// Check whether the session is expired
				if (session.is_expired_by_json(data)) {
					return;
				}
				
				if (data.isSuccess == null || data.isSuccess === true) {
					if (fnOnSuccess != null && typeof fnOnSuccess === "function") {
						fnOnSuccess(data);
					}
				} else if (data != null && data.isSuccess === false) {
					if (fnOnError != null && typeof fnOnError === "function") {
			        	fnOnError(data);
					} else {
						modal.error.open("Error occurred.");
					}
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				modal.error.open("Error occurred.");
				
		        console.log(xhr.responseText);
		        console.log(textStatus);
		        console.log(errorThrown);
			},
			complete: function() {
				if (showLoadingModal == true) {
					modal.loading.close();
				}
			}
		});
	},
	postFormData: function(url, data, fnOnSuccess, fnOnError) {
		this.postFormDataWithOption(url, data, fnOnSuccess, fnOnError, true);
	},
	postFormDataWithOption: function(url, data, fnOnSuccess, fnOnError, showLoadingModal) {
		$.ajax({
			url: url,
			type: 'POST',
			processData: false,
			contentType: false,
			data: data,
			beforeSend: function() {
				if (showLoadingModal == true) {
					modal.loading.open();
				}
			},
			success: function(data) {
				// Check whether the session is expired
				if (session.is_expired_by_json(data)) {
					return;
				}
				
				if (data.isSuccess == null || data.isSuccess === true) {
					if (fnOnSuccess != null && typeof fnOnSuccess === "function") {
						fnOnSuccess(data);
					}
				} else if (data != null && data.isSuccess === false) {
					if (fnOnError != null && typeof fnOnError === "function") {
			        	fnOnError(data);
					} else {
						modal.error.open("Error occurred.");
					}
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				modal.error.open("Error occurred.");
				
		        console.log(xhr.responseText);
		        console.log(textStatus);
		        console.log(errorThrown);
			},
			complete: function() {
				if (showLoadingModal == true) {
					modal.loading.close();
				}
			}
		});
	},
	
	
	// As of jQuery 1.8, the use of async: false with jqXHR ($.Deferred) is deprecated
	// post: function(url, data, async, fnOnSuccess, fnOnError) {
		// $.ajax({
			// url: url,
			// type: 'POST',
			// data: data,
			// async: async,
			// success: function(data) {
// 				
				// // Check whether the session is expired
				// if (session.is_expired_by_json(data)) {
					// return;
				// }
// 				
				// if (data.isSuccess == null || data.isSuccess === true) {
					// if (fnOnSuccess != null && typeof fnOnSuccess === "function") {
						// fnOnSuccess(data);
					// }
				// } else if (data != null && data.isSuccess === false) {
					// if (fnOnError != null && typeof fnOnError === "function") {
			        	// fnOnError(data);
					// } else {
						// modal.error.open("Error occurred.");
					// }
				// }
// 					
			// },
			// error: function(xhr, textStatus, errorThrown) {
				// modal.error.open("Error occurred.");
// 				
		        // console.log(xhr.responseText);
		        // console.log(textStatus);
		        // console.log(errorThrown);
			// }
		// });
	// }
};
