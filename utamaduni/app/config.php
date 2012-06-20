<?php
/*
 * Utamaduni (suajili language meaning 'culture') is a book management.
 * Copyright (C) 2011 Román Ginés Martínez Ferrández <rgmf@riseup.net>
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
 * config.php
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */

/**
 * Global constant with application root directory.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_BASE_PATH Absolute root path to directory of the app.
 */
define ('UT_BASE_PATH', dirname (__FILE__));

/**
 * This is a DSN to connect to database.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_DSN database DSN.
 */
define ('UT_DSN', 'mysql://roman:roman@localhost/machafuko_test');
// splitted
define ('UT_DSN_DB', 'machafuko_test');
define ('UT_DSN_HOST', 'localhost');
define ('UT_DSN_USER', 'roman');
define ('UT_DSN_PASS', 'roman');

/**
 * Global constant with locale folder.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_LOCALE_DIR Locale directory.
 */
define ('UT_LOCALE_DIR', 'locale');

/**
 * Global constant with core log path file.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_LOG_FILE log path file.
 */
define ('UT_LOG_FILE', '/tmp/core.log');

/**
 * Global constant with HTML templates base path.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_HTML_TPL_PATH HTML templates base folder.
 */
define ('UT_HTML_TPL_PATH', 'site/html/tpl');

/**
 * Global constant with CSS base path.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_CSS_FOLDER CSS base folder.
 */
define ('UT_CSS_PATH', 'site/css');

/**
 * Global constant with CSS bootstrap base path.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_CSS_BOOTSTRAP_PATH CSS base folder.
 */
define ('UT_CSS_FRAMEWORK_PATH', 'site/css/960');

/**
 * Global constant with JavaScript base path when are all JavaScript files.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_JS_BASE_PATH JavaScript base path.
 */
define ('UT_JS_BASE_PATH', 'site/js');

/**
 * Global constant with base path when all files are uploads.
 *
 * This folder should be apache or nobody user folder (chown apache or nobody) with 770
 * permission (chmod 770).
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_FILES_BASE_PATH JavaScript base path.
 */
define ('UT_FILES_BASE_PATH', '/var/www/machafuko/utamaduni/uploads');

/**
 * Global constant with logical web path when all files are uploads.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_LOGICAL_PATH JavaScript base path.
 */
define ('UT_FILES_LOGICAL_PATH', '/machafuko/utamaduni/uploads');

/**
 * Global constant with folder path when covers are uploads.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_FOLDER_COVERS
 */
define ('UT_FOLDER_COVERS', '/covers');

/**
 * Global constant with folder path when photos are uploads.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_FOLDER_PHOTOS
 */
define ('UT_FOLDER_PHOTOS', '/photos');

/**
 * Global constant with folder path when bookshop logos are uploads.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @global string UT_FOLDER_LOGOS
 */
define ('UT_FOLDER_LOGOS', '/logos');

?>