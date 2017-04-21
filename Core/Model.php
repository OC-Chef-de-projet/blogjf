<?php namespace Core;

//require_once('App/config/database.php');

class Model extends \stdClass
{

	private $db = null;
	public function __construct(){
		$this->connect();
	}

	private function connect(){
		if(is_null($this->db)){

			$db = new \PDO(	'mysql:dbname='.Config::getInstance()->db('database').';'.
							'host='.Config::getInstance()->db('host'),
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

			$sql = 'DELETE FROM '.strtolower($model).' WHERE id=?';
			$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
			$sth->execute(array($pkey));

		} catch (\Exception $ex){
			error_log("DELETE : ".$ex->getMessage());
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


			$fields = 'count(*) as count';

			$sql = 'SELECT '.$fields.' FROM '.strtolower($model).' WHERE '.$w.' '.$order.' '.$limit;
			$result = $this->db->query($sql);

			$count = 0;
			if($result){
				$count = $result->fetch()->count;
			}

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
			if(isset($options['offset']) && is_numeric($options['offset'])){
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
			if(empty($w))$w = '1=1';


			if(isset($options['field']) && !empty($options['field'])){
				$fields = implode(',',$options['field']);
			} else {
				$fields = '*';
			}

			$sql = 'SELECT '.$fields.' FROM '.strtolower($model).' WHERE '.$w.' '.$order.' '.$limit.' '.$offset;
			
			//echo $sql.'<br>';
			$result = $this->db->query($sql);

			if(isset($options['type']) && $options['type'] == 'one'){
				return $result->fetch();
			} else {
				return $result->fetchAll();
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
			error_log("SQL : ".$ex->getMessage());
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


			$field = array();
			foreach($data as $key => $content){
				//$field[$key] = $this->db->quote($content);
				$field[$key] = $content;
			}

			// Vérifie si il y a un champ modified qui existe et met la date/heure courante
			$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".strtolower($model)."' AND column_name LIKE 'modified'";
			$result = $this->db->query($sql);
			if($result->fetch()){
				$field['modified'] = date('Y-m-d H:i:s');
			}

			// INSERT
			if(!isset($field['id']) || empty($field['id'])){

				// Vérifie si il y a un champ created existe et met la date/heure courante
				$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".strtolower($model)."' AND column_name LIKE 'created'";
				$result = $this->db->query($sql);
				if($result->fetch()){
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


				$sql = 'INSERT INTO '.strtolower($model).' ('.trim($keys,',').') VALUES ('.trim($values,',').');';

				$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
				$sth->execute($prepKeys);

				// Retourne l'enregistrement
				$sql = 'SELECT * FROM '.strtolower($model).' WHERE id = ?';
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
				$sql = 'UPDATE '.strtolower($model).' SET '.trim($fields,',').' WHERE `id` = :id';//.$field['id'].';';
				$sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
				$sth->execute($prepKeys);
				// Retourne l'enregistrement
				$sql = 'SELECT * FROM '.strtolower($model).' WHERE id = ?';
				$sth = $this->db->prepare($sql);
				$sth->execute(array($field['id']));
				$result = $sth->fetch();
			}
			//$this->db->close();
			return $result;
	 } catch(\Exception $ex){
	 	error_log($ex->getMessage());
		return false;
	 }
	}
}

