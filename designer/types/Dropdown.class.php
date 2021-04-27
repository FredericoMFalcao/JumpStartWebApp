<?php
class Dropdown extends _Type {
	
	private $values = [];
	
	public function __construct(array $data) {
		parent::__construct($data);

		if (isset($data["values"])) $this->values = $data["values"];

		$this->htmlType     = "select";
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
					(new _DomEl("select"))
					->addClass("form-select")
					->addChildren(
						array_map(
							fn($o)=>(new _DomEl("option"))->text($o),
							$this->values
						)
				)
				);


	    return $html;
	}
	
}
