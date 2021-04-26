<?php

	
class Collections extends _Component {

    public $initialStatusBannerMsg = "Define your backend SQL tables here.";
	
	const priority =  -4;

    public $data = [];
	protected $actions = [
	        "saveToFile"       => ["label" => "Save",               "style" => "primary"]
    ];


					
	public $fileName = ".collections.json";
	
	public function __construct() { 
		$this->data = [			"name"        => new Text(["machineName"=> "name","friendlyName"=>"Name","value"=>"..."]),
						
					];
		
		$this->loadFromFile();
	}
	
	public function _getTabFriendlyName() { return "4. Collections"; }
	
	/*
	*	1. ACTIONs
	*
	*/

	
	/*
	*	2. I/O (input, output)
	*
	*/
	
	

	
	

}