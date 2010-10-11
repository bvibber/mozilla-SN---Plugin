<?php

/**
 *
 * @category  Plugin
 * @package   Mozilla
 * @author    Paul Booker <paulbooker@ilovetheopenweb.org>
 * @license   http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License version 3.0
 *
 *
 * Notes:
 * require_once('plugins/Mozilla/MozillaPlugin.php');
 * $moz = new MozillaPlugin(); 
 */

if (!defined('STATUSNET')) {
    exit(1);
}

class MozillaPlugin extends Plugin
{
    function __construct($code=null) 
    {
        parent::__construct();
    }

    function initialize()
	{
	    return true;
	}
	
	function cleanup()
	{
	    return true;
	}	

    function onStartSecondaryNav($action) 
    {
        $action->menuItem(common_local_url('doc', array('title' => 'mozilla')), _('mozilla'));
	    $action->menuItem('http://www.drumbeat.org', 'Drumbeat');
	   
	    return true;
    }

    function onStartShowFooter($action) 
    {	
	   $output = "";
       $action->elementStart('div', array('id' => 'footer'));
       $action->showSecondaryNav(); 
       $action->elementStart('dl', array('id' => 'licenses'));
       $action->showStatusnetLicense($action);
       $action->elementStart('dd', null);
	   $instr = _('This site is officially affiliated with the [Mozilla Foundation](http://www.mozilla.org/).');
	   $output .= common_markup_to_html($instr);
	   $action->raw($output);
	   $action->elementEnd('dd');
       $action->showContentLicense();
       $action->elementEnd('dl');
       $action->elementEnd('div');
     
       return false; 
    }

    function onStartLoadDoc(&$title, &$output)
    {
	    switch($title) 
	    {		
		    case "mozilla":
		
		        $filename = common_path('local/plugins/Mozilla/doc-src/') . $title;
	            $c = file_get_contents($filename);
	            $output = common_markup_to_html($c);
	            return false;
	
	       	break;	               
	    }
        return true;
    }
	
    function onEndShowStyles($action) 
    {
        $action->element('link', array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => common_path('local/plugins/Mozilla/MozillaPlugin.css')));		
    }
	
    function onEndShowSections ($action) 
    { 
        $images_directory = common_path('local/plugins/Mozilla/images/');

        switch ($action->trimmed('action'))
        {
	        case 'profilesettings':
	        case 'register':
	
                $image = $images_directory . 'mozilla_Drumbeat__get_involved.png';
	            $action->elementStart('a', array('href' => 'http://www.mozilla.org/drumbeat'));
			    $action->element('img', array('src' => $image, 'alt' => 'mozilla Drumbeat - Get involved'), '');
			    $action->elementEnd('a');
	
	        break;	
        }

	    //if ($action->trimmed('action') == 'doc') 
        //{ 
        //    switch ($action->title)
        //    {
        //    }
        //}
          
        return true;
    }
}