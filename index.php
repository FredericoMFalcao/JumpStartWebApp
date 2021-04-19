<?php
define("MYSQL_HOST", "127.0.0.1");
define("MYSQL_USERNAME", "admin");
define("MYSQL_PASSWORD", "admin");
define("MYSQL_DATABASE_NAME", "Test");
$db = 0;
function connectToDatabase() {global $db;
if(file_exists(".credentials.json")) extract(json_decode(file_get_contents(".credentials.json"),1));
$db = new PDO("mysql:host=".($dbHost??MYSQL_HOST).";dbname=".($dbName??MYSQL_DATABASE_NAME), $dbUser??MYSQL_USERNAME, $dbPassword??MYSQL_PASSWORD);
}
connectToDatabase();
/*
* DB FUNCTIONS 
*
*/
function fetchAll($q) {global $db; $sq=$db->prepare($q); $sq->execute(); return $sq->fetchAll(PDO::FETCH_ASSOC); }
function extractFirstCol($array) { $output = []; foreach($array as $rowNo => $row) $output[] = $row[array_keys($row)[0]]; return $output;}
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
	<title>Seedcode for WebApp Written in Javascript</title>
	<script src="bootstrap.bundle.min.js"></script>
	<link href="bootstrap.min.css" rel="stylesheet">
	<script src="jquery-3.6.0.min.js"></script>
	<script><?php includeJavascriptFunctions(); ?></script>
</head>
<body>




<script>m = main(); m.renderAt(document.body)</script>
</body>
</html>
