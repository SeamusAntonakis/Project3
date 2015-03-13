CREATE DATABASE IF NOT EXISTS site_db;

GRANT ALL ON *.*
TO 'primary'@'localhost' IDENTIFIED BY 'pass';

GRANT SELECT,INSERT,UPDATE,DELETE,DROP,CREATE ON * . * 
TO 'secondary'@'localhost' IDENTIFIED BY 'pass';

USE site_db;

CREATE TABLE IF NOT EXISTS users(
user_id		INT	UNSIGNED NOT NULL AUTO_INCREMENT,
first_name	VARCHAR(20) NOT NULL,
last_name	VARCHAR(40) NOT NULL,
email		VARCHAR(60) NOT NULL,
pass		CHAR(40) 	NOT NULL,
reg_date	DATETIME	NOT NULL,
PRIMARY KEY	(user_id),
UNIQUE		(email)
);

CREATE TABLE IF NOT EXISTS portal(
user_id		INT UNSIGNED NOT NULL,
dbid		INT NOT NULL,
retrieve	BOOLEAN NOT NULL,
insrt		BOOLEAN	NOT NULL,
updte		BOOLEAN	NOT NULL,
dlt			BOOLEAN NOT NULL,
FOREIGN KEY(user_id) REFERENCES users(user_id),
FOREIGN KEY(dbid) REFERENCES userdatabase(dbid)
);

CREATE UNIQUE INDEX portal_index ON portal(user_id, dbid);

CREATE TABLE IF NOT EXISTS userdatabase(
dbid		INT AUTO_INCREMENT,
dbname		VARCHAR(60)	NOT NULL,
user_id		INT UNSIGNED NOT NULL,
PRIMARY KEY (dbid),
FOREIGN KEY (user_id) REFERENCES users(user_id)
);