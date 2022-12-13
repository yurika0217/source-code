-- マンガDBを追加
CREATE DATABASE manga;

-- マンガDBを使用
USE manga;

-- 顧客テーブルを追加
CREATE TABLE users(
 id INT PRIMARY KEY AUTO_INCREMENT,
 login_id varchar(255) NOT NULL,
 name  varchar(255) NOT NULL,
 pass varchar(255) NOT NULL,
 post varchar(255) NOT NULL,
 prefecture varchar(255) NOT NULL,
 city varchar(255) NOT NULL,
 o_address varchar(255),
 phone varchar(255) NOT NULL,
 mail varchar(255) NOT NULL,
 flg TINYINT NOT NULL DEFAULT'0'
) DEFAULT CHARACTER SET=utf8;

-- 管理者テーブルを追加
CREATE TABLE admin( 
 id INT PRIMARY KEY AUTO_INCREMENT,
 login_id varchar(255) NOT NULL,
 name  varchar(255) NOT NULL,
 pass varchar(255) NOT NULL,
 flg TINYINT NOT NULL DEFAULT'0'
) DEFAULT CHARACTER SET=utf8;

-- 商品テーブルを追加
CREATE TABLE books(
 id INT PRIMARY KEY AUTO_INCREMENT,
 isbn char(20) UNIQUE NOT NULL,
 title  varchar(255) NOT NULL,
 price INT NOT NULL,
 category_id INT NOT NULL,
 detail varchar(255) NOT NULL,
 stock varchar(255) NOT NULL,
 publish_date DATETIME NOT NULL,
 author varchar(255) NOT NULL,
 author_kana varchar(255) NOT NULL,
 publish varchar(255) NOT NULL,
 img varchar(255) NOT NULL,
 flg TINYINT NOT NULL DEFAULT'0'
) DEFAULT CHARACTER SET=utf8;

-- 購入テーブルを追加
CREATE TABLE purchase(
 id INT PRIMARY KEY AUTO_INCREMENT,
 user_id varchar(255) NOT NULL,
 pay_id INT NOT NULL,
 payment varchar(255) NOT NULL,
 pur_date DATETIME NOT NULL,
 flg TINYINT NOT NULL DEFAULT'0'
) DEFAULT CHARACTER SET=utf8;

-- 購入詳細テーブルを追加
CREATE TABLE purdetails(
 isbn char(20) PRIMARY KEY UNIQUE NOT NULL,
 pur_id INT NOT NULL,
 quantity varchar(255)
) DEFAULT CHARACTER SET=utf8;
