<?php
/* 
V 0.1
27/07/07
by Pascal Vila

Objet réaliser et modifier à partir de Page format v1.5
Il faut activere l'extention curl pour que cela fonctionne
*/
/*
PageForward v1.5
by Joshua Dick
http://pageforward.sourceforge.net

If you did not download this file from Sourceforge.net, please redownload from
http://sourceforge.net/project/showfiles.php?group_id=156341 to ensure that you have the lastest version.

PageForward includes support for loading media (images, videos, etc.) through the proxy. This feature is still
very experimental and may break some pages. Therefore, it is turned off by default; to turn it on, change
$proxify_media to true in the user config section.

CHANGELOG:
See http://pageforward.sf.net/changelog.txt for the PageFoward changelog.

PageForward (referred to as 'PF' for the remainder of this text) is a PHP program that will let you surf
the web through a makeshift proxy (the web server the program runs on) to bypass things like internet
content filters, or to browse the internet anonymously.

INSTALLATION AND USAGE:
Change the first two uncommented lines (the ones that start with dollar signs) below this information if
you need to. Upload this file to a web server running PHP. Make sure the program has proper execute permissions.
The program is used by going to http://your.webserver.com/[x.php]?url=[y] in a browser where [x.php] is the
name of this file, and [y] is the URL of a site that you wish to view through the proxy. Links you click on
will be 'redirected' through the proxy; things typed in the address bar of your browser will not (unless they
appear after the 'url='.) Note that you can change the name of this .php file to anything you want.

OTHER INFO:
This program is released under the GNU Lesser GPL. It is a modified version of Simple Browser Proxy
(located at http://sbp.sf.net) and I'd like to thank the original author for writing and freely distributing
SBP and its source code. PF is free to use on its own, but if you are integrating it or part of it into your
own program, please mention PF, the fact that it is released under the LGPL, and its home on the internet,
http://pageforward.sourceforge.net. The author of this program takes no responsibility for any
consequence of the use of this program. This program does not absolutely guarantee secure anonymous
browsing, it is only a simple proxy browser. Use it at your own risk.
*/

Class Proxy
{
  	public $url;
	public $mediafile;
	public $proxy_page;
  	//**BEGIN USER CONFIG**
  	//Page to display by default (if no URL is supplied)
  	private $default_url = "http://www.alienorweblibre.org";
	//Tag to prepend page titles
	private $title_tag = "PF--";
	//Attempt to load media (images, movies, scripts, etc.) through the proxy (EXPERIMENTAL)
	public $proxify_media = false;
	//**END USER CONFIG**

	private $start_time;
	private $form_submission;
	private $HTML;
	private $hostName;
	
	public function __construct(){
		// parametre 0 : activer le changement des url des images (pour quelle passe par le proxy true or flase
		// parametre 1 : page du receptionnaire de requete proxy pour les images
   		// parametre 2 : page par défaut
		$nbParam = func_num_args();
		for ($i=0; $i<= $nbParam-1 ; $i++){
			$param = func_get_arg($i);
			switch ($i){
				case "0" :	$this->proxify_media  = $param;
							break;
				case "1" :	$this->proxy_page = $param;
							break;
				case "2" :	$this->default_url = $param;
							break;
			}
		}
	}
	public function toString(){
		$chaine = "<br/>Objet de classe Proxy, avec les propriétés suivantes :";
		$chaine .= '<br/> url :' . (string)$this->url;
		$chaine .= "<br/> mediafile :" . (string)$this->mediafile;;
		$chaine .= "<br/> url :" . (string)$this->url;
		$chaine .= "<br/> proxy_page :" . (string)$this->proxy_page;
		$chaine .= "<br/> proxify_media :" . (string)$this->proxify_media;
		return $chaine;
	}
	public function toDebug(){
		$chaine = "<br/>Objet de classe Proxy, avec les variables internes suivantes :";
		$chaine .= '<br/> default_url :' . (string)$this->default_url;
		$chaine .= "<br/> title_tag :" . (string)$this->title_tag;
		$chaine .= "<br/> proxify_media :" . (string)$this->proxify_media;
		$chaine .= "<br/> start_time :" . (string)$this->start_time;
		$chaine .= "<br/> form_submission :" . (string)$this->form_submission;
		$chaine .= "<br/> HTML :" . (string)$this->HTML;
		return $chaine;
	}
	public function __Set($name, $value){
		$this->$name = $value;
	}
	public function __get($name){
		return $this->$name;
	}
	public function getPage(){
		$this->start_time = microtime();
		if (empty($this->url)) {
			$this->url = $this->default_url;
		}

		//If a proxified media file (not a web page) is requested...
		if (!empty($this->mediafile)) {
			$mediaContents = implode('',file($this->mediafile));
			return $mediaContents;
		}

		//If a proxified media file isn't requested (a web page is)...
		else {  
			//Check the URL for protocol, etc....
			if(substr($this->url, 0, 7) != "http://") //didn't start with 'http://'...we have a problem.
			{
				$this->url = "http://".$this->url;
			}

			
			//Checks if there was a form redirected to this proxy.
			
			   if(!empty($_POST['original_url']))
					{
						$this->form_submission = true;
					}
					else if(!empty($_GET['original_url']))
					{
						
						//have to strip off any unwanted stuff from original_url
						$this->url = explode(" ", $_GET['original_url']);
						$this->url = $this->url[0];
						$this->form_submission = false;
						$this->url = urldecode($this->url)."?".str_replace("original_url=".urlencode($_GET['original_url'])."&", "", $_SERVER['QUERY_STRING']);
						//echo "url :".$this->url;
					}
				if(!$this->form_submission) //OK, no redirected form so go ahead and fetch a page.
				{
					//echo "<br>juste avant getfile :".$this->url;
					$this->HTML = $this->getFile($this->url);
					//echo "<br>this html:<br>".$this->HTML;
					$this->HTML = preg_replace("#\<(title|TITLE)\>#", "<\$1>".$this->title_tag, $this->HTML, 1);
					$this->completeURLs(); //Complete local links so that they are fully qualified URIs
					
					$this->proxyURLs();  //Complete links so that they pass through this proxy
					
					//Point all media back to proxy--EXPERIMENTAL!
					if ($this->proxify_media) {
						// initial $pattern = '/ src=\s*(["\']?)([^>\s"\']+)\\1[^>]*>/i';
						$pattern ="'!(FRAME|frame) (src|SRC)=(\"|\')?'";
						if (empty($this->proxy_page)){
							$replace = " src=\"{$_SERVER['PHP_SELF']}?mediafile=";
						}else{
							$replace = " src=\"{$this->proxy_page}?mediafile=";
						}
						$this->HTML = preg_replace($pattern, $replace, $this->HTML);
						// pour les framset
						$pattern = "'(FRAME|frame) (src|SRC)=(\"|\')?'";
						if (empty($this->proxy_page)){
							$replace = "frame src=\"{$_SERVER['PHP_SELF']}?url=";
						}else{
							$replace = "frame src=\"{$this->proxy_page}?url=";
						}
						
						$this->HTML = preg_replace($pattern, $replace, $this->HTML);
						
						// rempplace les images de fond
						$pattern = "' background=(\"|\')?'";
						if (empty($this->proxy_page)){
							$replace = "background=\"{$_SERVER['PHP_SELF']}?mediafile=";
						}else{
							$replace = " background=\"{$this->proxy_page}?mediafile=";
						}
						$this->HTML = preg_replace($pattern, $replace, $this->HTML);
						//echo "<br>apres preg replace host no path :<br>".$this->HTML;
						
					}
					//print_r($HTML); //Output the page using print_r so that frames at least partially are written
					//flush();
					return $this->HTML;
					//Calculate execution time and add HTML comment with that info
					$duration = $this->microtime_diff($this->start_time, microtime());
					$duration = sprintf("%0.3f", $duration);
					//echo ("\n<!-- PageForward v1.5 took $duration seconds to construct this page.-->");
				}
			}
		
	}//fin de getPage
	
	
	
	

	//Finds the nth position of a string within a string. (Stolen from http://us3.php.net/strings).
	private function strnpos($haystack, $needle, $occurance, $pos = 0) {
		
		for ($i = 1; $i <= $occurance; $i++) {
			$pos = strpos($haystack, $needle, $pos) + 1;
		}
		return $pos - 1;
	}

	//URL parser that works better than PHP's built-in function.
	private function parseURL($url)
	{
		//protocol(1), auth user(2), auth password(3), hostname(4), path(5), filename(6), file extension(7) and query(8)
		$pattern = "/^(?:(http[s]?):\/\/(?:(.*):(.*)@)?([^\/]+))?((?:[\/])?(?:[^\.]*?)?(?:[\/])?)?(?:([^\/^\.]+)\.([^\?]+))?(?:\?(.+))?$/i";
		preg_match($pattern, $url, $matches);
		
		$URI_PARTS["scheme"] = $matches[1];
		$URI_PARTS["host"] = $matches[4];
		$URI_PARTS["path"] = $matches[5];
		$this->hostName = $URI_PARTS["host"];
		return $URI_PARTS;
	}

	//Turns any local URLs into fully qualified URLs
	private function completeURLs()
	{
		$URI_PARTS = $this->parseURL($this->url);
		$path = trim($URI_PARTS["path"], "/");
		$host_url = trim($URI_PARTS["host"], "/");
		
		//$host = $URI_PARTS["scheme"]."://".trim($URI_PARTS["host"], "/")."/".$path; //ORIGINAL
		$host = $URI_PARTS["scheme"]."://".$host_url."/".$path."/";
		$host_no_path = $URI_PARTS["scheme"]."://".$host_url."/";
		
		//Proxifies local META redirects
		if (empty($this->proxy_page)){
			$this->HTML = preg_replace('@<META HTTP-EQUIV(.*)URL=/@', "<META HTTP-EQUIV\$1URL=".$_SERVER['PHP_SELF']."?url=".$host_no_path, $this->HTML);
		}else{
			$this->HTML = preg_replace('@<META HTTP-EQUIV(.*)URL=/@', "<META HTTP-EQUIV\$1URL=".$this->proxy_page."?url=".$host_no_path, $this->HTML);
		}

		
		//Make sure the host doesn't end in '//'
		$host = rtrim($host, '/')."/";
		
		//Replace '//' with 'http://'
		$pattern = "#(?<=\"|'|=)\/\/#"; //the '|=' is experimental as it's probably not necessary
		$this->HTML = preg_replace($pattern, "http://", $this->HTML);
				
		
		//Fully qualifies '"/'
		$this->HTML = preg_replace("#!(\"/\")\"\/#", "\"".$host_no_path, $this->HTML);
		//Fully qualifies "'/"
		$this->HTML = preg_replace("#!(\'/\')\'\/#", "\'".$host, $this->HTML);
		
		//Matches [ src|href|background|action]="/ because in the following pattern the '/' shouldn't stay
		$this->HTML = preg_replace("~( src|href|background|action)(=\"|='|=(?!'|\"|=#))\/~i", "\$1\$2".$host_no_path, $this->HTML);
		$this->HTML = preg_replace("~(href| src|background|action)(=\"|=(?!'|\")|=')(?!http|ftp|https|\"|'|javascript:|mailto:|#)~i", "\$1\$2".$host, $this->HTML);
		//Points all form actions back to the proxy
		if (empty($this->proxy_page)){
			//$this->HTML = preg_replace('/<form.+?action=\s*(["\']?)([^>\s"\']+)\\1[^>]*>/i', "<form action=\"{$_SERVER['PHP_SELF']}\"><input type=\"hidden\" name=\"original_url\" value=\"$2\">", $this->HTML);
			$this->HTML = preg_replace('/<form.+?action=\s*(["\']?)([^>\s"\']+)(["\']?)(.+?)>/i', "<form action=\"{$_SERVER['PHP_SELF']}\" $4 ><input type=\"hidden\" name=\"original_url\" value=\"$2\">", $this->HTML);
		}else{
			//$this->HTML = preg_replace('/<form.+?action=\s*(["\']?)([^>\s"\']+)\\1[^>]*>/i', "<form action=\"{$this->proxy_page}\"><input type=\"hidden\" name=\"original_url\" value=\"$2\">", $this->HTML);
			$this->HTML = preg_replace('/<form.+?action=\s*(["\']?)([^>\s"\']+)(["\']?)(.+?)>/i', "<form action=\"{$this->proxy_page}\" $4 ><input type=\"hidden\" name=\"original_url\" value=\"$2\">", $this->HTML);
		}

		//Matches '/[any assortment of chars or nums]/../'
		$this->HTML = preg_replace("#\/(\w*?)\/\.\.\/(.*?)>#ims", "/\$2>", $this->HTML);
		
		//Matches '/./'
		$this->HTML = preg_replace("#\/\.\/(.*?)>#ims", "/\$1>", $this->HTML);
		
		//Handles CSS2 imports
		if (strpos($this->HTML, "import url(\"http") == false && (strpos($this->HTML, "import \"http") == false) && strpos($this->HTML, "import url(\"www") == false && (strpos($this->HTML, "import \"www") == false)) {
			$pattern = "#import .(.*?).;#ims";
			$mainurl = substr($host, 0, $this->strnpos($host, "/", 3));
			$replace = "import '".$mainurl."\$1';";
			$this->HTML = preg_replace($pattern, $replace, $this->HTML);
		}
	}

	//Redirects link targets through this proxy
	private function proxyURLs()
	{
		$edited_tag = "PF"; //used to check if the link has already been modified by the proxy
		
		//BASE tag needs to be removed for sites like yahoo.com
		//OR make the proxy insert the FULL URL to itself
		$pattern = "#\<base(.*?)\>#ims";
		$replacement = "<!-- <base\$1> -->"; //comment it out for now//
		$this->HTML = preg_replace($pattern, $replacement, $this->HTML);
		
		//edit <link tags so that 'edited="$edit_tag" ' is just before 'href'
		$this->HTML = preg_replace("#\<link(.*?)(\shref=)#ims", "<link\$1 edited=\"".$edited_tag."\"\$2", $this->HTML);
		
		//matches everything with an </a> after it on the same line....fails to match when that is on another line.
		$pattern = "~(?<!edited=\"".$edited_tag."\"\s)(href='|href=\"|href=(?!'|\"))(?=(.+)\</a\>)(?!mailto:|http://ftp|ftp|javascript:|'|\")~ims";

		if (empty($this->proxy_page)){
			$this->HTML = preg_replace($pattern, "edited=\"".$edited_tag."\" \$1".$_SERVER['PHP_SELF'].'?url=', $this->HTML);
		}else{
			$this->HTML = preg_replace($pattern, "edited=\"".$edited_tag."\" \$1".$this->proxy_page.'?url=', $this->HTML);
		}
		$pattern = "~href=.+url=#~";
		$remplacement = "href=\"#";
		$this->HTML = preg_replace($pattern,$remplacement,$this->HTML);
	}

	//Calculates the differences in microtime captures
	private function microtime_diff($a, $b)
	{
		list($a_dec, $a_sec) = explode(" ", $a);
		list($b_dec, $b_sec) = explode(" ", $b);
		return $b_sec - $a_sec + $b_dec - $a_dec;
	}

	//Retrieves a file from the web.
	private function getFile($fileLoc)
	{
		//Sends user-agent of actual browser being used--unless there isn't one.
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if (empty($user_agent)) {
			$user_agent = "AWLPro/5.0 (compatible; PageForward Proxy)";
		}
		$ch = curl_init($fileLoc);
		//echo "titi".$fileLoc;
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_FAILONERROR, true);
		$file = curl_exec($ch);
		curl_close($ch);
		return $file;
	}

} // fin de la def de la classe Proxy
?>