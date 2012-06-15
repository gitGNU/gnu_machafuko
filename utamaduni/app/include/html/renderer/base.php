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
abstract class html_renderer_base
{
  // {{{ properties
  /**
   * $form
   *
   * The form object.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var mixed $form the form object.
   */
  protected $form = null;
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
    $this -> form = $form;
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

  // {{{ render ()
  /**
   * render
   *
   * Abstract method.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  abstract public function render ();
  // }}}
}

?>