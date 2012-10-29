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

	public static function user($self, $name, $value='SKUNKSANDSEALS')
	{
		global $user;

		if ($value == 'SKUNKSANDSEALS') {
			return $user[$name];
		} else {
			$user[$name] = $value;
		}
	}

	public static function console_input($self, $buffername) {
		$self->pause = true;
		$self->state = 1;
		$self->buffername = $buffername;
	}

	public static function console_print($self, $output) {
		self::c_print($self,$output);
	}

	public static function console_printl($self, $output) {
		self::c_print($self,$output.chr(10));
	}

	public static function console_goto($self, $label) {
		if (!array_key_exists($label,$self->labels)) {
			self::console_error($self,'Label Not Found '.$label);
		} else {
			if ($self->jumps + 1 > $self->maxjumps) {
				self::console_error($self,'Too Many Jumps Error '.$self->maxjumps);
			} else {
				$self->jumps++;
				$self->pc = $self->labels[$label];
			}
		}
	}

	public static function console_gosub($self, $label) {
		if (!array_key_exists($label,$self->labels)) {
			self::console_error($self,'Label Not Found '.$label);
		} else {
			if (count($self->gosub_stack) + 1 > $self->maxstack) {
				self::console_error($self,'Stack Overflow Error '.$self->maxstack);
			} else {
				array_push($self->gosub_stack, $self->pc + 1);
				$self->pc = $self->labels[$label];
			}
		}
	}

	public static function console_end($self) {
		$self->pc = $self->lines + 1;
	}

	public static function console_return($self) {
		$self->pc = array_pop($self->gosub_stack);
	}

	public static function console_if($self, $logic) {
		$self->test = false;
		if ($logic) {
			$self->test = true;
			$self->run_line($self->step2);
		}
	}

	public static function console_else($self) {
		if ($self->test == false) {
			$self->run_line($self->step2);
		}
	}

	public static function console_debug($self) {
		print_r($self->vars);
		print_r($self->labels);
		print_r($self->gosub_stack);
		print_r($self->jumps);
	}

	public static function c_print($self,$output) {
		$str = str_replace('##','SKUNKSANDSEALS#',$output);
		foreach ($self->vars as $key => $value) {
			$str = str_replace('#'.$key,$value,$str);
		}
		$str = str_replace('SKUNKSANDSEALS','#',$str);
		echo $str;
	}
	
	public static function console_error($self,$msg) {
		$self->trigger($msg);
		$self->last_error = $msg;
	}

}

/*
// remark
:label
input(a)
print("")
printl("")
jump label
gosub label
return
let c = 23 + 1
if(a = 3) jump label
not(a = 3) jump label
debug()
*/