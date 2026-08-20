var app = {
	container: {
		slideDuration: 500,
		slideHorizontally: function(leftContainerId, rightContainerId, toBeShowContainerId, fnAfterSlide) {
			
			//check active form			
			if(activeForm.checkActiveForm(false, function(){
				app.container.slideHorizontallyAction(leftContainerId, rightContainerId, toBeShowContainerId, fnAfterSlide);	
			})){
				app.container.slideHorizontallyAction(leftContainerId, rightContainerId, toBeShowContainerId, fnAfterSlide);
			}
						
		},
		slideHorizontallyAction: function(leftContainerId, rightContainerId, toBeShowContainerId, fnAfterSlide){
			leftContainer = $("#" + leftContainerId);
			rightContainer = $("#" + rightContainerId);
			
			jQuery.when(
				this.slideHorizontallyActionByDeferred(leftContainerId, rightContainerId, toBeShowContainerId)
			).done(
				function() {
					if (fnAfterSlide != null && typeof fnAfterSlide === "function") {
						fnAfterSlide();						
					}
					
					// Check whether to be show container contains datatable. If yes, recalc the datatable width for handling responsive case
					if ($("#" + toBeShowContainerId).find(".dataTable").length > 0) {
						var dataTables = $("#" + toBeShowContainerId).find(".dataTable");
						$.each(dataTables, function() {
							$(this).DataTable().responsive.recalc();
						});
						// var dataTable = $("#" + toBeShowContainerId).find(".dataTable");
						// dataTable.DataTable().responsive.recalc();
					}
				} 
			);
		},
		slideHorizontallyActionByDeferred: function(leftContainerId, rightContainerId, toBeShowContainerId) {
			var dfd = $.Deferred();
			
			if (rightContainerId == toBeShowContainerId) {	// Slide from left to right
				if (! rightContainer.is(':visible')) {
					leftContainer.hide('slide', {direction:'left'}, this.slideDuration);
					
					setTimeout(function() {
						rightContainer.show();
						dfd.resolve();
					}, this.slideDuration);
				} else {
					dfd.resolve();
				}
			} else if (leftContainerId == toBeShowContainerId) {	// Slide from right to left
				rightContainer.hide();
				leftContainer.show('slide', {direction:'left'}, this.slideDuration);
				dfd.resolve();
			}
			
			return dfd.promise();
		}
		
	},
	
	authorPanel: {
		isShowDefault: false,
		duration: 400,
		$btnToggle: null,
		$contentWrapper: null,
		$authorPanelWrapper: null,
		init: function() {
			this.$btnToggle = $(".toggle_btn_author_panel");
			this.$contentWrapper = $(".wrapper_content");
			this.$authorPanelWrapper = $('.wrapper_author_panel');
			
			this.$btnToggle.off("click").on('click', function(e) {
				app.authorPanel.toggle(this.duration);
			});
			
			this.show();
		},
		show: function(duration) {
			if (this.$authorPanelWrapper.is(":visible")) {
				return;	
			}
			
			if (($.cookie("autherPanel.isShow") == null && this.isShowDefault) || ($.cookie("autherPanel.isShow") != null && $.cookie("autherPanel.isShow") == "true")) {
				this.$contentWrapper.parent().removeClass("col-md-12").addClass("col-md-9");
				this.$authorPanelWrapper.parent().addClass("col-md-3");
				if (duration == null) {
					this.$authorPanelWrapper.show();
				} else {
					this.$authorPanelWrapper.show("slide", { direction: "right" }, duration);
				}
				this.$btnToggle.attr("title", "Hide Author/Editor");
			}
		},
		hide: function(duration) {
			if (! this.$authorPanelWrapper.is(":visible")) {
				return;
			}
			
			if (($.cookie("autherPanel.isShow") == null && !this.isShowDefault) || ($.cookie("autherPanel.isShow") != null && $.cookie("autherPanel.isShow") == "false")) {
				this.$authorPanelWrapper.hide("slide", { direction: "right" }, duration);
				setTimeout(function () {
					app.authorPanel.$authorPanelWrapper.parent().removeClass("col-md-3");
					app.authorPanel.$contentWrapper.parent().removeClass("col-md-9").addClass("col-md-12");
				}, duration);
				this.$btnToggle.attr("title", "Show Author/Editor");
			}
		},
		toggle: function() {
			if (this.$authorPanelWrapper.is(":visible")) {
				$.cookie("autherPanel.isShow", "false", { path: '/' });
				this.hide(this.duration);
			} else {
				$.cookie("autherPanel.isShow", "true", { path: '/' });
				this.show(this.duration);
			}
		}
	},
	
	form: {
		editForm: {
			init: function (formId) {
				// Init author panel
				app.authorPanel.init();
				
				// Disable input which is a hidden value
				$.each($("#" + formId + " :input"), function(index, value) {
					if ($(this).val() == "***") {
						$(this).prop("disabled", true);
					}
				});
				
			}	
		}
	},
	
	address: {
		selectRegionPzoneByCountry: function (getCountryAPI, countryId, selectIdCountry, selectIdRegion, selectIdPzone) {
			if ($("#" + selectIdCountry).val().length == 0) {
				$("#" + selectIdRegion).val("");
				$("#" + selectIdPzone).val("");
			} else {
				ajax.postWithoutLoadingDialog(
					getCountryAPI,
					{ "country_id": countryId },
					function (json) {
						data = json.data;
						
						if (data != null) {
							// $("#" + selectIdRegion).find('option:selected').removeAttr("selected");
							// $("#" + selectIdPzone).find('option:selected').removeAttr("selected");
							
							// Region
							if (data.country_region_id != null) {
								if ($("#" + selectIdRegion + " option[value='" + data.country_region_id + "']").length > 0) {
									$("#" + selectIdRegion).val(data.country_region_id);
								}
							} else {
								$("#" + selectIdRegion).val($("#" + selectIdRegion + " option:first").val());
							}
							
							// Pzone
							if (data.pzone_id != null) {
								if ($("#" + selectIdPzone + " option[value='" + data.pzone_id + "']").length > 0) {
									$("#" + selectIdPzone).val(data.pzone_id);
								}
							} else {
								$("#" + selectIdPzone).val($("#" + selectIdPzone + " option:first").val());
							}
						}				
					},
					null
				);
			}
		}
		
// 		
		// loadCountryRegion: function(loadHtmlUrl, countryId, $wrapper) {
			// ajax.post(
				// loadHtmlUrl,
				// { "country_id": countryId },
				// false,
				// function (data) {
					// $wrapper.html(data);
				// },
				// null
			// );
		// },
// 		
		// loadPzone: function(loadHtmlUrl, countryId, $wrapper) {
			// ajax.post(
				// loadHtmlUrl,
				// { "country_id": countryId },
				// false,
				// function (data) {
					// $wrapper.html(data);
				// },
				// null
			// );
		// }
	},
};

var activeForm = {
	activeFormHash: null,
	activeFormActionBtnFn: null,
	$activeForm : null,	
	$activeFormTextInputs: null,
	$activeFormTextAreas: null,
	createActiveForm: function(formId, actionFn){		
		
		//find active form
		this.$activeForm = $("#"+formId);
		
		//save activeFormHash to app object
		this.activeFormHash = JSON.stringify(this.$activeForm.serializeArray()).hashCode();
		
		//save the action button id
		if (typeof actionFn == 'function') {
			//store actionFn if existed 
			this.activeFormActionBtnFn = actionFn;
		} else {
			//otherwise go to the form tag and find data-fn
			this.activeFormActionBtnFn = window[this.$activeForm.data("fn")];	
		}
		
		
		//=================================================================================================
		//	Form validation
		//=================================================================================================
		
		// Find all text inputs in active form
		$activeFormTextInputs = $("#"+formId+" :input[type=text]");
		
		$($activeFormTextInputs).each(function(index, value) {
			$(this).focusout(function(event) {
				validation.text.validateInputByAllRules($(this), false);
			});
		});
		
		// Find text area in active form
		$activeFormTextAreas = $("#"+formId+" textarea");
		$.each($activeFormTextAreas, function(index, value) {
			$(this).focusout(function(event) {
				validation.text.validateInputByAllRules($(this), false);
			});
		});
		
		// Find select in active form
		$activeFormSelects = $("#"+formId+" select");
		$.each($activeFormSelects, function(index, value) {
			$(this).change(function(event) {
				// $("#" + $(this).attr('id') + " option:first").prop("selected", false);
				validation.select.validate($(this), [RULE_IS_REQUIRED], false);
			});
		});
		
		// Find split date wrapper in active form
		$activeFormSplitDates = $("#"+formId+" div.split_date");
		$.each($activeFormSplitDates, function(index, value) {
			$(this).focusout(function(event) {
				validation.splitDate.validate($(this), false);
			});
		});
		
		// Find split birth date wrapper in active form
		$activeFormSplitDates = $("#"+formId+" div.split_birth_date");
		$.each($activeFormSplitDates, function(index, value) {
			$(this).focusout(function(event) {
				validation.splitDate.validateBirthDate($(this), false);
			});
		});
		
		// Find whether date range exist in the form
		if ($("#"+formId+" .split_date_from").length && $("#"+formId+" .split_date_to").length) {
			// Validate date range when mouse focus out
			$("#"+formId+" .split_date_from").focusout(function(event) {
				validation.splitDate.validateDateRange($("#"+formId+" .split_date_from"), $("#"+formId+" .split_date_to"), false);
			});
			$("#"+formId+" .split_date_to").focusout(function(event) {
				validation.splitDate.validateDateRange($("#"+formId+" .split_date_from"), $("#"+formId+" .split_date_to"), false);
			});
		}
		
		//=================================================================================================
		//	Form buttons action
		//=================================================================================================
		/*------------------------------ Reset Button ------------------------------*/
		$("#"+formId+" input[type=reset]").on('click', function () {
			validation.text.clearAllFeedback();
			validation.select.clearAllFeedback();
			validation.splitDate.clearAllFeedback();
		});
		
		
		//=================================================================================================
		//	Form autocomplete control
		//=================================================================================================
		$("#"+formId+" input[type=text]").attr('autocomplete', 'off');
		
		
		
	},
	resetActiveForm: function() {
		//reset active form
		activeForm.$activeForm = null;
	},
	checkActiveForm: function(isOverride, actionFn){		
		if(activeForm.$activeForm == null){
			//active form is not existed. Don't check anything
			return true;
		} else {
			var currentForm = JSON.stringify(activeForm.$activeForm.serializeArray()).hashCode();
	    	var isValidForm = true;
	    	isOverride = isOverride || false;
	    	
	    	if(activeForm.activeFormHash && !isOverride && currentForm != activeForm.activeFormHash){
	    		isValidForm = false;
	    		
	    		modal.leaveTabNotification.open(
					"Do you want to save changes?", 
					null,		
					function(){
						validation.form.validate(
							activeForm.$activeForm,
							true,
							function() {
								//save
								activeForm.activeFormActionBtnFn(false);
								
								//reset active form
								activeForm.$activeForm = null;
								
								// Check whether the error modal is opened. If it is opened (Because of session expired), 
								// the action will stop here and will not go to next page
								if (!modal.error.isOpen()) {
									//go to next page
									actionFn();
								}
							},
							null
						);
					},			 
					function() {
						//unsave
						
						//reset active form
						activeForm.$activeForm = null;
						
						//go to next page	
	                    actionFn();
	                    				
					},
					function(){
						//cancel							
													
					}
				);
	    	}
	    	
	    	
	    	return isValidForm;	
		}
	}
};

String.prototype.hashCode = function() {
  var hash = 0, i, chr, len;
  if (this.length === 0) return hash;
  for (i = 0, len = this.length; i < len; i++) {
    chr   = this.charCodeAt(i);
    hash  = ((hash << 5) - hash) + chr;
    hash |= 0; // Convert to 32bit integer
  }
  return hash;
};

