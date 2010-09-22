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

    function onStartSecondaryNav($action) 
    {
        $action->menuItem(common_local_url('doc', array('title' => 'mozilla')), _('mozilla'));
	    $action->menuItem('http://www.drumbeat.org', 'Drumbeat');
	   
	    return true;
    }

    function onStartShowFooter($action) 
    {	
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
		    case "badge":
		
		    	$filename = INSTALLDIR.'/plugins/Mozilla/doc-src/' . $title;
	            $c = file_get_contents($filename);
	            $output = common_markup_to_html($c);
	            return false;
	
	       	break;	               
	    }
        return true;
    }
    	
    /**
     * Notes: 
     * EndShowStyles is in lib/actions.php
     */
	
    function onEndShowStyles($action) 
    {
        $action->element('link', array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => common_path('plugins/Mozilla/MozillaPlugin.css')));		
    }
	
    function onEndShowSections ($action) 
    { 
        $plugin_images_directory = 'plugins/Mozilla/images';

        switch ($action->trimmed('action'))
        {
	        case 'profilesettings':
	        case 'register':
	
	            $action->elementStart('a', array('href' => 'http://www.mozilla.org/drumbeat'));
			    $action->element('img', array('src' => "/$plugin_images_directory/mozilla_Drumbeat__get_involved.png", 'alt' => 'mozilla Drumbeat - Get involved'), '');
			    $action->elementEnd('a');
	
	        break;	
        }

	    if ($action->trimmed('action') == 'doc') 
        { 
            switch ($action->title)
            {
            }
        }
          
        return true;
    }

 

/***
**
** Terms and Conditions
** 
***/
    
    function onStartRegistrationTry($action)
    {
        if (!$action->boolean('tos')) 
        {
            $action->showForm(_('You can\'t register if you don\'t agree to the terms & conditions.'));
            return false;  
        }
        return true;  
    }

    function onEndRegistrationFormData($action)
    {
        $attrs = array('type' => 'checkbox',
                       'id' => 'tos',
                       'class' => 'checkbox',
                       'name' => 'tos',
                       'value' => 'true');
        if ($action->boolean('tos')) 
        {
            $attrs['checked'] = 'checked';
        }
        
        $action->elementStart('li');
        $action->element('input', $attrs);
        $action->elementStart('label', array('class' => 'checkbox', 'for' => 'tos'));
        $action->text(_('Please read our '));
        $action->element('a', array('href' => '/doc/tos', 'target' => '_blank'), 'Terms of Service');
        $action->text(_(' only then tick the checkbox to confirm your agreement.'));
        $action->elementEnd('label');
        $action->elementEnd('li');
      
        return true;
    }

}