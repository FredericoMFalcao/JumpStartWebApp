<?php
	
class DatabaseConnection {
	
	public $data = [	"dbHost"      => ["type"=> "text",      "friendlyName"=> "Host",      "value" => "localhost"],
						"dbUser"      => ["type"=> "text",     	"friendlyName"=> "Username",  "value" => "admin"],
						"dbPassword"  => ["type"=> "password",  "friendlyName"=> "Password",  "value" => "admin"],
						"dbName"      => ["type"=> "text",      "friendlyName"=> "Db Name",   "value" => "Test"]
					];
					
	private $fileName = ".credentials.json";
	
	public function __construct() { $this->loadFromFile(); }
	
	public function _getTabFriendlyName() { return "1. Database Connection"; }
	
	/*
	*	1. ACTIONs
	*
	*/
	public function testDbConnection() {
		global $db;
		try{
			$db = new PDO("mysql:host=".$this->data["dbHost"]["value"],$this->data["dbUser"]["value"],$this->data["dbPassword"]["value"]);
			print(statusMessage(0,"SUCCESS: connected with these credentials.",1)); return 1;
		}catch(Exception $e){
			print(statusMessage(0,"ERROR: Couldn't connected with these credentials.",0)); return 0;
		}
		
	}
	
	public function initializeDb() {
		global $db;
		if (!testDbConnection()) return 0;
		try{$q = $db->prepare("DROP DATABASE IF EXISTS ".$_POST["dbName"]); $q->execute();} catch (Exception $e) {
			print(statusMessage(0,"ERROR: Couldn't drop the old database.",0));
		}
		
		try{$q = $db->prepare("CREATE DATABASE ".$_POST["dbName"]."; USE ".$_POST["dbName"].";".file_get_contents("initDb.sql"));$q->execute();} catch (Exception $e) {
			print(statusMessage(0,"ERROR: Couldn't create the new database.",0));
		}
		
		print(statusMessage(0,"SUCCESS: Initialized the new database.",1));
	}
	
	/*
	*	2. I/O (input, output)
	*
	*/
	
	public function parseUserInput() {
		foreach($_POST as $k => $v ) $data[$k]["value"] = $v;
	}	

	public function saveToFile() {
		file_put_contents($this->fileName,json_encode($_POST));
		print(statusMessage(0,"SUCCESS: Credentials successfully stored.",1));
		
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
				<div class="alert alert-info" role="alert" id="DatabaseConnectionStatusMsg">Your MariaDB database credentials</div>
			</div>
			<?php foreach($this->data as $machineName => $attr) :?>
			<label class="col-sm-2 col-form-label" ><?=$attr["friendlyName"]?></label><div class="col-sm-10"><input class="form-control" type="<?=$attr["type"]?>" name="<?=$machineName?>" value="<?=$attr["value"]?>"></div>
			<?php endforeach; ?>
			<div class="col-sm-12">
				<button type="button" class="btn btn-primary float-end" onclick="submitData(this)" name="DatabaseConnection\saveToFile" >Save</button>
				<button type="button" class="btn btn-light float-end"   onclick="submitData(this)" name="DatabaseConnection\initializeDb">Initialize Db</button>
				<button type="button" class="btn btn-light float-end"   onclick="submitData(this)" name="DatabaseConnection\testDbConnection" >Test Connection</button>
			</div>
		</div>
<?php
		$html = ob_get_clean();
		return $html;
	}
}