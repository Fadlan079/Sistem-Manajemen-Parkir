<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('Asia/Makassar');

require_once __DIR__ . "/../App/Controllers/auth-controller.php";
require_once __DIR__ . "/../App/Controllers/dashboard-controller.php";
require_once __DIR__ . "/../App/Controllers/Tiket-controller.php";
require_once __DIR__ . "/../App/Controllers/Tarif-controller.php";
require_once __DIR__ . "/../App/Controllers/Transaksi-controller.php";
require_once __DIR__ . "/../App/Controllers/User-controller.php";
require_once __DIR__ . "/../App/Controllers/Export-controller.php";
require_once __DIR__ . "/../App/Controllers/Import-controller.php";
require __DIR__ . '/../vendor/autoload.php';

$auth = new AUTHController();
$dashboard = new DASHBOARDController();
$tiket = new TIKETController();
$tarif = new TARIFController();
$transaksi = new TRANSAKSIController();
$user = new USERController();
$export = new EXPORTController();
$import = new IMPORTController();

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? Null;

switch($action){
    // Authentication
    case 'login';
        $auth->ShowLogin();
        break;
    case 'store-login';
        $auth->StoreLogin();
        break;    
    case 'register';
        $auth->ShowRegister();
        break;
    case 'store-register';
        $auth->StoreRegister();
        break;
    case 'verify-email':
        $auth->VerifyEmail();
        break;
    case 'resend-verification':
        $auth->ResendVerification();
        break;
    case 'logout':
        $auth->Logout();
        break;  
    case 'forgot-password':
        $auth->ShowForgotPassword();
        break;
    case 'store-forgot-password':
        $auth->StoreForgotPassword();
        break;
    case 'reset-password':
        $auth->ShowResetPassword();
        break;
    case 'store-reset-password':
        $auth->StoreResetPassword();
        break;

    // Dashboard   
    case 'index':
        $dashboard->index();
        break;

    // Tiket    
    case 'tiket-masuk':
        $tiket->ShowTiketMasuk();
        break;   
    case 'preview-tiket':
        $tiket->PreviewTiket();
        break;
    case 'hapus-tiket':
        $tiket->HapusTiket();
        break;
    case 'print-tiket':
        $tiket->PrintTiket();
        break;
    case 'store-tiket-masuk':
        $tiket->StoreTiketMasuk();
        break;       
    case 'tiket-keluar':
        $tiket->ShowTiketKeluar();
        break;   
    case 'update-tiket-keluar':
        $tiket->UpdateTiketKeluar();
        break;  
    case 'get-tiket-by-barcode':
        $tiket->GetTiketByBarcode();
        break;  

    // User      
    case 'manage-user':
        $user->ManageUser();
        break;   
    case 'tambah-user':
        $user->ShowTambahUser();
        break;  
    case 'store-tambah-user':
        $user->StoreTambahUser();
        break;        
    case 'delete-user':
        $user->deleteUser($id);
        break;
    case 'edit-user':
        $user->editUser($id);
        break;   
    case 'store-edit-user':
        $user->updateUser();
        break;   

    // Tarif    
    case 'manage-tarif':
        $tarif->ManageTarif();
        break;
    case 'delete-tarif':
        $tarif->deleteTarif($id);
        break;            
    case 'store-tambah-tarif':
        $tarif->storeInsertTarif();
        break;
    case 'tambah-tarif':
        $tarif->ShowInsertTarif();
        break;  
    case 'edit-tarif':
        $tarif->editTarif($id);
        break;
    case 'store-edit-tarif':
        $tarif->UpdateTarif();
        break;

    // Transaksi    
    case 'transaksi':
        $transaksi->ShowInsertTransaksi();
        break;
    case 'store-transaksi':
        $transaksi->StoreTransaksi();
        break; 
        
    // Export
    case 'export-tiket-excel':
        $export->exportTiket();
        break; 
    case 'export-user-excel':
        $export->exportUser();
        break; 
    case 'export-transaksi-excel':
        $export->exportTransaksi();
        break;         

    //Import    
    case 'import-tiket-excel':
        $import->importTiket();
        break;         
    case 'import-user-excel':
        $import->importUser();
        break; 
    case 'import-transaksi-excel':
        $import->importTransaksi();
        break;         

    // 404 Not Found    
    default:
        http_response_code(404);
        include __DIR__ . "/../Resources/Views/errors/404.php";
        break;    
}
?>