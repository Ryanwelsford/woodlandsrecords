<?php

class databasetable{
    private $table;
    private $pdo;
    private $primarykey;

    public function __construct($pdo,$table,$primarykey)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primarykey = $primarykey;
    }

    public function find($field,$value)
{
    $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
    $values = [
        'value' => $value
    ];
    $stmt->execute($values);
    return $stmt->fetchAll();
}

public function findAll()
{
    $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
    $stmt->execute();
    return $stmt->fetchAll();
}

public function insert($record)
{
    $keys = array_keys($record);

    $values = implode(', ', $keys);
    $valueswithcolon = implode(', :', $keys);

    $query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valueswithcolon . ')';
    $stmt = $this->pdo->prepare($query);

    $stmt->execute($record);
}

public function update($record)
{
    $query = 'UPDATE ' . $this->table . ' SET ';
    $parameters = [];
    foreach ($record as $key => $value) {
        $parameters[] = $key . ' = :' . $key;
    }

    $query = $query . implode(', ', $parameters);
    $query = $query . ' WHERE ' . $this->primarykey . ' = :primarykey';

    $record['primarykey'] = $record[$this->primarykey];

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($record);
}

public function delete($field, $value)
{
    $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
    $criteria = [
        'value' => $value
    ];
    $stmt->execute($criteria);
}


public function save($record)
{
    try{
        insert($this->pdo,$this->table,$record);
    }
    catch(Exception $e) {
        update($this->pdo, $this->table, $record, $this->primarykey);
    }
}

}
?>