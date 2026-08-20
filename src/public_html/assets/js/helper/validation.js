var RULE_IS_REQUIRED = "isRequired";
var RULE_IS_NUMERIC = "isNumeric";
var RULE_IS_INTEGER = "isInteger";
var RULE_IS_EMAIL = "isEmail";
var RULE_IS_URL = "isURL";
var RULE_MAX_LENGTH = "maxLength";
var RULE_IS_DECIMAL = "isDecimal";	// Two parameters are required - data-before-dp, data-after-dp
var RULE_IS_ALU_DON_ID = "isAluDonId";
var RULE_BETWEEN_RANGE = "betweenRange";
var RULE_IS_YEAR = "isYear";
var RULE_IS_UPPERCASE = "isUppercase";
var RULE_IS_GROUP_REQUIRED = "isGroupRequired";
var RULE_IS_HKID_4 = "isHKID4";
var RULE_IS_PHONE_NO_MIN_8 = "isPhoneNoMin8";
var RULES_ALL = [RULE_MAX_LENGTH, RULE_IS_REQUIRED, RULE_IS_NUMERIC, RULE_IS_EMAIL, RULE_IS_URL, RULE_IS_DECIMAL, RULE_IS_ALU_DON_ID, RULE_BETWEEN_RANGE, RULE_IS_YEAR, RULE_IS_UPPERCASE, RULE_IS_GROUP_REQUIRED, RULE_IS_INTEGER, RULE_IS_HKID_4, RULE_IS_PHONE_NO_MIN_8];
// var RULE_IS_DATE = "isDate";

var FEEDBACK_TYPE_SUCCESS = "success";
var FEEDBACK_TYPE_WARNING = "warning";
var FEEDBACK_TYPE_ERROR = "error";

var MAX_LENGTH_DEFAULT = 10000;
var DATE_FOMRAT_DEFAULT = 'YYYY-MM-DD';


var validation = {
	form: {
		validate: function($form, needFocus, fnForValid, fnForInvalid) {
			var invalidCount = 0;
			var isValid = false;
			
			// Validate text input
			$.each($("#"+$form.attr("id")+" input[type=text]").get().reverse(), function (index, input) {
				validation.text.validateInputByAllRules($(input), needFocus) == false ? invalidCount++ : invalidCount;
			});
			
			// Validate textarea
			$("#"+$form.attr("id")+" textarea").each(function() {
				validation.text.validateInputByAllRules($(this), needFocus) == false ? invalidCount++ : invalidCount;
			});
			
			// Validate select
			$("#"+$form.attr("id")+" select").each(function() {
				validation.select.validateInputByAllRules($(this), needFocus) == false ? invalidCount++ : invalidCount;
			});
			
			// Validate required checkbox groups (at least one visible option must be checked)
			var requiredCheckboxGroups = {};
			$("#"+$form.attr("id")+" input[data-required-group]").each(function() {
				var groupName = $(this).attr("data-required-group");
				if (!requiredCheckboxGroups[groupName]) {
					requiredCheckboxGroups[groupName] = $([]);
				}
				requiredCheckboxGroups[groupName] = requiredCheckboxGroups[groupName].add(this);
			});
			$.each(requiredCheckboxGroups, function(groupName, $group) {
				var $visibleGroup = $group.filter(":visible");
				if (!$visibleGroup.length) {
					return;
				}

				var $feedbackTarget = $visibleGroup.first();
				validation.text.clearFeedback($feedbackTarget);
				if (!$visibleGroup.filter(":checked").length) {
					invalidCount++;
					validation.text.addFeedback($feedbackTarget, FEEDBACK_TYPE_ERROR, "<li>Required Field</li>", false);
					if (needFocus) {
						$feedbackTarget.focus();
					}
				}
			});

			// Validate split date
			$("#"+$form.attr("id")+" div.split_date").each(function() {
				validation.splitDate.validate($(this), needFocus) == false ? invalidCount++ : invalidCount;
			});
			
			// Validate split date (birth date)
			$("#"+$form.attr("id")+" div.split_birth_date").each(function() {
				validation.splitDate.validateBirthDate($(this), needFocus) == false ? invalidCount++ : invalidCount;
			});
			
			// Validate split date range
			if ($("#"+$form.attr("id")+" div.split_date_from").length && $("#"+$form.attr("id")+" div.split_date_to").length) {
				validation.splitDate.validateDateRange($("#"+$form.attr("id")+" div.split_date_from"), $("#"+$form.attr("id")+" div.split_date_to"), needFocus) == false ? invalidCount++ : invalidCount;
			}
			
			isValid = invalidCount == 0;
			
			if (isValid) {
				if (fnForValid != null && typeof fnForValid === "function") {
					fnForValid();
				}
			} else {
				if (fnForInvalid != null && typeof fnForInvalid === "function") {
					fnForInvalid();
				} else {
					modal.warn.open("Incorrect Input.");
				}
			}
		}
	},
	
	text: {
		validate: function($textInput, rules, needFocus) {
			// Define text input element
			var textInputId = $textInput.attr('id');
			var $parentFormGroup = $textInput.closest('.form-group');
			
			// Clear text input's feedback
			validation.text.clearFeedback($textInput);
			
			// Validate according to the rules
			var errorMsg = "";
			if (rules != null && rules instanceof Array && $textInput.length > 0) {
				var onPlaceHolder = false;
				
				for (i = 0; i < rules.length; i++) {
					switch(rules[i]) {
						case RULE_IS_REQUIRED:
							if ($textInput.prop('required') && $textInput.val() == "") {
								errorMsg = "<li>Required Field</li>";
								// errorMsg = $parentFormGroup.find("label:first").text() + " - Required";
								// errorMsg = errorMsg.replace("* ", "");
								// onPlaceHolder = true;
							}
						break;
						case RULE_IS_NUMERIC:
							// Only check if input value is not empty
							if ($textInput.hasClass('is_numeric') && $textInput.val().length > 0) {
							   	if (isNaN($textInput.val())) {
							      	errorMsg = "<li>Required Numeric Input</li>";
								} else {
									var greaterThan = $textInput.attr("data-greater-than");
									var atLeast = $textInput.attr("data-at-least");
									var max = $textInput.attr("data-max");
									
									if (greaterThan != null && greaterThan.length && !isNaN(greaterThan) && $textInput.val() <= greaterThan) {
							      		errorMsg = "<li>Required Numeric Input (Greater Than " + greaterThan + ")</li>";
							      	} else if (atLeast != null && atLeast.length && !isNaN(atLeast) && $textInput.val() < atLeast) {
							      		errorMsg = "<li>Required Numeric Input (At Least " + atLeast + ")</li>";
							      	} else if (max != null && max.length && !isNaN(max) && parseInt($textInput.val()) > parseInt(max)) {
										errorMsg = "<li>Required Numeric Input (Maximum " + max + ")</li>";
									} 
								}
							}
						break;
						case RULE_IS_INTEGER:
							if ($textInput.hasClass('is_integer') && $textInput.val().length > 0) {
							   	if (isNaN($textInput.val()) || parseInt($textInput.val()).toString() !== $textInput.val()) {
							      	errorMsg = "<li>Required Integer Input</li>";
								} else {
									var greaterThan = $textInput.attr("data-greater-than");
									var atLeast = $textInput.attr("data-at-least");
									var max = $textInput.attr("data-max");
									
									if (greaterThan != null && greaterThan.length && !isNaN(greaterThan) && $textInput.val() <= greaterThan) {
							      		errorMsg = "<li>Required Integer Input (Greater Than " + greaterThan + ")</li>";
							      	} else if (atLeast != null && atLeast.length && !isNaN(atLeast) && $textInput.val() < atLeast) {
							      		errorMsg = "<li>Required Integer Input (At Least " + atLeast + ")</li>";
							      	}  else if (max != null && max.length && !isNaN(max) && parseInt($textInput.val()) > parseInt(max)) {
										errorMsg = "<li>Required Numeric Input (Maximum " + max + ")</li>";
									} 
								}
							}
						break;
						case RULE_IS_EMAIL:
							// Only check if input value is not empty
							if ($textInput.hasClass('is_email') && $textInput.val().length > 0) {
								var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;   
							   	if (regex.test($textInput.val()) == false) {      	
							      	errorMsg = "<li>Required E-mail Format</li>";
								}
							}
						break;
						case RULE_IS_URL:
							if ($textInput.hasClass('is_url') && $textInput.val().length > 0) {
							   	if (!($textInput.val().match("^http://") || $textInput.val().match("^https://"))) {
							   		errorMsg = '<li>Required URL Format (Start with "http://" or "https://")</li>';
								}
							}
						break;
						case RULE_MAX_LENGTH:
							var maxLength = $textInput.attr("maxlength") != null ? $textInput.attr("maxlength") : MAX_LENGTH_DEFAULT;
							if ($textInput.val().length > maxLength) {
						   		errorMsg = "<li>Maximum allow " + maxLength + " character(s)</li>";
							}
						break;
						case RULE_IS_DECIMAL:
							if ($textInput.hasClass('is_decimal') && $textInput.val().length > 0) {
								var beforeDecimalPt = $textInput.attr("data-before-dp");
								var afterDecimalPt = $textInput.attr("data-after-dp");
								
								if (! (beforeDecimalPt == null && afterDecimalPt == null)) {
									var regex = new RegExp("^\\d{1," + beforeDecimalPt + "}(\\.\\d{1," + afterDecimalPt + "})?$");
									
									// Allow positive or negative value
									var val = $textInput.val();
									val = val.startsWith("-") ? val.substring(1) : val;
									
									if (regex.test(val) == false) {     	
								      	errorMsg = "<li>Required Decimal Format (" + beforeDecimalPt + ", " + afterDecimalPt + ")</li>";
									}
								}
							}
						break;
						case RULE_IS_ALU_DON_ID:
							if ($textInput.hasClass('is_alu_don_id') && $textInput.val().length > 0) {
								var adType = $textInput.attr("data-ad-type") == null ? "" : $textInput.attr("data-ad-type");
								var regex = "";
								switch (adType) {
									case "1":	// Individual
										regex = /^([0-9]|X|H){1}\d+$/;   
									   	if (regex.test($textInput.val()) == false) {      	
									      	errorMsg = "<li>Required Alumni / Donor ID Format (Prefix: donor = X, hon. Doc./Fellow = H)</li>";
										}
									break;
									case "all": default:
										regex = /^([0-9]|X38|H|AA|G){1}\d+$/;   
									   	if (regex.test($textInput.val()) == false) {      	
									      	errorMsg = "<li>Required Alumni / Donor ID Format (Prefix: donor = X38, hon. Doc./Fellow = H, alumni assocuation = AA, alumni group = G)</li>";
										}
									break;
								}
							}
						break;
						case RULE_BETWEEN_RANGE:
							if ($textInput.hasClass('between_range') && $textInput.val().length > 0) {
								var min = $textInput.attr("data-min") == null ? "" : $textInput.attr("data-min");
								var max = $textInput.attr("data-max") == null ? "" : $textInput.attr("data-max");
								
								if (parseFloat($textInput.val()) < parseFloat(min) || parseFloat($textInput.val()) > parseFloat(max)) {
							   		errorMsg = "<li>Require Range Between (" + min + " - " + max + ")</li>";
								}
							}
						break;
						case RULE_IS_YEAR:
							if ($textInput.hasClass('is_year') && $textInput.val().length > 0) {
								if ($textInput.val() != "" && (isNaN($textInput.val()) || $textInput.val() < 1900)) {
									errorMsg = "<li>Incorrect Year Format</li>";
								}
							}
						break;
						case RULE_IS_UPPERCASE:
							if ($textInput.hasClass('is_uppercase') && $textInput.val().length > 0) 
							{
								var str = $textInput.val();
								if(str !== str.toUpperCase())
								{
									errorMsg = "<li>Required Uppercase Alphabet</li>";
								}
							}
						break;
						case RULE_IS_GROUP_REQUIRED:
							// check the text group that has at least one filled
							if ($textInput.hasClass('txt_group_required')) 
							{
								var validate_pass = false;
								var text_group_number = $textInput.attr("data-txtGroupRequired");
								
								$("input[data-txtGroupRequired='"+text_group_number+"']").each(function(){
									
									if($(this).val() != "" && $(this).val() != null)
									{
										validate_pass = true;
									}
								});
								
								if(!validate_pass)
								{
									errorMsg = "<li>Required at least one information</li>";
								}
								if (errorMsg != '') {
									$("input[data-txtGroupRequired='"+text_group_number+"']").each(function(){
										validation.text.addFeedback($(this), FEEDBACK_TYPE_ERROR, errorMsg, onPlaceHolder);
									});
									
									if (needFocus) {
										$textInput.focus();
									}
									
								}
								else
								{
									$("input[data-txtGroupRequired='"+text_group_number+"']").each(function(){
										validation.text.clearFeedback($(this));
									});
								}
							}
						break;
						case RULE_IS_HKID_4:
							if ($textInput.hasClass('is_hkid_4') && $textInput.val().length > 0) {
								var regex = /^([a-zA-Z0-9]){4}$/;    
							   	if (regex.test($textInput.val()) == false) {      	
							      	errorMsg = "<li>Required 4 digits / alphabets with no special characters</li>";
								}
							}
						break;
						case RULE_IS_PHONE_NO_MIN_8:
							if ($textInput.hasClass('is_phone_no_min_8') && $textInput.val().length > 0) {
								var regex = /^([0-9()\+\*\/\-\ ]){8,50}$/;    
							   	if (regex.test($textInput.val()) == false) {      	
							      	errorMsg = "<li>Invalid input. Required at least 8 characters long. Accept only numbers, and special characters including <strong>( ) + / * -</strong></li>";
								}
							}
						break;
						// case RULE_IS_DATE:
							// if ($textInput.val().length > 0) {
								// var momentDate = moment($textInput.val(), DATE_FOMRAT_DEFAULT);
								// var jsDate = momentDate.toDate();
// 								
								// if (jsDate == "Invalid Date") {
							   		// errorMsg = "<li>Incorrect Date Format</li>";
								// }
							// }
						// break;
					}					
					
					if (errorMsg != '') {
						validation.text.addFeedback($textInput, FEEDBACK_TYPE_ERROR, errorMsg, onPlaceHolder);
						if (needFocus) {
							$textInput.focus();
						}
						break;
					}
				}
			}
			
			return errorMsg == "";
		},
		validateInputByAllRules: function($textInput, needFocus) {
			return validation.text.validate($textInput, RULES_ALL, needFocus);
		},
		// validateForm: function($form, needFocus, fnForValid, fnForInvalid) {
			// var invalidCount = 0;
			// var isValid = false;
// 			
			// // Validate text input
			// $.each($("#"+$form.attr("id")+" input[type=text]").get().reverse(), function (index, input) {
				// validation.text.validateInputByAllRules($(input), needFocus) == false ? invalidCount++ : invalidCount;
			// });
// 			
			// // Validate textarea
			// $("#"+$form.attr("id")+" textarea").each(function() {
				// validation.text.validateInputByAllRules($(this), needFocus) == false ? invalidCount++ : invalidCount;
			// });
			// isValid = invalidCount == 0;
// 			
			// if (isValid) {
				// if (fnForValid != null && typeof fnForValid === "function") {
					// fnForValid();
				// }
			// } else {
				// if (fnForInvalid != null && typeof fnForInvalid === "function") {
					// fnForInvalid();
				// } else {
					// modal.warn.open("Incorrect Input.");
				// }
			// }
		// },
		// validateDateRange: function($textInputFromDate, $textInputToDate, needFocus) {
			// // Define text input element
			// var $textInputFromDateId = $textInputFromDate.attr('id');
			// var $fromDateParentFormGroup = $textInputFromDate.closest('.form-group');
// 			
			// var textInputToDateId = $textInputToDate.attr('id');
			// var $toDateParentFormGroup = $textInputToDate.closest('.form-group');
// 			
			// var errorMsg = "";
			// var onPlaceHolder = false;
// 			
			// // Clear text input's feedback
			// validation.text.clearFeedback($textInputFromDate);
			// validation.text.clearFeedback($textInputToDate);
// 			
			// // Validate fromDate and toDate
			// validation.text.validate($textInputFromDate, [RULE_IS_DATE], false);
			// validation.text.validate($textInputToDate, [RULE_IS_DATE], false);
// 			
			// if ($textInputFromDate.val() != "" && $textInputToDate.val() != "") {
				// var momentFromDate = moment($textInputFromDate.val(), DATE_FOMRAT_DEFAULT);
				// var momentToDate = moment($textInputToDate.val(), DATE_FOMRAT_DEFAULT);
// 				
				// // Check if fromDate is before toDate
				// if (momentFromDate > momentToDate) {
					// errorMsg = "<li>Incorrect date range</li>";
				// }				
// 				
				// if (errorMsg != '') {
					// validation.text.addFeedback($textInputFromDate, FEEDBACK_TYPE_ERROR, errorMsg, onPlaceHolder);
					// validation.text.addFeedback($textInputToDate, FEEDBACK_TYPE_ERROR, errorMsg, onPlaceHolder);
					// if (needFocus) {
						// $textInputFromDate.focus();
					// }
				// }
			// }
		// },
		
		addFeedback: function($textInput, feedbackType, feedbackMsg, onPlaceHolder) {
			// Check if it is correct feedbackType
			if ( ! (feedbackType == FEEDBACK_TYPE_SUCCESS || feedbackType == FEEDBACK_TYPE_WARNING || feedbackType == FEEDBACK_TYPE_ERROR)) {
				console.debug("addFeedbackToTextInput - Incorrect feebackType[" + feedbackType + "]");
				return;
			}
			
			// Define variables
			var textInputId = $textInput.attr('id');
			var $textInputParent = !$textInput.parent().hasClass("input-group") ? $textInput.parent() : $textInput.parent().parent();
			var describeBlockId = "describe_block_" + textInputId;
			var iconClass = "";
			switch (feedbackType) {
				case FEEDBACK_TYPE_SUCCESS: iconClass = "glyphicon-ok"; break;
				case FEEDBACK_TYPE_WARNING: iconClass = "glyphicon-warning-sign"; break;
				case FEEDBACK_TYPE_ERROR: iconClass = "glyphicon-remove"; break;
			}
			
			if ($textInput.length) {
				// Define "aria-describedby" if attr is not exist
				var attr = $textInput.attr("aria-describedby");
				
				if ( ! (typeof attr !== typeof undefined && attr !== false)) {
					$textInput.attr("aria-describedby", describeBlockId);
				}
				
				$textInputParent.addClass("has-feedback");
				$textInputParent.addClass("has-" + feedbackType);
				
				// Do not need to show the icon if the text input is within "input-group"
				if (!$textInputParent.children().hasClass("input-group")) {
					$textInputParent.append(
						"<span class='glyphicon " + iconClass + " form-control-feedback' aria-hidden='true'></span>" +
						"<span id='" + describeBlockId + "' class='sr-only'>(" + feedbackType + ")</span>"
					);
				}
				
				if (feedbackMsg != null && feedbackMsg != '') {
					if (onPlaceHolder) {
						$textInput.attr('placeholder', feedbackMsg);
					} else {
						// Hide help block if it is exist
						if ($textInputParent.find(".help-block").length) {
							$textInputParent.find(".help-block").hide();
						}
						
						if (!$textInputParent.hasClass("input-group")) {
							$textInputParent.append(
								"<span id='" + describeBlockId + "' class='help-block feedback-msg'>" + feedbackMsg + "</span>"
							);
						} else {
							$textInputParent.parent().addClass("has-feedback");
							$textInputParent.parent().append(
								"<span id='" + describeBlockId + "' class='help-block feedback-msg'>" + feedbackMsg + "</span>"
							);
						}
					}
				}
			}
		},
						
		clearFeedback: function($textInput) {
			// Define variables
			var $textInputParent = !$textInput.parent().hasClass("input-group") ? $textInput.parent() : $textInput.parent().parent();
			
			if ($textInput.length) {
				// Remove "aria-describedby" if attr is not exist
				var attr = $textInput.attr("aria-describedby");
				if (typeof attr !== typeof undefined && attr !== false) {
					$textInput.removeAttr("aria-describedby");
				}
				
				// Remove "has-feedback" if exist
				if ($textInputParent.hasClass("has-feedback")) {
					$textInputParent.removeClass("has-feedback");
				}
				// Remove "has-success" if exist
				if ($textInputParent.hasClass("has-success")) {
					$textInputParent.removeClass("has-success");
				}
				// Remove "has-warning" if exist
				if ($textInputParent.hasClass("has-warning")) {
					$textInputParent.removeClass("has-warning");
				}
				// Remove "has-error" if exist
				if ($textInputParent.hasClass("has-error")) {
					$textInputParent.removeClass("has-error");
				}
				
				// Remove two added span elements
				if ($textInputParent.children("span.form-control-feedback").length) {
					$textInputParent.children("span.form-control-feedback").remove();
				}
				if ($textInputParent.children("span.sr-only").length) {
					$textInputParent.children("span.sr-only").remove();
				}
				
				// Remove feedback message
				if ($textInputParent.children("span.feedback-msg").length) {
					$textInputParent.children("span.feedback-msg").remove();
				}
				
				// Show help block if it is hidden
				if ($textInputParent.find(".help-block").length) {
					$textInputParent.find(".help-block").show();
				}
				
				// Set the placeholder according to label
				// var oriLabel = $textInputParent.prev("label").text().replace("* ", "");
				// $textInput.attr('placeholder', oriLabel);
			}
		},
		
		clearAllFeedback: function() {
			$('input[type=text]').each(function(){
				validation.text.clearFeedback($(this));
			});
			
			$('textarea').each(function(){
				validation.text.clearFeedback($(this));
			});
		}
		
	},
	
	radio: {
		validate: function($radio, rules, needFocus) {
			// Define radio button element
			var radioName = $radio.attr('name');
			var $parentRadioGroup = $radio.parent().closest(".radio-group");
			
			// Clear radio button's feedback
			validation.radio.clearFeedback($radio);
			
			// Validate according to the rules
			if (rules != null && rules instanceof Array) {
				var errorMsg = "";
				for (i = 0; i < rules.length; i++) {
					switch(rules[i]) {
						case RULE_IS_REQUIRED:
							if (! $radio.is(':checked')) {
								errorMsg = $parentRadioGroup.find("label[for='" + radioName + "']").text() + " - Required to select one";
							}
						break;
					}					
					
					if (errorMsg != '') {
						validation.radio.addFeedback($radio, FEEDBACK_TYPE_ERROR, errorMsg);
						if (needFocus) {
							$radio.first().focus();
						}
						break;
					}
				}
			}
			return errorMsg == '';
		},
		
		addFeedback: function($radio, feedbackType, feedbackMsg) {
			// Check if it is correct feedbackType
			if ( ! (feedbackType == FEEDBACK_TYPE_SUCCESS || feedbackType == FEEDBACK_TYPE_WARNING || feedbackType == FEEDBACK_TYPE_ERROR)) {
				console.debug("addFeedbackToRadio - Incorrect feebackType[" + feedbackType + "]");
				return;
			}
			
			// Define variables
			var radioName = $radio.attr('name');
			var $parentRadioGroup = $radio.parent().closest(".radio-group");
			var describeBlockId = "describe_block_" + radioName;
			var iconClass = "";
			switch (feedbackType) {
				case FEEDBACK_TYPE_SUCCESS: iconClass = "glyphicon-ok"; break;
				case FEEDBACK_TYPE_WARNING: iconClass = "glyphicon-warning-sign"; break;
				case FEEDBACK_TYPE_ERROR: iconClass = "glyphicon-remove"; break;
			}
			
			if ($radio.length) {
				// Define "aria-describedby" if attr is not exist
				var attr = $parentRadioGroup.attr("aria-describedby");
				if ( ! (typeof attr !== typeof undefined && attr !== false)) {
					$parentRadioGroup.attr("aria-describedby", describeBlockId);
				}
				
				$parentRadioGroup.addClass("has-feedback");
				$parentRadioGroup.addClass("has-" + feedbackType);
				
				if (feedbackMsg != null && feedbackMsg != '') {
					// Hide help block if it is exist
					// if ($parentRadioGroup.find(".help-block").length) {
						// $parentRadioGroup.find(".help-block").hide();
					// }
					
					// $parentRadioGroup.append(
						// "<span id='" + describeBlockId + "' class='help-block feedback-msg'>" + feedbackMsg + "</span>"
					// );
				}
			}
		},
		
		clearFeedback: function($radio) {
			// Define variables
			var $parentRadioGroup = $radio.parent().closest(".radio-group");
			
			if ($radio.length) {
				// Remove "aria-describedby" if attr is not exist
				var attr = $parentRadioGroup.attr("aria-describedby");
				if (typeof attr !== typeof undefined && attr !== false) {
					$parentRadioGroup.removeAttr("aria-describedby");
				}
				
				// Remove "has-feedback" if exist
				if ($parentRadioGroup.hasClass("has-feedback")) {
					$parentRadioGroup.removeClass("has-feedback");
				}
				// Remove "has-success" if exist
				if ($parentRadioGroup.hasClass("has-success")) {
					$parentRadioGroup.removeClass("has-success");
				}
				// Remove "has-warning" if exist
				if ($parentRadioGroup.hasClass("has-warning")) {
					$parentRadioGroup.removeClass("has-warning");
				}
				// Remove "has-error" if exist
				if ($parentRadioGroup.hasClass("has-error")) {
					$parentRadioGroup.removeClass("has-error");
				}
				
				// Remove feedback message
				// if ($parentRadioGroup.children("span.feedback-msg").length) {
					// $parentRadioGroup.children("span.feedback-msg").remove();
				// }
				
				// Show help block if it is hidden
				// if ($parentRadioGroup.find(".help-block").length) {
					// $parentRadioGroup.find(".help-block").show();
				// }
			}
		},
		
		clearAllFeedback: function() {
			$('input[type=radio]').each(function() {
				validation.radio.clearFeedback($(this));
			});
		}
	},
	
	select: {
		validate: function($select, rules, needFocus) {
			
			// Define select element
			var selectName = $select.attr('name');
			var selectId = $select.attr('id');
			
			// Clear select's feedback
			validation.select.clearFeedback($select);
			
			// Validate according to the rules
			if (rules != null && rules instanceof Array) {
				var errorMsg = "";
				for (i = 0; i < rules.length; i++) {
					switch(rules[i]) {
						case RULE_IS_REQUIRED:
							if ($select.prop('required') && $("#" + selectId + " option:selected").val() == "") {
								errorMsg = "<li>Required Field</li>";
							}
						break;
					}					
					
					if (errorMsg != '') {
						validation.select.addFeedback($select, FEEDBACK_TYPE_ERROR, errorMsg);
						if (needFocus) {
							$select.focus();
						}
						break;
					}
				}
			}
			return errorMsg == '';
		},
		
		validateInputByAllRules: function($select, needFocus) {
			return validation.select.validate($select, [RULE_IS_REQUIRED], needFocus);
		},
		
		addFeedback: function($select, feedbackType, feedbackMsg) {
			// Check if it is correct feedbackType
			if ( ! (feedbackType == FEEDBACK_TYPE_SUCCESS || feedbackType == FEEDBACK_TYPE_WARNING || feedbackType == FEEDBACK_TYPE_ERROR)) {
				console.debug("addFeedbackToSelect - Incorrect feebackType[" + feedbackType + "]");
				return;
			}
			
			// Define variables
			var selectId = $select.attr('id');
			var $selectParent = $select.parent();
			var describeBlockId = "describe_block_" + selectId;
			var iconClass = "";
			switch (feedbackType) {
				case FEEDBACK_TYPE_SUCCESS: iconClass = "glyphicon-ok"; break;
				case FEEDBACK_TYPE_WARNING: iconClass = "glyphicon-warning-sign"; break;
				case FEEDBACK_TYPE_ERROR: iconClass = "glyphicon-remove"; break;
			}
			
			if ($select.length) {
				// Define "aria-describedby" if attr is not exist
				var attr = $select.attr("aria-describedby");
				
				if ( ! (typeof attr !== typeof undefined && attr !== false)) {
					$select.attr("aria-describedby", describeBlockId);
				}
				
				$selectParent.addClass("has-feedback");
				$selectParent.addClass("has-" + feedbackType);
				
				if (feedbackMsg != null && feedbackMsg != '') {
					
					// Hide help block if it is exist
					if ($selectParent.find(".help-block").length) {
						$selectParent.find(".help-block").hide();
					}
					
					if (!$selectParent.hasClass("select-group")) {
						$selectParent.append(
							"<span id='" + describeBlockId + "' class='help-block feedback-msg'>" + feedbackMsg + "</span>"
						);
					} else {
						$selectParent.parent().addClass("has-feedback");
						$selectParent.parent().append(
							"<span id='" + describeBlockId + "' class='help-block feedback-msg'>" + feedbackMsg + "</span>"
						);
					}
					
				}
			}
		},
		
		clearFeedback: function($select) {
			
			var $selectParent = $select.parent();
			
			if ($select.length) {
				// Remove "aria-describedby" if attr is not exist
				var attr = $selectParent.attr("aria-describedby");
				if (typeof attr !== typeof undefined && attr !== false) {
					$selectParent.removeAttr("aria-describedby");
				}
				
				// Remove "has-feedback" if exist
				if ($selectParent.hasClass("has-feedback")) {
					$selectParent.removeClass("has-feedback");
				}
				// Remove "has-success" if exist
				if ($selectParent.hasClass("has-success")) {
					$selectParent.removeClass("has-success");
				}
				// Remove "has-warning" if exist
				if ($selectParent.hasClass("has-warning")) {
					$selectParent.removeClass("has-warning");
				}
				// Remove "has-error" if exist
				if ($selectParent.hasClass("has-error")) {
					$selectParent.removeClass("has-error");
				}
				
				// Remove feedback message
				if ($selectParent.children("span.feedback-msg").length) {
					$selectParent.children("span.feedback-msg").remove();
				}
				
				// Show help block if it is hidden
				if ($selectParent.find(".help-block").length) {
					$selectParent.find(".help-block").show();
				}
			}
		},
		
		clearAllFeedback: function() {
			$('select').each(function() {
				validation.select.clearFeedback($(this));
			});
		}
	},
	
	splitDate: {
		// RULE_DAY_FORMAT: "check_day_format",
		// RULE_MONTH_FORMAT: "check_month_format",
		// RULE_YEAR_FORMAT: "check_year_format",
		// RULE_IS_DAY_INPUT: "is_day_input",
		// RULE_IS_MONTH_INPUT: "is_month_input",
		// RULE_IS_VALID_DATE: "is_valid_date",
		
		
		RULE_FORMAT_BIRTH_DATE: "check_birth_date_format",
		RULE_FORMAT_DAY: "check_day_format",
		RULE_FORMAT_MONTH: "check_month_format",
		RULE_FORMAT_YEAR: "check_year_format",
		
		validateBirthDate: function($wrapper, needFocus) {
			rules = [this.RULE_BIRTH_DATE];
			return validation.splitDate.validate($wrapper, needFocus, rules);
		},
		
		validate: function($wrapper, needFocus, rules) {
			
			// Define variable
			// rules = [this.RULE_DAY_FORMAT, this.RULE_MONTH_FORMAT, this.RULE_YEAR_FORMAT, this.RULE_IS_DAY_INPUT, this.RULE_IS_MONTH_INPUT, this.RULE_IS_VALID_DATE];
			
			if (rules == null) {
				// Set default rules
				rules = [this.RULE_FORMAT_YEAR, this.RULE_FORMAT_MONTH, this.RULE_FORMAT_DAY];
			}
			
			$year = $wrapper.find(".is_year");
			$month = $wrapper.find(".is_month");
			$day = $wrapper.find(".is_day");
			
			// // Clear feedback
			validation.splitDate.clearFeedback($wrapper);
			
			// Validate according to the rules
			if (rules != null && rules instanceof Array) {
				var errorMsg = "";
				for (i = 0; i < rules.length; i++) {
					switch(rules[i]) {
						case this.RULE_BIRTH_DATE:
							// Accepted format Y-M-D, Y-M, M-D, Y
							if ($year.val() != "" || $month.val() != "" || $day.val() != "") {
								if (
									($year.val() != "" && $month.val() != "" && $day.val() != "") ||
									($year.val() != "" && $month.val() != "" && $day.val() == "") ||
									($year.val() == "" && $month.val() != "" && $day.val() != "") || 
									($year.val() != "" && $month.val() == "" && $day.val() == "")
								) {
									var year = $year.val() == "" ? 1900 : $year.val();
									var month = $month.val() == "" ? 1 : $month.val();
									var day = $day.val() == "" ? 1 : $day.val();
									var m = moment(year + "-" + month + "-" + day, 'YYYY-M-D', true);
									
									if ( ! m.isValid() || year > new Date().getFullYear()) {
										errorMsg = "<li>Incorrect Birth Date Format</li>";
									}
								} else {
									errorMsg = "<li>Incorrect Birth Date Format</li>";
								}
							}
						break;
						
						case this.RULE_FORMAT_YEAR:
							if ($year.val() != "" && (isNaN($year.val()) || ($year.val() < 1900 && $year.val() > 3000))) {
								errorMsg = "<li>Incorrect Year Format</li>";
							}
						break;
						
						case this.RULE_FORMAT_MONTH:
							if ($month.val() != "" && (isNaN($month.val()) || ($month.val() < 1 || $month.val() > 12))) {
								errorMsg = "<li>Incorrect Month Format</li>";
							}
						break;
						
						case this.RULE_FORMAT_DAY:
							if ($day.val() != "") {
								var year = $year.val() == "" ? 1900 : $year.val();
								var month = $month.val() == "" ? 1 : $month.val();
								var m = moment(year + "-" + month + "-" + $day.val(), 'YYYY-M-D', true);
								
								// console.debug(year + "-" + month + "-" + $day.val());
								// console.debug(m.isValid());
								
								if ( ! m.isValid()) {
									errorMsg = "<li>Incorrect Day Format</li>";
								}
							}
						break;
						
						// case this.RULE_DAY_FORMAT:
							// if ($day.val() != "" && (isNaN($day.val()) || ($day.val() < 1 || $day.val() > 31))) {
								// errorMsg = "<li>Incorrect Day Format</li>";
							// }
						// break;
						// case this.RULE_MONTH_FORMAT:
							// if ($month.val() != "" && (isNaN($month.val()) || ($month.val() < 1 || $month.val() > 12))) {
								// errorMsg = "<li>Incorrect Month Format</li>";
							// }
						// break;
						// case this.RULE_YEAR_FORMAT:
							// if ($year.val() != "" && (isNaN($year.val()) || $year.val() < 1900)) {
								// errorMsg = "<li>Incorrect Year Format</li>";
							// }
						// break;
						// case this.RULE_IS_DAY_INPUT:
							// if ($day.val() != "" && ($month.val() == "" || $year.val() == "")) {
								// errorMsg = "<li>Please Input Year And Month</li>";
							// }
						// break;
						// case this.RULE_IS_MONTH_INPUT:
							// if ($month.val() != "" && $year.val() == "") {
								// errorMsg = "<li>Please Input Year</li>";
							// }
						// break;
						// case this.RULE_IS_VALID_DATE:
							// if ($year.val() != "" && $month.val() != "" && $day.val() != "") {
								// $dateStr = $year.val() + "-" + $month.val() + "-" + $day.val();
								// var momentDate = moment($dateStr, DATE_FOMRAT_DEFAULT);
								// if (!momentDate.isValid()) {
									// errorMsg = "<li>Invalid Date</li>";
								// }
							// }
						// break;
					}					
					
					if (errorMsg != '') {
						validation.splitDate.addFeedback($wrapper, FEEDBACK_TYPE_ERROR, errorMsg);
						if (needFocus) {
							$wrapper.focus();
						}
						break;
					}
				}
			}
			return errorMsg == '';
		},
		
		addFeedback: function($wrapper, feedbackType, feedbackMsg) {
			// Check if it is correct feedbackType
			if ( ! (feedbackType == FEEDBACK_TYPE_SUCCESS || feedbackType == FEEDBACK_TYPE_WARNING || feedbackType == FEEDBACK_TYPE_ERROR)) {
				console.debug("addFeedbackToSelect - Incorrect feebackType[" + feedbackType + "]");
				return;
			}
			
			// Define variables
			var wrapperClass = $wrapper.attr('class');
			var describeBlockId = "describe_block_" + wrapperClass;
			
			var iconClass = "";
			switch (feedbackType) {
				case FEEDBACK_TYPE_SUCCESS: iconClass = "glyphicon-ok"; break;
				case FEEDBACK_TYPE_WARNING: iconClass = "glyphicon-warning-sign"; break;
				case FEEDBACK_TYPE_ERROR: iconClass = "glyphicon-remove"; break;
			}
			
			if ($wrapper.length) {
				// Define "aria-describedby" if attr is not exist
				var attr = $wrapper.attr("aria-describedby");
				
				if ( ! (typeof attr !== typeof undefined && attr !== false)) {
					$wrapper.attr("aria-describedby", describeBlockId);
				}
				
				$wrapper.addClass("has-feedback");
				$wrapper.addClass("has-" + feedbackType);
				
				if (feedbackMsg != null && feedbackMsg != '') {
					// Hide help block if it is exist
					if ($wrapper.find(".help-block").length) {
						$wrapper.find(".help-block").hide();
					}
					
					$wrapper.append(
						"<span id='" + describeBlockId + "' class='help-block feedback-msg'>" + feedbackMsg + "</span>"
					);
				}
			}
		},
		
		clearFeedback: function($wrapper) {
			
			if ($wrapper.length) {
				// Remove "aria-describedby" if attr is not exist
				var attr = $wrapper.attr("aria-describedby");
				if (typeof attr !== typeof undefined && attr !== false) {
					$wrapper.removeAttr("aria-describedby");
				}
				
				// Remove "has-feedback" if exist
				if ($wrapper.hasClass("has-feedback")) {
					$wrapper.removeClass("has-feedback");
				}
				// Remove "has-success" if exist
				if ($wrapper.hasClass("has-success")) {
					$wrapper.removeClass("has-success");
				}
				// Remove "has-warning" if exist
				if ($wrapper.hasClass("has-warning")) {
					$wrapper.removeClass("has-warning");
				}
				// Remove "has-error" if exist
				if ($wrapper.hasClass("has-error")) {
					$wrapper.removeClass("has-error");
				}
				
				// Remove feedback message
				if ($wrapper.children("span.feedback-msg").length) {
					$wrapper.children("span.feedback-msg").remove();
				}
				
				// Show help block if it is hidden
				if ($wrapper.find(".help-block").length) {
					$wrapper.find(".help-block").show();
				}
			}
		},
		
		clearAllFeedback: function() {
			$('div.split_date').each(function() {
				validation.splitDate.clearFeedback($(this));
			});
		},
		
		validateDateRange: function($fromDateWrapper, $toDateWrapper, needFocus) {
			
			var errorMsg = "";
			var isValidFromDate = this.validate($fromDateWrapper, false);
			var isValidToDate = this.validate($toDateWrapper, false);
			
			if (isValidFromDate && isValidToDate) {
				var fromYear = $fromDateWrapper.find(".is_year").val();
				var fromMonth = $fromDateWrapper.find(".is_month").val();
				var fromDay = $fromDateWrapper.find(".is_day").val();
				
				var toYear = $toDateWrapper.find(".is_year").val();
				var toMonth = $toDateWrapper.find(".is_month").val();
				var toDay = $toDateWrapper.find(".is_day").val();
				
				var fromDateStr = "";
				var momentFromDate;
				var toDateStr = "";
				var momentToDate;
				
				if (fromYear != '' && fromMonth != '' && fromDay != '' && toYear != '' && toMonth != '' && toDay != '') {
					// Compare YYYY-MM-DD
					fromDateStr = fromYear + "-" + fromMonth + "-" + fromDay;
					toDateStr = toYear + "-" + toMonth + "-" + toDay;
				} else if (fromYear != '' && fromMonth != '' && toYear != '' && toMonth != '') {
					// Compare YYYY-MM-XX
					fromDateStr = fromYear + "-" + fromMonth + "-1";
					toDateStr = toYear + "-" + toMonth + "-1";
				} else if (fromYear != '' && toYear != '') {
					// Compare YYYY-XX-XX
					fromDateStr = fromYear + "-1-1";
					toDateStr = toYear + "-1-1";
				}
				
				momentFromDate = moment(fromDateStr, DATE_FOMRAT_DEFAULT);
				momentToDate = moment(toDateStr, DATE_FOMRAT_DEFAULT);
				if (momentFromDate.isAfter(momentToDate)) {
					errorMsg = "<li>Incorrect Date Range</li>";
				}
				
				if (errorMsg != '') {
					validation.splitDate.addFeedback($fromDateWrapper, FEEDBACK_TYPE_ERROR, errorMsg);
					validation.splitDate.addFeedback($toDateWrapper, FEEDBACK_TYPE_ERROR, errorMsg);
					if (needFocus) {
						$fromDateWrapper.focus();
					}
				}
			}
			
			return errorMsg == '';
		}
	}
	
};