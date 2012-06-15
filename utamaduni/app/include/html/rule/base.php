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
 * html_rule_base.php
 *
 * A base class to the rules.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
abstract class html_rule_base
{
  // {{{ properties
  /**
   * $element
   *
   * The element object who have this rule.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $element
   */
  var $element = null;

  /**
   * $msg
   *
   * The message to show if the element do not satisfy the rule.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $msg
   */
  var $msg;

  /**
   * $id
   *
   * The id of the div html tag. It can uses to html render.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $id
   */
  var $id;

  /**
   * $class
   *
   * The class of the div html tag. Ir can uses to html render.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $class
   */
  var $class;
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param object $element
   * @param string $msg
   */
  public function __construct ($element, $msg)
  {
    $this -> element = $element;
    $this -> msg = $msg;
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

  // {{{ validate ()
  /**
   * validate
   *
   * Validate the rule over the element object.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  abstract public function validation ();
  // }}}
}

?>