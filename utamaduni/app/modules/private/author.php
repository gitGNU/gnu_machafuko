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
 * author.php
 *
 * This module show the private author web page.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class author extends core_auth_user
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

  // {{{ __get_author ()
  /**
   * __get_author
   *
   * Get author information and returns it or null if there is any error or
   * not exist that author.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  private function __get_author ()
  {
    $utam_author = null;

    // Get POST or GET data.
    // Prepare validation from POST or GET data (the validators objects
    // get the POST or GET automatically).
    $id_validator = new validation_digit_field ('id',
						gettext ('Invalid identifier'));
    $val_facade = new validation_facade ();
    $val_facade -> add_validator ($id_validator);
    if ($val_facade -> validation ())
      {
	$clean = $val_facade -> get_clean_request ();

	include_once (UT_BASE_PATH . '/include/db/mysql/utam_author_mysql_dao.php');
	$dao = new utam_author_mysql_dao ();
	$utam_author = new utam_author ();
	$utam_author = $dao -> load ($clean -> get ('id'));
      }

    return $utam_author;
  }
  // }}}

  // {{{ update ()
  /**
   * update
   *
   * This function will be ran by model if an event is "update".
   *
   * This function will insert a new author or, if there is GET or POST data, update a
   * existing author.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function update ()
  {
    $msg = array ();
    $href = '';
    $link = '';
    $msg_file = '';

    // Get POST or GET data.
    // Prepare validation from POST or GET data (the validators objects
    // get the POST or GET automatically).
    $name_validator =
      new validation_alpha_field ('name',
				  gettext ('The name must consist of letters only'));
    $surname_validator =
      new validation_alpha_field ('surname',
				  gettext ('The surname must consist of letters only'));
    
    $val_facade = new validation_facade ();
    $val_facade -> add_validator ($name_validator);
    $val_facade -> add_validator ($surname_validator);
    
    // Check data in (validation).
    $facade_val_res = $val_facade -> validation ();
    
    // Get clean data.
    $clean = $val_facade -> get_clean_request ();
    
    if ($facade_val_res)
      {
	try
	  {
	    // Open a transaction.
	    include_once (UT_BASE_PATH . '/include/db/mysql/core/transaction.php');
	    $transaction = new transaction ();

	    // Insert the author.
	    include_once (UT_BASE_PATH . '/include/db/mysql/utam_author_mysql_dao.php');
	    $dao = new utam_author_mysql_dao ();
	    $utam_author = new utam_author ();
	    $file = new file_phpfiles ('photo', UT_FILES_BASE_PATH . UT_FOLDER_PHOTOS,
				       UT_FILES_LOGICAL_PATH . UT_FOLDER_PHOTOS);
	    $utam_author -> name = $clean -> get ('name');
	    $utam_author -> surname = $clean -> get ('surname');
	    $utam_author -> photo = $file -> get_logical_full_path ();
	    $dao -> insert ($utam_author);

	    // Move the upload photo.
	    if ($file -> move_uploaded_files ())
	      throw new Exception (gettext ('It can not upload the file') . ': ' . 
				   $file -> get_error ());
		    
	    // It prepares the message.
	    $msg_file = file_get_contents (UT_HTML_TPL_PATH . '/ok.html');
	    $msg[] = array ('msg' => gettext ('The author') . ' "' . 
			    $clean -> get ('name') . ' ' . $clean -> get ('surname') .
			    '" ' . gettext ('has inserted'));
	    $href = "javascript: parent.formupdateauthorloader.loadXMLContent ();";
	    $link = gettext ('Continue');
		    
	    // Commit the transaction.
	    $transaction -> commit ();
	  }
	catch (Exception $e)
	  {
	    // If error rollback the transaction and delete the file.
	    $file -> delete ();
	    $transaction -> rollback ();
	    $msg_file = file_get_contents (UT_HTML_TPL_PATH . '/error.html');
	    $msg[] = array ('msg' => $e -> getMessage ());
	    $href = "javascript: parent.authorloader.loadXMLContent ();";
	    $link = gettext ('Leave');
	  }
      }
    else // Validation error.
      {
	foreach ($val_facade -> get_errors () as $err)
	  {
	    $msg[] = array ('msg' => $err);
	  }
	$msg_file = file_get_contents (UT_HTML_TPL_PATH . '/error.html');
	$msg_id = 'error-box';
	$href = "javascript: parent.authorloader.loadXMLContent ();";
	$link = gettext ('Leave');
      }

    $this -> set ('msg_file', $msg_file);
    $this -> set ('messages', $msg);
    $this -> set ('href', $href);
    $this -> set ('link', $link);
    
    // It changes template file name.
    $this -> tpl_name = 'msg.tpl.html';
  }
  // }}}

  // {{{ formupdate ()
  /**
   * formupdate
   *
   * This function will be ran by model if an event is "update".
   *
   * This function show the form to update or insert a author.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function formupdate ()
  {
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();

    // Get the book template.
    $tpl_author = file_get_contents (UT_HTML_TPL_PATH . '/authorform.html');
    $this -> set ('author', $tpl_author);
    $this -> set ('private_menu', $private_menu -> get_menu ('author'));

    // Get the book information (maybe null).
    $utam_author = $this -> __get_author ();

    $this -> set ('author_header', gettext ('Author'));
    $this -> set ('photo_label', gettext ('Photo'));
    $this -> set ('name_label', gettext ('Name'));
    $this -> set ('name', $utam_author ? $utam_author -> name : '');
    $this -> set ('name_len', '30');
    $this -> set ('surname_label', gettext ('Surname'));
    $this -> set ('surname', $utam_author ? $utam_author -> surname : '');
    $this -> set ('surname_len', '50');
    $this -> set ('cancel_btn', gettext ('Cancel'));
    $this -> set ('ok_btn', gettext ('Create'));
  }
  // }}}

  // {{{ __default ()
  /**
   * __default
   *
   * This function will be ran by model if an event (method) is not specified
   * in the request.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __default ()
  {
    include_once (UT_BASE_PATH . '/include/db/mysql/utam_author_mysql_dao.php');
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();
    $all_authors = array ();
    $aa_paginated = array ();
    $page_navigation = '';
    
    // Get all authors.
    $dao = new utam_author_mysql_dao ();
    $author_list = $dao -> query_all ();

    if (is_array ($author_list))
      {
	if (count ($author_list) > 0)
	  {
	    foreach ($author_list as $author)
	      {
		$all_authors[] = array (
			  'href' => $author -> photo,
			  'imgid' => 'mini',
			  'imgsrc' => $author -> photo,
			  'author_title' => $author -> surname . ', ' . $author -> name);
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
	    $page_results = new paginated ($all_authors, 12, $page);
	    while ($row = $page_results -> fetch_paged_row ()) 
	      {
		$aa_paginated[] = $row;
	      }
	    $page_results -> set_layout (new ajax_trailing_layout ());
	    $page_navigation = $page_results -> fetch_paged_navigation ('authorloader');
	  }
      }

    // Get the author template.
    $tpl_author = file_get_contents (UT_HTML_TPL_PATH . '/allauthors.html');

    // Sets all datas.
    $this -> set ('private_menu', $private_menu -> get_menu ('author'));
    $this -> set ('author', $tpl_author); // After that, include all its sets.
    $this -> set ('new_author_msg', gettext ('New author'));
    $this -> set ('all_authors', $aa_paginated);
    $this -> set ('page_navigation', $page_navigation);
    if (count ($all_authors))
      $this -> set ('all_authors_msg', gettext ("All authors:"));
    else
      $this -> set ('all_authors_msg', gettext ("There are not authors."));
  }
  // }}}
}

?>