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
 * phpfiles.php
 *
 * This class manages the files you want to upload through a PHP form.
 *
 * It is a $_FILES wrapper with util methods to manages upload files.
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @license http://www.gnu.org/licenses/gpl.html
 */
class file_phpfiles
{
  // {{{ Properties
  /**
   * $allowed_exts
   *
   * Array with allowed files extensions.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var mixed $allowed_exts array with allowed files extensions.
   */
  private $allowed_exts =
    array (
	   // Images.
	   'jpg', 'jpeg', 'gif', 'png', 'svg',
	   // Text.
	   'txt', 'rtf',
	   // Office.
	   'ods', 'odt', 'ods', 'odp', 'odb'
	   );

  /**
   * $upload_errors
   *
   * Array with possibles errors.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var mixed $upload_errors array with upload errors.
   */
  private $upload_errors = 
    array(
	  UPLOAD_ERR_OK          => "No errors.",
	  UPLOAD_ERR_INI_SIZE    => "Larger than upload_max_filesize.",
	  UPLOAD_ERR_FORM_SIZE   => "Larger than form MAX_FILE_SIZE.",
	  UPLOAD_ERR_PARTIAL     => "Partial upload.",
	  UPLOAD_ERR_NO_FILE     => "No file.",
	  UPLOAD_ERR_NO_TMP_DIR  => "No temporary directory.",
	  UPLOAD_ERR_CANT_WRITE  => "Can't write to disk.",
	  UPLOAD_ERR_EXTENSION   => "File upload stopped by extension.",
	  5                      => "File is empty." // add this to avoid an offset
	  );

  /**
   * $error_msg
   *
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $error_msg error description.
   */
  private $error_msg = null;
  
  /**
   * $files
   *
   * $_FILES['field'] array in the form:
   *
   * Array
   * (
   * [name] => Array
   *     (
   *         [0] => foo.txt
   *         [1] => bar.txt
   *     )
   *
   * [type] => Array
   *     (
   *         [0] => text/plain
   *         [1] => text/plain
   *     )
   *
   * [tmp_name] => Array
   *     (
   *         [0] => /tmp/phpYzdqkD
   *         [1] => /tmp/phpeEwEWG
   *     )
   *
   * [error] => Array
   *     (
   *         [0] => 0
   *         [1] => 0
   *     )
   *
   * [size] => Array
   *     (
   *         [0] => 123
   *         [1] => 456
   *     )
   * )
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var mixed $files array with files information.
   */
  private $files = array ();

  /**
   * $path
   *
   * Save files path.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $path folder when files will be saved.
   */
  private $path;
  // }}}

  /**
   * $logical_path
   *
   * Logical path to save information into database.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @var string $logical_path 
   */
  private $logical_path;
  // }}}

  // {{{ __construct ()
  /**
   * __construct
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param string $field the index of $_FILES array on the file/s is/are.
   * @path string $path the folder on file/s will be saved.
   */
  public function __construct ($field, $path, $logical_path)
  {
    if (isset ($_FILES[$field]))
      $this -> files = $_FILES[$field];
    $this -> path = $path;
    $this -> logical_path = $logical_path;
  }
  // }}}

  // {{{ get_error ()
  /**
   * get_error
   *
   * Get error message.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function get_error ()
  {
    if ($this -> error_msg)
      return $this -> error_msg;
    return '';
  }
  // }}}

  // {{{ get_full_path ($idx)
  /**
   * get_full_path
   *
   * Return a path property with name if there is name.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param int $idx index array.
   */
  public function get_full_path ($idx = 0)
  {
    $name = $this -> get_name ($idx);
    if (!empty ($name))
      return $this -> path . '/' . $name;
    return '';
  }
  // }}}

  // {{{ get_logical_full_path ($idx)
  /**
   * get_logical_full_path
   *
   * Return a logical path property with name if there is name.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param int $idx index array.
   */
  public function get_logical_full_path ($idx = 0)
  {
    $name = $this -> get_name ($idx);
    if (!empty ($name))
      return $this -> logical_path . '/' . $name;
    return '';
  }
  // }}}

  // {{{ get_name ($idx)
  /**
   * get_name
   *
   * Return the idx file name. Recall that files property can have serveral information files.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param int $idx index array.
   */
  public function get_name ($idx = 0)
  {
    if (isset ($this -> files['name']))
      {
	if (is_array ($this -> files['name']))
	  return $this -> files['name'][$idx];
	else
	  return $this -> files['name'];
      }
    
    return '';
  }
  // }}}

  // {{{ delete ($idx = 0)
  /**
   * delete
   *
   * This function deletes the file.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param int $idx index array.
   */
  public function delete ($idx = 0)
  {
    unlink ($this -> path . '/' . $this -> get_name ($idx));
  }

  // {{{ __move_uploaded_files ($error, $tmp_name, $name)
  /**
   * __move_uploaded_files
   *
   * If there is not error it moves the file to the destination. Further, this function
   * protects the files uploads (check the upload file to avoid security problems).
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   * @param int $error information over errors.
   * @param string $tmp_name temporary file name.
   * @param string $name the name of the file.
   */
  private function __move_uploaded_files ($error, $tmp_name, $name)
  {
    if ($error == UPLOAD_ERR_OK)
      {
	$ext = strtolower (substr ($name, strrpos ($name, '.') + 1));
	if (!in_array ($ext, $this -> allowed_exts))
	  {
	    $this -> error_msg = "Extension file '" . $ext . "' do not allowed.";
	    return 1;
	  }
	if (!move_uploaded_file ($tmp_name, $this -> path . '/' . $name))
	  {
	    $this -> error_msg = "Cannot move " . $this -> files['name'] .
	      ": " . PHP_EOL;
	    return 1;
	  }
      }
    elseif ($error != UPLOAD_ERR_NO_FILE)
      {
	$this -> error_msg = $this -> upload_errors[$error];
	return $error;
      }

    return UPLOAD_ERR_OK;
  }

  // {{{ move_uploaded_files ()
  /**
   * move_uploaded_files
   *
   * Move all files to destination.
   *
   * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
   */
  public function move_uploaded_files ()
  {
    if (isset ($this -> files['name']))
      {
	// It must uploads more than one file.
	if (is_array ($this -> files['name']))
	  {
	    foreach ($this -> files['error'] as $key => $error)
	      {
		if ($e = $this -> __move_uploaded_files ($error,
							 $this -> files['tmp_name'][$key],
							 $this -> files['name'][$key]))
		  {
		    return $e;
		  }
	      }
	  }
	// Only there is a file to upload.
	else
	  {
	    return $this -> __move_uploaded_files ($this -> files['error'], 
						   $this -> files['tmp_name'],
						   $this -> files['name']);
	  }
      }

    return UPLOAD_ERR_OK;
  }
  // }}}
}

?>