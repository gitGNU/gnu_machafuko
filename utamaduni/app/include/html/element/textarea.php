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
 * html_element_textarea.php
 *
 * Text area input element.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_element_textarea extends html_element_base
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
  private $size = null;

  /**
   * $length
   *
   * Maximum length of the element.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var integer $length
   */
  private $length = null;

  /**
   * $rows
   *
   * The rows attribute that controls how many lines of the text are
   * visible in the textarea at one time.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var integer $rows
   */
  private $rows = null;

  /**
   * $cols
   *
   * The columns attribute that controls the width of the area.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var integer $rows
   */
  private $cols = null;
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
    $this -> rows = html_element_base::$N_ROWS;
    $this -> cols = html_element_base::$N_COLS;
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

  /**
   * set_rows ($rows)
   *
   * Set the rows attribute.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $rows the rows.
   */
  public function set_rows ($rows)
  {
    $this -> rows = $rows;
  }
  // }}}

  // {{{ set_cols ($cols)
  /**
   * set_cols
   *
   * Set the width of the area.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $cols the columns.
   */
  public function set_cols ($cols)
  {
    $this -> cols = $cols;
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

    $html .= "<textarea id='" . $this -> id . "' name='" .
      $this -> name . "' ";
    if ($this -> size)
      $html .= "size='" . $this -> size . "' ";
    if ($this -> length)
      $html .= "maxlength='" . $this -> length . "' ";
    if ($this -> rows)
      $html .= "rows='" . $this -> rows . "' ";
    if ($this -> cols)
      $html .= "cols='" . $this -> cols . "' ";
    if ($this -> value)
      $html .= "value='" . $this -> value . "' ";
    foreach ($this -> events as $event => $function)
      $html .= $event . "='" . $function . "' ";
    $html .= ">";
    if ($this -> value)
      $html .= $this -> value;
    $html .= "</textarea>";

    $html .= $close;
    
    return $html;
  }
  // }}}
}

?>