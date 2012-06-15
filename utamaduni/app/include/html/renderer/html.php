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
 * html_renderer_base.php
 *
 * A base class to the renderers.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_renderer_html extends html_renderer_base
{
  // {{{ properties
  // }}}

  // {{{ __construct ($forn)
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param mixed $form the form object.
   */
  public function __construct ($form)
  {
    parent::__construct ($form);
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
    parent::__destruct ();
  }
  // }}}

  // {{{ render ()
  /**
   * render
   *
   * Render the form. Each field is in a separate line and all buttons are in the 
   * same line.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function render ()
  {
    $iframe = '';
    $fields = '';
    $buttons = "<div>";
    $form = $this -> form;

    // Open the form tag.
    $html = "<form id='" . $form -> id . "' name='" .
      $form -> name . "' class='" . $form -> class . "' method='" .
      $form -> method . "' action='" . $form -> action . "' ";

    if ($form -> target)
      {
	$html .= "target='" . $form -> target . "' ";
	$iframe = "<div><iframe name='" . $form -> target .
	  "' frameborder='0' width='100%'></iframe></div>";
      }
    if ($form -> enctype)
      $html .= "enctype='" . $form -> enctype . "' "; 

    $html .= "/>";

    $html .= "<fieldset>";

    // For each form element.
    foreach ($form -> elements as $element)
      {
	if ($element instanceof html_element_button)
	  $buttons .= $element -> to_html ();
	else
	  $fields .= $element -> label -> to_html () . $element -> to_html ();

	// If there is rule for this element show the message.
	if (array_key_exists ($element -> id, $form -> rules))
	  {
	    $fields .= "<div id='" . $form -> rules[$element -> id] -> id . "' class='" .
	      $form -> rules[$element -> id] -> class . "'>" . 
	      $form -> rules[$element -> id] -> msg . "</div>";
	  }

	// The divs below this element.
	foreach ($element -> divs as $contents)
	  {
	    $fields .= "<div id='" . $contents['id'] . "' class='" . $contents['class'] . 
	      "'>" . $contents['content'] . "</div>";
	  }
      }

    // Join fields and buttons.
    $buttons .= "</div>";
    $html .= $fields . $buttons . $iframe;

    $html .= "</fieldset>";

    // Close the form tag.
    $html .= "</form>";

    return $html;
  }
  // }}}
}

?>
