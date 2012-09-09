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
		if($this->_fd)
		{
			while($c=$this->_readTag($c))
			{
				if($this->_tag['name']=='a' || $this->_tag['name']=='A')
				{
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
				}
				else if($this->_tag['name']=='dd' || $this->_tag['name']=='DD')
				{
					$i--;
					$this->_bookmarks[$i]['desc']=isset($this->_tag['content'])?rtrim($this->_tag['content']):'';
					$i++;
				}
			}
		}
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
		if($lastchar!='<')
		{
			while(($c=fgetc($this->_fd))!==false)
			{
				if($c=='<')
					break;
			}
		}
		
		// It mybe a close tag (in this case it calls itself).
		if($c=='<' || $lastchar=='<')
		{
			$c=fgetc($this->_fd);
			if($c=='/')
			{
				while(($c=fgetc($this->_fd))!==false)
				{
					if($c=='>')
						return $this->_readTag($c);
				}
			}
			else if($c!==false)
				$name.=$c;
		}
		
		// It reads the name of the tag.
		while(($c=fgetc($this->_fd))!==false)
		{
			if($c==' ' || $c=='>')
				break;
			$name.=$c;
		}
		if($name!='')
			$this->_tag['name']=$name;

		
		// If this tag have attributes, it reads these attributes.
		if($c==' ')
		{
			$this->_tag['attributes']=array();
			$c=$this->_readAttributes();
		}
		else
			$this->_tag['attributes']=array();
		
		// If this tag have content, it reads the content.
		while(($c=fgetc($this->_fd))!==false)
		{
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
		while(($c=fgetc($this->_fd))!==false)
		{
			if($c=='>' || $c=='=')
				break;
			if($c!==' ')
				$name.=strtolower($c);
		}

		// It reads the attribute value.
		if($c=='=')
		{
			if(fgetc($this->_fd)!==false) // it reads the '"' character.
			{
				while(($c=fgetc($this->_fd))!==false)
				{
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
		foreach($array as $key=>$value)
		{
			if(is_array($value))
				$this->arrayClean($value);
			else if($value!==null)
				unset($value);
		}
	}
	
	/**
	 * 
	 */
	public function getBookmarks()
	{
		return $this->_bookmarks;
	}
}