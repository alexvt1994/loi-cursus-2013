<?php
/**
 * @author     Alex van Turenhout <info@lexoft.nl>
 */
class TemplateParser {
	private $file = 'start.tpl'; //Het standaard bestand, deze gebruikt hij als er geen bestand wordt opgegeven
	private $errors = ''; //Hier komen de errors in
	private $lang = '';

	public function __construct($file = false) {
		if($file != "" && $file != false) { //Kijken of $file niet leeg is.
			/*if(!preg_match("#(.+?).tpl#si", $file)) { //Kijken of het bestand de exentie .tpl heeft
				$this->errors .= "<b>TemplateParser Error:</b> Het bestand moet de exentie .tpl hebben!<br />";
			}else*/if(!file_exists($file)){ //Kijken of het bestand bestaat
				$this->errors .= "<b>TemplateParser Error:</b> het bestand ".$file." bestaat niet!<br />";
			}else{
				$this->output = file_get_contents($file);
			}
		}
	}
	public function set($pattern, $replacement) {
		$this->output = preg_replace("#\{".$pattern."\}#si", $replacement, $this->output); //{iets} wordt veranderd in iets.
	}
	public function parseBlocks(Array $tags=array()){
		if(count($tags)>0){
			foreach($tags as $tag=>$data){
				$data=(file_exists($data))?$this->parseFile($data):$data;
				$this->output=str_replace('{'.$tag.'}',$data,$this->output);
			}
		} else {
			die('Error: No tags were provided for replacement');
		}
	}
	public function parseFile($file){
		ob_start();
		include($file);
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	} 
	public function parse(){
		if($this->errors == ''){ //Kijken of de errors leeg zijn
			return $this->output; //De inhoud returnen
		}else{
			return $this->errors; //Als er errors zijn, deze returnen.
		}
	}
}
?>