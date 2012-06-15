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
 * html.php
 *
 * By default we use a html with marks to write dynamic content as our 
 * presentation (view) layer.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class core_presenter_html extends core_presenter_base
{
  // {{{ __construct ()
  /**
   * construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct (core_module $module)
  {
    parent::__construct ($module);
  }
  // }}}

  // {{{ __desctruct ()
  /**
   * __destruct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __destruct ()
  {
    parent::__destruct ();
  }
  // }}}

  // {{{ get_loop_content ($loop, $file)
  /**
   * get_loop_content
   *
   * Return the content from '{{$loop' to '}}' on $file.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $loop the tag later '{{'.
   * @param string $file the content of the file when should b the '{{$lopp'.
   * @return the content or empty string if not exists '{{$loop'.
   */
  private function get_loop_content ($loop, $file)
  {
    $first = false;
    $len = strlen ($loop);
    $readed = '';
    
    // Find the substring '{{$loop' on $file.
    for ($i = 0; $i < strlen ($file); $i++)
      {
	if ($file[$i] == '{')
	  {
	    if ($first)
	      {
		if (strlen ($file) - $i >= $len)
		  {
		    for ($j = 1; $j <= $len; $j++)
		      {
			$readed .= $file[$i + $j];
		      }
		    
		    if (!strcmp ($readed, $loop))
		      {
			$i += $j;
			break;
		      }
		    else
		      {
			$readed = '';
		      }
		    
		    $first = false;
		  }
	      }
	    else
	      {
		$first = true;
	      }
	  }
	else
	  {
	    $first = false;
	  }
      }
    
    // Get all content from '{{$loop' to '}}'.
    $readed = '';
    $exit = false;
    while (!$exit && $i < strlen ($file))
      {
	if ($file[$i] == '}' && $i < (strlen ($file) + 1))
	  {
	    if ($file[$i + 1] == '}')
	      $exit = true;
	    else
	      {
		$readed .= $file[$i];
	      }
	  }
	else
	  {
	    $readed .= $file[$i];
	  }
	
	$i++;
      }
    
    return $readed;
  }
  // }}}

  // {{{ render ()
  /**
   * render
   *
   * This function render the html template. Before change the '{<var>}' tag with
   * values.
   *
   * This function work with arrays. In this case you must insert into your templates
   * these options:
   * - {{tag}} for simples arrays.
   * - {{tag<li><a href={href}>{another_tag}</li>}} for arrays of arrays. In this case:
   *      array (tag => array (href => value1, another_tag => value2))
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function render ()
  {
    $str = '';
    $pattern = '';
    $tpl_path = UT_BASE_PATH . '/modules/' . $this -> module -> module_name . '/tpl/';
    $tpl_file_name = $this -> module -> tpl_name;
    $tpl_file = file_get_contents ($tpl_path . $tpl_file_name);

    foreach ($this -> module -> get_data () as $var => $val)
      {
	// Is a array or not?
	if (is_array ($val))
	  {
	    $pattern = $this -> get_loop_content ($var, $tpl_file);
	    $var = '{' . $var . $pattern . '}';
	    foreach ($val as $substr)
	      {
		if (is_array ($substr))
		  {
		    $pattern_aux = $pattern;
		    foreach ($substr as $idx => $v)
		      {
			$pattern_aux = str_replace ('{' . $idx . '}', $v, $pattern_aux);
		      }
		    $str .= $pattern_aux;
		  }
		else
		  $str .= $substr;
	      }
	  }
	else
	  $str = $val;

	$tpl_file = str_replace ('{' . $var . '}', $str, $tpl_file);
	$str = ''; // prepare the next iteration.
      }

    return $tpl_file;
  }
  // }}}
}

?>