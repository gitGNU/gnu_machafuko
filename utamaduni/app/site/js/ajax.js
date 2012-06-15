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
 * ajax.js
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */

var net = new Object ();

// Constants.
net.READY_STATE_UNINITIALIZED = 0;
net.READY_STATE_LOADING = 1;
net.READY_STATE_LOADED = 2;
net.READY_STATE_INTERACTIVE = 3;
net.READY_STATE_COMPLETE = 4;

// Attributes.
net.url = null;
net.req = null;
net.onload = null;
net.onerror = null;
net.method = null;
net.param = null;
net.contentType = null;
net.idlabel = null;

/*
 * Constructor.
 * - url: php page to load.
 * - func: function that load the content.
 * - errorFunc: error function.
 * - method: methot to pass parameter to php page (POST or GET).
 * - param: the parameters (name=value).
 * - contentType: content type.
 * - idlabel: identifier of label in load contents.
 */
net.loadContents = function (url, func, errorFunc, method, param, contentType, idlabel) {
    this.url = url;
    this.req = null;
    this.onload = func;
    this.onerror = (errorFunc) ? errorFunc : this.defaultError;
    this.method = method;
    this.param = param;
    this.contentType = contentType;
    this.idlabel = idlabel;
}

/*
 * The class prototype.
 */
net.loadContents.prototype = {
    loadXMLContent: function (param) {
	if (window.XMLHttpRequest) {
	    this.req = new XMLHttpRequest ();
	}
	else if (window.ActiveXObject) {
	    this.req = new ActiveXObject ("Microsoft.XMLHTTP");
	}

	if (this.req) {
	    try {
		var loader = this;
		this.req.onreadystatechange = function () {
		    loader.onReadyState.call (loader);
		}
		this.req.open (this.method, this.url, true);
		if (this.contentType) {
		    this.req.setRequestHeader ("content-Type", this.contentType);
		}
		if (param)
		    this.param = param;
		else
		    this.param = null;
		this.req.send (this.param);
	    } catch (err) {
		this.onerror.call (this);
	    }
	}
    },

    onReadyState: function () {
	var req = this.req;
	var ready = req.readyState;
	
	if (ready == net.READY_STATE_COMPLETE) {
	    var httpStatus = req.status;
	    if (httpStatus == 200 || httpStatus == 0) {
		this.onload.call (this);
	    }
	    else {
		this.onerror.call (this);
	    }
	}
    },

    defaultError: function () {
	alert ("JavaScript (AJAX) error:" +
	       "\nreadyState: " + this.req.readyState +
	       "\nstatus: " + this.req.status +
	       "\nheaders: " + this.req.getAllResponseHeaders ());
    },
}

/*
 * This function load the content into id label.
 */
function insertContent () {
    document.getElementById (this.idlabel).innerHTML = this.req.responseText;
}