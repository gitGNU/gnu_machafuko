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
 * html_element_select.php
 *
 * Select form element.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_element_select extends html_element_base
{
  // {{{ properties
  /**
   * $options
   *
   * Array with select values (options).
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var integer $options
   */
  protected $options = array ();

  /**
   * $binsert
   *
   * It is a button which can be used to insert news optiones into this select.
   * The type of this property is html_element_button
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var object $binsert
   */
  protected $binsert = null;
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
    parent::__construct ($id, $class, $name);
    $this -> size = html_element_base::$N_TEXT_SIZE;
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

  // {{{ set_options ($opt)
  /**
   * set_options
   *
   * Set the options array if $opt is an array.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param mixed $opt the options array.
   */
  public function set_options ($opt)
  {
    if (is_array ($opt))
      $this -> options = $opt;
  }
  // }}}

  // {{{ set_selected ($sel)
  /**
   * set_selected
   *
   * Set the selected option of the array options if $sel option exists into
   * $options array.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $sel selected option of the options array.
   */
  public function set_selected ($sel)
  {
    if (array_key_exists ($sel))
      $this -> value = $this -> options[$sel];
  }
  // }}}

  // {{{ set_list_values ($opt, $sel)
  /**
   * set_list_values
   *
   * Set the $options array and $selected option if set.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param mixed $opt the array with options.
   * @param mixed $sel the selected option.
   */
  public function set_list_values ($opt, $sel)
  {
    if (is_array ($opt))
      {
	$this -> options = $opt;
	if (array_key_exists ($sel, $opt))
	  $this -> value = $this -> options[$sel];
      }
  }
  // }}}

  // {{{ set_insert_button ($id, $class, $name)
  /**
   * set_insert_button
   *
   * Set the binsert property.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $id identifier of the html tag.
   * @param string $value value of the button (the label).
   * @param string $class html class of the tag.
   * @param string $name html name of the tag.
   */
  public function set_insert_button ($id, $value = null, $class = null, $name = null)
  {
    $this -> binsert = new html_element_button ($id, $class, $name);
    if ($value)
      $this -> binsert -> set_value ($value);
  }
  // }}}

  // {{{ get_insert_button ()
  /**
   * get_insert_button
   *
   * Return the binsert property.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_insert_button ()
  {
    return $this -> binsert;
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
  public function to_html ()
  {
    $close = '';
    $html = '';

    foreach ($this -> containers as $idx => $contents)
      {
	$html .= "<" . $contents['tag'] . " id='" . $contents['id'] .
	  "' class='" . $contents['class'] . "'>";
	$close .= '</' . $contents['tag'] . '>';
      }

    $html .= "<select type='text' id='" . $this -> id . "' name='" .
      $this -> name . "'>";

    foreach ($this -> options as $opt)
      {
	$html .= "<option";
	if ($opt == $this -> value)
	  $html .= " selected";
	$html .= ">" . $opt . "</option>";
      }

    $html .= "</select>";

    if ($this -> binsert)
      $html .= $this -> binsert -> to_html ();

    $html .= $close; // Close all containsers.
    
    return $html;
  }
  // }}}
}

?>