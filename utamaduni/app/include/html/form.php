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
 * html_form.php
 *
 * This class creates and manages the HTML form.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_form
{
  // {{{ properties
  /**
   * $id
   *
   * The form identifier.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $id
   */
  var $id;

  /**
   * $name
   *
   * The form name tag.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $name
   */
  var $name;

  /**
   * $class
   *
   * The form class tag.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $class
   */
  var $class;

  /**
   * $method
   *
   * The method (post or get).
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $method
   */
  var $method;

  /**
   * $action
   *
   * The submit action.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $action
   */
  var $action;

  /**
   * $enctype
   *
   * The encode type of the form.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $enctype
   */
  var $enctype;

  /**
   * $target
   *
   * Attribute of the form target.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $target
   */
  var $target;

  /**
   * $elements
   *
   * Array with all form elements objects.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var mixed $elements
   */
  var $elements = array ();

  /**
   * $rules
   *
   * Array with all elements rules. The rules can be:
   * - required: the field is required.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var mixed $rules
   */
  var $rules = array ();

  /**
   * $renderer
   *
   * It is a type of renderer (html, latex, etc).
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $renderer
   */
  var $renderer = 'html';
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ($id, $method, $action, $enctype = null, 
			       $target = null, $name = null, $class = null)
  {
    $this -> id = $id;
    $this -> method = $method;
    $this -> action = $action;
    $this -> enctype = $enctype;
    $this -> target = $target;
    $this -> name = $name ? $name : $id;
    $this -> class = $class ? $class : $id;
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

  // {{{ add_element ($element)
  /**
   * add_element
   *
   * Add a new element to the form.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $element element type ('text', 'select', etc).
   * @param string $id id html tag value.
   * @param string $class class html tag value.
   * @param string $name name html tag value.
   */
  public function add_element ($element, $id, $class = null, $name = null)
  {
    $element_object = html_element::factory ($element, $id);
    if ($class)
      $element_object -> class = $class;
    if ($name)
      $element_object -> name = $name;
    $this -> elements[$id] = $element_object;

    return $element_object;
  }
  // }}}

  // {{{ add_rule ($element, $msg, $rule)
  /**
   * add_rule
   *
   * Add a element rule.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $element the element id.
   * @param string $msg the message to show.
   * @param string $rule type of rule (required, etc).
   * @param string $id the id of the div html tag.
   * @param string $class the class of the div html tag.
   */
  public function add_rule ($element, $msg, $rule, $id = null, $class = null)
  {
    $element_object = $this -> elements[$element];
    if ($element_object instanceof html_element_base)
      {
	$this -> rules[$element] = html_rule::factory ($rule, $element_object, $msg);
	$this -> rules[$element] -> id = $id != null ? $id : '';
	$this -> rules[$element] -> class = $class != null ? $class : '';
      }
    else
      throw new Exception ('The element ' . $element . ' do not exists and is not possible ' .
			   'add a rule to this element.');
  }
  // }}}

  // {{{ validation ()
  /**
   * validation
   *
   * Execute all validation rules.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function validation ()
  {
    foreach ($this -> rules as $rule)
      if (!$rule -> validation ())
	return false;

    return true;
  }
  // }}}

  // {{{ set_renderer ($renderer)
  /**
   * set_renderer
   *
   * It changes the type of renderer.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function set_renderer ($renderer)
  {
    $this -> renderer = $renderer;
  }
  // }}}

  // {{{ display ($type)
  /**
   * display
   *
   * Display the form.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function display ()
  {
    $renderer = html_renderer::factory ($this -> renderer, $this);
    return $renderer -> render ();
  }
  // }}}
}

?>
