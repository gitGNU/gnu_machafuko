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
 * html_element_file.php
 *
 * File input element.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_element_file extends html_element_base
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
   * $max_file_size
   *
   * This property (measured in bytes) is the maximum filesize accepted by
   * PHP.
   *
   * By default its value is 102400 bytes = 100 KB.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var integer $max_file_size
   */
  private $max_file_size = 102400;
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

  // {{{ set_max_file_size ($bytes)
  /**
   * set_max_file_size
   *
   * Set maximum file size in bytes.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $bytes the size in bytes
   */
  public function set_max_file_size ($bytes)
  {
    $this -> max_file_size = $bytes;
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
	  " class='" . $contents['class'] . ">";
	$close .= '</' . $contents['tag'] . '>';
      }

    $html .= "<input type='hidden' name='MAX_FILE_SIZE' value='" .
      $this -> max_file_size . "' />";
    $html .= "<input type='file' id='" . $this -> id . "' name='" .
      $this -> name . "' ";
    if ($this -> size)
      $html .= "size='" . $this -> size . "' ";
    $html .= "/>";

    $html .= $close; // Close all containsers.
    
    return $html;
  }
  // }}}
}

?>