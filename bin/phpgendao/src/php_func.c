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

#include "php_func.h"

/*******************************************************************************/

void
php_write_gpl_license (FILE *f)
{
  if (f)
    fprintf (f, "/*\n"
	     " Copyright 2011 Román Ginés Martínez Ferrández <romangines@riseup.net>\n"
	     "\n"
	     " This file is part of phpgendao.\n"
	     "\n"
	     " phpgendao is free software: you can redistribute it and/or modify\n"
	     " it under the terms of the GNU General Public License as published by\n"
	     " the Free Software Foundation, either version 3 of the License, or\n"
	     " (at your option) any later version.\n"
	     "\n"
	     " phpgendao is distributed in the hope that it will be useful,\n"
	     " but WITHOUT ANY WARRANTY; without even the implied warranty of\n"
	     " MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n"
	     " GNU General Public License for more details.\n"
	     "\n"
	     " You should have received a copy of the GNU General Public License\n"
	     " along with Foobar.  If not, see <http://www.gnu.org/licenses/>.\n"
	     " */\n");
  else
    fprintf (stderr, "Error: php_func.c: the FILE is not valid\n");
}

/*******************************************************************************/

static char *
has_parent (struct db_info_table *t)
{
  int i;
  char *pk = NULL;
  char *res = NULL;
  
  if (t != NULL)
    {
      // It looks for the primar key field name.
      for (i = 0; i < t -> n_props; i++)
	if (t -> prop[i].is_pk)
	  {
	    pk = t -> prop[i].name;
	    break;
	  }

      // Is the primary key a foreign key? If it is, return the referenced table name.
      for (i = 0; i < t -> n_assoc; i++)
	if (!strcmp (pk, t -> assoc[i].key[0]) &&
	    !strcmp (t -> assoc[i].type, "many-to-one"))
	  {
	    res = strdup (t -> assoc[i].table);
	    return res;
	  }
    }

  return res;
}

/*******************************************************************************/

static char *
is_a_reference (struct db_info_table *t, char *prop)
{
  int i;
  char *res = NULL;

  if (t != NULL && prop != NULL)
    {
      for (i = 0; i < t -> n_assoc; i++)
	if (!strcmp (t -> assoc[i].key[0], prop) && 
	    !strcmp (t -> assoc[i].type, "many-to-one"))
	  {
	    res = strdup (t -> assoc[i].table);
	    return res;
	  }
    }

  return res;
}

/*******************************************************************************/

void
php_generate_domain_class (struct db_info_table *infotable, char *dir)
{
  FILE *fd = NULL;
  int i;
  char file[100];
  char *parent = NULL, *ref = NULL, *extends = NULL;

  if (infotable == NULL)
    {
      fprintf (stderr, "Error: php_func.c: there are problems with data struct.\n");
    }
  else if (infotable -> name == NULL || infotable -> prop == NULL)
    {
      fprintf (stderr, "Error: php_func.c: there are problems with data struct.\n");
    }
  else
    {
      strcpy ((char *) file, dir);
      strcat ((char *) file, infotable -> name);
      strcat ((char *) file, ".php");
      if (!(fd = fopen (file, "w")))
	{
	  fprintf (stderr, "Error: php_func.c: can not create the dto file '%s'.\n", file);
	}
      else
	{
	  fprintf (fd, "<?php\n");
	  php_write_gpl_license (fd);

	  // Is there inheritance?
	  if ((parent = has_parent (infotable)) != NULL)
	    {
	      fprintf (fd, "\ninclude_once ('%s.php');\n", parent);
	      extends = (char *) malloc (sizeof (char) * 100);
	      strcpy (extends, " extends ");
	      strcat (extends, parent);
	    }
	  else
	    {
	      extends = (char *) malloc (sizeof (char));
	      extends[0] = '\0';
	    }
	  // End is there inheritance?

	  fprintf (fd, "\n/**\n * Object represents table '");
	  fprintf (fd, "%s", infotable -> name);
	  fprintf (fd, "'\n *\n * @author: Román Ginés Martínez Ferrández "
		   "<romangines@riseup.net>\n */\nclass ");
	  fprintf (fd, "%s%s", infotable -> name, extends);
	  fprintf (fd, "\n{\n");
	  for (i = 0; i < infotable -> n_props; i++)
	    {
	      if (infotable -> prop[i].name != NULL)
		{
		  // The property can be a foreign key (in this case will be a object).
		  if (!infotable -> prop[i].is_pk & 
		      (ref = is_a_reference (infotable, infotable -> prop[i].name)) != NULL)
		    {
		      fprintf (fd, "\tvar $%s; // It is a object.\n", ref);
		      free (ref);
		    }
		  else
		    fprintf (fd, "\tvar $%s;\n", infotable -> prop[i].name);
		}
	      else
		fprintf (stderr, "Error: php_func.c: there is a problem with a property\n");
	    }
	  
	  //for (i = 0; i < infotable -> n_assoc; i++)
	  //printf ("Table: %s, assoc table: %s, type assoc: %s, key: %s\n",
	  //	    infotable -> name, infotable -> assoc[i].table,
	  //	    infotable -> assoc[i].type, infotable -> assoc[i].key[0]);

	  // If there was inheritance it has must be a property object.
	  if (parent != NULL)
	    fprintf (fd, "\tvar $%s; // It is a object.\n", parent);
	  // End if there was inheritance it has must be a property object.

	  fprintf (fd, "}\n?>");
	  
	  // Close the file.
	  fclose (fd);
	}
    }

  if (extends != NULL)
    free (extends);
}

/*******************************************************************************/

void
php_generate_dao_class (struct db_info_table *infotable, char *dir)
{
  FILE *fd;
  int i;
  char file[100];

  if (infotable == NULL)
    {
      fprintf (stderr, "Error: php_func.c: there are problems with data struct.\n");
    }
  else if (infotable -> name == NULL || infotable -> prop == NULL)
    {
      fprintf (stderr, "Error: php_func.c: there are problems with data struct.\n");
    }
  else
    {
      strcpy ((char *) file, dir);
      strcat ((char *) file, infotable -> name);
      strcat ((char *) file, "_dao.php");
      if (!(fd = fopen (file, "w")))
	{
	  fprintf (stderr, "Error: php_func.c: can not create the dao file '%s'.\n", file);
	}
      else
	{
	  fprintf (fd, "<?php\n");
	  php_write_gpl_license (fd);
	  fprintf (fd, "\n/**\n * Interface DAO.\n *\n * "
		   "@author: Román Ginés Martínez Ferrández <romangines@riseup.net>\n */\n"
		   "interface %s_dao\n{\n"

		   "\t/**\n\t * Get domain object by primary key.\n"
		   "\t *\n\t * @param String $id primary key.\n"
		   "\t * @return %s.\n\t */\n"
		   "\tpublic function load ($id);\n\n"
		   
		   "\t/**\n\t * Get all records from table.\n\t */\n"
		   "\tpublic function query_all ();\n\n"

		   "\t/**\n\t * Get all records from table ordered by field.\n"
		   "\t *\n\t * @param String $order_col column name.\n"
		   "\t */\n"
		   "\tpublic function query_all_order_by ($order_col);\n\n"

		   "\t/**\n\t * Delete record from table.\n\t *\n\t *"
		   " @param String $id primary key.\n"
		   "\t */\n"
		   "\tpublic function delete ($id);\n\n"

		   "\t/**\n\t * Insert record to table.\n\t *\n\t *"
		   " @param %s $%s.\n\t */\n"
		   "\tpublic function insert ($%s);\n\n"

		   "\t/**\n\t * Update record in table.\n\t *\n\t *"
		   " @param %s $%s.\n\t */\n"
		   "\tpublic function update ($%s);\n\n"

		   "\t/**\n\t * Delete all rows.\n\t */\n"
		   "\tpublic function clean ();\n\n"

		   "\t/**\n\t * Queries and deletes.\n\t */\n", infotable -> name, 
		   infotable -> name, infotable -> name, infotable -> name,
		   infotable -> name, infotable -> name, infotable -> name,
		   infotable -> name);

	  for (i = 0; i < infotable -> n_props; i++)
	    {
	      if (infotable -> prop[i].name != NULL)
		fprintf (fd, "\tpublic function query_by_%s ($value);\n"
			 "\tpublic function delete_by_%s ($value);\n\n",
			 infotable -> prop[i].name, infotable -> prop[i].name);
	      else
		fprintf (stderr, "Error: php_func.c: there is a problem with a property.\n");
	    }
	  fprintf (fd, "}\n?>");

	  // Close the file.
	  fclose (fd);
	}
    }
}

/*******************************************************************************/

void
php_generate_mysql_dao_class (struct db_info_table *infotable, char *dir)
{
  FILE *fd;
  int i, count, first;
  char file[100], insert_names[500], insert_values[200], sets[1000];
  char update[500], readrow[500];
  char from[500], where[500];
  char *parent_table = NULL;

  if (infotable == NULL)
    {
      fprintf (stderr, "Error: php_func.c: there are problems with data struct.\n");
    }
  else if (infotable -> name == NULL || infotable -> prop == NULL)
    {
      fprintf (stderr, "Error: php_func.c: there are problems with data struct.\n");
    }
  else
    {
      strcpy ((char *) file, dir);
      strcat ((char *) file, infotable -> name);
      strcat ((char *) file, "_mysql_dao.php");
      if (!(fd = fopen (file, "w")))
	{
	  fprintf (stderr, "Error: php_func.c: can not create the extension dao file '%s'.\n",
		   file);
	}
      else
	{
	  // Prepare the FROM and the WHERE part of the SELECTs.
	  if ((parent_table = has_parent (infotable)) != NULL)
	    {
	      strcpy ((char *) from, ", ");
	      strcat ((char *) from, parent_table);
	      strcat ((char *) from, " b");
	      strcpy ((char *) where, "and a.id = b.id");
	    }
	  else
	    {
	      from[0] = '\0';
	      where[0] = '\0';
	    }

	  // Write into file.
	  fprintf (fd, "<?php\n");
	  php_write_gpl_license (fd);
	  fprintf (fd, "\ninclude_once (dirname (__FILE__) . '/../dao/%s_dao.php');"
		   "\ninclude_once (dirname (__FILE__) . '/core/array_list.php');"
		   "\ninclude_once (dirname (__FILE__) . '/core/sql_query.php');"
		   "\ninclude_once (dirname (__FILE__) . '/core/query_executor.php');"
		   "\ninclude_once (dirname (__FILE__) . '/core/transaction.php');\n"
		   "\n/**\n * Class that operate on table '%s'. Database MySQL.\n"
		   " *\n * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>\n"
		   " */\n"

		   "class %s_mysql_dao implements %s_dao\n"
		   "{\n"
		   
		   "\t/**\n\t * Get domain object by primary key.\n\t *\n"
		   "\t * @param String $id primary key.\n"
		   "\t * @return %s_mysql.\n"
		   "\t */\n"
		   "\tpublic function load ($id)\n"
		   "\t{\n"
		   "\t\t$sql = 'SELECT * FROM %s a%s WHERE a.id = ? %s';\n"
		   "\t\t$query = new sql_query ($sql);\n"
		   "\t\t$query -> set_number ($id);\n"
		   "\t\treturn $this -> get_row ($query);\n"
		   "\t}\n\n"

		   "\t/**\n"
		   "\t * Get all records from table.\n\t */\n"
		   "\tpublic function query_all ()\n"
		   "\t{\n"
		   "\t\t$sql = 'SELECT * FROM %s a%s WHERE 0 = 0 %s';\n"
		   "\t\t$query = new sql_query ($sql);\n"
		   "\t\treturn $this -> get_list ($query);\n"
		   "\t}\n\n"

		   "\t/**\n"
		   "\t * Get all records from table ordered by field.\n\t *\n"
		   "\t * @param $order_col column name.\n\t */\n"
		   "\tpublic function query_all_order_by ($order_col)\n\t {\n"
		   "\t\t$sql = 'SELECT * FROM %s a%s WHERE 0 = 0 %s ORDER BY ' . $order_col;\n"
		   "\t\t$query = new sql_query ($sql);\n"
		   "\t\treturn $this -> get_list ($query);\n"
		   "\t}\n\n"

		   "\t/**\n"
		   "\t * Delete record from table.\n\t *\n"
		   "\t * @param String $id %s primary key\n\t */\n"
		   "\tpublic function delete ($id)\n\t{\n"
		   "\t\t$sql = 'DELETE FROM %s WHERE id = ?';\n"
		   "\t\t$query = new sql_query ($sql);\n"
		   "\t\t$query -> set_number ($id);\n"
		   "\t\treturn $this -> execute_update ($query);\n"
		   "\t}\n\n"

		   "\t/**\n"
		   "\t * Queries and deletes by column.\n\t */\n"

		   , infotable -> name, infotable -> name, 
		   infotable -> name, infotable -> name, infotable -> name, 
		   infotable -> name, from, where, infotable -> name, from, where,
		   infotable -> name, from, where, infotable -> name, infotable -> name);

	  // Write, into file, the queries and deletes and prepare insert and update.
	  strcpy ((char *) insert_names, "(");
	  strcpy ((char *) insert_values, "VALUES (");
	  strcpy ((char *) update, "SET ");
	  strcpy ((char *) sets, "");
	  strcpy ((char *) readrow, "");
	  for (i = 0; i < infotable -> n_props - 1; i++)
	    {
	      strcat ((char *) insert_names,  infotable -> prop[i].name);
	      strcat ((char *) insert_names, ", ");

	      strcat ((char *) insert_values, "?, ");

	      strcat ((char *) update, infotable -> prop[i].name);
	      strcat ((char *) update, " = ?, ");

	      strcat ((char *) sets, "\t\t$query -> set ($");
	      strcat ((char *) sets, infotable -> name);
	      strcat ((char *) sets, " -> ");
	      strcat ((char *) sets, infotable -> prop[i].name);
	      strcat ((char *) sets, ");\n");

	      strcat ((char *) readrow, "\t\t$");
	      strcat ((char *) readrow, infotable -> name);
	      strcat ((char *) readrow, " -> ");
	      strcat ((char *) readrow, infotable -> prop[i].name);
	      strcat ((char *) readrow, " = $row['");
	      strcat ((char *) readrow, infotable -> prop[i].name);
	      strcat ((char *) readrow, "'];\n");

	      // Write into file.
	      fprintf (fd, "\tpublic function query_by_%s ($value)\n\t{\n"
		       "\t\t$sql = 'SELECT * FROM %s a%s WHERE %s = ? %s';\n"
		       "\t\t$query = new sql_query ($sql);\n"
		       "\t\t$query -> set ($value);\n"
		       "\t\treturn $this -> get_list ($query);\n"
		       "\t}\n\n"

		       "\tpublic function delete_by_%s ($value)\n\t{\n"
		       "\t\t$sql = 'DELETE FROM %s WHERE %s = ?';\n"
		       "\t\t$query = new sql_query ($sql);\n"
		       "\t\t$query -> set ($value);\n"
		       "\t\treturn $this -> execute_update ($query);\n"
		       "\t}\n\n"

		       , infotable -> prop[i].name, infotable -> name, from,
		       infotable -> prop[i].name, where, infotable -> prop[i].name,
		       infotable -> name, infotable -> prop[i].name);
	    }
	  strcat ((char *) insert_names, infotable -> prop[infotable -> n_props - 1].name);
	  strcat ((char *) insert_names, ")");

	  strcat ((char *) insert_values, "?)");

	  strcat ((char *) update, infotable -> prop[infotable -> n_props - 1].name);
	  strcat ((char *) update, " = ?");

	  strcat ((char *) sets, "\t\t$query -> set ($");
	  strcat ((char *) sets, infotable -> name);
	  strcat ((char *) sets, " -> ");
	  strcat ((char *) sets, infotable -> prop[infotable -> n_props - 1].name);
	  strcat ((char *) sets, ");\n");

	  strcat ((char *) readrow, "\t\t$");
	  strcat ((char *) readrow, infotable -> name);
	  strcat ((char *) readrow, " -> ");
	  strcat ((char *) readrow, infotable -> prop[infotable -> n_props - 1].name);
	  strcat ((char *) readrow, " = $row['");
	  strcat ((char *) readrow, infotable -> prop[infotable -> n_props - 1].name);
	  strcat ((char *) readrow, "'];\n");

	  // Write last query, delete, etc, into file.
	  fprintf (fd, "\tpublic function query_by_%s ($value)\n\t{\n"
		   "\t\t$sql = 'SELECT * FROM %s WHERE %s = ?';\n"
		   "\t\t$query = new sql_query ($sql);\n"
		   "\t\t$query -> set ($value);\n"
		   "\t\treturn $this -> get_list ($query);\n"
		   "\t}\n\n"
		   
		   "\tpublic function delete_by_%s ($value)\n\t{\n"
		   "\t\t$sql = 'DELETE FROM %s WHERE %s = ?';\n"
		   "\t\t$query = new sql_query ($sql);\n"
		   "\t\t$query -> set ($value);\n"
		   "\t\treturn $this -> execute_update ($query);\n"
		   "\t}\n\n"
		   
		   , infotable -> prop[infotable -> n_props - 1].name, infotable -> name,
		   infotable -> prop[infotable -> n_props - 1].name, 
		   infotable -> prop[infotable -> n_props - 1].name,
		   infotable -> name, infotable -> prop[infotable -> n_props - 1].name);
	  
	  // Write the insert and update.
	  fprintf (fd, "\t/**\n"
		   "\t * Insert record to table.\n\t *\n"
		   "\t * @param %s_mysql %s.\n\t */\n"
		   "\tpublic function insert ($%s)\n\t{\n"
		   "\t\t$sql = 'INSERT INTO %s %s %s';\n"
		   "\t\t$query = new sql_query ($sql);\n\n"
		   "%s\n"
		   "\t\t$id = $this -> execute_insert ($query);\n"
		   "\t\t$%s -> id = $id;\n"
		   "\t\treturn $id;\n"
		   "\t}\n\n"

		   "\t/**\n"
		   "\t * Update record in table.\n"
		   "\t *\n\t * @param %s_mysql %s\n\t */\n"
		   "\tpublic function update ($%s)\n\t{\n"
		   "\t\t$sql = 'UPDATE %s %s WHERE id = ?';\n"
		   "\t\t$query = new sql_query ($sql);\n\n"
		   "%s\n"
		   "\t\t$query -> set_number ($%s -> id);\n"
		   "\t\treturn $this -> execute_query ($query);\n"
		   "\t}\n\n"

		   "\t/**\n"
		   "\t * Delete all rows.\n\t */\n"
		   "\tpublic function clean ()\n\t{\n"
		   "\t\t$sql = 'DELETE FROM %s';\n"
		   "\t\t$query = new sql_query ($sql);\n"
		   "\t\treturn $this -> execute_update ($query);\n"
		   "\t}\n\n"

		   "\t/**\n"
		   "\t * Read row.\n\t *\n"
		   "\t * @return %s_mysql\n\t */\n"
		   "\tprotected function read_row ($row)\n\t{\n"
		   "\t\t$%s = new %s ();\n\n"
		   "%s\n"
		   "\t\treturn $%s;\n"
		   "\t}\n\n"

		   "\tprotected function get_list ($query)\n\t{\n"
		   "\t\t$tab = query_executor::execute ($query);\n"
		   "\t\t$ret = array ();\n"
		   "\t\tfor ($i = 0; $i < count ($tab); $i++)\n\t\t{\n"
		   "\t\t\t$ret[$i] = $this -> read_row ($tab[$i]);\n\t\t}\n"
		   "\t\treturn $ret;\n"
		   "\t}\n\n"

		   "\t/**\n\t * Get row.\n\t *\n\t * @return %s_mysql.\n\t */\n"
		   "\tprotected function get_row ($query)\n\t{\n"
		   "\t\t$tab = query_executor::execute ($query);\n"
		   "\t\tif (count ($tab) == 0)\n\t\t{\n"
		   "\t\t\treturn null;\n\t\t}\n"
		   "\t\treturn $this -> read_row ($tab[0]);\n"
		   "\t}\n\n"

		   "\t/**\n\t * Execute sql query.\n"
		   "\t */\n"
		   "\tprotected function execute ($query)\n\t{\n"
		   "\t\treturn query_executor::execute ($query);\n"
		   "\t}\n\n"

		   "\t/**\n\t * Execute sql query.\n"
		   "\t */\n"
		   "\tprotected function execute_update ($query)\n\t{\n"
		   "\t\t return query_executor::execute_update ($query);\n"
		   "\t}\n\n"

		   "\t/**\n\t * Query for one row and one column.\n"
		   "\t */\n"
		   "\tprotected function query_single_result ($query)\n\t{\n"
		   "\t\treturn query_executor::query_for_string ($query);\n"
		   "\t}\n\n"

		   "\t/**\n\t * Insert row to table.\n"
		   "\t */\n"
		   "\tprotected function execute_insert ($query)\n\t{\n"
		   "\t\treturn query_executor::execute_insert ($query);\n"
		   "\t}\n}\n?>"

		   , infotable -> name, 
		   infotable -> name, infotable -> name, infotable -> name, 
		   insert_names, insert_values, sets, infotable -> name,
		   infotable -> name, infotable -> name, infotable -> name,
                   infotable -> name, update, sets, infotable -> name,
		   infotable -> name, infotable -> name, infotable -> name,
		   infotable -> name, readrow,
		   infotable -> name, infotable -> name);

	  // Close the file.
	  fclose (fd);
	}
    }

  if (parent_table != NULL)
    free (parent_table);
}

/*******************************************************************************/

void
php_generate_mysql_dao_extra_class (struct db_info_table *infotable, char *dir)
{
  FILE *fd;
  int i;
  char file[100];

  if (infotable == NULL)
    {

      fprintf (stderr, "Error: php_func.c: there are problems with data struct.\n");
    }
  else if (infotable -> name == NULL || infotable -> prop == NULL)
    {
      fprintf (stderr, "Error: php_func.c: there are problems with data struct.\n");
    }
  else
    {
      strcpy ((char *) file, dir);
      strcat ((char *) file, infotable -> name);
      strcat ((char *) file, "_mysql_ext_dao.php");
      if (!(fd = fopen (file, "w")))
	{
	  fprintf (stderr, "Error: php_func.c: can not create the extension dao file '%s'.\n",
		   file);
	}
      else
	{
	  fprintf (fd, "<?php\n");
	  php_write_gpl_license (fd);
	  fprintf (fd, "\n/**\n * Class that operate on table '%s'. Database MySQL.\n"
		   " *\n * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>\n"
		   " */\nclass %s_mysql_ext_dao extends %s_mysql_dao\n{\n\n}\n?>",
		   infotable -> name, infotable -> name, infotable -> name);
	  // Close the file.
	  fclose (fd);
	}
    }
}

/*******************************************************************************/

void
php_copy_static_files (char *from_dir, char *to_dir)
{
  char cmd[500];

  strcpy ((char *) cmd, "cp -r ");
  strcat ((char *) cmd, from_dir);
  strcat ((char *) cmd, " ");
  strcat ((char *) cmd, to_dir);

  if (system (cmd))
    {
      fprintf (stderr, "Error: php_func.c: cannot copy PHP static files from '%s'"
	       " to '%s'.\n", from_dir, to_dir);
    }
}

/*******************************************************************************/
