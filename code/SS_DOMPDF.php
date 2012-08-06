<?php
/**
 * SilverStripe wrapper for DOMPDF
 */
class SS_DOMPDF{
	
	protected $dompdf;
	
	function __construct(){
		//set configuration
		require_once str_replace(DIRECTORY_SEPARATOR, '/', BASE_PATH."/dompdf/dompdf_config.inc.php");
		//require_once str_replace(DIRECTORY_SEPARATOR, '/', DOMPDF_DIR."/include/functions.inc.php");
		require_once(DOMPDF_INC_DIR . "/autoload.inc.php");
		$this->dompdf = new DOMPDF();
		$this->dompdf->set_base_path(BASE_PATH);
	}
	
	public function set_paper($size, $orientation){
		$this->dompdf->set_paper($size, $orientation);
	}
	
	public function setHTML($html){
		$this->dompdf->load_html($html);
	}
	
	public function setHTMLFromFile($filename){
		$this->dompdf->load_html_file($filename);
	}
	  
	public function render(){
		$this->dompdf->render();
	}
	
	public function output($options=null){
		return $this->dompdf->output($options);
	}
	
	public function stream($outfile, $options = ''){
		return $this->dompdf->stream($outfile, $options);
	}
	
	public function toFile($filename = "file",$folder = "PDF"){
		$filedir = ASSETS_DIR."/$folder/$filename.pdf";
		$filepath = ASSETS_PATH.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$filename.".pdf";
		$folder = Folder::find_or_make($folder);
		$output = $this->output();
		if($fh = fopen($filepath, 'w')) {
			fwrite($fh, $output);
			fclose($fh);
		}
		$file = new File();
		$file->setName($filename);
		$file->Filename = $filedir;
		$file->ParentID = $folder->ID;
		$file->write();
		return $file;
	}
	
}