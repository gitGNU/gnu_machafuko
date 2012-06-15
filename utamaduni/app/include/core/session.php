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
 * core_session
 *
 * The base session class as a singleton. Handles creating the session,
 * writing to the session variable (via overloading) and destroying the
 * session.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class core_session
{
  // {{{ properties
  /**
   * $instance
   *
   * Instance variable used for singleton pattern. Stores a single instance of
   * core_session.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var mixed $instance
   */
  private static $instance;

  /**
   * $sessionID
   *
   * The session ID assigned by PHP.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $session_id
   */
  public static $session_id;
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * Starts the session and sets the session_id for the class.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  private function __construct ()
  {
    session_start ();
    self::$session_id = session_id ();
  }
  // }}}

  // {{{ __destruct ()
  /**
   * __destruct
   *
   * Writes the current session.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __destruct ()
  {
    session_write_close ();
  }
  // }}}

  // {{{ singleton ()
  /**
   * singleton
   * 
   * Implementation of the singleton pattern. Returns a single instance of the
   * session class.
   * 
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @return mixed Instance of session.
   */
  public static function singleton ()
  {
    if (!isset (self::$instance)) 
      {
	$class_name = __CLASS__;
	self::$instance = new $class_name;
      }

    return self::$instance;
  }
  // }}}

  // {{{ destroy ()
  public function destroy ()
  {
    foreach ($_SESSION as $var => $val) 
      {
	$_SESSION[$var] = null;
      }

    session_destroy ();
  }
  // }}}

  // {{{ __clone ()
  /**
   * __clone
   *
   * Disable PHP5's cloning method for session so people can't make copies
   * of the session instance.
   * 
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __clone ()
  {
    trigger_error ('Clone is not allowed for ' . __CLASS__, E_USER_ERROR);
  }
  // }}}

  // {{{ __get ($var)
  /**
   * __get
   *
   * Returns the requested session variable. If it does not exists session variable then
   * it returns null.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @return mixed
   */
  public function __get ($var)
  {
    if (isset ($_SESSION[$var]))
      return $_SESSION[$var];
    return null;
  }
  // }}}

  // {{{ __set ($var, $val)
  /**
   * __set 
   * 
   * Using PHP5's overloading for setting and getting variables we can
   * use $session->var = $val and have it stored in the $_SESSION 
   * variable.
   * 
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $var
   * @param mixed $val
   */
  public function __set ($var, $val)
  {
    return ($_SESSION[$var] = $val);
  }
  // }}}
}

?>