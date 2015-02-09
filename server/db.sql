CREATE TABLE photo
(
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    sender BIGINT NOT NULL,
    recipient BIGINT,
    storage_identifier VARCHAR(255) NOT NULL,
    sent_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
CREATE TABLE user
(
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password_md5 VARCHAR(255) NOT NULL
);
ALTER TABLE photo ADD FOREIGN KEY (recipient) REFERENCES user (id);
ALTER TABLE photo ADD FOREIGN KEY (sender) REFERENCES user (id);
CREATE INDEX fk_photo_recipient ON photo (recipient);
CREATE INDEX fk_photo_sender ON photo (sender);
CREATE UNIQUE INDEX unique_username ON user (username);
