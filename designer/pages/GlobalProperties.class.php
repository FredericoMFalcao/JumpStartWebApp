<?php
	
class GlobalProperties extends _Component {

    public $initialStatusBannerMsg = "Your web app generic global properties";
	
	const priority = -2;
	
	public $data = [];

    protected $actions = [
        "saveToFile"       => ["label" => "Save",               "style" => "primary"]

    ];


    public $fileName = ".globalProperties.json";
	
	public function __construct() {
		$this->data = [	"Title"       		=> new Text(["machineName"=> "Title","friendlyName"=>"Title","value"=>"My new website","htmlType"=>"text"]),
						"jQuery"      		=> new Checkbox(["machineName"=> "jQuery","friendlyName"=>"jQuery","value"=>"true"]),
						"bootstrapCSS"      => new Checkbox(["machineName"=> "bootstrapCSS","friendlyName"=>"Bootstrap CSS","value"=>"true"]),
					];
		$this->loadFromFile();  
	}
	
	public function _getTabFriendlyName() { return "2. Global Properties"; }
	
	/*
	*	1. ACTIONs
	*
	*/

	
	/*
	*	2. I/O (input, output)
	*
	*/
	
	

	

}