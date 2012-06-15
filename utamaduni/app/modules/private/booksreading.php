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
 * booksreading.php
 *
 * This module show the books it is reading.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class booksreading extends core_auth_user
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
    $books_reading = array ();
    $rb_paginated = array ();
    $page_navigation = '';

    // Get all books read.
    $dao = new utam_read_mysql_ext_dao ();
    $book_list = $dao -> query_all_books_reading ();

    if (is_array ($book_list))
      {
	if (count ($book_list) > 0)
	  {
	    foreach ($book_list as $book)
	      {
		$books_reading[] = array ('href' => $book -> utam_book -> cover,
					  'imgid' => 'mini',
					  'imgsrc' => $book -> utam_book -> cover,
					  'book_title' => $book -> utam_book -> title);
	      }

	    // Paginated.
	    include_once (UT_BASE_PATH . '/modules/helper/paginated/paginated.php');
	    include_once (UT_BASE_PATH . '/modules/helper/paginated/ajax_trailing_layout.php');
	    $page = 1;
	    $page_validator = new validation_digit_field ('page',
					gettext ('The page must consist of numbers only'));
	    $val_facade = new validation_facade ();
	    $val_facade -> add_validator ($page_validator);
	    if ($val_facade -> validation ())
	      {
		$clean = $val_facade -> get_clean_request ();
		$page = $clean -> get ('page');
	      }
	    $page_results = new paginated ($books_reading, 6, $page);
	    while ($row = $page_results -> fetch_paged_row ()) 
	      {
		$rb_paginated[] = $row;
	      }
	    $page_results -> set_layout (new ajax_trailing_layout ());
	    $page_navigation = $page_results -> fetch_paged_navigation ('booksreadingloader');
	  }
      }

    $this -> set ('books_reading', $rb_paginated);
    $this -> set ('page_navigation', $page_navigation);
    if (count ($books_reading))
      $this -> set ('msg', gettext ("Books you are reading:"));
    else
      $this -> set ('msg', gettext ("You are not reading any book."));
  }
  // }}}
}

?>