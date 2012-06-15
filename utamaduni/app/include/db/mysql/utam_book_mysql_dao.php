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

include_once (dirname (__FILE__) . '/../dao/utam_book_dao.php');
include_once (dirname (__FILE__) . '/../dto/utam_book.php');
include_once (dirname (__FILE__) . '/core/array_list.php');
include_once (dirname (__FILE__) . '/core/sql_query.php');
include_once (dirname (__FILE__) . '/core/query_executor.php');
include_once (dirname (__FILE__) . '/core/transaction.php');

/**
 * Class that operate on table 'utam_book'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_book_mysql_dao implements utam_book_dao
{
	/**
	 * Get domain object by primary key.
	 *
	 * @param String $id primary key.
	 * @return utam_book_mysql.
	 */
	public function load ($id)
	{
		$sql = 'SELECT * FROM utam_book a WHERE a.id = ? ';
		$query = new sql_query ($sql);
		$query -> set_number ($id);
		return $this -> get_row ($query);
	}

	/**
	 * Get all records from table.
	 */
	public function query_all ()
	{
		$sql = 'SELECT * FROM utam_book a WHERE 0 = 0 ';
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
		$sql = 'SELECT * FROM utam_book a WHERE 0 = 0  ORDER BY ' . $order_col;
		$query = new sql_query ($sql);
		return $this -> get_list ($query);
	}

	/**
	 * Delete record from table.
	 *
	 * @param String $id utam_book primary key
	 */
	public function delete ($id)
	{
		$sql = 'DELETE FROM utam_book WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set_number ($id);
		return $this -> execute_update ($query);
	}

	/**
	 * Queries and deletes by column.
	 */
	public function query_by_id ($value)
	{
		$sql = 'SELECT * FROM utam_book a WHERE id = ? ';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_id ($value)
	{
		$sql = 'DELETE FROM utam_book WHERE id = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_isbn ($value)
	{
		$sql = 'SELECT * FROM utam_book a WHERE isbn = ? ';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_isbn ($value)
	{
		$sql = 'DELETE FROM utam_book WHERE isbn = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_title ($value)
	{
		$sql = 'SELECT * FROM utam_book a WHERE title = ? ';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_title ($value)
	{
		$sql = 'DELETE FROM utam_book WHERE title = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_description ($value)
	{
		$sql = 'SELECT * FROM utam_book a WHERE description = ? ';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_description ($value)
	{
		$sql = 'DELETE FROM utam_book WHERE description = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_cover ($value)
	{
		$sql = 'SELECT * FROM utam_book a WHERE cover = ? ';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_cover ($value)
	{
		$sql = 'DELETE FROM utam_book WHERE cover = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_pages ($value)
	{
		$sql = 'SELECT * FROM utam_book a WHERE pages = ? ';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_pages ($value)
	{
		$sql = 'DELETE FROM utam_book WHERE pages = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_publisher ($value)
	{
		$sql = 'SELECT * FROM utam_book a WHERE publisher = ? ';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_publisher ($value)
	{
		$sql = 'DELETE FROM utam_book WHERE publisher = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
	}

	public function query_by_format ($value)
	{
		$sql = 'SELECT * FROM utam_book WHERE format = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> get_list ($query);
	}

	public function delete_by_format ($value)
	{
		$sql = 'DELETE FROM utam_book WHERE format = ?';
		$query = new sql_query ($sql);
		$query -> set ($value);
		return $this -> execute_update ($query);
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
		$query -> set ($utam_book -> publisher);
		$query -> set ($utam_book -> format);

		$id = $this -> execute_insert ($query);
		$utam_book -> id = $id;
		return $id;
	}

	/**
	 * Update record in table.
	 *
	 * @param utam_book_mysql utam_book
	 */
	public function update ($utam_book)
	{
		$sql = 'UPDATE utam_book SET id = ?, isbn = ?, title = ?, description = ?, cover = ?, pages = ?, publisher = ?, format = ? WHERE id = ?';
		$query = new sql_query ($sql);

		$query -> set ($utam_book -> id);
		$query -> set ($utam_book -> isbn);
		$query -> set ($utam_book -> title);
		$query -> set ($utam_book -> description);
		$query -> set ($utam_book -> cover);
		$query -> set ($utam_book -> pages);
		$query -> set ($utam_book -> publisher);
		$query -> set ($utam_book -> format);

		$query -> set_number ($utam_book -> id);
		return $this -> execute_query ($query);
	}

	/**
	 * Delete all rows.
	 */
	public function clean ()
	{
		$sql = 'DELETE FROM utam_book';
		$query = new sql_query ($sql);
		return $this -> execute_update ($query);
	}

	/**
	 * Read row.
	 *
	 * @return utam_book_mysql
	 */
	protected function read_row ($row)
	{
		$utam_book = new utam_book ();

		$utam_book -> id = $row['id'];
		$utam_book -> isbn = $row['isbn'];
		$utam_book -> title = $row['title'];
		$utam_book -> description = $row['description'];
		$utam_book -> cover = $row['cover'];
		$utam_book -> pages = $row['pages'];
		$utam_book -> publisher = $row['publisher'];
		$utam_book -> format = $row['format'];

		return $utam_book;
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
	 * @return utam_book_mysql.
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