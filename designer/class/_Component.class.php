<?php
	
class _Component {
	
	public function _getTabFriendlyName() { return "Title not defined."; }
	
	public function parseUserInput() {
		foreach($_POST as $k => $v ) $this->data[$k]["value"] = $v;
		return $this;
	}	
	
}