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
* 1. Autoload CLASSES
*
*/
spl_autoload_register(function ($class_name) {$file = __DIR__."/designer/types/$class_name.class.php"; if (file_exists($file)) require_once $file;});
spl_autoload_register(function ($class_name) {$file = __DIR__."/designer/pages/$class_name.class.php"; if (file_exists($file)) require_once $file;});
$classes = [];
foreach(scandir(__DIR__."/designer/pages/") as $file)
	if (substr($file,-10) == ".class.php" && substr($file,0,1) != "_")
		$classes[] =  str_replace(".class.php","",$file);

/*
* 2. Parse COMMANDS
*
*/
if (isset($_GET["_cmd"])) {
	header("Content-type: application/javascript"); 
	$className = explode("\\", $_GET["_cmd"])[0];
	$cmd       = explode("\\", $_GET["_cmd"])[1];
	$component = (new $className())->parseUserInput();	
	call_user_func([$component, $cmd]);
	die();
}
function statusMessage($id,$message,$success) {
	return "$('#".$id."').attr('class','alert alert-".($success?"success":"danger")."').text('".str_replace("'","\\'",$message)."');";
}


?>
<html>
<head>
	<title>Configure your webapp</title>
	<script src="bootstrap.bundle.min.js"></script>
	<link href="bootstrap.min.css" rel="stylesheet">
	<script src="jquery-3.6.0.min.js"></script>
	
</head>
<body class="container">
<form action="?_cmd=StoreDatabaseConnection" method="POST">	
	
<?php if (isset($statusMessage)) :?>
<div class="alert-dismissible fade show alert alert-<?=$statusMessage[0];?>" role="alert"><?=$statusMessage[1];?>
<button type="button" class="btn-close" data-bs-dismiss="alert" ></button>
</div>
<?php endif; ?>

<!-- TOP BAR -->
<div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="#" class="navbar-brand d-flex align-items-center">
		 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 512 512"><g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#FFFFFF" stroke="none">		  <path d="M4420 4961 c-84 -27 -164 -71 -284 -156 -219 -156 -413 -330 -648		  -582 l-169 -183 -1660 0 -1659 0 0 -1950 0 -1950 1965 0 1965 0 0 1140 0 1141		  355 369 c195 203 355 373 355 378 0 5 -102 107 -227 227 l-228 218 -127 -134		  -128 -133 0 275 0 275 71 69 c165 162 377 416 495 591 93 139 133 230 134 302		  0 66 -12 90 -55 108 -45 18 -87 17 -155 -5z m-1556 -1426 l-156 -176 38 -55		  c64 -92 265 -274 304 -274 6 0 132 120 280 267 l270 266 0 -280 0 -281 -606		  -632 -606 -633 33 -32 c127 -125 425 -405 430 -405 5 0 327 333 672 695 l76		  80 1 -802 0 -803 -1635 0 -1635 0 0 1620 0 1620 1345 0 1346 0 -157 -175z"></path>		  <path d="M2568 3188 c-179 -216 -350 -441 -457 -600 -49 -74 -54 -78 -89 -78		  -51 0 -206 -34 -272 -59 -139 -53 -279 -157 -346 -258 -100 -150 -173 -456		  -174 -721 l0 -104 46 56 c98 121 239 210 423 266 131 40 211 78 284 135 119		  94 197 244 237 456 10 53 14 58 78 104 176 129 688 563 700 594 1 4 -17 21		  -40 36 -73 48 -158 127 -220 205 -34 41 -64 76 -68 78 -5 2 -50 -48 -102 -110z"></path>		  <path d="M2150 1343 c-286 -578 -275 -553 -258 -570 14 -13 60 8 434 202 231		  120 423 221 428 226 8 7 -90 105 -380 382 l-72 68 -152 -308z"></path>		  <path d="M4663 4094 c-17 -9 -114 -101 -214 -206 l-183 -190 189 -184 c105		  -101 210 -201 233 -221 l44 -37 171 178 c95 98 182 195 194 215 15 23 23 52		  23 81 0 45 -2 47 -112 156 -216 211 -232 224 -275 224 -21 0 -52 -7 -70 -16z"></path>		  </g>		  </svg>
        <strong>Designer</strong>
      </a>
    </div>
</div>
<!-- /TOP BAR -->



<!-- HERO -->
<section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Configure your new web app here!</h1>
        <p class="lead text-muted">This program will write new files to disk to reflect your choices for you new web app.</p>
      </div>
    </div>
</section>
<!-- /HERO -->



<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
	  <?php foreach($classes as $no => $class) : ?>
	  <button class="nav-link <?=($no==0?"active":"")?>" data-bs-toggle="tab" data-bs-target="#tab<?=$no?>" type="button" role="tab" >
		  <?=(new $class())->_getTabFriendlyName(); ?>
	  </button>
	  <?php endforeach; ?>	
	  
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <?php foreach($classes as $no => $class) : ?>
  <div class="tab-pane fade show <?=($no==0?"active":"")?>" id="tab<?=$no?>" role="tabpanel" >
	  <?=(new $class())->generateHtmlForm(); ?>
  </div>
  <?php endforeach; ?>	
</div>



</form>

<script>
function submitData(domEl) {$.ajax({url:"?_cmd="+$(domEl).attr("name"),method:"POST",data:$(domEl).closest(".row").find("input").serialize(),success:function(js){eval(js);}});}
function cloneUserPass(domEl) {}
</script>
</body>
</html>
