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
 * facade.php
 *
 * This class provide a unified interface to a set of interfaces in a
 * subsystem.
 *
 * The facade will act as the visible validation component in the 
 * application.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class validation_facade
{
  // {{{
  /**
   * $coordinator
   *
   * Validation coordinator.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var object $coordinator Validation coordinator.
   */
  private $coordinator;

  /**
   * validators
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var array $validators Array of validators.
   */
  private $validators = array ();

  /**
   * $has_validate
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var boolean $has_validated
   */
  private $has_validated = FALSE;
  // }}}

  // {{{ add_validator ($validator)
  /**
   * add_validator
   *
   * Add validator to validate values.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function add_validator ($validator)
  {
    $this -> validators[] = $validator;
  }
  // }}}

  // {{{ validation ($request = FALSE)
  /**
   * validation
   *
   * Create the coordinator and run the validators.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function validation ($request = FALSE)
  {
    $this -> coordinator = $this -> create_coordinator (new validation_rawrequest ($request),
							new validation_cleanrequest ());
    foreach ($this -> validators as $validator)
      {
	$validator -> validation ($this -> coordinator);
      }

    $this -> has_validated = TRUE;
    return $this -> is_valid ();
  }
  // }}}

  // {{{ is_valid ()
  /**
   * is_valid
   *
   * Returns TRUE if no errors.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function is_valid ()
  {
    if (!$this -> has_validated)
      return FALSE;
    return count ($this -> coordinator -> get_errors ()) == 0;
  }
  // }}}

  // {{{ create_coordinator ($raw, $clean)
  /**
   * create_coordinator
   *
   * Separate create method for testing.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function create_coordinator ($raw, $clean)
  {
    return new validation_coordinator ($raw, $clean);
  }
  // }}}

  // {{{ get_clean_request ()
  /**
   * get_clean_request
   *
   * Get the results.
   *
   * The clean request is only available on success.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_clean_request ()
  {
    /*if (!$this -> is_valid ())
     return FALSE;*/
    return $this -> coordinator -> get_clean_request ();
  }
  // }}}

  // {{{ get_errors ()
  /**
   * get_errors
   *
   * Get the error messages.
   *
   * The clean request is only available on success.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_errors ()
  {
    return $this -> coordinator -> get_errors ();
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
    return $this -> coordinator -> get_count_post ();
  }
  // }}}
}

?>