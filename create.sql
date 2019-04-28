CREATE DATABASE IF NOT EXISTS omni;
USE omni;

DROP TABLE IF EXISTS access_level;
CREATE TABLE IF NOT EXISTS access_level
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	description VARCHAR(255) UNIQUE NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = Latin1;

INSERT INTO access_level (description) VALUES('ADMIN');
INSERT INTO access_level (description) VALUES('USER');

DROP TABLE IF EXISTS user_access;
CREATE TABLE IF NOT EXISTS user_access
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	email VARCHAR(80) UNIQUE NOT NULL,
	password VARCHAR(72) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	updated_at DATETIME,
	access_level_id INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT user_access_level_id
	FOREIGN KEY fk_user_acess_level_id(access_level_id)
	REFERENCES access_level(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = Latin1;

DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS user
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	cpf VARCHAR(15) NOT NULL,
	gender CHAR(1) NOT NULL,
	birthdate DATETIME NOT NULL,
	cellphone VARCHAR(18) NOT NULL,
	address VARCHAR(255) NOT NULL,
    address_num VARCHAR(5) NOT NULL,
    address_compl VARCHAR(80),
	user_access_id INT(10) UNSIGNED NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	updated_at DATETIME,
	PRIMARY KEY (id),
	CONSTRAINT user_access_id
	FOREIGN KEY fk_user_access_id(user_access_id)
	REFERENCES user_access(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = Latin1;


/**
 * STORED PROCEDURES
 */

/**
 * @table user_access
 * Lista todos os usuários de acesso ao sistema
 */
DELIMITER $$
CREATE PROCEDURE listUserAccess()
	BEGIN
		SELECT
			ua.id
			, ua.email
			, al.description AS level
		FROM user_access AS ua
		INNER JOIN access_level AS al
			ON al.id = ua.access_level_id;
	END $$
DELIMITER ;

