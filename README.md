# phpmybackup

backup your website.

upload files to the root/myphpbackup of your website and admend backup_config.php file to suit.
then browse to the myphpbackup, login and run backup

OPTION/CONFIG file

$website = 'yourWebsiteName';// your website name to appear on backup file and emails
$debug = true;//show debugging info
ini_set('max_execution_time',300);//max time php allows for backup script to run

//Credentials to run this script from webpage
$username = 'username';//hardcoding username to use to login to perform backups
$password = 'password';//hardcoding password to use to login to perform backups


// DATABASE DUMP OPTIONS
$database_dump = true;                  //backup mysql databse
$dbhost				=	'localhost';            //mysql database location
$dbuser				=	'dbUser';               //mysql database username
$dbpwd				=	'dbPassword';           //mysql database password
$dbname			=	'dbnameToBackup';         //mysql database name
$db_dump_file	=	'backups/sql_dump.sql'; //name of mysql file to create for backup 

// ZIP FOLDER OPTIONS
$zip_folders = true;                    //backup addtional folders of your website
//$directory_list[] = '../uploads';     //add addtional folder you which to add to your backup
//$directory_list[] = 'folder3'; etc


//file to attach to email.
$zip_file_name = 'backups/'.$website.'_backup.zip'; //give filename for file that wil be atached to email

// EMAIL OPTIONS
$send_backups_via_mail 			= false;//send actual backup file via email
$send_backups_log_via_mail 		= true;//send backup LOG file via email
$show_file_list_in_log 				= true;//Show files backed up in log
//Email options
$from_address							= 'some@email.address'; 
$from_name 								= $website.' Website backups';
$to_address								= 'some@email.address';//traget to email the backup too
$subject 									= 'Backup/Log from '.$website;
$body 										= 'your website backup is attached';

//FTP DESTINATIONS OPTIONS
$ftp_client 								= true; //Send backup to an FTP server
$ftp_host								= 'ftp.yourdomain';
$ftp_username						= 'FTPuser';
$ftp_password						= 'FTPpassword';
$ftp_appendDateToFileName 	= true;
