<?php

/**
 * @author Rodolfo González <metayii.framework@gmail.com>
 * @copyright 2011 Rodolfo González González.
 * @license http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright (c) 2011 Rodolfo González González.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * EAjaxValidationMessages loads a jQuery plugin which show the validation
 * error messages and changes the CSS class for the error class. It also
 * contains a function to hide those errors and restore the form to its original
 * state.
 *
 * @version 1.1
 * @since 1.8.0
 * @example This is an usage example:
 *
 * In your view:
 *
 * <code>
 * <?php $this->widget('application.extensions.ajaxvalidationmessages.EAjaxValidationMessages',
 *                     array(
 *                        'errorCssClass'=>'clsError',
 *                        'errorMessageCssClass'=>'clsErrorMessage')); ?></code>
 *
 * In your view, in your AJAX callbacks for ajaxSubmitButton which validate:
 *
 * <code>
 * 'success'=>"function(html) {
 *    if (html.indexOf('{')==0) {
 *       jQuery('#the-form').ajaxvalidationmessages('show', html);
 *    }
 *    else {
 *       jQuery('#the-form').ajaxvalidationmessages('hide');
 *    }
 * }",
 * 'error'=>"function(html) {
 *    jQuery('#the-form').ajaxvalidationmessages('hide');
 * }",
 * </code>
 *
 * @package application.extensions.ajaxvalidationmessages.EAjaxValidationMessages
 */
class EAjaxValidationMessages extends CWidget
{
   //***************************************************************************
   // Configuration.
   //***************************************************************************

   /**
    * @var string the CSS class for th error fields and labels.
    */
   public $errorCssClass = 'clsError';

   /**
    * @var string the CSS class for the error messages.
    */
   public $errorMessageCssClass = 'clsErrorMessage';

   /**
    * @var string the CSS class for the error summary.
    */
   public $errorSummaryCssClass = 'clsErrorSummary';

   //***************************************************************************
   // Utilities.
   //***************************************************************************

   /**
    * Generate the javascript options object for the plugin.
    *
    * @return string the options object.
    */
   protected function makeOptions()
   {
      $options = array();

      if (!empty($this->errorCssClass)) {
         $options['errorCssClass'] = strval($this->errorCssClass);
      }
      if (!empty($this->errorMessageCssClass)) {
         $options['errorMessageCssClass'] = strval($this->errorMessageCssClass);
      }

      return CJavaScript::encode($options);
   }

   //***************************************************************************
   // Run Lola Run.
   //***************************************************************************

   /**
    * Init.
    */
   public function init()
   {
      $url = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
      Yii::app()->clientScript->registerScriptFile($url.'/jquery/jquery.ajaxvalidationmessages.js');
   }

   /**
    * Run.
    */
   public function run()
   {
      $options = $this->makeOptions();

      $script =<<<EOP
jQuery().ajaxvalidationmessages('init', $options);
EOP;
      Yii::app()->clientScript->registerScript(get_class($this), $script, CClientScript::POS_HEAD);
   }
}
