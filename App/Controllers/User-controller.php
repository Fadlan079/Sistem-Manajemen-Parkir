<?php 
require_once __DIR__ . "/../Models/user.php"; 

class USERController{
    private $modelUser; 

    public function __construct() { 
        $this->modelUser = new User(); 
    } 

    public function ManageUser() { 
        $current = 'manage-user'; 
        $limit = 5; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
        $page = max($page, 1); 
        $p = ($page - 1) * $limit + 1; 
        $offset = ($page - 1) * $limit; 
        $listUser = $this->modelUser->Select($limit, $offset); 
        $totalData = $this->modelUser->countUser(); 
        $totalPages = ceil($totalData / $limit); 
        include __DIR__ . "/../../Resources/Views/Pages/manage-user.php"; 
    } 

    public function ShowTambahUser() { 
        include __DIR__ . "/../../Resources/Views/components//Form/form-tambah-user.php"; 
    } 

    public function StoreTambahUser() { 
        $nama_lengkap = $_POST['nama_lengkap'] ?? ''; 
        $email = $_POST['email'] ?? ''; 
        $password = $_POST['password'] ?? ''; 
        $gender = $_POST['gender'] ?? ''; 
        $role = isset($_POST['role']) && in_array($_POST['role'], ['admin','petugas']) ? $_POST['role'] : 'petugas'; 

        if(empty($nama_lengkap) || empty($email) || empty($password) || empty($gender)) { 
            $_SESSION['flash'] = ['type'=>'warning','msg'=>'Data tidak lengkap']; 
            header("Location: ?action=tambah-user"); 
            exit; 
        } 

        if($this->modelUser->checkEmail($email)) { 
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Email sudah di gunakan']; 
            header("Location: ?action=tambah-user"); 
            exit; 
        } 

        $insert = $this->modelUser->Insert($nama_lengkap, $email, $password, $gender, $role); 

        if($insert) { 
            $_SESSION['flash'] = ['type'=>'success','msg'=>'Berhasil Menambahkan User!']; 
        } else { 
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Gagal Menambahkan User']; 
        } 

        header("Location: ?action=tambah-user"); 
        exit; 
    } 

    public function deleteUser($id) { 
        $hapus = $this->modelUser->Delete($id); 

        if($hapus){ 
            $_SESSION['flash'] = [ 'type' => 'success', 'msg' => 'Berhasil Menghapus User' ]; 
        }else{ 
            $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'Gagal Menghapus User' ]; 
        } 

        header("Location:?action=manage-user"); 
        exit; 
    } 

    public function editUser($id_user) { 
        $user = $this->modelUser->getById($id_user); 
        include __DIR__ . "/../../Resources/Views/components/Form/edit-user.php"; 
    } 

    public function updateUser() { 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
            $id_user = $_POST['id_user']; 
            $nama_lengkap = $_POST['nama_lengkap']; 
            $email = $_POST['email']; 
            $password = $_POST['password']; 
            $gender = $_POST['gender']; 
            $role = $_POST['role']; 

            if($this->modelUser->checkEmail($email)){ 
                $existingUser = $this->modelUser->getByEmail($email); 
                if($existingUser['id_user'] != $id_user){ 
                    $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'Email Sudah Di gunakan' ]; 
                    header("Location: ?action=edit-user&id=".$id_user); 
                    exit; 
                } 
            } 

            $update = $this->modelUser->updateUser($id_user, $nama_lengkap, $email, $password, $gender, $role); 

            if($update){ 
                $_SESSION['flash'] = [ 'type' => 'success', 'msg' => 'Berhasil Mengupdate User' ]; 
                header("Location: ?action=manage-user"); 
                exit; 
            } else { 
                $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'gagal Mengupdate User' ]; 
                header("Location: ?action=edit-user&id=".$id_user); 
                exit; 
            } 
        } 
    } 
}
?>