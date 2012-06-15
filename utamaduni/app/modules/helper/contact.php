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

include_once (UT_BASE_PATH . '/include/db/mysql/ajen_contact_mysql_dao.php');

/**
 * contact.php
 *
 * This module help to fetch contact data from database.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class contact extends core_auth_user
{
  // {{{ __default ()
  /**
   * __default
   *
   * This function will be ran by model if an event (method) is not specified
   * in the request.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __default ()
  {
  }
  // }}}

  // {{{ get_all_contact ()
  /**
   * get_all_contact
   *
   * Return an array on index is a contact id and value the name and surname value.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  static public function get_all_contact ()
  {
    $res = array ();
    $dao = new ajen_contact_mysql_dao ();
    $lcontact = $dao -> query_all ();
    foreach ($lcontact as $c)
      {
	$res[$c -> id] = $c -> name . ' ' . $c -> surname;
      }

    return $res;
  }
  // }}}
}

?>