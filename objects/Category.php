<?php
class Category
{
    //För databas
    private $conn;
    private $table = 'categories'; // Används i SQL query längre ner

    // Produkt värden
    public $id;
    public $name;

    // constructor för databasen, körs när classen körs och sätter databasen.
    public function __construct($db)
    {
        $this->conn = $db;

    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        //BindParam
        $stmt->bindParam(':name', $this->name);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

    // Hämta alla kategorier
    public function read()
    {
        //skapa query
        $query = 'SELECT * FROM ' . $this->table;
        //Prepare
        $stmt = $this->conn->prepare($query);
        //execute
        $stmt->execute();
        return $stmt;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET name = :name_IN WHERE id = :id_IN';
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //BindParam
        $stmt->bindParam(':name_IN', $this->name);
        $stmt->bindParam(':id_IN', $this->id);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);
        return false;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean
        $this->id = htmlspecialchars(strip_tags($this->id));
        //Bind
        $stmt->bindParam(':id', $this->id);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }
}