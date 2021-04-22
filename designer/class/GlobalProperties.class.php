<?php
	
class GlobalProperties extends _Component {
	
	public $data = [	"Title"       		=> ["type"=> "text",	    "friendlyName"=> "Title",          "value" => "My new website"],
						"jQuery"      		=> ["type"=> "checkbox",	"friendlyName"=> "jQuery",         "value" => "true"],
						"bootstrapCSS"      => ["type"=> "checkbox",	"friendlyName"=> "Bootstrap CSS",  "value" => "true"],
					];
					
	private $fileName = ".globalProperties.json";
	
	public function __construct() {  $this->loadFromFile();  }
	
	public function _getTabFriendlyName() { return "2. Global Properties"; }
	
	/*
	*	1. ACTIONs
	*
	*/

	
	/*
	*	2. I/O (input, output)
	*
	*/
	
	public function saveToFile() {
		file_put_contents($this->fileName,json_encode($_POST));
		print(statusMessage(0,"SUCCESS: Global settings successfully stored.",1));
		
	}
	
	public function loadFromFile() {
		if (file_exists($this->fileName)) {
			$data = json_decode(file_get_contents($this->fileName),1);
			foreach($data as $k => $v)
				$this->data[$k]["value"] = $v;
		}
		
	}
	
	
	public function _generateHtmlForm() {
		ob_start();
?>
	<div class="mb-3 row">
		<div class="col-sm-12">
			<div class="alert alert-info" role="alert" id="GlobalPropertiesStatusMsg">Your web app generic global properties</div>
		</div>
		<?php foreach($this->data as $machineName => $attr) :?>
		<label class="col-sm-4 col-form-label" ><?=$attr["friendlyName"]?></label>
		<div class="col-sm-8"><input 
			class="form-<?=($attr["type"]=="checkbox"?"check-input":"control")?>" 
			type="<?=$attr["type"]?>" 
			name="<?=$machineName?>" 
			value="<?=($attr["type"]=="checkbox"?"true":$attr["value"])?>"
			<?=($attr["type"]=="checkbox"?($attr["value"]=="true"?"checked":""):"")?>
			></div>
		<?php endforeach; ?>

		<div class="col-sm-12">
			<button type="button" class="btn btn-primary float-end" onclick="submitData(this)" name="GlobalProperties\saveToFile">Save</button>
		</div>
	</div>



<?php
		$html = ob_get_clean();
		return $html;
	}
}