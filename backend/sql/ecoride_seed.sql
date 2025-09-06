-- EcoRide seed.sql (sample data)
USE ecoride;

INSERT INTO users (pseudo, email, password_hash, role, credits, suspended)
VALUES
('marie', 'marie@example.com', '$2y$10$hash_marie', 'USER', 40, 0),
('luc', 'luc@example.com', '$2y$10$hash_luc', 'USER', 30, 0),
('emma', 'emma@example.com', '$2y$10$hash_emma', 'EMPLOYEE', 20, 0),
('admin', 'admin@example.com', '$2y$10$hash_admin', 'ADMIN', 100, 0);

INSERT INTO vehicles (user_id, plate, first_registration_date, brand, model, color, energy)
VALUES
(1, 'EV-123-AB', '2023-04-10', 'Renault', 'Zoe', 'Vert', 'EV'),
(2, 'AA-456-BB', '2018-06-21', 'Peugeot', '308', 'Bleu', 'GAS');

-- Preferences for drivers
INSERT INTO preferences (driver_id, pref_key, pref_value) VALUES
(1, 'music', 'Pop'),
(1, 'talk', 'Low'),
(2, 'smoking', 'No'),
(2, 'pets', 'Yes');

-- Trips
INSERT INTO trips (driver_id, vehicle_id, from_city, to_city, start_datetime, end_datetime, price, seats_total, seats_left, eco, status)
VALUES
(1, 1, 'Paris', 'Lyon', '2025-09-01 08:00:00', NULL, 12, 3, 3, 1, 'PLANNED'),
(2, 2, 'Paris', 'Orléans', '2025-08-25 18:30:00', NULL, 6, 2, 2, 0, 'PLANNED'),
(1, 1, 'Lyon', 'Grenoble', '2025-08-28 07:15:00', NULL, 5, 3, 3, 1, 'PLANNED');

-- Bookings (Luc books Marie's Paris->Lyon)
INSERT INTO bookings (trip_id, passenger_id, seats, status, confirmed_at)
VALUES
(1, 2, 1, 'CONFIRMED', '2025-08-20 10:00:00');

-- Reviews (pending example)
INSERT INTO reviews (trip_id, reviewer_id, driver_id, rating, comment, status)
VALUES
(1, 2, 1, 5, 'Trajet parfait, conducteur très ponctuel.', 'PENDING');

-- Credit transactions
-- Initial credits are implied at signup; here we show booking flow
INSERT INTO credit_transactions (user_id, amount, type, ref_trip_id, created_at)
VALUES
(2, -12, 'BOOKING', 1, NOW()),   -- Luc pays 12 crédits
(1, +10, 'EARNED', 1, NOW()),    -- Marie gagne (price - fee)
(1, -2, 'PLATFORM_FEE', 1, NOW()); -- Plateforme prélève 2