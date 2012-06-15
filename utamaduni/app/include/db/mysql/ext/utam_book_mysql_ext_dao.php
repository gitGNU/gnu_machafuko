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

include_once (dirname (__FILE__) . '/../utam_book_mysql_dao.php');
include_once (dirname (__FILE__) . '/utam_subject_mysql_ext_dao.php');
include_once (dirname (__FILE__) . '/utam_author_mysql_ext_dao.php');

/**
 * Class that operate on table 'utam_book'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_book_mysql_ext_dao extends utam_book_mysql_dao
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
      'SELECT b.id id, b.isbn isbn, b.title title, b.description description, b.cover cover, b.pages pages, p.id publisherid, p.name publishername, f.id formatid, f.name formatname FROM utam_book b, utam_publisher p, utam_format f WHERE b.id = ? and b.publisher = p.id and b.format = f.id';
    $query = new sql_query ($sql);
    $query -> set_number ($id);
    return $this -> get_row ($query);
  }
  
  /**
   * Insert record to table.
   *
   * @param utam_book_mysql utam_book.
   */
  public function insert ($utam_book)
  {
    $sql = 'INSERT INTO utam_book (id, isbn, title, description, cover, pages, publisher, format) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $query = new sql_query ($sql);
    
    $query -> set ($utam_book -> id);
    $query -> set ($utam_book -> isbn);
    $query -> set ($utam_book -> title);
    $query -> set ($utam_book -> description);
    $query -> set ($utam_book -> cover);
    $query -> set ($utam_book -> pages);
    $query -> set ($utam_book -> utam_publisher -> id);
    $query -> set ($utam_book -> utam_format -> id);
    
    $id = $this -> execute_insert ($query);
    $utam_book -> id = $id;

    foreach ($utam_book -> utam_author as $author)
      {
	$sql = 'INSERT INTO utam_book_author (book, author) VALUES (?, ?)';
	$query = new sql_query ($sql);
	$query -> set ($utam_book -> id);
	$query -> set ($author -> id);
	$this -> execute_insert ($query);
      }

    foreach ($utam_book -> utam_subject as $subject)
      {
	$sql = 'INSERT INTO utam_book_subject (book, subject) VALUES (?, ?)';
	$query = new sql_query ($sql);
	$query -> set ($utam_book -> id);
	$query -> set ($subject -> id);
	$this -> execute_insert ($query);
      }

    return $id;
  }

  /**
   * Read row and get all subjects and author book to complete all book information.
   *
   * @return utam_book_mysql
   */
  protected function read_row ($row)
  {
    $utam_book = new utam_book ();
    $subjects_dao = new utam_subject_mysql_ext_dao ();
    $authors_dao = new utam_author_mysql_ext_dao ();
    
    $utam_book -> id = $row['id'];
    $utam_book -> isbn = $row['isbn'];
    $utam_book -> title = $row['title'];
    $utam_book -> description = $row['description'];
    $utam_book -> cover = $row['cover'];
    $utam_book -> pages = $row['pages'];
    $utam_book -> utam_publisher -> id = $row['publisherid'];
    $utam_book -> utam_publisher -> name = $row['publishername'];
    $utam_book -> utam_format -> id = $row['formatid'];
    $utam_book -> utam_format -> name = $row['formatname'];
    $utam_book -> utam_subject = $subjects_dao -> query_subjects_by_book ($utam_book -> id);
    $utam_book -> utam_author = $authors_dao -> query_authors_by_book ($utam_book -> id);    
    
    return $utam_book;
  }
}
?>