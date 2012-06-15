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
 * form.js
 *
 * The AJAX JavaScript class support. This class can call loader's AJAX
 * from HTML forms.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */

var form = new Object ();

/*
 * Construct.
 */
form.construct = function () {
}

/*
 * The class prototype.
 */
form.construct.prototype = {
    /*
     * This function call the "loadXMLContent" (that is a "ajax.js" method) using a 
     * "ajaxloader" object with the values of the form identified by "idform".
     *
     * Args:
     * - ajaxloader: the net.loadConents object (defined into workloader.js file).
     * - idform: identifier of the form.
     */
    ajaxSubmit: function (ajaxloader, idform) {
	var frm = document.getElementById (idform);
	var param;
	
	if (idform) {
	    // Prepare the data POST.
	    param = this.getPOST (idform);
	}
	// Call loadXMLContent with the data POST.
	ajaxloader.loadXMLContent (param);
    },

    /*
     * This function create a POST string with fields and values of the form.
     *
     * Args:
     * - idform: The id form.
     *
     * Return:
     * - The POST string.
     */
    getPOST: function (idform) {
	var param = "";
	var frm = document.getElementById (idform);

	for (i = 0; i < frm.elements.length; i++)
	    {
		if (frm.elements[i].type == "radio" && frm.elements[i].checked)
		    param += frm.elements[i].id + "=" + frm.elements[i].value + "&";
		else if (frm.elements[i].type == "hidden" ||
			 frm.elements[i].type == "input" ||
			 frm.elements[i].type == "checkbox" ||
			 frm.elements[i].type == "select-one" ||
			 frm.elements[i].type == "text" ||
			 frm.elements[i].type == "password" ||
			 frm.elements[i].type == "textarea")
		    param += frm.elements[i].id + "=" + frm.elements[i].value + "&";
	    }
	param = param.slice (0, -1); // Remove last character (the "&" character).

	return param;
    },

    /*
     * This function check if there are extra spaces into of the input text type.
     * If there are extra spaces, delete it.
     *
     * Args:
     * - id: value of the id property of the input text type.
     */
    deleteExtraSpace: function (id) {
	var element = document.getElementById (id);
	var str;
	
	if (element) {
	    str = element.value;
	    element.value = str.replace (/^\s+|\s+$/g, '').replace (/\s+/g, ' ');
	}
    },

    /*
     * This function check if the 'id' element is not null. If the element is null show
     * a message into a id='id'-error element.
     *
     * Args:
     * - id: identifier of the form element.
     * - msg: message to show.
     */
    required: function (id, msg) {
	var element = document.getElementById (id);
	var errelement = document.getElementById (id + '-error');

	this.deleteExtraSpace (id);
	if (element) {
	    if (element.value == '') {
		errelement.innerHTML = msg;
	    }
	    else { // If ok, clean the likely messages error.
		errelement.innerHTML = '';
	    }
	}
    },

    /*
     * Check if a year is leap.
     *
     * Args:
     * - year
     */
    isLeapYear: function (year) {
	if ((year % 100 != 0) && ((year % 4 == 0 || year % 400 == 0)))
	    return true;
	else
	    return false;
    },

    /*
     * This function check the day, month and year on a date.
     *
     * Args:
     * - day
     * - month
     * - year
     */
    isValidDate: function (day, month, year) {
	var numDays;
	day = parseInt (day, 10);
	month = parseInt (month, 10);
	year = parseInt (year, 10);
	if (day && month && year) {
	    switch (month) {
	       case 1: case 3: case 5: case 7: case 8: case 10: case 12:
		   numDays = 31;
		   break;
	       case 4: case 6: case 9: case 11:
		   numDays = 30;
		   break;
	       case 2:
		   numDays = this.isLeapYear (year) ? 29 : 28;
		   break;
	       default:
		   return false;
		   break;
	    }

	    if (day > numDays || day <= 0)
		return false;
	    else
	    	return true;
	}
	else {
	    return false;
	}
    },

    /*
     * This function check if the 'id' element is a valida date format. A valid date format
     * is 'dd-mm-aaaa' or 'aaaa-mm-dd'.
     *
     * Args:
     * - id: identifier of the form element.
     * - msg: message to show.
     */
    checkDate: function (id, msg) {
	var element = document.getElementById (id);
	var errelement = document.getElementById (id + '-error');
	var format = new RegExp ("^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$");
	var arr_date;

	if (element) {
	    element.value = element.value.replace (new RegExp ("-", "g"), "/");
	    if (element.value.match (format)) {
		arr_date = element.value.split ("/");
		if (this.isValidDate (arr_date[0], arr_date[1], arr_date[2])) {
		    errelement.innerHTML = '';
		    return;
		}
	    }

	    // If is here, something is bad.
	    errelement.innerHTML = msg;
	    element.value = '';
	}
    }
}

/*
 * The object of the class.
 */
var formobj = new form.construct ();