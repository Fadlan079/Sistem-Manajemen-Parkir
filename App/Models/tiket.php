<?php
require_once __DIR__ . "/../../Config/database.php";

class Tiket{
    private $pdo;

    public function __construct(){
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function SelectTiketPagination($limit, $offset){
    $stmt = $this->pdo->prepare("SELECT * FROM tiket ORDER BY id_tiket DESC LIMIT ? OFFSET ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countAllTiket(){
    return $this->pdo->query("SELECT COUNT(*) FROM tiket")->fetchColumn();
}

public function GetTiketByBarcode($barcode){
    $sql = "SELECT t.*, tr.harga_flat 
            FROM tiket t
            JOIN tarif_parkir tr ON tr.id_tarif = t.id_tarif
            WHERE t.barcode = :barcode";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':barcode' => trim($barcode)]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function lastInsertId() {
    return $this->pdo->lastInsertId();
}


public function getTiketById($id)
{
    $query = "
        SELECT 
            t.*, 
            u1.nama_lengkap AS petugas_masuk,
            u2.nama_lengkap AS petugas_keluar
        FROM tiket t
        LEFT JOIN user u1 ON u1.id_user = t.id_petugas_masuk
        LEFT JOIN user u2 ON u2.id_user = t.id_petugas_keluar
        WHERE t.id_tiket = :id
    ";

    $stmt = $this->pdo->prepare($query);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
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
        $sql = "SELECT harga_flat FROM tarif_parkir WHERE id_tarif = :id_tarif LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id_tarif", $id_tarif);
        $stmt->execute();
        return $stmt->fetchColumn(); // langsung ambil angka harga
    }

    public function InsertTiketMasuk($nomor_polisi, $jenis_kendaraan, $id_tarif, $tgl_masuk, $id_petugas_masuk, $status) {
        try {
            $barcode = $this->generateBarcode();

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

            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();   // ⬅ ID tiket baru
            }

            return false;

        } catch(PDOException $e) {
            die("Query gagal :" . $e->getMessage());
        }
    }


public function SelectTiket()
{
    try {
        $sql = "
            SELECT 
                t.id_tiket,
                t.barcode,
                t.nomor_polisi,
                t.jenis_kendaraan,

                tp.harga_flat AS harga_tarif,

                t.tgl_masuk,
                t.tgl_keluar,
                t.total_harga,

                pm.nama_lengkap AS petugas_masuk,
                pk.nama_lengkap AS petugas_keluar,

                t.status
            FROM tiket t
            JOIN tarif_parkir tp 
                ON t.id_tarif = tp.id_tarif
            LEFT JOIN user pm 
                ON t.id_petugas_masuk = pm.id_user
            LEFT JOIN user pk 
                ON t.id_petugas_keluar = pk.id_user
            ORDER BY t.id_tiket DESC
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Query gagal : " . $e->getMessage());
    }
}

public function getStatStatus()
{
    $sql = "
        SELECT status, COUNT(*) as total
        FROM tiket
        GROUP BY status
    ";

    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getStatKendaraan()
{
    $sql = "
        SELECT jenis_kendaraan, COUNT(*) as total
        FROM tiket
        GROUP BY jenis_kendaraan
    ";

    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getTotalPendapatan()
{
    $sql = "
        SELECT SUM(total_harga) 
        FROM tiket
        WHERE status = 'keluar'
    ";

    return (int) $this->pdo->query($sql)->fetchColumn();
}


public function getPendapatanPerHari()
{
    $sql = "
        SELECT DATE(tgl_keluar) tanggal, SUM(total_harga) total
        FROM tiket
        WHERE status = 'keluar'
        GROUP BY DATE(tgl_keluar)
        ORDER BY tanggal ASC
    ";

    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


public function GetTiketAktifByBarcode($barcode){
    $sql = "SELECT * FROM tiket 
            WHERE barcode = :barcode 
            AND status = 'masuk'
            LIMIT 1";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':barcode' => $barcode]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function UpdateTiketKeluar($barcode, $tgl_keluar, $id_petugas_keluar, $total_harga){
    $sql = "UPDATE tiket 
            SET tgl_keluar = :tgl_keluar,
                id_petugas_keluar = :id_petugas_keluar,
                total_harga = :total_harga,
                status = 'keluar'
            WHERE barcode = :barcode
            AND status = 'masuk'";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':barcode' => trim($barcode),
        ':tgl_keluar' => $tgl_keluar,
        ':id_petugas_keluar' => $id_petugas_keluar,
        ':total_harga' => $total_harga
    ]);

    return $stmt->rowCount(); // ✅ PENTING
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
// $tiket->UpdateTiketKeluar(8079059781058,"2025-10-12 09:31:00",1,10000,"keluar");
// $tiket->DeleteTiket(3);
// $data = $tiket->SelectTiket();
// $data = $tiket->GetTiketByBarcode("3155239835524");
// $data = $tiket->getTiketById(33);
// var_dump($data);
?>