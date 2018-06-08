CREATE DATABASE GameParadise;

CREATE TABLE Games (
title VARCHAR(25) PRIMARY KEY,
category VARCHAR(25),
minage INT(25),
releasedate DATE,
publisher VARCHAR(25),
platform VARCHAR(25)
);