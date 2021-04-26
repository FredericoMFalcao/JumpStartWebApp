<?php
class Text extends _Type {
	
	public function __construct(array $data) {
		parent::__construct($data);
		$this->htmlType     = $this->htmlType??"text";
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
						->addClass("form-control")
						->setAttr("type",$this->htmlType)
						->setAttr("name",array_reduce($this->namespace,fn($c,$i)=>$i."[".$c."]",$this->machineName))
						->setAttr("value",$this->value)
					);
			
			
		return $html;
		
	}
	
}
?>