<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Module ID
|--------------------------------------------------------------------------
|
*/
define('TAM_MODULE_ID_REPORT', 1002);




define('TAM_MODULE_ID_NOTIFICATION', 5000);


/*
|--------------------------------------------------------------------------
| Report Type ID
|--------------------------------------------------------------------------
| Add a REPORT_TYPE_ID_* per report type as reports are introduced.
*/

/*
|--------------------------------------------------------------------------
| Report ID
|--------------------------------------------------------------------------
| Add a REPORT_ID_* per report, matched by json/html/Report::load_select_form().
*/


/*
|--------------------------------------------------------------------------
| System Error Codes
|--------------------------------------------------------------------------
*/
define('ERROR_CODE_UNAUTHORIZED', '9002');
define('ERROR_CODE_UNKNOWN_USER', '9007');
define('ERROR_CODE_PERMISSION_DENIED', '9010');
define('ERROR_CODE_MISSING_REQUIRED_FIELD', '9011');
define('ERROR_CODE_SESSION_EXPIRED', '9013');
define('ERROR_CODE_MENU_ITEM_NOT_FOUND', '9018');

/*
|--------------------------------------------------------------------------
| Status Codes
|--------------------------------------------------------------------------
*/
// define('STATUS_ACTIVE', 'A');
// define('STATUS_INACTIVE', 'I');

/*
|--------------------------------------------------------------------------
|Permission ID
|--------------------------------------------------------------------------
|
*/
define('PERMISSION_ID_Read', 1);
define('PERMISSION_ID_Create', 2);
define('PERMISSION_ID_Update', 3);
define('PERMISSION_ID_Delete', 4);
define('PERMISSION_ID_ExportExcel', 5);
define('PERMISSION_ID_ImportExcel', 6);

/*
|--------------------------------------------------------------------------
| System Value
|--------------------------------------------------------------------------
*/
define('VALUE_EMPTY', 'N/A');
define('DATE_FORMAT', 'Y-m-d');
define('DATETIME_FORMAT', 'Y-m-d H:i:s');


/*
|--------------------------------------------------------------------------
| System Job Status Code
|--------------------------------------------------------------------------
|
*/

/*
|--------------------------------------------------------------------------
| Cron Job System Name
|--------------------------------------------------------------------------
|
*/

/*
| System Email Status Code
|--------------------------------------------------------------------------
|
*/

/*
|--------------------------------------------------------------------------
| File Format
|--------------------------------------------------------------------------
|
*/
define("FILE_FORMAT_XLS", "xls");
define("FILE_FORMAT_CSV", "csv");



/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
*/



/*
|--------------------------------------------------------------------------
| Session Key
|--------------------------------------------------------------------------
*/
define('SESSION_KEY_SSO_USER_PROFILE', 'sso_user_profile');
define('SESSION_KEY_TAM_USER_PROFILE', 'tam_user_profile');

/*
|--------------------------------------------------------------------------
| DB Query Return Type
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Role
|--------------------------------------------------------------------------
|
*/


/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| TAM Activity create-form constants
|--------------------------------------------------------------------------
| Values the create-form JavaScript compares against. The "Others" ids match
| the seeded lookup row / inline objective-evaluation list built in the
| json/html controller.
*/
defined('ACTIVITY_OBJECTIVES_OTHERS')    OR define('ACTIVITY_OBJECTIVES_OTHERS', 4);         // tam_mtr_activity_purpose "Others" (OTH) id
defined('ACTIVITY_OBJ_EVALUATION_OTHER') OR define('ACTIVITY_OBJ_EVALUATION_OTHER', 99);     // inline obj-evaluation "Others" id

