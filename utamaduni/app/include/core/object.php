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

require_once ('Log.php');

/**
 * core_object
 *
 * This is the base object class for all the classes core. Provide basic 
 * functionality.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
abstract class core_object
{
  /**
   * $log
   *
   * @var mixed $log Instance of PEAR Log 
   */
  protected $log;

  /**
   * $me
   *
   * @var mixed $me Instance of ReflectionClass
   */
  protected $me;

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ()
  {
    $this -> log = Log::factory ('file', UT_LOG_FILE);
    $this -> me = new ReflectionClass ($this);
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
    if ($this -> log instanceof Log)
      $this -> log -> close ();
  }
  // }}}

  // {{{ set_from ($data)
  /**
   * set_from
   *
   * Assigns values to properties through data array.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param mixed $data Array of variables to assign to instance.
   * @return void.
   */
  public function set_from ($data)
  {
    if (is_array ($data) && count ($data))
      {
	// get_class gets the name of the class of the given object.
	// get_class_vars gets the default properties of the given class name.
	$valid = get_class_vars (get_class ($this));
	foreach ($valid as $var => $val)
	  {
	    if (isset ($data[$var]))
	      $this -> $var = $data[$var];
	  }
      }
  }
  // }}}

  // {{{ to_array ()
  /**
   * to_array
   *
   * Return a array with values of the class properties.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @return mixed Array of properties keyed by variable name.
   */
  public function to_array ()
  {
    // getDefaultProperties is a ReflectionClass method.
    $defaults = $this -> me -> getDefaultProperties ();
    $return = array ();
    foreach ($defaults as $var => $val)
      {
	if ($this -> $var instanceof core_object)
	  $return[$var] = $this -> $var -> to_array ();
	else
	  $return[$var] = $this -> $var;
      }

    return $return;
  }
}

?>