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

// Simpan token reset password
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

// Ambil user berdasarkan token reset password
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

// Update password berdasarkan token reset
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
            $stmt->bindParam(":role",$role); // <-- Tambahkan ini
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
            // Jika password tidak kosong, lakukan hash
            if(!empty($password)){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE user 
                        SET nama_lengkap = :nama_lengkap,
                            email = :email,
                            password = :password,
                            gender = :gender,
                            role = :role
                        WHERE id_user = :id_user";
            } else {
                // Jika password kosong, jangan update password
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
}

$user = new User();
// $user->Insert("Fadlan Firdaus","fadlanfirdaus220@gmail.com","fadlan123","L");
$data = $user->Select();
// $data = $user->getByEmail('fadlanfirdaus220@gmail.com');
// var_dump($data);
?>