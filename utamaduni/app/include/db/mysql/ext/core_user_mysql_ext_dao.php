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

include_once (dirname (__FILE__) . '/../core_user_mysql_dao.php');

/**
 * Class that operate on table 'core_user'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class core_user_mysql_ext_dao extends core_user_mysql_dao
{
  /**
   * This function is used to check login user. Return an object
   * with user information if exists.
   *
   * @param String $mail E-mail.
   * @param String $pass Password.
   */
  public function login ($mail, $pass)
  {
    $sql = 'SELECT * FROM core_user WHERE email = ? and pass = ?';
    $query = new sql_query ($sql);
    $query -> set ($mail);
    $query -> set (md5 ($pass));
    return $this -> get_row ($query);
  }
}
?>