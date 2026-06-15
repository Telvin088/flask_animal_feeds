<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <title>Document</title>
</head>

<body>

</body>

</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM new_products LIMIT 6";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<style>
        .container {
            width: 96%;
            // border: 1px solid red;
            margin-left: 2%;
            height: 500px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            z-index: -1;
        }
        .product {
            max-width: 400px;
            // max-width: 450px;
            width: auto;
            max-height: 250px;
            height: auto;
            // margin-top: -10px;
            // margin-bottom: -65px;
            // border: 1px solid #ddd;
            // padding: 10px;
            display: flex;
            text-align: center;
            background-color: #ffffff;
            border-radius: 5px;
            margin-top: 15px;
            position: relative;
            overflow: hidden;
        }

        .product:nth-child(7) {
            margin-top: -10px;
        }
        .product:nth-child(8) {
            margin-top: -10px;
        }
        .product:nth-child(9) {
            margin-top: -10px;
        }
        .product:nth-child(10) {
            margin-top: -10px;
        }
        .product:nth-child(11) {
            margin-top: -10px;
        }
        .product:nth-child(12) {
            margin-top: -10px;
        }
        .imageContainer {
            height: 100%;
            width: 100%;
            // border: 1px solid red;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
        }
        .imageContainer img {
            height: 80%;
            width: 100%;
            object-fit: cover;
        }
        .product p {
            text-align: center;
            margin-top: -5px;
            padding: 10px;
            font-size: 16px;
        }
        .product button {
            cursor: pointer;
            position: absolute;
            bottom: -30px;
            background-color: #fa9b1b;
            color: #ffffff;
            border: none;
            height: 30px;
            width: 80px;
            border-radius: 3px;
            left: 65%;
            transform: translateX(-50%);
            opacity: 0;
            transition: all 0.5s ease;
            // border: 1px solid red;
            // margin-top: -200px;
        }
        .product:hover button {
            bottom: 10px;
            opacity: 1;
        }
    </style>";

    echo "<div class='container'>";

    while ($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<div class='imageContainer'>";
        echo "<img class='productImage' src='/administrator/products/" . basename($row["image"]) . "' />";
        echo "</div>";
        echo "<div class='description-section'";
        echo "<h4 style='font-size: 20px; padding: 10px; margin-top: 10px; text-align: left;'><strong></strong> " . $row["name"] . "</h4>";
        echo "<p style='text-align: left; margin-top: -10px; margin-left: -10px;'><strong>Units:</strong> " . $row["units"] . "</p>";
        echo "<div style='margin-top: -30px; margin-left: 0px; text-align: left;'>";
        echo '<i style="color: #ffb800; font-size: 14px;" class="las la-star"></i>';
        echo '<i style="color: #ffb800; font-size: 14px;" class="las la-star"></i>';
        echo '<i style="color: #ffb800; font-size: 14px;" class="las la-star"></i>';
        echo '<i style="color: #ffb800; font-size: 14px;" class="las la-star"></i>';
        echo '<i style="color: #ffb800; font-size: 14px;" class="las la-star"></i>';
        echo "</div>";
        echo "<p style='text-align: left; margin-left: -10px;'><strong>Description:</strong> ";
        // Get the description from the row
        $description = $row["description"];
        // Limit the description to a certain number of words
        $words = explode(" ", $description);
        $maxWords = 16; // Change this to the desired maximum number of words
        if (count($words) > $maxWords) {
            $description = implode(" ", array_slice($words, 0, $maxWords)) . "...";
        }
        echo $description;
        echo "</p>";
        echo "<button data-product-id='" . $row["id"] . "' class='showPopupButton'>Request</button>";
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
} else {
    echo "No data found.";
}

$conn->close();
?>