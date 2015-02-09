CREATE TABLE user
(
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password_md5 VARCHAR(255) NOT NULL
);
CREATE UNIQUE INDEX unique_username ON user (username);
