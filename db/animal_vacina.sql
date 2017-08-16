--
-- Definition for view vw_animal_vacina
--
DROP VIEW IF EXISTS vw_animal_vacina CASCADE;
CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW vw_animal_vacina
AS
  SELECT 
	  `animal_vacina`.`anv_int_codigo` AS `anv_int_codigo`,
    `animal_vacina`.`ani_int_codigo` AS `ani_int_codigo`,
    `animal_vacina`.`usu_int_codigo` AS `usu_int_codigo`,
    `usuario`.`usu_var_nome` AS `usu_var_nome`,
    `animal`.`ani_var_nome` AS `ani_var_nome`,
    `animal_vacina`.`vac_int_codigo` AS `vac_int_codigo`,
    `vacina`.`vac_var_nome` AS `vac_var_nome`,
    `proprietario`.`pro_var_nome` AS `pro_var_nome`,    
    `animal_vacina`.`anv_dat_programacao` AS `anv_dat_programacao`,
    DATE_FORMAT(`animal_vacina`.`anv_dat_programacao`, '%d/%m/%Y') AS `anv_dtf_programacao`,
    `animal_vacina`.`anv_dti_aplicacao` AS `anv_dti_aplicacao`,
    CASE WHEN `animal_vacina`.`anv_dti_aplicacao` 
      IS NULL THEN CONCAT('<button type="button" class="btn btn-default btn_aplicar_vacina" anv_int_codigo="', `animal_vacina`.`anv_int_codigo`, '">Aplicar vacina</button>')
      ELSE DATE_FORMAT(`animal_vacina`.`anv_dti_aplicacao`, '%d/%m/%Y %H:%i:%s') 
    END AS `anv_dtf_aplicacao`,
    `animal_vacina`.`anv_dti_inclusao` AS `anv_dti_inclusao`,
	DATE_FORMAT(`animal_vacina`.`anv_dti_inclusao`, '%d/%m/%Y %H:%i:%s') AS `anv_dtf_inclusao` 
  FROM `animal_vacina`
  INNER JOIN `animal` USING(`ani_int_codigo`)
  INNER JOIN `vacina` USING(`vac_int_codigo`)
  INNER JOIN `proprietario` USING(`pro_int_codigo`)
  INNER JOIN `usuario` USING(`usu_int_codigo`);

DELIMITER $$

  --
-- Definition for procedure sp_animalvacina_ins
--
DROP PROCEDURE IF EXISTS sp_animalvacina_ins$$
CREATE PROCEDURE sp_animalvacina_ins(IN p_ani_int_codigo INT(11), IN p_vac_int_codigo INT(11), IN p_anv_dat_programacao DATE, IN p_usu_int_codigo INT(11), INOUT p_status BOOLEAN, INOUT p_msg TEXT, INOUT p_insert_id INT(11))
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
  IF p_ani_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Animal não informado.<br />');
  END IF;

  IF p_vac_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Vacina não informada.<br />');
  END IF;
  
  IF p_anv_dat_programacao IS NULL THEN
    SET p_msg = concat(p_msg, 'Data de programação não informada.<br />');
  END IF;
  
  IF p_usu_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Usuário não informado.<br />');
  END IF;

  IF p_msg = '' THEN

    START TRANSACTION;

    INSERT INTO animal_vacina (ani_int_codigo, vac_int_codigo, anv_dat_programacao, usu_int_codigo)
    VALUES (p_ani_int_codigo, p_vac_int_codigo, p_anv_dat_programacao, p_usu_int_codigo);

    COMMIT;

    SET p_status = TRUE;
    SET p_msg = 'Um novo registro foi inserido com sucesso.';
    SET p_insert_id = LAST_INSERT_ID();

  END IF;
END
$$

--
-- Definition for procedure sp_animalvacina_upd
--
DROP PROCEDURE IF EXISTS sp_animalvacina_upd$$
CREATE PROCEDURE sp_animalvacina_upd(IN p_anv_int_codigo INT(11), IN p_ani_int_codigo INT(11), IN p_vac_int_codigo INT(11), IN p_anv_dat_programacao DATE, IN p_usu_int_codigo INT(11), INOUT p_status BOOLEAN, INOUT p_msg TEXT)
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
  FROM animal_vacina
  WHERE anv_int_codigo = p_anv_int_codigo;
  IF NOT v_existe THEN
    SET p_msg = concat(p_msg, 'Registro não encontrado.<br />');
  END IF;

  -- VALIDAÇÕES
  IF p_ani_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Animal não informado.<br />');
  END IF;

  IF p_vac_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Vacina não informada.<br />');
  END IF;
  
  IF p_anv_dat_programacao IS NULL THEN
    SET p_msg = concat(p_msg, 'Data de programação não informada.<br />');
  END IF;

  IF p_usu_int_codigo IS NULL THEN
    SET p_msg = concat(p_msg, 'Usuário não informado.<br />');
  END IF;

  IF p_msg = '' THEN

    START TRANSACTION;

    UPDATE animal_vacina
    SET 
      ani_int_codigo = p_ani_int_codigo, 
      vac_int_codigo = p_vac_int_codigo, 
      anv_dat_programacao = p_anv_dat_programacao,
      usu_int_codigo = p_usu_int_codigo
    WHERE anv_int_codigo = p_anv_int_codigo;

    COMMIT;

    SET p_status = TRUE;
    SET p_msg = 'O registro foi alterado com sucesso';

  END IF;

END
$$

DELIMITER ;

