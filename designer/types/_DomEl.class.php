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
	
	public function attr(string $key, string $value) {if (!empty($key)) $this->attributes[$key] = $value; return $this;}
	
	public function addChild(_DomEl|_Type $child) { $this->children[] = ($child instanceof _Type?$child->asDomEl():$child); return $this; }

	public function addChildren(array $children) { 
		foreach($children as $child) 
			if (is_array($child)) $this->addChildren($child); else $this->addChild($child); return $this; }
	
	public function text(string $t) { $this->innerText = $t; return $this; }
	
	public function id(string $i) {$this->attributes["id"] = $i; return $this; }

	public function render() :string {
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
	
	public function __toString() {print_r($this); die();return $this->render();}
	
}
?>