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

#ifndef _PHP_FUNC_H_
#define _PHP_FUNC_H_

#include "db_func.h"

/*
 * It generates the DTO object (Domain Object). It is a little class with
 * only properties (attributes).
 */
void php_generate_domain_class (struct db_info_table *, char *);

/*
 * It generate the Data Access Object (DAO). It is a class with a serie of
 * functions to access to get, insert, delete and update data.
 */
void php_generate_dao_class (struct db_info_table *, char *);

/*
 * It generate the class that operates with a table using MySQL.
 */
void php_generate_mysql_dao_class (struct db_info_table *, char *);

/*
 * It generate a class scheme to add specified methods to access to database.
 */
void php_generate_mysql_dao_extra_class (struct db_info_table *, char *);

/*
 * It function copy the PHP static files from specified folder to specified folder.
 */
void php_copy_static_files (char *, char *);

#endif
