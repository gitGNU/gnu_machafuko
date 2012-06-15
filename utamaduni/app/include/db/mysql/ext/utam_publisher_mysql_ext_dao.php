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

include_once (dirname (__FILE__) . '/../utam_publisher_mysql_dao.php');

/**
 * Class that operate on table 'utam_publisher'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_publisher_mysql_ext_dao extends utam_publisher_mysql_dao
{
  /**
   * Insert a publisher if not exists.
   *
   * This function avoid publisher name duplications.
   *
   * @param string $publisher a publisher name.
   */
  public function insert ($publisher)
  {
    $res = new utam_publisher ();
    // The strtolower function do not found with latin character.
    // The solution: use mb_strtolower.
    $name = mb_strtolower ($publisher, 'UTF-8');

    // If exists the publisher fetch it.
    $lpublisher = $this -> query_by_name ($name);
    if (!count ($lpublisher))
      {
	$sql = 'INSERT INTO utam_publisher (name) VALUES (?)';	
	$query = new sql_query ($sql);
	$query -> set ($name);
	$id = $this -> execute_insert ($query);
      }
    else
      {
	$id = $lpublisher[0] -> id;
      }

    $res -> id = $id;
    $res -> name = $name;

    return $res;
  }
}
?>