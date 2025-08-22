CREATE DATABASE evalphp2025;
USE evalphp2025;

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE users (
	id_users INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(50) UNIQUE,
    `password` VARCHAR(100)
    );
    
CREATE TABLE category (
	id_category INT PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(50) UNIQUE
);

CREATE TABLE book (
	id_book INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50),
    description TEXT,
    publication_date DATETIME, -- Par habitude, pour chaque date, je préfère utiliser DATETIME
    author VARCHAR(50),
    id_category INT,
    id_users INT,
    FOREIGN KEY (id_users) REFERENCES users(id_users),
    FOREIGN KEY (id_category) REFERENCES category(id_category)
);

INSERT INTO category (id_category, `name`)
VALUES 	(1, Bob),
		(2, Bobby),
        (3, Bobbychou),
        (4, Rom),
        (5, Romani),
        (6, Romulus);
        

SET FOREIGN_KEY_CHECKS = 1;