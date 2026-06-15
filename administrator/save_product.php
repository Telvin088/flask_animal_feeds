<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $units = $_POST["units"];
    $description = $_POST["description"];

    if(isset($_FILES['image'])){
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        $allowed_extensions = array("jpeg", "jpg", "png");

        if(!in_array(strtolower($file_ext), $allowed_extensions)){
            echo "Error: Invalid file type. Please upload a valid image (JPEG or PNG).";
            exit();
        }

        $upload_directory = "products/";

        $image = $upload_directory . uniqid() . "." . $file_ext;

        if(move_uploaded_file($file_tmp, $image)){
            $conn = new mysqli("localhost", "root", "", "agrikenya_admin");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO new_products (name, units, image, description) VALUES ('$name', '$units', '$image', '$description')";

            if ($conn->query($sql) === TRUE) {
                echo "Data saved successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Error: Failed to move the uploaded file to the destination folder.";
        }
    } else {
        echo "Error: No file uploaded.";
    }
}
?>
