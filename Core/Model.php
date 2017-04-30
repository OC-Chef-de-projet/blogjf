<?php namespace Core;

abstract class Model extends \stdClass
{

	private $db = null;
	public function __construct(){
		$this->connect();
	}

	private function connect(){
		if(is_null($this->db)){

			$port = Config::getInstance()->db('port');
			if(!empty($port)){
				$port = ';port='.$port;
			}

			$db = new \PDO(	'mysql:dbname='.Config::getInstance()->db('database').';'.
							'host='.Config::getInstance()->db('host').$port,
								Config::getInstance()->db('login'),
								Config::getInstance()->db('password'),
								[
    								\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    								\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    								\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
    							]
							);
			$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->db = $db;
		}
		return true;
	}

	public function delete($pkey){

		try {

			$this->connect();

			$model = (new \ReflectionClass($this))->getShortName();
			$table = strtolower($model);
			$sql = "DELETE FROM `{$table}` WHERE id = ?";
			$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
			$sth->execute(array($pkey));

		} catch (\Exception $ex){
			return false;
		}
		return true;
	}


	public function count($options = array()){
		try {
			$this->connect();
			$model = (new \ReflectionClass($this))->getShortName();
			$where = [];
			if(isset($options['conditions']) && !empty($options['conditions'])){
				foreach($options['conditions'] as $key => $condition){
					if(is_numeric($condition)){
						$value = $condition;
					} else {
						$value = "'".$condition."'";
					}
					$where[] = ' '.$key.' = '.$value;
				}
			}
			$limit = '';
			if(isset($options['limit']) && !empty($options['limit'])){
				$limit = ' LIMIT '.(int)$options['limit'];
			}

			$order = '';
			if(isset($options['order']) && !empty($options['order'])){
				$orderBy = ' ORDER BY ';
				foreach($options['order'] as $k => $order){
					$orderBy .= $k.' '.$order.',';
				}
				$order = trim($orderBy,',');
			}

			$w = implode('AND',$where);
			if(empty($w))$w = '1=1';


			$table = strtolower($model);
			$sql = "SELECT count(*) as count FROM `{$table}` WHERE {$w} {$order} {$limit}";
			$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
			$sth->execute();
			$result = $sth->fetch();
			$count = $result->count;
		} catch (\Exception $ex){
				return false;
		}
		return $count;
	}


	public function find($options = array()){

		try {
			$this->connect();
			$model = (new \ReflectionClass($this))->getShortName();
			$where = [];
			if(isset($options['conditions']) && !empty($options['conditions'])){
				foreach($options['conditions'] as $key => $condition){
					if(is_numeric($condition)){
						$value = $condition;
					} else {
						$value = "'".$condition."'";
					}
					$operation = '=';
					if(preg_match('/</',$key)){
						$operation = '';
					}
					if(preg_match('/>/',$key)){
						$operation = '';
					} 
					$where[] = ' '.$key.$operation.$value;
				}
			}
			$limit = '';
			if(isset($options['limit']) && !empty($options['limit'])){
				$limit = ' LIMIT '.(int)$options['limit'];
			}

			$offset = '';
			if(isset($options['offset']) && is_numeric($options['offset']) && !empty($options['offset'])){
				$offset = ' OFFSET '.(int)$options['offset'];
			}

			$order = '';
			if(isset($options['order']) && !empty($options['order'])){
				$orderBy = ' ORDER BY ';
				foreach($options['order'] as $k => $order){
					$orderBy .= $k.' '.$order.',';
				}
				$order = trim($orderBy,',');
			}

			$w = implode('AND',$where);
			if(empty($w)){
				$args = [
					'1',
					'1'
				];
				$w = '? = ?';
			} else {
				$args = [];
			}


			if(isset($options['field']) && !empty($options['field'])){
				$fields = implode(',',$options['field']);
			} else {
				$fields = '*';
			}

			$table = strtolower($model);
			$sql = "SELECT {$fields} FROM `{$table}` WHERE {$w} {$order} {$limit} {$offset} ";
			$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
			$sth->execute($args);

			if(isset($options['type']) && $options['type'] == 'one'){
				return $sth->fetch();
			} else {
				return $sth->fetchAll();
			}
		} catch (\Exception $ex){
				return false;
		}
	}


	public function sql($sql,$args){
		if(empty($sql))return;

		try {
			$this->connect();
			$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
			$sth->execute($args);

		}catch(\Exception $ex){
			return false;
	 	}
	 	return true;
	}

	/**
	 * Enregistrement de données soit en INSERT soit en UPDATE
	 *
	 * Si le champ id est présent c'est un UPDATE,
	 * si il est absent ou = 0 c'est un INSERT
	 */
	public function save($data = ''){

		if(empty($data))return;

		try {

			$result = null; // valeur de retour

			$this->connect();


			$model = (new \ReflectionClass($this))->getShortName();
			$table = strtolower($model);

			$field = array();
			foreach($data as $key => $content){
				$field[$key] = $content;
			}
			// Vérifie si il y a un champ modified qui existe et met la date/heure courante
			$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ? AND column_name LIKE ?";
			$args = [
				$table,
				'modified'
			];
			$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
			$sth->execute($args);

			if($sth->fetch()){
				$field['modified'] = date('Y-m-d H:i:s');
			}

			// INSERT
			if(!isset($field['id']) || empty($field['id'])){
				// Vérifie si il y a un champ created existe et met la date/heure courante
				$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ? AND column_name LIKE ?";
				$args = [
					$table,
					'created'
				];
				$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
				$sth->execute($args);
				if($sth->fetch()){
					$field['created'] = date('Y-m-d H:i:s');
				}

				$keys = '';
				$values = '';
				$prepKeys = array();
				foreach($field as $key => $value ){
					$keys .= $key.',';
					$values .= ':'.$key.',';
					$prepKeys[':'.$key] = $value;
				}

				$keys = trim($keys,',');
				$values = trim($values,',');

				$sql = "INSERT INTO `{$table}` ({$keys}) VALUES ({$values});";

				$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
				$sth->execute($prepKeys);

				// Retourne l'enregistrement
				$sql = "SELECT * FROM `{$table}` WHERE id = ?";
				$sth = $this->db->prepare($sql);
				$sth->execute(array($this->db->lastInsertId()));
				$result = $sth->fetch();


			} else {
				// UPDATE
				$fields = '';
				$prepKeys = array();
				foreach($field as $key => $value ){
					$fields .= '`'.$key.'` = :'.$key.',';
					$prepKeys[':'.$key] = $value;
				}
				$sql = "UPDATE `{$table}` SET ".trim($fields,',')." WHERE `id` = :id";
				$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
				$sth->execute($prepKeys);
				// Retourne l'enregistrement
				$sql = "SELECT * FROM `{$table}` WHERE id = ?";
				$sth = $this->db->prepare($sql);
				$sth->execute(array($field['id']));
				$result = $sth->fetch();
			}
			return $result;
	 } catch(\Exception $ex){
		return false;
	 }
	}
}

