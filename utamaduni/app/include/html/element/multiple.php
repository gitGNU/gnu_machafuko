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
 * html_element_multiple.php
 *
 * Select form element with a format that do more easy select several options.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_element_multiple extends html_element_select
{
  // {{{ properties
  /**
   * $visible
   *
   * The visible elements.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var integer $visible
   */
  protected $visible = 5;
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
      $this -> name . "[]' multiple size='" . $this -> visible . "'>";

    foreach ($this -> options as $key => $val)
      {
	$html .= "<option value='" . $key . "'";
	if ($val == $this -> value)
	  $html .= " selected";
	$html .= ">" . $val . "</option>";
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
