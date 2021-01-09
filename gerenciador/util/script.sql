
CREATE DATABASE comprebilhete;

CREATE TABLE administrador (
  id int primary key AUTO_INCREMENT,
  nome varchar(100),
  email varchar(100) UNIQUE,
  senha varchar(256),
  status char(1)
);

CREATE TABLE contato (
  id int primary key AUTO_INCREMENT,
  nome varchar(100),
  email varchar(100),
  telefone varchar(20),
  cidade varchar(100),
  texto varchar(500)
);

CREATE TABLE visitante (
  id int primary key AUTO_INCREMENT,
  nome varchar(100),
  sobrenome varchar(200),
  cpf varchar(20) UNIQUE,
  rg varchar(20),
  cod_area varchar(5),
  telefone varchar(20),
  email varchar(100) UNIQUE,
  senha varchar(256),
  logradouro varchar(100),
  complemento varchar(100),
  numero varchar(20),
  bairro varchar(100),
  cidade varchar(100),
  estado char(2),
  cep varchar(20),
  datanascimento varchar(15),
  status char(1)
);

CREATE TABLE categoria (
  id int primary key AUTO_INCREMENT,
  descricao varchar(100) UNIQUE,
  status char(1)
);

CREATE TABLE parceiro (
  id int primary key AUTO_INCREMENT,
  nomefantasia varchar(100),
  razaosocial varchar(100),
  cnpj varchar(50),
  telefone varchar(20),
  email varchar(100),
  logradouro varchar(100),
  complemento varchar(100),
  numero varchar(20),
  bairro varchar(100),
  cidade varchar(100),
  estado char(2),
  cep varchar(20),
  contato varchar(100),
  imagem varchar(1000),
  status char(1)
);

CREATE TABLE pontovenda (
  id int primary key AUTO_INCREMENT,
  nome varchar(100),
  telefone varchar(20),
  email varchar(100),
  logradouro varchar(100),
  numero varchar(20),
  bairro varchar(100),
  cep varchar(20),
  cidade varchar(100),
  estado char(2),
  status char(1)
);

CREATE TABLE setor (
  id int primary key AUTO_INCREMENT,
  descricao varchar(100) UNIQUE,
  status char(1)
);

CREATE TABLE evento (
  id int primary key AUTO_INCREMENT,
  CATEGORIA_id int,
  PARCEIRO_id int,
  descricao varchar(100),
  local varchar(100),
  cidade varchar(100),
  estado char(2),
  abertura time,
  inicio time,
  data date,
  informacoes varchar(5000),
  imagem varchar(1000),
  capa varchar(1000),
  status char(1),
  CONSTRAINT FK_EVENTO_CATEGORIA FOREIGN KEY (CATEGORIA_ID) REFERENCES CATEGORIA (ID),
  CONSTRAINT FK_EVENTO_PARCEIRO FOREIGN KEY (PARCEIRO_ID) REFERENCES PARCEIRO (ID)
);

CREATE TABLE evento_pontovenda (
  id int primary key AUTO_INCREMENT,
  evento_id int,
  pontovenda_id int,
  taxacobranca float,
  CONSTRAINT FK_EVENTOPONTOVENDA_EVENTO FOREIGN KEY (evento_id) REFERENCES evento (id),
  CONSTRAINT FK_EVENTOPONTOVENDA_PONTOVENDA FOREIGN KEY (pontovenda_id) REFERENCES pontovenda (id)
);

CREATE TABLE evento_setor (
  id int primary key AUTO_INCREMENT,
  evento_id int,
  setor_id int,
  tipo varchar(100),
  valor float,
  taxa float,
  CONSTRAINT FK_EVENTOSETOR_EVENTO FOREIGN KEY (evento_id) REFERENCES evento (id),
  CONSTRAINT FK_EVENTOSETOR_SETOR FOREIGN KEY (setor_id) REFERENCES setor (id)
);

CREATE TABLE pedido (
  id int primary key AUTO_INCREMENT,
  visitante_id int,
  data date,
  total float,
  status int,
  taxa_total float,
  email int,
  status_detail varchar(50),
  CONSTRAINT FK_PEDIDO_VISITANTE FOREIGN KEY (visitante_id) REFERENCES visitante (id)
);

CREATE TABLE itens_pedido (
  id int primary key AUTO_INCREMENT,
  pedido_id int,
  evento_setor_id int,
  quantidade int,
  valor_unitario float,
  taxa_unitario float,
  CONSTRAINT FK_ITENSPEDIDO_PEDIDO FOREIGN KEY (pedido_id) REFERENCES pedido (id),
  CONSTRAINT FK_ITENSPEDIDO_EVENTO_SETOR FOREIGN KEY (evento_setor_id) REFERENCES evento_setor (id)
);

CREATE TABLE bilhetes(
  numero bigint primary key,
  status int,
  data_hora_status datetime,
  itens_pedido_id int,
  CONSTRAINT FK_BILHETE_ITENSPEDIDO FOREIGN KEY (itens_pedido_id) REFERENCES itens_pedido (id)
);

