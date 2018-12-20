<?php

error_reporting(E_ALL); 
ini_set('display_errors', 1);

require_once ('backup_config.php');
$status = "";

//CHECK CREDENTIALS
if (($_REQUEST['Username'] == $username) && ($_REQUEST['Password'] == $password)){
	if (isset($_REQUEST['Submit'])){
		$send_backups_log_via_mail = false;
		$ftp_client = false;
	}


require_once ('css.php');
$output.= "<h2>Backup of $website</h2>";

//DUMP THE DATABASE
if ($database_dump){
	@unlink( $db_dump_file );
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {//windows
    	passthru("mysqldump  -u$dbuser -p$dbpwd $dbname > $db_dump_file");
	} else {//linus
   		passthru("/usr/bin/mysqldump --opt --host=$dbhost --user=$dbuser --password=$dbpwd $dbname > $db_dump_file");
	}
	
	
	if (!file_exists($db_dump_file) or (filesize($db_dump_file) < 500)){
		$output.= '<div class="warning">MYSQL dump file error</div>';
		$status = 'FAILED: ';	
	}
}


//ZIP FOLDERS
	require_once ('classes/class.zip.php');
	@unlink( $zip_file_name );
	$zip_backup = new zip;
	$zipfile_status = $zip_backup->create($zip_file_name);
	if ($database_dump){$zip_backup->add_file($db_dump_file);}
	if ($zip_folders){
		if (isset($directory_list)){
			foreach ($directory_list as $directory){
				$zip_backup->add_directory($directory);
			}
		}
	}
	$zip_status = $zip_backup->close();
	if ($zipfile_status){echo 'zip ok';};
	if ($zip_status['zipped_size'] == "" or ($zip_backup->error === true)){
		$output.= '<div class="warning">Zip file error.</div>';
		$status = 'FAILED: ';
	}
	//$zip_status = implode('<br/>',$zip_status);
	$file_list =  $zip_backup->output;
	$output.= '<div class="ok">Orignal size of files - '.round($zip_status['unzipped_size']/1000000,1).'MB </div>';
	$output.= '<div class="ok">Compressed size - '.round($zip_status['zipped_size']/1000000,1).'MB </div>';
	$output.= '<div class="ok">Number of files added - '.$zip_status['filecount'].'</div>';
	$download_link = '<div class="link"><a href="'.$zip_file_name.'">You can download your back up file here</a></div>';


//EMAIL BACKUPS
if ($send_backups_via_mail){
	set_include_path('classes/phpmailer');
	require_once("classes/phpmailer/phpmailer.inc.php");
	$mail = new phpmailer;
	$mail->From = $from_address;
	$mail->FromName = $from_name;
	$mail->AddAddress($to_address);
	$mail->AddAttachment($zip_file_name);
	$mail->IsHTML(false);    // set email format to HTML
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->Send(); // send message
	$output.= '<div class="ok">Backup sent via email to '.$to_address.'</div>';
}


//FTP DATA TO SERVER
if ($ftp_client){
	require_once ('classes/class.FTPClient.php');
	$ftp = new ftp_client($ftp_host,$ftp_username,$ftp_password);
	if (!$ftp->error){
		if ($ftp_appendDateToFileName){
			$remoteFileName = $website.'_backup'.'_'.date(dmy).'.zip';
		}else{
			$remoteFileName = $website_.'backup.zip';
		}	
		$ftp->upload($zip_file_name,$remoteFileName);
		$ftp->close();
	}
	if ($ftp->error === true){$status = 'FAILED: ';}
	$output.= $ftp->output;
}

//Email LOG
if ($send_backups_log_via_mail){
	set_include_path('classes/phpmailer');
	require_once("classes/phpmailer/phpmailer.inc.php");
	$mail = new phpmailer;
	$mail->From = $from_address;
	$mail->FromName = $from_name;
	$mail->AddAddress($to_address);
	$mail->IsHTML(true);    // set email format to HTML
	$mail->Subject = $status.$subject;
	if ($show_file_list_in_log){$log_output = $output.'<div class="log">Zip log</div>'.$file_list;}else{$log_output = $output;}
	$mail->Body = $log_output;
	$mail->Send(); // send message
	$output.= '<div class="ok">Backup logfile sent via email to '.$to_address.'</div>';
}


//OUTPUT TO CONSOLE
echo $output;
echo $download_link;
echo '<br/><div class="ok">Output log file list below....</div>';
echo $file_list;
echo '<br/><div class="ok">Scroll to top for download link</div>';

}else{echo 'Bad login';}
?>