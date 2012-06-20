<?php
/*
 Copyright 2011 Román Ginés Martínez Ferrández <romangines@riseup.net>

 This file is part of phpgendao.

 phpgendao is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 phpgendao is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once ('utam_author.php');
include_once ('utam_subject.php');
include_once ('utam_publisher.php');
include_once ('utam_format.php');

/**
 * Object represents table 'utam_book'
 *
 * @author: Román Ginés Martínez Ferrández <romangines@riseup.net>
 */
class utam_book
{
	var $id;
	var $isbn;
	var $title;
	var $description;
	var $cover;
	var $pages;
	var $utam_subject = array (); // Array of objects.
	var $utam_author = array (); // Array of objects.
	var $utam_publisher; // It is an object.
	var $utam_format; // It is an object.
}
?>