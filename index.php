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
function includeJavascriptFunctions() {
	global $db;
	$q = $db->prepare("SELECT * FROM JavascriptFuncs ORDER BY Namespace");
	$q->execute();
	$lastNamespace = "";
	foreach($q->fetchAll(PDO::FETCH_ASSOC) as $row) {
		extract($row);
		if ($Namespace != $lastNamespace) { echo "\n$Namespace = {}\n";} $lastNamespace = $Namespace;
		echo ($Namespace==""?"window":$Namespace)."[\"$Name\"] = function (".implode(",",array_keys(json_decode($Arguments,1))).") {\n$Code\n}\n";

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
