<?php
/*
* 0. Server LOCAL STATIC FILES
*
*/
$serverFiles = ["bootstrap.min.css", "bootstrap.bundle.min.js","jquery-3.6.0.min.js"];
foreach($serverFiles as $file)
	if ($_SERVER["REQUEST_URI"] == "/$file") 
		die(file_get_contents($file));

/*
* DB FUNCTIONS 
*
*/
$db = 0;
function connectToDatabase() {
	global $db, $dbName; 
/*	if(file_exists(".credentials.json")) 
		extract(json_decode(file_get_contents(".credentials.json"),1));
	else
*/
	if (!isset($_REQUEST["dbUser"]) || !isset($_REQUEST["dbPassword"]) || !isset($_REQUEST["dbName"]))	
		die("No database connection credentials provided.");
	else
	{	$dbUser = $_REQUEST["dbUser"]; $dbPassword = $_REQUEST["dbPassword"]; $dbName = $_REQUEST["dbName"];}

	$db = new PDO("mysql:host=".($dbHost??"localhost").";dbname=".($dbName), $dbUser, $dbPassword);
}
function fetchAll($q) {global $db; $sq=$db->prepare($q); $sq->execute(); return $sq->fetchAll(PDO::FETCH_ASSOC); }
function extractFirstCol($array) { $output = []; foreach($array as $rowNo => $row) $output[] = $row[array_keys($row)[0]]; return $output;}
connectToDatabase();

/*
* Global Properties
*
*/
$globalProperties = [];
function fetchGlobalProperties() {
	global $globalProperties;
	$file = ".globalProperties.json"; if (file_exists($file)) $globalProperties = json_decode(file_get_contents($file),1);
}
fetchGlobalProperties();

/*
* MODE 1: OUTPUT SEED HTML with JS FUNCTIONS
*
*/
function includeJavascriptFunctions() {
	global $db;
	$classes = extractFirstCol(fetchAll("SELECT DISTINCT ClassName FROM JavascriptFuncs"));
	foreach($classes as $class) {
		if (!empty($class)) echo "function $class() {\nvar output = {};\n";
		/*
		* 2.1 Write the constructor
		*
		*/
		$constructor = fetchAll("SELECT Value FROM JavascriptFuncs WHERE Type = 'function' AND ClassName = '$class' AND Name = '__construct'");
		if (!empty($constructor)) echo "\n".$constructor[0]['Value']."\n";


		/*
		* 2.2 Write the variables
		*
		*/
		foreach(fetchAll("SELECT Name, Value FROM JavascriptFuncs WHERE Type = 'variable' AND ClassName = '$class'") as $row) {
			extract($row);
			if (!empty($class)) echo "\noutput.";
			echo "$Name = $Value\n";
		}

		/*
		* 2.3 Write the functions
		*
		*/
		foreach(fetchAll("SELECT Name,Arguments,Value as Code FROM JavascriptFuncs WHERE Type = 'function' AND ClassName = '$class'") as $row) {
			extract($row);
			if ($Name == "__construct") continue;
			if (!empty($class)) echo "output.";
			echo "$Name = function (".implode(",",array_keys(json_decode($Arguments,1))).") {\n$Code\n}\n";

		}
		if (!empty($class)) echo "\nreturn output;\n}\n";
		
		
	}
}
function includeGraphicalComponents() {
	global $db;
	foreach(fetchAll("SELECT Name, ViewCode, ControllerCode, ModelCode FROM Components") as $Component) {
		extract($Component);

		echo "$Name = function () {\nvar output = {};";


		/*
		* 2.1 Write the Model Code
		*
		*/
		$ModelCode = str_replace(["\n","\t","\r"],"",$ModelCode);
		$ModelCode = str_replace('"','\\"',$ModelCode);
?>output.updateModel = function () {
	var controller = this
	$.ajax({url:"",data: {"sqlCmd":"<?=$ModelCode?>"}, success: function (data) {
		// Initialize object's variable with data
		controller.data = data
		// Force a graphical re-render
		controller.updateView();
	 }});
};
<?php

		/*
		* 2.2 Write the Controller Code
		*
		*/
		echo 'output.renderAt = function (domEl) { this.viewEl = domEl; this.updateModel();};';



		/*
		* 2.3 Write the View Code
		*
		*/
		echo "output.updateView = function(){ \n".$ViewCode."\n};\n";
		
		/*
		* 2.4 Write the Extension Variables
		*
		*/
		$ComponentName = $Name;
		foreach(fetchAll("SELECT Name, Value FROM ComponentExtensions WHERE Type = 'variable' AND ClassName = '$ComponentName'") as $row) {
			extract($row);
			echo "\noutput.$Name = $Value\n";
		}

		/*
		* 2.5 Write the Extension Functions
		*
		*/
		foreach(fetchAll("SELECT Name,Arguments,Value as Code FROM ComponentExtensions WHERE Type = 'function' AND ClassName = '$ComponentName'") as $row) {
			extract($row);
			if ($Name == "__construct") continue;
			echo "output.$Name = function (".implode(",",array_keys(json_decode($Arguments,1))).") {\n$Code\n}\n";

		}
	
	
		echo "\nreturn output;\n};\n";	
		
	}
}
/*
* MODE 2: OUTPUT JSON DATA (parse SQL queries)
*
*/
if (isset($_REQUEST["sqlCmd"])) { 
	$q=$db->prepare($_REQUEST["sqlCmd"]); 
	$q->execute(); 
	header("Content-type: application/json");
	echo json_encode($q->fetchAll(PDO::FETCH_ASSOC)); 
	die(); 
}
?>
<html>
<head>
	<title><?=$globalProperties["Title"]??"Seedcode for WebApp Written in Javascript"?></title>
<?php if (($globalProperties["bootstrapCSS"]??false)) : ?>
	<script src="bootstrap.bundle.min.js"></script>
	<link href="bootstrap.min.css" rel="stylesheet">
<?php endif; ?>
<?php if (($globalProperties["jQuery"]??false)) : ?>
	<script src="jquery-3.6.0.min.js"></script>
<?php endif; ?>
	<script><?php includeJavascriptFunctions(); includeGraphicalComponents(); ?></script>
</head>
<body>




<script>m = main(); m.renderAt(document.body)</script>
</body>
</html>
