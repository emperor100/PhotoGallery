CREATE TABLE likedphotos (
    imageid INT NOT NULL,
    username VARCHAR(50) NOT NULL,

  CONSTRAINT FK_likedphotos_id FOREIGN KEY (imageid) REFERENCES sharedphotos (imageid) ON DELETE CASCADE,
  CONSTRAINT FK_likedphotos_user FOREIGN KEY (username) REFERENCES users (username) ON DELETE CASCADE,

  CONSTRAINT PK_likedphotos PRIMARY KEY (imageid,username)
);




