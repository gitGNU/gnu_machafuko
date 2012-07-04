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

include_once (dirname(__FILE__) . '/../utam_bookshop_mysql_dao.php');

/**
 * Class that operate on table 'utam_bookshop'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_bookshop_mysql_ext_dao extends utam_bookshop_mysql_dao
{
  /**
   * Update record in table.
   *
   * @param utam_bookshop_mysql utam_bookshop
   */
  public function update ($utam_bookshop)
  {
    $sql = 'UPDATE utam_bookshop SET id = ?, name = ?';
    if (!empty ($utam_bookshop -> logo))
      $sql .= ', logo = ?';
    $sql .= ' WHERE id = ?';

    $query = new sql_query ($sql);
    
    $query -> set ($utam_bookshop -> id);
    $query -> set ($utam_bookshop -> name);
    if (!empty ($utam_bookshop -> logo))
      $query -> set ($utam_bookshop -> logo);
    $query -> set_number ($utam_bookshop -> id);

    return $this -> execute_update ($query);
  }
}
?>