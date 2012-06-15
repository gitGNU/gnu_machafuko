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

require_once ('page_layout.php');

/**
 * paginated.php
 *
 * This class is the base to manage the iteration of records based on a
 * specified page number.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class paginated
{
  // {{{ Properties
  /**
   * $rs
   *
   * The result set.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param mixed $rs the result set.
   */
  private $rs;

  /**
   * $page_size
   *
   * Number of records to display.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $page_size number of records to display.
   */
  private $page_size;

  /**
   * $page_number
   *
   * Page to be displayed.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $page_number page to be displayed.
   */
  private $page_number;

  /**
   * $row_number
   *
   * The current row of data which must be less than the page_size in keeping 
   * with the specified size.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $row_number the current row of data.
   */
  private $row_number;

  /**
   * $offset
   *
   * The array offset to control the iteration.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $offset the array of data offset.
   */
  private $offset;

  /**
   * $layout
   *
   * The layout object which will be used.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param object $layout the layout which will be used.
   */
  private $layout;
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  function __construct ($obj, $display_rows = 10, $page_num = 1)
  {
    $this -> set_rs ($obj);
    $this -> set_page_size ($display_rows);
    $this -> assign_page_number ($page_num);
    $this -> set_row_number (0);
    $this -> set_offset (($this -> get_page_number () - 1) * ($this -> get_page_size ()));
  }

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

  // {{{ getters and setters.
  public function set_offset ($offset)
  {
    $this -> offset = $offset;
  }

  public function get_offset ()
  {
    return $this -> offset;
  }


  public function get_rs ()
  {
    return $this -> rs;
  }

  public function set_rs ($obj)
  {
    $this -> rs = $obj;
  }

  public function get_page_size ()
  {
    return $this -> page_size;
  }

  public function set_page_size ($pages)
  {
    $this -> page_size = $pages;
  }

  public function get_page_number ()
  {
    return $this -> page_number;
  }

  public function set_page_number ($number)
  {
    $this -> page_number = $number;
  }

  public function get_row_number ()
  {
    return $this -> row_number;
  }

  public function set_row_number ($number)
  {
    $this -> row_number = $number;
  }

  public function get_layout ()
  {
    return $this -> layout;
  }

  public function set_layout(page_layout $layout)
  {
    $this -> layout = $layout;
  }
  // }}}

  // {{{ fetch_number_pages ()
  /**
   * fetch_number_pages
   *
   * Return the number of the pages which are need to show all data into 
   * the record set. Or false if there is not data into the record set.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function fetch_number_pages ()
  {
    if (!$this -> get_rs ())
      {
	return false;
      }
    
    $pages = ceil (count ($this -> get_rs ()) / (float)$this -> get_page_size ());
    return $pages;
  }
  // }}}

  // {{{ assign_page_number ($page)
  /**
   * assign_page_number
   *
   * Upon assigning the current page, move the cursor in the result set to (page number 
   * minus one) multiply by the page size, example  (2 - 1) * 10
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param integer $page
   */
  public function assign_page_number ($page)
  {
    if (($page <= 0) || ($page > $this -> fetch_number_pages ()) || ($page == ""))
      {
	$this -> set_page_number (1);
      }
    else
      {
	$this -> set_page_number ($page);
      }
  }
  // }}}

  // {{{ fetch_paged_row ()
  /**
   * fetch_paged_row
   *
   * Get the next item which is into the record set array.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function fetch_paged_row ()
  {
    $idx = $this -> get_offset ();

    if ((!$this -> get_rs ()) || ($this -> get_row_number () >= $this -> get_page_size ()) ||
	($idx >= count ($this -> get_rs ())))
      {
	return false;
      }

    $this -> set_row_number ($this -> get_row_number() + 1);
    $this -> set_offset ($this -> get_offset () + 1);

    return $this -> rs[$idx];
  }
  // }}}

  // {{{ is_first_page ()
  /**
   * is_first_page
   *
   * Return true if it is a first page.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function is_first_page ()
  {
    return ($this -> get_page_number () <= 1);
  }
  // }}}

  // {{{ is_last_page ()
  /**
   * is_last_page
   *
   * Return true if it is a last page.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function is_last_page ()
  {
    return ($this -> get_page_number () >= $this -> fetch_number_pages ());
  }
  // }}}

  // {{{ fetch_paged_navigation ($query_vars)
  /**
   * fetch_paged_navigation
   *
   * returns a string with the base navigation for the page
   * if queryVars are to be added then the first parameter should be preceeded by a ampersand
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function fetch_paged_navigation ($action, $query_vars = "")
  {
    return $this -> get_layout () -> fetch_paged_links ($this, $action, $query_vars);
  }
  // }}}
}

?>