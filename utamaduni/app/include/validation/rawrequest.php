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
 * rawrequest.php
 *
 * Raw request object.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class validation_rawrequest
{
  // {{{ properties
  /**
   * $data
   *
   * Data set with raw request values (_GET or _POST raw values).
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var array $data Data set.
   */
  private $data = array ();

  /**
   * $count_post
   *
   * Number of element POST.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var array $count_post
   */
  private $count_post = 0;
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ($data = FALSE)
  {
    $this -> data = $data ? $data : $this -> init_from_http ();
    unset ($_REQUEST);
    unset ($_POST);
    unset ($_GET);
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

  // {{{ init_from_http ()
  /**
   * init_from_http
   *
   * Get $_POST data, or $_GET data whether $_POST is voided.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  private function init_from_http ()
  {
    if (!empty ($_POST))
      {
	$this -> count_post = count ($_POST);
	return $_POST;
      }
    if (!empty ($_GET))
      return $_GET;
    return array ();
  }
  // }}}

  // {{{ get_for_validation ($var)
  /**
   * get_for_validation
   *
   * Get the indexed value for validation.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_for_validation ($var)
  {
    if (!isset ($this -> data[$var]))
      return null;
    return $this -> data[$var];
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
    return $this -> count_post;
  }
  // }}}
}