
CREATE TABLE vinyl (
	id INT PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(50) DEFAULT '',
	description TEXT,
	year YEAR(4) DEFAULT 0,
	genre VARCHAR(50),
	format varchar(25),
	price FLOAT DEFAULT 0
);