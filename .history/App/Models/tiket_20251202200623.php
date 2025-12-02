<?php
require_once __DIR__ . "/../../Config/database.php";

class Tiket{
    private $pdo;

    public function __construct(){
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

public function GetTiketByBarcode($barcode){
    try {
        $sql = "SELECT t.*, tr.harga_flat 
                FROM tiket t
                JOIN tarif_parkir tr ON tr.id_tarif = t.id_tarif
                WHERE t.barcode = :barcode
                AND t.status = 'masuk'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":barcode", $barcode);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch(PDOException $e){
        return ['error' => $e->getMessage()];
    }
}


    public function generateBarcode() {
        do {
            $barcode = str_pad(rand(0, 9999999999999), 13, '0', STR_PAD_LEFT);
            $check = $this->pdo->prepare("SELECT COUNT(*) FROM tiket WHERE barcode = ?");
            $check->execute([$barcode]);
            $exists = $check->fetchColumn() > 0;
        } while ($exists);

        return $barcode;
    }

    public function SelectTiketMasukSaja() {
        try {
            $sql = "SELECT id_tiket, nomor_polisi, jenis_kendaraan 
                    FROM tiket 
                    WHERE status = 'masuk' 
                    ORDER BY tgl_masuk ASC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Gagal mengambil tiket masuk: " . $e->getMessage());
        }
    }

    public function countTiketMasuk() {
        try {
            $sql = "SELECT COUNT(*) FROM tiket WHERE status = 'masuk'";
            $stmt = $this->pdo->query($sql);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function countTiketKeluar() {
        try {
            $sql = "SELECT COUNT(*) FROM tiket WHERE status = 'keluar'";
            $stmt = $this->pdo->query($sql);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query gagal :" . $e->getMessage());
        }
    }

    private function getTarifById($id_tarif) {
        $sql = "SELECT harga FROM tarif_parkir WHERE id_tarif = :id_tarif LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id_tarif", $id_tarif);
        $stmt->execute();
        return $stmt->fetchColumn(); // langsung ambil angka harga
    }

    public function InsertTiketMasuk($nomor_polisi, $jenis_kendaraan, $id_tarif, $tgl_masuk, $id_petugas_masuk, $status) {
        try {
            $barcode = $this->generateBarcode();

            // AMBIL TARIF DARI TABLE TARIF
            $harga = $this->getTarifById($id_tarif);

            $sql = "INSERT INTO tiket(barcode, nomor_polisi, jenis_kendaraan, id_tarif, tgl_masuk, id_petugas_masuk, status, total_harga)
                    VALUES(:barcode, :nomor_polisi, :jenis_kendaraan, :id_tarif, :tgl_masuk, :id_petugas_masuk, :status, :total_harga)";
            
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(":barcode", $barcode);
            $stmt->bindParam(":nomor_polisi", $nomor_polisi);
            $stmt->bindParam(":jenis_kendaraan", $jenis_kendaraan);
            $stmt->bindParam(":id_tarif", $id_tarif);
            $stmt->bindParam(":tgl_masuk", $tgl_masuk);
            $stmt->bindParam(":id_petugas_masuk", $id_petugas_masuk);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":total_harga", $harga);

            return $stmt->execute();

        } catch(PDOException $e) {
            die("Query gagal :" . $e->getMessage());
        }
    }


    public function SelectTiket(){
        try{
            $sql = "SELECT * FROM tiket";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function UpdateTiketKeluar($barcode, $tgl_keluar, $id_petugas_keluar, $total_harga){
        try{
            $sql = "UPDATE tiket 
                    SET tgl_keluar = :tgl_keluar,
                        id_petugas_keluar = :id_petugas_keluar,
                        total_harga = :total_harga,
                        status = 'keluar'
                    WHERE barcode = :barcode";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":barcode", $barcode);
            $stmt->bindParam(":tgl_keluar", $tgl_keluar);
            $stmt->bindParam(":id_petugas_keluar", $id_petugas_keluar);
            $stmt->bindParam(":total_harga", $total_harga);

            return $stmt->execute();

        } catch(PDOException $e){
            die("Query gagal : " . $e->getMessage());
        }
    }

    public function DeleteTiket($id_tiket){
        try{
            $sql = "DELETE FROM tiket WHERE id_tiket = :id_tiket";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id_tiket' => $id_tiket]);
        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }
}

$tiket = new Tiket();
// $tiket->InsertTiketMasuk("KT 1824 BS","mobil",2,"2025-11-19 09:37:00",1,"masuk");
// $tiket->UpdateTiketKeluar(2214385623602,"2025-11-19 10:37:00",1,10000,"keluar");
// $tiket->DeleteTiket(3);
// $data = $tiket->SelectTiket();
// $data = $tiket->GetTiketByBarcode("3155239835524");
// var_dump($data);
?>