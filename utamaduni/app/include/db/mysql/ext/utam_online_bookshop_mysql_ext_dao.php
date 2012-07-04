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

include_once (dirname (__FILE__) . '/../utam_online_bookshop_mysql_dao.php');

/**
 * Class that operate on table 'utam_online_bookshop'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_online_bookshop_mysql_ext_dao extends utam_online_bookshop_mysql_dao
{
  /**
   * Update record in table or insert it if not exists.
   *
   * @param utam_online_bookshop_mysql utam_online_bookshop
   */
  public function update ($utam_online_bookshop)
  {
    $list = $this -> query_by_id ($utam_online_bookshop -> id);
    if (!empty ($list))
      {
	$sql = 'UPDATE utam_online_bookshop SET id = ?, url = ? WHERE id = ?';
	$query = new sql_query ($sql);
	
	$query -> set ($utam_online_bookshop -> id);
	$query -> set ($utam_online_bookshop -> url);
	
	$query -> set_number ($utam_online_bookshop -> id);
	return $this -> execute_update ($query);
      }
    else
      return $this -> insert ($utam_online_bookshop);
  }
}
?>