<?php 
require_once __DIR__ . "/../Models/user.php";
require_once __DIR__ . "/../Models/tiket.php";
require_once __DIR__ . "/../Models/transaksi.php";
require_once __DIR__ . "/../Models/tarif-parkir.php";

class DASHBOARDController{
    private $modelUser;
    private $modelTiket;
    private $modelTransaksi;
    private $modelTarif;

    public function __construct(){
        $this->modelUser = new User();
        $this->modelTiket = new Tiket();
        $this->modelTransaksi = new Transaksi();
        $this->modelTarif = new TarifParkir();
    }

    public function index(){
        $current = 'index';
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max($page, 1);
        $p = ($page - 1) * $limit + 1;

        $offset = ($page - 1) * $limit;

        $listUser = $this->modelUser->Select($limit, $offset);

        $totalData = $this->modelUser->countUser();
        $totalPages = ceil($totalData / $limit);

        $totalbayar = $this->modelTransaksi->TotalBayar();
        $listTiket = $this->modelTiket->SelectTiket();
        $listTransaksi = $this->modelTransaksi->GetAllTransaksi();
        
        $TotalUser = $this->modelUser->countuser();
        $Totalmasuk = $this->modelTiket->countTiketMasuk();
        $Totalkeluar = $this->modelTiket->countTiketKeluar();
        $Totaltransaksi = $this->modelTransaksi->countTransaksi();
        include __DIR__ . "/../../Resources/Views/index.php";
    }

    public function ShowTiketMasuk(){
        $data_tarif = $this->modelTarif->SelectTarif();
        include __DIR__ . "/../../Resources/Views/components/tiket-masuk.php";
    }

    public function StoreTiketMasuk() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nomor_polisi       = $_POST['nomor_polisi'];
            $jenis_kendaraan    = $_POST['jenis_kendaraan'];
            $id_tarif           = $_POST['id_tarif'];
            $tgl_masuk          = date("Y-m-d H:i:s");
            $id_petugas_masuk   = $_SESSION['user']['id_user'];
            $status             = "masuk";

            $insert = $this->modelTiket->InsertTiketMasuk(
                $nomor_polisi,
                $jenis_kendaraan,
                $id_tarif,
                $tgl_masuk,
                $id_petugas_masuk,
                $status
            );
            
        if ($insert) {
            $lastId = $this->modelTiket->pdo->lastInsertId(); // ambil id tiket terakhir

            header("Location: ?action=preview-tiket&id=$lastId");
            exit;


            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'msg'  => 'Gagal Membuat Tiket'
                ];
                header("Location: ?action=tiket-masuk");
                exit;
            }

        }
    }

    public function PrintTiket() {
        if (!isset($_GET['id'])) {
            echo "ID tidak ditemukan";
            return;
        }

        $id = $_GET['id'];
        $tiket = $this->modelTiket->getTiketById($id);

        if (!$tiket) {
            echo "Tiket tidak ditemukan";
            return;
        }

        include __DIR__ . "/../../Resources/Views/Tiket/tiket.php";
    }

    public function GetTiketByBarcode() {
        header("Content-Type: application/json");

        if (!isset($_GET['barcode'])) {
            echo json_encode(['status' => 'error', 'message' => 'Barcode tidak dikirim']);
            return;
        }

        $barcode = $_GET['barcode'];

        // Panggil model
        $data = $this->modelTiket->GetTiketByBarcode($barcode);

        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'not_found']);
        }
    }

    public function ShowTiketKeluar(){
        include __DIR__ . "/../../Resources/Views/components/tiket-keluar.php";
    }

    public function UpdateTiketKeluar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $barcode = $_POST['barcode'];
            $tgl_keluar = date("Y-m-d H:i:s");
            $id_petugas_keluar = $_SESSION['user']['id_user'];
            $total_harga = $_POST['total_harga'];

            $update = $this->modelTiket->UpdateTiketKeluar(
                $barcode,
                $tgl_keluar,
                $id_petugas_keluar,
                $total_harga
            );

            if ($update) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'msg'  => 'Tiket Berhasil Di Selesaikan!'
                ];
                header("Location: ?action=tiket-keluar&success=1");
                exit;
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'msg'  => 'Tiket gagal Di Selesaikan'
                ];
                header("Location: ?action=tiket-keluar");
                exit;
            }
        }
    }

    public function ShowInsertTarif(){
        include __DIR__ . "/../../Resources/Views/components/form-tambah-tarif.php";
    }

    public function storeInsertTarif() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jenis_kendaraan = $_POST['jenis_kendaraan'] ?? '';
            $harga_flat = $_POST['harga_flat'] ?? 0;

            // Validasi sederhana
            if (empty($jenis_kendaraan) || $harga_flat <= 0) {
                echo "<script>alert('Data tidak valid!'); window.history.back();</script>";
                exit;
            }

            $insert = $this->modelTarif->InsertTarif($jenis_kendaraan, $harga_flat);

            if ($insert) {
                // Redirect atau tampilkan notifikasi sukses
                echo "<script>alert('Tarif berhasil disimpan!'); window.location='?action=manage-tarif';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan tarif!'); window.history.back();</script>";
            }
        }
    }

    public function ManageUser(){
        $current = 'manage-user';
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max($page, 1);
        $p = ($page - 1) * $limit + 1;

        $offset = ($page - 1) * $limit;

        $listUser = $this->modelUser->Select($limit, $offset);

        $totalData = $this->modelUser->countUser();
        $totalPages = ceil($totalData / $limit);
        include __DIR__ . "/../../Resources/Views/components/manage-user.php";
    }

    public function ShowTambahUser(){
        include __DIR__ . "/../../Resources/Views/components/form-tambah-user.php";
    }

    public function StoreTambahUser() {
        $nama_lengkap = $_POST['nama_lengkap'] ?? '';
        $email        = $_POST['email'] ?? '';
        $password     = $_POST['password'] ?? '';
        $gender       = $_POST['gender'] ?? '';
        $role         = isset($_POST['role']) && in_array($_POST['role'], ['admin','petugas'])
                        ? $_POST['role']
                        : 'petugas';

        // Validasi
        if(empty($nama_lengkap) || empty($email) || empty($password) || empty($gender)) {
            $_SESSION['flash'] = ['type'=>'warning','msg'=>'Data tidak lengkap'];
            header("Location: ?action=tambah-user");
            exit;
        }

        // Cek email
        if($this->modelUser->checkEmail($email)) {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Email sudah di gunakan'];
            header("Location: ?action=tambah-user");
            exit;
        }

        // Insert
        $insert = $this->modelUser->Insert($nama_lengkap, $email, $password, $gender, $role);

        if($insert) {
            $_SESSION['flash'] = ['type'=>'success','msg'=>'Berhasil Menambahkan User!'];
        } else {
            $_SESSION['flash'] = ['type'=>'error','msg'=>'Gagal Menambahkan User'];
        }

        header("Location: ?action=tambah-user");
        exit;

    }

    public function deleteUser($id){
        $hapus = $this->modelUser->Delete($id);
        if($hapus){
            $_SESSION['flash'] = [
                'type' => 'success',
                'msg'  => 'Berhasil Menghapus User'
            ];
        }else{
            $_SESSION['flash'] = [
                'type' => 'error',
                'msg'  => 'Gagal Menghapus User'
            ];
        }
        header("Location:?action=manage-user");
        exit;
    }

    public function ManageTarif(){
        $current = 'manage-tarif';
        $listTarif= $this->modelTarif->SelectTarif();
        include __DIR__ . "/../../Resources/Views/components/manage-tarif.php";
    }

    public function deleteTarif($id){
        $this->modelTarif->DeleteTarif($id);
        header("Location:?action=manage-tarif");
    }

    public function editUser($id_user){
        $user = $this->modelUser->getById($id_user);
        include __DIR__ . "/../../Resources/Views/components/edit-user.php";
    }

    public function updateUser(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_user = $_POST['id_user'];
            $nama_lengkap = $_POST['nama_lengkap'];
            $email = $_POST['email'];
            $password = $_POST['password']; // kosong jika tidak ingin diubah
            $gender = $_POST['gender'];
            $role = $_POST['role'];

            // Optional: cek email sudah dipakai user lain
            if($this->modelUser->checkEmail($email)){
                // Pastikan email yang sama bukan milik user ini
                $existingUser = $this->modelUser->getByEmail($email);
                if($existingUser['id_user'] != $id_user){
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'msg'  => 'Email Sudah Di gunakan'
                    ];
                    header("Location: ?action=edit-user&id=".$id_user);
                    exit;
                }
            }

            // Panggil method updateUser
            $update = $this->modelUser->updateUser($id_user, $nama_lengkap, $email, $password, $gender, $role);

            if($update){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'msg'  => 'Berhasil Mengupdate User'
                ];
                header("Location: ?action=manage-user");
                exit;
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'msg'  => 'gagal Mengupdate User'
                ];
                header("Location: ?action=edit-user&id=".$id_user);
                exit;
            }
        }
    }

    public function editTarif($id_tarif){
        $tarif = $this->modelTarif->getById($id_tarif);
        include __DIR__ . "/../../Resources/Views/components/edit-tarif.php";
    }

    public function UpdateTarif() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_tarif = $_POST['id_tarif'];
            $jenis_kendaraan = $_POST['jenis_kendaraan'];
            $harga_flat = $_POST['harga_flat'];

            // Validasi sederhana
            if (empty($jenis_kendaraan) || $harga_flat <= 0) {
                $_SESSION['error'] = "Data tidak valid!";
                header("Location: ?action=edit-tarif&id=".$id_tarif);
                exit;
            }

            $update = $this->modelTarif->UpdateTarif($id_tarif, $jenis_kendaraan, $harga_flat);

            if ($update) {
                $_SESSION['success'] = "Tarif berhasil diupdate!";
                header("Location: ?action=manage-tarif");
                exit;
            } else {
                $_SESSION['error'] = "Gagal mengupdate tarif!";
                header("Location: ?action=edit-tarif&id=".$id_tarif);
                exit;
            }
        }
    }


    public function ShowInsertTransaksi(){
        $allTiket = $this->modelTiket->SelectTiketMasukSaja(); // semua tiket masuk
        $listTiket = [];

        foreach($allTiket as $tiket){
            if(!$this->modelTransaksi->isTiketPaid($tiket['id_tiket'])){
                $listTiket[] = $tiket; // hanya tiket yang belum dibayar
            }
        }
        include __DIR__ . "/../../Resources/Views/components/form-tambah-transaksi.php";
    }

    public function StoreTransaksi(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id_tiket = $_POST['id_tiket'] ?? '';
            $jumlah_bayar = $_POST['jumlah_bayar'] ?? 0;
            $metode = $_POST['metode'] ?? '';

            // Validasi sederhana
            if(empty($id_tiket) || $jumlah_bayar <= 0 || empty($metode)){
                $_SESSION['error'] = "Data transaksi tidak valid!";
                header("Location: ?action=transaksi");
                exit;
            }

            $insert = $this->modelTransaksi->InsertTransaksi($id_tiket, $jumlah_bayar, $metode);

            if($insert){
                $_SESSION['success'] = "Transaksi berhasil ditambahkan!";
                header("Location: ?action=transaksi");
                exit;
            } else {
                $_SESSION['error'] = "Gagal menambahkan transaksi!";
                header("Location: ?action=transaksi");
                exit;
            }
        }
    }

}
?>