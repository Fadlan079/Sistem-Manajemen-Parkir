<?php
require_once __DIR__ . "/../../Config/database.php";

class TarifParkir {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function InsertTarif($jenis_kendaraan, $harga_flat) {
        try {
            $sql = "INSERT INTO tarif_parkir (jenis_kendaraan, harga_flat)
                    VALUES (:jenis_kendaraan, :harga_flat)";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(":jenis_kendaraan", $jenis_kendaraan);
            $stmt->bindParam(":harga_flat", $harga_flat);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Insert Tarif Gagal: " . $e->getMessage());
        }
    }

    public function SelectTarif() {
        try {
            $sql = "SELECT * FROM tarif_parkir ORDER BY id_tarif ASC";
            $stmt = $this->pdo->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Select Tarif Gagal: " . $e->getMessage());
        }
    }

    public function getById($id_tarif){
        try{
            $sql = "SELECT * FROM tarif_parkir WHERE id_tarif = :id_tarif";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id_tarif",$id_tarif);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            die("Query gagal :" . $e->getMessage());
        }
    }

    public function FindTarifByJenisKendaraan($jenis_kendaraan) {
        try {
            $sql = "SELECT * FROM tarif_parkir WHERE jenis_kendaraan = :jenis_kendaraan";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(["jenis_kendaraan" => $jenis_kendaraan]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Find Tarif By Jenis Kendaraan Gagal: " . $e->getMessage());
        }
    }

    public function UpdateTarif($id_tarif, $jenis_kendaraan, $harga_flat) {
        try {
            $sql = "UPDATE tarif_parkir 
                    SET jenis_kendaraan = :jenis_kendaraan,
                        harga_flat = :harga_flat
                    WHERE id_tarif = :id_tarif";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(":id_tarif", $id_tarif);
            $stmt->bindParam(":jenis_kendaraan", $jenis_kendaraan);
            $stmt->bindParam(":harga_flat", $harga_flat);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Update Tarif Gagal: " . $e->getMessage());
        }
    }

    public function DeleteTarif($id_tarif) {
        try {
            $sql = "DELETE FROM tarif_parkir WHERE id_tarif = :id_tarif";
            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute(["id_tarif" => $id_tarif]);
        } catch (PDOException $e) {
            die("Delete Tarif Gagal: " . $e->getMessage());
        }
    }
}