<?php
class _jQuery {

	private $content = [];
	
	public function __construct(string $content, $literal = false) {
		$this->content[] = ($literal?$content:"(".$this->escapeData($content).")");
	}
	
	private function escapeData($d) {if (is_string($d)) return "'".str_replace("'","\\'",$d)."'"; else return $d;}
	
	public function find(string $str) { $this->content[] = "find(".$this->escapeData($str).")"; return $this;}
	
	public function insertBefore(_jQuery $jq) { $this->content[] = "insertBefore(".$jq.")"; return $this;}

	public function prepend(_jQuery $jq) { $this->content[] = "prepend(".$jq.")"; return $this;}
	
	public function html(string $str) { $this->content[] = "html(".$this->escapeData($str).")"; return $this;}
	
	public function __toString() {
		return "$".implode(".",$this->content);
	}
	
}
?>