--
-- Definition for view vw_vacina
--
DROP VIEW IF EXISTS vw_vacina CASCADE;
CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW vw_vacina
AS
  SELECT 
    `vacina`.`vac_int_codigo` AS `vac_int_codigo`, 
    `vacina`.`vac_var_nome` AS `vac_var_nome`, 
    `vacina`.`vac_dti_inclusao` AS `vac_dti_inclusao`,
    date_format(`vacina`.`vac_dti_inclusao`,'%d/%m/%Y %H:%i:%s') AS `vac_dtf_inclusao` 
  FROM `vacina`;