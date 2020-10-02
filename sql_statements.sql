-- Create database 'project1' if it does not exist
CREATE DATABASE IF NOT EXISTS project1;

-- Use database 'project1'
USE project1;

-- Create table 'account' with ID as primary key
CREATE TABLE account(
	id INT NOT NULL AUTO_INCREMENT,
	email VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	PRIMARY KEY(id)
);

-- Create table 'person' with ID as foreign key from table 'account'
CREATE TABLE person(
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  firstname VARCHAR(255) NOT NULL,
  middlename VARCHAR(255),
  lastname VARCHAR(255) NOT NULL,
  account_id INT NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(account_id) REFERENCES account(id)
);

-- Create user 'admin' in table 'account'
INSERT INTO account (id, email, password) 
VALUES ('1', 'admin@gmail.com', 'Welkom01');

-- Create user 'admin' in table 'person'
INSERT INTO person (id, username, firstname, lastname, account_id) 
VALUES ('1', 'admin', 'Mike', 'Wazowski', '1');