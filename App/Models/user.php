<?php 
require_once __DIR__ . "/../../Config/database.php";

class User{
    private $pdo;

    public function __construct(){
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function InsertWithVerify($nama,$email,$password,$gender,$role,$token){
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user 
                (nama_lengkap,email,password,gender,role,verification_token)
                VALUES (?,?,?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $nama,
            $email,
            $hash,
            $gender,
            $role,
            $token
        ]);
    }

    public function updateVerificationSentAt($email, $time){
        $stmt = $this->pdo->prepare("
            UPDATE user 
            SET verification_sent_at = ? 
            WHERE email = ?
        ");
        return $stmt->execute([$time, $email]);
    }

    public function getByToken($token){
        $sql = "SELECT * FROM user WHERE verification_token = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function saveResetToken($email, $token, $expired_at){
        try{
            $sql = "UPDATE user SET reset_password_token = :token, reset_password_expired_at = :expired WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':token' => $token,
                ':expired' => $expired_at,
                ':email' => $email
            ]);
        }catch(PDOException $e){
            die("Query gagal: " . $e->getMessage());
        }
    }

    public function getByResetToken($token){
        try{
            $sql = "SELECT * FROM user WHERE reset_password_token = :token LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':token' => $token]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            die("Query gagal: " . $e->getMessage());
        }
    }

    public function updatePasswordByToken($token, $password){
        try{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE user 
                    SET password = :password, reset_password_token = NULL, reset_password_expired_at = NULL 
                    WHERE reset_password_token = :token";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':password' => $hash,
                ':token' => $token
            ]);
        }catch(PDOException $e){
            die("Query gagal: " . $e->getMessage());
        }
    }

    public function verifyEmail($token){
        $sql = "UPDATE user 
                SET email_verified_at = NOW(), verification_token = NULL
                WHERE verification_token = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$token]);
    }

    public function Insert($nama_lengkap,$email,$password,$gender,$role){
        try{
            $sql = "INSERT INTO user(nama_lengkap,email,password,gender,role)
                    VALUES(:nama_lengkap,:email,:password,:gender,:role)";
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":nama_lengkap",$nama_lengkap);
            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":password",$hash);
            $stmt->bindParam(":gender",$gender);
            $stmt->bindParam(":role",$role);
            return $stmt->execute();
        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function checkEmail($email){
        try{
            $sql = "SELECT COUNT(*) FROM user WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":email",$email);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function updateUser($id_user, $nama_lengkap, $email, $password, $gender, $role){
        try {
            if(!empty($password)){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE user 
                        SET nama_lengkap = :nama_lengkap,
                            email = :email,
                            password = :password,
                            gender = :gender,
                            role = :role
                        WHERE id_user = :id_user";
            }else {
                $sql = "UPDATE user 
                        SET nama_lengkap = :nama_lengkap,
                            email = :email,
                            gender = :gender,
                            role = :role
                        WHERE id_user = :id_user";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":nama_lengkap", $nama_lengkap);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":gender", $gender);
            $stmt->bindParam(":role", $role);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_INT);

            if(!empty($password)){
                $stmt->bindParam(":password", $hash);
            }

            $stmt->execute();
            return true;
        } catch(PDOException $e){
            die("Query gagal: " . $e->getMessage());
        }
    }

    public function getById($id_user){
        try{
            $sql = "SELECT * FROM user WHERE id_user = :id_user";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id_user",$id_user);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function getByEmail($email){
        try{
            $sql = "SELECT * FROM user WHERE email = :email LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":email",$email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function countUser() {
        try {
            $sql = "SELECT COUNT(*) FROM user";
            $stmt = $this->pdo->query($sql);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function Select($limit = null, $offset = null){
        try{
            $sql = "SELECT * FROM user ORDER BY id_user ASC";

            if ($limit !== null && $offset !== null) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }

            $stmt = $this->pdo->prepare($sql);

            if ($limit !== null && $offset !== null) {
                $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
                $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function Delete($id_user){
        try{
            $sql = "DELETE FROM user WHERE id_user = :id_user";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id_user' =>$id_user]);
        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function getStatRole() {
        $stmt = $this->pdo->query("
            SELECT role, COUNT(*) as total
            FROM user
            GROUP BY role
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatGender() {
        $stmt = $this->pdo->query("
            SELECT gender, COUNT(*) as total
            FROM user
            GROUP BY gender
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserIdByName($nama){
        $stmt = $this->pdo->prepare(
            "SELECT id_user FROM user WHERE nama_lengkap = ? LIMIT 1"
        );
        $stmt->execute([$nama]);
        return $stmt->fetchColumn();
    }

    public function getStatVerifikasi() {
        $stmt = $this->pdo->query("
            SELECT 
                IF(email_verified_at IS NULL, 'belum', 'sudah') AS status,
                COUNT(*) as total
            FROM user
            GROUP BY status
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserHarian() {
        $stmt = $this->pdo->query("
            SELECT DATE(created_at) as tanggal, COUNT(*) as total
            FROM user
            GROUP BY DATE(created_at)
            ORDER BY tanggal ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cekEmail($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function insertUser($data) {
        $sql = "INSERT INTO user (nama_lengkap, email, gender, role, password, created_at, email_verified_at)
                VALUES (:nama, :email, :gender, :role, :password, :created_at, :email_verified_at)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nama' => $data['nama_lengkap'],
            ':email' => $data['email'],
            ':gender' => $data['gender'],
            ':role' => $data['role'],
            ':password' => $data['password'],
            ':created_at' => $data['created_at'],
            ':email_verified_at' => $data['email_verified_at']
        ]);
    }
}