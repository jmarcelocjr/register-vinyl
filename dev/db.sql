
CREATE TABLE vinyl (
	id INT PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(50) DEFAULT '',
	description TEXT,
	year YEAR(4) DEFAULT 0,
	genre VARCHAR(50) NOT NULL DEFAULT '',
	format VARCHAR(25) NOT NULL DEFAULT '',
	stateOfUse VARCHAR(25) NOT NULL DEFAULT '',
	price FLOAT DEFAULT 0
);