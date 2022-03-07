<?php

class StockService
{
    private static $instance = null;

    public static function getInstance($stocks = []) {
        if (self::$instance == null) {
            self::$instance = new StockService($stocks);
        }
        return self::$instance;
    }

    function __construct($stocks) {
        $this->stocks = $stocks;
        $this->quantity = 200;
        $this->sortStocksByDate();
    }

    function allStockEntries() {
        return $this->stocks;
    }

    function uniqueStockNames() {
        return array_values(array_unique(array_column($this->stocks, 'stock_name')));
    }

    function checkStockExists($stockName) {
        return in_array($stockName, $this->uniqueStockNames());
    }

    function filterStockByName($stockName) {
        return array_values(array_filter($this->stocks, function ($stock) use ($stockName) {
            return (strtolower($stock['stock_name']) == strtolower($stockName));
        }));
    }

    function sortStocksByDate() {
        usort($this->stocks, function($a, $b) {
            return $a['date'] <=> $b['date'];
        });
    }

    function formatStockData() {
        foreach($this->stocks as $key => $stock) {
            echo ($stock["date"] . " " . $stock["stock_name"] . " " . $stock["price"] . " " ."<br/>");
        }
    }

    function getBestDatesByTransactions($transactions) {
        $maxDiff = -INF;
        $selectedTransactions = [];
        $selectedTransactions['allTransactions'] = $transactions;
        foreach($transactions as $key => $transaction) {
            for ($i=($key + 1); $i < count($transactions) ; $i++) {
                $priceDiff = $transactions[$i]['price'] - $transaction['price'];
                if($priceDiff > $maxDiff) {
                    $maxDiff = $priceDiff;
                    $selectedTransactions['buy'] = $transaction;
                    $selectedTransactions['sell'] = $transactions[$i];
                }
            }
        }
        return $selectedTransactions;
    }

    function filterTransactionsByDate($transactions, $startDate, $endDate) {
        return array_values(array_filter($transactions, function ($transaction) use ($startDate, $endDate) {
            $transactionDate = date('Y-m-d', strtotime($transaction['date']));
            return ($transactionDate >= $startDate && $transactionDate <= $endDate);
        }));
    }

    function getAnalyticsByDates($bestDates, $transactions) {
        return [
            'quantity' => $this->quantity,
            'profit' => ($bestDates['sell']['price'] - $bestDates['buy']['price']) * $this->quantity,
            'meanPrice' => $bestDates['buy']['price'],
            'deviation' => $this->standardDeviationByTransactions(array_values(array_column($transactions, 'price')))
        ];  
    }

    function standardDeviationByTransactions($transactions) {
        $num_of_elements = count($transactions);
        $variance = 0.0;
        $average = array_sum($transactions)/$num_of_elements;
        foreach($transactions as $transaction) {
            $variance += pow(($transaction - $average), 2);
        }
        return number_format((float)sqrt($variance/$num_of_elements), 2, '.', '');
    }
}

?>