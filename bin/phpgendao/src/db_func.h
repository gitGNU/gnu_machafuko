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

#ifndef _DB_FUNC_H_
#define _DB_FUNC_H_

#include <mysql/mysql.h>

/*
 * Needed structs.
 */
struct db_property
{
  char *name; // Name of the property.
  char *type; // MySQL type of property.
  int is_pk; // 1 whether this property is primary key or 0 whether it isn't.
};

struct db_association
{
  char *type; // many-to-one, one-to-many, many-to-many, etc.
  char *table; // Referenced table.
  char **key; /* Column names of the foreign key.
		 This is a NULL terminated array of strings. */
};

struct db_info_table
{
  char *name; // Name of the table.
  int n_props; // Number of properties.
  struct db_property *prop; // Array of properties.
  int n_assoc; // Number of associations (foreign keys).
  struct db_association *assoc; // Array of associations.
};

/*
 * This function creates a MySQL connection and returns 0 whether ok or NULL  whether 
 * there are problems.
 */
int db_connect (char *host, char *db, char *user, char *pass);

/*
 * This function close a MySQL connection.
 */
void db_disconnect ();

/*
 * Execute the "show tables" query to get MYSQL_RES data.
 *
 * Return 0 whather all ok and 1 if there is any error.
 */
int db_select_and_load_tables ();

/*
 * Retry all information of the next table. This function can be call once has been call 
 * the db_select_and_load_tables function.
 *
 * Return a db_info_table struct or NULL if there is any error or is final.
 */
struct db_info_table *db_get_next_info_table ();

#endif
