create database login_grupo2;
use login_grupo2;
create table usuarios(
id_usuario int auto_increment primary key,
nome varchar(30),
telefone varchar(30),
email varchar(200),
senha varchar(200)
);
select * from usuarios;
create table codigos(
id_usuario int auto_increment primary key,
codigo varchar(200),
data1 datetime
);
select * from codigos;