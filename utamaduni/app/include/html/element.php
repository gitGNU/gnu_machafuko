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

include_once ('element/base.php');

/**
 * html_element.php
 *
 * This class implement the factory pattern to create html elemnts
 * objects.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_element
{
  // {{{ factory ($type)
  /**
   * factory
   *
   * Factory method.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $type the element type.
   */
  static public function factory ($type, $id)
  {
    $file = 'element/' . $type . '.php';
    if (include_once ($file))
      {
	$class = 'html_element_' . $type;
	if (class_exists ($class))
	  {
	    $element = new $class ($id);
	    if ($element instanceof html_element_base)
	      {
		return $element;
	      }
	    else
	      {
		throw new Exception ('Invalid html element: ' . $type . '.');
	      }
	  }
	else
	  {
	    throw new Exception ('Html element class not found: ' . $class . '.');
	  }
      }
    else
      {
	throw new Exception ('Html element file not found: ' . $file . '.');
      }
  }
  // }}}
}

?>