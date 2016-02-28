<?php
abstract class Entry extends Model {	
	public function __construct(int $id) {
   		$data = $this->requestDb($id);
   		foreach ($data as $key => $value) {
   			if (!is_numeric($key) ) {
   				$this->$key = $value;
   			}
   		}
	}

	public function save() {
	    if (isset($this->id)) {
	    	$attr = get_object_vars($this);
    		unset($attr['id']);
    		$cols = array_keys($attr);
    		$args = array_values($attr);
    		$this->saveToDb($this->id, $cols, $args);
	    }
	}

	public function delete() {
	    if (isset($this->id)) {
    		$this->removeFromDb($this->id);
	    }
	}
}