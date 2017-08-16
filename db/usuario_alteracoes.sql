--
-- Adição do campo senha, para validação
--

ALTER TABLE `selecao_phpdev2017_2`.`usuario` 
ADD COLUMN `usu_var_senha` VARCHAR(255) NOT NULL AFTER `usu_cha_status`;

--
-- Definition for view vw_usuario
--
DROP VIEW IF EXISTS vw_usuario CASCADE;
CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW vw_usuario
AS
  SELECT 
    `usuario`.`usu_int_codigo` AS `usu_int_codigo`,
    `usuario`.`usu_var_nome` AS `usu_var_nome`,    
    `usuario`.`usu_var_email` AS `usu_var_email`,
    `usuario`.`usu_cha_status` AS `usu_cha_status`,
    `usuario`.`usu_cha_status` AS `usu_var_senha`,
    (case `usuario`.`usu_cha_status` when 'A' then 'Ativo' when 'I' then 'Inativo' end) AS `usu_var_status`,
    `usuario`.`usu_dti_inclusao` AS `usu_dti_inclusao`,
    date_format(`usuario`.`usu_dti_inclusao`,'%d/%m/%Y %H:%i:%s') AS `usu_dtf_inclusao` 
  FROM `usuario`;

