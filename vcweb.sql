-- Create the 'vcweb' database
CREATE DATABASE IF NOT EXISTS vcweb;

-- Switch to the 'vcweb' database
USE vcweb;

-- Create the 'Users' table to store user information
CREATE TABLE Users (
    username VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create the 'chats' table to store chat messages
CREATE TABLE chats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_username VARCHAR(50) NOT NULL,
    receiver_username VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_username) REFERENCES Users(username),
    FOREIGN KEY (receiver_username) REFERENCES Users(username)
);

-- Create the 'conferences' table to store video conference information
CREATE TABLE conferences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    host_username VARCHAR(50) NOT NULL,
    conference_name VARCHAR(100) NOT NULL,
    start_time DATETIME NOT NULL,
    duration INT NOT NULL,
    FOREIGN KEY (host_username) REFERENCES Users(username)
);

-- Add any additional columns or constraints as needed for your application.
