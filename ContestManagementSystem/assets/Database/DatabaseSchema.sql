CREATE DATABASE ContestManagementSystem;

USE ContestManagementSystem;

CREATE TABLE Registration
(
	userId int AUTO_INCREMENT PRIMARY KEY,
	firstName VARCHAR(15) NOT NULL,
	middleName VARCHAR(15) NOT NULL,
	lastName VARCHAR(15) NOT NULL,
	mobileNo CHAR(10) UNIQUE NOT NULL,
	emergencyContactNo CHAR(10) UNIQUE NOT NULL,
	emailId VARCHAR(30) UNIQUE NOT NULL,
	username VARCHAR(15) UNIQUE NOT NULL,
	password CHAR(32) NOT NULL,
	birthDate DATE NOT NULL,
	gender CHAR(1) NOT NULL,
	permanentAdd VARCHAR(80) NOT NULL,
	temporaryAdd VARCHAR(80),
	city VARCHAR(28) NOT NULL,
	registrationDt DATETIME,
	profilePic VARCHAR(255) NOT NULL,
	identityProof VARCHAR(255) NOT NULL,
	winnerCount INT,
	status CHAR(1) DEFAULT "a",
	theme VARCHAR(10) DEFAULT "White"
);

INSERT INTO Registration (firstName,middleName,lastName,mobileNo,emergencyContactNo,emailId,username,password,birthDate,gender,permanentAdd,city,registrationDt,profilePic,identityProof)
VALUES("Hiyan","Anilbhai","Singh","9874586541","9874575845","coordinator@gmail.com","hiyan_",MD5("pass@co1"),"1995-04-15","M","Landmark Buildings","Surat","2020-11-05 04:45:21","coordinator.jpg","coordinator.pdf");


CREATE TABLE ContestLevel
(
	clId int AUTO_INCREMENT PRIMARY KEY,
	cLevel VARCHAR(13) NOT NULL
);

INSERT INTO ContestLevel(cLevel) VALUES
("Local"),
("State"),
("National"),
("International");


CREATE TABLE Contest
(
	cId INT AUTO_INCREMENT PRIMARY KEY,
	cName VARCHAR(40) NOT NULL,
	cType INT(1) NOT NULL,
	cDate DATE NOT NULL,
	CDuration INT(5) NOT NULL,
	cDescription VARCHAR(255) NOT NULL,
	cBanner VARCHAR(255) NOT NULL,
	FOREIGN KEY (cType) REFERENCES ContestLevel(clId)
);

INSERT INTO Contest (cName,cType,cDate,CDuration,cDescription,cBanner) VALUES
("Punjabi Food Making Contest",2,"2023-05-16",45,"This contest will held in Punjab on 16 May 2023.","PunjabiFood.jpeg"),
("Gujarati Breakfast Contest",1,"2023-09-03",120,"This contest will held in Surat city of Gujarat State on 03 September 2023.","GujaratiBreakfast.jpeg"),
("Pizza Making Contest",4,"2023-06-25",30,"In this contest, participant has to make pizza in 30 minutes with the good taste.","Pizza.jpeg");


CREATE TABLE Participation
(
	pId INT AUTO_INCREMENT PRIMARY KEY,
	cId INT NOT NULL,
	userId INT NOT NULL,
	participantRegistrationDate DATE NOT NULL,
	FOREIGN KEY (cId) REFERENCES Contest(cId),
	FOREIGN KEY (userId) REFERENCES Registration(userId)
);

CREATE PROCEDURE insertParticipationInfo(cId INT, userId INT, participantRegistrationDate DATE)
	INSERT INTO Participation(cId,userId,participantRegistrationDate) VALUES(cId,userId,participantRegistrationDate);


CREATE TABLE OnlineUsers
(
	userId INT,
	FOREIGN KEY (userId) REFERENCES Registration(userId)
);


CREATE TABLE Result
(
	pId INT,
	scoreByJudge1 INT NOT NULL,
	scoreByJudge2 INT NOT NULL,
	scoreByJudge3 INT NOT NULL,
	timeTaken INT(3) NOT NULL,
	scoreEntryDate DATE NOT NULL,
	FOREIGN KEY (pId) REFERENCES Participation(pId)
);


CREATE TABLE ContestResult
(
	rId INT AUTO_INCREMENT PRIMARY KEY,
	cId INT NOT NULL,
	winnerPid INT NOT NULL,
	runnerupPid INT NOT NULL,
	timeTaken INT(3) NOT NULL,
	scoreEntryDate DATE NOT NULL,
	FOREIGN KEY (cId) REFERENCES Contest(cId),
	FOREIGN KEY (winnerPid) REFERENCES Participation(pId),
	FOREIGN KEY (runnerupPid) REFERENCES Participation(pId)
);




DELIMITER //
CREATE TRIGGER increaseWinnerCount 
AFTER INSERT 
ON ContestResult FOR EACH ROW
BEGIN
    UPDATE Registration SET winnerCount = winnerCount + 1 WHERE userId = NEW.winnerPid;
END //