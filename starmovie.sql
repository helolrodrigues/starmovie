/* Lógico_1: */

CREATE DATABASE Starmovie;
USE Starmovie;


CREATE TABLE usuarios (
    id_usuario int PRIMARY KEY,
    nome int
);

CREATE TABLE titulos (
    id_titulos int PRIMARY KEY,
    nome_filmes int,
    tipo int,
    nome_serie int
);

CREATE TABLE generos (
    id_generos int PRIMARY KEY,
    acao int,
    fantasia int,
    comedia int,
    romance int,
    suspense int,
    terror int,
    drama int
);

CREATE TABLE titulo_genero (
    fk_generos_id_generos int,
    fk_titulos_id_titulos int
);

CREATE TABLE reviews (
    fk_titulos_id_titulos int,
    fk_usuarios_id_usuario int,
    nota decimal,
    titulo_reviews int,
    conteudo int
);
 
ALTER TABLE titulo_genero ADD CONSTRAINT FK_titulo_genero_1
    FOREIGN KEY (fk_generos_id_generos)
    REFERENCES generos (id_generos)
    ON DELETE RESTRICT;
 
ALTER TABLE titulo_genero ADD CONSTRAINT FK_titulo_genero_2
    FOREIGN KEY (fk_titulos_id_titulos)
    REFERENCES titulos (id_titulos)
    ON DELETE RESTRICT;
 
ALTER TABLE reviews ADD CONSTRAINT FK_reviews_1
    FOREIGN KEY (fk_titulos_id_titulos)
    REFERENCES titulos (id_titulos)
    ON DELETE RESTRICT;
 
ALTER TABLE reviews ADD CONSTRAINT FK_reviews_2
    FOREIGN KEY (fk_usuarios_id_usuario)
    REFERENCES usuarios (id_usuario)
    ON DELETE RESTRICT;