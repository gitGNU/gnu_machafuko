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


include_once ('connection_factory.php');

/**
 * Object represents connection to database.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 * @date: 27.11.2007
 */
class connection
{
	private $connection;

   /**
    * Creates the connection using a factory.
    */
	public function connection ()
	{
		$this -> connection = connection_factory::get_connection();
	}

   /**
    * Closes the connection to database.
    */
	public function close ()
	{
		connection_factory::close ($this -> connection);
	}

	/**
	 * Execute the query.
	 *
	 * @param sql the query.
	 * @return the mysql_query result.
	 */
	public function execute_query ($sql)
	{
		return mysql_query ($sql, $this -> connection);
	}
}
?>