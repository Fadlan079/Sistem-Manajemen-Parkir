<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'msg'    => 'Invalid request'
    ]);
    exit;
}

if (!isset($_FILES['foto_plat'])) {
    echo json_encode([
        'status' => 'error',
        'msg'    => 'File tidak ada'
    ]);
    exit;
}

$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$fileName = uniqid('ocr_') . '.jpg';
$fotoPath = $uploadDir . $fileName;

if (!move_uploaded_file($_FILES['foto_plat']['tmp_name'], $fotoPath)) {
    echo json_encode([
        'status' => 'error',
        'msg'    => 'Gagal upload file'
    ]);
    exit;
}

$pythonScript = __DIR__  . '/../../ocr/detect_plate.py';
$cmdDetect = "python " . escapeshellarg($pythonScript) . " " . escapeshellarg($fotoPath);
$output = shell_exec($cmdDetect);

$data = json_decode(trim($output), true);

if (!$data || isset($data['error'])) {
    echo json_encode([
        'status' => 'fail',
        'msg'    => 'Plat tidak terdeteksi'
    ]);
    exit;
}

$platePath   = $data['plate_path'] ?? null;
$vehicleType = $data['vehicle_type'] ?? null;

if (!$platePath || !file_exists($platePath)) {
    echo json_encode([
        'status' => 'fail',
        'msg'    => 'Gagal crop plat'
    ]);
    exit;
}

$cmdOcr = "tesseract " . escapeshellarg($platePath) .
          " stdout -l eng --psm 7 " .
          "-c tessedit_char_whitelist=ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

$ocrResult = shell_exec($cmdOcr);

$raw = strtoupper(
    preg_replace('/[^A-Z0-9]/', '', $ocrResult)
);

$nomor_polisi = "";

if (preg_match('/^([A-Z]{1,2})(\d{1,5})([A-Z]{1,3})$/', $raw, $m)) {
    $nomor_polisi = "{$m[1]} {$m[2]} {$m[3]}";
} else {
    $nomor_polisi = $raw;
}

if ($nomor_polisi === "") {
    echo json_encode([
        'status' => 'fail',
        'msg'    => 'Plat tidak terbaca'
    ]);
    exit;
}

echo json_encode([
    'status'        => 'success',
    'plate'         => $nomor_polisi,
    'vehicle_type'  => $vehicleType
]);