<?php
namespace Framework\DB;

abstract class Repository
{
    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function find($id)
    {
        $query = $this->conn->prepare("select * from {$this->table} where id = :id");
        $query->execute(['id' => $id]);
        $attributes = $query->fetch();
        return $this->modelClass::build($attributes);
    }
}
