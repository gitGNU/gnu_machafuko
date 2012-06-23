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
interface utam_online_bookshop_dao
{
	/**
	 * Get domain object by primary key.
	 *
	 * @param String $id primary key.
	 * @return utam_online_bookshop.
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
	 * @param utam_online_bookshop $utam_online_bookshop.
	 */
	public function insert ($utam_online_bookshop);

	/**
	 * Update record in table.
	 *
	 * @param utam_online_bookshop $utam_online_bookshop.
	 */
	public function update ($utam_online_bookshop);

	/**
	 * Delete all rows.
	 */
	public function clean ();

	/**
	 * Queries and deletes.
	 */
	public function query_by_id ($value);
	public function delete_by_id ($value);

	public function query_by_url ($value);
	public function delete_by_url ($value);

}
?>