<?php

/**
 * @class ModelManager
 */
class ModelManager
{
	/**
	 *
	 */
	protected $db;

	/**
	 *
	 */
	protected $dbConnectionName='db';

	/**
	 *
	 */
	public function __construct($config=array())
	{
		foreach ($config as $key => $value) {
			if (property_exists($this, $key)) {
				if (isset($this->{$key})) {
					$this->{$key} = $value;
				}
			}
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
        	$return[] = $this->create($className, $record);
      //   	new $className(array(
      //   		'attrs'=>$record,
      //   		'db'=>$this->getDb(),
      //   		'manager'=>$this,
    		// ));
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
        	return $this->create($className, $record);
      //   	return new $className(array(
      //   		'attrs'=>$record,
      //   		'db'=>$this->getDb(),
      //   		'manager'=>$this,
    		// ));
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
        
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute($values);
        
        return (int) $stmt->fetchColumn();
	}

	/**
	 *
	 */
	public function create($className, $attrs=array())
	{
		$join = $className::join();

		if ($join !== null && is_array($join)) {
			foreach ($join as $joinName=>$joinItem) {
				$className = $joinItem['className'];

				$columns = $className::fields();

				$joinAttrs = array();

				foreach ($columns as $columnName) {
					if (isset($attrs[$joinName . '_' . $columnName])) {
						$joinAttrs[$columnName] = $attrs[$joinName . '_' . $columnName];
						unset($attrs[$joinName . '_' . $columnName]);
					}
				}

				$attrs[$joinName] = $this->create($className, $joinAttrs);
			}
		}

		return new $className(array(
			'attrs'=>$attrs,
			'db'=>$this->getDb(),
			'manager'=>$this,
		));
	}

	/**
	 *
	 */
	private function getDb()
	{
		if ($this->db===null) {
			$name=$this->dbConnectionName;
			$this->db = Flexio::app()->{$name};
		}

		return $this->db;
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

		$baseTable = $this->tableByClass($className);

		$select = array($baseTable . '.*');
		$from = array($this->tableByClass($className).' AS ' . $baseTable);

		$join = $className::join();

		if ($join !== null && is_array($join)) {
			foreach ($join as $joinName=>$joinItem) {
				$className = $joinItem['className'];
				$on = $joinItem['on'];

				$columns = $className::fields();
				$selectColumns = array();

				$table = $this->tableByClass($className);
				$onItems = array();

				foreach ($columns as $c) {
					$select[] = $joinName . '.' . $c . ' AS ' . $joinName . '_' . $c;
				}

				foreach ($on as $k=>$v) {
					$onItems[] = $baseTable . '.' . $k . '=' . $joinName . '.' . $v;
				}

				$from[] = $table . ' AS ' . $joinName . ' ON ' . implode(',', $onItems);
			}
		}

		$sql = 'SELECT ' . implode(',', $select) . ' FROM '. implode(' LEFT JOIN ', $from) . ' '.$suffix;

        $stmt = $this->getDb()->prepare($sql);
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