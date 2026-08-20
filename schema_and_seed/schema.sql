/*
   schema.sql
   Base tables/procedures followed by the activity-form schema patch.
   Run this file before seed.sql.
*/
-- Repository-focused SQL subset for 

-- Generated from active PHP model wrappers and the 15 activity-form lookup procedures.

-- This is a schema/data script only; it does not execute against a database.

IF NOT EXISTS (SELECT 1 FROM sys.schemas WHERE name = N'tam') EXEC(N'CREATE SCHEMA [tam]');
GO

-- Required by CodeIgniter database sessions.
IF OBJECT_ID(N'[tam].[sys_session_admin]', N'U') IS NULL
BEGIN
    CREATE TABLE [tam].[sys_session_admin](
        [id] [varchar](40) NOT NULL,
        [ip_address] [varchar](45) NOT NULL,
        [timestamp] [bigint] NOT NULL,
        [data] [varchar](max) NOT NULL,
        CONSTRAINT [PK_sys_session_admin] PRIMARY KEY CLUSTERED ([id] ASC)
    );
END
GO

GRANT SELECT, INSERT, UPDATE, DELETE ON [tam].[sys_session_admin] TO [local_db_user];
GO

/****** Object:  Table [tam].[acl_module]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[acl_module](
	[module_id] [int] NOT NULL,
	[parent_module_id] [int] NULL,
	[module_name] [nvarchar](50) NULL,
	[module_desc] [nvarchar](100) NULL,
	[module_path] [varchar](255) NULL,
	[module_img] [varchar](50) NULL,
	[json_api_path] [varchar](255) NULL,
	[json_html_path] [varchar](255) NULL,
	[is_visible_in_header_menu] [tinyint] NULL,
	[seq] [int] NULL,
	[create_by] [varchar](20) NOT NULL,
	[create_dt] [datetime] NOT NULL,
	[update_by] [varchar](20) NULL,
	[update_dt] [datetime] NULL,
 CONSTRAINT [PK__acl_modu__1A2D0653E50312C0] PRIMARY KEY CLUSTERED 
(
	[module_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[acl_perm]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[acl_perm](
	[perm_id] [int] IDENTITY(1,1) NOT NULL,
	[perm_name] [nvarchar](50) NULL,
	[perm_desc] [nvarchar](100) NULL,
	[create_by] [varchar](20) NOT NULL,
	[create_dt] [datetime] NOT NULL,
	[update_by] [varchar](20) NULL,
	[update_dt] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[perm_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[acl_role]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[acl_role](
	[role_id] [int] IDENTITY(1,1) NOT NULL,
	[role_name] [nvarchar](200) NULL,
	[role_desc] [nvarchar](200) NULL,
	[default_module_id] [int] NULL,
	[granter_whitelist] [varchar](500) NULL,
	[granter_blacklist] [varchar](500) NULL,
	[create_by] [varchar](20) NOT NULL,
	[create_dt] [datetime] NOT NULL,
	[update_by] [varchar](20) NULL,
	[update_dt] [datetime] NULL,
 CONSTRAINT [PK__acl_role__760965CCD7FC0EA1] PRIMARY KEY CLUSTERED 
(
	[role_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[acl_role_mod_perm]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[acl_role_mod_perm](
	[role_id] [int] NOT NULL,
	[module_id] [int] NOT NULL,
	[perm_id] [int] NOT NULL,
	[create_by] [varchar](20) NOT NULL,
	[create_dt] [datetime] NOT NULL,
	[update_by] [varchar](20) NULL,
	[update_dt] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[role_id] ASC,
	[module_id] ASC,
	[perm_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[acl_user]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[acl_user](
	[user_id] [varchar](20) NOT NULL,
	[salu_code] [nvarchar](20) NULL,
	[fam_name] [nvarchar](40) NULL,
	[oth_name] [nvarchar](100) NULL,
	[dept_unit_code] [varchar](10) NULL,
	[email] [varchar](60) NULL,
	[username] [varchar](30) NULL,
	[role_dept] [varchar](10) NULL,
	[staff_std_type] [varchar](10) NULL,
	[is_inactive] [tinyint] NULL,
	[ip_range] [varchar](255) NULL,
	[create_by] [varchar](20) NOT NULL,
	[create_dt] [datetime] NOT NULL,
	[update_by] [varchar](20) NULL,
	[update_dt] [datetime] NULL,
 CONSTRAINT [PK__acl_user__B9BE370F5B52E52B] PRIMARY KEY CLUSTERED 
(
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[acl_user_last_login]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[acl_user_last_login](
	[user_id] [varchar](20) NOT NULL,
	[username] [varchar](20) NULL,
	[last_login_dt] [datetime] NULL,
	[create_dt] [datetime] NOT NULL,
 CONSTRAINT [PK__acl_user__B9BE370F8AE754DD] PRIMARY KEY CLUSTERED 
(
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[acl_user_role]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[acl_user_role](
	[user_id] [varchar](20) NOT NULL,
	[role_id] [int] NOT NULL,
	[dept_unit_code] [varchar](10) NOT NULL,
	[is_sys_gen] [varchar](1) NULL,
	[create_by] [varchar](20) NOT NULL,
	[create_dt] [datetime] NOT NULL,
	[update_by] [varchar](20) NULL,
	[update_dt] [datetime] NULL,
 CONSTRAINT [PK__acl_user__6EDEA153891BB7EB] PRIMARY KEY CLUSTERED 
(
	[user_id] ASC,
	[role_id] ASC,
	[dept_unit_code] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[report]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[report](
	[rpt_id] [int] NOT NULL,
	[rpt_type_id] [int] NOT NULL,
	[role_dept] [varchar](10) NULL,
	[name] [nvarchar](100) NULL,
	[description] [nvarchar](255) NULL,
	[remark] [nvarchar](1000) NULL,
	[file_name] [nvarchar](255) NULL,
	[file_format] [nvarchar](255) NULL,
	[controller] [varchar](255) NULL,
	[method] [varchar](255) NULL,
	[rec_status] [varchar](1) NOT NULL,
	[create_by] [varchar](50) NOT NULL,
	[create_dt] [datetime] NOT NULL,
	[update_by] [varchar](50) NULL,
	[update_dt] [datetime] NULL,
 CONSTRAINT [PK_report] PRIMARY KEY CLUSTERED 
(
	[rpt_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[sys_sql_error]    Script Date: 3/7/2026 4:33:46 pm ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[sys_sql_error](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[sp_name] [varchar](100) NULL,
	[error_num] [int] NULL,
	[error_line] [int] NULL,
	[error_msg] [nvarchar](200) NULL,
	[error_severity] [int] NULL,
	[error_state] [int] NULL,
	[create_dt] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

/****** Object:  Table [tam].[tam_activity]    TAM vendor-test ******/
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[tam].[tam_activity]') AND type = N'U')
DROP TABLE [tam].[tam_activity]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[tam_activity](
	[activity_id] [int] IDENTITY(1,1) NOT NULL,
	[activity_name] [nvarchar](200) NOT NULL,
	[start_date] [date] NOT NULL,
	[end_date] [date] NOT NULL,
	[language] [varchar](10) NOT NULL,
	[organiser] [nvarchar](200) NULL,
	[form_data] [nvarchar](max) NULL,
	[create_by] [varchar](50) NOT NULL,
	[create_dt] [datetime] NOT NULL,
	[update_by] [varchar](50) NULL,
	[update_dt] [datetime] NULL,
 CONSTRAINT [PK_tam_activity] PRIMARY KEY CLUSTERED ([activity_id] ASC)
)
GO

ALTER TABLE [tam].[tam_activity] ADD CONSTRAINT [DF_tam_activity_create_dt] DEFAULT (GETDATE()) FOR [create_dt]
GO

GRANT SELECT, INSERT, UPDATE, DELETE ON [tam].[tam_activity] TO [local_db_user]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [tam].[tam_attendance_report](
	[attendance_id] [int] IDENTITY(1,1) NOT NULL,
	[attendance_date] [date] NOT NULL,
	[student_no] [varchar](20) NOT NULL,
	[student_name] [nvarchar](100) NOT NULL,
	[department] [nvarchar](100) NOT NULL,
	[activity_name] [nvarchar](200) NOT NULL,
	[attendance_status] [varchar](20) NOT NULL,
	[check_in_time] [datetime] NULL,
	[rec_status] [varchar](1) NOT NULL CONSTRAINT [DF_tam_attendance_report_rec_status] DEFAULT ('A'),
	[create_by] [varchar](50) NOT NULL,
	[create_dt] [datetime] NOT NULL CONSTRAINT [DF_tam_attendance_report_create_dt] DEFAULT (GETDATE()),
 CONSTRAINT [PK_tam_attendance_report] PRIMARY KEY CLUSTERED
(
	[attendance_id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
GO

GRANT SELECT ON [tam].[tam_attendance_report] TO [local_db_user];
GO

CREATE FUNCTION [tam].[const_AclPerm_Read]
()
RETURNS int
AS
BEGIN
	
	RETURN 1;

END
GO

-- Activity lookup tables, seed data, and lookup procedures

/* =============================================================================
   TAM activity-form lookup tables + sp_tam_Get*List procedures
   (dropdown/checkbox value sources for the Create Activity form)
   Uniform shape: id, code, name, seq, rec_status('A'=active) + audit cols.
   ============================================================================= */

/* ---- tam_mtr_quality ---- */
DROP TABLE IF EXISTS [tam].[tam_mtr_quality];
CREATE TABLE [tam].[tam_mtr_quality] (
	id int IDENTITY(1,1) NOT NULL,
	code varchar(30) NULL,
	name nvarchar(300) NOT NULL,
	seq int NULL,
	rec_status varchar(1) NOT NULL CONSTRAINT [DF_tam_mtr_quality_rec_status] DEFAULT ('A'),
	create_by varchar(20) NULL, create_dt datetime NULL, update_by varchar(20) NULL, update_dt datetime NULL,
	CONSTRAINT [PK_tam_mtr_quality] PRIMARY KEY (id)
);
GO

DROP PROCEDURE IF EXISTS [tam].[sp_tam_GetQualityList];
GO

CREATE PROCEDURE [tam].[sp_tam_GetQualityList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_quality] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT SELECT ON [tam].[tam_mtr_quality] TO [local_db_user];
GRANT EXECUTE ON [tam].[sp_tam_GetQualityList] TO [local_db_user];
GO

/* ---- tam_mtr_dept ---- */
DROP TABLE IF EXISTS [tam].[tam_mtr_dept];
CREATE TABLE [tam].[tam_mtr_dept] (
	id int IDENTITY(1,1) NOT NULL,
	code varchar(30) NULL,
	name nvarchar(300) NOT NULL,
	seq int NULL,
	rec_status varchar(1) NOT NULL CONSTRAINT [DF_tam_mtr_dept_rec_status] DEFAULT ('A'),
	create_by varchar(20) NULL, create_dt datetime NULL, update_by varchar(20) NULL, update_dt datetime NULL,
	CONSTRAINT [PK_tam_mtr_dept] PRIMARY KEY (id)
);
GO

DROP PROCEDURE IF EXISTS [tam].[sp_tam_GetDeptList];
GO

CREATE PROCEDURE [tam].[sp_tam_GetDeptList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_dept] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT SELECT ON [tam].[tam_mtr_dept] TO [local_db_user];
GRANT EXECUTE ON [tam].[sp_tam_GetDeptList] TO [local_db_user];
GO

/* ---- tam_mtr_society ---- */
DROP TABLE IF EXISTS [tam].[tam_mtr_society];
CREATE TABLE [tam].[tam_mtr_society] (
	id int IDENTITY(1,1) NOT NULL,
	code varchar(30) NULL,
	name nvarchar(300) NOT NULL,
	seq int NULL,
	rec_status varchar(1) NOT NULL CONSTRAINT [DF_tam_mtr_society_rec_status] DEFAULT ('A'),
	create_by varchar(20) NULL, create_dt datetime NULL, update_by varchar(20) NULL, update_dt datetime NULL,
	CONSTRAINT [PK_tam_mtr_society] PRIMARY KEY (id)
);
GO

DROP PROCEDURE IF EXISTS [tam].[sp_tam_GetSocietyList];
GO

CREATE PROCEDURE [tam].[sp_tam_GetSocietyList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_society] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT SELECT ON [tam].[tam_mtr_society] TO [local_db_user];
GRANT EXECUTE ON [tam].[sp_tam_GetSocietyList] TO [local_db_user];
GO

/* ---- tam_mtr_component ---- */
DROP TABLE IF EXISTS [tam].[tam_mtr_component];
CREATE TABLE [tam].[tam_mtr_component] (
	id int IDENTITY(1,1) NOT NULL,
	code varchar(30) NULL,
	name nvarchar(300) NOT NULL,
	seq int NULL,
	rec_status varchar(1) NOT NULL CONSTRAINT [DF_tam_mtr_component_rec_status] DEFAULT ('A'),
	create_by varchar(20) NULL, create_dt datetime NULL, update_by varchar(20) NULL, update_dt datetime NULL,
	CONSTRAINT [PK_tam_mtr_component] PRIMARY KEY (id)
);
GO

DROP PROCEDURE IF EXISTS [tam].[sp_tam_GetComponentList];
GO

CREATE PROCEDURE [tam].[sp_tam_GetComponentList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_component] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT SELECT ON [tam].[tam_mtr_component] TO [local_db_user];
GRANT EXECUTE ON [tam].[sp_tam_GetComponentList] TO [local_db_user];
GO

/* ---- tam_mtr_activity_purpose ---- */
DROP TABLE IF EXISTS [tam].[tam_mtr_activity_purpose];
CREATE TABLE [tam].[tam_mtr_activity_purpose] (
	id int IDENTITY(1,1) NOT NULL,
	code varchar(30) NULL,
	name nvarchar(300) NOT NULL,
	seq int NULL,
	rec_status varchar(1) NOT NULL CONSTRAINT [DF_tam_mtr_activity_purpose_rec_status] DEFAULT ('A'),
	create_by varchar(20) NULL, create_dt datetime NULL, update_by varchar(20) NULL, update_dt datetime NULL,
	CONSTRAINT [PK_tam_mtr_activity_purpose] PRIMARY KEY (id)
);
GO

DROP PROCEDURE IF EXISTS [tam].[sp_tam_GetActivityPurposeList];
GO

CREATE PROCEDURE [tam].[sp_tam_GetActivityPurposeList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_activity_purpose] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT SELECT ON [tam].[tam_mtr_activity_purpose] TO [local_db_user];
GRANT EXECUTE ON [tam].[sp_tam_GetActivityPurposeList] TO [local_db_user];
GO

/* ---- tam_mtr_learning_outcome ---- */
DROP TABLE IF EXISTS [tam].[tam_mtr_learning_outcome];
CREATE TABLE [tam].[tam_mtr_learning_outcome] (
	id int IDENTITY(1,1) NOT NULL,
	code varchar(30) NULL,
	name nvarchar(300) NOT NULL,
	seq int NULL,
	rec_status varchar(1) NOT NULL CONSTRAINT [DF_tam_mtr_learning_outcome_rec_status] DEFAULT ('A'),
	create_by varchar(20) NULL, create_dt datetime NULL, update_by varchar(20) NULL, update_dt datetime NULL,
	CONSTRAINT [PK_tam_mtr_learning_outcome] PRIMARY KEY (id)
);
GO

DROP PROCEDURE IF EXISTS [tam].[sp_tam_GetLearningOutcomeList];
GO

CREATE PROCEDURE [tam].[sp_tam_GetLearningOutcomeList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_learning_outcome] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT SELECT ON [tam].[tam_mtr_learning_outcome] TO [local_db_user];
GRANT EXECUTE ON [tam].[sp_tam_GetLearningOutcomeList] TO [local_db_user];
GO

/* ---- tam_mtr_curricular_requirement ---- */
DROP TABLE IF EXISTS [tam].[tam_mtr_curricular_requirement];
CREATE TABLE [tam].[tam_mtr_curricular_requirement] (
	id int IDENTITY(1,1) NOT NULL,
	code varchar(30) NULL,
	name nvarchar(300) NOT NULL,
	seq int NULL,
	rec_status varchar(1) NOT NULL CONSTRAINT [DF_tam_mtr_curricular_requirement_rec_status] DEFAULT ('A'),
	create_by varchar(20) NULL, create_dt datetime NULL, update_by varchar(20) NULL, update_dt datetime NULL,
	CONSTRAINT [PK_tam_mtr_curricular_requirement] PRIMARY KEY (id)
);
GO

DROP PROCEDURE IF EXISTS [tam].[sp_tam_GetCurricularRequirementList];
GO

CREATE PROCEDURE [tam].[sp_tam_GetCurricularRequirementList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_curricular_requirement] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT SELECT ON [tam].[tam_mtr_curricular_requirement] TO [local_db_user];
GRANT EXECUTE ON [tam].[sp_tam_GetCurricularRequirementList] TO [local_db_user];
GO

/* ---- tam_mtr_questionnaire_question (mapping_type + link to curricular_requirement) ---- */
DROP TABLE IF EXISTS [tam].[tam_mtr_questionnaire_question];
CREATE TABLE [tam].[tam_mtr_questionnaire_question] (
	id int IDENTITY(1,1) NOT NULL,
	code varchar(30) NULL,
	name nvarchar(300) NOT NULL,
	seq int NULL,
	mapping_type varchar(20) NOT NULL,           -- 'activity' (always shown) or 'cr' (shown per selected curricular_requirement)
	curricular_requirement_id int NULL,          -- links a 'cr' question to tam_mtr_curricular_requirement.id
	rec_status varchar(1) NOT NULL CONSTRAINT [DF_tam_mtr_questionnaire_question_rec_status] DEFAULT ('A'),
	create_by varchar(20) NULL, create_dt datetime NULL, update_by varchar(20) NULL, update_dt datetime NULL,
	CONSTRAINT [PK_tam_mtr_questionnaire_question] PRIMARY KEY (id)
);
GO

DROP PROCEDURE IF EXISTS [tam].[sp_tam_GetQuestionnaireQuestionList];
GO

CREATE PROCEDURE [tam].[sp_tam_GetQuestionnaireQuestionList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq, mapping_type, curricular_requirement_id
	FROM [tam].[tam_mtr_questionnaire_question]
	WHERE rec_status = 'A'
	ORDER BY seq, name;
END
GO

GRANT SELECT ON [tam].[tam_mtr_questionnaire_question] TO [local_db_user];
GRANT EXECUTE ON [tam].[sp_tam_GetQuestionnaireQuestionList] TO [local_db_user];
GO

-- Retained application procedures

CREATE PROCEDURE [tam].[sp_rpt_GetReportByIdRoleDept]
	@rpt_id int
,	@role_dept varchar(10)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	
	BEGIN TRY

		select
			rpt_id
		,	rpt_type_id
		,	role_dept
		,	name
		,	description
		,	remark
		,	file_name
		,	file_format
		,	controller
		,	method
		,	create_by
		,	create_dt
		,	update_by
		,	update_dt
		from
			report
		where
			rpt_id = @rpt_id
		and (role_dept is null or role_dept = @role_dept)
		and rec_status = 'A'

	END TRY
	BEGIN CATCH
		
		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_rpt_GetReportByIdRoleDept] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_rpt_GetReportsByRptTypeIdRoleDept]
	@rpt_type_id int
,	@role_dept varchar(10)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	
	BEGIN TRY

		select
			rpt_id
		,	rpt_type_id
		,	role_dept
		,	name
		,	description
		,	remark
		,	file_name
		,	file_format
		,	controller
		,	method
		,	create_by
		,	create_dt
		,	update_by
		,	update_dt
		from
			report
		where
			rpt_type_id = @rpt_type_id
		and (role_dept is null or role_dept = @role_dept)
		and rec_status = 'A'

	END TRY
	BEGIN CATCH
		
		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_rpt_GetReportsByRptTypeIdRoleDept] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_system_HandleSqlError]
	@SpName varchar(100)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	DECLARE @ErrorNumber INT = ERROR_NUMBER();
	DECLARE @ErrorLine INT = ERROR_LINE();
	DECLARE @ErrorMessage NVARCHAR(300) = ERROR_MESSAGE();	
	DECLARE @ErrorSeverity INT = ERROR_SEVERITY();
	DECLARE @ErrorState INT = ERROR_STATE();
	DECLARE @CUSTOMIZED_ERROR_NUM INT = ERROR_NUMBER() + 100000;
/*
	select
		@SpName
	,	@ErrorNumber
	,	@ErrorLine
	,	@ErrorMessage
	,	@ErrorSeverity
	,	@ErrorState
*/

	insert into
		sys_sql_error
	(
		sp_name
	,	error_num
	,	error_line
	,	error_msg
	,	error_severity
	,	error_state
	,	create_dt
	)
	values(
		@SpName
	,	@ErrorNumber
	,	@ErrorLine
	,	@ErrorMessage
	,	@ErrorSeverity
	,	@ErrorState
	,	getdate()
	);

	--RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState);
	
	throw @CUSTOMIZED_ERROR_NUM, @ErrorMessage, 1
		
	

END


-- select * from sys_sql_error order by id desc
GO

GRANT EXECUTE ON [tam].[sp_system_HandleSqlError] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclModuleByUserIdDeptUnitCodeModuleId]
	@user_id varchar(20)
,	@dept_unit_code varchar(10)
,	@module_id int
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY
		
		select
			distinct C.module_id
		,	C.parent_module_id
		,	C.module_name
		,	C.module_desc
		,	C.module_path
		,	C.module_img
		,	C.is_visible_in_header_menu
		,	C.json_api_path
		,	C.json_html_path
		,	C.seq
		,	C.create_by
		,	C.create_dt
		,	C.update_by
		,	C.update_dt
		from
			acl_user_role A
		left join		
			acl_role_mod_perm B on A.role_id = B.role_id		
		left join
			acl_module C on B.module_id = C.module_id
		where
			A.user_id = @user_id
		and	A.dept_unit_code = @dept_unit_code
		and	C.module_id = @module_id

	END TRY
	BEGIN CATCH
		
		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclModuleByUserIdDeptUnitCodeModuleId] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclModulePermissionByRoleIdModuleId]
	@role_id int
,	@module_id int
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY

		select
			distinct C.perm_id
		,	C.perm_name
		,	C.perm_desc
		,	C.create_by
		,	C.create_dt
		,	C.update_by
		,	C.update_dt
		from
			acl_role_mod_perm B 
		left join
			acl_perm C on B.perm_id = C.perm_id
		where
			B.role_id = @role_id
		and B.module_id = @module_id
	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclModulePermissionByRoleIdModuleId] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclModulePermissionByUserIdDeptUnitCodeModuleId]
	@user_id varchar(20)
,	@dept_unit_code varchar(10)
,	@module_id int
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	
	BEGIN TRY

		select
			distinct C.perm_id
		,	C.perm_name
		,	C.perm_desc
		,	C.create_by
		,	C.create_dt
		,	C.update_by
		,	C.update_dt
		from
			acl_user_role A
		left join
			acl_role_mod_perm B on A.role_id = B.role_id
		left join
			acl_perm C on B.perm_id = C.perm_id
		where
			A.user_id = @user_id
		and	A.dept_unit_code = @dept_unit_code
		and B.module_id = @module_id

	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH

END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclModulePermissionByUserIdDeptUnitCodeModuleId] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclModulesByUserIdDeptUnitCodeParentModuleId]
	@user_id varchar(20)
,	@dept_unit_code varchar(10)
,	@parent_module_id int
,	@is_visible_in_header_menu tinyint = 1 
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY
		
		select
			distinct B.module_id
		,	B.parent_module_id
		,	B.module_name
		,	B.module_desc
		,	B.module_path
		,	B.module_img
		,	B.json_api_path
		,	B.json_html_path
		,	B.is_visible_in_header_menu
		,	B.seq
		,	case when D.child_cnt is null then 0 else D.child_cnt end as child_cnt
		,	B.create_by
		,	B.create_dt
		,	B.update_by
		,	B.update_by
		from
			acl_role_mod_perm A
		left join
			acl_module B on A.module_id = B.module_id
		left join
		(
			select
				D1.parent_module_id
			,	count(D1.module_id) as child_cnt
			from
				acl_module D1
			where
				(D1.is_visible_in_header_menu = @is_visible_in_header_menu or @is_visible_in_header_menu is null)
			group by
				D1.parent_module_id
		) D on B.module_id = D.parent_module_id
		inner join
		(
			select
				A.role_id
			from
				acl_user_role A
			where
				A.user_id = @user_id 
			and A.dept_unit_code = @dept_unit_code
		) E on E.role_id = A.role_id
		where
			(
				B.parent_module_id = @parent_module_id 
			or	(B.parent_module_id is null and @parent_module_id is null)
		)
		order by
			B.seq

	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclModulesByUserIdDeptUnitCodeParentModuleId] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclRoleDeptByUserId]
	@user_id varchar(20)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY
		
		select
			dept_unit_code
		,	min(A.role_id) as role_id
		from
			acl_user_role A			
		where
			user_id = @user_id
		group by
			A.dept_unit_code
		order by
			A.dept_unit_code asc

	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclRoleDeptByUserId] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclRolesByUserIdDeptUnitCode]
	@user_id varchar(20)
,	@dept_unit_code varchar(10)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY

		select
			A.role_id
		,	A.role_name
		,	A.role_desc
		,	B.dept_unit_code
		,	A.create_by
		,	A.create_dt
		,	A.update_by
		,	A.update_dt
		from
			acl_role A
		left join
			acl_user_role B on A.role_id = B.role_id
		where
			B.user_id = @user_id
		and (B.dept_unit_code = @dept_unit_code or @dept_unit_code is null)

	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclRolesByUserIdDeptUnitCode] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclRolesByUserIdRoleId]
	@user_id varchar(20)
,	@role_id int
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY

		select
			A.role_id
		,	A.role_name
		,	A.role_desc
		,	B.dept_unit_code
		,	A.create_by
		,	A.create_dt
		,	A.update_by
		,	A.update_dt
		from
			acl_role A
		left join
			acl_user_role B on A.role_id = B.role_id
		where
			(B.user_id = @user_id or @user_id is null)
		and (B.role_id = @role_id or @role_id is null)

	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclRolesByUserIdRoleId] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclUserByUserId]
	@user_id varchar(20)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY

		select top 1
			A.user_id
		,	A.salu_code
		,	A.fam_name
		,	A.oth_name
		,	A.dept_unit_code
		,	A.email
		,	A.username
		,	B.last_login_dt	
		,	A.role_dept
		,	A.staff_std_type
		,	A.is_inactive
		,	A.ip_range
		,	A.create_by
		,	A.create_dt
		,	A.update_by
		,	A.update_dt
		from
		(
			select
				cast(A.user_id as varchar(20)) as user_id
			,	A.salu_code
			,	A.fam_name
			,	A.oth_name
			,	A.dept_unit_code
			,	A.email
			,	A.username
			,	A.role_dept
			,	A.staff_std_type
			,	A.is_inactive
			,	A.ip_range
			,	A.create_by
			,	A.create_dt
			,	A.update_by
			,	A.update_dt
			from
				acl_user A
			where
				A.user_id = @user_id
		) A
		left join
			acl_user_last_login B on B.user_id = A.user_id

	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclUserByUserId] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetAclUserByUsername]
	@username varchar(30)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY
		select
			A.user_id
		,	A.salu_code
		,	A.fam_name
		,	A.oth_name
		,	A.dept_unit_code
		,	A.email
		,	A.username
		,	B.last_login_dt	
		,	A.role_dept
		,	A.staff_std_type
		,	A.is_inactive
		,	A.ip_range
		,	A.create_by
		,	A.create_dt
		from
			acl_user A
		left join
			acl_user_last_login B on B.user_id = A.user_id
		where
			A.username = @username
	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetAclUserByUsername] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetActivity]
AS
BEGIN
	SET NOCOUNT ON;

	SELECT
		activity_id
	,	activity_name
	,	CONVERT(varchar(10), start_date, 120)	AS start_date
	,	CONVERT(varchar(10), end_date, 120)		AS end_date
	,	CASE language
			WHEN 'EN'   THEN 'English'
			WHEN 'ZH'   THEN 'Chinese'
			WHEN 'BOTH' THEN 'Both'
			ELSE language
		END									AS language
	,	organiser
	,	create_by
	,	CONVERT(varchar(16), create_dt, 120)	AS create_dt
	FROM
		tam.tam_activity
	ORDER BY
		activity_id DESC;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetActivity] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetActivityPurposeList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_activity_purpose] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetActivityPurposeList] TO [local_db_user];
GO

CREATE PROCEDURE [tam].[sp_tam_GetComponentList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_component] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetComponentList] TO [local_db_user];
GO

CREATE PROCEDURE [tam].[sp_tam_GetCurricularRequirementList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_curricular_requirement] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetCurricularRequirementList] TO [local_db_user];
GO

CREATE PROCEDURE [tam].[sp_tam_GetDefaultAclModuleByUserIdDeptUnitCode]
	@user_id varchar(20)
,	@dept_unit_code varchar(20)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	BEGIN TRY	

		select 
			A.role_id
		,	A.role_name
		,	A.role_desc
		,	A.default_module_id as module_id
		,	C.parent_module_id
		,	C.module_name
		,	C.module_desc
		,	C.module_path
		,	C.module_img
		,	C.json_api_path
		,	C.json_html_path
		from 
			acl_role A
		inner join
			acl_user_role B on B.user_id = @user_id and B.dept_unit_code = @dept_unit_code and A.role_id = B.role_id and B.role_id is not null
		inner join
			acl_module C on C.module_id = A.default_module_id
		inner join
			acl_role_mod_perm D on D.role_id = B.role_id and D.module_id = A.default_module_id and D.perm_id = tam.const_AclPerm_Read()
		order by
			A.default_module_id desc

	END TRY
	BEGIN CATCH

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetDefaultAclModuleByUserIdDeptUnitCode] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_GetDeptList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_dept] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetDeptList] TO [local_db_user];
GO

CREATE PROCEDURE [tam].[sp_tam_GetLearningOutcomeList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_learning_outcome] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetLearningOutcomeList] TO [local_db_user];
GO

CREATE PROCEDURE [tam].[sp_tam_GetQualityList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_quality] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetQualityList] TO [local_db_user];
GO

CREATE PROCEDURE [tam].[sp_tam_GetQuestionnaireQuestionList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq, mapping_type, curricular_requirement_id
	FROM [tam].[tam_mtr_questionnaire_question]
	WHERE rec_status = 'A'
	ORDER BY seq, name;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetQuestionnaireQuestionList] TO [local_db_user];
GO

CREATE PROCEDURE [tam].[sp_tam_GetSocietyList]
AS
BEGIN
	SET NOCOUNT ON;
	SELECT id, code, name, seq FROM [tam].[tam_mtr_society] WHERE rec_status = 'A' ORDER BY seq, name;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_GetSocietyList] TO [local_db_user];
GO

CREATE PROCEDURE [tam].[sp_tam_InsertActivity]
	@activity_name			nvarchar(200)
,	@start_date				date
,	@end_date				date
,	@language				varchar(10)
,	@organiser				nvarchar(200)
,	@create_by				varchar(50)
,	@form_data				nvarchar(max) = NULL
AS
BEGIN
	SET NOCOUNT ON;

	INSERT INTO tam.tam_activity
		(activity_name, start_date, end_date, language, organiser, create_by, form_data, create_dt)
	VALUES
		(@activity_name, @start_date, @end_date, @language, @organiser, @create_by, @form_data, GETDATE());

	SELECT SCOPE_IDENTITY() AS inserted_id;
END
GO

GRANT EXECUTE ON [tam].[sp_tam_InsertActivity] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_tam_UpdateUserLastLoginDt]
	@user_id varchar(20)
,	@username varchar(20)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	SET TRANSACTION ISOLATION LEVEL serializable;

	BEGIN TRY

		-- Transaction start
		BEGIN TRANSACTION;

		merge 
			acl_user_last_login as target
		using
		(
			select
				@user_id as user_id
			,	@username as username
		) as source
		on
			target.user_id = source.user_id
		when matched then
			update set
				target.username = @username
			,	target.last_login_dt = getdate()
		when not matched by target then
			insert 
				(user_id, username, last_login_dt, create_dt)
			values
				(@user_id, @username, getdate(), getdate());

		--commit transaction
		COMMIT TRANSACTION;
		
	END TRY
	BEGIN CATCH
		
		 IF @@TRANCOUNT > 0
			ROLLBACK TRANSACTION;

		DECLARE @SpName varchar(100) = OBJECT_NAME(@@PROCID);
		exec sp_system_HandleSqlError
			@SpName
		;

	END CATCH

END
GO

GRANT EXECUTE ON [tam].[sp_tam_UpdateUserLastLoginDt] TO [local_db_user]
GO

CREATE PROCEDURE [tam].[sp_rpt_GetAttendanceReportData]
AS
BEGIN
	SET NOCOUNT ON;

	SELECT
		[attendance_id]
	, 	[attendance_date]
	, 	[student_no]
	, 	[student_name]
	, 	[department]
	, 	[activity_name]
	, 	[attendance_status]
	, 	[check_in_time]
	FROM [tam].[tam_attendance_report]
	WHERE [rec_status] = 'A'
	ORDER BY [attendance_date], [attendance_id];
END
GO

GRANT EXECUTE ON [tam].[sp_rpt_GetAttendanceReportData] TO [local_db_user];
GO

/* ---- schema patch: activity create-form payload column ----
   Stores the full submitted create-form as JSON (tam_activity.form_data),
   and extends sp_tam_InsertActivity to accept it. Already present in a fresh
   tam_schema.sql; this idempotent patch keeps an existing DB in sync.
   Safe to re-run; preserves existing rows. */
IF COL_LENGTH('tam.tam_activity', 'form_data') IS NULL
    ALTER TABLE [tam].[tam_activity] ADD [form_data] nvarchar(max) NULL;
GO

ALTER PROCEDURE [tam].[sp_tam_InsertActivity]
    @activity_name        nvarchar(200)
,   @start_date           date
,   @end_date             date
,   @language             varchar(10)
,   @organiser            nvarchar(200)
,   @create_by            varchar(50)
,   @form_data            nvarchar(max) = NULL
AS
BEGIN
    SET NOCOUNT ON;
    INSERT INTO tam.tam_activity
        (activity_name, start_date, end_date, language, organiser, create_by, form_data, create_dt)
    VALUES
        (@activity_name, @start_date, @end_date, @language, @organiser, @create_by, @form_data, GETDATE());
    SELECT SCOPE_IDENTITY() AS inserted_id;
END
GO

