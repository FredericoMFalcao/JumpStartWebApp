<?php
class Text extends _Type {
	
	public function __construct(array $data) {
		parent::__construct($data);
		$this->htmlType     = $this->htmlType??"text";
	}
	
	public function asDomEl() : _DomEl {

			return (new _DomEl("div"))
				->addChild((new _DomEl("label"))
					->addClass("col-sm-2")
					->addClass("col-form-label")
					->text($this->friendlyName)
				)->brwaddChild(
					(new _DomEl("div"))
					->addClass("col-sm-10")
					->addChild(
						(new _DomEl("input"))
						->addClass("form-control")
						->attr("type",$this->htmlType)
						->attr("name",array_reduce($this->namespace,fn($c,$i)=>$i."[".$c."]",$this->machineName))
						->attr("value",$this->value)
					)
				);
		
	}
	
}
?>