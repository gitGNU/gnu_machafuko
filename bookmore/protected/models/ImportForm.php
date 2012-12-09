<?php
/**
 * ImportForm class.
 * ImportForm is the data structure for keeping import form data. It is used
 * by the 'import' action of 'WebController'.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Copyright &copy; Román Ginés Martínez Ferrández
 * @license GPLv3 (http://www.gnu.org/licenses/gpl)
 */
class ImportForm extends CFormModel
{
    public $bmFile;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('bmFile', 'file', 'types'=>'html,htm'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'bmFile'=>Yii::t('bm', 'File'),
        );
    }
}
