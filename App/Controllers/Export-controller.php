<?php
require_once __DIR__ . "/../Models/tiket.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EXPORTController {

    private $modelTiket;

    public function __construct() {
        $this->modelTiket = new Tiket();
    }

    public function exportTiket()
    {
        $data = $this->modelTiket->SelectTiket();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Tiket');

        /* ================= HEADER ================= */
        $headers = [
            'ID Tiket',
            'Barcode',
            'Nomor Polisi',
            'Jenis Kendaraan',
            'Harga Tarif',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Total Harga',
            'Petugas Masuk',
            'Petugas Keluar',
            'Status'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col.'1', $header);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        /* ================= ISI DATA ================= */
        $row = 2;
        foreach ($data as $item) {

            $sheet->setCellValue('A'.$row, $item['id_tiket']);

            // BARCODE ANGKA (TEXT)
            $sheet->setCellValueExplicit(
                'B'.$row,
                $item['barcode'],
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            );

            // Font monospace biar rapi
            $sheet->getStyle('B'.$row)->getFont()->setName('Consolas');

            $sheet->setCellValue('C'.$row, $item['nomor_polisi']);
            $sheet->setCellValue('D'.$row, ucfirst($item['jenis_kendaraan']));
            $sheet->setCellValue('E'.$row, 'Rp ' . number_format($item['harga_tarif'], 0, ',', '.'));
            $sheet->setCellValue('F'.$row, $item['tgl_masuk']);
            $sheet->setCellValue('G'.$row, $item['tgl_keluar'] ?? '-');
            $sheet->setCellValue('H'.$row, 'Rp ' . number_format($item['total_harga'] ?? 0, 0, ',', '.'));
            $sheet->setCellValue('I'.$row, $item['petugas_masuk'] ?? '-');
            $sheet->setCellValue('J'.$row, $item['petugas_keluar'] ?? '-');
            $sheet->setCellValue('K'.$row, ucfirst($item['status']));

            $row++;
        }

        /* ================= DOWNLOAD ================= */
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="data-tiket-parkir.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
