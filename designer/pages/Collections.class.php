<?php

	
class Collections extends _Component {

    public $initialStatusBannerMsg = "Define your backend SQL tables here.";
	
	const priority =  -4;

    public $data = [];
	protected $actions = [
	        "createCollections"    => ["label" => "Create",              "style" => "primary"]
    ];


					
	public $fileName = ".collections.json";
	
	public function __construct() { 
		$this->data = [			"Collection"        => [
										"Name" => new Text(["machineName"=> "name","friendlyName"=>"Name","value"=>"..."]),
										"Col1Name" => new Text(["machineName"=> "Col1Name","friendlyName"=>"Col1Name","value"=>""]),
										"Col1Type" => new Dropdown(["machineName"=> "Col1Type","friendlyName"=>"Type","value"=>"",
											"values"=>["INT","TEXT","BOOL","FILE"]
												])
								]
							
					];
		
		$this->loadFromFile();
	}
	
	public function _getTabFriendlyName() { return "4. Collections"; }
	
	/*
	*	1. ACTIONs
	*
	*/
	public function createCollections() {
		/* 1. Connect to DB */
		global $db; 
		$dbObj = new DatabaseConnection();
		if (!($dbObj->connectToDb())) {
			$this->setStatusMsg("ERROR: Could not connect to database.","danger"); return 0;
		}
		$dbName = $dbObj->data["dbName"]->getValue();	
		/* 2. Delete old users from sql-database */	
		try{$q = $db->prepare("DROP USER IF EXISTS ".implode(",",array_keys($users))); $q->execute();} catch (Exception $e) {
					$this->setStatusMsg("ERROR: Could delete old users.","danger"); return 0;
		}
	}

	
	/*
	*	2. I/O (input, output)
	*
	*/
	
	

	
	

}