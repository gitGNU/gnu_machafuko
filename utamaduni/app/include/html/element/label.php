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
 * html_element_label.php
 *
 * Label tag.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_element_label
{
  // {{{ properties
  /**
   * $content
   *
   * The label content
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $content
   */
  var $content = null;

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
   * @param string $content the content of the label.
   * @param string $class the class attribute value.
   */
  public function __construct ($content, $class = null)
  {
    $this -> content = $content;
    $this -> class = $class;
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

    $html .= "<label";
    if ($this -> class)
      $html .= " class='" . $this -> class . "'";
    $html .= ">" . $this -> content . "</label>";

    $html .= $close; // Close all containsers.

    return $html;
  }
  // }}}
}

?>
