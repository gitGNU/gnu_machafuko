<?php
/**
 * CNetspaceBookmarkFormatParser class file.
 *
 * This class provides methods to manage Netscape bookmark format files.
 *
 * This class generates an array in this format:
 * array(
 * 		array('url'=>{url},
 *  		  'name'=>{name},
 *  		  'desc'=>{description},
 * 			  'tags'=>array({tag1},{tag2},...,{tag-n})),
 *      array('url'=>{url},
 *  		  'name'=>{name},
 *  		  'desc'=>{description},
 *      	  'tags'=>array({tag1},{tag2},...,{tag-n})),
 *      ...
 * )
 *
 * A possible example:
 * array(
 * 		array('url'=>'http://www.fsf.org',
 *  		  'name'=>'Free Software Foundation',
 *  		  'desc'=>'',
 * 			  'tags'=>array('free software','foundation')),
 *      array('url'=>'http://www.gnu.org',
 *  		  'name'=>'GNU',
 *  		  'desc'=>'GNU's not Unix',
 *      	  'tags'=>array('free software','system','software')),
 *      array('url'=>'http://linux.org',
 *  		  'name'=>'Linux',
 *  		  'desc'=>'An Operating System',
 *      	  'tags'=>array()),
 * )
 *
 * @author Román Ginés Martínez Ferrández <rgmf@riseup.net>
 * @copyright Copyright &copy; Román Ginés Martínez Ferrández
 * @license GPLv3 (http://www.gnu.org/licenses/gpl)
 */
class CNetscapeBookmarkFormatParser extends CApplicationComponent
{
    /**
     * In this property it will load the bookmarks file information.
     *
     * @var array array with bookmarks information
     */
    private $_bookmarks=array();
    /**
     * @var handler the file descriptor.
     */
    private $_fd=null;
    /**
     * The tags that are read from file. Theses will be save into an array with
     * this format:
     * array(
     * 		'name'=>{tag_name},
     * 		'attributes'=>array('name'=>{value},...),
     * 		'content'=>{content},
     * )
     *
     * @var array the current tag.
     */
    private $_tag=array();
    /**
     * @var array the last tag.
     */
    private $_lastTag=array();

    /**
     * Load the bookmarks $file into $_bookmarks array. If $_bookmarks already
     * have contents it will add contents to $_bookmarks.
     *
     * @param string $file path and name of the file with bookmarks.
     */
    public function loadFile($file)
    {
        $c='';
        $i=0;
        $this->_fd=fopen($file,'r');
        if ($this->_fd) {
            while ($c=$this->_readTag($c)) {
                if ($this->_tag['name']=='a' || $this->_tag['name']=='A') {
                    $url=isset($this->_tag['attributes']['href'])?rtrim($this->_tag['attributes']['href']):'';
                    $name=isset($this->_tag['content'])?rtrim($this->_tag['content']):'';
                    $tags=isset($this->_tag['attributes']['tags'])?$this->_tag['attributes']['tags']:'';
                    $this->_bookmarks[$i]=array(
                            'url'=>$url,
                            'name'=>$name,
                            'desc'=>'',
                            'tags'=>$tags,
                    );
                    $i++;
                } elseif ($this->_tag['name']=='dd' || $this->_tag['name']=='DD') {
                    $i--;
                    $this->_bookmarks[$i]['desc']=isset($this->_tag['content'])?rtrim($this->_tag['content']):'';
                    $i++;
                }
            }
        }
    }
    
    /**
     * It creates and writes a file with _bookmark information.
     * 
     * @return true if the file was create or false if there was error.
     */
    public function createFile($path, $name="bookmark", $ext="html")
    {
        // If path does not finished at '/' it adds this.
        $lastCharacter=substr($path, -1);
        if ($lastCharacter!='/')
            $path.='/';
        
        // Create the file.
        if ($handle=fopen($path.$name.'.'.$ext, 'w')) {
            // Write the head.
            fwrite($handle, '<!DOCTYPE NETSCAPE-Bookmark-file-1>'.PHP_EOL.
                    '<!-- This is an automatically generated file by Bookmore.'.
                    ' It will not be edit'.PHP_EOL.
                    '<META HTTP-EQUIV="Content-Type" CONTENT="text/html; '.
                    'charset=UTF-8">'.PHP_EOL.
                    '<TITLE>'.$name.'</TITLE>'.PHP_EOL.'<H1>'.$name.'</H1>'.
                    PHP_EOL.'<DL><p>'.PHP_EOL
            );
            // Write all items.
            foreach ($this->_bookmarks as $key=>$value) {
                if (!is_array($value))
                    throw new UnexpectedValueException(
                            "The value of the bookmark has to be an array"
                            );
                fwrite($handle, '<DT><A HREF="'.$value['url'].'" TAGS="'.
                    implode(",", $value['tags']).'">'.$value['name'].'</A><DD>'.
                    $value['desc'].PHP_EOL);
            }
            // Close opened tags.
            fwrite($handle, "</p></DL>");
            fclose($handle);
            return true;
        }
        
        return false; 
    }

    /**
     * It reads a tag and load its information into $_tag.
     *
     * @return string the last read character.
     */
    private function _readTag($lastchar=null)
    {
        $c='';
        $name='';
        $content='';
        $this->_lastTag=$this->_tag;

        // It moves to the start of the tag. If the last
        // tag is '<' then it just be in the start tag.
        if ($lastchar!='<') {
            while (($c=fgetc($this->_fd))!==false) {
                if($c=='<')
                    break;
            }
        }

        // It mybe a close tag (in this case it calls itself).
        if ($c=='<' || $lastchar=='<') {
            $c=fgetc($this->_fd);
            if ($c=='/') {
                while (($c=fgetc($this->_fd))!==false) {
                    if($c=='>')

                        return $this->_readTag($c);
                }
            } else if($c!==false)
                $name.=$c;
        }

        // It reads the name of the tag.
        while (($c=fgetc($this->_fd))!==false) {
            if($c==' ' || $c=='>')
                break;
            $name.=$c;
        }
        if($name!='')
            $this->_tag['name']=$name;


        // If this tag have attributes, it reads these attributes.
        if ($c==' ') {
            $this->_tag['attributes']=array();
            $c=$this->_readAttributes();
        } else
            $this->_tag['attributes']=array();

        // If this tag have content, it reads the content.
        while (($c=fgetc($this->_fd))!==false) {
            if($c=='<')
                break;
            $content.=$c;
        }
        $this->_tag['content']=$content;

        return $c;
    }

    /**
     * It reads attributes. The file descriptor must be into
     * a tag and this function will read to '>' character. It
     * saves the information into $_tag.
     *
     * @return string the las read character.
     */
    private function _readAttributes()
    {
        $name='';
        $value='';

        // It reads the attribute name.
        while (($c=fgetc($this->_fd))!==false) {
            if($c=='>' || $c=='=')
                break;
            if($c!==' ')
                $name.=strtolower($c);
        }

        // It reads the attribute value.
        if ($c=='=') {
            if (fgetc($this->_fd)!==false) { // it reads the '"' character.
                while (($c=fgetc($this->_fd))!==false) {
                    if($c=='>' || $c=='"')
                        break;
                    $value.=$c;
                }
            }

            if(!empty($name) && !empty($value))
                $this->_tag['attributes'][$name]=$value;

            if($c=='"')
                $this->_readAttributes();
        }

        return $c;
    }

    /**
     * It empties the $_bookmarks array.
     */
    public function cleanBookmarks()
    {
        $this->arrayClean($this->_bookmarks);
    }

    /**
     * It empties the $_bookmarks array.
     */
    private function arrayClean($array)
    {
        foreach ($array as $key=>$value) {
            if(is_array($value))
                $this->arrayClean($value);
            else if($value!==null)
                unset($value);
        }
    }

    /**
     * Return the _bookmark attribute.
     */
    public function getBookmarks()
    {
        return $this->_bookmarks;
    }
    
    /**
     * Set the bookmark attribute.
     */
    public function setBookmarks($bookmark)
    {
        $this->_bookmarks=$bookmark;
    }
    
    /**
     * Queue a new bookmark.
     * 
     * @param string $url the bookmark url.
     * @param string $name the name of the bookmark.
     * @param string $desc a description (optional).
     * @param array $tags is an array of tags (optional).
     */
    public function addBookmark($url, $name, $desc='', array $tags=array())
    {
        $this->_bookmarks[]=array(
                'url'=>$url,
                'name'=>$name,
                'desc'=>$desc,
                'tags'=>$tags,
                );
    }
}
