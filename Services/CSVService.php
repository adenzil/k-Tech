<?php

class CSVService
{
    function __construct($file = '../Resources/uploads/SampleStockPriceList.csv') {
        $this->file = $file;
    }

    function readCSV() {
        $csvFile = fopen($this->file, 'r');
        // skips header
        fgetcsv($csvFile);
        $stocks = [];
        while(!feof($csvFile)) {
            $row = fgetcsv($csvFile);
            if (!empty($row)) {
                $stocks[] = [
                    'date' => $row[1],
                    'stock_name' => $row[2],
                    'price' => $row[3]
                ];
            }
        }
        fclose($csvFile);
        return $stocks;
    }
}

?>