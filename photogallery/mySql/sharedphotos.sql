CREATE TABLE sharedphotos (
	imageid INT NOT NULL PRIMARY KEY ,
    shared_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (imageid)
        REFERENCES photos (id)
        ON DELETE CASCADE
);