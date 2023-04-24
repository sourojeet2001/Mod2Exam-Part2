-- Active: 1677665060185@@127.0.0.1@3306@MusicPlayer

CREATE TABLE Registration_Details(
    UserId INT AUTO_INCREMENT PRIMARY KEY,
    Firstname VARCHAR(30) NOT NULL CHECK(Firstname <> ""),
    Lastname VARCHAR(30) NOT NULL CHECK(Lastname <> ""),
    Phone VARCHAR(13) UNIQUE NOT NULL CHECK(Phone <> ""),
    EmailId VARCHAR(50) UNIQUE NOT NULL CHECK(EmailId <> ""),
    UserPassword VARCHAR(50) NOT NULL CHECK(UserPassword <> ""),
    UserRole VARCHAR(255) NOT NULL CHECK(UserRole <> "")
);

CREATE TABLE Upload (
  EmpId INT PRIMARY KEY,
  EmpName VARCHAR(30) NOT NULL CHECK(EmpName <> ""),
  EmpType VARCHAR(30) NOT NULL CHECK(EmpType <> ""),
  EmpPoint INT NOT NULL
);

CREATE TABLE MyTeam (
  EmpId INT PRIMARY KEY,
  EmpName VARCHAR(30) NOT NULL CHECK(EmpName <> ""),
  EmpType VARCHAR(30) NOT NULL CHECK(EmpType <> ""),
  EmpPoint INT NOT NULL
);
