CREATE DATABASE teste;

USE teste;

CREATE TABLE maquina(
    id_maquina INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nome_maquina VARCHAR(50) NOT NULL
);

CREATE TABLE operacao(
    id_operacao INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nome_operacao VARCHAR(50) NOT NULL
);

CREATE TABLE turnos(
    id_turnos INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nome_turno VARCHAR(50) NOT NULL
);

CREATE TABLE operadores(
    id_operador INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nome_operador VARCHAR(50) NOT NULL,
    turnos_id INT UNSIGNED,
    
    FOREIGN KEY (turnos_id) REFERENCES turnos(id_turnos)
);

CREATE TABLE nop(
    numero_ordem VARCHAR(12) PRIMARY KEY,
    codigo INT(10) UNSIGNED NOT NULL,
    quantidadeMaxima INT(10) UNSIGNED NOT NULL,
    quantidade INT(10) UNSIGNED NOT NULL,
    lote VARCHAR(10) NOT NULL,
    data_inicial DATETIME NOT NULL,
    data_final DATETIME NOT NULL,
    perda INT(10) UNSIGNED,
    operacao_id INT UNSIGNED,
    maquina_id INT UNSIGNED,
    operador_id INT UNSIGNED,
    turnos_id INT UNSIGNED,
    
    FOREIGN KEY (operacao_id) REFERENCES operacao(id_operacao),
    FOREIGN KEY (maquina_id) REFERENCES maquina(id_maquina),
    FOREIGN KEY (operador_id) REFERENCES operadores(id_operador),
    FOREIGN KEY (turnos_id) REFERENCES turnos(id_turnos)
);

CREATE TABLE historico(
    ordem VARCHAR(12),
    quantidade INT(10) UNSIGNED NOT NULL,
    data_inicial DATETIME NOT NULL,
    data_final DATETIME NOT NULL,
    perda INT(10) UNSIGNED,
    operacao_id INT UNSIGNED,
    maquina_id INT UNSIGNED,
    operador_id INT UNSIGNED,
    PRIMARY KEY(ordem, operacao_id),
    
    FOREIGN KEY (ordem) REFERENCES nop(numero_ordem),
    FOREIGN KEY (operacao_id) REFERENCES operacao(id_operacao),
    FOREIGN KEY (maquina_id) REFERENCES maquina(id_maquina),
    FOREIGN KEY (operador_id) REFERENCES operadores(id_operador)
);


-- INSERTS:
INSERT INTO maquina(nome_maquina)
VALUES 
("L20"),
("C16"),
("C15");

INSERT INTO operacao(nome_operacao)
VALUES 
("Produção"),
("Rebarbar"),
("Polimento");

INSERT INTO turnos(nome_turno)
VALUE 
("Primeiro Turno"),
("Segundo Turno");

INSERT INTO operadores(nome_operador, turnos_id)
VALUE
("Enzo Zamineli", 1),
("Vitor Assalin", 2),
("Thales Zamineli", 1);

INSERT INTO nop(numero_ordem, codigo, quantidadeMaxima, lote)
VALUE 
('001234SA001',123456789,50,'SA001234-1'),
('002234SA001',234567890,46,'SA002234-1'),
('003234SA001',345678901,150,'SA031234-1'),
('004234SA001',456789012,7,'SA004234-1');


select * from historico;
-- drop table nop;
-- drop table historico;