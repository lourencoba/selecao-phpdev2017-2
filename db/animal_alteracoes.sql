-- 
-- Criação do campo codigo do proprietário
--

ALTER TABLE `selecao_phpdev2017_2`.`animal` 
ADD COLUMN `pro_int_codigo` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `ani_int_codigo`;


-- 
-- Alteração do campo raça varchar, para campo inteiro
--

ALTER TABLE `selecao_phpdev2017_2`.`animal` 
CHANGE COLUMN `ani_var_raca` `rac_int_codigo` INT(11) UNSIGNED NOT NULL COMMENT 'Raça' AFTER `pro_int_codigo`;

-- 
-- Criação da chave estrangeira para a tabela raça
--

ALTER TABLE `selecao_phpdev2017_2`.`animal` 
ADD INDEX `FK_animal_raca_rac_int_codigo_idx` (`rac_int_codigo` ASC);
ALTER TABLE `selecao_phpdev2017_2`.`animal` 
ADD CONSTRAINT `FK_animal_raca_rac_int_codigo`
  FOREIGN KEY (`rac_int_codigo`)
  REFERENCES `selecao_phpdev2017_2`.`raca` (`rac_int_codigo`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

-- 
-- Criação da chave estrangeira proprietário
--

ALTER TABLE `selecao_phpdev2017_2`.`animal` 
ADD INDEX `FK_animal_proprietario_pro_int_codigo_idx` (`pro_int_codigo` ASC);
ALTER TABLE `selecao_phpdev2017_2`.`animal` 
ADD CONSTRAINT `FK_animal_proprietario_pro_int_codigo`
  FOREIGN KEY (`pro_int_codigo`)
  REFERENCES `selecao_phpdev2017_2`.`proprietario` (`pro_int_codigo`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


DELIMITER $$

--
-- Definition for procedure sp_animal_ins
--
DROP PROCEDURE IF EXISTS sp_animal_ins$$
CREATE PROCEDURE sp_animal_ins(IN p_pro_int_codigo INT(11), IN p_rac_int_codigo INT(11), IN p_ani_var_nome VARCHAR(50), IN p_ani_dec_peso DECIMAL(8,3), IN p_ani_cha_vivo CHAR(1), INOUT p_status BOOLEAN, INOUT p_msg TEXT, INOUT p_insert_id INT(11))
  SQL SECURITY INVOKER
  COMMENT 'Procedure de Insert'
BEGIN

  DECLARE v_existe boolean;

  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_status = FALSE;
    SET p_msg = 'Erro ao executar o procedimento.';
  END;

  SET p_msg = '';
  SET p_status = FALSE;

  -- VALIDAÇÕES
  IF p_pro_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Proprietário não informado.<br />');
  END IF;
  IF p_rac_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Raça não informada.<br />');
  END IF;
  IF p_ani_var_nome IS NULL THEN
    SET p_msg = concat(p_msg, 'Nome não informado.<br />');
  END IF;  
  IF p_ani_cha_vivo IS NULL THEN
    SET p_msg = concat(p_msg, 'Status não informado.<br />');
  ELSE
    IF p_ani_cha_vivo NOT IN ('S','N') THEN
      SET p_msg = concat(p_msg, 'Status inválido.<br />');
    END IF;
  END IF;

  IF p_msg = '' THEN

    START TRANSACTION;

    INSERT INTO animal (pro_int_codigo, rac_int_codigo, ani_var_nome, ani_dec_peso, ani_cha_vivo)
    VALUES (p_pro_int_codigo, p_rac_int_codigo, p_ani_var_nome, p_ani_dec_peso, p_ani_cha_vivo);

    COMMIT;

    SET p_status = TRUE;
    SET p_msg = 'Um novo registro foi inserido com sucesso.';
    SET p_insert_id = LAST_INSERT_ID();

  END IF;

END
$$

--
-- Definition for procedure sp_animal_upd
--
DROP PROCEDURE IF EXISTS sp_animal_upd$$
CREATE PROCEDURE sp_animal_upd(IN p_ani_int_codigo INT(11), IN p_pro_int_codigo INT(11), IN p_rac_int_codigo INT(11), IN p_ani_var_nome VARCHAR(50), IN p_ani_dec_peso DECIMAL(8,3), IN p_ani_cha_vivo CHAR(1), INOUT p_status BOOLEAN, INOUT p_msg TEXT)
  SQL SECURITY INVOKER
  COMMENT 'Procedure de Update'
BEGIN

  DECLARE v_existe BOOLEAN;

  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_status = FALSE;
    SET p_msg = 'Erro ao executar o procedimento.';
  END;

  SET p_msg = '';
  SET p_status = FALSE;

  -- VALIDAÇÕES
  SELECT IF(count(1) = 0, FALSE, TRUE)
  INTO v_existe
  FROM animal
  WHERE ani_int_codigo = p_ani_int_codigo;
  IF NOT v_existe THEN
    SET p_msg = concat(p_msg, 'Registro não encontrado.<br />');
  END IF;

  -- VALIDAÇÕES
  IF p_ani_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Código não informado.<br />');
  END IF;  
  IF p_pro_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Proprietário não informado.<br />');
  END IF;
  IF p_rac_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Raça não informada.<br />');
  END IF;
  IF p_ani_var_nome IS NULL THEN
    SET p_msg = concat(p_msg, 'Nome não informado.<br />');
  END IF;
  IF p_ani_cha_vivo IS NULL THEN
    SET p_msg = concat(p_msg, 'Status não informado.<br />');
  ELSE
    IF p_ani_cha_vivo NOT IN ('S','N') THEN
      SET p_msg = concat(p_msg, 'Status inválido.<br />');
    END IF;
  END IF;

  IF p_msg = '' THEN

    START TRANSACTION;

    UPDATE animal
    SET 
        pro_int_codigo = p_pro_int_codigo, 
        rac_int_codigo = p_rac_int_codigo, 
        ani_var_nome = p_ani_var_nome, 
        ani_dec_peso = p_ani_dec_peso,          
        ani_cha_vivo = p_ani_cha_vivo
    WHERE ani_int_codigo = p_ani_int_codigo;

    COMMIT;

    SET p_status = TRUE;
    SET p_msg = 'O registro foi alterado com sucesso';

  END IF;

END
$$

DELIMITER ;

--
-- Definition for view vw_animal
--
DROP VIEW IF EXISTS vw_animal CASCADE;
CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW vw_animal
AS
  SELECT 
    `animal`.`ani_int_codigo` AS `ani_int_codigo`,
    `animal`.`pro_int_codigo` AS `pro_int_codigo`,
    `animal`.`rac_int_codigo` AS `rac_int_codigo`,
    `proprietario`.`pro_var_nome` AS `pro_var_nome`,
    `raca`.`rac_var_nome` AS `rac_var_nome`,
    `animal`.`ani_var_nome` AS `ani_var_nome`,
    `animal`.`ani_dec_peso` AS `ani_dec_peso`,
    `animal`.`ani_cha_vivo` AS `ani_cha_vivo`,
    (case `animal`.`ani_cha_vivo` when 'S' then 'Sim' when 'N' then 'Não' end) AS `ani_var_vivo`,
    `animal`.`ani_dti_inclusao` AS `ani_dti_inclusao`,
    date_format(`animal`.`ani_dti_inclusao`,'%d/%m/%Y %H:%i:%s') AS `ani_dtf_inclusao` 
  FROM `animal`
  INNER JOIN `proprietario` USING(`pro_int_codigo`)
  INNER JOIN `raca` USING(`rac_int_codigo`);

