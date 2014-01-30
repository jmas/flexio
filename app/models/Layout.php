<?php

/**
 * @class Layout
 */
class Layout extends Model
{
	public function fields()
	{
		return array(
			'id',
			'name',
			'content',
			'content_html',
			'create_date',
			'update_date',
			'create_user_id',
			'update_user_id',
			'content_type',
		);
	}
	public function validators()
	{
		return array(
			'name'=>function($str) {
				return ! empty($str);
			},
            'content_html'=>function($str) {
				return ! empty($str);
			}
		);
	}
    
    public function beforeSave()
	{

 		if ($this->isNew()) { 
			$this->create_date = date('Y-m-d H:i:s');
			$this->create_user_id = Flexio::app()->auth->getId();
		} 
        
        $this->update_date = date('Y-m-d H:i:s');
        $this->update_user_id = Flexio::app()->auth->getId();
        var_dump($this);
		return parent::beforeSave(); 
	}
    
}