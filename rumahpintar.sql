Drop database if exists rumahpintar;
create database rumahpintar;
use rumahpintar;

create table data_user(
username varchar(16) not null,
email varchar(50) not null,
password varchar(32) not null,
kode varchar(32) not null,
primary key(username))engine='MyISAM';

create table admin(
username varchar(16) not null,
email varchar(50) not null,
password varchar(32) not null,
primary key(username))engine='MyISAM';
