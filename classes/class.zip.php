<?php

class zip {
	
	
	function __construct() {
		$this->unzipped_size = 0;
		$this->filecount = 0;
		$this->output="";
		echo "<br/>Please wait....";
		$this->error = false;
	}
		
	function create($zip_file_name){
		global $debug;
		//@unlink ($zip_file_name);
		$this->zipfile = new ZipArchive;
		$res = $this->zipfile->open($zip_file_name,ZipArchive::CREATE);
		if ($debug){
			if ($res){
				$this->output .= '<div class="log">opening file '.$zip_file_name.'</div>';
			}
			else{
				$this->output .= '<div class="warning>error file '.$zip_file_name.'not opened</div>';
				$this->error = true;
			}
		}
	}
	
	
	function addFromString($file, $string){
		global $debug;
		if ($string != NULL){
			$this->zipfile->addFromString($file, $string);
			if ($debug){$this->output .= '<div class="log">adding file '.$file.'</div>';}
		}
	}
	
	
	/* add whole directory to zip file */
	function add_directory($dir){
		global $debug;
		if (!is_dir($dir)){
			$this->output .= '<div class="warning">Unable to open folder '.$dir.' to add to zip - skipping</div>';
			$this->error = true;
			return;
		}
		$dir_list_array = $this->get_directory_list($dir);
			foreach ($dir_list_array as $path){
				$this->add_file($path);
				/*
				$path = str_replace ('\\','/',$path);
				if (file_exists($path) && is_readable($path)){
					if (is_file($path)) {
						$this->unzipped_size = $this->unzipped_size + filesize($path);
						$res = $this->zipfile->addFile($path);
						if ($debug){
							if ($res){$this->output .= '<div class="log">adding file ['.round(filesize($path)/1000000,3).'mb] '.$path.'</div>';}
							else{$this->output .= '<div class="warning">error file '.$path.'not added</div>';$this->error = true;}
						}
					}
				}else{$this->output .= '<div class="warning">cant find file $path - skipping</div>';$this->error = true;}
				*/
			}
		} 
	
	/* add single file to zip file */
	function add_file($file){
		global $debug;
		$file = str_replace ('\\','/',$file);
		if (file_exists($file) && is_readable($file)){
			if (is_file($file)){
				$this->unzipped_size = $this->unzipped_size + filesize($file);
				$res = $this->zipfile->addFile($file);
				if ($debug){
					if ($res){$this->output .= '<div class="log">adding file '.$file.'</div>';
					$this->filecount++;
					}else{$this->output .= '<div class="warning>error file '.$file.'not added</div>';$this->error = true;}
				}
			}
		}else{$this->output .= '<div class="warning">cant find file '.$file.' - skipping</div>';$this->error = true;}
	}
		
		
	
	/*internal function to get an array of all files in a directory recursively */
	function get_directory_list($dir){
		$dir_list_array = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
		return $dir_list_array;
	}
	
	function close() {
		$filename = $this->zipfile->filename;
		$this->status['unzipped_size'] = $this->unzipped_size;
		$this->status['filecount'] = $this->filecount;//$this->zipfile->numFiles;
		$this->zipfile->close();
		@$this->status['zipped_size'] = filesize($filename);
		return $this->status;
	}
	
	
	function __destruct() {
		@$this->zipfile->close();
	}
	
	
}

?>