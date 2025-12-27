<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once __DIR__ . "/../Models/user.php";

class AUTHController{
    private $model;

    public function __construct(){
        $this->model = new User();
    }

public function ShowLogin(){
    if (isset($_SESSION['unverified_email'])) {
        $user = $this->model->getByEmail($_SESSION['unverified_email']);

        if ($user && $user['verification_sent_at']) {
            $last = strtotime($user['verification_sent_at']);
            $now  = time();
            $cooldown = 120;

            if ($now - $last < $cooldown) {
                $_SESSION['resend_wait'] = $cooldown - ($now - $last);
            } else {
                unset($_SESSION['resend_wait']);
            }
        }
    }

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

if(!$dataUser['email_verified_at']){
    $_SESSION['unverified_email'] = $email;

    $_SESSION['flash'] = [
        'type' => 'error',
        'msg'  => 'Email belum diverifikasi, silakan cek inbox'
    ];
    header("Location:?action=login");
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

public function ShowForgotPassword(){
    include __DIR__ . "/../../Resources/Views/auth/forgot-password.php";
}

public function StoreForgotPassword(){
    $email = $_POST['email'] ?? null;
    if(!$email) return;

    $user = $this->model->getByEmail($email);

    // ⛔ jangan bocorin apakah email ada
    if(!$user){
        $_SESSION['flash'] = [
            'type' => 'info',
            'msg' => 'Jika email terdaftar, link reset akan dikirim'
        ];
        header("Location:?action=forgot-password");
        exit;
    }

    $token = bin2hex(random_bytes(32));
    $expired = date('Y-m-d H:i:s', time() + (15 * 60));

    $this->model->saveResetToken($email, $token, $expired);

    $this->sendResetPasswordEmail($email, $token);

    $_SESSION['flash'] = [
        'type' => 'success',
        'msg' => 'Link reset password telah dikirim ke email'
    ];

    header("Location:?action=login");
    exit;
}

private function sendResetPasswordEmail($email, $token){
    $mail = new PHPMailer(true);

    $link = "http://localhost/sistem_parkir/Public/?action=reset-password&token=$token";

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fadlanfirdaus220@gmail.com';
    $mail->Password = 'nthrcoezrgsoeydm';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('fadlanfirdaus220@gmail.com', 'Sistem Parkir');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Reset Password';
    $mail->Body = "
        <p>Klik link berikut untuk reset password:</p>
        <a href='$link'>$link</a>
        <p>Link berlaku 15 menit.</p>
    ";

    $mail->send();
}

public function ShowResetPassword(){
    $token = $_GET['token'] ?? null;
    $user = $this->model->getByResetToken($token);

    if(!$user || strtotime($user['reset_password_expired_at']) < time()){
        die('Token tidak valid / expired');
    }

    include __DIR__ . "/../../Resources/Views/auth/reset-password.php";
}

public function StoreResetPassword(){
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $user = $this->model->getByResetToken($token);
    if(!$user) die('Token invalid');

    $this->model->updatePasswordByToken($token, $password);

    $_SESSION['flash'] = [
        'type' => 'success',
        'msg' => 'Password berhasil direset'
    ];

    header("Location:?action=login");
    exit;
}


    public function ShowRegister(){
        include __DIR__ . "/../../Resources/Views/auth/register.php";
    }

private function sendVerificationEmail($email, $token){
    $mail = new PHPMailer(true);

    $verifyLink = "http://localhost/sistem_parkir/Public/?action=verify-email&token=$token";

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'fadlanfirdaus220@gmail.com';
    $mail->Password   = 'nthrcoezrgsoeydm';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('fadlanfirdaus220@gmail.com', 'Sistem Parkir');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Verifikasi Email Akun Sistem Parkir';
    $mail->Body = "
        <h3>Verifikasi Email</h3>
        <p>Klik link berikut untuk mengaktifkan akun:</p>
        <a href='$verifyLink'>$verifyLink</a>
    ";

    $mail->send();
}

public function ResendVerification(){
    $email = $_GET['email'] ?? null;

    if(!$email) die('Email tidak valid');

    $user = $this->model->getByEmail($email);
    if(!$user) die('User tidak ditemukan');

    // sudah verif
    if($user['email_verified_at']){
        $_SESSION['flash'] = [
            'type' => 'info',
            'msg'  => 'Email sudah diverifikasi'
        ];
        header("Location:?action=login");
        exit;
    }   

    // cek cooldown
    if($user['verification_sent_at']){
        $last = strtotime($user['verification_sent_at']);
        $now  = time();

        if($now - $last < 120){
            $sisa = 120 - ($now - $last);

            $_SESSION['resend_wait'] = $sisa;
            $_SESSION['flash'] = [
                'type' => 'warning',
                'msg'  => "Tunggu {$sisa} detik untuk kirim ulang"
            ];

            header("Location:?action=login");
            exit;
        }
    }

    // kirim ulang
    $this->sendVerificationEmail(
        $user['email'],
        $user['verification_token']
    );

    $this->model->updateVerificationSentAt(
        $user['email'],
        date('Y-m-d H:i:s')
    );

    unset($_SESSION['resend_wait']);

    $_SESSION['flash'] = [
        'type' => 'success',
        'msg'  => 'Email verifikasi dikirim ulang'
    ];

    header("Location:?action=login");
    exit;
}


public function VerifyEmail(){
    $token = $_GET['token'] ?? null;

    if(!$token){
        die('Token tidak valid');
    }

    $user = $this->model->getByToken($token);

    if(!$user){
        die('Token tidak ditemukan');
    }

    $this->model->verifyEmail($token);

    $_SESSION['flash'] = [
        'type' => 'success',
        'msg'  => 'Email berhasil diverifikasi, silakan login'
    ];

    header("Location:?action=login");
    exit;
}


public function StoreRegister(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $nama_lengkap = $_POST['nama_lengkap'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];  
        $role = 'petugas';

        // validasi format email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['flash'] = [
                'type' => 'error',
                'msg'  => 'Format email tidak valid'
            ];
            header("Location:?action=register");
            exit;
        }

        if($this->model->checkEmail($email)){
            $_SESSION['flash'] = [
                'type' => 'error',
                'msg'  => 'Email Sudah Digunakan'
            ];
            header("Location:?action=register");
            exit;
        }

        // generate token
        $token = bin2hex(random_bytes(32));

        $regis = $this->model->InsertWithVerify(
            $nama_lengkap,
            $email,
            $password,
            $gender,
            $role,
            $token
        );

        if($regis){
            // kirim email verifikasi
            $this->sendVerificationEmail($email, $token);

            $_SESSION['flash'] = [
                'type' => 'success',
                'msg'  => 'Registrasi berhasil! Silakan cek email untuk verifikasi.'
            ];
            header("Location:?action=login");
            exit;
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