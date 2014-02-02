<?php

class AppController extends Controller
{
    /**
     *
     */
    protected function addEditorAssets()
    {
        $this->app->assets->addJs(array(
        	'http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ace.js',
        	'http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ext-emmet.js',
        	'http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/mode-php.js',
    	));
    }
}