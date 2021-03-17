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

    //Skapa user
    public function create_user()
    {
        if (!empty($this->fname) && !empty($this->lname) && !empty($this->username) && !empty($this->password) && !empty($this->email)) {

            $query1 = "SELECT userID FROM users WHERE username=:username OR email=:email";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindParam(':username', $this->username);
            $stmt1->bindParam(':email', $this->email);

            if (!$stmt1->execute()) {
                echo "Something went wrong";
                die();
            }

            $num_rows = $stmt1->rowCount();
            if ($num_rows > 0) {
                echo "User is already registered";
                die();
            }

            $query = 'INSERT INTO ' . $this->table . '
            SET
              fname = :fname,
              lname = :lname,
              username = :username,
              password = :password,
              email = :email';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->fname = htmlspecialchars(strip_tags($this->fname));
            $this->lname = htmlspecialchars(strip_tags($this->lname));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->email = htmlspecialchars(strip_tags($this->email));

            //Kryptera lösenord
            $salt = "siahbndjiasnidja12893183s9300";
            $this->password = md5($this->password . $salt);

            //BindParam
            $stmt->bindParam(':fname', $this->fname);
            $stmt->bindParam(':lname', $this->lname);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':email', $this->email);

            //execute
            if ($stmt->execute()) {
                return true;
            }

            //error om den inte körs
            printf("ERROR: %s.\n", $stmt->error);

            return false;
        } else {
            echo "Fill in all the fields!";
            die();
        }
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

    //Delete post
    public function delete_user()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE userID = :userID';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean
        $this->userID = htmlspecialchars(strip_tags($this->userID));
        //Bind
        $stmt->bindParam(':userID', $this->userID);
        /* $stmt->bindParam(1, $this->id); */

        //execute
        if ($stmt->execute()) {
            return true;
        }

        //error om den inte körs
        printf("ERROR: %s.\n", $stmt->error);

        return false;
    }

}
