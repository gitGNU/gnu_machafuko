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
 
include_once (dirname (__FILE__) . '/../utam_read_mysql_dao.php');

/**
 * Class that operate on table 'utam_read'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_read_mysql_ext_dao extends utam_read_mysql_dao
{
  /**
   * This function return a list of all books.
   *
   * @return An array of reading books (it can be null).
   */
  function query_all ()
  {
    $sql = 'SELECT b.id id, b.isbn isbn, b.title title, b.description description, b.cover cover, r.start start, r.finish finish, r.opinion opinion, r.valoration valoration ' .
      'FROM utam_book b, utam_read r ' .
      'WHERE b.id = r.id';
    $query = new sql_query ($sql);
    return $this -> get_list ($query);
  }

  /**
   * This function return a list of reading books. A book is reading
   * if has start date and has not finish date.
   *
   * @return An array of reading books (it can be null).
   */
  function query_all_books_reading ()
  {
    $sql = 'SELECT b.id id, b.isbn isbn, b.title title, b.description description, b.cover cover, r.start start, r.finish finish, r.opinion opinion, r.valoration valoration ' .
      'FROM utam_book b, utam_read r ' .
      'WHERE b.id = r.id AND r.start <> "0000-00-00" AND r.start IS NOT NULL AND ' .
      '(r.finish = "0000-00-00" OR r.finish IS NULL)';
    $query = new sql_query ($sql);
    return $this -> get_list ($query);
  }
  
  /**
   * Read row.
   *
   * @return utam_read_mysql
   */
  protected function read_row ($row)
  {
    $utam_read = new utam_read ();
    $utam_read -> utam_book = new utam_book ();
    
    $utam_read -> id = $row['id'];
    $utam_read -> isbn = $row['isbn'];
    $utam_read -> start = $row['start'];
    $utam_read -> finish = $row['finish'];
    $utam_read -> opinion = $row['opinion'];
    $utam_read -> valoration = $row['valoration'];
    $utam_read -> utam_book -> id = $row['id'];
    $utam_read -> utam_book -> isbn = $row['isbn'];
    $utam_read -> utam_book -> title = $row['title'];
    $utam_read -> utam_book -> description = $row['description'];
    $utam_read -> utam_book -> cover = $row['cover'];
    
    return $utam_read;
  }
}
?>