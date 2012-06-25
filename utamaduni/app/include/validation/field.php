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
 * field.php
 *
 * Validation field base class.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
abstract class validation_field
{
  // {{{ properties
  /**
   * $fieldname
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $fieldname
   */
  protected $fieldname;

  /**
   * $message
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $message Error message.
   */
  protected $message;

  /**
   * $required
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var boolean $required is this field required.
   */
  private $required;
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * The validator needs the fieldname and the message.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ($fieldname, $message, $required = null)
  {
    $this -> fieldname = $fieldname;
    $this -> message = $message;
    $this -> required = $required;
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
  }
  // }}}

  // {{{ check_required ($field)
  /**
   * check_required
   *
   * This function return true if the field is no required or if is required
   * and have value.
   *
   * @param string $field the field.
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  protected function check_required ($field)
  {
    return (!$this -> required) || ($this -> required && !empty ($field)); 
  }
  // }}}

  // {{{ validation ($coordinator)
  /**
   * validation
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  abstract function validation ($coordinator);
  // }}}
}

?>