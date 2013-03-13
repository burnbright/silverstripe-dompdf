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
		$this->dompdf->set_host(Director::absoluteBaseURL());
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
		return $this->dompdf->stream($this->addFileExt($outfile), $options);
	}
	
	public function toFile($filename = "file",$folder = "PDF"){
		$filename = $this->addFileExt($filename);
		$filedir = ASSETS_DIR."/$folder/$filename";
		$filepath = ASSETS_PATH.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$filename;
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
	
	function addFileExt($filename, $new_extension = 'pdf') {
		if(strpos($filename, ".".$new_extension)){
			return $filename;
		}
	    $info = pathinfo($filename);
	    return $info['filename'] . '.' . $new_extension;
	}
	
	/**
	 * uesful function that streams the pdf to the browser,
	 * with correct headers, and ends php execution.
	 */
	public function streamdebug(){
		header('Content-type: application/pdf');
		$this->stream('debug',array('Attachment' => 0));
		die();
	}
	
}