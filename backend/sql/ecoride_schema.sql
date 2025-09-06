-- EcoRide schema.sql (MySQL 8+, InnoDB, utf8mb4)
SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE DATABASE IF NOT EXISTS ecoride CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecoride;

-- Drop tables in order (if re-running)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS credit_transactions;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS preferences;
DROP TABLE IF EXISTS trips;
DROP TABLE IF EXISTS vehicles;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pseudo VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('USER','EMPLOYEE','ADMIN') NOT NULL DEFAULT 'USER',
  credits INT NOT NULL DEFAULT 20,
  suspended TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE vehicles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  plate VARCHAR(20) NOT NULL,
  first_registration_date DATE,
  brand VARCHAR(60),
  model VARCHAR(60),
  color VARCHAR(30),
  energy ENUM('EV','HYBRID','GAS','DIESEL') NOT NULL,
  CONSTRAINT fk_vehicle_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY uniq_vehicle_plate (plate)
) ENGINE=InnoDB;

CREATE TABLE trips (
  id INT AUTO_INCREMENT PRIMARY KEY,
  driver_id INT NOT NULL,
  vehicle_id INT NOT NULL,
  from_city VARCHAR(80) NOT NULL,
  to_city VARCHAR(80) NOT NULL,
  start_datetime DATETIME NOT NULL,
  end_datetime DATETIME,
  price INT NOT NULL, -- price in platform credits
  seats_total INT NOT NULL,
  seats_left INT NOT NULL,
  eco TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('PLANNED','ONGOING','FINISHED','CANCELLED') NOT NULL DEFAULT 'PLANNED',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_trip_search (from_city, to_city, start_datetime),
  CONSTRAINT fk_trip_driver FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE RESTRICT,
  CONSTRAINT fk_trip_vehicle FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE preferences (
  id INT AUTO_INCREMENT PRIMARY KEY,
  driver_id INT NOT NULL,
  pref_key VARCHAR(50) NOT NULL,
  pref_value VARCHAR(100) NOT NULL,
  CONSTRAINT fk_pref_driver FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_pref_driver (driver_id)
) ENGINE=InnoDB;

CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  trip_id INT NOT NULL,
  passenger_id INT NOT NULL,
  seats INT NOT NULL DEFAULT 1,
  status ENUM('PENDING','CONFIRMED','CANCELLED') NOT NULL DEFAULT 'CONFIRMED',
  confirmed_at DATETIME NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_booking_trip FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE,
  CONSTRAINT fk_booking_passenger FOREIGN KEY (passenger_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY uniq_trip_passenger (trip_id, passenger_id)
) ENGINE=InnoDB;

CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  trip_id INT NOT NULL,
  reviewer_id INT NOT NULL,
  driver_id INT NOT NULL,
  rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
  comment VARCHAR(500),
  status ENUM('PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'PENDING',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_review_trip FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE,
  CONSTRAINT fk_review_reviewer FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_review_driver FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE credit_transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  amount INT NOT NULL, -- positive or negative
  type ENUM('INIT','BOOKING','PLATFORM_FEE','EARNED','REFUND') NOT NULL,
  ref_trip_id INT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_tx_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_tx_user_date (user_id, created_at)
) ENGINE=InnoDB;