CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255)
);

CREATE TABLE Channel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    data DATETIME,
    liked TINYINT(1) DEFAULT 0
);

CREATE TABLE Hashtag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    data DATETIME
);

CREATE TABLE Field (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    data DATETIME
);

CREATE TABLE Field_Hashtag (
    id_hashtag INT,
    id_field INT,
    FOREIGN KEY (id_hashtag) REFERENCES Hashtag(id),
    FOREIGN KEY (id_field) REFERENCES Field(id)
);

CREATE TABLE SMS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    channel_id INT,
    description TEXT,
    data DATETIME,
    save TINYINT(1) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (channel_id) REFERENCES Channel(id)
);

CREATE TABLE SMS_Hashtag (
    id_sms INT,
    id_hashtag INT,
    FOREIGN KEY (id_sms) REFERENCES SMS(id),
    FOREIGN KEY (id_hashtag) REFERENCES Hashtag(id)
);