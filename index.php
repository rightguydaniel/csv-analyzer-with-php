<?php

// Function to parse CSV file and categorize data
function parseCSV($filename) {
    $data = []; // Initialize empty array to store parsed data

    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Skip the header row
            if ($row[0] === 'Year') continue;

            // Extract relevant columns
            $industryName = $row[3];
            $newValue = str_replace(",", "", $row[8]);
            $value = floatval($newValue); // Convert value to float

            // If industry name already exists, add value to existing total
            if (array_key_exists($industryName, $data)) {
                $data[$industryName] += $value;
            } else {
                // If industry name doesn't exist, initialize total value
                $data[$industryName] = $value;
            }
        }
        fclose($handle);
    }

    return $data;
}

// Function to output data as a table
function outputTable($data) {
    // Sort data by industry name
    ksort($data);

    // Output table headers
    echo "<table border='1'>";
    echo "<tr><th>Industry Name</th><th>Total Financial Value (Dollars)</th></tr>";

    // Output data rows
    foreach ($data as $industry => $value) {
        $finalValue = number_format($value, 2);
        echo "<tr><td>$industry</td><td>$finalValue</td></tr>";
    }

    echo "</table>";
}

// Main program
$filename = "annual-enterprise-survey-2021-financial-year-provisional-csv.csv"; // Specify the filename here
$data = parseCSV($filename); // Parse CSV file
outputTable($data); // Output data as a table

?>
