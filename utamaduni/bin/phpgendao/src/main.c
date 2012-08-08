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
#include <stdlib.h>
#include <getopt.h>

#include "db_func.h"
#include "php_func.h"

/*******************************************************************************/

void
show_help (char *name)
{
  printf ("Usage: %s [options]\nOptions:\n\t-c [--host]\tDatabase host\n", name);
  printf ("\t-d [--database]\tDatabase name\n");
  printf ("\t-u [--user]\tDatabase user\n\t-p [--password]\tDatabase password\n");
  printf ("\t-h [--help]\tDisplay this information\n\n");
  
  printf ("Román Ginés Martínez Ferrández <romangines@riseup.net>\n");
}

/*******************************************************************************/

int
main (int argc, char **argv)
{
  int result = 0, i, option_index = 0;
  char *host = NULL, *db = NULL, *user = NULL, *pass = NULL, c;
  struct db_info_table *infotable;
  static struct option long_options[] =
    {
      {"host", required_argument, 0, 'c'},
      {"database", required_argument, 0, 'd'},
      {"user", required_argument, 0, 'u'},
      {"password", required_argument, 0, 'p'},
      {"help", no_argument, 0, 'h'},
      {0, 0, 0, 0}
    };

  // Check arguments with getopt_long.
  // (http://www.gnu.org/s/libc/manual/html_node/Getopt.html).
  if (argc == 9 || argc == 3)
    {
      do
        {
          c = getopt_long (argc, argv, "c:d:u:p:h", long_options, &option_index);
          switch (c)
            {
            case 'c':
              host = optarg;
              break;
            case 'd':
              db = optarg;
              break;
            case 'u':
              user = optarg;
              break;
            case 'p':
              pass = optarg;
              break;
            case 'h':
              show_help (argv[0]);
              break;
            case '?':
              /* getopt_long already printed an error message. */
              result = 1;
              show_help (argv[0]);
              break;
            default:
              if (c != -1)
                abort ();
              break;
            }
        }
      while (c != -1);
    }
  else
    {
      result = 1;
      show_help (argv[0]);
    }

  // If check arguments is ok... continue.
  if (!result)
    {
      // Connect to db.
      if (!db_connect (host, db, user, pass))
	{
	  // Select the tables (if ok it returns 0).
	  if (!db_select_and_load_tables ())
	    {
	      // For each table generate all PHP needed files.
	      if (system ("mkdir ../generated") || system ("mkdir ../generated/dto") ||
		  system ("mkdir ../generated/dao") || system ("mkdir ../generated/mysql") ||
		  system ("mkdir ../generated/mysql/ext"))
		{
		  fprintf (stderr, "Error: main.c: cannot creates folders\n");
		  result = 1;
		}
	      else
		{
		  while (infotable = db_get_next_info_table ())
		    {
		      php_generate_domain_class (infotable, "../generated/dto/");
		      php_generate_dao_class (infotable, "../generated/dao/");
		      php_generate_mysql_dao_class (infotable, "../generated/mysql/");
		      php_generate_mysql_dao_extra_class (infotable, 
							  "../generated/mysql/ext/");
		      
		      // Free the table.
		      free (infotable);
		    }
		  php_copy_static_files ("template", "../generated/mysql/core/");
		}
	    }
	  // Database disconnect.
	  db_disconnect ();
	}
      else
	{
	  fprintf (stderr, "%s: database connect fail.\n", argv[0]);
	  result = 1;
	}
    }

  return result;
}

/*******************************************************************************/
