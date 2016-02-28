<?php
class Utils {
	public static function time(): int {
		$jet_lag = 0;
		return time() + (3600 * $jet_lag); 
	}
}