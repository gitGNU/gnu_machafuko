<?php
/*
 * Utamaduni (suajili language meaning 'culture') is a book management.
 * Copyright (C) 2012 Román Ginés Martínez Ferrández <romangines@riseup.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * util.php
 *
 * This is a class with utilities to searches.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class search_util
{
  // {{{ is_in_object_array ($object_array, $pattern)
  /**
   * is_in_object_array
   *
   * Check if into object $object_array there is any object that matches with $pattern that is
   * an array $attribute => $value.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param mixed $object_array array of objects.
   * @param mixed $pattern array with attribute => value pairs.
   * @return an array with the objects into $object_array that matches with $pattern or null.
   */
  static public function is_in_object_array ($object_array, $pattern)
  {
    $res = null;

    foreach ($object_array as $obj)
      {
	$equal = true;
	foreach ($pattern as $idx => $val)
	  {
	    if (strtolower ($obj -> $idx) != strtolower ($val))
	      {
		$equal = false;
		break;
	      }
	  }
	if ($equal)
	  $res = $obj;
      }

    return $res;
  }
  // }}}
}
?>
