<?php

function expandArrays(&$data) {
	foreach($data as $k => $v)
		if (preg_match(";([a-zA-Z_]+)\[([0-9]+)\];",$k,$matches)) {
			unset($data[$k]);
			$data[$matches[1][0]."[]"] = array_fill(0,$matches[2][0],$v);
		}
}
	
class Users extends _Component {

    public $initialStatusBannerMsg = "Your list of users and their initial passwords";
	
	public $data = [];
	
    const priority = -3;
					
    protected $actions = [
          "saveToFile"       => ["label" => "Create Users",               "style" => "primary"],
          "loadOneMore"      => ["label" => "Load One More",               "style" => "light"]

    ];					
	public $fileName = ".users.json";
	
	
	
	public function __construct() {
		$this->data = [	"Users[1]"      	=> [
											 "User"     => new Text(["machineName"=> "User","friendlyName"=>"User","value"=>""]),
										     "Password" => new Text(["machineName"=> "User","friendlyName"=>"Password","value"=>"","htmlType"=>"password"]),
										     "isAdmin"  => new Checkbox(["machineName"=> "isAdmin","friendlyName"=>"Admin"])
										    ]
					  ];
		expandArrays($this->data);
	}
	

	
	public function _getTabFriendlyName() { return "3. Users"; }
		
	/*
	*	1. ACTIONs
	*
	*/
	public function parseUserInput(&$receivedData = null, &$localData = null) { return $this; }
	public function loadOneMore() {
		echo (new _jQuery("<div/>"))
			->html(recursiveRenderInputField($this->data[array_keys($this->data)[0]]))
			->insertBefore((new _jQuery("#".$this->getDomId()))->find("div.buttons-row"))
		;

	}
	public function createUsers() {
		$users = [];
	
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
		/* 3. Create new users in sql-database */
		try{
			foreach($users as $username => $attributes) {
				$query = "DROP USER IF EXISTS $username@localhost; CREATE USER $username@localhost IDENTIFIED BY '{$attributes["password"]}'; GRANT SELECT, UPDATE, INSERT, DELETE ON {$dbName}.* TO $username@localhost;";
				error_log($query);
				$q = $db->prepare($query); $q->execute();		
			}
		} catch (Exception $e) {
					$this->setStatusMsg("ERROR: Could not create new users in sql database.","danger");
					error_log($query); 
					return 0;
		}
	
		/* 3. Write the new users / password into a file */
		try {$this->saveToFile();} catch (Exception $e) {
				$this->setStatusMsg("ERROR: Could not write the list of users.","danger"); return 0;
		}
		$this->setStatusMsg("SUCCESS: submitted list to SQL Db and wrote it to disk.","success");
	}
	
	/*
	*	2. I/O (input, output)
	*
	*/	

	

	

}