<?php
require_once __DIR__ . "/../Models/tiket.php";
require_once __DIR__ . "/../Models/transaksi.php";
require_once __DIR__ . "/../Models/user.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EXPORTController {

    private $modelTiket;
    private $modelTransaksi;
    private $modelUser;

    public function __construct() {
        $this->modelTiket = new Tiket();
        $this->modelTransaksi = new Transaksi();
        $this->modelUser = new User();
    }

    public function exportTiket(){
        $data = $this->modelTiket->SelectTiket();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Tiket');

        $headers = [
            'ID Tiket',
            'Barcode',
            'Nomor Polisi',
            'Jenis Kendaraan',
            'Harga Tarif',
            'Tanggal Masuk',
            'Petugas Masuk',
            'Tanggal Keluar',
            'Petugas Keluar',
            'Total Harga',
            'Status'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col.'1', $header);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 2;
        foreach ($data as $item) {

            $sheet->setCellValue('A'.$row, $item['id_tiket']);

            $sheet->setCellValueExplicit(
                'B'.$row,
                $item['barcode'],
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            );

            $sheet->getStyle('B'.$row)->getFont()->setName('Consolas');

            $sheet->setCellValue('C'.$row, $item['nomor_polisi']);
            $sheet->setCellValue('D'.$row, ucfirst($item['jenis_kendaraan']));
            $sheet->setCellValue('E'.$row, 'Rp ' . number_format($item['harga_tarif'], 0, ',', '.'));
            $sheet->setCellValue('F'.$row, $item['tgl_masuk']);
            $sheet->setCellValue('G'.$row, $item['petugas_masuk'] ?? '-');
            $sheet->setCellValue('H'.$row, $item['tgl_keluar'] ?? '-');
            $sheet->setCellValue('I'.$row, $item['petugas_keluar'] ?? '-');
            $sheet->setCellValue('J'.$row, 'Rp ' . number_format($item['total_harga'] ?? 0, 0, ',', '.'));
            $sheet->setCellValue('K'.$row, ucfirst($item['status']));

            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="data-tiket-parkir.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

        public function exportUser() {
        $data = $this->modelUser->Select();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data User');

        $headers = [
            'ID', 'Nama', 'Email', 'Gender', 'Role', 'Dibuat', 'Verif', 'Tgl Verif'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col.'1', $header);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A'.$row, $item['id_user']);
            $sheet->setCellValue('B'.$row, $item['nama_lengkap']);
            $sheet->setCellValue('C'.$row, $item['email']);

            $gender = $item['gender'] === 'L' ? 'Laki-laki' : 'Perempuan';
            $sheet->setCellValue('D'.$row, $gender);

            $sheet->setCellValue('E'.$row, ucfirst($item['role']));
            $sheet->setCellValue('F'.$row, $item['created_at']);

            $verif = $item['email_verified_at'] ? 'Terverifikasi' : 'Belum';
            $sheet->setCellValue('G'.$row, $verif);

            $tglVerif = $item['email_verified_at'] ? date('d M Y H:i', strtotime($item['email_verified_at'])) : '-';
            $sheet->setCellValue('H'.$row, $tglVerif);

            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="data-user.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportTransaksi() {
        $data = $this->modelTransaksi->SelectAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Transaksi');

        $headers = [
            'ID Transaksi',
            'ID Tiket',
            'Metode Pembayaran',
            'No Polisi',
            'Total Bayar',
            'Tanggal Bayar',
            'Status'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col.'1', $header);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A'.$row, $item['id_transaksi']);
            $sheet->setCellValue('B'.$row, $item['id_tiket']);
            $sheet->setCellValue('C'.$row, ucfirst($item['metode']));
            $sheet->setCellValue('D'.$row, $item['nomor_polisi']);
            $sheet->setCellValue('E'.$row, 'Rp ' . number_format($item['total_bayar'] ?? 0, 0, ',', '.'));
            $sheet->setCellValue('F'.$row, $item['tgl_bayar']);
            $sheet->setCellValue('G'.$row, ucfirst($item['status']));
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="data-transaksi.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

}