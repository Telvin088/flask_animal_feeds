CREATE DATABASE agrikenya_admin;

USE agrikenya_admin;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    profile_picture VARCHAR(255), -- Store the path or URL to the profile picture
    phone_number VARCHAR(20), -- You can adjust the length as needed
    password VARCHAR(255) NOT NULL
);


USE agrikenya_admin;

CREATE TABLE new_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    units VARCHAR(255),
    description VARCHAR(255),
    image VARCHAR(255)
);


USE agrikenya_admin;
CREATE TABLE new_events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    topic VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL
);

-- DELETE FROM your_table_name
-- WHERE column_name = some_value;

USE agrikenya_admin;
CREATE TABLE top_ordered (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE agrikenya_admin.approved_report (
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    location VARCHAR(255),
    product VARCHAR(255),
    message TEXT,
    PRIMARY KEY (name)
);






-- CLIENTS

CREATE DATABASE agrikenya_clients;

USE agrikenya_clients;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    profile_picture VARCHAR(255), -- Store the path or URL to the profile picture
    phone_number VARCHAR(20), -- You can adjust the length as needed
    quantities VARCHAR(255),
    password VARCHAR(255) NOT NULL
);



USE agrikenya_clients;

CREATE TABLE recent_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    quantity VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    products TEXT NOT NULL,
    status TEXT NOT NULL,
    request_date DATE NOT NULL DEFAULT CURRENT_DATE
);


USE agrikenya_clients;

CREATE TABLE missing_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    quantity VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    products TEXT NOT NULL,
    status TEXT NOT NULL,
    request_date DATE NOT NULL DEFAULT CURRENT_DATE
);



USE agrikenya_clients;

CREATE TABLE client_messages (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(20) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message VARCHAR(255) NOT NULL
);