<?php
class Checkbox extends _Type {
	
	public function __construct(array $data) {
		parent::__construct($data);
		$this->htmlType     = "checkbox";
	}
	
	public function renderHtmlInputField() {

		$html = "";

            $html .= '<label class="col-sm-2 col-form-label" >'.$this->friendlyName.'</label>';
            $html .= '<div class="col-sm-10">';
            $html .= '<input class="form-check-input" ';
            $html .= 'type="'.$this->htmlType.'" name="'.$this->machineName.'" ';
            $html .= 'value="true" ';
            $html .= ($this->value=="true"?"checked":"");
            $html .= ' ></div>';

			
		return $html;
		
	}
	
}
?>