<?php

/**
 * @class Layout
 */
class Layout extends Model
{
	public function getLayouts()
	{
		return $layouts = glob(LAYOUTS_PATH . DIRECTORY_SEPARATOR . '*.php');
	}
    
    public function getLayout($name)
	{
        return file_get_contents(LAYOUTS_PATH . DIRECTORY_SEPARATOR . $name . '.php');
	}
    
    public function save()
	{
        $data = Flexio::app()->request->getPost('data');
        return file_put_contents(LAYOUTS_PATH . DIRECTORY_SEPARATOR . $data['name'] . '.php', $data['content']);
	}
    public function update($name)
    {
		$data = Flexio::app()->request->getPost('data');
        if($data['name'] !== $name) { $this->delete($name); }
        return file_put_contents(LAYOUTS_PATH . DIRECTORY_SEPARATOR . $data['name'] . '.php', $data['content']);
    }
    
    public function delete($name)
    {
        return unlink(LAYOUTS_PATH . DIRECTORY_SEPARATOR . $name . '.php');
    }
    
}