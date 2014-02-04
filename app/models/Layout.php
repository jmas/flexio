<?php

/**
 * @class Layout
 */
class Layout extends Model
{
	public static function join()
	{
		return array(
			'createdBy'=>array(
				'className'=>'User',
				'on'=>array(
					'create_user_id'=>'id',
				),
			),
			'updatedBy'=>array(
				'className'=>'User',
				'on'=>array(
					'update_user_id'=>'id',
				),
			),
		);
	}

	public static function fields()
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
			'name'=>function($key, $model) {
				$value = $model->getAttr($key);

				if (empty($value)) {
					$model->addError($key, 'Field is required.');
				}
			},
            'content'=>function($key, $model) {
				$value = $model->getAttr($key);

				if (empty($value)) {
					$model->addError($key, 'Field is required.');
				}
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
        
		return parent::beforeSave(); 
	}
}