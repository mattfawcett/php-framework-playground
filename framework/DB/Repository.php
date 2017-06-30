<?php
namespace Framework\DB;

use Framework\Interfaces\DB\ModelInterface;

abstract class Repository
{
    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Lookup a model within the collection using its id
     *
     * @param number $id
     * @return Framework\Interfaces\DB\ModelInterface|void
     */
    public function find($id)
    {
        $query = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
        $attributes = $query->fetch();
        if($attributes) {
            return $this->modelClass::build($attributes);
        }
    }

    /**
     * Retrieve all models from the database
     */
    public function all() : array
    {
        $query = $this->conn->query("SELECT * FROM {$this->table}");
        $models = [];
        while ($row = $query->fetch())
        {
            $models[] = $this->modelClass::build($row);
        }
        return $models;
    }

    /**
     * Delete a object with a given row from the database
     * @param number $id - The id of the model to remove
     * @return boolean - Returns true if a row was removed
     */
    public function remove($id) : bool
    {
        $query = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);

        return $query->rowCount() === 1;
    }

    /**
     * Update a model in the databse
     */
    public function update(ModelInterface $model) : ModelInterface
    {
        $sql = "UPDATE {$this->table} SET ";
        $updaters = [];
        foreach(array_keys($model->getAttributes()) as $key) {
            if($key !== 'id') {
                $updaters[] = "$key = :$key";
            }
        }
        $sql .= implode(', ', $updaters);
        $sql .= ' WHERE id = :id';

        $query = $this->conn->prepare($sql);
        $bindings = $model->getAttributes();
        $bindings['id'] = $model->getId();
        $query->execute($bindings);

        return $model;
    }

    /**
     * Add an object to the repository, returns the model with the id attribute
     * now set on it.
     */
    public function create(ModelInterface $model) : ModelInterface
    {
        $columnNames = implode(array_keys($model->getAttributes()), ' ,');
        $symbolizedColumnNames = array_map(function($key) {
            return ':' . $key;
        }, array_keys($model->getAttributes()));

        $valueNames = implode($symbolizedColumnNames, ' ,');

        $sql = "INSERT INTO {$this->table} ($columnNames) VALUES ($valueNames)";
        $query = $this->conn->prepare($sql);
        $query->execute($model->getAttributes());

        $model->forceFill(['id' => $this->conn->lastInsertId()]);
        return $model;
    }
}
