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
 * Object executes sql queries.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class query_executor
{
	public static function execute ($sqlquery){
		$transaction = transaction::get_current_transaction ();
		if (!$transaction)
		{
			$connection = new connection ();
		}
		else
		{
			$connection = $transaction -> get_connection ();
		}		
		$query = $sqlquery -> get_query ();
		$result = $connection -> execute_query ($query);
		if(!$result)
		{
			throw new Exception (mysql_error ());
		}
		$i=0;
		$tab = array ();
		while ($row = mysql_fetch_array ($result))
		{
			$tab[$i++] = $row;
		}
		mysql_free_result ($result);
		if (!$transaction)
		{
			$connection -> close ();
		}
		return $tab;
	}
	
	public static function execute_update ($sqlquery){
		$transaction = transaction::get_current_transaction ();
		if (!$transaction)
		{
			$connection = new connection ();
		}
		else
		{
			$connection = $transaction -> get_connection ();
		}		
		$query = $sqlquery -> get_query ();
		$result = $connection -> execute_query ($query);
		if (!$result)
		{
			throw new Exception(mysql_error ());
		}
		return mysql_affected_rows ();
	}

	public static function execute_insert($sqlquery)
	{
		query_executor::execute_update ($sqlquery);
		return mysql_insert_id ();
	}
	
	public static function query_for_string ($sqlquery)
	{
		$transaction = transaction::get_current_transaction ();
		if (!$transaction)
		{
			$connection = new connection ();
		}
		else
		{
			$connection = $transaction -> get_connection ();
		}
		$result = $connection -> execute_query ($sqlquery -> getQuery ());
		if (!$result)
		{
			throw new Exception (mysql_error ());
		}
		$row = mysql_fetch_array ($result);		
		return $row[0];
	}

}
?>