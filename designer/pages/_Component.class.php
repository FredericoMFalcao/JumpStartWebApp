<?php
function recursivelyGetValue($o) {if (is_array($o)) return array_map(fn($p)=>recursivelyGetValue($p),$o); else return $o->getValue();}	
function recursiveRenderHtmlInputField(array|_Type $o,$cssNo = 0): string {if (is_array($o)) return "<div class='c$cssNo'>".implode("</div><div class='c$cssNo'>",array_map(fn($p)=>recursiveRenderHtmlInputField($p,++$cssNo),$o))."</div>"; else return $o->renderHtmlInputField();}

		
class _Component {
	
	public function _getTabFriendlyName() { return "Title not defined."; }

	public function __construct() {}

    /*
    *	2. I/O (input, output)
    *
    */

    public function saveToFile() {
		file_put_contents($this->fileName,json_encode(array_map(fn($o) => recursivelyGetValue($o),$this->data)));
		$this->setStatusMsg("SUCCESS: ".get_class($this)." successfully stored.","success");
		
	}

    public function loadFromFile() {
        if (file_exists($this->fileName)) {
            $data = json_decode(file_get_contents($this->fileName),1);
            foreach($data as $k => $v)
                $this->data[$k]->setValue($v);
        }

    }
	
	public function parseUserInput(&$receivedData = null, &$localData = null) {
		if ($receivedData == null) $receivedData = $_POST;
		if ($localData == null) $localData = $this->data;
		
		error_log(print_r([$receivedData, $localData],1));
		
		foreach($receivedData as $k => $v )
			if (is_array($v))
				$this->parseUserInput($v, $localData[$k]);
			else
				$localData[$k]->setValue($v);
				
		return $this;
	}
	


    /*********************************************
    *	3. GRAPHICS
    *
    *********************************************/

    public function setStatusMsg($msg, $status) {
        print("$('#".get_class($this)."StatusMsg').attr('class','alert alert-$status').text('".str_replace("'","\\'",$msg)."');");
    }

    private function StatusBannerAsHtmlWithTitle($title) {
        $html = "";
        $html .= '<div class="col-sm-12">';
        $html .= '<div class="alert alert-info" role="alert" id="'.get_class($this).'StatusMsg">'.$title.'</div>';
        $html .= '</div>';
        return $html;
    }
		

    public function generateHtmlForm() {

        $html = "";

        $html .= '<div class="mb-3 row">';

		/* 1. Render STATUS BANNER */
        $html .= $this->StatusBannerAsHtmlWithTitle($this->initialStatusBannerMsg);

		/* 2. Render INPUT FIELDS */
        foreach($this->data as $machineName => $obj)
			$html .= recursiveRenderHtmlInputField($obj);

		/* 3. Render BUTTONS */
        $html .= '<div class="col-sm-12">';
        foreach($this->actions as $actionName => $props) {
            $html .= '<button type="button" class="btn btn-'.($props["style"]??"primary").' float-end" onclick="submitData(this)" name="'.get_class($this)."\\".$actionName.'" >'.$props["label"].'</button>';
        }
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }
	
}