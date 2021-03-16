<?php
class Post
{
    //För databas
    private $conn;
    private $table = 'posts'; // Används i SQL query längre ner

    // Post värden
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // constructor för databasen, körs när classen körs och sätter databasen.
    public function __construct($db)
    {
        $this->conn = $db;

    }

    // Hämta posts
    public function read()
    {
        //skapa query
        $query = 'SELECT
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
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
                    p.body,
                    p.author,
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
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

    }
    //Skapa post
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
        SET
          title = :title,
          body = :body,
          author = :author,
          category_id = :category_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //BindParam
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        //execute
        if ($stmt->execute()) {
            return true;
        }

        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);

        return false;

    }

    // Updatera post
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
        SET
          title = :title,
          body = :body,
          author = :author,
          category_id = :category_id
        WHERE
          id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //BindParam
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
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
