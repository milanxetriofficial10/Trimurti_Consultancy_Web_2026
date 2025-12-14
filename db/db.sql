create database project_1_chabahil;

use project_1_chabahil;

CREATE TABLE slider_images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        image VARCHAR(255) NOT NULL,
        heading VARCHAR(255) DEFAULT NULL,
        btn_text VARCHAR(100) DEFAULT NULL,
       btn_link VARCHAR(255) DEFAULT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );

     CREATE TABLE admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );


ALTER TABLE slider_images
    -> ADD COLUMN paragraph TEXT DEFAULT NULL;


CREATE TABLE `top_news` (
    ->     `id` INT AUTO_INCREMENT PRIMARY KEY,
    ->     `title` VARCHAR(255) NOT NULL,
    ->     `link` VARCHAR(255) DEFAULT NULL,
    ->     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    -> );

CREATE TABLE `courses` (
    ->   `id` INT AUTO_INCREMENT PRIMARY KEY,
    ->   `title` VARCHAR(255) NOT NULL,
    ->   `description` TEXT,
    ->   `image` VARCHAR(255),
    ->   `button_text` VARCHAR(50),
    ->   `button_link` VARCHAR(255),
    ->   `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    -> );


 CREATE TABLE course_categories (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     name VARCHAR(255) NOT NULL,
    ->     image VARCHAR(255),
    ->     description TEXT
    -> );

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  email VARCHAR(100),
  password VARCHAR(255),
  role VARCHAR(20) DEFAULT 'user'
);

INSERT INTO users (username, email, password, role)
VALUES (
    'admin',
    'admin1111@gmail.com',
    '$2y$10$mOq4jh2kY8uJ5UkwgZlY4uVdLD7qRXDF3pzv2PaFqHCYmxQEj5J6O',
    'admin'
);



CREATE TABLE about_manager (
    id INT AUTO_INCREMENT PRIMARY KEY,
    manager_name VARCHAR(100),
    manager_image VARCHAR(200),
    manager_message TEXT
);
CREATE TABLE about_consultancy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT
);
CREATE TABLE about_slider (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    image VARCHAR(200),
    button_text VARCHAR(50),
    button_link VARCHAR(200),
    status TINYINT DEFAULT 1
);

ALTER TABLE about_manager
ADD consultancy_name VARCHAR(150),
ADD years_active INT,
ADD students_count INT;
