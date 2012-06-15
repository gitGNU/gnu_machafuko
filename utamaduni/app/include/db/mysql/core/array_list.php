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
 * Array list class.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class array_list
{
	private $tab;
	private $size;

	public function array_list ()
	{
		$this -> tab = array ();
		$this -> size = 0;
	}
	
	public function add ($value)
	{
		$this -> tab[$this -> size] = $value;
		$this -> size = ($this -> size) + 1;
	}
	
	public function get ($idx)
	{
		return $this -> tab[$idx];
	}

	public function get_last ()
	{
		if ($this -> size == 0)
		{
			return null;
		}
		return $this -> tab[($this -> size) - 1];
	}

	public function size (){
		return $this -> size;
	}

	public function is_empty ()
	{
		return ($this -> size) == 0;
	}

	public function remove_last ()
	{
		return $this -> size = ($this -> size) - 1;
	}
}
?>