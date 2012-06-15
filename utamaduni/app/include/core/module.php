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
 * module.php
 *
 * This class is the module base class. All modules extends from it.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
abstract class core_module extends core_object_web
{
  // {{{ properties
  /**
   * $data
   *
   * Data set by the module that will eventually be passed to the view.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var array $data Data set
   */
  protected $data = array ();

  /**
   * $name
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $name Name of module class.
   */
  public $name;

  /**
   * $tpl_file
   *
   * Template file name (with extension). This file name is used by presenter
   * (view) to load the template file.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $tpl_file Name of template file.
   */
  public $tpl_file;

  /**
   * $presenter
   *
   * Used in core_presenter::factory () to determine which presentation (view)
   * class should be used for the module.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $presenter
   */
  public $presenter = 'html';

  /**
   * $module_name
   *
   * Used by presenter to access to template file of the module.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $module_name 
   */
  public $module_name;  
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ()
  {
    parent::__construct ();
    // getName is a ReflectionClass method.
    $this -> name = $this -> me -> getName ();
    $this -> tpl_name = $this -> name . '.tpl.html';
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
    parent::__destruct ();
  }
  // }}}

  // {{{ __default ()
  /**
   * __default
   *
   * This function will be ran by model if an event (method) is not specified
   * in the request.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  abstract public function __default ();
  // }}}

  // {{{ get_data ()
  /**
   * get_data
   *
   * Return module's data member.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @return mixed
   */
  public function get_data ()
  {
    return $this -> data;
  }
  // }}}

  // {{{ set ($var, $val)
  /**
   * set
   *
   * Set values for the module's data.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $var Name of variable
   * @param mixed $val Value of variable
   */
  public function set ($var, $val)
  {
    $this -> data[$var] = $val;
  }
  // }}}

  // {{{ is_valid ($module)
  /**
   * is_valid
   *
   * Determines if the module is a valid module.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param mixed @module The object to validated
   * @return bool
   */
  public static function is_valid ($module)
  {
    return (is_object ($module) && $module instanceof core_module);
  }
  // }}}
}

?>