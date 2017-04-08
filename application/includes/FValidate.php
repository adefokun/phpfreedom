<?php
class FValidate {
	function Email($entry){
		$emailPattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
		return preg_match($emailPattern,$entry);
	}
}