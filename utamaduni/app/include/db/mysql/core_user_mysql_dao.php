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

include_once (dirname (__FILE__) . '/../dao/core_user_dao.php');
include_once (dirname (__FILE__) . '/core/sql_query.php');
include_once (dirname (__FILE__) . '/core/query_executor.php');
include_once (dirname (__FILE__) . '/core/transaction.php');

/**
 * Class that operate on table 'core_user'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class core_user_mysql_dao implements core_user_dao
{
	/**
	 * Get domain object by primary key.
	 *
	 * @param String $id primary key.
	 * @return core_user_mysql.
	 */
	public function load ($id)
	{
		$sql = 'SELECT * FROM ajen_contact WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set_number ($id);
		return $this -> get_row ($query);
	}

	/**
	 * Get all records from table.
	 */
	public function query_all ()
	{
		$sql = 'SELECT * FROM core_user';
		$query = new sql_query ($sql);
		return $this -> get_list ($query);
	}

	/**
	 * Get all records from table ordered by field.
	 *
	 * @param $order_col column name.
	 */
	public function query_all_order_by ($order_col)
	 {
		$sql = 'SELECT * FROM core_user ORDER BY ' . $order_col;
		$query = new sql_query ($sql);
		return $this -> get_list ($query);
	}

	/**
	 * Delete record from table.
	 *
	 * @param String $id core_user primary key
	 */
	public function delete ($id)
	{
		$sql = 'DELETE FROM core_user WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set_number ($id);
		return $this -> execute_update ($query);
	}

	/**
	 * Queries and deletes by column.
	 */
	public function query_by_id ($value)
	{
		$sql = 'SELECT * FROM core_user WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_id ($value)
	{
		$sql = 'DELETE FROM core_user WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_email ($value)
	{
		$sql = 'SELECT * FROM core_user WHERE email = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_email ($value)
	{
		$sql = 'DELETE FROM core_user WHERE email = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_pass ($value)
	{
		$sql = 'SELECT * FROM core_user WHERE pass = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_pass ($value)
	{
		$sql = 'DELETE FROM core_user WHERE pass = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_name ($value)
	{
		$sql = 'SELECT * FROM core_user WHERE name = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_name ($value)
	{
		$sql = 'DELETE FROM core_user WHERE name = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_lname ($value)
	{
		$sql = 'SELECT * FROM core_user WHERE lname = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_lname ($value)
	{
		$sql = 'DELETE FROM core_user WHERE lname = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	/**
	 * Insert record to table.
	 *
	 * @param core_user_mysql core_user.
	 */
	public function insert ($core_user)
	{
		$sql = 'INSERT INTO core_user (id, email, pass, name, lname) VALUES (?, ?, ?, ?, ?)';
		$query = new sql_query ($sql);

		$query -> set ($core_user -> id);
		$query -> set ($core_user -> email);
		$query -> set ($core_user -> pass);
		$query -> set ($core_user -> name);
		$query -> set ($core_user -> lname);

		$id = $this -> execute_insert ($query);
		$core_user -> id = $id;
		return $id;
	}

	/**
	 * Update record in table.
	 *
	 * @param core_user_mysql core_user
	 */
	public function update ($core_user)
	{
		$sql = 'UPDATE core_user SET id = ?, email = ?, pass = ?, name = ?, lname = ? WHERE id = ?';
		$query = new sql_query ($sql);

		$query -> set ($core_user -> id);
		$query -> set ($core_user -> email);
		$query -> set ($core_user -> pass);
		$query -> set ($core_user -> name);
		$query -> set ($core_user -> lname);

		$query -> set_number ($core_user -> id);
		return $this -> execute_query ($query);
	}

	/**
	 * Delete all rows.
	 */
	public function clean ()
	{
		$sql = 'DELETE FROM core_user';
		$query = new sql_query ($sql);
		return $this -> execute_update ($query);
	}

	/**
	 * Read row.
	 *
	 * @return core_user_mysql
	 */
	protected function read_row ($row)
	{
		$core_user = new core_user ();

		$core_user -> id = $row['id'];
		$core_user -> email = $row['email'];
		$core_user -> pass = $row['pass'];
		$core_user -> name = $row['name'];
		$core_user -> lname = $row['lname'];

		return $core_user;
	}

	protected function get_list ($query)
	{
		$tab = query_executor::execute ($query);
		$ret = array ();
		for ($i = 0; $i < count ($tab); $i++)
		{
			$ret[$i] = $this -> read_row ($tab[$i]);
		}
		return $ret;
	}

	/**
	 * Get row.
	 *
	 * @return core_user_mysql.
	 */
	protected function get_row ($query)
	{
		$tab = query_executor::execute ($query);
		if (count ($tab) == 0)
		{
			return null;
		}
		return $this -> read_row ($tab[0]);
	}

	/**
	 * Execute sql query.
	 */
	protected function execute ($query)
	{
		return query_executor::execute ($query);
	}

	/**
	 * Execute sql query.
	 */
	protected function execute_update ($query)
	{
		 return query_executor::execute_update ($query);
	}

	/**
	 * Query for one row and one column.
	 */
	protected function query_single_result ($query)
	{
		return query_executor::query_for_string ($query);
	}

	/**
	 * Insert row to table.
	 */
	protected function execute_insert ($query)
	{
		return query_executor::execute_insert ($query);
	}
}
?>