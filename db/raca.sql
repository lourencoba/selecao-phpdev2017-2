--
-- Definition for table raca
--
DROP TABLE IF EXISTS raca;
CREATE TABLE raca (
  rac_int_codigo INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Código',
  rac_var_nome VARCHAR(100) NOT NULL COMMENT 'Nome',
  rac_dti_inclusao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Inclusão',
  PRIMARY KEY (rac_int_codigo)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
AVG_ROW_LENGTH = 2000
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Raça';

--
-- Definition for view vw_raca
--
DROP VIEW IF EXISTS vw_vacina CASCADE;
CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW vw_raca
AS
  SELECT 
    `raca`.`rac_int_codigo` AS `rac_int_codigo`, 
    `raca`.`rac_var_nome` AS `rac_var_nome`, 
    `raca`.`rac_dti_inclusao` AS `rac_dti_inclusao`,
    date_format(`raca`.`rac_dti_inclusao`,'%d/%m/%Y %H:%i:%s') AS `rac_dtf_inclusao` 
  FROM `raca`;