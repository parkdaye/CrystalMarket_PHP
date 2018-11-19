<?php
 
/**
 * @author Ravi Tamada
 * @link https://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
 
class DB_Functions {
 
    public $conn;
 
    // constructor
    function __construct() {
        require_once 'include/DB_Connect.php';
        // connecting to database
        $db = new DB_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($id, $name, $password, $nickname, $major, $student_num, $phone_num, $email) {
        $hash = $this->hashSSHA($password); //비밀번호 해쉬화
        $epassword = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $stmt = $this->conn->prepare("INSERT INTO users(id, name, password, nickname, major, student_num, phone_num, email, salt) 
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $id, $name, $epassword, $nickname, $major, $student_num, $phone_num, $email, $salt);
        $result = $stmt->execute();
        $stmt->close(); 
    
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return NULL;
        }
    }

    public function storeProduct($vendor_id, $products_name, $products_price, $products_info, $category, $products_pic) {
       
        $stmt = $this->conn->prepare("INSERT INTO products(products_pic, products_name, price, category, products_info, created_at, vendor_id) 
        VALUES(?, ?, ?, ?, ?, NOW(), ?)");
        
        $stmt->bind_param("ssssss", $products_pic, $products_name, $products_price, $category, $products_info, $vendor_id);
        $result = $stmt->execute();
        $stmt->close(); 
    
        // check for successful store
        if ($result) {
            /*
            $stmt = $this->conn->prepare("SELECT * FROM products WHERE products_name = $products_pic and vendor_id = $vendor_id");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $product;
            */
            return true;
        } else {
            return false;
        }
    }
 


    /**
     * Get user by id and password
     */
    public function getUserByIdAndPassword($id, $password) {
 
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
 
        $stmt->bind_param("s", $id);
 
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            // verifying user password
            $salt = $user['salt'];
            $epassword = $user['password'];
            $hash = $this->checkhashSSHA($salt, $password); //해시값 새성
            // check for password equality
            if ($epassword == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($id) {
        $stmt = $this->conn->prepare("SELECT id from users WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
 
    public function ctf_click($id)
    {
        echo "<script>alert(\"$id 의 인증을 완료했습니다.\");</script>";
        echo "<br/>\n";

        $stmt = $this->conn->prepare("UPDATE users set certification = 1 WHERE id = ?"); //인증허용 상태
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->close();
    }

    public function nctf_click($id)
    {
        echo "<script>alert(\"$id 의 인증을 거부했습니다.\");</script>";
        echo "<br/>\n";

        $stmt = $this->conn->prepare("UPDATE users set certification = 2 WHERE id = ?"); //인증거부 상태
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->close();
    }

     public function getProductByNum($products_num) {
 
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE products_num = ?");
 
        $stmt->bind_param("s", $products_num);
 
        if ($stmt->execute()) {
            $product = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $product;
        } else {
            return NULL;
        }
    }

    public function addScrap($id, $pnum) {
        $stmt = $this->conn->prepare("SELECT * from scrap WHERE scrap_id = ? and scrap_pnum = ?");
        $stmt->bind_param("ss", $id, $pnum);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // existed 
            $stmt->close();
            return false;
        } else {
            // not existed
            //$stmt->close();

            $stmt = $this->conn->prepare("INSERT INTO scrap(scrap_id, scrap_pnum) VALUES(?, ?)");
            $stmt->bind_param("ss", $id, $pnum);
            $stmt->execute();
            $stmt->close();

            return true;
        }
    }


    public function addCmt($id, $pnum, $cmt) {
       
        $stmt = $this->conn->prepare("INSERT INTO comment(cmt_id, cmt_pnum, cmt_sub, created_at) VALUES(?, ?, ?, NOW())");
        
        $stmt->bind_param("sss", $id, $pnum, $cmt);
        $result = $stmt->execute();
        $stmt->close(); 
    
        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function addReview($reviewing_id, $reviewed_id, $contents, $rating) {
       
        $stmt = $this->conn->prepare("INSERT INTO review(reviewing_id, reviewed_id, rev_sub, rating) VALUES(?, ?, ?, ?)");
        
        $stmt->bind_param("ssss", $reviewing_id, $reviewed_id, $contents, $rating);
        $result = $stmt->execute();
        $stmt->close(); 
    
        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function addReport($ring_id, $red_id, $reason) {
       
        $stmt = $this->conn->prepare("INSERT INTO report(reporting_id, reported_id, report_reason) VALUES(?, ?, ?)");
        
        $stmt->bind_param("sss", $ring_id, $red_id, $reason);
        $result = $stmt->execute();
        $stmt->close(); 
    
        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function addReport2($ring_id, $red_id, $reason, $sum) {
       
        $stmt = $this->conn->prepare("INSERT INTO report VALUES(?, ?, ?, ?)");
        
        $stmt->bind_param("ssss", $ring_id, $red_id, $reason, $sum);
        $result = $stmt->execute();
        $stmt->close(); 
    
        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}
 
?>
