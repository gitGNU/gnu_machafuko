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

include_once (dirname (__FILE__) . '/../dao/ajen_phone_dao.php');
include_once (dirname (__FILE__) . '/core/sql_query.php');
include_once (dirname (__FILE__) . '/core/query_executor.php');
include_once (dirname (__FILE__) . '/core/transaction.php');

/**
 * Class that operate on table 'ajen_phone'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class ajen_phone_mysql_dao implements ajen_phone_dao
{
	/**
	 * Get domain object by primary key.
	 *
	 * @param String $id primary key.
	 * @return ajen_phone_mysql.
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
		$sql = 'SELECT * FROM ajen_phone';
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
		$sql = 'SELECT * FROM ajen_phone ORDER BY ' . $order_col;
		$query = new sql_query ($sql);
		return $this -> get_list ($query);
	}

	/**
	 * Delete record from table.
	 *
	 * @param String $id ajen_phone primary key
	 */
	public function delete ($id)
	{
		$sql = 'DELETE FROM ajen_phone WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set_number ($id);
		return $this -> execute_update ($query);
	}

	/**
	 * Queries and deletes by column.
	 */
	public function query_by_id ($value)
	{
		$sql = 'SELECT * FROM ajen_phone WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_id ($value)
	{
		$sql = 'DELETE FROM ajen_phone WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_numphone ($value)
	{
		$sql = 'SELECT * FROM ajen_phone WHERE numphone = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_numphone ($value)
	{
		$sql = 'DELETE FROM ajen_phone WHERE numphone = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_contact ($value)
	{
		$sql = 'SELECT * FROM ajen_phone WHERE contact = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_contact ($value)
	{
		$sql = 'DELETE FROM ajen_phone WHERE contact = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	/**
	 * Insert record to table.
	 *
	 * @param ajen_phone_mysql ajen_phone.
	 */
	public function insert ($ajen_phone)
	{
		$sql = 'INSERT INTO ajen_phone (id, numphone, contact) VALUES (?, ?, ?)';
		$query = new sql_query ($sql);

		$query -> set ($ajen_phone -> id);
		$query -> set ($ajen_phone -> numphone);
		$query -> set ($ajen_phone -> contact);

		$id = $this -> execute_insert ($query);
		$ajen_phone -> id = $id;
		return $id;
	}

	/**
	 * Update record in table.
	 *
	 * @param ajen_phone_mysql ajen_phone
	 */
	public function update ($ajen_phone)
	{
		$sql = 'UPDATE ajen_phone SET id = ?, numphone = ?, contact = ? WHERE id = ?';
		$query = new sql_query ($sql);

		$query -> set ($ajen_phone -> id);
		$query -> set ($ajen_phone -> numphone);
		$query -> set ($ajen_phone -> contact);

		$query -> set_number ($ajen_phone -> id);
		return $this -> execute_query ($query);
	}

	/**
	 * Delete all rows.
	 */
	public function clean ()
	{
		$sql = 'DELETE FROM ajen_phone';
		$query = new sql_query ($sql);
		return $this -> execute_update ($query);
	}

	/**
	 * Read row.
	 *
	 * @return ajen_phone_mysql
	 */
	protected function read_row ($row)
	{
		$ajen_phone = new ajen_phone ();

		$ajen_phone -> id = $row['id'];
		$ajen_phone -> numphone = $row['numphone'];
		$ajen_phone -> contact = $row['contact'];

		return $ajen_phone;
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
	 * @return ajen_phone_mysql.
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