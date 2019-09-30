CREATE TABLE albums (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL,
	description VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	photo_link text NOT NULL,
	FOREIGN KEY (username)
        REFERENCES users (username)
        ON DELETE CASCADE
);