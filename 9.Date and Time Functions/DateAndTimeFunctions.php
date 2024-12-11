
<!-- 9. Date and Time Functions. Write a PHP script to demonstrate Date and Time functions. Display given date/time, operation and result. -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date and Time Functions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: #fff;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>PHP Date and Time Functions</h1>
    <table>
        <thead>
            <tr>
                <th>Given Date/Time</th>
                <th>Operation</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Example Date/Time
            $currentDateTime = date('Y-m-d H:i:s');
            $specificDate = '2024-01-01 12:00:00';

            // Display current date/time
            echo "<tr>
                    <td>$currentDateTime</td>
                    <td>Current Date and Time</td>
                    <td>$currentDateTime</td>
                  </tr>";

            // Format date
            $formattedDate = date('l, F j, Y', strtotime($specificDate));
            echo "<tr>
                    <td>$specificDate</td>
                    <td>Formatted Date</td>
                    <td>$formattedDate</td>
                  </tr>";

            // Add 10 days
            $datePlus10Days = date('Y-m-d', strtotime('+10 days', strtotime($specificDate)));
            echo "<tr>
                    <td>$specificDate</td>
                    <td>Add 10 Days</td>
                    <td>$datePlus10Days</td>
                  </tr>";

            // Subtract 1 month
            $dateMinus1Month = date('Y-m-d', strtotime('-1 month', strtotime($specificDate)));
            echo "<tr>
                    <td>$specificDate</td>
                    <td>Subtract 1 Month</td>
                    <td>$dateMinus1Month</td>
                  </tr>";

            // Difference between two dates
            $date1 = new DateTime('2024-01-01');
            $date2 = new DateTime('2024-02-15');
            $interval = $date1->diff($date2);
            echo "<tr>
                    <td>2024-01-01 and 2024-02-15</td>
                    <td>Difference Between Dates</td>
                    <td>{$interval->days} days</td>
                  </tr>";

            // Timestamp for current date
            $timestamp = time();
            echo "<tr>
                    <td>$currentDateTime</td>
                    <td>Current Timestamp</td>
                    <td>$timestamp</td>
                  </tr>";

            // Convert timestamp to date
            $convertedDate = date('Y-m-d H:i:s', $timestamp);
            echo "<tr>
                    <td>$timestamp</td>
                    <td>Convert Timestamp to Date</td>
                    <td>$convertedDate</td>
                  </tr>";

            // Timezone conversion
            $timezone = new DateTimeZone('America/New_York');
            $datetime = new DateTime('now', $timezone);
            echo "<tr>
                    <td>Current Time in America/New_York</td>
                    <td>Timezone Conversion</td>
                    <td>{$datetime->format('Y-m-d H:i:s')}</td>
                  </tr>";

            // Day of the week
            $dayOfWeek = date('l', strtotime($specificDate));
            echo "<tr>
                    <td>$specificDate</td>
                    <td>Day of the Week</td>
                    <td>$dayOfWeek</td>
                  </tr>";
            ?>
        </tbody>
    </table>
</body>
</html>
