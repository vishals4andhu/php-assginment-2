CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE hotel_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_name VARCHAR(255) NOT NULL,
    visitor VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    edition VARCHAR(255) NOT NULL,
    rating DECIMAL(3,1) NOT NULL,
    review TEXT NOT NULL,
canada_image VARCHAR(255) NOT NULL
);