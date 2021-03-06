<?php
/*
 Copyright 2011 Román Ginés Martínez Ferrández <romangines@riseup.net>

 This file is part of phpgendao.

 phpgendao is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 phpgendao is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once (dirname (__FILE__) . '/../utam_format_mysql_dao.php');

/**
 * Class that operate on table 'utam_format'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_format_mysql_ext_dao extends utam_format_mysql_dao
{
  /**
   * Insert a format if not exists.
   *
   * This function avoid format name duplications.
   *
   * @param string $format a format name.
   */
  public function insert ($format)
  {
    $res = new utam_format ();
    // The strtolower function do not found with latin character.
    // The solution: use mb_strtolower.
    $name = mb_strtolower ($format, 'UTF-8');

    // If exists the publisher fetch it.
    $lformat = $this -> query_by_name ($name);
    if (!count ($lformat))
      {
	$sql = 'INSERT INTO utam_format (name) VALUES (?)';	
	$query = new sql_query ($sql);
	$query -> set ($name);
	$id = $this -> execute_insert ($query);
      }
    else
      {
	$id = $lformat[0] -> id;
      }

    $res -> id = $id;
    $res -> name = $name;

    return $res;
  }
}
?>