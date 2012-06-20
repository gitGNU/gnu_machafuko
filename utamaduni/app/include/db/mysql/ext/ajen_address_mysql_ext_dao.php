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

include_once (dirname (__FILE__) . '/../ajen_address_mysql_dao.php');

/**
 * Class that operate on table 'ajen_address'. Database MySQL.
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class ajen_address_mysql_ext_dao extends ajen_address_mysql_dao
{
  /**
   * Return a address id if exists or NULL (0) if not exists the address.
   *
   * @param string $street the id of the street.
   * @param string $city the city.
   * @param string $country the country.
   * @return integer the address id if exists or null if not exists.
   */
  public function query_id ($street, $city, $country)
  {
    $sql = 'SELECT id FROM ajen_address WHERE street=? and lower(city)=lower(?) and lower(country)=lower(?)';
    $query = new sql_query ($sql);
    $query -> set ($street);
    $query -> set ($city);
    $query -> set ($country);
    $tab = query_executor::execute ($query);
    if (count ($tab) == 0)
      return null;
    else
      return $tab[0]['id'];
  }

  /**
   * Insert a new address if does not exists address with street, city and
   * country.
   *
   * @param string $street the street.
   * @param string $city the city.
   * @param string $country the country.
   * @return integer the address id inserted or existed.
   */
  public function insert_address ($ajen_address)
  {
    $addressid = $this -> query_id ($ajen_address -> street, $ajen_address -> city, 
				     $ajen_address -> country);
    if (!$addressid)
      {
	$sql = 'INSERT INTO ajen_address (street, city, country) VALUES (?, ?, ?)';
	$query = new sql_query ($sql);
	$query -> set ($ajen_address -> street);
	$query -> set ($ajen_address -> city);
	$query -> set ($ajen_address -> country);
	$addressid = $this -> execute_insert ($query);
      }

    return $addressid;
  }
}
?>