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

#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#include "db_func.h"

/* The MYSQL data connection */
static MYSQL *g_my_conn = NULL;

/* The MYSQL result table load */
static MYSQL_RES *g_tableres = NULL;

/*******************************************************************************/

int
db_connect (char *host, char *db, char *user, char *pass)
{
  // Database connection.
  if (!(g_my_conn = mysql_init (0)))
    {
      fprintf (stderr, "Error: db_func.c: %s\n", mysql_error (g_my_conn));
      g_my_conn = NULL;
      return 1;
    }
  else if (!mysql_real_connect (g_my_conn, host,  user, pass, db, 
				MYSQL_PORT, NULL, 0))
    {
      fprintf (stderr, "Error: db_func.c: %s\n", mysql_error (g_my_conn));
      g_my_conn = NULL;
      return 1;
    }
  else
    {
      return 0;
    }
}

/*******************************************************************************/

void
db_disconnect ()
{
  if (g_my_conn != NULL)
    {
      mysql_close (g_my_conn);
    }
}

/*******************************************************************************/

static struct db_property *
new_db_property ()
{
  struct db_property *p;

  p = (struct db_property *) malloc (sizeof (struct db_property));
  p -> name = NULL;
  p -> type = NULL;
  p -> is_pk = 0;

  return p;
}

/*******************************************************************************/

static struct db_association *
new_db_association ()
{
  struct db_association *a;

  a = (struct db_association *) malloc (sizeof (struct db_association));
  a -> type = NULL;
  a -> table = NULL;
  a -> key = NULL;

  return a;
}

/*******************************************************************************/

static struct db_info_table *
new_db_info_table ()
{
  struct db_info_table *t;

  t = (struct db_info_table *) malloc (sizeof (struct db_info_table));
  t -> name = NULL;
  t -> n_props = 0;
  t -> prop = NULL;
  t -> n_assoc = 0;
  t -> assoc = NULL;

  return t;
}

/*******************************************************************************/

char *
get_type_name (int mysql_type)
{
  char *res = NULL;

  if (mysql_type == MYSQL_TYPE_DECIMAL || mysql_type == MYSQL_TYPE_TINY ||
      mysql_type == MYSQL_TYPE_LONGLONG || mysql_type == MYSQL_TYPE_INT24 ||
      mysql_type == MYSQL_TYPE_LONG)
    res = strdup ("int");
  else if (mysql_type == MYSQL_TYPE_SHORT)
    res = strdup ("short");
  else if (mysql_type == MYSQL_TYPE_FLOAT)
    res = strdup ("float");
  else if (mysql_type == MYSQL_TYPE_DOUBLE)
    res = strdup ("double");
  else if (mysql_type == MYSQL_TYPE_DATE || mysql_type == MYSQL_TYPE_TIME ||
           mysql_type == MYSQL_TYPE_DATETIME || mysql_type == MYSQL_TYPE_YEAR ||
           mysql_type == MYSQL_TYPE_NEWDATE || mysql_type == MYSQL_TYPE_VARCHAR ||
           mysql_type == MYSQL_TYPE_VAR_STRING || mysql_type == MYSQL_TYPE_STRING)
    res = strdup ("varchar");

  return res;
}

/*******************************************************************************/

int
is_field_pk (char *column, char *table)
{
  int result = 0;
  char *sql;
  MYSQL_RES *res;

  if (!g_my_conn)
    fprintf (stderr, "Error: functions.c: MYSQL not inited\n");
  else
    {
      // Prepare the select and execute it.                                                                                                                                                     
      sql = (char *) malloc (sizeof (char) * 500);
      sql = strcpy (sql, "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.STATISTICS "
                    "WHERE INDEX_NAME='PRIMARY' "
                    "AND TABLE_NAME='");
      sql = strcat (sql, table);
      sql = strcat (sql, "' AND COLUMN_NAME='");
      sql = strcat (sql, column);
      sql = strcat (sql, "'");
      if (mysql_query (g_my_conn, sql))
        {
          fprintf (stderr, "Error: functions.c: %s\n", mysql_error (g_my_conn));
        }
      // Get the result.                                                                                                                                                                        
      else if (!(res = mysql_store_result (g_my_conn)))
        {
          fprintf (stderr, "Error: functions.c: %s\n", mysql_error (g_my_conn));
        }
      else
        {
          // If there is result then it will return 1.                                                                                                                                          
          if (mysql_num_rows (res) > 0)
            result = 1;
          mysql_free_result (res);
        }
    }

  return result;
}

/*******************************************************************************/

struct db_association *
association_info (char *table_name, int *n_assoc)
{
  struct db_association *result = NULL;
  char *sql1, *sql2;
  MYSQL_RES *res_one2many, *res_many2one;
  MYSQL_ROW row;
  int num, i, fk;

  *n_assoc = 0;

  if (!g_my_conn)
    fprintf (stderr, "Error: db_func.c: MYSQL not inited\n");
  else
    {
      // Prepare the select (many-to-one associations).
      sql1 = (char *) malloc (sizeof (char) * 500);
      sql1 = strcpy (sql1, "SELECT TABLE_NAME, COLUMN_NAME, "
		    "REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME "
		    "FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE "
		    "WHERE TABLE_NAME='");
      sql1 = strcat (sql1, table_name);
      sql1 = strcat (sql1, "' AND REFERENCED_TABLE_NAME IS NOT NULL "
		    "AND REFERENCED_COLUMN_NAME IS NOT NULL "
		     "ORDER BY REFERENCED_TABLE_NAME");

      // Prepare the select (one-to-many associations).
      sql2 = (char *) malloc (sizeof (char) * 500);
      sql2 = strcpy (sql2, "SELECT TABLE_NAME, COLUMN_NAME, "
		     "REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME "
		     "FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE "
		     "WHERE REFERENCED_TABLE_NAME='");
      sql2 = strcat (sql2, table_name);
      sql2 = strcat (sql2, "' AND REFERENCED_TABLE_NAME IS NOT NULL "
		     "AND REFERENCED_COLUMN_NAME IS NOT NULL "
		     "ORDER BY REFERENCED_TABLE_NAME");

      // Execute the query 1 (many-to-one association).
      if (mysql_query (g_my_conn, sql1))
	{
	  fprintf (stderr, "Error: db_func.c: %s\n", mysql_error (g_my_conn));
	}
      // Get the results.
      else if (!(res_many2one = mysql_store_result (g_my_conn)))
	{
	  fprintf (stderr, "Error: db_func.c: %s\n", mysql_error (g_my_conn));
	}
      else if (mysql_query (g_my_conn, sql2))
	{
	  fprintf (stderr, "Error: db_func.c: %s\n", mysql_error (g_my_conn));
	}
      else if (!(res_one2many = mysql_store_result (g_my_conn)))
	{
	  fprintf (stderr, "Error: db_func.c: %s\n", mysql_error (g_my_conn));
	}
      else
	{
	  num = mysql_num_rows (res_many2one) + mysql_num_rows (res_one2many) + 1;
	  if (num > 0)
	    {
	      result = (struct db_association *) malloc (sizeof (struct db_association) * num);
	      fk = 0;
	      i = 0;
	      while (row = mysql_fetch_row (res_many2one))
		{
		  if (fk == 0)
		    {
		      result[i].type = strdup ("many-to-one");
		      result[i].table = strdup (row[2]); // Referenced table.
		      result[i].key = (char **) malloc (sizeof (char *) * 2);
		      result[i].key[fk] = strdup (row[1]); // Foreign key (column name).
		      result[i].key[fk + 1] = NULL;
#ifdef _DEBUG_
		      printf ("FK %d: %s, %s, %s\n", i, result[i].type, 
			      result[i].table, result[i].key[fk]);
#endif
		      fk = 1;
		      i++;
		    }
		  else if (fk > 0 && !strcmp (result[i - 1].table, row[2]))
		    {
		      result[i - 1].key = (char **) realloc (result[i - 1].key, 
							 sizeof (char *) * (fk + 2));
		      result[i - 1].key[fk] = strdup (row[1]);
		      result[i - 1].key[fk + 1] = NULL;
#ifdef _DEBUG_
		      printf ("FK %d: %s, %s, %s\n", i - 1, result[i - 1].type, 
			      result[i - 1].table, result[i - 1].key[fk]);
#endif
		      fk++;
		    }
		  else 
		    {
		      fk = 0;
		      result[i].type = strdup ("many-to-one");
		      result[i].table = strdup (row[2]);
		      result[i].key = (char **) malloc (sizeof (char *) * 2);
		      result[i].key[fk] = strdup (row[1]);
		      result[i].key[fk + 1]= NULL;
#ifdef _DEBUG_
		      printf ("FK %d: %s, %s, %s\n", i, result[i].type, 
			      result[i].table, result[i].key[fk]);
#endif
		      fk = 1;
		      i++;
		    }
		}
	      fk = 0;
	      while (row = mysql_fetch_row (res_one2many))
		{
		  if (fk == 0)
		    {
		      result[i].type = strdup ("one-to-many");
		      result[i].table = strdup (row[0]); // Referenced table.
		      result[i].key = (char **) malloc (sizeof (char *) * 2);
		      result[i].key[fk] = strdup (row[1]); // Foreign key (column name).
		      result[i].key[fk + 1] = NULL;
#ifdef _DEBUG_

		      printf ("FK %d: %s, %s, %s\n", i, result[i].type, 
			      result[i].table, result[i].key[fk]);
#endif
		      fk = 1;
		      i++;
		    }
		  else if (fk > 0 && !strcmp (result[i - 1].table, row[0]))
		    {
		      result[i - 1].key = (char **) realloc (result[i - 1].key,
							     sizeof (char *) * (fk + 2));
		      result[i - 1].key[fk] = strdup (row[1]);
		      result[i - 1].key[fk + 1]= NULL;
#ifdef _DEBUG_
		      printf ("FK %d: %s, %s, %s\n", i - 1, result[i - 1].type, 
			      result[i - 1].table, result[i - 1].key[fk]);
#endif
		      fk++;
		    }
		  else
		    {
		      fk = 0;
		      result[i].type = strdup ("one-to-many");
		      result[i].table = strdup (row[0]);
		      result[i].key = (char **) malloc (sizeof (char *) * 2);
		      result[i].key[fk] = strdup (row[1]);
		      result[i].key[fk + 1] = NULL;
#ifdef _DEBUG_
		      printf ("FK %d: %s, %s, %s\n", i, result[i].type, 
			      result[i].table, result[i].key[fk]);
#endif
		      fk = 1;
		      i++;
		    }
		}
	      // Number of n_assoc.
	      *n_assoc = i;

	      mysql_free_result (res_many2one);
	      mysql_free_result (res_one2many);
	    }
	  free (sql1);
	  free (sql2);
	}
    }
  
  return result;
}

/*******************************************************************************/

int
db_select_and_load_tables ()
{
  int res = 0;

  if (g_my_conn != NULL)
    {
      // Get all tables.
      if (mysql_query (g_my_conn, "SHOW TABLES"))
	{
	  fprintf (stderr, "Error: db_func.c: %s\n", mysql_error (g_my_conn));
	  res = 1;
	}
      else if (!(g_tableres = mysql_store_result (g_my_conn)))
	{
	  fprintf (stderr, "Error: db_func.c: %s\n", mysql_error (g_my_conn));
	  res = 1;
	  g_tableres = NULL;
	}
    }
  else
    {
      res = 1;
    }

  return res;
}

/*******************************************************************************/

struct db_info_table *
db_get_next_info_table ()
{
  struct db_info_table *infotable = NULL;
  MYSQL_RES *fres;
  MYSQL_ROW row;
  MYSQL_FIELD *field;
  unsigned num_fields, i;

  if (g_my_conn != NULL && g_tableres != NULL)
    {
      if (row = mysql_fetch_row (g_tableres))
	{
	  infotable = new_db_info_table ();
	  // Get information field of the table (Args: MySQL data, table name and NULL).
	  if ((fres = mysql_list_fields (g_my_conn, row[0], NULL)) != NULL)
	    {
	      num_fields = mysql_num_fields (fres);
	      // The name of the table.
	      infotable -> name = strdup (row[0]);
	      // Allocated properties space.
	      infotable -> prop = (struct db_property *) malloc (sizeof (struct db_property) *
								 num_fields);
	      infotable -> n_props = num_fields;
	      // For each field... save it information.
	      i = 0;
	      while ((field = mysql_fetch_field (fres)) != NULL)
		{
		  infotable -> prop[i].name = strdup (field -> name);
		  infotable -> prop[i].type = get_type_name (field -> type);
		  infotable -> prop[i].is_pk = is_field_pk (field -> name, row[0]);
		  i++;
		}
	      // Free MYSQL_RES
	      mysql_free_result (fres);

	      // Complete the association information.
	      infotable -> assoc = association_info (row[0], &infotable -> n_assoc);
	    }
	}
    }
  else
    {
      fprintf (stderr, "Error: db_func.c: there is not exist a valid connection or "
	       "did not call db_select_and_load_tables function\n");
    }

  return infotable;
}

/*******************************************************************************/
