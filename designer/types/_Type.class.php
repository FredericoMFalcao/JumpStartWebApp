<?php
class _Type {

	public $friendlyName;
	public $value;
	public $htmlType;
	public $machineName;
	public $namespace = [];
	
	public function __construct(array $data) {
		$this->machineName  = $data[0];
		$this->friendlyName = $data[1];
		$this->value        = $data[2];
		$this->htmlType     = $data[3]??"text";
	}
	


	public function setValue($v) {$this->value = $v; return $this; }	
	public function getValue()   {return $this->value; }
	
	public function setFriendlyName($v) {$this->friendlyName = $v; return $this; }	
	public function getFriendlyName() {return $this->friendlyName; }	
	
	public function setHtmlType($v)     {$this->htmlType = $v; return $this;}
	public function getHtmlType()       {return $this->htmlType;}
	
	public function addNamespace($n)    {$this->namespace[] = $n; return $this;}
	
	public function renderHtmlInputField() { return "NOT DEFINED!"; }
}
?>