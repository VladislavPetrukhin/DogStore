-- SQL-скрипт для базы данных DogPanel (dogpanel_schema.sql)

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password) VALUES ('admin', 'ilovedogs');

CREATE TABLE IF NOT EXISTS breeds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

INSERT INTO breeds (name) VALUES
('Самоед'),
('Немецкая овчарка'),
('Лабрадор ретривер'),
('Золотистый ретривер'),
('Хаски'),
('Дог'),
('Корги'),
('Мопс');

CREATE TABLE IF NOT EXISTS dogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    breed_id INT NULL,
    age INT NULL,
    price DECIMAL(10,2) NULL,
    description TEXT NULL,
    main_photo VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_dogs_breed FOREIGN KEY (breed_id) REFERENCES breeds(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS dog_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dog_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_dog_photos_dog FOREIGN KEY (dog_id) REFERENCES dogs(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NULL,
    image VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NULL,
    message TEXT NOT NULL,
    approved TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
