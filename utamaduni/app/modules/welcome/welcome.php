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
 * welcome.php
 *
 * This module show the welcome web page.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class welcome extends core_auth_no
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
    $header = file_get_contents (UT_HTML_TPL_PATH . '/header.html');
    $footer = file_get_contents (UT_HTML_TPL_PATH . '/footer.html');
    include_once (UT_BASE_PATH . '/modules/helper/menu.php');
    $menu = new menu ();

    // Load CSS Files.
    $this -> set ('css_file1', UT_CSS_FRAMEWORK_PATH . '/960.css');
    $this -> set ('css_file2', UT_CSS_FRAMEWORK_PATH . '/reset.css');
    $this -> set ('css_file3', UT_CSS_FRAMEWORK_PATH . '/text.css');
    $this -> set ('css_file3', UT_CSS_PATH . '/my.css');

    // Load JS files.
    $this -> set ('js_base_path', UT_JS_BASE_PATH);

    // Load contents.
    $this -> set ('header_html_file', $header);
    $this -> set ('footer_html_file', $footer);
    $this -> set ('lema', gettext ('The book is the best friend of the people'));
    $this -> set ('header', 'Utamaduni');
    $this -> set ('h1_content', gettext ('Welcome to Utamaduni'));
    $this -> set ('welcome_content', gettext ('Here you can find a lot of information about books I have read') . '.');
    $this -> set ('menu', $menu -> get_menu ('home'));
    $this -> set ('page_title', '.:Utamaduni:.');
  }
  // }}}
}