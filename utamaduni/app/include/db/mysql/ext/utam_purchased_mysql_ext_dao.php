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

include_once (dirname (__FILE__) . '/../utam_purchased_mysql_dao.php');

/**
 * Class that operate on table 'utam_purchased'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_purchased_mysql_ext_dao extends utam_purchased_mysql_dao
{
  /**
   * Insert a purchased book (that is a read book) and read book 
   * information.
   */
  public function insert ($utam_purchased)
  {
    if (!empty ($utam_purchased -> utam_bookshop -> id))
      $sql = 'INSERT INTO utam_purchased (id, isbn, price, bookshop) VALUES (?, ?, ?, ?)';
    else
      $sql = 'INSERT INTO utam_purchased (id, isbn, price) VALUES (?, ?, ?)';
    $query = new sql_query ($sql);

    $query -> set ($utam_purchased -> id);
    $query -> set ($utam_purchased -> isbn);
    $query -> set ($utam_purchased -> price);
    if (!empty ($utam_purchased -> utam_bookshop -> id))
      $query -> set ($utam_purchased -> utam_bookshop -> id);

    $id = $this -> execute_insert ($query);
    $utam_purchased -> id = $id;

    return $id;
  }

  /**
   * Read row.
   *
   * @return utam_purchased_mysql
   */
  protected function read_row ($row)
  {
    $utam_purchased = new utam_purchased ();
    $utam_purchased -> utam_read = new utam_read ();
    $utam_purchased -> utam_bookshop = new utam_bookshop ();
    
    $utam_purchased -> id = $row['id'];
    $utam_purchased -> isbn = $row['isbn'];
    $utam_purchased -> price = $row['price'];

    $utam_purchased -> utam_read -> id = $row['id'];
    $utam_purchased -> utam_read -> isbn = $row['isbn'];
    $utam_purchased -> utam_read -> start = $row['start'];
    $utam_purchased -> utam_read -> finish = $row['finish'];
    $utam_purchased -> utam_read -> opinion = $row['opinion'];
    $utam_purchased -> utam_read -> valoration = $row['valoration'];

    $utam_purchased -> utam_bookshop -> id = $row['bsid'];
    $utam_purchased -> utam_bookshop -> name = $row['bsname'];
    $utam_purchased -> utam_bookshop -> logo = $row['bslogo'];
    
    return $utam_purchased;
  }
}
?>