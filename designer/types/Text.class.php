<?php
class Text extends _Type {
	
	public function __construct(array $data) {
		parent::__construct($data);
		$this->htmlType     = $this->htmlType??"text";
	}
	
	public function renderHtmlInputField() {

		$html = "";

            $html .= '<label class="col-sm-2 col-form-label" >'.$this->friendlyName.'</label>';
            $html .= '<div class="col-sm-10">';
            $html .= '<input class="form-control" ';
            $html .= 'type="'.$this->htmlType.'" ';
			$html .= 'name="'.array_reduce($this->namespace,fn($c,$i)=>$i."[".$c."]",$this->machineName).'" ';
            $html .= 'value="'.$this->value.'" ';
            $html .= ' ></div>';

			
		return $html;
		
	}
	
}
?>