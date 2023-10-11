<?php

namespace App\Models;

use App\Db\Db;

/**
 * Base Model for Repository contain all CRUD operation 
 * and function for hydrate data into the repository
 * 
 * @package App\Db\Model
 */
class Model extends Db
{

    // Table name of the db
    protected $table;

    // Connection Instance
    private $db;

    /**
     * Handle prepare query and simple query
     * @param string $sql sql query to execute => "SELECT * FROM ..."
     * @param array $attributes array of value to prepare for sql query
     * @return PDOStatement|false
     */
    public function request(string $sql, array $attributes = null)
    {

        // Get the db connection instance
        $this->db = Db::getInstance();

        if ($attributes !== null) {
            // Prepare request
            $query = $this->db->prepare($sql);
            var_dump($query);
            var_dump($attributes);
            $query->execute($attributes);
            return $query;
        } else {
            // Simple request
            return $this->db->query($sql);
        }
    }

    /**
     * Find all CRUD operation
     * 
     * Query: SELECT * FROM table
     *
     * @return array Array of all records
     */
    public function findAll()
    {
        // echo "SELECT * FROM {$this->table}";
        $query = $this->request("SELECT * FROM {$this->table}");
        return $query->fetchAll();
    }

    /**
     * FindBy CRUD operation
     * @param array $conditions array of conditions. Usage: ["id" => 2]
     *
     * Query: SELECT * FROM table WHERE conditions
     * @return array Array of records found
     */
    public function findBy(array $conditions)
    {
        $fields = [];
        $values =  [];

        foreach ($conditions as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        $field_list = implode(' AND ', $fields);

        return $this->request("SELECT * FROM {$this->table} WHERE $field_list", $values)->fetchAll();
    }

    /**
     * Find by id CRUD operation
     * @param int $id 
     * Query: SELECT * FROM table WHERE id = $id
     * @return  Object containing the found record
     */
    public function findById(int $id)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE id = ?", [$id])->fetch();
    }


    /**
     * Create CRUD operation
     * @param Model $model  object to create 
     * Query: INSERT INTO table (column ...) VALUES (value ...)
     * @return bool
     */
    public function create()
    {
        $fields = [];
        $binders = [];
        $values = [];

        foreach ($this as $field => $value) {
            if ($value !== null && $field != 'db' && $field != 'table') {

                $fields[] = $field;
                $binders[] = "?";
                $values[] = $value;
            }
        }

        $fields_list = implode(', ', $fields);
        $binders_list = implode(', ', $binders);

        return $this->request("INSERT INTO {$this->table} ($fields_list) VALUES ($binders_list)", $values);
    }

    /**
     * Update CRUD oepration
     * @param int $id id of the record
     *
     * Query: UPDATE table SET column = value ... WHERE id = $id 
     * @return bool
     */
    public function update(int $id)
    {
        $fields = [];
        $values = [];

        foreach ($this as $field => $value) {
            if ($value !== null && $field != 'db' && $field != 'table') {
                $fields[] = "$field = ?";
                $values[] = $value;
            }

            $fields_list = implode(', ', $fields);
        }
        $values[] = $id;
        return $this->request("UPDATE {$this->table} SET $fields_list WHERE  id  = ?", $values);
    }

    /** 
     * Delete CRUD operation
     * @param int $id id of record
     * Query: DELETE FROM table WHERE id = $id
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->request("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    /**
     * LastId, return last inserted ID 
     *
     * @return void
     */
    public function LastId()
    {
        return $this->db->lastInsertId();
    }


    /**
     * Hydratation of data.
     * Exemple data: ["username"=>"user", "password" => "1234"] 
     * @param array $data
     * @return self hydrate object
     */
    public function hydrate($data): self
    {
        foreach ($data as $key => $value) {

            $methode = "set" . ucfirst($key);

            if (method_exists($this, $methode)) {
                $this->$methode($value);
            }
        }

        return $this;
    }
}
