<?php
class Faq extends ActiveRecord\Model {

	static $table_name = 'faqs';

	public function erase() {
		$this->delete();
	}
}