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
 * login.php
 *
 * This module access to database to check the username and password.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class login extends core_auth_no
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

  // {{{ create_form ($clean)
  /**
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  private function create_form ($clean)
  {
    $form = new html_form ('login-form', 'post',
			   'javascript: formobj.ajaxSubmit (loginloader, "login-form");',
			   null, null, null, 'my-form');

    $element = $form -> add_element ('text', 'username', 'my-input-xlarge');
    $element -> set_label (gettext ('Username') . ': ', 'control-label');
    $element -> get_label () -> add_container ('div', 'my-form', 'grid_4 suffix_8');
    $element -> set_max_length (50);
    $element -> add_container ('div', 'left', 'grid_4 suffix_8');

    $element = $form -> add_element ('password', 'password', 'my-input-xlarge');
    $element -> set_label (gettext ('Password') . ': ');
    $element -> get_label () -> add_container ('div', 'my-form', 'grid_4 suffix_8');
    $element -> set_max_length (20);
    $element -> add_container ('div', 'left', 'grid_4 suffix_8');

    $element = $form -> add_element ('submit', 'submit', 'my-btn');
    $element -> set_value (gettext ("Log in"));
    $element -> add_container ('div', 'my-form', 'grid_4 suffix_8');

    return $form;
  }
  // }}}

  // {{{ __default ()
  /**
   * __default
   *
   * This function will be ran by model if an event (method) is not specified
   * in the request.
   *
   * Write the form.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __default ()
  {
    $errors = array ();
    $error_file = '';
    include_once (UT_BASE_PATH . '/modules/helper/menu.php');
    $menu = new menu ();

    // Prepare validation from POST or GET data (the validators objects
    // get the POST or GET automatically).
    $username_validator = 
      new validation_mail_field ('username',
				 gettext ('The username must be an e-mail'));
    $password_validator =
      new validation_alnum_field ('password',
				  gettext ('The password must consist of letter and numbers only'));
    $val_facade = new validation_facade ();
    $val_facade -> add_validator ($username_validator);
    $val_facade -> add_validator ($password_validator);

    // Check data in (validation). If there are not data returns 0 or null without error messages.
    $facade_val_res = $val_facade -> validation ();

    // Get clean data.
    $clean = $val_facade -> get_clean_request ();
    
    // It creates the form with cleaned data.
    $form = $this -> create_form ($clean);

    // If there is not POST show the form.
    if ($val_facade -> get_count_post ())
      {
	// Check data in (validation).
	if ($facade_val_res && $form -> validation ())
	  {
	    // Username and password validation.
	    include_once (UT_BASE_PATH . '/include/db/mysql/ext/core_user_mysql_ext_dao.php');
	    $dao = new core_user_mysql_ext_dao ();
	    $core_user_obj = $dao -> login ($clean -> get ('username'),
					    $clean -> get ('password'));
	    if ($core_user_obj) //Access OK.
	      {
		$this -> session -> user_id = $core_user_obj -> id;
		$this -> session -> fname = $core_user_obj -> name;
		$this -> session -> lname = $core_user_obj -> lname;
		header ("Location: ../private/home");
	      }
	    else // Access error.
	      {
		$errors[] = array ('msg' => gettext ('Username or password invalid'));
		$error_file = file_get_contents (UT_HTML_TPL_PATH . '/error.html');
	      }
	  }
	else // Validation error.
	  {
	    foreach ($val_facade -> get_errors () as $msg)
	      $errors[] = array ('msg' => $msg);
	    $error_file = file_get_contents (UT_HTML_TPL_PATH . '/error.html');
	  }
      }

    // Load contents.
    $this -> set ('error_html_file', $error_file);
    $this -> set ('caption', gettext ('Log in'));
    $this -> set ('form', $form -> display ());
    $this -> set ('messages', $errors);
    $this -> set ('menu', $menu -> get_menu ('login'));
  }
  // }}}
}

?>