<?php
	
class Users extends _Component {

    public $initialStatusBannerMsg = "Your list of users and their initial passwords";
	
	public $data = [	
						"Users[]"      	=> ["type"=> "Struct",	    "args" => [
													"User"     => ["type" => "Text", "args" => ["User","User",""]],
													"Password" => ["type" => "Text", "args" => ["Password","Password","","password"]],
											   ]],

					];
					
    protected $actions = [
//        "createUsers"       => ["label" => "Create Users",               "style" => "primary"]
          "saveToFile"       => ["label" => "Create Users",               "style" => "primary"]
    ];					
	public $fileName = ".users.json";
	
	
	
	public function __construct() {
		parent::__construct();
//		echo "<pre>"; var_dump($this->data); echo "</pre>";
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