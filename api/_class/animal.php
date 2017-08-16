<?php
class Animal{
	private $ani_int_codigo;

	/* @var $proprietario Proprietario */
	private $proprietario;
	/* @var $raca Raca */
	private $raca;

	private $ani_var_nome;
	private $ani_cha_vivo;
	private $ani_dec_peso;


	public function getAni_int_codigo() {
		return $this->ani_int_codigo;
	}

	public function setAni_int_codigo($ani_int_codigo) {
		$this->ani_int_codigo = $ani_int_codigo;
	}
	
	public function getProprietario() {
		return $this->proprietario;
	}

	public function setProprietario($proprietario) {
		$this->proprietario = $proprietario;
	}
	
	public function getRaca() {
		return $this->raca;
	}

	public function setRaca($raca) {
		$this->raca = $raca;
	}

	public function getAni_var_nome() {
		return $this->ani_var_nome;
	}

	public function setAni_var_nome($ani_var_nome) {
		$this->ani_var_nome = $ani_var_nome;
	}

	public function getAni_cha_vivo() {
		return $this->ani_cha_vivo;
	}

	public function setAni_cha_vivo($ani_cha_vivo) {
		$this->ani_cha_vivo = $ani_cha_vivo;
	}

	public function getAni_dec_peso() {
		return $this->ani_dec_peso;
	}

	public function setAni_dec_peso($ani_dec_peso) {
		$this->ani_dec_peso = $ani_dec_peso;
	}

}