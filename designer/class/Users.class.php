<?php
	
class Users {
	
	public $data = [	"User[]"       		=> ["type"=> "text",	    "friendlyName"=> "User",           "value" => ""],
						"Password[]"      	=> ["type"=> "password",	"friendlyName"=> "Password",        "value" => ""]
					];
					
	private $fileName = ".users.json";
	
	public function __construct() {  /* $this->load(); */ }
	
	public function _getTabFriendlyName() { return "3. Users"; }
	
	/*
	*	1. ACTIONs
	*
	*/
	public function createUsers() {
		$users = [];
	
		// Restructure array
		foreach($_POST["User"] as $no => $u) if (!empty($u)) $users[$u] = ["password"=>$_POST["Password"][$no]];
	
		/* 1. Delete old users from sql-database */
		global $db; 
		$dbObj = new DatabaseConnection();
		if (!($dbObj->testDbConnection())) {
			print(statusMessage(2,"ERROR: Could not connect to database.",0)); return 0;
		}
		$dbName = $dbObj->data["dbName"]["value"];
		
		
		try{$q = $db->prepare("DROP USER IF EXISTS ".implode(",",array_keys($users))); $q->execute();} catch (Exception $e) {
					print(statusMessage(2,"ERROR: Could delete old users.",0)); return 0;
		}
		/* 2. Create new users in sql-database */
		try{
			foreach($users as $username => $attributes) {
				$query = "DROP USER IF EXISTS $username@localhost; CREATE USER $username@localhost IDENTIFIED BY '{$attributes["password"]}'; GRANT USAGE ON {$dbName}.* TO $username@localhost;";
				$q = $db->prepare($query); $q->execute();		
			}
		} catch (Exception $e) {
					print(statusMessage(2,"ERROR: Could not create new users in sql database.",0));
					error_log($query); 
					return 0;
		}
	
		/* 3. Write the new users / password into a file */
		try {file_put_contents(".users.json",json_encode($users)); } catch (Exception $e) {
				print(statusMessage(2,"ERROR: Could not write the list of users.",0)); return 0;
		}
		print(statusMessage(2,"SUCCESS: wrote new list of users.",1));
	}
	
	/*
	*	2. I/O (input, output)
	*
	*/	

	public function save() { /* Not used */ }
	
	public function load() {
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
			<div class="alert alert-info" role="alert" id="UsersStatusMsg">Your list of users and their initial passwords</div>
		</div>			
		<?php foreach(range(1,3) as $no) : ?>
			<?php foreach($this->data as $machineName => $attr) :?>
			<label class="col-sm-2 col-form-label" ><?=$attr["friendlyName"]?></label>
			<div class="col-sm-4">
				<input 
					class="form-<?=($attr["type"]=="checkbox"?"check-input":"control")?>" 
					type="<?=$attr["type"]?>" 
					name="<?=$machineName?>" 
					value="<?=($attr["type"]=="checkbox"?"true":$attr["value"])?>"
					<?=($attr["type"]=="checkbox"?($attr["value"]=="true"?"checked":""):"")?>
				/>
			</div>
			<?php endforeach; ?>
		<?php endforeach; ?>

		<div class="col-sm-12">
			<button type="button" class="btn btn-primary float-end" onclick="submitData(this)" name="Users\createUsers">Create users</button>
			<button type="button" class="btn btn-light float-end"   onclick="cloneUserPass(this);" >More Users</button>
		</div>

	</div>


<?php
		$html = ob_get_clean();
		return $html;
	}
}