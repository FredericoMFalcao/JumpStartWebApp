<?php
function recursivelyGetValue($o) {if (is_array($o)) return array_map(fn($p)=>recursivelyGetValue($p),$o); else return $o->getValue();}	
/*function recursiveRenderInputField(array|_Type $o,$cssNo = 0): _DomEl {
	if (is_array($o))
		return (new _DomEl("div"))
			->addClass("c$cssNo")
			->after()
		return "<div class='c$cssNo'>".implode("</div><div class='c$cssNo'>",array_map(fn($p)=>recursiveRenderInputField($p,++$cssNo),$o))."</div>";
	else 
		return $o->renderHtmlInputField();
}*/

		
class _Component {
	
	protected $DomId = null;

	public function _getTabFriendlyName() { return "Title not defined."; }

	public function __construct() {}

    const priority = 0;
	
    /*
    *	1. Graphics
    *
    */
	public function setDomId(string $s) { $this->DomId = $s; return $this;}
	public function getDomId()          { return $this->DomId;}
	

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

    private function StatusBannerWithTitle($title): _DomEl {
		return (new _DomEl("div"))
			->addClass("col-sm-12")
			->addChild((new _DomEl("div"))
				->addClass("alert")
				->addClass("alert-info")
				->attr("role","alert")
				->id(get_class($this).'StatusMsg')
				->text($title)
					
		    )
	    ;
    }
		

    public function generateHtmlForm() {

        $outputDiv = (new _DomEl("div"))
			->addClass("mb-3")
			->addClass("row");

		/* 1. Render STATUS BANNER */
        $outputDiv->addChild($this->StatusBannerWithTitle($this->initialStatusBannerMsg));

		/* 2. Render INPUT FIELDS */
		$outputDiv->addChildren($this->data);		

		/* 3. Render BUTTONS */
		$buttonsRow = $outputDiv->addChild((new _DomEl("div"))->addClass("col-sm-12")->addClass("buttons-row"));
        foreach($this->actions as $actionName => $props) {
			$buttonsRow->addChild(
				(new _DomEl("button"))
				->attr("type","button")
				->addClass("btn")->addClass("btn-".($props["style"]??"primary"))
				->addClass("float-end")
				->attr("onclick","submitData(this)")
				->attr("name",get_class($this)."\\".$actionName)
				->text($props["label"])
			)
			;
        }		
		$outputDiv->addChild($buttonsRow);
		return $outputDiv;
    }
	
}