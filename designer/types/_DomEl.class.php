<?php
class _DomEl {

	private $tag;
	private $cssClasses = [];
	private $attributes = [];
	private $children = [];
	private $innerText = "";
	
	public function __construct(string $t) {
		$this->tag = $t;
	}
	
	public function setTag(string $t) {$this->tag = $t; return $this;}

	public function addClass(string $cssClass) {$this->cssClasses[] = $cssClass; return $this;}
	
	public function setAttr(string $key, string $value) {if (!empty($key)) $this->attributes[$key] = $value; return $this;}
	
	public function addChild(_DomEl $child) { $this->children[] = $child; return $this; }
	
	public function setText(string $t) { $this->innerText = $t; return $this; }

	public function render() {
		$html = "";
		$html .= "<".$this->tag;
		if (!empty($this->cssClasses)) $html .= ' class="'.implode(" ", $this->cssClasses).'"';
		if (!empty($this->attributes)) $html .= ' '.array_reduce(array_keys($this->attributes),fn($c,$i)=>"$c ".$i.'="'.$this->attributes[$i].'"', "");
		$html .= ">";
		if (!empty($this->children))   $html .= implode("", array_map(fn($o)=>$o->render(),$this->children));
		if (!empty($this->innerText))  $html .= $this->innerText;
		$html .= "</".$this->tag.">";
		return $html;
	}
	
	public function __toString() {return $this->render();}
	
}
?>