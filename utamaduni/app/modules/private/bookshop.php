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
 * bookshop.php
 *
 * This module show, insert and update bookshops.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class bookshop extends core_auth_user
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

  // {{{ __get_bookshop ()
  /**
   * __get_bookshop
   *
   * Get bookshop information and returns it or null if there is any error or
   * not exist that bookshop.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  private function __get_bookshop ()
  {
    $utam_bs = null;

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

	include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_bookshop_mysql_ext_dao.php');
	$dao = new utam_bookshop_mysql_ext_dao ();
	$utam_bs = new utam_bookshop ();
	$utam_bs = $dao -> load ($clean -> get ('id'));
      }

    return $utam_bs;
  }
  // }}}

  // {{{ __get_addr_bookshop ($id)
  /**
   * __get_addr_bookshop
   *
   * Get address bookshop information and returns it or null if there is any error or
   * not exist that bookshop.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  private function __get_addr_bookshop ($id)
  {
    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_addr_bookshop_mysql_ext_dao.php');
    $dao = new utam_addr_bookshop_mysql_ext_dao ();
    $utam_bs = new utam_addr_bookshop ();
    $utam_bs = $dao -> load ($id);

    return $utam_bs;
  }
  // }}}

  // {{{ __get_online_bookshop ($id)
  /**
   * __get_online_bookshop
   *
   * Get online bookshop information and returns it or null if there is any error or
   * not exist that bookshop.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  private function __get_online_bookshop ($id)
  {
    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_online_bookshop_mysql_ext_dao.php');
    $dao = new utam_online_bookshop_mysql_ext_dao ();
    $utam_bs = new utam_online_bookshop ();
    $utam_bs = $dao -> load ($id);

    return $utam_bs;
  }
  // }}}

  // {{{ update ()
  /**
   * update
   *
   * This function will be ran by model if an event is "update".
   *
   * This function will insert a new bookshop or, if there is GET or POST data, update a
   * existing bookshop.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function update ()
  {
    $msg = array ();
    $href = '';
    $link = '';
    $formstr = '';
    $msg_file = '';

    // Get POST or GET data.
    // Prepare validation from POST or GET data (the validators objects
    // get the POST or GET automatically).
    $id_validator = new validation_digit_field ('id', 'The id must be a digit');
    $update_validator = new validation_digit_field ('update', 'The update must be a digit');
    $name_validator =
      new validation_alnum_field ('name',
				  gettext ('The name is a required field and must consist of letter and numbers only'),
				  true);
    $streetname_validator =
      new validation_lalnum_field ('streetname',
				   gettext ('The street name must consist of letter and numbers only'));
    $streetnum_validator =
      new validation_digit_field ('streetnum',
				   gettext ('The street number must consist of letter and numbers only'));
    $streetextra_validator =
      new validation_lalnum_field ('streetextra',
				   gettext ('The extra information street must consist of letter and numbers only'));
    $city_validator =
      new validation_alnum_field ('city',
				  gettext ('The city must consist of letter and numbers only'));
    $country_validator =
      new validation_alnum_field ('country',
				  gettext ('The country must consist of letter and numbers only'));
    $url_validator =
      new validation_url_field ('url',
				gettext ('The web address must be an URL'));


    $val_facade = new validation_facade ();
    $val_facade -> add_validator ($id_validator);
    $val_facade -> add_validator ($update_validator);
    $val_facade -> add_validator ($name_validator);
    $val_facade -> add_validator ($streetname_validator);
    $val_facade -> add_validator ($streetnum_validator);
    $val_facade -> add_validator ($streetextra_validator);
    $val_facade -> add_validator ($city_validator);
    $val_facade -> add_validator ($country_validator);
    $val_facade -> add_validator ($url_validator);
    $file = new file_phpfiles ('logo', UT_FILES_BASE_PATH . UT_FOLDER_LOGOS,
			       UT_FILES_LOGICAL_PATH . UT_FOLDER_LOGOS);
    
    // Check data in (validation).
    $facade_val_res = $val_facade -> validation ();
    
    // Get clean data.
    $clean = $val_facade -> get_clean_request ();

    // The facade validation validates the entry data and the form validate
    // validates the required fields, minimun field length, and so on.
    if ($facade_val_res)
      {
	try
	  {
	    // Operation? It can be 'insert' or 'update'
	    if ($clean -> get ('update') == 1)
	      {
		$operation = 'update';
		$tail_msg = gettext ('has been updated');
	      }
	    else
	      {
		$operation = 'insert';
		$tail_msg = gettext ('has been inserted');
	      }

	    // Open a transaction because they do several inserts. If one fail rollback.
	    include_once (UT_BASE_PATH . '/include/db/mysql/core/transaction.php');
	    $transaction = new transaction ();

	    // Insert the bookshop into db.
	    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_bookshop_mysql_ext_dao.php');
	    $dao = new utam_bookshop_mysql_ext_dao ();
	    $utam_bs = new utam_bookshop ();
	    $utam_bs -> id = $clean -> get ('id');
	    $utam_bs -> name = $clean -> get ('name');
	    $utam_bs -> logo = $file -> get_logical_full_path ();		
	    // If ok it gets the identifier of the inserted book.
	    $idbookshop = $dao -> $operation ($utam_bs);
	    if ($operation == 'update')
	      $idbookshop = $clean -> get ('id');
	    
	    // Move the upload cover.
	    if ($file -> move_uploaded_files ())
	      throw new Exception (gettext ('It can not upload the file') . ': ' . 
				   $file -> get_error ());
		
	    // Insert the address, street and physical bookshop.
	    $aux = $clean -> get ('streetname');
	    if (!empty ($aux))
	      {
		include_once (UT_BASE_PATH . '/include/db/mysql/ext/ajen_street_mysql_ext_dao.php');
		$dao = new ajen_street_mysql_ext_dao ();
		$streetid = $dao -> insert_street ($clean -> get ('streetname'),
						   $clean -> get ('streetnum'),
						   $clean -> get ('streetextra'));

		// Insert the address.
		include_once (UT_BASE_PATH . '/include/db/mysql/ext/ajen_address_mysql_ext_dao.php');
		$dao = new ajen_address_mysql_ext_dao ();
		$ajen_address = new ajen_address ();
		$ajen_address -> street = $streetid;
		$ajen_address -> city = $clean -> get ('city');
		$ajen_address -> country = $clean -> get ('country');
		$addressid = $dao -> insert_address ($ajen_address);

		// Insert the physical bookshop.
		include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_addr_bookshop_mysql_ext_dao.php');
		$dao = new utam_addr_bookshop_mysql_ext_dao ();
		$utam_abs -> id = $idbookshop;
		$utam_abs -> address = $addressid;
		$dao -> $operation ($utam_abs);
	      }

	    // Insert the online bookshop.
	    $aux = $clean -> get ('url');
	    if (!empty ($aux))
	      {
		include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_online_bookshop_mysql_ext_dao.php');
		$dao = new utam_online_bookshop_mysql_ext_dao ();
		$utam_obs -> id = $idbookshop;
		$utam_obs -> url = $clean -> get ('url');
		$dao -> $operation ($utam_obs);
	      }
	    
	    // It prepares the message.
	    $msg_file = file_get_contents (UT_HTML_TPL_PATH . '/ok.html');
	    $msg[] = array ('msg' => gettext ('The bookshop') . ' "' . 
			    $clean -> get ('name') .
			    '" ' . $tail_msg);
	    $href = "javascript: parent.formupdatebookshoploader.loadXMLContent ();";
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
	    $href = "javascript: parent.bookshoploader.loadXMLContent ();";
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
	$href = "javascript: parent.bookshoploader.loadXMLContent ();";
	$link = gettext ('Leave');
      }
    
    $this -> set ('msg_file', $msg_file);
    $this -> set ('messages', $msg);
    $this -> set ('form', $formstr);
    $this -> set ('href', $href);
    $this -> set ('link', $link);

    // It changes template file name.
    $this -> tpl_name = 'msg.tpl.html';
  }
  // }}}

  // {{{ updateform ()
  /**
   * updateform
   *
   * This function will be ran by model if an event is "updateform".
   *
   * This function show the form for update or insert a bookshop.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function formupdate ()
  {
    $bookshop_id = '';
    $name = '';
    $streetname = '';
    $streetnum = '';
    $streetextra = '';
    $city = '';
    $country = '';
    $url = '';

    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();

    // Get the bookshop template.
    $tpl_book = file_get_contents (UT_HTML_TPL_PATH . '/bookshopform.html');
    $this -> set ('bookshop', $tpl_book);
    $this -> set ('private_menu', $private_menu -> get_menu ('bookshop'));

    // Get the bookshop information (maybe null).
    $utam_bookshop = $this -> __get_bookshop ();
    if ($utam_bookshop)
      {
	$bookshop_id = $utam_bookshop -> id;
	$name = $utam_bookshop -> name;
	$utam_addr = $this -> __get_addr_bookshop ($utam_bookshop -> id);
	$utam_online = $this -> __get_online_bookshop ($utam_bookshop -> id);
	if ($utam_addr) // It can be null
	  {
	    $streetname = $utam_addr -> ajen_address -> ajen_street -> name;
	    $streetnum = $utam_addr -> ajen_address -> ajen_street -> num;
	    $streetextra = $utam_addr -> ajen_address -> ajen_street -> extra;
	    $city = $utam_addr -> ajen_address -> city;
	    $country = $utam_addr -> ajen_address -> country;
	  }
	if ($utam_online) // It can be null
	  {
	    $url = $utam_online -> url;
	  }
	$this -> set ('update_value', '1');
      }
    else
      $this -> set ('update_value', '0');

    $this -> set ('id_value', $bookshop_id);
    $this -> set ('name_label', gettext ('Name'));
    $this -> set ('name', $name);
    $this -> set ('name_len', '100');
    $this -> set ('logo_label', gettext ('Logo'));
    $this -> set ('address_msg', gettext ('if is a physical bookshop type the post address'));
    $this -> set ('street_label', gettext ('Street'));
    $this -> set ('street_name_label', gettext ('name'));
    $this -> set ('streetname', $streetname);
    $this -> set ('streetname_len', '100');
    $this -> set ('street_number_label', gettext ('number'));
    $this -> set ('streetnum', $streetnum);
    $this -> set ('streetnum_len', '4');
    $this -> set ('street_extra_label', gettext ('more'));
    $this -> set ('streetextra', $streetextra);
    $this -> set ('streetextra_len', '100');
    $this -> set ('city_label', gettext ('City'));
    $this -> set ('city', $city);
    $this -> set ('city_len', '100');
    $this -> set ('country_label', gettext ('Country'));
    $this -> set ('country', $country);
    $this -> set ('country_len', '100');
    $this -> set ('url_msg', gettext ('If this bookshop have web page or is an online bookshop type the URL'));
    $this -> set ('url_label', gettext ('Web address'));
    $this -> set ('url', $url);
    $this -> set ('url_len', '200');
    $this -> set ('cancel_btn', gettext ('Cancel'));
    $this -> set ('ok_btn', gettext ('Create'));
  }
  // }}}

  // {{{ show ()
  /**
   * show
   *
   * This function will be ran by model if an event is "show".
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function show ()
  {
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();

    if ($utam_bookshop = $this -> __get_bookshop ())
      {
	$utam_addr = $this -> __get_addr_bookshop ($utam_bookshop -> id);
	$utam_online = $this -> __get_online_bookshop ($utam_bookshop -> id);
	if (!$utam_addr) // It can be null
	  {
	    $utam_addr = new utam_addr_bookshop ();
	    $ajen_address = new ajen_address ();
	    $ajen_street = new ajen_street ();
	    $utam_addr -> utam_bookshop = $utam_bookshop;
	    $utam_addr -> ajen_address = $ajen_address;
	    $utam_addr -> ajen_address -> ajen_street = $ajen_street;
	  }
	if (!$utam_online) // It can be null
	  {
	    $utam_online = new utam_online_bookshop ();
	  }

	// Get the book template.
	$tpl_bookshop = file_get_contents (UT_HTML_TPL_PATH . '/bookshop.html');

	// Sets all datas.
	$this -> set ('private_menu', $private_menu -> get_menu ('bookshop'));
	$this -> set ('bookshop', $tpl_bookshop); // After that, include all its sets.
	$this -> set ('bookshop_header', gettext ('Bookshop detail'));
	$this -> set ('bookshopid', $utam_bookshop -> id);
	$this -> set ('update_bookshop_msg', gettext ('Update bookshop'));
	$this -> set ('imgid', 'small');
	$this -> set ('logo', $utam_bookshop -> logo);
	$this -> set ('name_label', gettext ('Name'));
	$this -> set ('name', $utam_bookshop -> name);
	$this -> set ('street_label', gettext ('Address'));
	$this -> set ('street_name_label', gettext ('Street'));
	$this -> set ('streetname', $utam_addr -> ajen_address -> ajen_street -> name);
	$this -> set ('streetnumber', $utam_addr -> ajen_address -> ajen_street -> num);
	$this -> set ('streetextra', $utam_addr -> ajen_address -> ajen_street -> extra);
	$this -> set ('city_label', gettext ('City'));
	$this -> set ('city', $utam_addr -> ajen_address -> city);
	$this -> set ('country_label', gettext ('Country'));
	$this -> set ('country', $utam_addr -> ajen_address -> country);
	$this -> set ('url_label', gettext ('URL'));
	$this -> set ('url', $utam_online -> url);
      }
    else // Validation error.
      {
	echo "error<br>";
      }
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
    include_once (UT_BASE_PATH . '/include/db/mysql/utam_bookshop_mysql_dao.php');
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();
    $all_bookshops = array ();
    $abs_paginated = array ();
    $page_navigation = '';
    
    // Get all books.
    $dao = new utam_bookshop_mysql_dao ();
    $bookshop_list = $dao -> query_all ();

    if (is_array ($bookshop_list))
      {
	if (count ($bookshop_list) > 0)
	  {
	    foreach ($bookshop_list as $bookshop)
	      {
		$all_bookshops[] = array ('href' => "javascript: showbookshoploader.loadXMLContent ('id=" . $bookshop -> id . "');",
					  'imgid' => 'mini',
					  'imgsrc' => $bookshop -> logo,
					  'bookshop_title' => $bookshop -> name);
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
	    $page_results = new paginated ($all_bookshops, 12, $page);
	    while ($row = $page_results -> fetch_paged_row ()) 
	      {
		$abs_paginated[] = $row;
	      }
	    $page_results -> set_layout (new ajax_trailing_layout ());
	    $page_navigation = $page_results -> fetch_paged_navigation ('bookshoploader');
	  }
      }

    // Get the book template.
    $tpl_bookshop = file_get_contents (UT_HTML_TPL_PATH . '/allbookshops.html');

    // Sets all datas.
    $this -> set ('private_menu', $private_menu -> get_menu ('bookshop'));
    $this -> set ('bookshop', $tpl_bookshop); // After that, include all its sets.
    $this -> set ('new_bookshop_msg', gettext ('New bookshop'));
    $this -> set ('all_bookshops', $abs_paginated);
    $this -> set ('page_navigation', $page_navigation);
    if (count ($all_bookshops))
      $this -> set ('all_bookshops_msg', gettext ("All bookshops:"));
    else
      $this -> set ('all_bookshops_msg', gettext ("There are not any bookshop."));
  }
  // }}}
}

?>