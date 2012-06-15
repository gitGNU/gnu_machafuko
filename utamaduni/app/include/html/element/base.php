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

include_once ('label.php');

/**
 * html_element_base.php
 *
 * A base class to the elements.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
abstract class html_element_base
{
  // {{{ properties
  /**
   * Theses are constants static values to specifies the size of the
   * text fields.
   *
   * S: small.
   * N: normal.
   * B: big.
   * SB: super big.
   */
  static $S_TEXT_SIZE = 10;
  static $N_TEXT_SIZE = 30;
  static $B_TEXT_SIZE = 50;
  static $SB_TEXT_SIZE = 100;

  /**
   * Theses are constants static values to specifies the cols and the rows of the
   * textarea fields.
   *
   * S: small.
   * N: normal.
   * B: big.
   * SB: super big.
   */
  static $S_ROWS = 2;
  static $N_ROWS = 3;
  static $B_ROWS = 4;
  static $SB_ROWS = 8;
  static $S_COLS = 10;
  static $N_COLS = 30;
  static $B_COLS = 50;
  static $SB_COLS = 100;
  
  /**
   * $label
   *
   * The label of the field.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $label
   */
  var $label = null;

  /**
   * $id
   *
   * The html id tag value.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $id
   */
  var $id = null;

  /**
   * $class
   *
   * The html class tag value.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $class
   */
  var $class = null;

  /**
   * $name
   *
   * The html name tag value.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $name
   */
  var $name = null;

  /**
   * $value
   *
   * The value of the field.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $value
   */
  var $value = null;

  /**
   * $events
   *
   * Array with events (onclick, etc). Is a map array with event => function.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var array $events
   */
  var $events = array ();

  /**
   * $divs
   *
   * This property can sets to put a set of div tags below this element (to show a message 
   * through JavaScript, for exemple). It is a map: id => content.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var array $divs
   */
  var $divs = array ();

  /**
   * $containers
   *
   * If you want to envelop this element you can use this property. It util to put a
   * set of divs enveloping the element. For example:
   *
   * <div id='myid' class='myclass'>
   *   <div id='myid' class='anotherclass'>
   *     the element
   *   </div>
   * </div>
   */
  var $containers = array ();
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $id id html tag value.
   * @param string $class class html tag value.
   * @param string $name name html tag value.
   */
  public function __construct ($id, $class = null, $name = null)
  {
    $this -> id = $id;
    $this -> class = $class != null ? $class : $id;
    $this -> name = $name != null ? $name : $id;
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
  }
  // }}}

  // {{{ set_label ($label)
  /**
   * set_label
   *
   * Set the label of the field.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $content The label content
   * @param string $class The class attribute
   */
  public function set_label ($label, $class = null)
  {
    $this -> label = new html_element_label ($label, $class);
  }
  // }}}

  // {{{ get_label ()
  /**
   * get_label
   *
   * Get the label.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_label ()
  {
    return $this -> label;
  }
  // }}}

  // {{{ set_value ($value)
  /**
   * set_value
   *
   * Set the value of the field.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $value
   */
  public function set_value ($value)
  {
    $this -> value = $value;
  }
  // }}}

  // {{{ add_event ($event, $function)
  /**
   * add_event
   *
   * Add a new event into events array.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $event the key of the array.
   * @param string $function the event action.
   */
  public function add_event ($event, $function)
  {
    $this -> events[$event] = $function;
  }
  // }}}

  // {{{ add_div ($id, $content)
  /**
   * add_div
   *
   * This method create a entry into $divs array.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $id the id property of the div tag.
   * @param string $class the class property of the div tag.
   * @param string $content the content of the div tag.
   */
  public function add_div ($id, $class, $content)
  {
    $this -> divs[] = array ('id' => $id, 'class' => $class, 'content' => $content);
  }
  // }}}

  // {{{ add_container ($id, $class)
  /**
   * add_container
   *
   * This method create a entry into containers. The containers is an array of array.
   * Each entry is in the form [] => {$id, $class}.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $html_tag the html tag (the container: div, span, etc).
   * @param string $id the id property of the container.
   * @param string $class the class property of the container.
   */
  public function add_container ($html_tag, $id, $class)
  {
    $this -> containers[] = array ('tag' => $html_tag, 'id' => $id, 'class' => $class);
  }
  // }}}

  // {{{ to_html ()
  /**
   * to_html
   *
   * Get the html code of the element.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  abstract public function to_html ();
  // }}}
}

?>
