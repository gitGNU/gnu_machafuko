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

include_once ('rule/base.php');

/**
 * html_rule.php
 *
 * This class implement the factory pattern to create html rules
 * objects. They are added to elements form.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_rule
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
  static public function factory ($type, $element_object, $msg)
  {
    $file = 'rule/' . $type . '.php';
    if (include_once ($file))
      {
	$class = 'html_rule_' . $type;
	if (class_exists ($class))
	  {
	    $rule = new $class ($element_object, $msg);
	    if ($rule instanceof html_rule_base)
	      {
		return $rule;
	      }
	    else
	      {
		throw new Exception ('Invalid html form rule: ' . $type . '.');
	      }
	  }
	else
	  {
	    throw new Exception ('Html rule class not found: ' . $class . '.');
	  }
      }
    else
      {
	throw new Exception ('Html form rule file not found: ' . $file . '.');
      }
  }
  // }}}
}

?>