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
 * util.php
 *
 * This is a class with utilities to manage dates.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class date_util
{
  // {{{ is_empty ()
  /**
   * is_empty
   *
   * Check if the $date is empty.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  static public function is_empty ($date)
  {
    if ($date != null)
      {
	if (is_string ($date))
	  {
	    // The dates in the form: 00-00-0000, 00/00/0000, 0000-00-00 or 0000/00/00
	    // are empty dates.
	    $rep = array ('-', '/', '0');
	    $aux = str_replace ($rep, '', $date);
	    if (strlen ($aux) > 0)
	      return false;
	  }
      }

    return true;
  }
  // }}}

  // {{{ to_mysql_date ($date)
  /**
   * to_mysql_date
   *
   * This method change format date from dd/mm/yyyy to yyyy-mm-dd. If input data has not
   * dd/mm/yyyy format its returns the input data without changes.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  static public function to_mysql_date ($date)
  {
    $match_res = array ();
    $res_date = $date;

    if (preg_match ("/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2,4})/", $date, $match_res))
      $res_date = $match_res[3] . '-' . $match_res[2] . '-' . $match_res[1];

    return $res_date;
  }
  // }}}

  // {{{ to_php_date ($date)
  /**
   * to_mysql_date
   *
   * This method change format date from yyyy-mm-dd to dd/mm/yyyy. If input data has not
   * yyyy-mm-dd format its returns the input data without changes.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  static public function to_php_date ($date)
  {
    $match_res = array ();
    $res_date = $date;

    if (preg_match ("/([0-9]{2,4})\-([0-9]{1,2})\-([0-9]{1,2})/", $date, $match_res))
      $res_date = $match_res[3] . '-' . $match_res[2] . '-' . $match_res[1];

    return $res_date;
  }
  // }}}
}
?>
