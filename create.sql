DROP DATABASE IF EXISTS omni;
CREATE DATABASE IF NOT EXISTS omni;
USE omni;

/* ------------------------------
------------ SESSION ------------
------------------------------ */
DROP TABLE IF EXISTS sessions;
CREATE TABLE IF NOT EXISTS sessions
(
	id SERIAL,
	session_id TEXT NOT NULL,
	access_at INTEGER,
	data TEXT,
	PRIMARY KEY(id)
)ENGINE = InnoDB DEFAULT CHARSET = Latin1;

/* ------------------------------
------------- USERS -------------
------------------------------ */
DROP TABLE IF EXISTS access_level;
CREATE TABLE IF NOT EXISTS access_level
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	description VARCHAR(255) UNIQUE NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = Latin1;

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

/* ------------------------------
----------- EXPENSES ------------
------------------------------ */

DROP TABLE IF EXISTS  category;
CREATE TABLE IF NOT EXISTS category
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	description VARCHAR(255) UNIQUE NOT NULL,
	icon VARCHAR(50) NOT NULL,
	color VARCHAR(15) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	updated_at DATETIME,
	PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = Latin1;

DROP TABLE IF EXISTS  expense;
CREATE TABLE IF NOT EXISTS expense
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	description VARCHAR(255) NOT NULL,
	value VARCHAR(50) NOT NULL,
	category_id INT(10) UNSIGNED NOT NULL,
	user_access_id INT(10) UNSIGNED NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	updated_at DATETIME,
	PRIMARY KEY (id),
	CONSTRAINT expense_category_id
	FOREIGN KEY fk_expense_category_id(category_id)
	REFERENCES category(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
    CONSTRAINT expense_user_access_id
	FOREIGN KEY fk_expense_user_access_id(user_access_id)
	REFERENCES user_access(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = Latin1;



/**
 * STORED PROCEDURES
 */

/**
 * @Procedure listUserAccess
 * Lista todos os usuários de acesso ao sistema
 *
 * DROP PROCEDURE IF EXISTS listUserAccess;
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

/**
 * @Procedure userRegister
 * Registra usuários no sistema
 *
 * DROP PROCEDURE IF EXISTS userRegister;
 */
DELIMITER $$
CREATE PROCEDURE userRegister(
	IN name VARCHAR(255),
	IN cpf VARCHAR(15),
	IN gender CHAR(1),
	IN birthdate DATETIME,
	IN cellphone VARCHAR(18),
	IN address VARCHAR(255),
	IN address_num VARCHAR(5),
	IN address_compl VARCHAR(80),
	IN email VARCHAR(80),
	IN password VARCHAR(72))
	BEGIN
		SET @access_level_id = 2;
        SET @user_access_id_inserted = 0;
        SET @user_id_inserted = 0;
        START TRANSACTION;
		INSERT INTO user_access (email, password, access_level_id) VALUES (email, password, @access_level_id);
		SELECT LAST_INSERT_ID() INTO @user_access_id_inserted;

        IF (SELECT @user_access_id_inserted <= 0) THEN
			ROLLBACK;
		ELSE
			COMMIT;
		END IF;

        START TRANSACTION;
        INSERT INTO user(
			name,
			cpf,
			gender,
			birthdate,
			cellphone,
			address,
			address_num,
			address_compl,
			user_access_id
		) VALUES (
			name,
			cpf,
			gender,
			birthdate,
			cellphone,
			address,
			address_num,
			address_compl,
			@user_access_id_inserted
		);
		SELECT LAST_INSERT_ID() INTO @user_id_inserted;
		SELECT @user_access_id_inserted AS user_access_id, @user_id_inserted AS user_id;
        IF (SELECT @user_id_inserted <= 0) THEN
			ROLLBACK;
		ELSE
			COMMIT;
		END IF;

	END $$
DELIMITER ;

/**
 * @Procedure getUserAccess
 * Recupera usuário que acabou de logar no sistema
 * Autenticação
 *
 * DROP PROCEDURE IF EXISTS getUserAccess;
 */
DELIMITER $$
CREATE PROCEDURE getUserAccess(IN email VARCHAR(80))
	BEGIN
		SELECT
			ua.id,
		    u.name,
		    ua.email,
		    al.description AS level
		FROM user_access AS ua
		LEFT JOIN user AS u
			ON u.user_access_id = ua.id
		INNER JOIN access_level AS al
			ON al.id = ua.access_level_id
		WHERE ua.email = email;
	END $$
DELIMITER ;

/**
 * @Procedure getUserExpenses
 * Recupera usuário que acabou de logar no sistema
 * Autenticação
 *
 * DROP PROCEDURE IF EXISTS getUserExpenses;
 */
DELIMITER $$
CREATE PROCEDURE getUserExpenses(IN id INT(10))
	BEGIN
		SELECT
			ex.id,
			ex.description,
		    ex.value,
		    c.description AS category,
		    ex.created_at AS date
		FROM expense AS ex
			INNER JOIN category AS c
		    ON c.id = ex.category_id
		WHERE user_access_id = id;
	END $$
DELIMITER ;