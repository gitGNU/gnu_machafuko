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
 * menu.php
 *
 * This module managements the main menu.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class menu extends core_auth_no
{
  // {{{ Properties
  /**
   * $menu
   *
   * The menu map configuration.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param mixed $menu the menu map configuration.
   */
  private $menu = array ();
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __construct ()
  {
    parent::__construct ();
    $this -> menu = array (
           'home' => array ('id' => 'menu',
			    'link' => '',
			    'msg' => gettext ('Home')),
	   'about' => array ('id' => 'menu',
			     'link' => '',
			     'msg' => gettext ('About')),
	   'contact' => array ('id' => 'menu',
			       'link' => '',
			       'msg' => gettext ('Contact')),
	   'login' => array ('id' => 'menu',
			     'link' => 'javascript: loginloader.loadXMLContent ();',
			     'msg' => gettext ('Log in')),
	   'logout' => array ('id' => 'menu-logout',
			      'link' => 'user/logout',
			      'msg' => '')
			   );
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

  // {{{ get_menu ()
  /**
   * get_menu
   *
   * This function create the menu through the template and the menu property.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param array $selected the menu item selected.
   */
  public function get_menu ($selected = null)
  {
    $menu_file = file_get_contents (UT_HTML_TPL_PATH . '/menu.html');

    if ($selected == null)
      $selected = 'home';

    // If there is session the tag of the login menu changes.
    if ($this -> session -> user_id > 0)
      {
	$this -> menu['login']['msg'] = gettext ('Your space');
	$this -> menu['login']['link'] = 'javascript: homeloader.loadXMLContent ();';
	$this -> menu['logout']['msg'] = gettext ('Log out');
      }

    foreach ($this -> menu as $idx => $vals)
      {
	if ($idx == $selected)
	  $vals['id'] = 'selected';

	$menu_file = str_replace ('{'. $idx . '_id}', $vals['id'], $menu_file);
	$menu_file = str_replace ('{'. $idx . '_link}', $vals['link'], $menu_file);
	$menu_file = str_replace ('{'. $idx . '_msg}', $vals['msg'], $menu_file);
      }

    return $menu_file;
  }
  // }}}

  // {{{ __default ()
  /**
   * __default
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function __default ()
  {
    return $this -> get_menu ();
  }
  // }}}
}

?>