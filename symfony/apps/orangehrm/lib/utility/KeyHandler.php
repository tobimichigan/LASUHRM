<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class KeyHandler {

	private static $filePath = '/lib/confs/cryptokeys/key.ohrm';
	private static $key;
	private static $keySet = false;

    public static function createKey() {

		if (self::keyExists()) {
			throw new KeyHandlerException('Key already exists', KeyHandlerException::KEY_ALREADY_EXISTS);
		}

		// Creating the key
		try {

			$cryptKey = '';

			for($i = 0; $i < 4; $i++) {
				$cryptKey .= md5(rand(10000000, 99999999));
			}

			$cryptKey = str_shuffle($cryptKey);

			$handle = fopen(ROOT_PATH . self::$filePath, 'w');
			fwrite($handle, $cryptKey, 128) or die('error');
		    fclose($handle);

		} catch (Exception $e) {

			throw new KeyHandlerException('Failed to create the key file', KeyHandlerException::KEY_CREATION_FAILIURE);

		}

		if (self::keyExists()) {
			return true;
		} else {
		    return false;
		}

    }

    public static function readKey() {

		if (!self::keyExists()) {

			throw new KeyHandlerException('Key file does not exist', KeyHandlerException::KEY_DOES_NOT_EXIST);

		}

		if (!is_readable(ROOT_PATH . self::$filePath)) {

			throw new KeyHandlerException('Key is not readable', KeyHandlerException::KEY_NOT_READABLE);

		}

		if (!self::$keySet) {
	    	self::$key = trim(file_get_contents(ROOT_PATH . self::$filePath));
			self::$keySet = true;
		}

		return self::$key;

    }

    public static function deleteKey() {

		if (!self::keyExists()) {
			throw new KeyHandlerException('Key does not exist', KeyHandlerException::KEY_DOES_NOT_EXIST);
		}

		// Deleting
		try {
			@unlink(ROOT_PATH . self::$filePath);
		} catch (Exception $e) {
			throw new KeyHandlerException('Failed to delete the key file', KeyHandlerException::KEY_DELETION_FAILIURE);
		}

		if (!self::keyExists()) {
			return true;
		} else {
		    return false;
		}

    }

    public static function keyExists() {

		return (file_exists(ROOT_PATH . self::$filePath));

    }

}

class KeyHandlerException extends Exception {

	const KEY_DOES_NOT_EXIST		= 1;
	const KEY_NOT_READABLE			= 2;
	const KEY_ALREADY_EXISTS		= 3;
	const KEY_CREATION_FAILIURE	= 4;
	const KEY_DELETION_FAILIURE	= 5;

}
?>
