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

include_once (dirname (__FILE__) . '/../ajen_street_mysql_dao.php');

/**
 * Class that operate on table 'ajen_street'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class ajen_street_mysql_ext_dao extends ajen_street_mysql_dao
{
  /**
   * Return a street id if exists or NULL (0) if not exists the street.
   *
   * @param string $name the lowercase name.
   * @param string $num the number.
   * @param string $extra the lowercase extra information of the street.
   */
  public function query_id ($name, $num, $extra)
  {
    $sql = 'SELECT id FROM ajen_street WHERE lower(name)=lower(?) and num=? and lower(extra)=lower(?)';
    $query = new sql_query ($sql);
    $query -> set ($name);
    $query -> set ($num);
    $query -> set ($extra);
    $tab = query_executor::execute ($query);
    if (count ($tab) == 0)
      return null;
    else
      return $tab[0]['id'];
  }

  /**
   * Insert a new street if does not exists street with name, number and
   * extra information.
   *
   * @param string $name the name of the street.
   * @param string $num the number of the street.
   * @param string $extra the extra information of the street.
   * @return integer the street id inserted or existed.
   */
  public function insert_street ($name, $num, $extra)
  {
    $streetid = $this -> query_id ($name, $num, $extra);
    if (!$streetid)
      {
	$sql = 'INSERT INTO ajen_street (name, num, extra) VALUES (?, ?, ?)';
	$query = new sql_query ($sql);
	$query -> set ($name);
	$query -> set ($num);
	$query -> set ($extra);
	$streetid = $this -> execute_insert ($query);
      }

    return $streetid;
  }
}
?>