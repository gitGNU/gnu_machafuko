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
include_once (dirname (__FILE__) . '/utam_subject_mysql_ext_dao.php');
include_once (dirname (__FILE__) . '/utam_author_mysql_ext_dao.php');

/**
 * Class that operate on table 'utam_purchased'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_purchased_mysql_ext_dao extends utam_purchased_mysql_dao
{
  /**
   * Load all information relates with purchased book.
   */
  public function load ($id)
  {
    /*
    $sql = 'SELECT ' .
      'p.id id, p.isbn isbn, p.price price, ' .
      'r.start start, r.finish finish, r.opinion opinion, r.valoration valoration, ' .
      'b.title title, b.description description, b.cover cover, b.pages pages, ' .
      'f.id formatid, f.name formatname, ' .
      'pu.id publisherid, pu.name publishername, ' .
      'bs.id bsid, bs.name bsname, bs.logo bslogo ' .
      'FROM ' .
      'utam_purchased p, utam_read r, utam_book b, utam_format f, utam_publisher pu, utam_bookshop bs ' .
      'WHERE ' .
      'p.id=? and p.id=r.id and r.id=b.id and b.format=f.id and b.publisher=pu.id and p.bookshop=bs.id';
    */
    $sql = 'SELECT ' .
      'p.id id, p.isbn isbn, p.price price, ' .
      'r.start start, r.finish finish, r.opinion opinion, r.valoration valoration, ' .
      'b.title title, b.description description, b.cover cover, b.pages pages, ' .
      'f.id formatid, f.name formatname, ' .
      'pu.id publisherid, pu.name publishername, ' .
      'bs.id bsid, bs.name bsname, bs.logo bslogo ' .
      'FROM utam_purchased p ' .
      'RIGHT OUTER JOIN utam_read r ON p.id = r.id ' .
      'RIGHT OUTER JOIN utam_book b ON r.id = b.id ' .
      'LEFT OUTER JOIN utam_format f ON b.format = f.id ' .
      'LEFT OUTER JOIN utam_publisher pu ON b.publisher = pu.id ' .
      'LEFT OUTER JOIN utam_bookshop bs ON p.bookshop = bs.id ' .
      'WHERE p.id = ?';
    $query = new sql_query ($sql);
    $query -> set ($id);
    return $this -> get_row ($query);
  }

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
    $utam_purchased -> utam_read -> utam_book = new utam_book ();
    $utam_purchased -> utam_read -> utam_book -> utam_format = new utam_format ();
    $utam_purchased -> utam_read -> utam_book -> utam_publisher = new utam_publisher ();
    $utam_purchased -> utam_bookshop = new utam_bookshop ();
    $subjects_dao = new utam_subject_mysql_ext_dao ();
    $authors_dao = new utam_author_mysql_ext_dao ();
    
    $utam_purchased -> id = $row['id'];
    $utam_purchased -> isbn = $row['isbn'];
    $utam_purchased -> price = $row['price'];

    $utam_purchased -> utam_read -> id = $row['id'];
    $utam_purchased -> utam_read -> isbn = $row['isbn'];
    $utam_purchased -> utam_read -> start = $row['start'];
    $utam_purchased -> utam_read -> finish = $row['finish'];
    $utam_purchased -> utam_read -> opinion = $row['opinion'];
    $utam_purchased -> utam_read -> valoration = $row['valoration'];

    $utam_purchased -> utam_read -> utam_book -> id = $row['id'];
    $utam_purchased -> utam_read -> utam_book -> isbn = $row['isbn'];
    $utam_purchased -> utam_read -> utam_book -> title = $row['title'];
    $utam_purchased -> utam_read -> utam_book -> description = $row['description'];
    $utam_purchased -> utam_read -> utam_book -> cover = $row['cover'];
    $utam_purchased -> utam_read -> utam_book -> pages = $row['pages'];
    $utam_purchased -> utam_read -> utam_book -> utam_format -> id = $row['formatid'];
    $utam_purchased -> utam_read -> utam_book -> utam_format -> name = $row['formatname'];
    $utam_purchased -> utam_read -> utam_book -> utam_publisher -> id = $row['publisherid'];
    $utam_purchased -> utam_read -> utam_book -> utam_publisher -> name = 
      $row['publishername'];
    $utam_purchased -> utam_read -> utam_book -> utam_subject =
      $subjects_dao -> query_subjects_by_book ($row['id']);
    $utam_purchased -> utam_read -> utam_book -> utam_author =
      $authors_dao -> query_authors_by_book ($row['id']);

    $utam_purchased -> utam_bookshop -> id = $row['bsid'];
    $utam_purchased -> utam_bookshop -> name = $row['bsname'];
    $utam_purchased -> utam_bookshop -> logo = $row['bslogo'];
    
    return $utam_purchased;
  }
}
?>