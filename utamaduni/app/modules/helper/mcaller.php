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

class mcaller
{
  static public function call_module ($module, $event = '__default', $class = null)
  {
    if ($class === null)
      $class = $module;

    $class_file = UT_BASE_PATH . '/modules/' . $module . '/' . $class . '.php';
    if (file_exists ($class_file))
      {
	require_once ($class_file);
	if (class_exists ($class))
	  {
	    try
	      {
		$instance = new $class ();
		if (!core_module::is_valid ($instance))
		  {
		    die (gettext ("Requested module is not a valid module."));
		  }

		$instance -> module_name = $module;
		if ($instance -> authenticate ())
		  {
		    try
		      {
			$instance -> $event ();
			$presenter = core_presenter::factory ($instance -> presenter,
							      $instance);
			return $presenter -> render ();
			
		      }
		    catch (Exception $e)
		      {
			die ($e -> getMessage ());
		      }
		  }
		else
		  {
		    die (gettext ("You do not have access to the requested page."));
		  }
	      }
	    catch (Exception $e)
	      {
		die ($e -> getMessage ());
	      }
	  }
	else
	  {
	    die (gettext ("An valid module for your request was not found."));
	  }
      }
    else
      {
	die (gettext ("Could not find") . ": $class_file.");
      }
  }
}

?>