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
}