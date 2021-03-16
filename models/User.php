<?php
class User
{
    //för databas
    private $conn;
    private $table = 'users';

    // Värden för user
    public $userID;
    public $fname;
    public $lname;
    public $username;
    public $password;
    public $email;
    public $role;
    public $created_at;

    //Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Hämta alla users
    public function read_users()
    {
        //skapa query
        $query = 'SELECT
                    u.userID,
                    u.fname,
                    u.lname,
                    u.username,
                    u.password,
                    u.email,
                    u.created_at,
                    u.role
                  FROM
                  ' . $this->table . '  u
                  ORDER BY
                    u.created_at DESC';

        //Prepare
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;

    }

    public function read_single_user()
    {
        //skapa query
        $query = 'SELECT
                    u.userID,
                    u.fname,
                    u.lname,
                    u.username,
                    u.password,
                    u.email,
                    u.created_at,
                    u.role
                  FROM
                  ' . $this->table . '  u
                  WHERE
                    u.userID = ?
                    LIMIT 0,1';

        //Prepare
        $stmt = $this->conn->prepare($query);

        //Binda id till ? i SQL
        $stmt->bindParam(1, $this->id); // Eftersom det bara finns en parameter '?' i SQL frågan 1, this ID

        //execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Sätta värden
        $this->userID = $row['userID'];
        $this->fname = $row['fname'];
        $this->lname = $row['lname'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->email = $row['email'];
        $this->created_at = $row['created_at'];
        $this->role = $row['role'];

    }

}
