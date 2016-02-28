<?php
class Example extends Entry implements ModelInterface {
    static $table_name = 'example';
    
    public function __construct(int $id) {
        parent::__construct($id);
    }
}