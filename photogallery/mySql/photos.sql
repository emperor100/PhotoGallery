CREATE TABLE photos (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    imagename VARCHAR(50) NOT NULL UNIQUE,
	albumname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	photo_link text NOT NULL,
	FOREIGN KEY (albumname)
        REFERENCES albums (name)
        ON DELETE CASCADE
);