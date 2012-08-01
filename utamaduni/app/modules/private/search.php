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
 * search.php
 *
 * This module show the private search web page.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class search extends core_auth_user
{
  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ()
  {
    parent::__construct ();
  }
  // }}}

  // {{{ __destruct ()
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

  // {{{ __search ()
  /**
   * __search
   *
   * This function gets POST and realizes the search.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @return a list of result.
   */
  private function __search ()
  {
    $res = array ();

    // Get POST or GET data.
    // Prepare validation from POST or GET data (the validators objects
    // get the POST or GET automatically).
    $book_validator = new validation_alpha_field ('book',
						  gettext ('The book must consist of letter only'));
    $tag_validator = new validation_alnum_field ('tag',
						 gettext ('The tag must consist of letter only'));
    $author_validator =
      new validation_alpha_field ('author',
				  gettext ('The author must consist of letters only'));
    
    $val_facade = new validation_facade ();
    $val_facade -> add_validator ($book_validator);
    $val_facade -> add_validator ($tag_validator);
    $val_facade -> add_validator ($author_validator);
    
    // Check data in (validation).
    $facade_val_res = $val_facade -> validation ();
    
    // Get clean data.
    $clean = $val_facade -> get_clean_request ();
    
    if ($facade_val_res)
      {
	// Get all books that matches with the title.
	include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_book_mysql_ext_dao.php');
	$dao = new utam_book_mysql_ext_dao ();
	$listbook = $dao -> search (array ('title' => $clean -> get ('book')));

	// Discards books when author or tags not matches.
	foreach ($listbook as $book_object)
	  {
	    $match = true;

	    // If author matches...
	    $aux = $clean -> get ('author');
	    if (!empty ($aux))
	      {
		$pattern = array ('name' => $clean -> get ('author'));
		if (!search_util::is_in_object_array ($book_object -> utam_author, $pattern))
		  $match = false;
	      }

	      // ... and some tag matches insert the book object into result.
	      $aux = $clean -> get ('tag');
	      if (!empty ($aux))
		{
		  $aux = explode (',', $clean -> get ('tag'));
		  foreach ($aux as $tag)
		    {
		      $tag = trim ($tag);
		      $pattern = array ('name' => $tag);
		      if (!search_util::is_in_object_array ($book_object -> utam_subject, $pattern))
			{
			  $match = false;
			  break;
			}
		    }
		}

	      // If matched...
	      if ($match)
		$res[] = $book_object;
	  }
      }
    else // Validation error.
      {
	echo "Error";
      }

    return $res;
  }
  // }}}

  // {{{ search ()
  /**
   * search
   *
   * This function will be ran by model if an event (method) is search
   * in the request and realize the search.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function search ()
  {
    $all_result = array ();
    $ar_paginated = array ();
    $page_navigation = '';

    // Get results.
    $result_list = $this -> __search ();
    if (is_array ($result_list))
      {
	if (count ($result_list) > 0)
	  {
	    foreach ($result_list as $item)
	      {
		$author = array ();
		$tag = array ();
		foreach ($item -> utam_author as $i)
		  $author[] = $i -> name . ' ' . $i -> surname;
		foreach ($item -> utam_subject as $i)
		  $tag[] = $i -> name;
		$all_result[] = array (
			  'href' => "javascript: showbookloader.loadXMLContent ('id=" . $item -> id . "');",
			  'imgid' => 'mini',
			  'imgsrc' => $item -> cover,
			  'book_title' => $item -> title,
			  'author_name' => implode (', ', $author),
			  'tag' => implode (', ', $tag)
			  );
	      }

	    // Paginated.
	    include_once (UT_BASE_PATH . '/modules/helper/paginated/paginated.php');
	    include_once (UT_BASE_PATH . '/modules/helper/paginated/ajax_trailing_layout.php');
	    $page = 1;
	    $page_validator = new validation_digit_field ('page',
				  gettext ('The page must consist of numbers only'));
	    $val_facade = new validation_facade ();
	    $val_facade -> add_validator ($page_validator);
	    if ($val_facade -> validation ())
	      {
		$clean = $val_facade -> get_clean_request ();
		$page = $clean -> get ('page');
	      }
	    $page_results = new paginated ($all_result, 10, $page);
	    while ($row = $page_results -> fetch_paged_row ()) 
	      {
		$ar_paginated[] = $row;
	      }
	    $page_results -> set_layout (new ajax_trailing_layout ());
	    $page_navigation = $page_results -> fetch_paged_navigation ('searchresultloader');
	  }
      }
      
    // Get the search template.
    $tpl_search = file_get_contents (UT_HTML_TPL_PATH . '/searchlist.html');
    
    // Sets all datas.
    $this -> set ('private_menu', '');
    $this -> set ('search_form', $tpl_search); // After that, include all its sets.
    $this -> set ('all_result', $ar_paginated);
    $this -> set ('page_navigation', $page_navigation);
  }
  // }}}

  // {{{ __default ()
  /**
   * __default
   *
   * This function will be ran by model if an event (method) is not specified
   * in the request and show the form.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __default ()
  {
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();

    // Get the search template.
    $tpl_search = file_get_contents (UT_HTML_TPL_PATH . '/searchform.html');

    // Sets all datas.
    $this -> set ('private_menu', $private_menu -> get_menu ('search'));
    $this -> set ('search_form', $tpl_search); // After that, include all its sets.
    $this -> set ('search_header', gettext ('Search'));
    $this -> set ('book_label', gettext ('Title'));
    $this -> set ('book_len', '100');
    $this -> set ('tag_label', gettext ('Subject'));
    $this -> set ('tag_len', '100');
    $this -> set ('author_label', gettext ('Author'));
    $this -> set ('author_len', '100');
    $this -> set ('cancel_btn', gettext ('Cancel'));
    $this -> set ('search_btn', gettext ('Search1'));
  }
  // }}}
}

?>