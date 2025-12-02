<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('Asia/Makassar'); // atau Asia/Jakarta jika sesuai

require_once __DIR__ . "/../App/Controllers/auth-controller.php";
require_once __DIR__ . "/../App/Controllers/dashboard-controller.php";
require __DIR__ . '/../vendor/autoload.php';

$auth = new AUTHController();
$dashboard = new DASHBOARDController();

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
    case 'logout':
        $auth->Logout();
        break;    

    // Dashboard   
    case 'index':
        $dashboard->index();
        break;
    case 'tiket-masuk':
        $dashboard->ShowTiketMasuk();
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
    case 'manage-user':
        $dashboard->ManageUser();
        break;   
    case 'tambah-user':
        $dashboard->ShowTambahUser();
        break;  
    case 'store-tambah-user':
        $dashboard->StoreTambahUser();
        break;        
    case 'manage-tarif':
        $dashboard->ManageTarif();
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
    case 'transaksi':
        $dashboard->ShowInsertTransaksi();
        break;
    case 'store-transaksi':
        $dashboard->StoreTransaksi();
        break;            

    // 404 Not Found    
    default:
        http_response_code(404);
        include __DIR__ . "/../Resources/Views/errors/404.php";
        break;    
}
?>