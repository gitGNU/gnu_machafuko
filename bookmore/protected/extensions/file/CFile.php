<?php
/**
 * CFile class file.
 *
 * This class provides methods to manage files (and directories) and manage upload
 * files from forms. This class works under Yii Framework (http://www.yiiframework.com)
 * and CUploadedFile.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Copyright &copy; Román Ginés Martínez Ferrández
 * @license GPLv3 (http://www.gnu.org/licenses/gpl)
 */
class CFile extends CApplicationComponent
{
    /**
     * @var string real path when file is. This is
     * '$_dirname/$_basename'.
     */
    private $_filepath;

    /**
     * @var string basename of the file including extension,
     * for example 'file.odt'.
     */
    private $_basename;

    /**
     * @var string name of the file without extension, for
     * examenple 'file'.
     */
    private $_filename;

    /**
     * @var string directory name where file is in for example
     * '/var/www/htdocs/uploads'.
     */
    private $_dirname;

    /**
     * @var string file extension, for example 'odt'.
     */
    private $_extension;

    /**
     * @var string mime type of the file, for example 'text/html'.
     */
    private $_mimeType;

    /**
     * @var CUploadedFile uploaded file object.
     */
    private $_uploadedFile;

    /**
     * This function copy the $file that comes from a form into $directory.
     *
     * @param  object  $model     the model object.
     * @param  string  $file      value of the property 'name' from the input file tag.
     * @param  string  $directory destination directory when file will be save.
     * @param  boolean $deleteDir if true then it will empty the directory.
     * @return boolean true if it has been able to upload file.
     */
    public function saveAs($model,$file,$directory,$deleteDir=false)
    {
        $this->_uploadedFile=CUploadedFile::getInstance($model,$file);
        if ($this->_uploadedFile instanceof CUploadedFile) {
            if($deleteDir)
                $this->emptyDir($directory);
            $this->createDir($directory);
            $this->_uploadedFile->saveAs($directory.DIRECTORY_SEPARATOR.$this->_uploadedFile->name);

            $this->_dirname=$directory;
            $this->_basename=$this->_uploadedFile->name;
            $this->_filepath=$this->_dirname.DIRECTORY_SEPARATOR.$this->_basename;
            $arr=preg_split("/\./",$this->_basename);
            if (count($arr)==2) {
                $this->_filename=$arr[0];
                $this->_extension=$arr[1];
            }
            $this->_mimeType=$this->_uploadedFile->getType();

            return true;
        }

        return false;
    }

    /**
     * This function ask to saveAs to delete all into $directory and save the $file that
     * comes from a form into $directory.
     *
     * @param  object  $model     the model object.
     * @param  string  $file      value of the property 'name' from the input file tag.
     * @param  string  $directory destination directory when file will be save.
     * @return boolean true if it has been able to upload file.
     */
    public function moveAs($model,$file,$directory)
    {
        return $this->saveAs($model,$file,$directory,true);
    }

    /**
     * Delete a file and its folder if is empty.
     *
     * @param  string  $file the path of the file to delete.
     * @return boolean true if it deletes.
     */
    public function deleteFile($file)
    {
        if (is_file($file)) {
            $pathParts=pathinfo($file);
            @unlink($file);
            $contents=scandir($pathParts['dirname']);
            if(count($contents)<=2) // It counts '.' and '..' directory.
                @rmdir($pathParts['dirname']);

            return true;
        }

        return false;
    }

    /**
     * Purges (makes empty) the directory ($dir).
     *
     * @return boolean true if successed.
     */
    public function emptyDir($dir)
    {
        if (is_dir($dir)) {
            if ($contents=scandir($dir)) {
                foreach ($contents as $item) {
                    if ($item!='.' && $item!='..') {
                        if (is_file($dir.DIRECTORY_SEPARATOR.$item)) {
                            @unlink($dir.DIRECTORY_SEPARATOR.$item);
                        } elseif (is_dir($dir.DIRECTORY_SEPARATOR.$item)) {
                            @rmdir($dir.DIRECTORY_SEPARATOR.$item);
                        }
                    }
                }

                return true;
            }
        }

           return false;
    }

    /**
     * Creates empty directory defined by $directory.
     *
     * @param  string  $directory   Parameter used to create directory.
     * @param  string  $permissions Access permissions for the directory.
     * @return boolean true or false.
     */
    public function createDir($directory, $permissions=0754)
    {
        if (@mkdir($directory, $permissions, true))
            return true;

           return false;
    }

    /**
     * Magic get method.
     *
     * @see CComponent::__get()
     */
    public function __get($name)
    {
        $attr='_'.$name;

        return $this->$attr;
    }
}
