<?php
class Checkbox extends _Type {
	
	public function __construct(array $data) {
		parent::__construct($data);
		$this->htmlType     = "checkbox";
	}
	
	public function renderHtmlInputField() {

		$html = "";
	
		$html .= (new _DomEl("label"))
				->addClass("col-sm-2")
				->addClass("col-form-label")
				->setText($this->friendlyName);
		$html .= (new _DomEl("div"))
				->addClass("col-sm-10")
				->addChild(
					(new _DomEl("input"))
					->addClass("form-check-input")
					->setAttr("type",$this->htmlType)
					->setAttr("name",array_reduce($this->namespace,fn($c,$i)=>$i."[".$c."]",$this->machineName))
					->setAttr("value","true")
					->setAttr(($this->value==true?"checked":""),"checked")
				);


	    return $html;
	}
	
}
?>