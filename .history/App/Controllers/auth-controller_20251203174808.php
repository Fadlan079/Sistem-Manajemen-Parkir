<?php
require_once __DIR__ . "/../Models/user.php";

class AUTHController{
    private $model;

    public function __construct(){
        $this->model = new User();
    }

    public function ShowLogin(){
        include __DIR__ . "/../../Resources/Views/auth/login.php";
    }

    public function StoreLogin(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];

            $dataUser = $this->model->getByEmail($email);
            
            if(!$dataUser){
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'msg'  => 'Email tidak ditemukan'
                ];
                header("Location: ?action=login");
                exit;
            }

            if(!password_verify($password,$dataUser['password'])){
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'msg'  => 'Password salah'
                ];
                header("Location: ?action=login");
                exit;
            }

            session_start();
            $_SESSION['user'] = [
                'id_user' => $dataUser['id_user'],
                'email' => $dataUser['email'],
                'nama_lengkap' => $dataUser['nama_lengkap'],
                'role' => $dataUser['role']
            ];

            $_SESSION['flash'] = [
                'type' => 'success',
                'msg'  => 'Berhasil login'
            ];

            header("Location:?action=index");    
            exit;
        }
    }

    public function ShowRegister(){
        include __DIR__ . "/../../Resources/Views/auth/register.php";
    }

    public function StoreRegister(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $nama_lengkap = $_POST['nama_lengkap'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $gender = $_POST['gender'];  
            $role = 'petugas';

            if($this->model->checkEmail($email)){
                echo "EMAIL SUDAH TERDAFTAR";
                return;
            }

            $regis = $this->model->Insert($nama_lengkap,$email,$password,$gender,$role);

            if($regis){
                            $_SESSION['flash'] = [
                'type' => 'success',
                'msg'  => 'Berhasil login'
            ];
                header("Location:?action=login");
            }else{
                echo "GAGAL REGISTRASI";
            }
        }
    }

    public function Logout(){
        session_start();
        session_unset();
        session_destroy();
        header("Location:?action=index");
        exit;
    }
}
?>