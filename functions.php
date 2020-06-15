<?php

function find($pdo,$table,$field,$value)
{
    $stmt = $pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . $field . ' = :value');
    $values = [
        'value' => $value
    ];
    $stmt->execute($values);
    return $stmt->fetchAll();
}

function findAll($pdo,$table)
{
    $stmt = $pdo->prepare('SELECT * FROM ' . $table);
    $stmt->execute();
    return $stmt->fetchAll();
}

function insert($pdo,$table,$record)
{
    $keys = array_keys($record);

    $values = implode(', ', $keys);
    $valueswithcolon = implode(', :', $keys);

    $query = 'INSERT INTO ' . $table . ' (' . $values . ') VALUES (:' . $valueswithcolon . ')';
    $stmt = $pdo->prepare($query);

    $stmt->execute($record);
}

function update($pdo,$table,$record,$primarykey)
{
    $query = 'UPDATE ' . $table . ' SET ';
    $parameters = [];
    foreach ($record as $key => $value) {
        $parameters[] = $key . ' = :' . $key;
    }

    $query = $query . implode(', ', $parameters);
    $query = $query . ' WHERE ' . $primarykey . ' = :primarykey';

    $record['primarykey'] = $record[$primarykey];

    $stmt = $pdo->prepare($query);
    $stmt->execute($record);
}

function delete($pdo, $table, $field, $value)
{
    $stmt = $pdo->prepare('DELETE FROM ' . $table . ' WHERE ' . $field . ' = :value');
    $criteria = [
        'value' => $value
    ];
    $stmt->execute($criteria);
}

function save($pdo, $table, $record, $primarykey)
{
    try{
        insert($pdo,$table,$record);
    }
    catch(Exception $e) {
        update($pdo, $table, $record, $primarykey);
    }
}

?>