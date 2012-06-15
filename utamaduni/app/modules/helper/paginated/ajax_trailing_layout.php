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

include_once ('page_layout.php');

/**
 * trailing_layout.php
 *
 * This class implements the page_layout interface to shows ajax links.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class ajax_trailing_layout implements page_layout {
  // {{{ fetch_paged_links ($parent, $query_vars)
  /**
   * fetch_paged_links
   *
   * Print the links to go from a page to another one.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function fetch_paged_links ($parent, $action, $query_vars)
  {
    $current_page = $parent -> get_page_number ();
    $total_pages = $parent -> fetch_number_pages ();
    $str = "";

    if ($total_pages >= 1)
      {
	for ($i = 1; $i <= $total_pages; $i++)
	  {
	    if ($current_page == $i)
	      $str .= "Page $i";
	    else
	      $str .= " <a href=\"javascript: {$action}.loadXMLContent ('page={$i}$query_vars');\">Page $i</a>";

	    $str .= $i != $total_pages ? " | " : "";
	  }
      }
    
    return $str;
  }
}

?>