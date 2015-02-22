<?php

// Config file for travis build

if (!defined('SERVER_INSTANCE')) {
	// The Server Instance constant is used to help ease web applications with multiple environments.
	// Feel free to use, change or ignore.
	define('SERVER_INSTANCE', 'dev');

	switch (SERVER_INSTANCE) {
		case 'dev':
		case 'test':
		case 'stage':
		case 'prod':
			/* Constant to allow/disallow remote access to the admin pages
			 * e.g. the generated form_drafts, codegen, or any other script that calls QApplication::CheckRemoteAdmin()
			 *
			 * If set to TRUE, anyone can access those pages.
			 * If set to FALSE, only localhost can access those pages.
			 * If set to an IP address (e.g. "12.34.56.78"), then only localhost and 12.34.56.78 can access those pages.
			 * If set to a comma-separate list of IP addresses, then localhoost and any of those IP addresses can access those pages.
			 *
			 * Of course, you can also feel free to remove QApplication::CheckRemoteAdmin() call on any of these pages,
			 * which will completely ignore ALLOW_REMOTE_ADMIN altogether.
			 */
			define('ALLOW_REMOTE_ADMIN', false);


			/* Constants for Document Root (and Virtual Directories / Subfoldering)
			 *
			 * IMPORTANT NOTE FOR WINDOWS USERS
			 * Please note that all paths should use standard "forward" slashes instead of "backslashes".
			 * So windows paths would look like "c:/wwwroot" instead of "c:\wwwroot".
			 *
			 * Please specify the "Document Root" here.  This is the top level filepath for your web application.
			 * If you are on a installation that uses virtual directories, then you must specify that here, as well.
			 *
			 * For example, if your example web application where http://my.domain.com/index.php points to
			 * /home/web/htdocs/index.php, then you must specify:
			 *		__DOCROOT__ is defined as '/home/web/htdocs'
			 *		(note the leading slash and no ending slash)
			 * On Windows, if you have http://my.domain.com/index.php pointing to c:\webroot\files\index.php, then:
			 *		__DOCROOT__ is defined as 'c:/webroot/files'
			 *		(again, note the leading c:/ and no ending slash)
			 *
			 * Next, if you are using Virtual Directories, where http://not.my.domain.com/~my_user/index.php
			 * (for example) points to /home/my_user/public_html/index.php, then:
			 *		__DOCROOT__ is defined as '/home/my_user/public_html'
			 *		__VIRTUAL_DIRECTORY__ is defined as '/~my_user'
			 *
			 * Finally, if you have installed QCubed within a SubDirectory of the Document Root, so for example
			 * the QCubed "index.php" page is accessible at http://my.domain.com/frameworks/qcubed/index.php, then:
			 *		__SUBDIRECTORY__ is defined as '/frameworks/qcubed'
			 *		(again, note the leading and no ending slash)
			 *
			 * In combination with Virtual Directories, if you (for example) have the QCubed "index.php" page
			 * accessible at http://not.my.domain.com/~my_user/qcubed/index.php, and the index.php resides at
			 * c:\users\my_user\public_html\index.php, then:
			 *		__DOCROOT__ is defined as 'c:/users/my_user/public_html'
			 *		__VIRTUAL_DIRECTORY__ is defined as '/~my_user'
			 *		__SUBDIRECTORY__ is defined as '/qcubed'
			 *      /var/www/qcubed/wwwroot
			 */
			define ('__DOCROOT__', __WORKING_DIR__);
			define ('__VIRTUAL_DIRECTORY__', '');
			if (!defined ('__SUBDIRECTORY__')) {
				define ('__SUBDIRECTORY__', '');
			}

			/*
			 * The project directory is where your editable project files go. These include files
			 * that will be generated by the code generator. 
			 */
			
			// for travis build only, we point to the project directory inside the install directory
			define ('__PROJECT__', __DOCROOT__ . __SUBDIRECTORY__ . '/install/project');
			define ('__INCLUDES__', __PROJECT__ . '/includes');
			define ('__QCUBED__', __INCLUDES__); // on the way to deprecation

			/*
			 * These definitions will hardly change, but you may change them based on your setup
			 */
			// Will be defined in the test.php file
			//define ('__CONFIGURATION__', __INCLUDES__ . '/configuration');
			// The directory where the external libraries are placed, that are not in composer
			define ('__EXTERNAL_LIBRARIES__', __DOCROOT__ . '/vendor');
			// The application includes directory
			define ('__APP_INCLUDES__', __INCLUDES__ . '/app_includes');

			/*
			 * If you are using Apache-based mod_rewrite to perform URL rewrites, please specify "apache" here.
			 * Otherwise, specify as "none"
			 */
			define ('__URL_REWRITE__', 'none');

			/* Absolute File Paths for Internal Directories
			 *
			 * Please specify the absolute file path for all the following directories in your QCubed-based web
			 * application.
			 *
			 * Note that all paths must start with a slash or 'x:\' (for windows users) and must have
			 * no ending slashes.  (We take advantage of the __INCLUDES__ to help simplify this section.
			 * But note that this is NOT required.  These directories can also reside outside of the
			 * Document Root altogether.  So feel free to use or not use the __DOCROOT__ and __INCLUDES__
			 * constants as you wish/need in defining your other directory constants.)
			 */

			// The QCubed Directories
			// Includes subdirectories for QCubed Customizations in CodeGen and QForms, i18n PO files, QCache storage, etc.
			// Also includes the _core subdirectory for the QCubed Core
			define ('__PLUGINS__', __DOCROOT__ . __SUBDIRECTORY__ . '/vendor/qcubed/plugin');

			define ('__TMP__', __PROJECT__  . '/tmp');
			define ('__CACHE__', __TMP__ . '/cache');
			define ('__PLUGIN_TMP__', __TMP__ . '/plugin.tmp/');

			// The QCubed Core
			define ('__QCUBED_CORE__', __DOCROOT__ . __SUBDIRECTORY__ . '/includes');

			// Destination for Code Generated class files
			define ('__MODEL__', __INCLUDES__ . '/model' );
			define ('__MODEL_GEN__', __PROJECT__ . '/generated/model_base' );
			define ('__MODEL_CONNECTOR__', __INCLUDES__ . '/meta_controls' );
			define ('__META_CONTROLS_GEN__', __PROJECT__ . '/generated/meta_base' );

			/* Relative File Paths for Web Accessible Directories
			 *
			 * Please specify the file path RELATIVE FROM THE DOCROOT for all the following web-accessible directories
			 * in your QCubed-based web application.
			 *
			 * For some directories (e.g. the Examples site), if you are no longer using it, you STILL need to
			 * have the constant defined.  But feel free to define the directory constant as blank (e.g. '') or null.
			 *
			 * Note that constants must have a leading slash and no ending slash, and they MUST reside within
			 * the Document Root.
			 *
			 * (We take advantage of the __SUBDIRECTORY__ constant defined above to help simplify this section.
			 * Note that this is NOT required.  Feel free to use or ignore.)
			 */

			// Destination for generated form drafts and panel drafts. Relative to __DOCROOT__.
			define ('__FORM_DRAFTS__', __SUBDIRECTORY__ . '/install/project/generated/drafts');
			define ('__PANEL_DRAFTS__', __FORM_DRAFTS__ . '/panels');
			
			define ('__FORMBASE_CLASSES__', __PROJECT__ . '/generated/form_base');
			define ('__FORM_DRAFTS_FORM_LIST_ITEMS_PER_PAGE__', 20);
			define ('__FORM_DRAFTS_PANEL_LIST_ITEMS_PER_PAGE__', 8);

			// __DOCROOT__ relative location of QCubed-specific Web Assets (JavaScripts, CSS, Images, and PHP Pages/Popups)
			// Note: These locations are for use by the framework only. You should put your own files in __APP*_ASSETS__ directories defined below
			define ('__QCUBED_ASSETS__', __SUBDIRECTORY__ . '/assets');
			define ('__PROJECT_ASSETS__', __SUBDIRECTORY__ . '/install/project/assets');
			
			define ('__JS_ASSETS__', __QCUBED_ASSETS__ . '/js');
			define ('__CSS_ASSETS__', __QCUBED_ASSETS__ . '/css');
			define ('__IMAGE_ASSETS__', __QCUBED_ASSETS__ . '/images');
			define ('__PHP_ASSETS__', __QCUBED_ASSETS__ . '/php');
			

			// Location of asset files for your application
			define ('__APP_JS_ASSETS__', __PROJECT_ASSETS__ . '/js');
			define ('__APP_CSS_ASSETS__', __PROJECT_ASSETS__ . '/css');
			define ('__APP_IMAGE_ASSETS__', __PROJECT_ASSETS__ . '/images');
			define ('__APP_PHP_ASSETS__', __PROJECT_ASSETS__ . '/php');
			define ('__PLUGIN_ASSETS__',  __SUBDIRECTORY__ . '/vendor/qcubed/plugin');
			define ('__IMAGE_CACHE__', __APP_IMAGE_ASSETS__ . '/cache');

			// There are two ways to add jQuery JS files to QCubed. Either by absolute paths (Google CDN of
			// the jQuery library is awesome! It's the default option below) - or by using the jQuery
			// installation that's local to QCubed (in that case, paths must be relative to __JS_ASSETS__
			define ('__JQUERY_BASE__', ' http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
			define ('__JQUERY_EFFECTS__', ' http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');

			// If you want to use the local jQuery files, specify the paths relative to __JS_ASSETS__
			// or just uncomment the 2 lines below.
			// define ('__JQUERY_BASE__',  'jquery/jquery.min.js');
			// define ('__JQUERY_EFFECTS__',   'jquery/jquery-ui.custom.min.js');

			// The core qcubed javascript file to be used.
			// In production or as a performance tweak, you may want to use the compressed "_qc_packed.js" library
			define ('__QCUBED_JS_CORE__',  'qcubed.js');
			//define ('__QCUBED_JS_CORE__',  '_qc_packed.js');

			define ('__JQUERY_CSS__', 'jquery-ui-themes/ui-qcubed/jquery-ui.custom.css');

			// Location of the QCubed-specific web-based development tools, like codegen.php
			define ('__DEVTOOLS__', __PHP_ASSETS__ . '/_devtools');

			// Location of the Examples site
			define ('__EXAMPLES__', __PHP_ASSETS__ . '/examples');

			// Location of .po translation files
			define ('__QI18N_PO_PATH__', __QCUBED__ . '/i18n');

			/* Database Connection SerialArrays
			 *
			 * Note that all Database Connections are defined as constant serialized arrays.  QCubed supports
			 * connections to an unlimited number of different database sources.  Each database source, referenced by
			 * a numeric index, will have its DB Connection SerialArray stored in a DB_CONNECTION_# constant
			 * (where # is the numeric index).
			 *
			 * The SerialArray can have the following keys:
			 * "adapter" (Required), options are:
			 *		MySql (MySQL v4.x, using the old mysql extension)
			 *		MySqli (MySQL v4.x, using the new mysqli extension)
			 *		MySqli5 (MySQL v5.x, using the new mysqli extension)
			 *		SqlServer (Microsoft SQL Server)
			 *		SqlServer2005 (Microsoft SQL Server 2005/2008 using new sqlsrv extension, Windows only)
			 *		PostgreSql (PostgreSQL)
			 * "server" (Required) is the db server's name or IP address, e.g. localhost, 10.1.1.5, etc.
			 * "port" is the port number - default is the server-specified default
			 * "database", "username", "password" should be self explanatory
			 * "dateformat" is an optional value for the desired db date format, the default value is
			 *		'YYYY-MM-DD hhhh:mm:ss' if not defined or null
			 * "profiling" is true or false, defining whether or not you want to enable DB profiling - default is false
			 *		NOTE: Profiling should only be enabled when you are actively wanting to profile a
			 *		specific PHP script or scripts.  Because of SIGNIFICANT performance degradation,
			 *		it should otherwise always be OFF.
			 * "ScriptPath": you can have CodeGen virtually add additional FKs, even though they are
			 * 		not defined as a DB constraint in the database, by using a script to define what
			 * 		those constraints are.  The path of the script can be defined here. - default is blank or none
			 * Note: any option not used or set to blank will result in using the default value for that option
			 */
			require_once (getenv("DB") . '.inc.php');

			// Additional Database Connection Strings can be defined here (e.g. for connection #2, #3, #4, #5, etc.)
			//			define('DB_CONNECTION_2', serialize(array('adapter'=>'SqlServer', 'server'=>'localhost', 'port'=>null, 'database'=>'qcubed', 'username'=>'root', 'password'=>'', 'profiling'=>false)));
			//			define('DB_CONNECTION_3', serialize(array('adapter'=>'MySqli', 'server'=>'localhost', 'port'=>null, 'database'=>'qcubed', 'username'=>'root', 'password'=>'', 'profiling'=>false)));
			//			define('DB_CONNECTION_4', serialize(array('adapter'=>'MySql', 'server'=>'localhost', 'port'=>null, 'database'=>'qcubed', 'username'=>'root', 'password'=>'', 'profiling'=>false)));
			//			define('DB_CONNECTION_5', serialize(array('adapter'=>'PostgreSql', 'server'=>'localhost', 'port'=>null, 'database'=>'qcubed', 'username'=>'root', 'password'=>'', 'profiling'=>false)));
			//			define('DB_CONNECTION_6', serialize(array('adapter' => 'InformixPdo', 'host' => 'maxdata', 'server' => 'maxdata', 'service' => 9088, 'protocol' => 'onsoctcp', 'database' => 'qcubed', 'username' => 'root', 'password' => '', 'profiling' => false)));

			// Maximum index of the DB connections defined by DB_CONNECTION_# constants above
			// When reading the DB_CONNECTION_# constants, it will only go up to (and including) the index defined here
			// See ApplicationBase::InitializeDatabaseConnections()
			define ('MAX_DB_CONNECTION_INDEX', 9);

			/** The value for QApplication::$EncodingType constant */
			define('__QAPPLICATION_ENCODING_TYPE__', 'UTF-8');

			// (For PHP > v5.1) Setup the default timezone (if not already specified in php.ini)
			if ((function_exists('date_default_timezone_set')) && (!ini_get('date.timezone')))
				date_default_timezone_set('America/Los_Angeles');


			/*
			 * Caching support for QCubed (Vaibhav Kaushal Jan 21, 2012)
			 * Determines which class as a Cache Provider. It should be a subclass of QAbstractCacheProvider.
			 * Setting it to null will disable caching. Current implentations are
			 *
			 * "QCacheProviderMemcache": this will use Memcache as the caching provider.
			 *   You must have the 'php5-memcache' package installed for this provider to work.
			 *
			 * "QCacheProviderLocalMemory": a local memory cache provider with a lifespan of the request
			 *   or session (if KeepInSession is configured).
			 *
			 * "QCacheProviderAPC": supports the APC interface. To use it, use PECL to install either
			 * APC or APCu.
			 *
			 * "QCacheProviderNoCahce": provider which does no caching at all
			 *
			 * "QMultiLevelCacheProvider": a provider that can combine multiple providers into one.
			 *   This can be used for example to combine the LocalMemory cache provider with the Memcache based provider.
			 */
			define("CACHE_PROVIDER_CLASS", null);
 
			/*
			 * Options passed to the constructor of the Caching Provider class above.
			 * For QCacheProviderMemcache, it's an array, where each item is an associative array of
			 * server configuration options.
			 * Please see the documentation for the constructor for each provider for a description of the accepted
			 * options.
			 */
			define ('CACHE_PROVIDER_OPTIONS' , serialize(
				array(
					 array('host' => '127.0.0.1', 'port' => 11211, ),
					 //array('host' => '10.0.2.2', 'port' => 11211, ), // adds a second server
				)
			) );

			/*
			 * Support for Watchers and automated updating of objects that display the results of table queries.
			 *
			 * The preferred way to setup your watcher is to make changes to the
			 * public/includes/controls/QWatcher.class.php file. However, you can also set up your watcher here
			 * using the following define. The main purpose of the define is to help with automated testing
			 * and the examples site.
			 */
			//define ('WATCHER_CLASS', 'QWatcherDB');

			/* Form State Handler. Determines which class is used to serialize the form in-between Ajax callbacks.
			 *
			 * Possible values are:
			 * "QFormStateHandler": This is the "standard" FormState handler, storing the base64 encoded session data
			 *	(and if requested by QForm, encrypted) as a hidden form variable on the page, itself.
			 *
			 * "QSessionFormStateHandler": Simple Session-based FormState handler.  Uses PHP Sessions so it's very straightforward
			 *	and simple, utilizing the session handling and cleanup functionality in PHP, itself.
			 *	The downside is that for long running sessions, each individual session file can get
			 *	very, very large, storing all hte various formstate data.  Eventually (if individual
			 *	session files are larger than 10MB), you can theoretically observe a geometrical
			 *	degradation of performance.
			 *
			 * "QFileFormStateHandler": This will store the formstate in a pre-specified directory (__FILE_FORM_STATE_HANDLER_PATH__)
			 *	on the file system. This offers significant speed advantage over PHP SESSION because EACH
			 *	form state is saved in its own file, and only the form state that is needed for loading will
			 *	be accessed (as opposed to with session, ALL the form states are loaded into memory
			 *	every time).
			 *	The downside is that because it doesn't utilize PHP's session management subsystem,
			 *	this class must take care of its own garbage collection/deleting of old/outdated
			 *	formstate files.
			 *
			 * "QDbBackedFormStateHandler": This will store the formstate in a predefined table in one of the DBs in the array above.
			 *    It provides a way to maintain the FormStates without creating too many files on the server.
			 *    It also makes sure that the application remains fast and provides all the features of QFileFormStateHandler.
			 *    The algorithm to periodically clean up the DB is also provided (just like QFileFormStateHandler) .
			 *
			 *    To use the QDbBackedFormStateHandler, the following two constants must be defined:
			 *       1. __DB_BACKED_FORM_STATE_HANDLER_DB_INDEX__ : It is the numerical index of the DB from the list of DBs defined
			 *             above where the table to store the FormStates is present. Note, it is the numerical Index, not the DB name.
			 *             e.g. If it is present in the DB_CONNECTION_1, then the value must be defined as '1'.
			 *       2. __DB_BACKED_FORM_STATE_HANDLER_TABLE_NAME__ : It is the name of the table where the FormStates must be stored
			 *              It must have following 4 columns:
			 *                  i) page_id: varchar(80) - It must be the primary key.
			 *                 ii) save_time: integer - This column should be indexed for performance reasons
			 *                iii) session_id: varchar(32) - This column should be indexed for performance reasons
			 *                 iv) state_data: text - This column must NOT be indexed otherwise it will degrade the performance.
			 *
			 * NOTE: Formstates can be large, depending on the complexity of your forms.
			 *       For MySQL, you might have to increase the max_allowed_packet variable in your my.cnf file to the maximum size of a formstate.
			 *       Also for MySQL, you should choose a MEDIUMTEXT type of column, rather than TEXT. TEXT is limited to 64KB,
			 *       which will not be big enough for moderately complex forms, and will result in data errors.
			 */
			define('__FORM_STATE_HANDLER__', 'QFormStateHandler');
				
			// If using the QFileFormStateHandler, specify the path where QCubed will save the session state files (has to be writeable!)
			define('__FILE_FORM_STATE_HANDLER_PATH__', __PROJECT__ . '/tmp');

			// If using the QDbBackedSessionHandler, define the DB index where the table to store the formstates is present
			define('__DB_BACKED_FORM_STATE_HANDLER_DB_INDEX__', 1);
			// If using QDbBackedSessionHandler, specify the table name which would hold the formstates (must meet the requirements laid out above)
			define('__DB_BACKED_FORM_STATE_HANDLER_TABLE_NAME__', 'qc_formstate');


			/*
			 * QCubed allows you to save / read / write your user PHP sessions in a database.
			 * This is immensely helpful when you want to develop your QCubed based application
			 * to support running on two different web servers with same data backends or with load balancing.
			 * If you are using QSessionFormStateHandler, it also automatically centralizes your formstates.
			 *
			 * To avail this feature, you must have a dedicated table in one of your databases above.
			 * The table must have 3 columns with follwing names and datatypes (note that column names should match exactly):
			 *
			 * [Column 1]
			 *      Name = id
			 *      Data Type = varchar / character varying with length of 32 characters (varchar(32))
			 *
			 * [Column 2]
			 *      Name = last_access_time
			 *      Data type = integer
			 *
			 * [Column 3]
			 *      Name = data
			 *      Data type = text
			 *
			 * For this to work, we need to know two things:
			 * 1. The DB_CONNECTION index (repeat: the numerical index) of the database from the list of databases above
			 *          where this table is located.
			 * 2. The name of the table in  the database.
			 *
			 * Notes:
			 * 1. if you do not want to use this feature, set the value of DB_BACKED_SESSION_HANDLER_DB_INDEX to 0.
			 * 2. It is recommended that you create a primary key on the 'id' field and an index on the 'last_access_time' field
			 *      to speed up the database queries.
			 * 3. This feature does not make use of the codegen feature. So you may exclude this table from being codegened.
			 */
			// The database index where the Session storage tables are present. Remember, define it as an integer.
			define("DB_BACKED_SESSION_HANDLER_DB_INDEX", 0);

			// The table name to be used for session data storage (must meet the requirements laid out above)
			define("DB_BACKED_SESSION_HANDLER_TABLE_NAME", "qc_session");

			// Define the Filepath for the error page (path MUST be relative from the DOCROOT)
			define('ERROR_PAGE_PATH', __PHP_ASSETS__ . '/error_page.php');

			// Define the Filepath for any logged errors
			define('ERROR_LOG_PATH', __TMP__ . '/error_log');

			// To Log ALL errors that have occurred, set flag to true
			//			define('ERROR_LOG_FLAG', true);

			// To enable the display of "Friendly" error pages and messages, define them here (path MUST be relative from the DOCROOT)
			//			define('ERROR_FRIENDLY_PAGE_PATH', __PHP_ASSETS__ . '/friendly_error_page.php');
			//			define('ERROR_FRIENDLY_AJAX_MESSAGE', 'Oops!  An error has occurred.\r\n\r\nThe error was logged, and we will take a look into this right away.');

			// If using HTML Purifier, the location of the writeable cache directory.
			//define ('__PURIFIER_CACHE__', __CACHE__ . '/purifier');

			break;
	}
}
?>
