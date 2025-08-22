-- 1) Table for users which can later be used for Authentication
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'admin',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO users (username, password_hash, role)
VALUES ('admin', '$2y$10$REPLACE_WITH_YOUR_BCRYPT_HASH', 'admin');

-- 2) SPORTS table(for lookup of the sports)
CREATE TABLE sports (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO sports (name) VALUES
('athletics track'), ('swimming'), ('cycling'), ('triathlon');

-- 3) ATHLETES table for recording paralympic athlete information
CREATE TABLE ipcathletes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  given_name VARCHAR(100) NOT NULL,
  family_name VARCHAR(100) NOT NULL,
  date_of_birth DATE NOT NULL,
  sport_id INT UNSIGNED NOT NULL,
  personal_best_time CHAR(8) NOT NULL,
  created_by INT UNSIGNED NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_athlete_sport FOREIGN KEY (sport_id) REFERENCES sports(id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_athlete_user FOREIGN KEY (created_by) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
