<?php 
//http://host/myphpbackup/backup.php?Username=wylie&Password=36223
$website = 'yourWebsiteName';
$debug = true;
ini_set('max_execution_time',300);

//Credentials to run this script from webpage
$username = 'username';
$password = 'password';


// DATABASE DUMP OPTIONS
$database_dump = true;
$dbhost				=	'localhost';
$dbuser				=	'dbUser';
$dbpwd				=	'dbPassword';
$dbname			=	'dbnameToBackup';
$db_dump_file	=	'backups/sql_dump.sql';

// ZIP FOLDER OPTIONS
$zip_folders = true;
//adds any addtional folders in your website to the backup
//$directory_list[] = '../uploads';
//$directory_list[] = 'folder3'; etc


//file to attach to email.
$zip_file_name = 'backups/'.$website.'_backup.zip';

// EMAIL OPTIONS
$send_backups_via_mail 			= false;
$send_backups_log_via_mail 		= true;
$show_file_list_in_log 				= true;
$from_address							= 'some@email.address';
$from_name 								= $website.' Website backups';
$to_address								= 'some@email.address';//traget to email the backup too
$subject 									= 'Backup/Log from '.$website;
$body 										= 'your website backup is attached';

//FTP DESTINATIONS OPTIONS
$ftp_client 								= true;
$ftp_host								= 'ftp.yourdomain';
$ftp_username						= 'FTPuser';
$ftp_password						= 'FTPpassword';
$ftp_appendDateToFileName 	= true;


?>