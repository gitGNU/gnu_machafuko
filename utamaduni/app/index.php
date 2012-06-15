<?php
/*
 * Utamaduni (suajili language meaning 'culture') is a book management.
 * Copyright (C) 2012 Román Ginés Martínez Ferrández <rgmf@riseup.net>
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
 * index.php
 *
 * This source is based on the article Joe Smith:
 * http://oreilly.com/pub/a/php/archive/mvc-intro.html?page=1
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */

require_once ("config.php");

/**
 * Set locale.
 */
if (isset ($_GET['lan']))
  {
    switch ($_GET['lan'])
      {
      case 'es':
	$lan = 'es_ES.utf8';
	break;
      case 'en':
	$lan = 'en_GB.utf8';
	break;
      default:
	$lan = 'es_ES.utf8';
	break;
      }
  }
else
  {
    $lan = 'es_ES.utf8';
  }

// Defines language.
putenv ('LAN=$lan');
setlocale (LC_ALL, $lan);

// Defines the directory location.
bindtextdomain ('messages', UT_LOCALE_DIR);
textdomain ('messages');

/**
 * This function (__autoload) is ran by PHP when cannot find a class it is
 * trying to load.
 *
 * @author Román Ginés Martíne Ferrández <rgmf@riseup.net>
 * @param string $class Class name we are trying to load.
 * @return void
 */
function __autoload ($class)
{
  //echo "CLASE: '" . $class . "'\tFICHERO: '";
  $file = str_replace ('_', '/', $class) . '.php';
  //$file = str_replace ('_', '/', substr ($class, 4)) . '.php';
  //echo $file . "'<br/><br/>";
  require_once (UT_BASE_PATH . '/include/' . $file);
}

// The index.php is the controller and it may be called:
// index.php?module=a_module&event=a_event&class=a_class
// For example:
// - index.php?module=foo&event=bar, call foo::bar()
// - index.php?module=dir&class=foo&event=bar, call bar method,
// of the foo class into dir directory.
if (isset ($_GET['module']))
  {
    $module = $_GET['module'];    
    if (isset ($_GET['event']))
      {
	$event = $_GET['event'];
      }
    else
      {
	$event = '__default';
      }

    if (isset ($_GET['class']))
      {
	$class = $_GET['class'];
      }
    else
      {
	$class = $module;
      }

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
			echo $presenter -> render ();
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
else
  {
    die (gettext ("A valid module was not specified."));
  }

?>