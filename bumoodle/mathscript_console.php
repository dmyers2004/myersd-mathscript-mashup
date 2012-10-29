<?php

/**
 * console function extension for MathScript.
 * 
 * @package 
 * @version $id$
 * @copyright 2011, 2012 Binghamton University
 * @author Kyle Temkin <ktemkin@binghamton.edu> 
 * @license GNU Public License, {@link http://www.gnu.org/copyleft/gpl.html}
 */
class mathscript_console
{

	public static function user($self, $name, $value="#$#$")
  {
		global $user;		

		if ($value == '#$#$') {
			return $user[$name];
		} else {
			$user[$name] = $value;		
		}
  }
  
  public static function y($self, $logic) {
  	return $logic;
  }

  public static function n($self, $logic) {
  	return !$logic;
  }

}