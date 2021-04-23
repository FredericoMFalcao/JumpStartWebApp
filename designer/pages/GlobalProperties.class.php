<?php
	
class GlobalProperties extends _Component {

    public $initialStatusBannerMsg = "Your web app generic global properties";
	
	public $data = [	"Title"       		=> ["type"=> "Text",	    "args"=> ["Title","Title","My new website"]],
						"jQuery"      		=> ["type"=> "Checkbox",	"args"=> ["jQuery","jQuery","true"]],
						"bootstrapCSS"      => ["type"=> "Checkbox",	"args"=> ["bootstrapCSS","Bootstrap CSS","true"]]
					];

    protected $actions = [
        "saveToFile"       => ["label" => "Save",               "style" => "primary"]

    ];


    public $fileName = ".globalProperties.json";
	
	public function __construct() {
		parent::__construct();
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