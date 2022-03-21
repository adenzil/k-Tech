<?php

session_start();

require_once '../Services/CSVService.php';
require_once '../Services/StockService.php';

// Always return JSON for API calls.
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if(isset($_FILES['file'])) {

    $file = $_FILES['file'];
    
    // Check upload error
    if($file['error'] != 0) {
        echo json_encode(array('status' => 'failure', 'message' => 'File uploaded unsuccessfully'));
        die();
    }

    // Check file type
    if($file['type'] != 'text/csv') {
        echo json_encode(array('status' => 'failure', 'message' => 'Please upload csv file'));
        die();
    }

    $fileName = sprintf('../Resources/uploads/%s.%s', sha1_file($file['tmp_name']), 'csv');

    if (!move_uploaded_file($file['tmp_name'], $fileName)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    $csvService = new CSVService($fileName);
    $stocks = $csvService->readCSV();

    $data = [];

    if(!empty($stocks)) {
        $stockService = StockService::getInstance($stocks);
        $data['stocks'] = $stockService->allStockEntries();
        $_SESSION['stocks'] = $data['stocks'];
        $data['uniqueStockNames'] = $stockService->uniqueStockNames();
    }

    echo json_encode(array('status'=> 'success', 'data' => $data));
    
    die();
}

if(isset($_GET['selectedStock'])) {
    
    if(empty($_SESSION['stocks']))
        return;
    
    $selectedStockName = $_GET['selectedStock'];
    
    $stockService = StockService::getInstance($_SESSION['stocks']);
    
    //Check if stock exists
    if(!$stockService->checkStockExists($selectedStockName))
        return;

    $transactions = $stockService->filterStockByName($selectedStockName);
    
    if(isset($_GET['startDate'])) {
        $startDate = date('Y-m-d', strtotime($_GET['startDate']));
        $endDate = isset($_GET['endDate']) ? date('Y-m-d', strtotime($_GET['endDate'])) : date('Y-m-d');
        $transactions = $stockService->filterTransactionsByDate($transactions, $startDate, $endDate);
    }

    if(count($transactions) < 2) {
        echo json_encode(array('status'=> 'failure', 'message' => 'Not enough transactions for selected date range.'));
        die();
    }
    
    $bestDates = $stockService->getBestDatesByTransactions($transactions);
    if(!(isset($bestDates['buy']) && isset($bestDates['sell']))) {
        echo json_encode(array('status'=> 'failure', 'message' => 'No valid buy/sell transactions for selected stock or date range.'));
        die();
    }
    $analytics = $stockService->getAnalyticsByDates($bestDates, $transactions);

    echo json_encode(array('status'=> 'success', 'data' => [
        'bestDates' => $bestDates,
        'analytics' => $analytics
    ]));
    
    die();
}

?>