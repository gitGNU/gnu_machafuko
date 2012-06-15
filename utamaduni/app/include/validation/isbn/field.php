<?php
/*
 * Utamaduni (suajili language meaning 'culture') is a book management.
 * Copyright (C) 2012 Román Ginés Martínez Ferrández <romangines@riseup.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * field.php
 *
 * ISBN field validator.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class validation_isbn_field
{
  // {{{ properties
  /**
   * $fieldname
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $fieldname
   */
  private $fieldname;

  /**
   * $message
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $message Error message.
   */
  private $message;
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * The validator needs the fieldname and the message.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ($fieldname, $message)
  {
    $this -> fieldname = $fieldname;
    $this -> message = $message;
  }
  // }}}

  // {{{ __desctruct ()
  /**
   * __destruct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __destruct ()
  {
  }
  // }}}

  // {{{ validation ($coordinator)
  /**
   * validation
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function validation ($coordinator)
  {
    $field = $coordinator -> get ($this -> fieldname);
    
    if (empty ($field))
      {
	$coordinator -> set_clean ($this -> fieldname);
	return TRUE;
      }
    else
      {
	$subfields = explode ('-', $field);
	$all = true;
	foreach ($subfields as $f)
	  {
	    if (!ctype_digit ($f))
	      {
		$all = false;
		break;
	      }
	  }
	if ($all)
	  {
	    $coordinator -> set_clean ($this -> fieldname);
	    return TRUE;
	  }
	else
	  {
	    $coordinator -> add_error ($this -> message);
	    return FALSE;
	  }
      }
  }
  // }}}
}

?>