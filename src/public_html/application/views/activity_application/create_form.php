<form id="<?= $form_id ?>_create_sa" class="form-horizontal" action="<?= base_url().$module_json_api_path ?>/create_activity">
<div class="row">
	<div class="col-md-12">

		<div class="form-group">
			<label for="quality" class="col-sm-2 control-label"><span class="required">* </span>Activity Content</label>
			<div class="col-sm-10">
				<?php foreach ($quality as $quality_row): ?>
					<div class="checkbox col-sm-4">
						<label>
							<input type="checkbox" name="quality[]" value="<?= $quality_row->id ?>" data-required-group="quality">
							<?= $quality_row->name ?>
						</label>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<hr>

<h3>Activity Details</h3>
<div class="row space_bottom_btn">
	<div class="col-md-12">
		<fieldset class="fieldset-default" style="margin-bottom: 15px;">
			<legend class="legend-default">ABC Secondary School</legend>
			<div class="form-group">
				<label for="organiser_dept" class="col-sm-2 control-label"><span class="required">* </span>ABC Secondary School Organiser Department
				<a data-toggle="tooltip" data-placement="bottom" title="The organiser must be a University department/office/unit. Student organisations and external parties are not accepted as organisers of activity programmes. The organiser is usually expected to arrange department staff member(s) to stay on-site during the programme for management." onclick="return false;"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
				</label>
				<div class="col-sm-10">
					<select id="organiser_dept" name="organiser_dept" class="form-control" required><option value="">-- Select --</option><option value="CHINESE">Chinese Department</option><option value="ENGLISH">English Department</option><option value="MATH">Math Department</option><option value="SCIENCE">Science Department</option></select>
				</div>
			</div>

			<div class="form-group">
				<label for="co_organiser_dept" class="col-sm-2 control-label">ABE Secondary School Co-organiser Department</label>
				<div class="col-sm-10">
					<select id="co_organiser_dept" name="co_organiser_dept[]" class="form-control" multiple="multiple">
						<?php foreach ($co_organiser_dept as $row): ?>
							<option value="<?= $row->id ?>" title="<?= $row->name ?>"><?= $row->name ?></option>
						<?php endforeach; ?>
					</select>
					<input type="hidden" id="co_organiser_dept_ids" name="co_organiser_dept_ids">
					<p class="help-block">You can search for the department</p>
				</div>
			</div>

			<div class="form-group">
                <label for="co_organiser_society" class="col-sm-2 control-label">ABE Secondary School Co-organiser</label>
                <div class="col-sm-10">
                    <select id="co_organiser_society" name="co_organiser_society[]" class="form-control" multiple="multiple">
                        <?php foreach ($co_organiser_society as $org_type_desc => $org_arr): ?>
                            <optgroup label="<?= $org_type_desc ?>">
                            <?php foreach ($org_arr as $row): ?>
                                <option value="<?= $row->id ?>" title="<?= $row->name ?>"><?= $row->name ?></option>
                            <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" id="co_organiser_society_ids" name="co_organiser_society_ids">
					<p class="help-block">More than one co-organiser is allowed.</p>
                </div>
            </div>
		</fieldset>
		
		<div class="form-group">
			<label for="title" class="col-sm-2 control-label"><span class="required">* </span>Activity Name (English)
			<a data-toggle="tooltip" data-placement="bottom" title="Please do not use identical programme title for similar programmes/sessions to be held within a short period of time to avoid confusion of students." onclick="return false;"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
			</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="title" name="title" maxlength="500" placeholder="Activity Name (English)" required>
			</div>
			<label for="title_chi" class="col-sm-2 control-label">Activity Name (Chinese)</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="title_chi" name="title_chi" maxlength="500" placeholder="Activity Name (Chinese)">
			</div>
		</div>
		
		<div class="form-group">
			<label for="main_language" class="col-sm-2 control-label">Main Medium (Language)</label>
			<div class="col-sm-4">
				<select class="form-control" id="main_language" name="main_language" data-toggle="popover" data-placement="top" data-trigger="focus" title="Main Medium (Language)" data-content="Please fill in the form the main language of the activity.">
					<option value=""><?= "-- Select --" ?></option>
						<option value="EN">English</option>
						<option value="ZH">Chinese</option>
						<option value="BOTH">Both</option>
				</select>
			</div>
			<label for="secondary_language" class="col-sm-2 control-label">Secondary Medium (if any)</label>
			<div class="col-sm-4">
				<select class="form-control" id="secondary_language" name="secondary_language">
					<option value=""><?= "-- Select --" ?></option>
						<option value="EN">English</option>
						<option value="ZH">Chinese</option>
						<option value="BOTH">Both</option>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="activity_component" class="col-sm-2 control-label">
				<span class="required">* </span> Activity Component
			</label>
			<div class="col-sm-10">
				<div style="padding-top: 7px;">
					<select class="form-control" id="activity_component" name="activity_component" required>
						<option value="">-- Select --</option>
						<?foreach($activity_component as $activity_component_row):?>
							<option value="<?= $activity_component_row->id ?>"><?= $activity_component_row->name ?></option>
						<?endforeach;?>
					</select>
                </div>
			</div>
		</div>

		<div class="form-group collapse" id="activity_purpose_collapse">
			<label for="activity_purpose" class="col-sm-2 control-label">
				<span class="required">* </span> Activity Purpose
			</label>
			<div class="col-sm-10">
				<div style="padding-top: 7px;">
					<?php foreach ($activity_purpose as $objectives_row): ?>
						<div class="checkbox col-sm-12" id="activity_purpose_area_<?= $objectives_row->id ?>">
							<label>
								<input type="checkbox" id="activity_purpose_val_<?= $objectives_row->id ?>" name="activity_purpose[]" value="<?= $objectives_row->id ?>" data-required-group="activity_purpose">
								<?= $objectives_row->name ?>
							</label>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="activity_purpose_others" class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="activity_purpose_others" name="activity_purpose_others" maxlength="200" placeholder="Others Activity Objectives, please specify" style="display: none;" disabled>
			</div>
		</div>

		<div class="form-group collapse" id="learning_outcome_collapse">
			<label for="learning_outcome" class="col-sm-2 control-label">
				<span class="required">* </span> Intended Learning Outcomes
			</label>
			<div class="col-sm-10">
				<div style="padding-top: 7px;">
					<?php foreach ($learning_outcome as $ilo_row): ?>
						<div class="checkbox col-sm-12" id="learning_outcome_area_<?= $ilo_row->id ?>">
							<label>
								<input type="checkbox" id="learning_outcome_val_<?= $ilo_row->id ?>" name="learning_outcome[]" value="<?= $ilo_row->id ?>" data-required-group="learning_outcome">
								<?= $ilo_row->name ?>
							</label>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		
		<div class="form-group collapse" id="activity_curricular_requirement_collapse">
			<label for="curricular_requirement_primary" class="col-sm-2 control-label">
			Curricular Requirement
				<br><span style="font-style: italic; background-color: #ffff00;">(not more than three)</span>
			</label>
			<div class="col-sm-10">
				<div style="padding-top: 7px;">
					
				</div>
                <div style="padding-top: 7px;">
					<label for="curricular_requirement_primary"><span class="required">* </span>Curricular Requirement (Primary)</label>
                    <div style="padding-top: 7px;">
						<select class="form-control" id="curricular_requirement_primary" name="curricular_requirement_primary[]" required>
							<option value="">-- Select --</option>
							<?foreach($curricular_requirement as $curricular_requirement_row):?>
								<option value="<?= $curricular_requirement_row->id ?>" id="curricular_requirement_primary_<?= $curricular_requirement_row->id ?>"><?= $curricular_requirement_row->name ?></option>
							<?endforeach;?>
						</select>
                    </div>
                </div>
                <div style="padding-top: 7px;">
					<label for="curricular_requirement_secondary">Curricular Requirement (Secondary)</label>
                    <div style="padding-top: 7px;">
                        <select id="curricular_requirement_secondary" name="curricular_requirement_secondary[]" class="form-control selectpicker" multiple data-none-selected-text="-- Select --" data-style="selectpicker-default">
                            <?foreach($curricular_requirement as $curricular_requirement_row):?>
								<option value="<?= $curricular_requirement_row->id ?>" id="curricular_requirement_secondary_<?= $curricular_requirement_row->id ?>"><?= $curricular_requirement_row->name ?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                </div>
			</div>
		</div>

		<!-- Questionnaire Questions Section (questionnaire_questions) -->
		<div class="form-group collapse" id="questionnaire_questions_collapse">
		<label for="questionnaire_questions" class="col-sm-2 control-label">
			Questionnaire Questions
			
		</label>
			<div class="col-sm-10">
				<div style="padding-top: 7px;">

					<!-- Activity Questions Subsection (questionnaire_activity_question[]) -->
					<div style="margin-bottom: 15px;">
						<strong>Activity Arrangement:</strong>
						<?php
						// Filter and sort questionnaire activity questions
						$questionnaire_activity_questions = array_filter($questionnaire_questions, function($q) {
							return $q->mapping_type == 'activity';
						});
						usort($questionnaire_activity_questions, function($a, $b) {
							return $a->curricular_requirement_id - $b->curricular_requirement_id;
						});
						?>
						<?php foreach ($questionnaire_activity_questions as $question): ?>
							<div class="checkbox col-sm-12">
								<label >
									<input type="checkbox"
										name="questionnaire_activity_question[]"
										value="<?= $question->id ?>"
										checked
										disabled>
									<?= $question->name ?>
								</label>
								<!-- Hidden input to ensure disabled checkboxes are submitted -->
								<input type="hidden"
									name="questionnaire_activity_question[]"
									value="<?= $question->id ?>">
							</div>
						<?php endforeach; ?>
					</div>

					<!-- Curricular Requirement Questions Subsection (questionnaire_curricular_requirement_question[]) -->
					<div style="margin-bottom: 15px;">
						<strong id="questionnaire_curricular_requirement_questions_header" style="display: none;"><span class="required">* </span>Curricular Requirements (Please select at least one question)</strong>
						<?php
						$questionnaire_curricular_requirement_questions = array_filter($questionnaire_questions, function($q) {
							return $q->mapping_type == 'cr';
						});
						?>
						<div id="questionnaire_curricular_requirement_questions_container">
							<?php foreach ($questionnaire_curricular_requirement_questions as $question): ?>
								<div class="checkbox col-sm-12 questionnaire_curricular_requirement_question"
									data-curricular-requirement-id="<?= $question->curricular_requirement_id ?>"
									style="display: none;">
									<label>
										<input type="checkbox"
											name="questionnaire_curricular_requirement_question[]"
											class="questionnaire_curricular_requirement_question_checkbox"
											value="<?= $question->id ?>"
											data-required-group="questionnaire_curricular_requirement_question">
										<?= $question->name ?>
									</label>
									<input type="hidden"
										name="questionnaire_curricular_requirement_question[]"
										class="questionnaire_curricular_requirement_question_hidden"
										value="<?= $question->id ?>"
										disabled>
								</div>
							<?php endforeach; ?>
							<div class="col-sm-12" id="curricular_requirement_no_questions_msg" style="display: none; color: #999; font-style: italic;">
								No questions available for the selected Curricular Requirements.
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="start_dt_tm" class="col-sm-2 control-label"><span class="required">* </span>Start Date and Time
			<a data-toggle="tooltip" data-placement="bottom" title="An activity programme should last at least 1.5 hours." onclick="return false;"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
			</label>
			<div class="col-sm-4">
				<div class="input-group datetime" id="dt_picker_start_dt_tm">
					<input type="text" class="form-control" id="start_dt_tm" name="start_dt_tm" placeholder="YYYY-MM-DD HH:mm" required>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
			
			<label for="end_dt_tm" class="col-sm-2 control-label"><span class="required">* </span>End Date and Time</label>
			<div class="col-sm-4">
				<div class="input-group datetime" id="dt_picker_end_dt_tm">
					<input type="text" class="form-control" id="end_dt_tm" name="end_dt_tm" placeholder="YYYY-MM-DD HH:mm" required>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
			
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<span class="help-block">The end date and time must be set later than start date and time.</span>
			</div>
		</div>
		
		<div class="form-group">
			<label for="activity_obj_evaluation" class="col-sm-2 control-label">
				<span class="required">* </span> Evaluation of Objectives / ILOs
			</label>
			<div class="col-sm-10">
				<div style="padding-top: 7px;">
					<?php foreach ($activity_obj_evaluation as $obj_evaluation_row): ?>
						<div class="checkbox col-sm-12">
							<label>
								<input type="checkbox" name="activity_obj_evaluation[]" value="<?= $obj_evaluation_row->id ?>" data-required-group="activity_obj_evaluation"<?= $obj_evaluation_row->checked == 'Y' ? ' onclick="return false" checked ' : '' ?>>
								<?= $obj_evaluation_row->name ?>
							</label>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-12 text-right">
				<button type="button" class="btn btn-default" id="btn_cancel_activity">Back to Activity List</button>
				<button type="button" class="btn btn-primary" id="btn_create_activity_submit">Create Activity</button>
			</div>
		</div>
	</div>
</div>

</form>

<script>
	var co_organiser_dept_ids_values = [];
	var co_organiser_society_ids_values = [];

	// function initTaginput(json_data) {
	// 	var depts = new Bloodhound({
	// 		local: json_data.data,
	// 		queryTokenizer: Bloodhound.tokenizers.whitespace,
	// 		datumTokenizer: Bloodhound.tokenizers.whitespace
	// 	});
	// 	depts.initialize();

	// 	$('#co_organiser_dept').tagsinput({
	// 		typeaheadjs: {
	// 			source: depts.ttAdapter()
	// 		},
	// 		freeInput: false
	// 	});
    // }

	function formatState (state, container) {
        if (!state.id) {
            return state.text;
        }

        var $state = $(
            '<span><span></span></span>'
        );

        // Use .text() instead of HTML string concatenation to avoid script injection issues.
        // Options no longer carry a "#NOT_SHOW#<search terms>" suffix, so show the full text
        // when the marker is absent (otherwise substring(0,-1) would blank the label).
        var not_show_idx = state.text.indexOf("#NOT_SHOW#");
        $state.find("span").text(not_show_idx === -1 ? state.text : state.text.substring(0, not_show_idx));

        return $state;
    };

	$(document).ready(function() {

		// ajax.get(
		// 	'<?= base_url().$module_json_api_path ?>/get_all_departments',
		// 	null,
		// 	null,
		// 	function (json_data) {
		// 		initTaginput(json_data);
		// 	},
		// 	null
		// );

		//==============================================================================
		//	Select Picker
		//==============================================================================
		$('.selectpicker').selectpicker();

		//==============================================================================
		//	Select2
		//==============================================================================
		/* Organiser */
		$('#organiser_dept').select2({
            templateResult: formatState,
            templateSelection: formatState,
			width: '100%',
			multiple: false
        });
		
		/* co_organiser_dept: Department / Office / Unit */
		$('#co_organiser_dept').select2({
            templateResult: formatState,
            templateSelection: formatState,
			width: '100%'
        });

        $("#co_organiser_dept").on("select2:selecting", function (evt) {
            var dept_unit_code = evt.params.args.data.id;
            co_organiser_dept_ids_values.push(dept_unit_code);
			$("#co_organiser_dept_ids").val(JSON.stringify(co_organiser_dept_ids_values));
        });

        $("#co_organiser_dept").on("select2:unselecting", function (evt) {
            var dept_unit_code = evt.params.args.data.id;
            co_organiser_dept_ids_values = $.grep(co_organiser_dept_ids_values, function(value) {
                return value != dept_unit_code;
            });
            $("#co_organiser_dept_ids").val(JSON.stringify(co_organiser_dept_ids_values));
        });

		/* co_organiser_society: Society / Alumni */
        $('#co_organiser_society').select2({
            templateResult: formatState,
            templateSelection: formatState,
			width: '100%'
        });

        $("#co_organiser_society").on("select2:selecting", function (evt) {
            var org_soc_alu_id = evt.params.args.data.id;
            co_organiser_society_ids_values.push(org_soc_alu_id);
            $("#co_organiser_society_ids").val(JSON.stringify(co_organiser_society_ids_values));
        });

        $("#co_organiser_society").on("select2:unselecting", function (evt) {
            var org_soc_alu_id = evt.params.args.data.id;
            co_organiser_society_ids_values = $.grep(co_organiser_society_ids_values, function(value) {
                return value != org_soc_alu_id;
            });
            $("#co_organiser_society_ids").val(JSON.stringify(co_organiser_society_ids_values));
        });

		// Datetime picker is initialized immediately below the ready wrapper for AJAX-injected forms.


		//==============================================================================
		//	Tooltip
		//==============================================================================
		$('[data-toggle="tooltip"]').tooltip({html: true});
		
		//==============================================================================
		//	Popover
		//==============================================================================
		$('[data-toggle="popover"]').popover({html: true});
	});

	//==============================================================================
	//	Datetime Picker
	//==============================================================================
	$('#dt_picker_start_dt_tm').datetimepicker({
		useCurrent: false,
		allowInputToggle: true,
		format: 'YYYY-MM-DD HH:mm',
		//maxDate : '2024-08-31 23:59'
	});
	$('#dt_picker_end_dt_tm').datetimepicker({
		useCurrent: false,
		allowInputToggle: true,
		format: 'YYYY-MM-DD HH:mm',
		//maxDate : '2024-08-31 23:59'
	});
	$("#dt_picker_start_dt_tm").on("dp.change", function (e) {
		$('#dt_picker_end_dt_tm').data("DateTimePicker").minDate(e.date);
	});
	$("#dt_picker_end_dt_tm").on("dp.change", function (e) {
		$('#dt_picker_start_dt_tm').data("DateTimePicker").maxDate(e.date);
	});
	$('#dt_picker_start_dt_tm').data("DateTimePicker").minDate('now');

	$("#start_dt_tm").val("");

	// Explicit lookup-ID mappings. These IDs come from the seeded lookup tables.
	var activityPurposeIdsByComponent = {
		1: [1, 5], // Workshop: Knowledge Enhancement, Problem Solving
		2: [2, 6], // Seminar: Skills Development, Communication
		3: [3, 7], // Training: Attitude Building, Self-Management
		4: [4]     // Talk: Others
	};
	var learningOutcomeIdsByComponent = {
		1: [1],
		2: [2],
		3: [3],
		4: []
	};
	var curricularRequirementIdsByLearningOutcome = {
		1: [1, 2],
		2: [3, 4],
		3: [5, 6, 7]
	};

	$('#activity_component').change(function() {
		<?php foreach ($activity_purpose as $objectives_row): ?>
			$('#activity_purpose_val_<?= $objectives_row->id ?>').prop( "checked", false );
			$('#activity_purpose_val_<?= $objectives_row->id ?>').prop( "disabled", true );
			$('#activity_purpose_area_<?= $objectives_row->id ?>').hide();
		<?php endforeach; ?>

		<?php foreach ($learning_outcome as $ilo_row): ?>
			$('#learning_outcome_val_<?= $ilo_row->id ?>').prop( "checked", false );
			$('#learning_outcome_val_<?= $ilo_row->id ?>').prop( "disabled", true );
			$('#learning_outcome_val_<?= $ilo_row->id ?>').parent().css( "color", '#ccc' );
		<?php endforeach; ?>

        $("#activity_purpose_others").val("");
        validation.text.clearFeedback($("#activity_purpose_others"));
        $("#activity_purpose_others").prop("disabled", true);
        $("#activity_purpose_others").prop("required", false);
        $("#activity_purpose_others").hide();

		if (this.value != '') {
			<?php foreach ($activity_purpose as $objectives_row): ?>
				<? if ($objectives_row->id == ''):?>
					$('#activity_purpose_area_<?= $objectives_row->id ?>').show();
					$('#activity_purpose_val_<?= $objectives_row->id ?>').prop( "disabled", false );
				<? else: ?>
					if ($.inArray(<?= $objectives_row->id ?>, activityPurposeIdsByComponent[this.value] || []) !== -1) {
						$('#activity_purpose_area_<?= $objectives_row->id ?>').show();
						$('#activity_purpose_val_<?= $objectives_row->id ?>').prop( "disabled", false );
					}
				<? endif; ?>
			<?php endforeach; ?>

			<?php foreach ($learning_outcome as $ilo_row): ?>
				if ($.inArray(<?= $ilo_row->id ?>, learningOutcomeIdsByComponent[this.value] || []) !== -1) {
					$('#learning_outcome_val_<?= $ilo_row->id ?>').prop( "disabled", false );
					$('#learning_outcome_val_<?= $ilo_row->id ?>').parent().css( "color", '' );

					<? if( count(explode(',',$ilo_row->id) ) == 1): ?>
						$('#learning_outcome_val_<?= $ilo_row->id ?>').prop( "checked", true );
					<? endif; ?>
				}
			<?php endforeach; ?>
			if ($('input[name="learning_outcome[]"]').not(":disabled").length == 1) {
				$('input[name="learning_outcome[]"]').not(":disabled").prop( "checked", true );
			}

			update_curricular_requirement_options();

			$('#activity_purpose_collapse').collapse('show');
			$('#learning_outcome_collapse').collapse('show');
			$('#activity_curricular_requirement_collapse').collapse('show');
			$('#questionnaire_questions_collapse').collapse('show');
		}
		else {
			$('#activity_purpose_collapse').collapse('hide');
			$('#learning_outcome_collapse').collapse('hide');
			$('#activity_curricular_requirement_collapse').collapse('hide');
			$('#questionnaire_questions_collapse').collapse('hide');
			$('.questionnaire_curricular_requirement_question').hide();
			$('.questionnaire_curricular_requirement_question_checkbox').prop('checked', false);
			$('#curricular_requirement_no_questions_msg').hide();
		}
	});

	function update_curricular_requirement_options() {
		<?foreach($curricular_requirement as $curricular_requirement_row):?>
			$('#curricular_requirement_primary_<?= $curricular_requirement_row->id ?>').prop( "disabled", true );
			$('#curricular_requirement_primary_<?= $curricular_requirement_row->id ?>').prop( "selected", false );
			$('#curricular_requirement_secondary_<?= $curricular_requirement_row->id ?>').prop( "disabled", true );
			$('#curricular_requirement_secondary_<?= $curricular_requirement_row->id ?>').prop( "selected", false );
		<?endforeach;?>

		$('input[name="learning_outcome[]"]:checked').map(function(){
			<?php foreach ($learning_outcome as $ilo_row): ?>
				if ($(this).val() == <?= $ilo_row->id ?>) {
					<?foreach($curricular_requirement as $curricular_requirement_row):?>
						if ($.inArray(<?= $curricular_requirement_row->id ?>, curricularRequirementIdsByLearningOutcome[$(this).val()] || []) !== -1) {
							$('#curricular_requirement_primary_<?= $curricular_requirement_row->id ?>').prop( "disabled", false );
							$('#curricular_requirement_secondary_<?= $curricular_requirement_row->id ?>').prop( "disabled", false );
						}
					<?endforeach;?>
				}
			<?php endforeach; ?>
		});

		$('#curricular_requirement_secondary').selectpicker('refresh');
	}

	function update_questionnaire_curricular_requirement_questions() {
		// Get selected primary curricular requirement only (not secondary)
		var primary_curricular_requirement_id = $('#curricular_requirement_primary').val();

		// Hide all curricular-requirement questions first and reset
		$('.questionnaire_curricular_requirement_question').hide();
		$('.questionnaire_curricular_requirement_question').find('.questionnaire_curricular_requirement_question_checkbox').prop('checked', false).prop('disabled', false);
		$('.questionnaire_curricular_requirement_question').find('.questionnaire_curricular_requirement_question_hidden').prop('disabled', true);

		// Show questions matching the selected primary curricular requirement
		if (primary_curricular_requirement_id && primary_curricular_requirement_id !== '') {
			// Show the header when the primary curricular requirement is selected
			$('#questionnaire_curricular_requirement_questions_header').show();

			var $visible_questions = $('.questionnaire_curricular_requirement_question').filter(function() {
				var question_curricular_requirement_id = $(this).data('curricularRequirementId').toString();
				return question_curricular_requirement_id === primary_curricular_requirement_id || question_curricular_requirement_id === parseInt(primary_curricular_requirement_id).toString();
			});

			$visible_questions.show();

			// If only one question exists for this curricular requirement, auto-check it and submit it through the hidden input
			if ($visible_questions.length === 1) {
				$visible_questions.find('.questionnaire_curricular_requirement_question_checkbox').prop('checked', true).prop('disabled', true);
				$visible_questions.find('.questionnaire_curricular_requirement_question_hidden').prop('disabled', false);
			}

			// Show/hide "no questions" message
			if ($visible_questions.length > 0) {
				$('#curricular_requirement_no_questions_msg').hide();
			} else {
				$('#curricular_requirement_no_questions_msg').show();
			}
		} else {
			// No primary curricular requirement selected - hide header and message
			$('#questionnaire_curricular_requirement_questions_header').hide();
			$('#curricular_requirement_no_questions_msg').hide();
		}
	}

	// Update curricular-requirement questions when the primary requirement changes
	$('#curricular_requirement_primary').change(function() {
		update_questionnaire_curricular_requirement_questions();
	});

	$('input[name="learning_outcome[]"]').change(function() {
		update_curricular_requirement_options();
	});

	$('input[name="activity_purpose[]"]').change(function() {
		var show_activity_objectives_others = false;
		$('input[name="activity_purpose[]"]:checked').map(function(){
			if ($(this).val() == <?= ACTIVITY_OBJECTIVES_OTHERS ?>) {
				show_activity_objectives_others = true;
			}
		});

		if (show_activity_objectives_others == true) {
			$("#activity_purpose_others").prop("disabled", false);
			$("#activity_purpose_others").prop("required", true);
			$("#activity_purpose_others").show();
		} else {
			$("#activity_purpose_others").val("");
			validation.text.clearFeedback($("#activity_purpose_others"));
			$("#activity_purpose_others").prop("disabled", true);
			$("#activity_purpose_others").prop("required", false);
			$("#activity_purpose_others").hide();
		}
	});

	$('input[name="activity_obj_evaluation[]"]').change(function() {
		var show_activity_obj_evaluation_other = false;
		$('input[name="activity_obj_evaluation[]"]:checked').map(function(){
			if ($(this).val() == <?= ACTIVITY_OBJ_EVALUATION_OTHER ?>) {
				show_activity_obj_evaluation_other = true;
			}
		});

		if (show_activity_obj_evaluation_other == true) {
			$("#activity_obj_evaluation_other").prop("disabled", false);
			$("#activity_obj_evaluation_other").prop("required", true);
			$("#activity_obj_evaluation_other").show();
		} else {
			$("#activity_obj_evaluation_other").val("");
			validation.text.clearFeedback($("#activity_obj_evaluation_other"));
			$("#activity_obj_evaluation_other").prop("disabled", true);
			$("#activity_obj_evaluation_other").prop("required", false);
			$("#activity_obj_evaluation_other").hide();
		}
	});

	//==============================================================================
	//	Listener
	//==============================================================================
	$("#main_language").change(function () {
		if ($("#main_language > option:selected").text() == '<?= 'ZH' ?>' || $("#main_language > option:selected").text() == '<?= 'ZH' ?>') {
			$("#title_chi").prop("required", true);
			$('#title_chi').popover({
				placement: 'top',
				title: 'Activity Name (Chinese)',
				content: 'The main language of the activity is Chinese. Please provide a Chinese title.',
				trigger: 'focus'
			});
			$('#title_chi').popover('show');

			$('#title').popover('destroy');
		} else if ($("#main_language > option:selected").text() == '<?= 'EN' ?>') {
			$("#title_chi").removeAttr("required");
			$('#title').popover({
				placement: 'top',
				title: 'Activity Name (English)',
				content: 'The main language of the activity is English. Please provide an English Activity Name.',
				trigger: 'focus'
			});
			$('#title').popover('show');

			$('#title_chi').popover('destroy');
		} else {
			$("#title_chi").removeAttr("required");

			$('#title').popover('destroy');
			$('#title_chi').popover('destroy');
		}

		$(this).popover('hide');
	});

	$("#btn_cancel_activity").click(function() {
		returnToActivityList(false);
	});

	function returnToActivityList(shouldReload) {
		activeForm.resetActiveForm();
		app.container.slideHorizontally(
			"content_container_left",
			"content_container_right",
			"content_container_left",
			function() {
				if (shouldReload && typeof table_activity !== "undefined" && table_activity && table_activity.ajax) {
					table_activity.ajax.reload(null, false);
				}
			}
		);
	}

	$("#btn_create_activity_submit").click(function() {
		var $button = $(this);
		var $form = $("#<?= $form_id ?>_create_sa");

		validation.form.validate(
			$form,
			true,
			function() {
				$button.prop("disabled", true);
				ajax.post(
					$form.attr("action"),
					$form.serialize(),
					function() {
						returnToActivityList(true);
					},
					function() {
						$button.prop("disabled", false);
					}
				);
			},
			null
		);
	});
	
</script>
	
<style>
	form .tooltip-inner {
		max-width: 450px;
		width: 450px; 
	}

	.tag-this {
		margin: 0;
		width: unset;
	}
</style>