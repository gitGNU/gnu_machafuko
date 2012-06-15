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
 * coordinator.php
 *
 * Raw and clean request objects wrapper. This wrapper get raw request
 * values, add errors, management the validate values, etc.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class validation_coordinator
{
  // {{{ properties
  /**
   * $raw
   *
   * Raw request object.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var object $raw
   */
  private $raw;

  /**
   * $clean
   *
   * Cleaned request object.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var object $clean
   */
  private $clean;

  /**
   * $errors
   *
   * Array with errors description
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var array $errors
   */
  private $errors = array ();
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * Construct with both request objects.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ($raw, $clean)
  {
    $this -> raw = $raw;
    $this -> clean = $clean;
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

  // {{{ get ($name)
  /**
   * get
   *
   * Get value for raw request.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get ($name)
  {
    return $this -> raw -> get_for_validation ($name);
  }
  // }}}

  // {{{ set_clean ($name)
  /**
   * set_clean
   *
   * Copy validated value to clean request.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function set_clean ($name)
  {
    if (!$name)
      return FALSE;
    $this -> clean = $this -> clean -> set ($name,
					    $this -> raw -> get_for_validation ($name));
  }
  // }}}

  // {{{ add_error ($error)
  /**
   * add_error
   *
   * Add message on failure.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function add_error ($error)
  {
    $this -> errors[] = $error;
  }
  // }}}

  // {{{ get_errors ()
  /**
   * get_errors
   *
   * Get the error messages.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_errors ()
  {
    return $this -> errors;
  }
  // }}}

  // {{{ get_clean_request ()
  /**
   * get_clean_request
   *
   * Get the clean request object (result).
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_clean_request ()
  {
    return $this -> clean;
  }
  // }}}

  // {{{ get_count_post
  /**
   * get_count_post
   *
   * Return the POST array number of elements.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_count_post ()
  {
    return $this -> raw -> get_count_post ();
  }
  // }}}
}

?>