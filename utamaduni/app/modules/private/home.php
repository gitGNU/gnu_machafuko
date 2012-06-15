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
 * home.php
 *
 * This module show the private home web page.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class home extends core_auth_user
{
  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ()
  {
    parent::__construct ();
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
    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_read_mysql_ext_dao.php');
    $all_books = array ();
    $reading_books = array ();
    include_once (UT_BASE_PATH . '/modules/helper/menu.php');
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $menu = new menu ();
    $private_menu = new privatemenu ();
    
    // Executes the booksreading module.
    include_once (UT_BASE_PATH . '/modules/helper/mcaller.php');
    $books_reading = mcaller::call_module ('private', '__default', 'booksreading');

    // Sets all datas.
    $this -> set ('menu', $menu -> get_menu ('login'));
    $this -> set ('private_menu', $private_menu -> get_menu ('home'));
    $this -> set ('welcome', gettext ('Welcome to your personal site') . '.');
    $this -> set ('books_reading', $books_reading);
  }
  // }}}
}

?>