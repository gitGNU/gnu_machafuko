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

/**
 * Interface DAO.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
interface utam_book_dao
{
	/**
	 * Get domain object by primary key.
	 *
	 * @param String $id primary key.
	 * @return utam_book.
	 */
	public function load ($id);

	/**
	 * Get all records from table.
	 */
	public function query_all ();

	/**
	 * Get all records from table ordered by field.
	 *
	 * @param String $order_col column name.
	 */
	public function query_all_order_by ($order_col);

	/**
	 * Delete record from table.
	 *
	 * @param String $id primary key.
	 */
	public function delete ($id);

	/**
	 * Insert record to table.
	 *
	 * @param utam_book $utam_book.
	 */
	public function insert ($utam_book);

	/**
	 * Update record in table.
	 *
	 * @param utam_book $utam_book.
	 */
	public function update ($utam_book);

	/**
	 * Delete all rows.
	 */
	public function clean ();

	/**
	 * Queries and deletes.
	 */
	public function query_by_id ($value);
	public function delete_by_id ($value);

	public function query_by_isbn ($value);
	public function delete_by_isbn ($value);

	public function query_by_title ($value);
	public function delete_by_title ($value);

	public function query_by_description ($value);
	public function delete_by_description ($value);

	public function query_by_cover ($value);
	public function delete_by_cover ($value);

}
?>