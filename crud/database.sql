CREATE DATABASE university;
USE university;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    semester VARCHAR(20),
    phone_number VARCHAR(15),
    email VARCHAR(100),
    gender ENUM('Male', 'Female', 'Other'),
    course VARCHAR(50)
);
