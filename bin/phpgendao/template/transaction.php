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
 * Database transaction.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class transaction
{
	private static $transactions;

	private $connection;

	public function transaction ()
	{
		$this -> connection = new connection ();
		if (!transaction::$transactions)
		{
			transaction::$transactions = new array_list ();
		}
		transaction::$transactions -> add ($this);
		$this -> connection -> execute_query ('BEGIN');
	}

	/**
	 * Commit the last transaction.
	 */
	public function commit ()
	{
		$this -> connection -> execute_query ('COMMIT');
		$this -> connection -> close ();
		transaction::$transactions -> remove_last ();
	}

	/**
	 * Rollback the last transaction.
	 */
	public function rollback ()
	{
		$this -> connection -> execute_query ('ROLLBACK');
		$this -> connection -> close ();
		transaction::$transactions -> remove_last ();
	}

	/**
	 * Return the connection.
	 *
	 * @return the connection.
	 */
	public function get_connection ()
	{
		return $this -> connection;
	}

	/**
	 * Return the current transaction (the last).
	 *
	 * @return the last transaction.
	 */
	public static function get_current_transaction ()
	{
		if (transaction::$transactions)
		{
			$tran = transaction::$transactions -> get_last ();
			return $tran;
		}
		return;
	}
}
?>