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

include_once (dirname (__FILE__) . '/../utam_author_mysql_dao.php');

/**
 * Class that operate on table 'utam_author'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_author_mysql_ext_dao extends utam_author_mysql_dao
{
  /**
   * Get the author information through the book identifier.
   *
   * @param string $idbook identifier book.
   */
  public function query_authors_by_book ($idbook)
  {
    $sql = 'SELECT a.id id, a.name name, a.surname surname, a.photo photo FROM utam_book_author ba, utam_author a WHERE ba.book = ? and ba.author = a.id';
    $query = new sql_query ($sql);
    $query -> set ($idbook);
    return $this -> get_list ($query);
  }
}
?>