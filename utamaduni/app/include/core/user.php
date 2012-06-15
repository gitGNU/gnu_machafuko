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
 * core_user
 *
 * Base user object with his information.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class core_user extends core_object_db
{
  // {{{ properties
  public $user_id;
  public $email;
  public $password;
  public $fname;
  public $lname;
  // }}}

  // {{{ __construct ($user_id)
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param Integer $user_id the user identification.
   */
  public function __construct ($user_id = null)
  {
    parent::__construct ();
    if ($user_id  === null)
      {
	$session = core_session::singleton ();
	if (isset ($session -> user_id))
	  if (!is_numeric ($session -> user_id))
	    $user_id = 0;
	  else
	    $user_id = $session -> user_id;
	else
	  $user_id = 0;
      }
  }
  // }}}
  
  // {{{ __destruct ()
  /**
   * __destruct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __destruct ()
  {
    parent::__destruct ();
  }
  // }}}
}

?>