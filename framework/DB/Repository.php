<?php
namespace Framework\DB;

abstract class Repository
{
    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Lookup a model within the collection using it's id
     *
     * @param number $id
     * @return Framework\DB\Model|void
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

    public function all()
    {
        $query = $this->conn->query("SELECT * FROM {$this->table}");
        $models = [];
        while ($row = $query->fetch())
        {
            $models[] = $this->modelClass::build($row);
        }
        return $models;
    }
}
