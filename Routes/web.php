<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('Asia/Makassar'); // atau Asia/Jakarta jika sesuai

require_once __DIR__ . "/../App/Controllers/auth-controller.php";
require_once __DIR__ . "/../App/Controllers/dashboard-controller.php";
require_once __DIR__ . "/../App/Controllers/Export-controller.php";
require __DIR__ . '/../vendor/autoload.php';

$auth = new AUTHController();
$dashboard = new DASHBOARDController();
$export = new EXPORTController();

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
        $dashboard->ShowTiketMasuk();
        break;   
    case 'preview-tiket':
        $dashboard->PreviewTiket();
        break;
    case 'hapus-tiket':
        $dashboard->HapusTiket();
        break;
    case 'print-tiket':
        $dashboard->PrintTiket();
        break;
    case 'store-tiket-masuk':
        $dashboard->StoreTiketMasuk();
        break;       
    case 'tiket-keluar':
        $dashboard->ShowTiketKeluar();
        break;   
    case 'update-tiket-keluar':
        $dashboard->UpdateTiketKeluar();
        break;  
    case 'get-tiket-by-barcode':
        $dashboard->GetTiketByBarcode();
        break;  

    // User      
    case 'manage-user':
        $dashboard->ManageUser();
        break;   
    case 'tambah-user':
        $dashboard->ShowTambahUser();
        break;  
    case 'store-tambah-user':
        $dashboard->StoreTambahUser();
        break;        
    case 'delete-user':
        $dashboard->deleteUser($id);
        break;
    case 'edit-user':
        $dashboard->editUser($id);
        break;   
    case 'store-edit-user':
        $dashboard->updateUser();
        break;   

    // Tarif    
    case 'manage-tarif':
        $dashboard->ManageTarif();
        break;
    case 'delete-tarif':
        $dashboard->deleteTarif($id);
        break;            
    case 'store-tambah-tarif':
        $dashboard->storeInsertTarif();
        break;
    case 'tambah-tarif':
        $dashboard->ShowInsertTarif();
        break;  
    case 'edit-tarif':
        $dashboard->editTarif($id);
        break;
    case 'store-edit-tarif':
        $dashboard->UpdateTarif();
        break;

    // Transaksi    
    case 'transaksi':
        $dashboard->ShowInsertTransaksi();
        break;
    case 'store-transaksi':
        $dashboard->StoreTransaksi();
        break; 
        
    // Export/Import
    case 'export-tiket-excel':
        $export->exportTiket();
        break;   
    case 'import-tiket-excel':
       
        break;         

    // 404 Not Found    
    default:
        http_response_code(404);
        include __DIR__ . "/../Resources/Views/errors/404.php";
        break;    
}
?>