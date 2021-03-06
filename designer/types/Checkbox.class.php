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
				->text($this->friendlyName);
		$html .= (new _DomEl("div"))
				->addClass("col-sm-10")
				->addChild(
					(new _DomEl("input"))
					->addClass("form-check-input")
					->attr("type",$this->htmlType)
					->attr("name",array_reduce($this->namespace,fn($c,$i)=>$i."[".$c."]",$this->machineName))
					->attr("value","true")
					->attr(($this->value==true?"checked":""),"checked")
				);


	    return $html;
	}
	
}
?>