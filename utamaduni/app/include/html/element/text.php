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
 * html_element_text.php
 *
 * Text input element.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_element_text extends html_element_base
{
  // {{{ properties
  /**
   * $size
   *
   * Characters wide of the element.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var integer $size
   */
  protected $size = null;

  /**
   * $length
   *
   * Maximum length of the element.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var integer $length
   */
  protected $length = null;
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

  // {{{ set_size ($size)
  /**
   * set_size
   *
   * Set the size of the element.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $size the characters wide of the input text.
   */
  public function set_size ($size)
  {
    $this -> size = $size;
  }
  // }}}

  // {{{ set_max_length ($len)
  /**
   * set_max_length
   *
   * Set the maximum length of the text input field.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $len the maximum length.
   */
  public function set_max_length ($len)
  {
    $this -> length = $len;
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

    $html .= "<input type='text' id='" . $this -> id . "' name='" .
      $this -> name . "' ";
    if ($this -> size)
      $html .= "size='" . $this -> size . "' ";
    if ($this -> length)
      $html .= "maxlength='" . $this -> length . "' ";
    if ($this -> value)
      $html .= "value='" . $this -> value . "' ";
    if ($this -> class)
      $html .= "class='" . $this -> class . "' ";
    foreach ($this -> events as $event => $function)
      $html .= $event . "='" . $function . "' ";
    $html .= "/>";

    $html .= $close;
    
    return $html;
  }
  // }}}
}

?>