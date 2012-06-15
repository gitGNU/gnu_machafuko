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

include_once ('connection_property.php');

/*
 * Class return connection to database.
 *
 * @author: Román Ginés Martínez Ferrández <roman.gines@riseup.net>
 */
class connection_factory
{
	
	/**
	 * Creates a connection if not exists.
	 *
	 * @return the connection.
	 */
	static public function get_connection(){
		$conn = mysql_connect (connection_property::get_host (), connection_property::get_user (), 
		                       connection_property::get_password ());
		mysql_query ("SET CHARACTER SET 'utf8'", $conn);
		mysql_select_db (connection_property::get_database ());
		if (!$conn)
		{
			throw new Exception ('Could not connect to database.');
		}
		return $conn;
	}

	/**
	 * Close the connection to MySQL.
	 *
	 * @param the connection.
	 */
	static public function close ($connection)
	{
		mysql_close ($connection);
	}
}
?>