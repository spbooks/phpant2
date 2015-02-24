CREATE TABLE user (
  id          INT(11)     NOT NULL AUTO_INCREMENT,
  login       VARCHAR(50) NOT NULL DEFAULT '',
  password    VARCHAR(50) NOT NULL DEFAULT '',
  email       VARCHAR(50)          DEFAULT NULL,
  first_name  VARCHAR(50)          DEFAULT NULL,
  last_name   VARCHAR(50)          DEFAULT NULL,
  signature   TEXT        NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY user_login (login)
);

CREATE TABLE user_images (
  image_id    INT(11)      NOT NULL AUTO_INCREMENT,
  user_id     INT(11)      NOT NULL,
  type        VARCHAR(50)  NOT NULL DEFAULT '',
  filename    VARCHAR(32)  NOT NULL,
  PRIMARY KEY (image_id)
);