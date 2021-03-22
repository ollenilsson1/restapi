<?php
class Product
{
    //För databas
    private $conn;
    private $table = 'products'; // Används i SQL query längre ner

    // Produkt värden
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $description;
    public $imgUrl;
    public $price;
    public $quantity;
    public $created_at;
    public $keyword;

    // constructor för databasen, körs när classen körs och sätter databasen.
    public function __construct($db)
    {
        $this->conn = $db;

    }

    //Skapa Produkt
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
            SET
              title = :title,
              description = :description,
              imgUrl = :imgUrl,
              price = :price,
              quantity = :quantity,
              category_id = :category_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //BindParam
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':imgUrl', $this->imgUrl);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':category_id', $this->category_id);

        //execute
        if ($stmt->execute()) {
            return true;
        }

        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);

        return false;

    }

    // Hämta alla products
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
                    p.quantity,
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
                    p.quantity,
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
        $this->quantity = $row['quantity'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

    }

    public function updateTitle()
    {
        $query = 'UPDATE ' . $this->table . ' SET title = :title_IN WHERE id = :id_IN';
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //BindParam
        $stmt->bindParam(':title_IN', $this->title);
        $stmt->bindParam(':id_IN', $this->id);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);
        return false;
    }

    public function updateDescription()
    {
        $query = 'UPDATE ' . $this->table . ' SET description = :description_IN WHERE id = :id_IN';
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //BindParam
        $stmt->bindParam(':description_IN', $this->description);
        $stmt->bindParam(':id_IN', $this->id);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);
        return false;
    }

    public function updateImgUrl()
    {
        $query = 'UPDATE ' . $this->table . ' SET imgUrl = :imgUrl_IN WHERE id = :id_IN';
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //BindParam
        $stmt->bindParam(':imgUrl_IN', $this->imgUrl);
        $stmt->bindParam(':id_IN', $this->id);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);
        return false;
    }

    public function updatePrice()
    {
        $query = 'UPDATE ' . $this->table . ' SET price = :price_IN WHERE id = :id_IN';
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //BindParam
        $stmt->bindParam(':price_IN', $this->price);
        $stmt->bindParam(':id_IN', $this->id);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);
        return false;
    }

    public function updateQuantity()
    {
        $query = 'UPDATE ' . $this->table . ' SET quantity = :quantity_IN WHERE id = :id_IN';
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //BindParam
        $stmt->bindParam(':quantity_IN', $this->quantity);
        $stmt->bindParam(':id_IN', $this->id);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);
        return false;
    }

    public function updateCategory()
    {
        $query = 'UPDATE ' . $this->table . ' SET category_id = :category_id_IN WHERE id = :id_IN';
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //BindParam
        $stmt->bindParam(':category_id_IN', $this->category_id);
        $stmt->bindParam(':id_IN', $this->id);
        //execute
        if ($stmt->execute()) {
            return true;
        }
        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);
        return false;
    }

    function search(){
    $query = 'SELECT
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.description,
                    p.imgUrl,
                    p.price,
                    p.quantity,
                    p.created_at
                  FROM
                  ' . $this->table . '  p
                  LEFT JOIN
                    categories c ON p.category_id = c.id
                  WHERE
                    p.title LIKE :keyword_IN
                  OR
                    p.description LIKE :keyword_IN';

        //Prepare
        $stmt = $this->conn->prepare($query);
        //keyword
        $keyword = '%'. $this->keyword .'%';
        //Bind
        $stmt->bindParam(':keyword_IN', $keyword);
        //execute
        if ($stmt->execute()) {
            return $stmt;
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
