CREATE DATABASE banco_tcc_apont;

USE banco_tcc_apont;

CREATE TABLE operadores(
	id_operador INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nome_operador VARCHAR(50) NOT NULL
);

CREATE TABLE maquina(
	id_maquina INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nome_maquina VARCHAR(50) NOT NULL
);

CREATE TABLE operacao(
	id_operacao INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nome_operacao VARCHAR(50) NOT NULL	
);

CREATE TABLE nop(
	numero_ordem VARCHAR(12) PRIMARY KEY, 
	codigo INT UNSIGNED NOT NULL, 
	quantidade INT UNSIGNED NOT NULL,
    lote VARCHAR(10) NOT NULL,
    operacao_id INT UNSIGNED,
    maquina_id INT UNSIGNED,
    operador_id INT UNSIGNED,
    
    FOREIGN KEY (maquina_id) REFERENCES maquina(id_maquina),
    FOREIGN KEY (operacao_id) REFERENCES operacao(id_operacao),
    FOREIGN KEY (operador_id) REFERENCES operadores(id_operador)
);


-- DADOS

-- OPERADORES
INSERT INTO operadores(nome_operador) VALUES
("Enzo Zamineli"),
("Vitor Assalin"),
("Rodrigo Coelho de Amo");

-- MAQUINA
INSERT INTO maquina(nome_maquina) VALUES
("L20"),
("C16"),
("C15");

-- OPERACAO
INSERT INTO operacao(nome_operacao) VALUES
("Usinagem/Torneamento"),
("Rebarbar"),
("Polimento");

-- ORDEM (PRINCIPAL)
INSERT INTO nop(numero_ordem, codigo, lote,  quantidade, operacao_id, maquina_id, operador_id) VALUES
("004234SA001", 111222333, "SA004234-1", 200, 1, 1, 3),
("002234SA001", 111222334, "SA002234-1", 300, 3, 2, 2),
("003234SA001", 111222333, "SA003234-1", 200, 2, 3, 1);



-- drop database banco_tcc_apont;

