<?php

/**
 * @class ModelFinder
 */
class ModelFinder
{
	/**
	 *
	 */
	protected $db;

	/**
	 *
	 */
	public function __construct($config=array())
	{
		if (property_exists($this, $key)) {
			if (isset($this->{$key})) {
				$this->{$key} = $value;
			}
		}

		if (isset($config['dbConnectionName'])) {
			$name=$config['dbConnectionName'];
			$this->db = App::instance()->{$name};
		}
	}

	/**
	 *
	 */
	public function findAll($className, $args=array(), $values=array())
	{
		$return = array();

		$records = $this->finder($className, $args, $values);

        foreach ($records as $record) {
        	$return[] = new $className(array(
        		'attrs'=>$record,
        		'db'=>$this->db,
    		));
        }

        return $return;
	}

	/**
	 *
	 */
	public function find($className, $args=array(), $values=array())
	{
		$record = $this->finder($className, $args, $values, true);

         if (! empty($record)) {
        	return new $className(array(
        		'attrs'=>$record,
        		'db'=>$this->db,
    		));
        }

        return null;
	}

	/**
	 *
	 */
	public function findAllByAttrs($className, array $attrs)
	{
		$where = array();
		$values = array();

		foreach ($attrs as $key=>$value) {
			$values[':'.$key] = $value;
			$where[] = $key.'=:'.$key;
		}

		$where = implode(' AND ', $where);

		return $this->findAll($className, $where, $values);
	}

	/**
	 *
	 */
	public function findByAttrs($className, array $attrs)
	{
		$where = array();
		$values = array();

		foreach ($attrs as $key=>$value) {
			$values[':'.$key] = $value;
			$where[] = $key.'=:'.$key;
		}

		$where = implode(' AND ', $where);

		return $this->find($className, $where, $values);
	}

	/**
	 *
	 */
	public function findById($className, $id)
	{
		return $this->find($className, 'id=:id', array(':id'=>$id));
	}

	/**
	 *
	 */
	public function count($className, $args=array(), $values=array())
	{
		$suffix = $this->buildQuerySuffix($args);

		$sql = 'SELECT COUNT(*) AS nb_rows FROM '.$this->tableByClass($className).' '.$suffix;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        
        return (int) $stmt->fetchColumn();
	}

	/**
	 *
	 */
	protected function finder($className, $args=array(), $values=array(), $isSingle=false)
	{
		if (gettype($args) === 'string') {
			$args = array(
				'where'=>$args,
			);
		}

		if ($isSingle) {
			$args['limit'] = 1;
		}

		$suffix = $this->buildQuerySuffix($args);

		$sql = 'SELECT * FROM '.$this->tableByClass($className).' '.$suffix;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);

        $result = null;

        if ($isSingle) {
        	$result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
        	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if (empty($result)) {
        	return $isSingle ? null: array();
        }

        return $result;
	}

	/**
	 *
	 */
	protected function buildQuerySuffix($args)
	{
		$suffix = '';

		if (empty($args)) {
			return $suffix;
		}

		if (gettype($args) === 'string') {
			$args = array(
				'where'=>$args,
			);
		}

		$where   = isset($args['where'])  ? $args['where']: '';
        $order   = isset($args['order'])  ? $args['order']: '';
        $offset  = isset($args['offset']) ? $args['offset']: 0;
        $limit   = isset($args['limit'])  ? $args['limit']: 0;

        $suffix .= trim($where) === '' ? '': " WHERE {$where} ";
        $suffix .= empty($order) ? '': " ORDER BY {$order} ";
        $suffix .= (int) $limit > 0 ? " LIMIT {$offset}, {$limit} " : '';

        return $suffix;
	}

	/**
	 *
	 */
	protected function tableByClass($className)
	{
		return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $className));
	}
}