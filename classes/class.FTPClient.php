<?php


class ftp_client {
	
	function __construct($ftp_host,$ftp_username,$ftp_password) {
		$this->host = $ftp_host;
		$this->error = false;
		$this->output = "";
		$this->connection_id = @ftp_connect($ftp_host);
		if (!$this->connection_id){
				$this->output.='<div class="warning">Could not connect to FTP server ['.$ftp_host.']</div>';
				$this->error = true;
				return;
			} 
		ftp_pasv($this->connection_id, true);
		if (@ftp_login($this->connection_id, $ftp_username, $ftp_password)) {
    		$this->output.= '<div class="ok">Connected to FTP server</div>';
		} else {
    		$this->output.= '<div class="warning">Could not connect as '.$ftp_username.'</div>';
			$this->error = true;
		}
	}

	function upload($filename,$remoteFileName){
		$this->error = true;
		if (file_exists($filename)){
			
			if (@ftp_put($this->connection_id, $remoteFileName, $filename, FTP_BINARY) ) {
				$this->output.= '<div class="ok">File <b>'.$remoteFileName.'</b> successfully uploaded to remote FTP server <b>'.$this->host.'</b>.</div>';
				$this->error = false;
				}else{$this->output.= '<div class="warning">Failed to upload '.$filename.' to FTP server.</div>';}
				
		}else{$this->output.= '<div class="warning">Could not find file '.$filename.'</div>';
		}
	}
	
	
	function close(){ftp_close($this->connection_id);}


}