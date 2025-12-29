<?php
require_once __DIR__ . "/../Models/tiket.php";
require_once __DIR__ . "/../Models/user.php";
require_once __DIR__ . "/../Models/transaksi.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

class IMPORTController {

    private $modelTiket;
    private $modelUser;
    private $modelTransaksi;

    public function __construct() {
        $this->modelTiket = new Tiket();
        $this->modelUser = new User();
        $this->modelTransaksi = new Transaksi();
    }

    private function validDateTime($value){
        if (!$value) return null;

        $d = DateTime::createFromFormat('Y-m-d H:i:s', $value);
        return $d ? $d->format('Y-m-d H:i:s') : null;
    }

    public function importTiket(){
        if (!isset($_FILES['file_excel'])) {
            header("Location: ?error=no_file");
            exit;
        }

        require_once __DIR__ . "/../../vendor/autoload.php";

        $fileTmp = $_FILES['file_excel']['tmp_name'];
        $spreadsheet = IOFactory::load($fileTmp);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        unset($rows[0]);

        foreach ($rows as $row) {
            if (empty($row[1]) || empty($row[2])) {
                continue;
            }

        $jenis = strtolower(trim($row[3]));

        $idTarif = match ($jenis) {
            'mobil' => 2,
            'motor' => 1,
            default => 1,
        };

        $status = strtolower(trim($row[10] ?? 'masuk'));

        $idPetugasMasuk  = (int) $this->modelUser->getUserIdByName($row[6]);
        $idPetugasMasuk  = $idPetugasMasuk > 0 ? $idPetugasMasuk : null;

        $idPetugasKeluar = ($status === 'keluar') 
            ? (int) $this->modelUser->getUserIdByName($row[8])
            : null;
        $idPetugasKeluar = $idPetugasKeluar > 0 ? $idPetugasKeluar : null;

        $data = [
            'barcode'             => trim($row[1]),
            'nomor_polisi'        => trim($row[2]),
            'jenis_kendaraan'     => $jenis,
            'id_tarif'            => $idTarif,
            'tgl_masuk'           => $this->validDateTime($row[5]),
            'tgl_keluar'          => $this->validDateTime($row[7]),
            'total_harga' => (int) preg_replace('/[^0-9]/', '', $row[9] ?? '0'),
            'id_petugas_masuk'    => $idPetugasMasuk,
            'id_petugas_keluar'   => $idPetugasKeluar,
            'status'              => $status,
        ];
            if ($this->modelTiket->cekBarcode($data['barcode'])) {
                continue;
            }

            $this->modelTiket->insertImportTiket($data);
        }

        header("Location: ?import=success");
        exit;
    }

    public function importUser() {
        if (!isset($_FILES['file_excel'])) {
            header("Location: ?error=no_file");
            exit;
        }

        require_once __DIR__ . "/../../vendor/autoload.php";

        $fileTmp = $_FILES['file_excel']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmp);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        unset($rows[0]);

        foreach ($rows as $row) {
            if (empty($row[1]) || empty($row[2])) {
                continue;
            }

            $gender = strtolower(trim($row[3]));
            $genderEnum = $gender === 'perempuan' || $gender === 'p' ? 'P' : 'L';

            $role = strtolower(trim($row[4]));
            $roleEnum = $role === 'admin' ? 'admin' : 'petugas';

            $emailVerifiedAt = strtolower(trim($row[6] ?? 'belum')) === 'terverifikasi' && !empty($row[7])
                ? date('Y-m-d H:i:s', strtotime($row[7]))
                : null;

            $password = password_hash('1234567', PASSWORD_DEFAULT);

            $data = [
                'nama_lengkap' => trim($row[1]),
                'email'        => trim($row[2]),
                'gender'       => $genderEnum,
                'role'         => $roleEnum,
                'password'     => $password,
                'created_at'   => !empty($row[5]) ? date('Y-m-d H:i:s', strtotime($row[5])) : date('Y-m-d H:i:s'),
                'email_verified_at' => $emailVerifiedAt
            ];

            if ($this->modelUser->cekEmail($data['email'])) {
                continue;
            }

            $this->modelUser->insertUser($data);
        }

        header("Location: ?import=success");
        exit;
    } 

    public function importTransaksi() {
        if (!isset($_FILES['file_excel'])) {
            header("Location: ?error=no_file");
            exit;
        }

        require_once __DIR__ . "/../../vendor/autoload.php";

        $fileTmp = $_FILES['file_excel']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmp);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        unset($rows[0]);

        foreach ($rows as $row) {
            if (empty($row[1]) || empty($row[4]) || empty($row[5])) {
                continue;
            }

            $tglBayar = null;
            if (!empty($row[5])) {
                $d = DateTime::createFromFormat('Y-m-d H:i:s', $row[5]);
                if ($d) $tglBayar = $d->format('Y-m-d H:i:s');
            }
            $jumlahBayarRaw = $row[4] ?? 0;

            $jumlah_bayar = (int) str_replace(['.', ','], '', $jumlahBayarRaw);

            $data = [
                'id_transaksi' => (int) $row[0],
                'id_tiket'     => (int) $row[1],
                'jumlah_bayar' => $jumlah_bayar,
                'metode'       => strtolower(trim($row[2] ?? 'cash')),
                'tgl_bayar'    => !empty($row[5]) ? DateTime::createFromFormat('d/m/Y H:i', $row[5])->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
                'status'       => strtolower(trim($row[6] ?? 'paid'))
            ];

            if ($this->modelTransaksi->cekTransaksi($data['id_transaksi'])) {
                continue;
            }

            $this->modelTransaksi->insertImportTransaksi($data);
        }

        header("Location: ?import=success");
        exit;
    }

}