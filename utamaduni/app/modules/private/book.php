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
 * book.php
 *
 * This module show, insert, update and delete books.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class book extends core_auth_user
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

  // {{{ __get_book ()
  /**
   * __get_book
   *
   * Get book information and returns it or null if there is any error or
   * not exist that book.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  private function __get_book ()
  {
    $utam_book = null;

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

	include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_book_mysql_ext_dao.php');
	$dao = new utam_book_mysql_ext_dao ();
	$utam_book = new utam_book ();
	$utam_book = $dao -> load ($clean -> get ('id'));
      }

    return $utam_book;
  }
  // }}}

  // {{{ update ()
  /**
   * update
   *
   * This function will be ran by model if an event is "update".
   *
   * This function will insert a new book or, if there is GET or POST data, update a
   * existing book.
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
    $file = '';

    // Get POST or GET data.
    // Prepare validation from POST or GET data (the validators objects
    // get the POST or GET automatically).
    $author_validator = new validation_ok_field ('author');
    $bookshop_validator = new validation_ok_field ('bookshop');
    $contact_validator = new validation_ok_field ('contact');
    $isbn_validator =
      new validation_isbn_field ('isbn',
				 gettext ('The ISBN must consist of numbers and dashes only'));
    $title_validator =
      new validation_alnum_field ('title',
				  gettext ('The title must consist of letter and numbers only'));
    $desc_validator =
      new validation_lalnum_field ('description',
				   gettext ('The description must consist of letter and numbers only'));
    $publisher_validator = 
      new validation_alnum_field ('publisher',
				  gettext ('The publisher must consist of letter and numbers only'));
    $format_validator =
      new validation_alnum_field ('format',
				  gettext ('The format must consist of letter and numbers only'));
    $pages_validator =
      new validation_digit_field ('pages',
				  gettext ('The pages must consist of numbers only'));
    $start_validator =
      new validation_alnum_field ('start',
				  gettext ('The start date must consist of letter and numbers only'));
    $finish_validator =
      new validation_alnum_field ('finish',
				  gettext ('The finish date must consist of letter and numbers only'));
    $opinion_validator =
      new validation_lalnum_field ('opinion',
				   gettext ('The opinion must consist of letter and numbers only'));
    $valoration_validator =
      new validation_digit_field ('valoration',
				  gettext ('The valoration must consist of digits'));
    
    $subject_validator =
      new validation_alnum_field ('subject',
				  gettext ('The subjects must consist of letter and numbers only'));
    $price_validator =
      new validation_digit_field ('price',
				  gettext ('The price must consist of digits'));

    $val_facade = new validation_facade ();
    $val_facade -> add_validator ($author_validator);
    $val_facade -> add_validator ($bookshop_validator);
    $val_facade -> add_validator ($contact_validator);
    $val_facade -> add_validator ($isbn_validator);
    $val_facade -> add_validator ($title_validator);
    $val_facade -> add_validator ($desc_validator);
    $val_facade -> add_validator ($start_validator);
    $val_facade -> add_validator ($finish_validator);
    $val_facade -> add_validator ($opinion_validator);
    $val_facade -> add_validator ($publisher_validator);
    $val_facade -> add_validator ($format_validator);
    $val_facade -> add_validator ($pages_validator);
    $val_facade -> add_validator ($valoration_validator);
    $val_facade -> add_validator ($subject_validator);
    $val_facade -> add_validator ($price_validator);
    
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
	    // Open a transaction because they do two inserts. If one fail rollback.
	    include_once (UT_BASE_PATH . '/include/db/mysql/core/transaction.php');
	    $transaction = new transaction ();
		
	    // Insert the subjects.
	    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_subject_mysql_ext_dao.php');
	    $dao = new utam_subject_mysql_ext_dao ();
	    $subjects = $dao -> insert ($clean -> get ('tag'));
		
	    // Get all authors (it only needs the pk).
	    include_once (UT_BASE_PATH . '/include/db/mysql/utam_author_mysql_dao.php');
	    $authors = array ();
	    if (count ($clean -> get ('author')))
	      foreach ($clean -> get ('author') as $key => $val)
		{
		  $author = new utam_author ();
		  $author -> id = $val;
		  $authors[] = $author;
		}
		
	    // Insert the publisher.
	    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_publisher_mysql_ext_dao.php');
	    $dao = new utam_publisher_mysql_ext_dao ();
	    $publisher = $dao -> insert ($clean -> get ('publisher'));

	    // Insert the format.
	    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_format_mysql_ext_dao.php');
	    $dao = new utam_format_mysql_ext_dao ();
	    $format = $dao -> insert ($clean -> get ('format'));
		
	    // Insert the book into db.
	    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_book_mysql_ext_dao.php');
	    $dao = new utam_book_mysql_ext_dao ();
	    $file = new file_phpfiles ('cover', UT_FILES_BASE_PATH . UT_FOLDER_COVERS,
				       UT_FILES_LOGICAL_PATH . UT_FOLDER_COVERS);
	    $utam_book = new utam_book ();
	    $utam_book -> isbn = $clean -> get ('isbn');
	    $utam_book -> title = $clean -> get ('title');
	    $utam_book -> description = $clean -> get ('description');
	    $utam_book -> cover = $file -> get_logical_full_path ();
	    $utam_book -> pages = $clean -> get ('pages');
	    $utam_book -> utam_subject = $subjects;
	    $utam_book -> utam_author = $authors;
	    $utam_book -> utam_publisher = $publisher;
	    $utam_book -> utam_format = $format;
		
	    // If ok it gets the identifier of the inserted book.
	    $idbook = $dao -> insert ($utam_book);
	    
	    // Now, it inserts the book into book reading table.
	    include_once (UT_BASE_PATH . '/include/db/mysql/utam_read_mysql_dao.php');
	    $dao = new utam_read_mysql_dao ();
	    $utam_read = new utam_read ();
	    $utam_read -> id = $idbook;
	    $utam_read -> isbn = $clean -> get ('isbn');
	    $utam_read -> start = date_util::to_mysql_date ($clean -> get ('start'));
	    $utam_read -> finish = date_util::to_mysql_date ($clean -> get ('finish'));
	    $utam_read -> opinion = $clean -> get ('opinion');
	    $utam_read -> valoration = $clean -> get ('valoration');
	    $idbook = $dao -> insert ($utam_read);

	    // If is a purchased book it inserts the book into purchased table. Otherwise,
	    // it inserts into loaned book table.
	    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_purchased_mysql_ext_dao.php');
	    $dao = new utam_purchased_mysql_ext_dao ();
	    $utam_pur = new utam_purchased ();
	    $utam_pur -> bookshop = new utam_bookshop ();
	    $utam_pur -> id = $idbook;
	    $utam_pur -> isbn = $clean -> get ('isbn');
	    $utam_pur -> price = $clean -> get ('price');
	    $utam_pur -> bookshop -> id = $clean -> get ('bookshop');
	    $dao -> insert ($utam_pur);

	    // Move the upload cover.
	    if ($file -> move_uploaded_files ())
	      throw new Exception (gettext ('It can not upload the file') . ': ' . 
				   $file -> get_error ());
	    
	    // It prepares the message.
	    $msg_file = file_get_contents (UT_HTML_TPL_PATH . '/ok.html');
	    $msg[] = array ('msg' => gettext ('The book') . ' "' . 
			    $clean -> get ('title') .
			    '" ' . gettext ('has inserted'));
	    $href = "javascript: parent.formupdatebookloader.loadXMLContent ();";
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
	    $href = "javascript: parent.bookloader.loadXMLContent ();";
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
	$href = "javascript: parent.bookloader.loadXMLContent ();";
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
   * This function will be ran by model if an event is "update".
   *
   * This function show the form for update or insert a book.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function formupdate ()
  {
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();

    // Get the book template.
    $tpl_book = file_get_contents (UT_HTML_TPL_PATH . '/bookform.html');
    $this -> set ('book', $tpl_book);
    $this -> set ('private_menu', $private_menu -> get_menu ('book'));

    // Get the book information (maybe null).
    $utam_book = $this -> __get_book ();
    
    $this -> set ('title', gettext ('Title'));
    $this -> set ('title_len', '50');
    $this -> set ('cover_label', gettext ('Cover'));
    $this -> set ('author_label', gettext ('Author'));
    include_once (UT_BASE_PATH . '/modules/helper/author.php');
    $authors = author::get_all_author ();
    $select = array ();
    foreach ($authors as $key => $val)
      $select[] = array ('author_value' => $key, 'author_name' => $val);
    $this -> set ('authors', $select);
    $this -> set ('bookshop_label', gettext ('Bookshop'));
    include_once (UT_BASE_PATH . '/modules/helper/bookshop.php');
    $bookshops = bookshop::get_all_bookshop ();
    $select = array ();
    foreach ($bookshops as $key => $val)
      $select[] = array ('bookshop_value' => $key, 'bookshop_name' => $val);
    $this -> set ('bookshops', $select);
    $this -> set ('bookshop_select', gettext ('Select a bookshop'));
    $this -> set ('isbn_label', gettext ('ISBN'));
    $this -> set ('isbn', '');
    $this -> set ('isbn_len', '20');
    $this -> set ('publisher_label', gettext ('Publisher'));
    $this -> set ('publisher', '');
    $this -> set ('publisher_len', '50');
    $this -> set ('format_label', gettext ('Format'));
    $this -> set ('format', '');
    $this -> set ('format_len', '50');
    $this -> set ('subject_label', gettext ('Subject'));
    $this -> set ('subject', '');
    $this -> set ('subject_len', '100');
    $this -> set ('description_label', gettext ('Description'));
    $this -> set ('description', '');
    $this -> set ('description_len', '500');
    $this -> set ('description_rows', '4');
    $this -> set ('description_cols', '50');
    $this -> set ('format_label', gettext ('Format'));
    $this -> set ('format', '');
    $this -> set ('format_len', '50');
    $this -> set ('pages_label', gettext ('Pages'));
    $this -> set ('pages', '');
    $this -> set ('pages_len', '4');
    $this -> set ('start_label', gettext ('Start read date'));
    $this -> set ('start', '');
    $this -> set ('finish_label', gettext ('Finish read date'));
    $this -> set ('finish', '');
    $this -> set ('valoration_label', gettext ('Valoration'));
    $this -> set ('valoration_select', gettext ('Select a valoration'));
    $this -> set ('price_msg', gettext ('Complete this field only if this book has been purchased'));
    $this -> set ('price_label', gettext ('Price'));
    $this -> set ('price', '');
    $this -> set ('price_len', '6');
    $this -> set ('contact_msg', gettext ('Complete this field only if this book has been loaned'));
    $this -> set ('contact_label', gettext ('Loaned contact'));
    include_once (UT_BASE_PATH . '/modules/helper/contact.php');
    $this -> set ('contacts', contact::get_all_contact ());
    $this -> set ('opinion_label', gettext ('Opinion'));
    $this -> set ('opinion', '');
    $this -> set ('opinion_len', '500');
    $this -> set ('opinion_rows', '4');
    $this -> set ('opinion_cols', '50');
    $this -> set ('cancel_btn', gettext ('Cancel'));
    $this -> set ('ok_btn', gettext ('Create'));
  }
  // }}}

  // {{{ __default ()
  /**
   * __default
   *
   * This function will be ran by model if an event is "show".
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function show ()
  {
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();
    
    if ($utam_book = $this -> __get_book ())
      {
	// Create author array to set.
	$authors[0] = array ('imgauthorid' => '', 'photo' => '', 'author' => '');
	if (count ($utam_book -> utam_author))
	  {
	    $i = 0;
	    foreach ($utam_book -> utam_author as $author)
	      {
		$authors[$i] = array ('imgauthorid' => 'mini',
				      'photo' => $author -> photo,
				      'author' => $author -> name . ' ' . $author -> surname);
		$i++;
	      }
	  }

	// Create subjects string.
	$subjects = '';
	if ($i = count ($utam_book -> utam_subject))
	  {
	    $subjects = $utam_book -> utam_subject[0] -> name;
	    for ($j = 1; $j < $i; $j++)
	      $subjects .= ', ' . $utam_book -> utam_subject[$j] -> name;
	  }

	// Get the book template.
	$tpl_book = file_get_contents (UT_HTML_TPL_PATH . '/book.html');

	// Sets all datas.
	$this -> set ('private_menu', $private_menu -> get_menu ('book'));
	$this -> set ('book', $tpl_book); // After that, include all its sets.
	$this -> set ('title', $utam_book -> title);
	$this -> set ('imgid', 'small');
	$this -> set ('cover', $utam_book -> cover);
	$this -> set ('authors', $authors);
	$this -> set ('isbn', $utam_book -> isbn);
	$this -> set ('isbn_tag', gettext ('ISBN'));
	$this -> set ('publisher', $utam_book -> utam_publisher -> name);
	$this -> set ('publisher_tag', gettext ('Publisher'));
	$this -> set ('format', $utam_book -> utam_format -> name);
	$this -> set ('format_tag', gettext ('Format'));
	$this -> set ('subject', $subjects);
	$this -> set ('subject_tag', gettext ('Subject'));
	$this -> set ('description', $utam_book -> description);
	$this -> set ('description_tag', gettext ('Description'));
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
    include_once (UT_BASE_PATH . '/include/db/mysql/ext/utam_read_mysql_ext_dao.php');
    include_once (UT_BASE_PATH . '/modules/helper/privatemenu.php');
    $private_menu = new privatemenu ();
    $all_books = array ();
    $ab_paginated = array ();
    $page_navigation = '';
    
    // Get all books.
    $dao = new utam_read_mysql_ext_dao ();
    $book_list = $dao -> query_all ();

    if (is_array ($book_list))
      {
	if (count ($book_list) > 0)
	  {
	    foreach ($book_list as $book)
	      {
		$all_books[] = array ('href' => "javascript: showbookloader.loadXMLContent ('id=" . $book -> id . "');",
				      'imgid' => 'mini',
				      'imgsrc' => $book -> utam_book -> cover,
				      'book_title' => $book -> utam_book -> title);
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
	    $page_results = new paginated ($all_books, 12, $page);
	    while ($row = $page_results -> fetch_paged_row ()) 
	      {
		$ab_paginated[] = $row;
	      }
	    $page_results -> set_layout (new ajax_trailing_layout ());
	    $page_navigation = $page_results -> fetch_paged_navigation ('bookloader');
	  }
      }

    // Get the book template.
    $tpl_book = file_get_contents (UT_HTML_TPL_PATH . '/allbooks.html');

    // Sets all datas.
    $this -> set ('private_menu', $private_menu -> get_menu ('book'));
    $this -> set ('book', $tpl_book); // After that, include all its sets.
    $this -> set ('new_book_msg', gettext ('New book'));
    $this -> set ('all_books', $ab_paginated);
    $this -> set ('page_navigation', $page_navigation);
    if (count ($all_books))
      $this -> set ('all_books_msg', gettext ("All your books") . ':');
    else
      $this -> set ('all_books_msg', gettext ("You do not have any book") . '.');
  }
  // }}}
}

?>