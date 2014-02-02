<?php

class AppController extends Controller
{
	/**
	 *
	 */
	public function beforeExec($actionName, array $params=array())
	{
		$this->app->assets->add('http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css', AssetManager::TYPE_CSS, AssetManager::POS_HEAD);
		$this->app->assets->add($this->app->getAssetUrl('css/app.css'), AssetManager::TYPE_CSS, AssetManager::POS_HEAD);

		$this->app->assets->add('http://code.jquery.com/jquery-1.10.2.min.js', AssetManager::TYPE_JS, AssetManager::POS_HEAD);
		$this->app->assets->add('http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js', AssetManager::TYPE_JS, AssetManager::POS_HEAD);

		$this->app->assets->add('http://cdnjs.cloudflare.com/ajax/libs/parsley.js/1.2.2/parsley.min.js', AssetManager::TYPE_JS, AssetManager::POS_HEAD);

		$this->app->assets->add($this->app->getAssetUrl('js/app.js'), AssetManager::TYPE_JS, AssetManager::POS_BODY_BOTTOM);

		return parent::beforeExec($actionName, $params);
	}

    /**
     *
     */
    protected function addEditorAssets()
    {
        $this->app->assets->add('http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ace.js', AssetManager::TYPE_JS, AssetManager::POS_HEAD);
        $this->app->assets->add('http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ext-emmet.js', AssetManager::TYPE_JS, AssetManager::POS_HEAD);
        $this->app->assets->add('http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/mode-php.js', AssetManager::TYPE_JS, AssetManager::POS_HEAD);
    }
}