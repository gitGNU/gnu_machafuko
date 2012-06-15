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
 * Object represents sql query with params.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class sql_query
{
	var $txt;
	var $params = array ();
	var $idx = 0;

	/**
	 * Constructor
	 *
	 * @param String $txt zapytanie sql
	 */
	function sql_query ($txt)
	{
		$this -> txt = $txt;
	}

	/**
	 * Set string param.
	 *
	 * @param String $value value set.
	 */
	public function set_string ($value)
	{
		$value = mysql_escape_string ($value);
		$this -> params[$this->idx++] = "'" . $value . "'";
	}
	
	/**
	 * Set string param.
	 *
	 * @param String $value value to set.
	 */
	public function set ($value)
	{
		$value = mysql_escape_string ($value);
		$this -> params[$this->idx++] = "'" . $value . "'";
	}
	

	/**
	 * Set number param.
	 *
	 * @param String $value value to set.
	 */
	public function set_number($value)
	{
		if ($value === null)
		{
			$this -> params[$this->idx++] = "null";
			return;
		}
		if (!is_numeric ($value))
		{
			throw new Exception ($value.' is not a number.');
		}
		$this -> params[$this->idx++] = "'" . $value . "'";
	}

	/**
	 * Get sql query.
	 *
	 * @return String.
	 */
	public function get_query ()
	{
		if($this -> idx == 0)
		{
			return $this -> txt;
		}
		$p = explode ("?", $this -> txt);
		$sql = '';
		for ($i = 0; $i <= $this -> idx; $i++)
		{
			if ($i >= count ($this -> params))
			{
				$sql .= $p[$i];
			}
			else
			{
				$sql .= $p[$i] . $this -> params[$i];
			}
		}
		return $sql;
	}
	
	/**
	 * Function replace first char.
	 *
	 * @param String $str.
	 * @param String $old.
	 * @param String $new.
	 * @return String.
	 */
	private function replace_first ($str, $old, $new)
	{
		$len = strlen ($str);
		for ($i = 0; $i < $len; $i++)
		{
			if ($str[$i] == $old)
			{
				$str = substr ($str, 0, $i) . $new . substr ($str, $i + 1);
				return $str;
			}
		}
		return $str;
	}
}
?>