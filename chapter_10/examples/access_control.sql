CREATE TABLE user (
  user_id     INT(11)      NOT NULL AUTO_INCREMENT,
  login       VARCHAR(50)  NOT NULL DEFAULT '',
  password    VARCHAR(50)  NOT NULL DEFAULT '',
  email       VARCHAR(50)  DEFAULT NULL,
  firstName   VARCHAR(50)  DEFAULT NULL,
  lastName    VARCHAR(50)  DEFAULT NULL,
  signature   TEXT         NOT NULL,
  PRIMARY KEY (user_id),
  UNIQUE KEY user_login (login)
);

CREATE TABLE signup (
  signup_id    INT(11)     NOT NULL AUTO_INCREMENT,
  login        VARCHAR(50) NOT NULL DEFAULT '',
  password     VARCHAR(50) NOT NULL DEFAULT '',
  email        VARCHAR(50) DEFAULT NULL,
  firstName    VARCHAR(50) DEFAULT NULL,
  lastName     VARCHAR(50) DEFAULT NULL,
  signature    TEXT        NOT NULL,
  confirm_code VARCHAR(40) NOT NULL DEFAULT '',
  created      INT(11)     NOT NULL DEFAULT '0',
  PRIMARY KEY (signup_id),
  UNIQUE KEY confirm_code (confirm_code),
  UNIQUE KEY user_login (login),
  UNIQUE KEY email (email)
);

CREATE TABLE collection (
  collection_id INT(11)     NOT NULL auto_increment,
  name          VARCHAR(50) NOT NULL default '',
  description   TEXT        NOT NULL,
  PRIMARY KEY (collection_id)
);

CREATE TABLE user2collection (
  user_id       INT(11)     NOT NULL default '0',
  collection_id INT(11)     NOT NULL default '0',
  PRIMARY KEY (user_id, collection_id)
);

CREATE TABLE permission (
  permission_id INT(11)     NOT NULL AUTO_INCREMENT,
  name          VARCHAR(50) NOT NULL DEFAULT '',
  description   TEXT        NOT NULL,
  PRIMARY KEY (permission_id)
);

CREATE TABLE collection2permission (
  collection_id INT(11)     NOT NULL DEFAULT '0',
  permission_id INT(11)     NOT NULL DEFAULT '0',
  PRIMARY KEY (collection_id, permission_id)
);