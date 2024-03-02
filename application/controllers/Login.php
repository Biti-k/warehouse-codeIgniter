<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function index()
	{
	    $this->load->library('session');
        $this->load->view("Login/login", array(
			"msg" => ""
		));
	}

	public function login(){
	    $this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Usuario');

		$nom = $this->input->post('nom');
		$pass = $this->input->post('pass');

		$existe = $this->Usuario->get($nom, $pass);
		if($existe){
		    $_SESSION['connected'] = true;
			redirect(site_url("Inici"));
		}else{
			$this->load->view("Login/login", array(
				"msg" => "Name/password incorrect"
			));
		}
		
	}

}