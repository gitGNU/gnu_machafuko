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

include_once (dirname (__FILE__) . '/../utam_addr_bookshop_mysql_dao.php');

/**
 * Class that operate on table 'utam_addr_bookshop'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_addr_bookshop_mysql_ext_dao extends utam_addr_bookshop_mysql_dao
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
      'SELECT ab.id id, bs.name name, bs.logo logo, s.id streetid, s.name streetname, s.num streetnum, s.extra streetextra, a.id addressid, a.city city, a.country country ' .
      'FROM utam_addr_bookshop ab ' .
      'LEFT OUTER JOIN utam_bookshop bs ON ab.id = bs.id ' .
      'LEFT OUTER JOIN ajen_address a ON ab.address=a.id ' .
      'LEFT OUTER JOIN ajen_street s ON a.street=s.id ' .
      'WHERE ab.id=?';
    $query = new sql_query ($sql);
    $query -> set_number ($id);
    return $this -> get_row ($query);
  }

  /**
   * Update record in table or insert it if not exists.
   *
   * @param utam_addr_bookshop_mysql utam_addr_bookshop
   */
  public function update ($utam_addr_bookshop)
  {
    // It updates if exists this addres bookshop.
    $list = $this -> load ($utam_addr_bookshop -> id);
    if (!empty ($list))
      {
	$sql = 'UPDATE utam_addr_bookshop SET id = ?, address = ? WHERE id = ?';
	$query = new sql_query ($sql);
	
	$query -> set ($utam_addr_bookshop -> id);
	$query -> set ($utam_addr_bookshop -> address);
	
	$query -> set_number ($utam_addr_bookshop -> id);
	return $this -> execute_update ($query);
      }
    else
      return $this -> insert ($utam_addr_bookshop);
  }

  /**
   * Read row and get all address and streets to complete all address bookshop information.
   *
   * @return utam_book_mysql
   */
  protected function read_row ($row)
  {
    $utam_addr_bookshop = new utam_addr_bookshop ();
    $utam_bookshop = new utam_bookshop ();
    $ajen_address = new ajen_address ();
    $ajen_street = new ajen_street ();
    
    $utam_addr_bookshop -> id = $row['id'];
    $utam_bookshop -> id = $row['id'];
    $utam_bookshop -> name = $row['name'];
    $utam_bookshop -> logo = $row['logo'];
    $ajen_street -> id = $row['streetid'];
    $ajen_street -> name = $row['streetname'];
    $ajen_street -> num = $row['streetnum'];
    $ajen_street -> extra = $row['streetextra'];
    $ajen_address -> id = $row['addressid'];
    $ajen_address -> city = $row['city'];
    $ajen_address -> country = $row['country'];

    $utam_addr_booskhop -> utam_bookshop = $utam_bookshop;
    $utam_addr_bookshop -> ajen_address = $ajen_address;
    $utam_addr_bookshop -> ajen_address -> ajen_street = $ajen_street;
    
    return $utam_addr_bookshop;
  }
}
?>