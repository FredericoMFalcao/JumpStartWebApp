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
					
    protected $actions = [
//        "createUsers"       => ["label" => "Create Users",               "style" => "primary"]
          "saveToFile"       => ["label" => "Create Users",               "style" => "primary"]
    ];					
	public $fileName = ".users.json";
	
	
	
	public function __construct() {
		$this->data = [	"Users[5]"      	=> [
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
	public function createUsers() {
		$users = [];
	
		// Restructure array
		//foreach($_POST["User"] as $no => $u) if (!empty($u)) $users[$u] = ["password"=>$_POST["Password"][$no]];

	
		/* 1. Delete old users from sql-database */
		global $db; 
		$dbObj = new DatabaseConnection();
		if (!($dbObj->connectToDb())) {
			$this->setStatusMsg("ERROR: Could not connect to database.","danger"); return 0;
		}
		$dbName = $dbObj->data["dbName"]->getValue();
		
		
		try{$q = $db->prepare("DROP USER IF EXISTS ".implode(",",array_keys($users))); $q->execute();} catch (Exception $e) {
					$this->setStatusMsg("ERROR: Could delete old users.","danger"); return 0;
		}
		/* 2. Create new users in sql-database */
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