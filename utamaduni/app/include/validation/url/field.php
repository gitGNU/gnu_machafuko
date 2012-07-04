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
 * URL field validator.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class validation_url_field extends validation_field
{
  // {{{ validation ($coordinator)
  /**
   * validation
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function validation ($coordinator)
  {
    $field = $coordinator -> get ($this -> fieldname);

    if ($field !== null)
      {
	if ($this -> check_required ($field))
	  {
	    if (filter_var ($field, FILTER_VALIDATE_URL))
	      {
		$coordinator -> set_clean ($this -> fieldname);
		return TRUE;
	      }
	    elseif ($field === '')
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
	else
	  {
	    $coordinator -> add_error ($this -> message);
	    return FALSE;
	  }
      }
    else
      {
	// Field does not exits...
	$coordinator -> add_error ($this -> message);
	return FALSE;
      }
  }
  // }}}
}

?>