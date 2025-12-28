<?php
require_once __DIR__ . "/../../Config/database.php";
class Transaksi {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function TotalBayar(){
        try{
            $sql = "SELECT SUM(jumlah_bayar) FROM transaksi WHERE status = 'paid'";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            die("Gagal menambah transaksi: " . $e->getMessage());
        }
    }

public function SelectPagination($limit, $offset){
    $stmt = $this->pdo->prepare("
        SELECT 
            transaksi.*,
            tiket.nomor_polisi
        FROM transaksi
        JOIN tiket ON transaksi.id_tiket = tiket.id_tiket
        ORDER BY transaksi.id_transaksi DESC
        LIMIT ? OFFSET ?
    ");
    
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function InsertTransaksiAuto($id_tiket, $jumlah_bayar, $metode){
    $sql = "INSERT INTO transaksi 
            (id_tiket, jumlah_bayar, metode, status, tgl_bayar)
            VALUES 
            (:id_tiket, :jumlah_bayar, :metode, 'paid', NOW())";

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':id_tiket'     => $id_tiket,
        ':jumlah_bayar' => $jumlah_bayar,
        ':metode'       => $metode
    ]);
}



    public function InsertTransaksi($id_tiket, $jumlah_bayar, $metode) {
        try {
            $sql = "INSERT INTO transaksi (id_tiket, jumlah_bayar, metode, status)
                    VALUES (:id_tiket, :jumlah_bayar, :metode, 'paid')"; // langsung dianggap paid

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(":id_tiket", $id_tiket);
            $stmt->bindParam(":jumlah_bayar", $jumlah_bayar);
            $stmt->bindParam(":metode", $metode);

            return $stmt->execute();

        } catch (PDOException $e) {
            die("Gagal menambah transaksi: " . $e->getMessage());
        }
    }

    public function isTiketPaid($id_tiket){
        try {
            $sql = "SELECT status FROM transaksi 
                    WHERE id_tiket = :id_tiket 
                    ORDER BY tgl_bayar DESC LIMIT 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id_tiket", $id_tiket);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result && $result['status'] === 'paid'){
                return true; // tiket sudah dibayar
            }
            return false; // belum dibayar
        } catch(PDOException $e){
            die("Gagal cek status tiket: " . $e->getMessage());
        }
    }

    public function countTransaksi() {
        try {
            $sql = "SELECT COUNT(*) FROM transaksi";
            $stmt = $this->pdo->query($sql);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function GetAllTransaksi(){
        try{
            $sql = "SELECT t.*, tk.barcode, tk.nomor_polisi
                    FROM transaksi t
                    JOIN tiket tk ON t.id_tiket = tk.id_tiket
                    ORDER BY t.tgl_bayar DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            die("Query gagal: " . $e->getMessage());
        }
    }

    public function DeleteTransaksi($id_transaksi){
        try{
            $sql = "DELETE FROM transaksi WHERE id_transaksi = :id_transaksi";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id_transaksi", $id_transaksi);

            return $stmt->execute();
        }catch(PDOException $e){
            die("Delete gagal: " . $e->getMessage());
        }
    }

    public function getPendapatanHarian() {
    $stmt = $this->pdo->query("
        SELECT DATE(tgl_bayar) AS tanggal, SUM(jumlah_bayar) AS total
        FROM transaksi
        WHERE status = 'paid'
        GROUP BY DATE(tgl_bayar)
        ORDER BY tanggal ASC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getJumlahTransaksiHarian() {
    $stmt = $this->pdo->query("
        SELECT DATE(tgl_bayar) AS tanggal, COUNT(*) AS total
        FROM transaksi
        WHERE status = 'paid'
        GROUP BY DATE(tgl_bayar)
        ORDER BY tanggal ASC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getStatStatus() {
    $stmt = $this->pdo->query("
        SELECT status, COUNT(*) AS total
        FROM transaksi
        GROUP BY status
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getStatMetode() {
    $stmt = $this->pdo->query("
        SELECT metode, COUNT(*) AS total
        FROM transaksi
        GROUP BY metode
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getStatNominal() {
    $stmt = $this->pdo->query("
        SELECT jumlah_bayar, COUNT(*) AS total
        FROM transaksi
        WHERE status = 'paid'
        GROUP BY jumlah_bayar
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}



// $transaksi = new Transaksi();
// $transaksi->InsertTransaksi(2,10000,"cash");
// $data = $transaksi->GetAllTransaksi();
// $data = $transaksi->TotalBayar();
// $data = $transaksi->SelectPagination(10,0);
// var_dump($data);
?>