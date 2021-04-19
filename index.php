<?php
define("MYSQL_HOST", "127.0.0.1");
define("MYSQL_USERNAME", "admin");
define("MYSQL_PASSWORD", "admin");
define("MYSQL_DATABASE_NAME", "Test");
$db = 0;
function connectToDatabase() {global $db;$db = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DATABASE_NAME."", MYSQL_USERNAME, MYSQL_PASSWORD);}
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
?>
<html>
<head>
	<title>Boilerplate Code for a New Website</title>
	<script src="bootstrap.bundle.min.js"></script>
	<link href="bootstrap.min.css" rel="stylesheet">
	<script src="jquery-3.6.0.min.js"></script>
	<script><?php includeJavascriptFunctions(); ?></script>
</head>
<body>
<pre>A standard web app written purely in Javascript.</pre>





<script>main.renderAt(document.body)</script>
</body>
</html>
