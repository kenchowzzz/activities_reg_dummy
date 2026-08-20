var modal = {
	showDuration: 10000,
	
	success: {
		open: function(successMsg, fnOnClose, autoClose) {
			// Define success modal
			var successModal = 
				"<div class='modal fade' id='successModal' tabindex='-1' role='dialog' aria-labelledby='successMsg'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-header alert alert-success'>" +
							"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
							"<div id='successMsg'><span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span><span class='sr-only'> Warning: </span> " + successMsg + "</div>" +
						"</div>" +
					"</div>" +
				"</div>";
			
			// Append error modal to body
			$(successModal).appendTo("body");
					
			// Launch warn modal
			$('#successModal').modal();
			
			if (autoClose == null || autoClose == true) {
				// Auto close after 
				setTimeout(function() {
					$("#successModal button.close").trigger("click");
				}, modal.showDuration);
			}
			
			// Call back when closing modal 
			$('#successModal').on('hidden.bs.modal', function (e) {
				$("body").find('#successModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
		}
	},
	warn: {
		open: function(warnMsg, fnOnClose) {
			// Define warn modal
			var warnModal = 
				"<div class='modal fade' id='warnModal' tabindex='-1' role='dialog' aria-labelledby='warnMsg'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-header alert alert-warning'>" +
							"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
							"<div id='warnMsg'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'> Warning: </span> " + warnMsg + "</div>" +
						"</div>" +
					"</div>" +
				"</div>";
			
			// Append error modal to body
			$(warnModal).appendTo("body");
					
			// Launch warn modal
			$('#warnModal').modal();
			
			// Call back when closing modal 
			$('#warnModal').on('hidden.bs.modal', function (e) {
				$("body").find('#warnModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
		}
	},
	notification: {
		open: function(title, content, btnLabel, fnOnConfirm, fnOnClose) {
			// Remove previous #notificationModal			
			if ($("#notificationModal").length > 0) {
				$("#notificationModal").remove();
			}
			
			// Define notification modal
			var notificationModal = 
				"<div class='modal fade' id='notificationModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			if (content != null) {
				notificationModal += 
							"<div class='modal-body'>" +
								content +
      						"</div>";
			}
			
			notificationModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>" + 
      							"<button type='button' class='btn btn-primary' id='confirmBtn'>" + btnLabel + "</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			
			// Append notification modal to body
			$(notificationModal).appendTo("body");
					
			// Launch notification modal
			$('#notificationModal').modal();
			
			// Call back when closing modal 
			$('#notificationModal').on('hidden.bs.modal', function (e) {
				$("body").find('#notificationModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
			
			// Action when clicking confirm button
			$('#confirmBtn').on('click', function(e) {
				$('#notificationModal').modal('hide');
				
				if (fnOnConfirm != null && typeof fnOnConfirm === "function") {
					fnOnConfirm();
				}
			});
		}
	},
	leaveTabNotification:  {
		open: function(title, content, fnOnSave, fnOnUnsave, fnOnClose) {
			// Remove previous #notificationModal			
			if ($("#leaveTabNotificationModal").length > 0) {
				$("#leaveTabNotificationModal").remove();
			}
			
			// Define notification modal
			var leaveTabNotificationModal = 
				"<div class='modal fade' id='leaveTabNotificationModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			if (content != null) {
				leaveTabNotificationModal += 
							"<div class='modal-body'>" +
								content +
      						"</div>";
			}
			
			leaveTabNotificationModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>" +
      							"<button type='button' class='btn btn-danger' id='unsaveBtn' style='padding: 6px 25px;'>No</button>" +  
      							"<button type='button' class='btn btn-primary' id='saveBtn' style='padding: 6px 25px;'>Yes</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			
			// Append notification modal to body
			$(leaveTabNotificationModal).appendTo("body");
					
			// Launch notification modal
			$('#leaveTabNotificationModal').modal();
			
			// Call back when closing modal 
			$('#leaveTabNotificationModal').on('hidden.bs.modal', function (e) {
				$("body").find('#leaveTabNotificationModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
			
			// Action when clicking save button
			$('#saveBtn').on('click', function(e) {
				$('#leaveTabNotificationModal').modal('hide');
				
				if (fnOnSave != null && typeof fnOnSave === "function") {
					fnOnSave();
				}
			});
			
			// Action when clicking unsave button
			$('#unsaveBtn').on('click', function(e) {
				$('#leaveTabNotificationModal').modal('hide');
				
				if (fnOnUnsave != null && typeof fnOnUnsave === "function") {
					fnOnUnsave();
				}
			});
		}
	},
	confirm: {
		open: function(title, content, btnLabel, fnOnConfirm, fnOnClose) {
			// Remove previous #confirmModal			
			if ($("#confirmModal").length > 0) {
				$("#confirmModal").remove();
			}
			
			// Define confirm modal
			var confirmModal = 
				"<div class='modal fade' id='confirmModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			if (content != null) {
				confirmModal += 
							"<div class='modal-body'>" +
								content +
      						"</div>";
			}
			
			if (btnLabel != null) {
				confirmModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>" + 
      							"<button type='button' class='btn btn-primary' id='confirmBtn'>" + btnLabel + "</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			} else {
				confirmModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			}
			
			
			// Append confirm modal to body
			$(confirmModal).appendTo("body");
					
			// Launch notification modal
			$('#confirmModal').modal();
			
			// Call back when closing modal 
			$('#confirmModal').on('hidden.bs.modal', function (e) {
				$("body").find('#confirmModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
			
			// Action when clicking confirm button
			$('#confirmBtn').on('click', function(e) {
				
				$('#confirmModal').modal('hide');
				
				if (fnOnConfirm != null && typeof fnOnConfirm === "function") {
					fnOnConfirm();
				}
			});
		}
	},
	ok: {
		open: function(title, content, btnLabel, fnOnOk, fnOnClose) {
			// Remove previous #okModal			
			if ($("#okModal").length > 0) {
				$("#okModal").remove();
			}						
			// Define ok modal
			var okModal = 
				"<div class='modal fade' id='okModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			if (content != null) {
				okModal += 
							"<div class='modal-body'>" +
								content +
      						"</div>";
			}
			
			if (btnLabel != null) {
				okModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-primary' id='okBtn'>" + btnLabel + "</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			} else {
				okModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-primary' id='okBtn'>OK</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			}
			
			// Append ok modal to body
			$(okModal).appendTo("body");
					
			// Launch ok modal
			$('#okModal').modal();
			
			// Action when clicking confirm button
			$('#okBtn').on('click', function(e) {
				
				$('#okModal').modal('hide');
				
				if (fnOnOk != null && typeof fnOnOk === "function") {
					fnOnOk();
				}
			});
			
			// Call back when closing modal 
			$('#okModal').on('hidden.bs.modal', function (e) {
				$("body").find('#okModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
		}
	},
	two_btn_confirm: {
		open: function(title, content, btn1Label, fnbtn1OnConfirm, btn2Label, fnbtn2OnConfirm, fnOnClose) {
			// Remove previous #confirmModal			
			if ($("#confirmModal").length > 0) {
				$("#confirmModal").remove();
			}
			
			// Define confirm modal
			var confirmModal = 
				"<div class='modal fade' id='confirmModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			if (content != null) {
				confirmModal += 
							"<div class='modal-body'>" +
								content +
      						"</div>";
			}
			
			if (btn1Label != null && btn2Label != null) {
				confirmModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>" + 
      							"<button type='button' class='btn btn-primary' id='confirm1Btn'>" + btn1Label + "</button>" +
      							"<button type='button' class='btn btn-primary' id='confirm2Btn'>" + btn2Label + "</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			} else {
				confirmModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			}
			
			
			// Append confirm modal to body
			$(confirmModal).appendTo("body");
					
			// Launch notification modal
			$('#confirmModal').modal();
			
			// Call back when closing modal 
			$('#confirmModal').on('hidden.bs.modal', function (e) {
				$("body").find('#confirmModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
			
			// Action when clicking confirm button
			$('#confirm1Btn').on('click', function(e) {
				
				$('#confirmModal').modal('hide');
				
				if (fnbtn1OnConfirm != null && typeof fnbtn1OnConfirm === "function") {
					fnbtn1OnConfirm();
				}
			});
			
			$('#confirm2Btn').on('click', function(e) {
				
				$('#confirmModal').modal('hide');
				
				if (fnbtn2OnConfirm != null && typeof fnbtn2OnConfirm === "function") {
					fnbtn2OnConfirm();
				}
			});
		}
	},
	custom_confirmation: {
		open: function(title, content, fnBtn, fnOnClose) {
			// Remove previous #confirmModal			
			if ($("#confirmModal").length > 0) {
				$("#confirmModal").remove();
			}
			
			// Define confirm modal
			var confirmModal = 
				"<div class='modal fade' id='confirmModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			if (content != null) {
				confirmModal += 
							"<div class='modal-body'>" +
								content +
      						"</div>";
			}
			
			if (fnBtn.length != 0) {
				confirmModal += "<div class='modal-footer'>" ;
				var i=0;
				for (var label in fnBtn) 
				{
				  if (fnBtn.hasOwnProperty(label)) {
				  	confirmModal += "<button type='button' class='btn custom_confirm_btn "+(typeof fnBtn[label].btn_classes != "undefined"? fnBtn[label].btn_classes: "")+"' data-dismiss='modal' data-label_name='"+label+"' id='confirmation_dialog_btn_"+i+"'>"+label+"</button>" ;
				  	i++;
				  }
				}
			confirmModal += "</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			} else {
				confirmModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			}
			
			
			// Append confirm modal to body
			$(confirmModal).appendTo("body");
					
			// Launch notification modal
			$('#confirmModal').modal();
			
			// Call back when closing modal 
			$('#confirmModal').on('hidden.bs.modal', function (e) {
				$("body").find('#confirmModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
			var n=0;
			console.log(fnBtn);
			$('.custom_confirm_btn').on('click', function(){
				var label = $(this).attr("data-label_name");
				if (fnBtn[label].btn_fun != null && typeof fnBtn[label].btn_fun === "function") {
						fnBtn[label].btn_fun();
				}
			 });
			// Action when clicking confirm button
			
		}
	},
	captcha_confirm: {
		open: function(title, content, btnLabel, fnOnConfirm, fnOnClose, json_html_path) {
			// Remove previous #confirmModal			
			if ($("#captcha_confirmModal").length > 0) {
				$("#captcha_confirmModal").remove();
				$(".modal-backdrop").remove();
			}
			
			// Define confirm modal
			var confirmModal = 
				"<div class='modal fade' id='captcha_confirmModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			if (content != null) {
				confirmModal += 
							"<div class='modal-body'>" +
								content +
								'<br>If you confirm,<br>'+
								'Please Input Captcha:<div><input type="text" id="user_captcha_txt" class="captcha form-control"  size="10" maxlength="10" required></div>'+
								'<img src="'+json_html_path+'/captcha_img" alt="CAPTCHA Image" id="captcha_img"/>'+
								'<a href="#" id="captcha_img_diff" onclick="">[ Different Image ]</a>'+
      						"</div>";
			}
			
			confirmModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>" + 
      							"<button type='button' class='btn btn-primary' id='captcha_confirmBtn'>" + btnLabel + "</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			
			// Append confirm modal to body
			$(confirmModal).appendTo("body");
					
			// Launch notification modal
			$('#captcha_confirmModal').modal();
			
			// Call back when closing modal 
			$('#captcha_confirmModal').on('hidden.bs.modal', function (e) {
				$("body").find('#captcha_confirmModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
			$(document).on("click","#captcha_img_diff",function(){
				var link = json_html_path+'/captcha_img?'+Math.random();
				document.getElementById('captcha_img').src=link; 
				return false;
			});
			
			// Action when clicking confirm button
			$('#captcha_confirmBtn').on('click', function(e) {
				if($("#user_captcha_txt").val()=="")
				{
					validation.text.validate($("#user_captcha_txt"),[RULE_IS_REQUIRED],true);
				}
				else
				{
					$('#captcha_confirmModal').modal('hide');
				
					if (fnOnConfirm != null && typeof fnOnConfirm === "function") {
						fnOnConfirm($("#user_captcha_txt").val());
					}
				}
				
			});
		}
	},
	error: {
		open: function(errorMsg, fnOnClose) {
			// Define error modal
			var errorModal = 
				"<div class='modal fade' id='errorModal' tabindex='-1' role='dialog' aria-labelledby='errorMsg'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-header alert alert-danger'>" +
							"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
							"<div id='errorMsg'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'> Error: </span> " + errorMsg + "</div>" +
						"</div>" +
					"</div>" +
				"</div>";
			
			// Append error modal to body
			$(errorModal).appendTo("body");
					
			// Launch error modal
			$('#errorModal').modal();
			
			// Call back when closing modal 
			$('#errorModal').on('hidden.bs.modal', function (e) {
				$("body").find('#errorModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
		},
		isOpen: function() {
			return ($("#errorModal").data('bs.modal') || {}).isShown;
		}
	}
	,extra_error: {
		open: function(id,errorMsg, fnOnClose) {
			// Define error modal
			var errorModal = 
				"<div class='modal fade' id='"+id+"' tabindex='-1' role='dialog' aria-labelledby='"+id+"Msg'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-header alert alert-danger'>" +
							"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
							"<div id='"+id+"'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'> Error: </span> " + errorMsg + "</div>" +
						"</div>" +
					"</div>" +
				"</div>";
			
			// Append error modal to body
			$(errorModal).appendTo("body");
					
			// Launch error modal
			$('#'+id).modal();
			
			// Call back when closing modal 
			$('#'+id).on('hidden.bs.modal', function (e) {
				$("body").find('#'+id).remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
		},
		isOpen: function(id) {
			return ($('#'+id).data('bs.modal') || {}).isShown;
		}
	},
	loading: {
		id: "loadingModal",
		open: function() {
			// Define loading modal
			var loadingModal = 
				"<div class='modal' id='" + this.id + "' tabindex='-1' role='dialog'>" +
					"<div class='modal-dialog' role='document' style='position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 180px; min-width: unset;'>" +
						"<div class='modal-content'>" +
							"<div class='modal-body' style='padding: 25px;'>" +
								"<div id='loader'></div>" +
							"</div>" +
						"</div>" +
					"</div>" +
				"</div>";
			
			if ($("#" + this.id).length == 0) {
				// Append loading modal to body
				$(loadingModal).appendTo("body");
				
				// Launch loading modal
				$("#" + this.id).modal({backdrop: 'static'});
			} else {
				$("#" + this.id).modal('show');
			}
		},
		close: function() {
			$('#' + this.id).modal('hide');
		}
	},
	disclaimer: {
		open: function(title, content, checkboxMsg, btnAgreeLabel, fnOnAgree, btnDeclineLabel, fnOnDecline, fnOnClose) {
			// Remove previous #disclaimerModal			
			if ($("#disclaimerModal").length > 0) {
				$("#disclaimerModal").remove();
			}
			
			// Define disclaimer modal
			var disclaimerModal = 
				"<div class='modal fade' id='disclaimerModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			disclaimerModal += 
							"<div class='modal-body'>";
							
			if (content != null) {
				disclaimerModal += 
								content;
			}
			
			if (checkboxMsg != null) {
				disclaimerModal += 
								"<div class='checkbox checkbox-bootstrap'>" +
									"<input type='checkbox' id='disclaimerCheckbox' class='disclaimerCheckbox'>" +
									"<label for='disclaimerCheckbox'>" + checkboxMsg + "</label>" +
								"</div>";
			} else {
				disclaimerModal += 
								"<div class='checkbox checkbox-bootstrap'>" +
									"<input type='checkbox' id='disclaimerCheckbox' class='disclaimerCheckbox'>" +
									"<label for='disclaimerCheckbox'>I agree</label>" +
								"</div>";
			}
			
			disclaimerModal += 
							"</div>";
			
			disclaimerModal += 			
      						"<div class='modal-footer'>";
							
			if (btnDeclineLabel != null) {
				disclaimerModal += 		
      							"<button type='button' class='btn btn-delete' id='disclaimerDeclineBtn'>" + btnDeclineLabel + "</button>";
			} else {
				disclaimerModal += 		
      							"<button type='button' class='btn btn-delete' id='disclaimerDeclineBtn'>Decline</button>";
			}
							
			if (btnAgreeLabel != null) {
				disclaimerModal += 		
      							"<button type='button' class='btn btn-primary' id='disclaimerAgreeBtn' disabled>" + btnAgreeLabel + "</button>";
			} else {
				disclaimerModal += 		
      							"<button type='button' class='btn btn-primary' id='disclaimerAgreeBtn' disabled>Agree</button>";
			}
			
			disclaimerModal += 	
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			
			// Append disclaimer modal to body
			$(disclaimerModal).appendTo("body");
					
			// Launch notification modal
			$('#disclaimerModal').modal();
			
			// Call back when closing modal 
			$('#disclaimerModal').on('hidden.bs.modal', function (e) {
				$("body").find('#disclaimerModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
			
			// Action when checking disclaimer checkbox
			$('#disclaimerCheckbox').on('change', function(e) {
				
				$('#disclaimerAgreeBtn').prop('disabled', ! $("#disclaimerCheckbox").prop("checked"));
				
			});
			
			// Action when clicking disclaimer agree button
			$('#disclaimerAgreeBtn').on('click', function(e) {
				
				$('#disclaimerModal').modal('hide');
				
				if (fnOnAgree != null && typeof fnOnAgree === "function") {
					fnOnAgree();
				}
			});
			
			// Action when clicking disclaimer decline button
			$('#disclaimerDeclineBtn').on('click', function(e) {
				
				$('#disclaimerModal').modal('hide');
				
				if (fnOnDecline != null && typeof fnOnDecline === "function") {
					fnOnDecline();
				}
			});
		}
	},	
	warning_notification: {
		open: function(title, content, btnLabel, fnOnConfirm, fnOnClose) {
			// Remove previous #notificationModal			
			if ($("#warningnotificationModal").length > 0) {
				$("#warningnotificationModal").remove();
			}
			
			// Define notification modal
			var warningnotificationModal = 
				"<div class='modal fade' id='warningnotificationModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>" +
					"<div class='modal-dialog' role='document'>" +
						"<div class='modal-content alert-warning'>" +
							"<div class='modal-header'>" +
								"<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
								"<h4 class='modal-title' id='myModalLabel'>" + title + "</h4>" +
							"</div>";
							
			if (content != null) {
				warningnotificationModal += 
							"<div class='modal-body'>" +
								content +
      						"</div>";
			}
			
			warningnotificationModal += 			
      						"<div class='modal-footer'>" +
      							"<button type='button' class='btn btn-warning' data-dismiss='modal'>Close</button>" + 
      							"<button type='button' class='btn btn-primary' id='warningconfirmBtn'>" + btnLabel + "</button>" +
      						"</div>" + 
						"</div>" +
					"</div>" + 
				"</div>";
			
			// Append notification modal to body
			$(warningnotificationModal).appendTo("body");
					
			// Launch notification modal
			$('#warningnotificationModal').modal();
			
			// Call back when closing modal 
			$('#warningnotificationModal').on('hidden.bs.modal', function (e) {
				$("body").find('#notificationModal').remove();
				
				if (fnOnClose != null && typeof fnOnClose === "function") {
					fnOnClose();
				}
			});
			
			// Action when clicking confirm button
			$('#warningconfirmBtn').on('click', function(e) {
				$('#warningnotificationModal').modal('hide');
				
				if (fnOnConfirm != null && typeof fnOnConfirm === "function") {
					fnOnConfirm();
				}
			});
		}
	},
};
