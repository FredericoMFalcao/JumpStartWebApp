<?php
	
class DatabaseConnection extends _Component {

    public $initialStatusBannerMsg = "Your MariaDB database credentials";

    public $data = [	"dbHost"      => ["type" => "Text",     "args" => ["dbHost","Host","localhost"]],
						"dbUser"      => ["type" => "Text",     "args" => ["dbUser","Username","admin"]],
						"dbPassword"  => ["type" => "Text",     "args" => ["dbPassword","Password","admin","password"]],
						"dbName"      => ["type" => "Text",     "args" => ["dbName","Db Name","Test"]]
					];
	protected $actions = [
	        "saveToFile"       => ["label" => "Save",               "style" => "primary"],
            "initializeDb"     => ["label" => "Initialize Db",      "style" => "light"],
            "testDbConnection" => ["label" => "Test Db Connection", "style" => "light"]
    ];


					
	public $fileName = ".credentials.json";
	
	public function __construct() { 
		parent::__construct();
		$this->loadFromFile();
	}
	
	public function _getTabFriendlyName() { return "1. Database Connection"; }
	
	/*
	*	1. ACTIONs
	*
	*/
	public function connectToDb() {
		global $db;
		try{
			$db = new PDO("mysql:host=".$this->data["dbHost"]->getValue(),$this->data["dbUser"]->getValue(),$this->data["dbPassword"]->getValue());
			$this->setStatusMsg("SUCCESS: connected with these credentials.","success"); return 1;
		}catch(Exception $e){
			$this->setStatusMsg("ERROR: Couldn't connected with these credentials. ({$this->data["dbUser"]->getValue()})","danger"); return 0;
		}
		
	}

	public function testDbConnection() {
	    $this->parseUserInput();
	    $this->connectToDb();
    }
	
	public function initializeDb() {
		global $db;
		if (!$this->testDbConnection()) return 0;
		try{$q = $db->prepare("DROP DATABASE IF EXISTS ".$_POST["dbName"]); $q->execute();} catch (Exception $e) {
			$this->setStatusMsg("ERROR: Couldn't drop the old database.","danger");
		}
		
		try{$q = $db->prepare("CREATE DATABASE ".$_POST["dbName"]."; USE ".$_POST["dbName"].";".file_get_contents("initDb.sql"));$q->execute();} catch (Exception $e) {
			$this->setStatusMsg("ERROR: Couldn't create the new database.","danger");
		}
		
		$this->setStatusMsg("SUCCESS: Initialized the new database.","success");
	}
	
	/*
	*	2. I/O (input, output)
	*
	*/
	
	

	
	

}