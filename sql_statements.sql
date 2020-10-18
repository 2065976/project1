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
  username VARCHAR(255) UNIQUE NOT NULL,
  firstname VARCHAR(255) NOT NULL,
  middlename VARCHAR(255),
  lastname VARCHAR(255) NOT NULL,
  account_id INT NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(account_id) REFERENCES account(id)
);

-- Create table 'usertype' with ID as primary key
CREATE TABLE usertype (
  id INT NOT NULL AUTO_INCREMENT,
  type VARCHAR(255),
  created DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

-- Add  column 'created' and 'last_updated' to table 'person'
ALTER TABLE person
  ADD created DATETIME DEFAULT CURRENT_TIMESTAMP,
  ADD updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Add  column 'created' and 'last_updated' to table 'account'
ALTER TABLE account
  ADD created DATETIME DEFAULT CURRENT_TIMESTAMP,
  ADD updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Add column 'username' and foreign key for 'usertype_id' to table 'account'
ALTER TABLE account
  ADD username VARCHAR(255) UNIQUE NOT NULL AFTER id,
  ADD usertype_id INT NOT NULL,
  ADD FOREIGN KEY (usertype_id) REFERENCES usertype(id);

-- Drops column 'username' from table 'person'
ALTER TABLE person
  DROP column username;

-- Create usertypes 'user', 'mod' and 'admin' in table 'usertype'
INSERT INTO usertype (id, type)
  VALUES 
    ('1', 'user'),
    ('2', 'mod'),
	  ('3', 'admin');