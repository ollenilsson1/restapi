<?php
class Product
{
    //För databas
    private $conn;
    private $table = 'products'; // Används i SQL query längre ner

    // Post värden
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $description;
    public $imgUrl;
    public $price;
    public $created_at;

    // constructor för databasen, körs när classen körs och sätter databasen.
    public function __construct($db)
    {
        $this->conn = $db;

    }

    // Hämta products
    public function read()
    {
        //skapa query
        $query = 'SELECT
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.description,
                    p.imgUrl,
                    p.price,
                    p.created_at
                  FROM
                  ' . $this->table . '  p
                  LEFT JOIN
                    categories c ON p.category_id = c.id
                  ORDER BY
                    p.created_at DESC';

        //Prepare
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;

    }

    public function read_single()
    {
        //skapa query
        $query = 'SELECT
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.description,
                    p.imgUrl,
                    p.price,
                    p.created_at
                  FROM
                  ' . $this->table . '  p
                  LEFT JOIN
                    categories c ON p.category_id = c.id
                  WHERE
                    p.id = ?
                    LIMIT 0,1';

        //Prepare
        $stmt = $this->conn->prepare($query);

        //Binda id till ? i SQL
        $stmt->bindParam(1, $this->id); // Eftersom det bara finns en parameter '?' i SQL frågan 1, this ID

        //execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Sätta värden
        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->imgUrl = $row['imgUrl'];
        $this->price = $row['price'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

    }
    //Skapa post
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
        SET
          title = :title,
          description = :description,
          imgUrl = :imgUrl,
          price = :price,
          category_id = :category_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //BindParam
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':imgUrl', $this->imgUrl);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category_id', $this->category_id);

        //execute
        if ($stmt->execute()) {
            return true;
        }

        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);

        return false;

    }

    // Uppdatera produkt
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
        SET
          title = :title,
          description = :description,
          imgUrl = :imgUrl,
          price = :price,
          category_id = :category_id
        WHERE
          id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //BindParam
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':imgUrl', $this->imgUrl);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        //execute
        if ($stmt->execute()) {
            return true;
        }

        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);

        return false;

    }

    //Delete post
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
