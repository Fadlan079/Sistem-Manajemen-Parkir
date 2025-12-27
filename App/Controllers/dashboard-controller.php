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

    // ================= USER PAGINATION =================
    $pageUser = isset($_GET['page_user']) ? (int)$_GET['page_user'] : 1;
    $pageUser = max(1, $pageUser);
    $offsetUser = ($pageUser - 1) * $limit;

    $listUser = $this->modelUser->Select($limit, $offsetUser);
    $totalUser = $this->modelUser->countUser();
    $totalPagesUser = ceil($totalUser / $limit);
    $p = ($pageUser - 1) * $limit + 1;

    // ================= TIKET PAGINATION =================
    $pageTiket = isset($_GET['page_tiket']) ? (int)$_GET['page_tiket'] : 1;
    $pageTiket = max(1, $pageTiket);
    $offsetTiket = ($pageTiket - 1) * $limit;

    $listTiket = $this->modelTiket->SelectTiketPagination($limit, $offsetTiket);
    $totalTiket = $this->modelTiket->countAllTiket();
    $totalPagesTiket = ceil($totalTiket / $limit);

    // ================= TRANSAKSI PAGINATION =================
    $pageTrx = isset($_GET['page_trx']) ? (int)$_GET['page_trx'] : 1;
    $pageTrx = max(1, $pageTrx);
    $offsetTrx = ($pageTrx - 1) * $limit;

    $listTransaksi = $this->modelTransaksi->SelectPagination($limit, $offsetTrx);
    $totalTrx = $this->modelTransaksi->countTransaksi();
    $totalPagesTrx = ceil($totalTrx / $limit);

    // ================= DASHBOARD COUNTER =================
    $totalbayar = $this->modelTransaksi->TotalBayar();
    $TotalUser = $this->modelUser->countuser();
    $Totalmasuk = $this->modelTiket->countTiketMasuk();
    $Totalkeluar = $this->modelTiket->countTiketKeluar();
    $Totaltransaksi = $this->modelTransaksi->countTransaksi();

            $statusStat    = $this->modelTiket->getStatStatus();
        $kendaraanStat = $this->modelTiket->getStatKendaraan();
        $totalPendapatan = $this->modelTiket->getTotalPendapatan();
        $pendapatanPerHari = $this->modelTiket->getPendapatanPerHari();

                $statusCount = [
            'masuk'  => 0,
            'keluar' => 0
        ];

        foreach ($statusStat as $row) {
            $statusCount[$row['status']] = (int)$row['total'];
        }

        $kendaraanCount = [
            'motor' => 0,
            'mobil' => 0
        ];

        foreach ($kendaraanStat as $row) {
            $kendaraanCount[$row['jenis_kendaraan']] = (int)$row['total'];
        }

    include __DIR__ . "/../../Resources/Views/index.php";
}


    public function ShowTiketMasuk(){
        $data_tarif = $this->modelTarif->SelectTarif();
        include __DIR__ . "/../../Resources/Views/components/Form/tiket-masuk.php";
    }

    public function StoreTiketMasuk() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    // ================= AMBIL DATA DARI FORM
    $nomor_polisi      = trim($_POST['nomor_polisi'] ?? '');
    $jenis_kendaraan   = $_POST['jenis_kendaraan'];
    $id_tarif          = $_POST['id_tarif'];
    $tgl_masuk         = date("Y-m-d H:i:s");
    $id_petugas_masuk  = $_SESSION['user']['id_user'];
    $status            = "masuk";

    // ================= VALIDASI FINAL
    if (empty($nomor_polisi)) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'msg'  => 'Nomor polisi wajib diisi'
        ];
        header("Location: ?action=tiket-masuk");
        exit;
    }

    // ================= INSERT DB
    $insert = $this->modelTiket->InsertTiketMasuk(
        $nomor_polisi,
        $jenis_kendaraan,
        $id_tarif,
        $tgl_masuk,
        $id_petugas_masuk,
        $status
    );

    if ($insert) {
        $lastId = $this->modelTiket->lastInsertId();
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

    public function PreviewTiket() {
    $id = $_GET['id'];
    $tiket = $this->modelTiket->GetTiketById($id);

    include __DIR__ . '/../../Resources/Views/Tiket/preview-tiket.php';
}

public function HapusTiket() {
    $id = $_GET['id'];
    $this->modelTiket->DeleteTiket($id);

    $_SESSION['flash'] = [
        'type' => 'error',
        'msg' => 'Tiket dibatalkan.'
    ];
    header("Location: ?action=tiket-masuk");
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
        include __DIR__ . "/../../Resources/Views/components/Form/tiket-keluar.php";
    }

public function UpdateTiketKeluar() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $barcode = trim($_POST['barcode'] ?? '');
    $total_harga = intval(str_replace('.', '', $_POST['total_harga'] ?? 0));
    $metode = 'cash'; // default (bisa kamu buat dropdown nanti)

    if ($barcode === '' || $total_harga <= 0) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'msg'  => 'Data tidak valid! Scan ulang barcode.'
        ];
        header("Location: ?action=tiket-keluar");
        exit;
    }

    $tgl_keluar = date("Y-m-d H:i:s");
    $id_petugas_keluar = $_SESSION['user']['id_user'];

    // ✅ AMBIL DATA TIKET AKTIF
    $tiket = $this->modelTiket->GetTiketAktifByBarcode($barcode);

    if (!$tiket) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'msg'  => 'Tiket tidak ditemukan / sudah keluar!'
        ];
        header("Location: ?action=tiket-keluar");
        exit;
    }

    // ✅ UPDATE TIKET KELUAR
    $update = $this->modelTiket->UpdateTiketKeluar(
        $barcode,
        $tgl_keluar,
        $id_petugas_keluar,
        $total_harga
    );

    if ($update <= 0) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'msg'  => 'Gagal update tiket!'
        ];
        header("Location: ?action=tiket-keluar");
        exit;
    }

    // ✅ AUTO INSERT TRANSAKSI
    $this->modelTransaksi->InsertTransaksiAuto(
        $tiket['id_tiket'],
        $total_harga,
        $metode
    );

    $_SESSION['flash'] = [
        'type' => 'success',
        'msg'  => 'Tiket selesai & pembayaran berhasil!'
    ];

    header("Location: ?action=tiket-keluar");
    exit;
}



    public function ShowInsertTarif(){
        include __DIR__ . "/../../Resources/Views/components/Form/form-tambah-tarif.php";
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
        include __DIR__ . "/../../Resources/Views/Pages/manage-user.php";
    }

    public function ShowTambahUser(){
        include __DIR__ . "/../../Resources/Views/components//Form/form-tambah-user.php";
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
        include __DIR__ . "/../../Resources/Views/Pages/manage-tarif.php";
    }

    public function deleteTarif($id){
        $this->modelTarif->DeleteTarif($id);
        header("Location:?action=manage-tarif");
    }

    public function editUser($id_user){
        $user = $this->modelUser->getById($id_user);
        include __DIR__ . "/../../Resources/Views/components/Form/edit-user.php";
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
        include __DIR__ . "/../../Resources/Views/components/Form/edit-tarif.php";
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
        include __DIR__ . "/../../Resources/Views/components/Form/form-tambah-transaksi.php";
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