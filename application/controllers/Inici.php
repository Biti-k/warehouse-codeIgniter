<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inici extends CI_Controller {

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
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'categoria_helper'));
		$this->load->library('form_validation');
		$this->load->model('Producte');
		$this->load->model('Cat_producte');
		$this->load->model('Categoria');
		$this->load->model('Lots');
		$this->load->library('session');
	}

	public function index()
	{
	    if(!isset($_SESSION['connected'])){
	        redirect("Login");
	    }
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '4000000';
		$config['max_width'] = '3200';
		$config['max_height'] = '3200';
		$this->load->library('upload', $config);
		$productes = $this->Producte->getAll();
		$cat_prods = $this->Cat_producte->getAll();
		$categories = $this->Categoria->getAll();
		transformar($cat_prods, $this);
		$data = array("productes" => $productes, "cat_prods" => $cat_prods, "categories" => $categories
		);

		$this->form_validation->set_rules('name', 'Product name', 'required|is_unique[producte.nom]');
		if ($this->form_validation->run() == FALSE)
		{
			$data['validation_errors'] = validation_errors();
			$this->load->view('Lobby/lobby', $data);
		}else{
			if($this->upload->do_upload('img')){
				$fileInfo = $this->upload->data();
				$imgName = $fileInfo['file_name'];
				$selectedCategories = $this->input->post('categoriesS');
				$name = $this->input->post("name");
				$initialStock = $this->input->post("stock");	

				$producte = array(
					"nom" => $name,
					"imatge" => $imgName,
					"stock" => $initialStock
				);
				$pid = $this->Producte->insert($producte);
				if(!empty($selectedCategories)){
					foreach($selectedCategories as $selectedCategory){
						//logica cat_prods
						$data_catpd = array(
							"producte" => $pid,
							"categoria" => $selectedCategory
						);
						$this->Cat_producte->insert($data_catpd);
					}
				}
				redirect("Inici");
			}else{
				$data["uploadErrors"] = $this->upload->display_errors("<p class='text-danger p-1 mt-3 bg-light rounded'>", "</p>");
				$this->load->view('Lobby/lobby', $data);
			}
		}

		$delete = $this->input->get('delete');
		if(isset($delete)){
			$this->Cat_producte->delete($delete);
			$this->Producte->delete($delete);
			redirect("Inici");
		}
		
/* 		$mod = $this->input->get('mod'); */
/* 		if(isset($mod)){
			$_SESSION["mod"] = $mod;
			redirect("Inici/mod");
		} */
	}

	public function mod(){
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '4000000';
		$config['max_width'] = '3200';
		$config['max_height'] = '3200';
		$this->load->library('upload', $config);
		$mod = $_GET['mod'];
		$producte = $this->Producte->get($mod);
		$cat_prods = $this->Cat_producte->getAll();
		$categories = $this->Categoria->getAll();
		$modified = $this->input->post('modified');
		if($modified != null){
				$producte;
				$imgName;
				$fileInfo = $this->upload->data();
				if($this->upload->do_upload('img')){
					$imgName = $fileInfo['file_name'];
				}
				$selectedCategories = $this->input->post('categoriesS');
				$name = $this->input->post("name");
				$initialStock = $this->input->post("stock");	
				if(isset($imgName)){
					$producteU = array(
						"nom" => $name,
						"imatge" => $imgName,
						"stock" => $initialStock
					);
				}else{
					$producteU = array(
						"nom" => $name,
						"stock" => $initialStock
					);
				}
				var_dump($producte);
				$this->Producte->update($producte[0]->id, $producteU);
				var_dump($selectedCategories);
				$this->Cat_producte->delete($producte[0]->id);
				if(!empty($selectedCategories)){
					foreach($selectedCategories as $selectedCategory){
						//logica cat_prods
						$existingRecord = $this->Cat_producte->get_where($producte[0]->id, $selectedCategory);
						
						if (!$existingRecord) {
							// If the record doesn't exist, insert it
							$data_catpd = array(
								'producte' => $producte[0]->id,
								'categoria' => $selectedCategory
							);
				
							$this->Cat_producte->insert($data_catpd);
						}
					}
				}


				redirect("/Inici");
		}else{
			$data = array(
				"producte" => $producte,
				"categories" => $categories,
				"cat_prods" => $cat_prods
			);
			$this->load->view("Lobby/mod", $data);
		}
	}
	
	public function producte(){
	    if(!isset($_GET['id'])){
	        redirect("Inici");
	    }else{
	        $ops = $this->Lots->get($_GET['id']);
	        $productes = $this->Producte->get($_GET['id']);
    		$cat_prods = $this->Cat_producte->getAll();
    		$categories = $this->Categoria->getAll();
    		transformar($cat_prods, $this);
			$data = array("productes" => $productes, "cat_prods" => $cat_prods, "categories" => $categories, 
			"ops" => $ops
		    );
    	    $this->load->view("Lobby/producte", $data);
	    }
	}

	public function operations(){
	    if(!isset($_SESSION['connected'])){
	        redirect("Login");
	    }
		$productes = $this->Producte->getAll();
		$cat_prods = $this->Cat_producte->getAll();
		$categories = $this->Categoria->getAll();
		transformar($cat_prods, $this);
		$data = array("productes" => $productes, "cat_prods" => $cat_prods, "categories" => $categories
		);
		$this->form_validation->set_rules('qt', 'Quantity', 'required|greater_than[0]');
		$pid = $this->input->post("pid");
		if($pid){
			if ($this->form_validation->run() == FALSE)
			{
				$data['validation_errors'] = validation_errors();
				$this->load->view('Lobby/operations', $data);
			}else{
				$unitats = $this->input->post("qt");
				$lot = array(
					"producte" => $pid,
					"unitats" => $unitats,
					"data" => date('Y-m-d H:i:s')
				);
				if($this->input->post("add") || $this->input->post("take")){
					$unitats = (int) $unitats;
					$pstock = $this->Producte->get($pid);

					if($this->input->post("take")){
						$lot["unitats"] *= -1;
						$stock = $pstock[0]->stock - $unitats;
					}else{
						$stock = $pstock[0]->stock + $unitats;

					}
					$this->Producte->update($pid, array(
						"stock" => $stock
					));
					$this->Lots->insert($lot);
					redirect(site_url("Inici/Operations"));
				}

				
			}

		}


		$this->load->view("Lobby/operations", $data);
	}

	public function insert_xml(){
		$config['upload_path'] = './uploads/xmls';
		$config['allowed_types'] = 'xml';
		$config['max_size'] = '4000000';
		$this->load->library('upload', $config);
		if($this->upload->do_upload('xmlFile')){
			$fileInfo = $this->upload->data();
			$xmlName = $fileInfo['file_name'];
			$xmlPath = $fileInfo['full_path'];
			$xmlContent = file_get_contents($xmlPath);
			$xmlObject = simplexml_load_string($xmlContent);
			foreach($xmlObject->lot as $lot){
				$arr = array(
					"producte" => $lot->product,
					"unitats" => $lot->quantity,
					"data" => $lot->date
				);
				$this->Lots->insert($arr);
				$p = $this->Producte->get($lot->product);
				if($lot->quantity < 0){
					$this->Producte->update($lot->product, array("stock" => $p[0]->stock - $lot->quantity));
				}else{
					$this->Producte->update($lot->product, array("stock" => $p[0]->stock + $lot->quantity));
				}
			}

			redirect("Inici/operations");
		}else{
			$productes = $this->Producte->getAll();
			$cat_prods = $this->Cat_producte->getAll();
			$categories = $this->Categoria->getAll();
			transformar($cat_prods, $this);
			$data = array("productes" => $productes, "cat_prods" => $cat_prods, "categories" => $categories
			);
			$data["uploadErrors"] = $this->upload->display_errors("<p class='text-danger p-1 mt-3 bg-light rounded'>", "</p>");
			$this->load->view('Lobby/operations', $data);
		}
	}

	public function see_all_operations(){
		$ops = $this->Lots->getAll();
		for($i = 0; $i < count($ops); $i++){
			$p = $this->Producte->get($ops[$i]->producte);
			$ops[$i]->producte = $p[0]->nom;
		}
		$data = array(
			"ops" => $ops,
		);
		$this->load->view("Lobby/alloperations", $data);
	}

	public function pdfOperations(){
		$ops = $this->Lots->getAll();
		for($i = 0; $i < count($ops); $i++){
			$p = $this->Producte->get($ops[$i]->producte);
			$ops[$i]->producte = $p[0]->nom;
		}
		$data = array(
			"ops" => $ops,
		);
		$this->load->view("Lobby/alloperations", $data);

		$html = $this->output->get_output();
		$html = preg_replace('/<\/div>/', '</div><hr>', $html);
		$html = preg_replace('/DOWNLOAD PDF/', '', $html);
        // Load pdf library
        $this->load->library('pdf');
        // Load HTML content
        $this->dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
	}
}
