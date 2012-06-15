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
 * base.php
 *
 * Presenter base. All presenters (views) will extend from this class. If
 * they do not then core_presenter::factory () will throw an exception.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
abstract class core_presenter_base extends core_object_web
{
  // {{{ properties
  /**
   * $module
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var core_module $module
   */
  protected $module;
  // }}}

  // {{{ __construct (core_module $module)
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct (core_module $module)
  {
    parent::__construct ();
    $this -> module = $module;
  }
  // }}}

  // {{{ __desctruct ()
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
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  abstract public function render ();
  // }}}
}

?>