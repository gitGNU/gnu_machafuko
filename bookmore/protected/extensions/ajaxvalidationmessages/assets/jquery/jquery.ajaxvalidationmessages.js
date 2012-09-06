/*

 Author: Rodolfo González <metayii.framework@gmail.com>

 Copyright (c) 2011 Rodolfo González González.

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 SOFTWARE.

*/

// See the PHP code for the Yii extension for further information on what this
// tries to do =)
(function($) {
   var settings = {
      errorCssClass        : 'clsError',//'clsError',
      errorMessageCssClass : 'errorMessage',//'clsErrorMessage', // He cambiado clsErrorMessage por errorMessage.
      errorSummaryCssClass : 'clsErrorSummary'//'clsErrorSummary'
   };

   var methods = {
      init: function(options) {
         settings = $.extend({}, settings, options);
      },
      show: function(json, numItem) {
         var e = jQuery.parseJSON(json);
         var summary = '';
         jQuery('.errorMessage',$(this)).css('display','none'); // clean the error messages and then show the current errors.
         jQuery.each(e, function(key, value) {
            jQuery('#'+key+'_em_'+numItem).html(value.toString()).show();
            jQuery('#'+key).addClass(settings.errorCssClass);
            jQuery('label[for="'+key+'"]').addClass(settings.errorCssClass);
            summary = summary + '<li>' + value.toString() + '</li>';
         });
         jQuery('.'+settings.errorSummaryCssClass+' > ul', $(this)).html(summary);
         jQuery('.'+settings.errorSummaryCssClass, $(this)).show();
      },
      hide: function() {
         jQuery($(this)).children().each(
            function() {
               $(this).removeClass(settings.errorCssClass);
            }
         );
         jQuery('label, input', $(this)).each(
            function() {
               $(this).removeClass(settings.errorCssClass);
            }
         );
         //jQuery('.'+settings.errorMessageCssClass, $(this)).css('display', 'none');
         //jQuery('.'+settings.errorSummaryCssClass, $(this)).hide(); // Si quieres un cuadro descomenta esta línea y cambia errorSummaryCssClass a 'errorSummary'
         jQuery('.errorMessage',$(this)).css('display','none'); // He cambiado dos líneas más arriba por esta.
      }
   };

   $.fn.ajaxvalidationmessages = function(method) {
      if (methods[method]) {
    	  // The arguments can be 2 or 3 (these are my changes).
    	  if(arguments.length==3)
    		  return methods[method].apply(this, Array.prototype.slice.call(arguments, 1), Array.prototype.slice.call(arguments, 2));
    	  else if(arguments.length==2)
    		  return methods[method].apply(this, Array.prototype.slice.call(arguments, 1), '');
    	  else if(arguments.length==1)
    		  return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
      }
      else if (typeof method === 'object' || !method) {
         return methods.init.apply(this, arguments);
      }
      else {
         $.error('Method ' + method + ' does not exist on jQuery.ajaxvalidationmessages');
      }
  };
})(jQuery);