<?php

class Blog extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		
		$this->load->model('author_model', 'author');
	}
	
	function index(){
		$data['main'] = 'templates/add-author';
		$this->load->view('index', $data);
	}
	
	function add_author(){
		$data['main'] = 'templates/add-author';
		$this->load->view('index', $data);
	}
	
	function save_author(){
		$this->load->library('form_validation');
		
		if($this->form_validation->run('author') == FALSE){
			$this->session->set_flashdata('error_message', validation_errors());
			redirect('blog/add_author');
		}else{
			$this->author->save();
			$this->session->set_flashdata('message', 'Author data has been saved');
			redirect('blog/view_author');
		}
	}
	
	
	function view_author(){
		$data['authors'] = $this->author->all();
		$data['main'] = 'templates/view-author';
		
		$this->load->view('index', $data);
	}
	
	function delete_author($_id){
		$this->author->delete($_id);
		$this->session->set_flashdata('message', 'Author data has been deleted');
		redirect('blog/view_author');
	}
	
	function detail_author($_id){
		$this->session->set_userdata('current_url', ''.base_url().'blog/detail_author/'.$_id);
		$data['author'] = $this->author->find_by_id($_id);
		$data['main'] = 'templates/update-author';
		$this->load->view('index', $data);
	}
	
	function update_author(){
		$this->load->library('form_validation');
		
		if($this->form_validation->run('author') == FALSE){
			$this->session->set_flashdata('error_message', validation_errors());
			redirect($this->input->post('current_url'));
		}else{
			$this->author->update($this->input->post('_id'));
			$this->session->set_flashdata('message', 'Author data has been updated');
			redirect('blog/view_author');
		}	
	}
	
}
?>