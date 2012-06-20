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

include_once (dirname (__FILE__) . '/../utam_bookshop_mysql_dao.php');

/**
 * Class that operate on table 'utam_bookshop'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_bookshop_mysql_ext_dao extends utam_book_mysqlshop_dao
{
  /**
   * Get domain object by primary key.
   *
   * @param String $id primary key.
   * @return utam_book_mysql.
   */
  public function load ($id)
  {
    $sql = 
      'SELECT bs.id id, bs.name name, bs.logo logo, a.id idaddress, a.city city, a.country country, s.id idstreet, s.name namestreet, s.num numstreet, s.extra extrastreet  FROM utam_bookshop bs, ajen_address a, ajen_street s WHERE bs.id = ? and bs.address = a.id and a.street = s.id';
    $query = new sql_query ($sql);
    $query -> set_number ($id);
    return $this -> get_row ($query);
  }

  /**
   * Read row and get all subjects and author book to complete all book information.
   *
   * @return utam_book_mysql
   */
  protected function read_row ($row)
  {
    $utam_bs = new utam_bookshop ();
    $utam_bs -> ajen_address = new ajen_address ();
    $utam_bs -> ajen_address -> ajen_street = new ajen_street ();
    
    $utam_bs -> id = $row['id'];
    $utam_bs -> name = $row['name'];
    $utam_bs -> logo = $row['logo'];
    $utam_bs -> ajen_address -> id = $row['idaddress'];
    $utam_bs -> ajen_address -> street = $row['street'];
    $utam_bs -> ajen_address -> city = $row['city'];
    $utam_bs -> ajen_address -> country = $row['country'];
    $utam_bs -> ajen_address -> ajen_street -> id = $row['idstreet'];
    $utam_bs -> ajen_address -> ajen_street -> name = $row['namestreet'];
    $utam_bs -> ajen_address -> ajen_street -> num = $row['numstreet'];
    $utam_bs -> ajen_address -> ajen_street -> extra = $row['extrastreet'];
    
    return $utam_bs;
  }
}
?>