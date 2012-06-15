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

include_once (dirname (__FILE__) . '/../utam_subject_mysql_dao.php');

/**
 * Class that operate on table 'utam_subject'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_subject_mysql_ext_dao extends utam_subject_mysql_dao
{
  /**
   * Get the subject information through the book identifier.
   *
   * @param string $idbook identifier book.
   */
  public function query_subjects_by_book ($idbook)
  {
    $sql = 'SELECT s.id id, s.name name FROM utam_book_subject sb, utam_subject s WHERE sb.book = ? and sb.subject = s.id';
    $query = new sql_query ($sql);
    $query -> set ($idbook);
    return $this -> get_list ($query);
  }

  /**
   * Insert a serie of subjects and returns a utam_subject array.
   *
   * This function avoid subject name duplications.
   *
   * @param string $tags a list of subjects splitted by ','.
   */
  public function insert ($tags)
  {
    $res = array ();
    $subjects = preg_split ("/[\s]*[,][\s]*/", $tags);

    foreach ($subjects as $sub)
      {
	// If exists the subject fetch it.
	$lsubject = $this -> query_by_name ($sub);
	if (!count ($lsubject))
	  {
	    $sql = 'INSERT INTO utam_subject (name) VALUES (?)';
	    
	    $query = new sql_query ($sql);
	    // The strtolower function do not found with latin character.
	    // The solution: use mb_strtolower.
	    $query -> set (mb_strtolower($sub, 'UTF-8'));
	    $id = $this -> execute_insert ($query);
	  }
	else
	  {
	    $id = $lsubject[0] -> id;
	    $sub = $lsubject[0] -> name;
	  }

	$utam_subject = new utam_subject ();
	$utam_subject -> id = $id;
	$utam_subject -> name = $sub;
	$res[] = $utam_subject;
      }

    return $res;
  }
}
?>