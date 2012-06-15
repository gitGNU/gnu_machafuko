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
 * html_renderer.php
 *
 * Factory of renderers.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class html_renderer
{
  // {{{ factory ($type, $form)
  /**
   * factory
   *
   * It creates renderers.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $type kind of renderer (html, latex, etc).
   * @param mixed $form the form object.
   */
  static public function factory ($type, $form)
  {
    $file = 'renderer/' . $type . '.php';
    if (include_once ($file))
      {
	$class = 'html_renderer_' . $type;
	if (class_exists ($class))
	  {
	    $renderer = new $class ($form);
	    if ($renderer instanceof html_renderer_base)
	      {
		return $renderer;
	      }
	    else
	      {
		throw new Exception ('Invalid renderer: ' . $type . '.');
	      }
	  }
	else
	  {
	    throw new Exception ('Renderer class not found: ' . $class . '.');
	  }
      }
    else
      {
	throw new Exception ('Renderer file not found: ' . $file . '.');
      }
  }
  // }}}
}

?>