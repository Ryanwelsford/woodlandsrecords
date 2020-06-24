<?php
namespace RWCSY2028;
class DatabaseTable {
	private $pdo;
	private $table;
	private $primaryKey;
	private $entityClass;
	private $entityConstructor;

	//build class constructor, sets entity class to std class when a created class is not required
	public function __construct($pdo, $table, $primaryKey, $entityClass = 'stdclass', $entityConstructor = []) {
		$this->pdo = $pdo;
		$this->table = $table;
		$this->primaryKey = $primaryKey;
		$this->entityClass = $entityClass;
		$this->entityConstructor = $entityConstructor;
	}

	//find a value in table based on field given, returns array of object
	public function find($field, $value) {
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$criteria = [
			'value' => $value
		];
		$stmt->execute($criteria);
		return $stmt->fetchAll();
	}
	public function findLike($field, $value, $limit = false) {
		$limitString = '';
		if($limit != false) {
			$limitString = ' LIMIT '.$limit['offset'].', '.$limit['total'];
		}
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' LIKE :value ORDER BY '.$field.$limitString);

		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$criteria = [
			'value' => '%'.$value.'%'
		];
		$stmt->execute($criteria);
		return $stmt->fetchAll();
	}

	//search all fields passed for any value passed for whatever limit
	//functions like a query that has multiple like/or statements for every field and seperate value. Uses REGEXP or regular expression matching
	//https://stackoverflow.com/questions/4172195/mysql-like-multiple-values
	public function findGeneralLike($fields, $value, $limit) {
		//set up limit string if passed, allows for pagenation
		$limitString = '';
		if($limit != false && isset($limit['offset']) && isset($limit['total'])) {
			$limitString = ' LIMIT '.$limit['offset'].', '.$limit['total'];
		}

		//set up values seperated with | for regexp matching, explode passed $value to break up around spaces, if multiple words passed
		$searchValues = explode(' ',$value);
		$valueString = '';
		foreach($searchValues as $ivalue) {
			$valueString .= $ivalue.'|';
		}
		//remove final bar
		$valueString = substr($valueString, 0, -1);

		//var_dump($valueString);

		//set up fields string, search all passed fields adds in command and placeholder with OR
		$fieldsString = '';
		$intlimit = 1;
		foreach($fields as $field) {
			if($intlimit < sizeof($fields)) {
				$fieldsString .= $field.' REGEXP :value OR ';
			}
			else {
				$fieldsString .= $field.' REGEXP :value';
			}
			$intlimit++;
		}
		//create overall query string
		$stmtstring = 'SELECT * FROM '. $this->table. ' WHERE '.$fieldsString.$limitString;
		//var_dump($stmtstring);
		//set fetch mode to return a class rather than array
		$stmt = $this->pdo->prepare($stmtstring);
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);

		//replace placeholder with valuestring
		$criteria = [
			':value' => $valueString
		];
		
		$stmt->execute($criteria);
		
		return $stmt->fetchAll();

	}

	//find all records in table, returns array of objects
	public function findAll() {
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute();

		return $stmt->fetchAll();
	}
	public function searchAllFields($fields, $values) {

	}
	//insert into table based on passed data, pulls out array keys to use as table columns
	public function insert($record) {
	        $keys = array_keys($record);

	        $values = implode(', ', $keys);
	        $valuesWithColon = implode(', :', $keys);

	        $query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';

	        $stmt = $this->pdo->prepare($query);

	        $stmt->execute($record);
	}

	//remove from table based on id passed
	public function delete($id) {
		$stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id');
		$criteria = [
			'id' => $id
		];
		$stmt->execute($criteria);
	}

	public function deleteWhere($field, $value, $limit = false) {
		$limitstring = '';
		if($limit != false) {
			$limitstring = ' LIMIT '.$limit; 
		}
		$stmtstring = 'DELETE FROM '.$this->table.' WHERE '.$field. ' = :value'.$limitstring;

		$stmt = $this->pdo->prepare($stmtstring);
		$values = [
			':value' => $value
		];
		$stmt->execute($values);
	}

	public function desc() {
		$stmt = $this->pdo->prepare('SHOW COLUMNS FROM '.$this->table);
		$stmt->execute();
		$results = $stmt->fetchAll();
		return $results;
	}

	//attempt to insert if fail, run update instead
	//failure to insert caused by having two instances of an id
	public function save($record) {
		try {
			$this->insert($record);
		}
		catch (\Exception $e) {
			$this->update($record);
		}
	}
	//convert passed object into array then pass to save function, used in conjunction with entity and std classes
	public function saveObject($object) {
		$record = (array) $object;
		$this->save($record);
	}

	//update record 
	public function update($record) {

	         $query = 'UPDATE ' . $this->table . ' SET ';

	         $parameters = [];
	         foreach ($record as $key => $value) {
	                $parameters[] = $key . ' = :' .$key;
	         }

	         $query .= implode(', ', $parameters);
	         $query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';

	         $record['primaryKey'] = $record[$this->primaryKey];

	         $stmt = $this->pdo->prepare($query);

	         $stmt->execute($record);
	}

	// pass a multidimensonal array with field,value,operator,conjuction. returns set of db results that satisfy all index of array
    public function restrictionFind($array) {
        //build string up to where clause
        $arrayString = 'SELECT * FROM '.$this->table.' WHERE ';
        $values = array();
        //loop through array as list pull 1st value as field, 2nd as the value to search for, 3rd as the operator to use, 4th is the conjuction between statements i.e and/or
        
        $subStringTrim = 3;
        // can make this better by assigning keys to array passed i.e. the array would have a field "field" => fieldvalue then list would have as ['field' = $field, 'value' = $value etc]
        //trackes the value to be removed from string due to final conjuction
       foreach($array as list($field,$value,$operator, $conjuction)) {
            $arrayString .= $field.' '.$operator.' ' .':'.$field.' '.$conjuction.' ';
            $values[$field] = $value;
            $subStringTrim = strlen($conjuction)+1;
       }
       // remove final AND from string
       $queryString = substr($arrayString, 0, -$subStringTrim);
	   //var_dump($queryString);
	   $stmt = $this->pdo->prepare($queryString);
	   $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
       $stmt->execute($values);
       // fetch all for multi result
       $results = $stmt->fetchAll();
       return $results;
    }

	//count x in table based on field and value
	public function count($countThis,$field, $value) {
        $query = $this->pdo->prepare('SELECT COUNT('.$countThis.') FROM '.$this->table.' WHERE '.$field.' LIKE :value');
        $values = ['value' => $value];
		var_dump($query);
        $query->execute($values);
        //var_dump($query);
        $results = $query->fetch();
        //var_dump($results);
        return $results;
	}
	
	//find all rows in a db restricted to a list of values in the order passed
	public function findAndOrder($field, $value, $operator, $option) {
		$stmt = $this->pdo->prepare('SELECT * FROM '.$this->table. ' WHERE '.$field. ' ' . $operator. ' :value ORDER BY '.$field.' '.$option);
		$values = [
			'value' => $value
		];
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute($values);
        $results = $stmt->fetchAll();
        return $results;
	}
	
	//find all elements in table that match value based on field, order by field with given option and the limit passed
	public function findAndOrderLimit($field, $value, $operator, $option, $limit) {
		$stmt = $this->pdo->prepare('SELECT * FROM '.$this->table. ' WHERE '.$field. ' ' . $operator. ' :value ORDER BY '.$field.' '.$option. ' LIMIT '.$limit);
		$values = [
			'value' => $value
		];
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute($values);
		//var_dump($stmt);
        $results = $stmt->fetchAll();
        return $results;
	}
	public function findLatestRecord($field = 'id') {
		$stmt = $this->pdo->prepare('SELECT * FROM '.$this->table.' WHERE '.$field.' = (SELECT max('.$field.') FROM '.$this->table.')');
		$stmt->execute();
		$result = $stmt->fetch();
		return $result;
	}
	
	public function findBetweenOrdered($field, $value1, $value2, $order) {
		$value1 = "'".$value1."'";
		$value2 = "'".$value2."'";
		$stmtstring = 'SELECT * FROM '.$this->table. ' WHERE '.$field. " BETWEEN ".$value1. " AND ". $value2 . " ORDER BY ";
		$ordersection ='';
		foreach($order as $each) {
			$ordersection .= $each.", ";
		}
		$ordersection = substr($ordersection, 0, -2);
		$values = [
			'value1' => $value1,
			'value2' => $value2
		];
		$stmtstring .= $ordersection;

		$stmt = $this->pdo->prepare($stmtstring);
		$stmt->execute($values);
		$results = $stmt->fetchAll();
		return $results;
		//SELECT * FROM woodlands.appointment WHERE date BETWEEN '2020-06-01' AND '2020-06-30';
		//SELECT * FROM appointment WHERE date BETWEEN 2020-06-01 AND 2020-06-30 ORDER BY date, start_time
	}
}