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
 * presenter.php
 *
 * Presenter factory class that is used by controller with the 
 * core_module::presenter variable to produced the desired 
 * presenter class.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class core_presenter
{
  // {{{ factory ($type, core_module $module)
  /**
   * factory
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $type Presentation type (our view)
   * @param mixed $module Our module, which the presenter will display
   * @return throw exception on failure or a valid presenter
   */
  static public function factory ($type, core_module $module)
  {
    $file = UT_BASE_PATH . '/include/core/presenter/' . $type . '.php';
    if (include_once ($file)) 
      {
	$class = 'core_presenter_' . $type;
	if (class_exists ($class)) 
	  {
	    $presenter = new $class ($module);
	    if ($presenter instanceof core_presenter_base)
	      {
		return $presenter;
	      }
	    throw new Exception ('Invalid presentation class: ' . $type);
	  }
	 throw new Exception ('Presentation class not found: ' . $type);
      }
    throw new Exception ('Presenter file not found: ' . $type);
  }
  // }}}
}

?>