/*
   seed.sql
   Standalone data statements collected from the repository SQL sources.
   Run this file after schema.sql.
   Cleanup statements are included so the development seed can be re-run.
*/
INSERT INTO [tam].[tam_mtr_quality] (code, name, seq, rec_status, create_by, create_dt) VALUES
	('ACAD', N'Academic', 1, 'A', 'seed', GETDATE()),
	('NACAD', N'Non-academic', 2, 'A', 'seed', GETDATE()),
	('SPORT', N'Sports', 3, 'A', 'seed', GETDATE()),
	('CULT', N'Cultural', 4, 'A', 'seed', GETDATE()),
	('SERV', N'Community Service', 5, 'A', 'seed', GETDATE());
GO

INSERT INTO [tam].[tam_mtr_dept] (code, name, seq, rec_status, create_by, create_dt) VALUES
	('CHINESE', N'Chinese Department', 1, 'A', 'seed', GETDATE()),
	('ENGLISH', N'English Department', 2, 'A', 'seed', GETDATE()),
	('MATH', N'Math Department', 3, 'A', 'seed', GETDATE()),
	('SCIENCE', N'Science Department', 4, 'A', 'seed', GETDATE());
GO

INSERT INTO [tam].[tam_mtr_society] (code, name, seq, rec_status, create_by, create_dt) VALUES
	('SU', N'Students'' Union', 1, 'A', 'seed', GETDATE()),
	('PGA', N'Postgraduate Association', 2, 'A', 'seed', GETDATE()),
	('SPORTS', N'Sports Association', 3, 'A', 'seed', GETDATE());
GO

INSERT INTO [tam].[tam_mtr_component] (code, name, seq, rec_status, create_by, create_dt) VALUES
	('WS', N'Workshop', 1, 'A', 'seed', GETDATE()),
	('SEM', N'Seminar', 2, 'A', 'seed', GETDATE()),
	('TRN', N'Training', 3, 'A', 'seed', GETDATE()),
	('TALK', N'Talk', 4, 'A', 'seed', GETDATE());
GO

INSERT INTO [tam].[tam_mtr_activity_purpose] (code, name, seq, rec_status, create_by, create_dt) VALUES
	('KNOW', N'Knowledge Enhancement', 1, 'A', 'seed', GETDATE()),
	('SKILL', N'Skills Development', 2, 'A', 'seed', GETDATE()),
	('ATT', N'Attitude Building', 3, 'A', 'seed', GETDATE()),
	('OTH', N'Others', 4, 'A', 'seed', GETDATE()),
	('PROB', N'Problem Solving', 5, 'A', 'seed', GETDATE()),
	('COMM', N'Communication', 6, 'A', 'seed', GETDATE()),
	('SELF', N'Self-Management', 7, 'A', 'seed', GETDATE());
GO

INSERT INTO [tam].[tam_mtr_learning_outcome] (code, name, seq, rec_status, create_by, create_dt) VALUES
	('CT', N'Critical Thinking', 1, 'A', 'seed', GETDATE()),
	('COMM', N'Communication', 2, 'A', 'seed', GETDATE()),
	('COLL', N'Collaboration', 3, 'A', 'seed', GETDATE());
GO

INSERT INTO [tam].[tam_mtr_curricular_requirement] (code, name, seq, rec_status, create_by, create_dt) VALUES
	('CRIT', N'Critical Thinking', 1, 'A', 'seed', GETDATE()),
	('COLLAB', N'Collaboration', 2, 'A', 'seed', GETDATE()),
	('LEAD', N'Leadership', 3, 'A', 'seed', GETDATE()),
	('PROB', N'Problem Solving', 4, 'A', 'seed', GETDATE()),
	('SELF', N'Self-Management', 5, 'A', 'seed', GETDATE()),
	('EMPATHY', N'Empathy', 6, 'A', 'seed', GETDATE()),
	('DIGITAL', N'Digital Literacy', 7, 'A', 'seed', GETDATE());
GO

INSERT INTO [tam].[tam_mtr_questionnaire_question] (code, name, seq, mapping_type, curricular_requirement_id, rec_status, create_by, create_dt) VALUES
	('AQ1', N'The activity met its stated objectives', 1, 'activity', NULL, 'A', 'seed', GETDATE()),
	('AQ2', N'I would recommend this activity to others', 2, 'activity', NULL, 'A', 'seed', GETDATE()),
	('CQ1', N'The activity strengthened my Critical Thinking', 3, 'cr', 1, 'A', 'seed', GETDATE()),
	('CQ2', N'The activity enhanced my Collaboration',       4, 'cr', 2, 'A', 'seed', GETDATE()),
	('CQ3', N'The activity developed my Problem Solving',   5, 'cr', 4, 'A', 'seed', GETDATE()),
	('CQ4', N'The activity improved my Empathy',             6, 'cr', 6, 'A', 'seed', GETDATE());
GO

/* ---- clear previous seed so this can be re-run ---- */
DELETE FROM [tam].[acl_role_mod_perm] WHERE create_by = 'seed';
DELETE FROM [tam].[acl_user_role]     WHERE create_by = 'seed';
DELETE FROM [tam].[acl_user]          WHERE create_by = 'seed';
DELETE FROM [tam].[acl_module]        WHERE create_by = 'seed';
DELETE FROM [tam].[acl_role]          WHERE create_by = 'seed';
DELETE FROM [tam].[acl_perm]          WHERE create_by = 'seed';
GO

/* 1) Permissions: mirror the 5 rows from dbo.acl_perm
      (1 Read, 2 Create, 3 Update, 4 Delete, 5 Export Excel) */
SET IDENTITY_INSERT [tam].[acl_perm] ON;
INSERT INTO [tam].[acl_perm] (perm_id, perm_name, perm_desc, create_by, create_dt)
VALUES (1, 'Read',         'Read',         'seed', GETDATE()),
       (2, 'Create',       'Create',       'seed', GETDATE()),
       (3, 'Update',       'Update',       'seed', GETDATE()),
       (4, 'Delete',       'Delete',       'seed', GETDATE()),
       (5, 'Export Excel', 'Export Excel', 'seed', GETDATE());
SET IDENTITY_INSERT [tam].[acl_perm] OFF;
GO

/* 2) Role: activity_organiser  (role_id 1) */
SET IDENTITY_INSERT [tam].[acl_role] ON;
-- default_module_id = 2 -> land on 'Activity application' after login
INSERT INTO [tam].[acl_role] (role_id, role_name, role_desc, default_module_id, create_by, create_dt)
VALUES (1, 'activity_organiser', 'Activity organiser', 2, 'seed', GETDATE());
SET IDENTITY_INSERT [tam].[acl_role] OFF;
GO

/* 3) Menu modules: Home, Activity application, Report (parent + one report type)
      module_id is NOT identity, so insert directly.

      Report needs BOTH rows:
        1002 - the parent.
        1003 - a child. */
INSERT INTO [tam].[acl_module]
  (module_id, parent_module_id, module_name, module_desc, module_path,
   module_img, json_api_path, json_html_path, is_visible_in_header_menu, seq,
   create_by, create_dt)
VALUES
  (1, NULL, 'Home',                 'Home',                 'welcome',
   NULL, NULL, NULL, 1, 1, 'seed', GETDATE()),
  (2, NULL, 'Activity application', 'Activity application', 'activity_application',
   NULL, 'json/api/activity_application', 'json/html/activity_application', 1, 2, 'seed', GETDATE()),
  (1002, NULL, 'Report',            'Report',               '#',
   NULL, 'json/api/report', 'json/html/report', 1, 3, 'seed', GETDATE()),
  (1003, 1002, 'General Report',    'General Report',       'report',
   NULL, 'json/api/report', 'json/html/report', 1, 4, 'seed', GETDATE());
GO

/* 4) User: username 'tester'.
      is_inactive MUST be NULL (a set value = "Unauthorised" at login). */
INSERT INTO [tam].[acl_user]
  (user_id, salu_code, fam_name, oth_name, dept_unit_code, email, username,
   role_dept, staff_std_type, is_inactive, ip_range, create_by, create_dt)
VALUES
  ('tester', NULL, 'tester', 'tester', 'ADMINDEPT', 'tester@example.com', 'tester',
   NULL, 'staff', NULL, NULL, 'seed', GETDATE());
GO

/* 5) Link user -> role -> dept (exactly ONE dept -> straight into the app) */
INSERT INTO [tam].[acl_user_role]
  (user_id, role_id, dept_unit_code, is_sys_gen, create_by, create_dt)
VALUES
  ('tester', 1, 'ADMINDEPT', NULL, 'seed', GETDATE());
GO

/* 6) Give the role EVERY permission on ALL FOUR modules
      (4 modules x 5 perms = 20 rows) */
INSERT INTO [tam].[acl_role_mod_perm] (role_id, module_id, perm_id, create_by, create_dt)
SELECT 1, m.module_id, p.perm_id, 'seed', GETDATE()
FROM      (VALUES (1),(2),(1002),(1003)) AS m(module_id)
CROSS JOIN (VALUES (1),(2),(3),(4),(5))  AS p(perm_id);
GO

PRINT 'Seed complete.  Manual login -> username: tester';
GO

/* 7) Attendance report data and report registry rows */
DELETE FROM [tam].[report] WHERE [rpt_id] IN (2001, 2002);
DELETE FROM [tam].[tam_attendance_report] WHERE [create_by] = 'seed';
GO

INSERT INTO [tam].[tam_attendance_report]
  ([attendance_date], [student_no], [student_name], [department], [activity_name],
   [attendance_status], [check_in_time], [rec_status], [create_by], [create_dt])
VALUES
  ('2026-08-10', 'STU0001', N'Alice Chan',  N'Computer Science', N'New Student Orientation', 'Present', '2026-08-10T09:01:00', 'A', 'seed', GETDATE()),
  ('2026-08-10', 'STU0002', N'Brian Lee',   N'Business',          N'New Student Orientation', 'Present', '2026-08-10T09:04:00', 'A', 'seed', GETDATE()),
  ('2026-08-11', 'STU0003', N'Carmen Wong', N'Communication',     N'Library Induction',      'Absent',  NULL,                    'A', 'seed', GETDATE()),
  ('2026-08-11', 'STU0004', N'David Ho',    N'Business',          N'Library Induction',      'Late',    '2026-08-11T10:18:00', 'A', 'seed', GETDATE()),
  ('2026-08-12', 'STU0005', N'Emily Lau',   N'Communication',     N'Campus Safety Briefing', 'Present', '2026-08-12T14:02:00', 'A', 'seed', GETDATE());
GO

INSERT INTO [tam].[report]
  ([rpt_id], [rpt_type_id], [role_dept], [name], [description], [remark],
   [file_name], [file_format], [controller], [method], [rec_status], [create_by], [create_dt])
VALUES
  (2001, 1003, NULL, N'Attendance Report (Excel)', N'Export attendance records to Excel.', NULL,
   N'attendance_report.xlsx', N'xlsx', 'json/api/report', 'attendance_excel', 'A', 'seed', GETDATE()),
  (2002, 1003, NULL, N'Attendance Report (PDF)', N'Export attendance records to PDF.', NULL,
   N'attendance_report.pdf', N'pdf', 'json/api/report', 'attendance_pdf', 'A', 'seed', GETDATE());
GO

PRINT 'Attendance report seed complete.';
GO

