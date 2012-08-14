/*
 * Utamaduni (suajili language meaning 'culture') is a book management.
 * Copyright (C) 2011, 2012 Román Ginés Martínez Ferrández <rgmf@riseup.net>
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

/*
 * loader.js
 *
 * The AJAX JavaScript loaders. 
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */

/*
 * Login module loader.
 */
var loginloader =
    new net.loadContents 
    ("user/login",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "content");

/*
 * Private home loader.
 */
var homeloader =
    new net.loadContents
    ("private/home",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "content");

/*
 * Private books reading loader.
 */
var booksreadingloader =
    new net.loadContents
    ("private/booksreading",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "books-reading");

/*
 * Private all books loader.
 */
var allbooksloader =
    new net.loadContents
    ("private/allbooks",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "all-books");

/*
 * Private form update book loader.
 */
var formupdatebookloader =
    new net.loadContents
    ("private/book/formupdate.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private delete book loader.
 */
var deletebookloader =
    new net.loadContents
    ("private/book/delete.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private bookshop loader.
 */
var bookshoploader =
    new net.loadContents
    ("private/bookshop",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private author.
 */
var authorloader =
    new net.loadContents
    ("private/author",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private quote loader.
 */
var qouteloader =
    new net.loadContents
    ("private/quote",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "content");

/*
 * Private search loader.
 */
var searchloader =
    new net.loadContents
    ("private/search",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Book info home loader.
 */
var bookloader =
    new net.loadContents
    ("private/book",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Book info home loader.
 */
var showbookloader =
    new net.loadContents
    ("private/book/show.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Author info home loader.
 */
var showauthorloader =
    new net.loadContents
    ("private/author/show.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Bookshop info loader.
 */
var showbookshoploader =
    new net.loadContents
    ("private/bookshop/show.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private form update author.
 */
var formupdateauthorloader =
    new net.loadContents
    ("private/author/formupdate.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private delete author.
 */
var deleteauthorloader =
    new net.loadContents
    ("private/author/delete.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private form update bookshop.
 */
var formupdatebookshoploader =
    new net.loadContents
    ("private/bookshop/formupdate.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private delete bookshop.
 */
var deletebookshoploader =
    new net.loadContents
    ("private/bookshop/delete.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "private-content");

/*
 * Private form search result loader.
 */
var searchresultloader =
    new net.loadContents
    ("private/search/search.html",
     insertContent,
     null,
     "POST",
     "",
     "application/x-www-form-urlencoded",
     "search-result");
