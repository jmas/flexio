<?php

class AppController extends Controller
{
	/**
	 *
	 */
	public function beforeExec($actionName, array $params=array())
	{
		$this->app->assets->addCss(array(
			'http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css',
			$this->app->getAssetUrl('css/app.css'),
		));

		$this->app->assets->addJs(array(
			'http://code.jquery.com/jquery-1.10.2.min.js',
			'http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js',
			'http://cdnjs.cloudflare.com/ajax/libs/parsley.js/1.2.2/parsley.min.js',
		));

		$this->app->assets->addJs($this->app->getAssetUrl('js/app.js'), AssetManager::POS_BODY_BOTTOM);

		return parent::beforeExec($actionName, $params);
	}

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