<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('adminmodel');
		$this->load->model('usermodel');
		$this->load->library('pagination');

		if(isset($_POST['logout'])){
			$this->session->unset_userdata('logged_user');
			$this->session->sess_destroy();
			redirect(base_url()); die();
		}
		/*Page Access Prevention*/
		$page = $this->router->fetch_method();
		if ($page != 'register' && $page != 'login' && $page != 'index' && $page != 'forget_password') {
			if(!$this->session->userdata('logged_user')){ 
				redirect(base_url()); die(); 
			}
		}
		//if($this->session->userdata('logged_user')){ redirect('admin/dashboard'); die(); }
		

	}
	
	/*Home Page && Login Page*/
	public function index()
	{	
		if(isset($_POST['admin_submit'])){/*Registration Action*/
			//Register User If data valid
			$data['loginSucess'] = $this->adminmodel->login(); 
			if ($data['loginSucess']['status']) {
				redirect($data['loginSucess']['url']);
			}else{
				$data['reset'] = FALSE;
			}
		}else{
			$data['loginSucess'] = array('status'=>FALSE,'message' => '', 'referror'=>'');
			$data['reset'] = FALSE;
		}	
		$this->load->view('admin/login');
	}
	
	/*Forget Password*/
	public function forgot_password()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/forgot_password');
		$this->load->view('admin/footer');
	}
	/*Logout*/
	public function logout()
	{
		$this->session->unset_userdata('logged_user');
		$this->session->sess_destroy();
		redirect(base_url()); die();
	}
	

	/*====================
	Dashboard
	=====================*/
	public function dashboard(){
		/*$data['user'] = $this->usermodal->getUserInformation();
		$data['wdhistory'] = $this->usermodal->withdrowhistory($data['user']->id);
		$data['tphistory'] = $this->usermodal->topuphistory($data['user']->id);
		if (isset($_POST['messageSend'])) {
			$data['messagerep'] = $this->usermodal->messageSend($_POST['message'], $data['user']->id, "me");
		}
		$data['options'] = $this->usermodal->getOptions();
		$data['title'] = "Starsfair | Dashboard";
		$data['cart'] = $this->usermodal->getCartItem();
		$data['qty'] = $this->usermodal->getCart();*/
		$this->load->view('admin/header');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}
	/*====================
	All Category
	=====================*/
	
	public function all_listing_category()
	{
		$data['user'] = $this->adminmodel->getAdminInformation();
		$data['all_listing_category'] = $this->adminmodel->allListingCategory();
		
		$this->load->view('admin/header');
		$this->load->view('admin/all_listing_category',$data);
		$this->load->view('admin/footer');
	}
	
	
	/*====================
	Add new Category
	=====================*/
	
	public function add_new_listing_category()
	{		
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[listing_categories.category_name]');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/add_new_listing_category');
			$this->load->view('admin/footer');
		}
		else 
		{
			$data = array();
			$data['category_name'] = $this->input->post('category_name');

			if($_FILES && $_FILES['category_image']['name'])
			{
				$img_info = [
					'upload_path' => 'images/services',
					'quality'     => '60%',
					'height'      => 250,
					'width'       => 400,
					'image_name'  => 'category_image'
				];
				$data['category_image'] = uploadAndResize($img_info);
			}	    

			if($this->adminmodel->addListingCategory($data))
			{
				$this->session->set_flashdata('message', 'Successfully Added Listing Category!!');
				redirect('admin/all_listing_category');
			}
			else 
			{
				$this->session->set_flashdata('message', 'Adding Listing Category failed!!');
			}
		}
	}
	
	/*====================
	Edit Category
	=====================*/
	public function edit_listing_category($id)
	{
		$data['category'] = $this->adminmodel->getSingleValue($id,'category_id','listing_categories');
		$old_image        = $data['category']->category_image;

		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/edit_listing_category',$data);
			$this->load->view('admin/footer');
		} else 
		{
			$info['category_name'] = $this->input->post('category_name');
			
			if($_FILES && $_FILES['category_image']['name'])
			{
				$img_info = [
					'upload_path' => 'images/services',
					'quality'     => '60%',
					'height'      => 250,
					'width'       => 400,
					'image_name'  => 'category_image'
				];
				
				$image_link = $old_image;

				if($image_link != null){
					if(file_exists('./'.$image_link))
					{
						
						unlink($image_link);
					}                    
				}

				
				$info['category_image'] = uploadAndResize($img_info);
			} else 
			{
				$info['category_image'] = $old_image;
			}
			
			if($this->adminmodel->updateListingCategory($id,$info))
				{	$this->session->set_flashdata('message', 'Successfully Updated Listing Category!!');
			redirect('admin/all_listing_category','refresh');
		} else 
		{
			$this->session->set_flashdata('message', 'Sorry, Update Listing Category failed!!');
			redirect('admin/edit_listing_category', 'refresh');
		}
		

		
	}

}

	/*====================
	Delete Listing Category
	=====================*/
	public function delete_listing_category($id)
	{
		if($this->adminmodel->deleteCategory($id))
		{
			redirect('admin/all_listing_category','refresh');
		} else 
		{
			redirect('admin/all_listing_category','refresh');
		}
	}
	
	/*====================
	All Sub Category
	=====================*/
	public function all_listing_sub_category($id = NULL){
		$data['user'] = $this->adminmodel->getAdminInformation();
		if (!empty($id)) {
			$data['all_listing_sub_category'] = $this->adminmodel->ListingSubCategoryByCateId($id);
		}else{
			$data['all_listing_sub_category'] = $this->adminmodel->allListingSubCategory();
		}

		$this->load->view('admin/header');
		$this->load->view('admin/all_listing_sub_category',$data);
		$this->load->view('admin/footer');
	}
	/*====================
	Add new Sub Category
	=====================*/
	public function add_new_listing_sub_category()
	{		
		$this->form_validation->set_rules('sub_category_name', 'Sub Category Name', 'trim|required|is_unique[listing_sub_categories.sub_category_name]');

		if($this->form_validation->run() == FALSE)
		{	
			$data['all_listing_category'] = $this->adminmodel->allListingCategory();
			$this->load->view('admin/header');
			$this->load->view('admin/add_new_listing_sub_category',$data);
			$this->load->view('admin/footer');
		}
		else 
		{
			$data = array();
			$data['sub_category_name'] = $this->input->post('sub_category_name');
			$data['category_id'] = $this->input->post('category_id');
			

			if($this->adminmodel->addListingSubCategory($data))
			{
				$this->session->set_flashdata('message', 'Sub Category has been Added Successfully!!');
				redirect('admin/all_listing_sub_category');
			}
			else 
			{
				$this->session->set_flashdata('message', 'Sub Category has been Failed!!');
			}
		}
	}
	/*====================
	Add Edit Sub Category
	=====================*/
	public function edit_listing_sub_category($id)
	{
		$data['sub_category'] = $this->adminmodel->get_listing_sub_category_ById($id);
		$data['allListingCategory'] = $this->adminmodel->allListingCategory();

		$this->form_validation->set_rules('sub_category_name', 'Sub Category Name', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/edit_listing_sub_category',$data);
			$this->load->view('admin/footer');
		} else 
		{
			$info['category_id'] = $this->input->post('category_id');
			$info['sub_category_name'] = $this->input->post('sub_category_name');
			if($this->adminmodel->updateListingSubCategory($id,$info))
			{
				$this->session->set_flashdata('message', 'Sub Category has been Updated Successfully.');
				redirect('admin/all_listing_sub_category','refresh');
			} else 
			{
				redirect('admin/edit_listing_sub_category', 'refresh');
			}
			

			
		}

	}
	/*====================
	Delete Listing Sub Category
	=====================*/
	public function delete_listing_sub_category($id)
	{
		if($this->adminmodel->deleteListingSubCategory($id))
		{	
			$this->session->set_flashdata('message', 'Sub Category has been Permanently Deleted!!!');
			redirect('admin/all_listing_sub_category','refresh');
		} else 
		{
			redirect('admin/all_listing_sub_category','refresh');
		}
	}
	/*====================
	Get Listing Sub Category
	=====================*/
	public function get_listing_sub_category()
	{
		
		if(!empty($this->input->post('category_id'))){
			$category_id = $this->input->post('category_id');
			$data['sub_categories'] = $this->adminmodel->ListingSubCategoryByCateId($category_id);
			$this->load->view('admin/get_sub_categories',$data);
		}
	}
	/*====================
	All Listing
	=====================*/
	public function all_listings(){
		$config = [
			'base_url' => base_url('admin/all_listings'),
			'per_page' => 10,
			'total_rows'=> count($this->adminmodel->getAllListings(NULL, NULL))
		];

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="/" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li class="page-link">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-link">';
		$config['next_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-link">';
		$config['num_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-link">';
		$config['last_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-link">';
		$config['first_tag_close'] = '</li>';
		$config['next_link'] = 'Next >';
		$config['prev_link'] = '< Prev';

		$this->pagination->initialize($config);


		$data['AllListings']   = $this->adminmodel->getAllListings($config['per_page'],$this->uri->segment(3)); 
		$data['link'] 		   = $this->pagination->create_links();

		$this->load->view('admin/header');
		$this->load->view('admin/all_listings',$data);
		$this->load->view('admin/footer');
	}
	/*====================
	Add  Listing
	=====================*/
	public function add_new_listings(){
		
		$this->load->view('admin/header');
		$this->load->view('admin/add_new_listings');
		$this->load->view('admin/footer');
	}

	/*====================
	Add New Listing From Scratch
	=====================*/
	public function add_listing_scratch(){
		$data['categories'] 	= $this->usermodel->getAllValues('listing_categories');
		$data['users'] 		  	= $this->adminmodel->getAllUsers('user');
		if(!empty($this->input->post('user_id'))){
			if($this->form_validation->run('admin_listing_scratch') == FALSE)
			{	        
				$this->load->view('admin/header',$data);
				$this->load->view('admin/add_new_listings_start');
				$this->load->view('admin/footer');
			} else 
			{
				$listing_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('listing_name'));
				$info = array(
					'user_id'=> $this->input->post('user_id'),
					'listing_name'=> $this->input->post('listing_name'),
					'featured_listing'=> $this->input->post('featured_listing'),
					'spotlight_listing'=> $this->input->post('spotlight_listing'),
					'category_id'=> $this->input->post('category_id'),
					'sub_category_id'=> $this->input->post('sub_category_id'),
					'listing_mobile'=> $this->input->post('listing_mobile'),
					'listing_whatsapp'=> $this->input->post('listing_whatsapp'),
					'display_phone'=> $this->input->post('display_phone'),
					'listing_email'=> $this->input->post('listing_email'),
					'listing_website'=> $this->input->post('listing_website'),
					'listing_address'=> $this->input->post('listing_address'),
					'county_name'=> $this->input->post('county_name'),
					'postal_code'=> $this->input->post('postal_code'),
					'listing_lat'=> $this->input->post('listing_lat'),
					'listing_lng'=> $this->input->post('listing_lng'),
					'display_address'=> $this->input->post('display_address'),
					'listing_description'=> $this->input->post('listing_description'),
					'service_locations'=> $this->input->post('service_locations'),
					'service_offered'=> $this->input->post('service_offered'),
					'listing_video'=> $this->input->post('listing_video'),
					'listing_seo_title'=> $this->input->post('listing_seo_title'),
					'listing_seo_keywords'=> $this->input->post('listing_seo_keywords'),
					'listing_seo_description'=> $this->input->post('listing_seo_description'),
					'listing_slug'=> $listing_slug
				);
				if($_FILES && $_FILES['listing_profile_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/listings',
						'quality'     => '60%',
						'image_name'  => 'listing_profile_image'
					];
					$info['listing_image'] = uploadWithoutResize($img_info);
				}
				if($this->adminmodel->addListing($info)){
					$this->session->set_flashdata('message', 'Lisitng Added Successfully.');
					redirect('admin/all_listings','refresh');
				}else{
					redirect('admin/add_listing_scratch', 'refresh');
				}
			}
		}
		$this->load->view('admin/header',$data);
		$this->load->view('admin/add_new_listings_start');
		$this->load->view('admin/footer');
	}
	/*Edit Listing*/

	public function edit_listing($slug)
	{
		$data['categories']  = $this->usermodel->getAllValues('listing_categories');
		$data['users'] 		 = $this->adminmodel->getAllUsers('user');
		$data['slug']= $slug;

		$data['listing'] 	 = $this->usermodel->getSingleValue($slug,'listing_slug','listings');
		if($data['listing']->category_id != ''){
			$data['sub_category_listing'] = $this->adminmodel->ListingSubCategoryByCateId($data['listing']->category_id);
		}
		
		if($this->form_validation->run('admin_listing_scratch') == FALSE)
		{	        
			$this->load->view('admin/header',$data);
			$this->load->view('admin/edit_listings');
			$this->load->view('admin/footer');
		} else 
		{
			$listing_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('listing_name'));
			$info = array(
				'user_id'=> $this->input->post('user_id'),
				'listing_name'=> $this->input->post('listing_name'),
				'featured_listing'=> $this->input->post('featured_listing'),
				'spotlight_listing'=> $this->input->post('spotlight_listing'),
				'category_id'=> $this->input->post('category_id'),
				'sub_category_id'=> $this->input->post('sub_category_id'),
				'listing_mobile'=> $this->input->post('listing_mobile'),
				'listing_whatsapp'=> $this->input->post('listing_whatsapp'),
				'display_phone'=> $this->input->post('display_phone'),
				'listing_email'=> $this->input->post('listing_email'),
				'listing_website'=> $this->input->post('listing_website'),
				'listing_address'=> $this->input->post('listing_address'),
				'county_name'=> $this->input->post('county_name'),
				'postal_code'=> $this->input->post('postal_code'),
				'listing_lat'=> $this->input->post('listing_lat'),
				'listing_lng'=> $this->input->post('listing_lng'),
				'display_address'=> $this->input->post('display_address'),
				'listing_description'=> $this->input->post('listing_description'),
				'service_locations'=> $this->input->post('service_locations'),
				'service_offered'=> $this->input->post('service_offered'),
				'listing_video'=> $this->input->post('listing_video'),
				'listing_seo_title'=> $this->input->post('listing_seo_title'),
				'listing_seo_keywords'=> $this->input->post('listing_seo_keywords'),
				'listing_seo_description'=> $this->input->post('listing_seo_description'),
				'listing_slug'=> $listing_slug
			);
			if($_FILES && $_FILES['listing_profile_image']['name'])
			{
				$img_info = [
					'upload_path' => 'images/listings',
					'quality'     => '60%',
					'image_name'  => 'listing_profile_image'
				];
				$info['listing_image'] = uploadWithoutResize($img_info);
			}

			if($this->adminmodel->update($slug,$info,'listing_slug','listings'))
			{
				$this->session->set_flashdata('message', 'Lisitng Updated Successfully.');
				redirect('admin/all-listings');
			}
			else 
			{
				redirect('admin/edit-listing');
			}	
		}
	}

	/*listing Preview */
	public function listing_preview($listing_slug)
	{
		$data['logged_id'] = '';
		$data['listing'] = $this->usermodel->getSingleValue($listing_slug,'listing_slug','listings');
		$data['RelatedListing'] = $this->usermodel->getRelatedListing('listings',$listing_slug,$data['listing']->category_id);
		//var_dump($data['RelatedListing']);

		$this->load->view('header');
		$this->load->view('listing_details',$data);
		$this->load->view('footer');		
	}

	/*====================
	Edit Listing
	=====================*/
	public function edit_listings(){
		
		$this->load->view('admin/header');
		$this->load->view('admin/edit_listings');
		$this->load->view('admin/footer');
	}


    /*=================== 
    	Delete Listing 
	===================*/
	public function delete_listing($listing_slug)
	{
		$listings = $this->adminmodel->getSingleValue($listing_slug,'listing_slug','listings');

		$listings->is_deleted 	= 1;
		$listings->deleted_date= date('Y-m-d H:i:s');

		if($this->adminmodel->update($listing_slug,$listings,'listing_slug','listings'))
		{
			$this->session->set_flashdata('message', 'Successfully Listing Deleted!!');
			redirect('admin/all-listings','refresh');
		}
		else 
		{
			$this->session->set_flashdata('message', 'Deleting Listing Failed!!');
			redirect('admin/all-listings','refresh');
		}	
	}
	/*====================
	Add Duplicate Listing
	=====================*/
	public function create_duplicate_listing(){
		
		$data['users'] 		  	= $this->adminmodel->getAllUsers('user');
		$data['listings']		= $this->adminmodel->getAllListingNames();
		// echo "<pre>";var_dump($data['listings']);die();
		
		if($this->form_validation->run('admin_duplicate_listing') == FALSE)
		{	        
			$this->load->view('admin/header',$data);
			$this->load->view('admin/create_duplicate_listing');
			$this->load->view('admin/footer');
		} else {
			$old_listing_id = $this->input->post('listing_id');
			$new_listing_name = $this->input->post('listing_name');

			$getOldData = $this->adminmodel->getListingSingleValue($old_listing_id,'listing_id','listings');
			unset($getOldData[0]['listing_id']);

			$getOldData[0]['listing_name'] = $new_listing_name;

			if($this->adminmodel->addDuplicateListing('listings',$getOldData[0]))
			{
				$this->session->set_flashdata('message', 'Successfully Duplicated Listing!!');
				redirect('admin/all-listings');
			}
			else 
			{
				$this->session->set_flashdata('message', 'Duplicating Listing Failed!!');
				redirect('admin/create-duplicate-listing');
			}
		}

	}
	/*====================
	Claim Listing
	=====================*/
	public function claim_listing(){
		
		$this->load->view('admin/header');
		$this->load->view('admin/claim_listing');
		$this->load->view('admin/footer');
	}
	/*====================
	Trash Listing
	=====================*/
	public function trash_listing(){
		
		$config = [
			'base_url' => base_url('admin/trash_listings'),
			'per_page' => 10,
			'total_rows'=> count($this->adminmodel->getAllDeletedListings(NULL, NULL))
		];

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="/" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li class="page-link">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-link">';
		$config['next_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-link">';
		$config['num_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-link">';
		$config['last_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-link">';
		$config['first_tag_close'] = '</li>';
		$config['next_link'] = 'Next >';
		$config['prev_link'] = '< Prev';

		$this->pagination->initialize($config);


		$data['AllListings']   = $this->adminmodel->getAllDeletedListings($config['per_page'],$this->uri->segment(3)); 
		$data['link'] 		   = $this->pagination->create_links();


		$this->load->view('admin/header',$data);
		$this->load->view('admin/trash_listing');
		$this->load->view('admin/footer');
	}


    /*=================== 
    	Restore Listing 
	===================*/
	public function restore_listing($listing_slug)
	{
		$listings = $this->adminmodel->getSingleValue($listing_slug,'listing_slug','listings');

		$listings->is_deleted 	= 0;
		$listings->deleted_date= date('Y-m-d H:i:s');

		if($this->adminmodel->update($listing_slug,$listings,'listing_slug','listings'))
		{
			$this->session->set_flashdata('message', 'Successfully Listing Restored!!');
			redirect('admin/trash-listing','refresh');
		}
		else 
		{
			$this->session->set_flashdata('message', 'Listing Restore Failed!!');
			redirect('admin/trash-listing','refresh');
		}	
	}	    

	/*===============================
		Listing Delete Permanently
	=================================*/

	public function listing_delete($slug)
	    {
	    	if($this->adminmodel->permanentDeleteListing($slug))
	    	{
	    		$this->session->set_flashdata('message', 'Successfully Removed Listing!!');
	    		redirect('admin/trash-listing');
	    	} 
			else 
			{
				$this->session->set_flashdata('message', 'Listing Remove Failed!!');
				redirect('admin/trash-listing','refresh');
			}
	    }	

	/*====================
		Listing Enquiry
	=====================*/
	public function all_enquiry(){
		
		$this->load->view('admin/header');
		$this->load->view('admin/all_enquiry');
		$this->load->view('admin/footer');
	}
	/*====================
	Saved Listing Enquiry
	=====================*/
	// public function saved_enquiry(){
	
	// 	$this->load->view('admin/header');
	// 	$this->load->view('admin/saved_enquiry');
	// 	$this->load->view('admin/footer');
	// }
	/*====================
	All Product Category
	=====================*/
	public function all_product_category(){
		$data['user'] = $this->adminmodel->getAdminInformation();
		$data['all_product_category'] = $this->adminmodel->allProductCategory();
		$this->load->view('admin/header');
		$this->load->view('admin/all_product_category',$data);
		$this->load->view('admin/footer');
	}
	/*====================
	Add New Product Category
	=====================*/
	public function add_new_product_category()
	{		
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[product_categories.category_name]');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/add_new_product_category');
			$this->load->view('admin/footer');
		}
		else 
		{
			$data = array();
			$data['category_name'] = $this->input->post('category_name');

			if($_FILES && $_FILES['category_image']['name'])
			{
				$img_info = [
					'upload_path' => 'images/services',
					'quality'     => '60%',
					'height'      => 250,
					'width'       => 400,
					'image_name'  => 'category_image'
				];
				$data['category_image'] = uploadAndResize($img_info);
			}	    

			if($this->adminmodel->addProductCategory($data))
			{
				$this->session->set_flashdata('message', 'Successfully Added Product Category!!');
				redirect('admin/all_product_category');
			}
			else 
			{
				$this->session->set_flashdata('message', 'Adding Product Category failed!!');
			}
		}
	}
	
	/*====================
	Edit Product Category
	=====================*/
	public function edit_product_category($id)
	{
		$data['category'] = $this->adminmodel->get_product_category_ById($id);
		$old_image        = $data['category']->category_image;

		// $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[product_categories.category_name]');

		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/edit_product_category',$data);
			$this->load->view('admin/footer');
		} else 
		{
			$info['category_name'] = $this->input->post('category_name');
			
			if($_FILES && $_FILES['category_image']['name'])
			{
				$img_info = [
					'upload_path' => 'images/services',
					'quality'     => '60%',
					'height'      => 250,
					'width'       => 400,
					'image_name'  => 'category_image'
				];
				
				$image_link = './'.$old_image;
				if(file_exists($image_link))
				{
					unlink($image_link);
				}
				
				$info['category_image'] = uploadAndResize($img_info);
			} else 
			{
				$info['category_image'] = $old_image;
			}
			
			if($this->adminmodel->updateProductCategory($id,$info))
				{	$this->session->set_flashdata('message', 'Successfully Updated Product Category!!');
			redirect('admin/all_product_category','refresh');
		} else 
		{
			$this->session->set_flashdata('message', 'Sorry, Update Product Category failed!!');
			redirect('admin/edit_product_category', 'refresh');
		}
		

		
	}

}
	/*====================
	Delete Product Category
	=====================*/
	public function delete_product_category($id)
	{
		if($this->adminmodel->deleteProductCategory($id))
		{	
			$this->session->set_flashdata('message', 'Prodcut Category has been Permanently Deleted!!!');
			redirect('admin/all_product_category','refresh');
		} else 
		{
			redirect('admin/all_product_category','refresh');
		}
	}
	/*====================
	Product All Sub Category
	=====================*/
	public function all_product_sub_category($id = NULL){

		$data['user'] = $this->adminmodel->getAdminInformation();
		if (!empty($id)) {
			$data['all_product_sub_category'] = $this->adminmodel->ProductSubCategoryByCateId($id);
		}else{
			$data['all_product_sub_category'] = $this->adminmodel->allProductSubCategory();
		}

		$this->load->view('admin/header');
		$this->load->view('admin/all_product_sub_category',$data);
		$this->load->view('admin/footer');

	}
	/*====================
	Add new Product Sub Category
	=====================*/
	public function add_new_product_sub_category()
	{		
		$this->form_validation->set_rules('sub_category_name', 'Sub Category Name', 'trim|required|is_unique[product_sub_categories.sub_category_name]');

		if($this->form_validation->run() == FALSE)
		{	
			$data['all_product_category'] = $this->adminmodel->allProductCategory();
			$this->load->view('admin/header');
			$this->load->view('admin/add_new_product_sub_category',$data);
			$this->load->view('admin/footer');
		}
		else 
		{
			$data = array();
			$data['sub_category_name'] = $this->input->post('sub_category_name');
			$data['category_id'] = $this->input->post('category_id');
			

			if($this->adminmodel->addProductSubCategory($data))
			{
				$this->session->set_flashdata('message', 'Sub Category has been Added Successfully!!');
				redirect('admin/all_product_sub_category');
			}
			else 
			{
				$this->session->set_flashdata('message', 'Sub Category has been Failed!!');
			}
		}
	}
	/*====================
	Add Edit Product Sub Category
	=====================*/
	public function edit_product_sub_category($id)
	{
		$data['sub_category'] = $this->adminmodel->get_product_sub_category_ById($id);
	    // echo "<pre>";var_dump($data['sub_category']);die();
		$data['all_product_category'] = $this->adminmodel->allProductCategory();

		$this->form_validation->set_rules('sub_category_name', 'Sub Category Name', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/edit_product_sub_category',$data);
			$this->load->view('admin/footer');
		} else 
		{
			// echo "<pre>";var_dump($this->input->post());die();
			$info['category_id'] = $this->input->post('category_id');
			$info['sub_category_name'] = $this->input->post('sub_category_name');
			if($this->adminmodel->updateProductSubCategory($id,$info))
			{
				$this->session->set_flashdata('message', 'Sub Category has been Updated Successfully.');
				redirect('admin/all_product_sub_category','refresh');
			} else 
			{
				redirect('admin/edit_product_sub_category', 'refresh');
			}
			
		}

	}
	/*====================
	Delete Product Sub Category
	=====================*/
	public function delete_product_sub_category($id)
	{
		if($this->adminmodel->deleteProductSubCategory($id))
		{	
			$this->session->set_flashdata('message', 'Sub Category has been Permanently Deleted!!!');
			redirect('admin/all_product_sub_category','refresh');
		} else 
		{
			redirect('admin/all_product_sub_category','refresh');
		}
	}

	/*=============================
		Get Product Sub Category
	=============================*/
	public function get_product_sub_category()
	{
		
		if(!empty($this->input->post('category_id'))){
			$category_id = $this->input->post('category_id');
			$data['sub_categories'] = $this->adminmodel->ProductSubCategoryByCateId($category_id);
			$this->load->view('admin/get_sub_categories',$data);
		}
	}

	
	
	    /*===============
	      PRODUCTS
	      ================*/
	      
	    /*User All Products*/
	    public function products()
	    {
	      	$data['allProducts'] = $this->adminmodel->getAllProducts(); 

	      	$this->load->view('admin/header');
	      	$this->load->view('admin/left_sidebar');
	      	$this->load->view('admin/all_products',$data);
			//	$this->load->view('admin/right _sidebar');
	      	$this->load->view('admin/footer');
      	}	

	      /*Product Details*/
	    public function product_details($product_slug)
	    {
	      	$data['product'] = $this->adminmodel->getSingleProduct($product_slug);

	      	$this->load->view('header');
	      	$this->load->view('admin/product_details',$data);
	      	$this->load->view('footer');
	    }	

	    /*User Add Product*/
	    public function add_product()
	    {
	      	$data['productCategories'] = $this->adminmodel->getAllValues('product_categories');
	      	$data['users']             = $this->adminmodel->getAllUsers('user');

	      	if ($this->form_validation->run('admin_products') == FALSE) {
	      		$this->load->view('admin/header');
	      		$this->load->view('admin/add_new_product',$data);
	      		$this->load->view('admin/footer');
	      	} else {
	      		$product_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('product_name'));
	      		$info = array(
	      			'user_id'			    => htmlentities($this->input->post('user_id'), ENT_QUOTES),
	      			'product_name'			=> htmlentities($this->input->post('product_name'), ENT_QUOTES),
	      			'category_id'			=> htmlentities($this->input->post('category_id'), ENT_QUOTES),
                	'sub_category_id'		=> htmlentities($this->input->post('sub_category_id'), ENT_QUOTES),
	      			'product_price'			=> htmlentities($this->input->post('product_price'), ENT_QUOTES),
	      			'product_price_offer'	=> htmlentities($this->input->post('product_price_offer'), ENT_QUOTES),
	      			'product_payment_link'	=> htmlentities($this->input->post('product_payment_link'), ENT_QUOTES),
	      			'product_description'	=> htmlentities($this->input->post('product_description'), ENT_QUOTES),
	      			'product_tags'			=> htmlentities($this->input->post('product_tags'), ENT_QUOTES),
	      			'product_status'        => 1,
	      			'product_slug'			=> $product_slug
	      		);

	      		if(!empty($this->input->post('product_highlights')))
	      		{
	      			$info['product_highlights'] = json_encode($this->input->post('product_highlights'));
	      		}
	      		if(!empty($this->input->post('product_info_question')))
	      		{
	      			$info['product_info_question'] = json_encode($this->input->post('product_info_question'));
	      		}
	      		if(!empty($this->input->post('product_info_answer')))
	      		{
	      			$info['product_info_answer'] = json_encode($this->input->post('product_info_answer'));
	      		}

	      		if($_FILES && $_FILES['gallery_image']['name'])
	      		{
	      			$img_info = [
	      				'upload_path' => 'images/products',
	      				'quality'     => '60%',
	      				'height'      => 500,
	      				'width'       => 500,
	      				'image_name'  => 'gallery_image'
	      			];
	      			$info['gallery_image'] = uploadMultipleAndResize($img_info,5);
	      		}

	      		if($this->adminmodel->add('products',$info))
	      		{
	      			$this->session->set_flashdata('message', 'Successfully Product Added!!');
	      			redirect('admin/products');
	      		}
	      		else 
	      		{
	      			$this->session->set_flashdata('message', 'Adding Product Failed!!');
	      			redirect('admin/add-product','refresh');
	      		}	
	      	}
	    }
	      
	    /* User Edit Product */
	    public function edit_products($product_slug)
	    {
	      	$data['product'] 			= $this->adminmodel->getOnlyProduct($product_slug);
	      	$data['productCategories'] 	= $this->adminmodel->getAllValues('product_categories');
	      	$data['users']              = $this->adminmodel->getAllUsers('user');

			if($data['product']->category_id != ''){
				$data['sub_category_product'] = $this->adminmodel->ProductSubCategoryByCateId($data['product']->category_id);
			}
		
	      	$old_images = $data['product']->gallery_image;

	      	if ($this->form_validation->run('admin_products') == FALSE) {
	      		$this->load->view('admin/header');
	      		$this->load->view('admin/edit_product',$data);
	      		$this->load->view('admin/footer');
	      	} else {
	      		$product_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('product_name'));
	      		$info = array(
	      			'user_id'			    => htmlentities($this->input->post('user_id'), ENT_QUOTES),
	      			'product_name'			=> htmlentities($this->input->post('product_name'), ENT_QUOTES),
	      			'category_id'			=> htmlentities($this->input->post('category_id'), ENT_QUOTES),
                	'sub_category_id'		=> htmlentities($this->input->post('sub_category_id'), ENT_QUOTES),
	      			'product_price'			=> htmlentities($this->input->post('product_price'), ENT_QUOTES),
	      			'product_price_offer'	=> htmlentities($this->input->post('product_price_offer'), ENT_QUOTES),
	      			'product_payment_link'	=> htmlentities($this->input->post('product_payment_link'), ENT_QUOTES),
	      			'product_description'	=> htmlentities($this->input->post('product_description'), ENT_QUOTES),
	      			'product_tags'			=> htmlentities($this->input->post('product_tags'), ENT_QUOTES),
	      			'product_slug'			=> $product_slug
	      		);

	      		if(!empty($this->input->post('product_highlights')))
	      		{
	      			$info['product_highlights'] = json_encode($this->input->post('product_highlights'));
	      		}
	      		if(!empty($this->input->post('product_info_question')))
	      		{
	      			$info['product_info_question'] = json_encode($this->input->post('product_info_question'));
	      		}
	      		if(!empty($this->input->post('product_info_answer')))
	      		{
	      			$info['product_info_answer'] = json_encode($this->input->post('product_info_answer'));
	      		}

	      		if($_FILES && $_FILES['gallery_image']['name'])
	      		{
	      			$img_info = [
	      				'upload_path' => 'images/products',
	      				'quality'     => '60%',
	      				'height'      => 500,
	      				'width'       => 500,
	      				'image_name'  => 'gallery_image'
	      			];
	      			$info['gallery_image'] = uploadMultipleAndResize($img_info,5);
	      		}

	      		$is_new_image = 1;
	      		if($info['gallery_image'] == '[]')
	      		{
	      			$is_new_image = 0;
	      		}

	      		if ($is_new_image == 1) 
	      		{
	      			$imgs = json_decode($old_images);
	      			foreach ($imgs as $value) 
	      			{
	      				if(file_exists('./'.$value))
	      				{
	      					unlink($value);
	      				}   
	      			}
	      		} else 
	      		{
	      			$info['gallery_image'] = $old_images;
	      		}

	      		if($this->adminmodel->update($product_slug,$info,'product_slug','products'))
	      		{
	      			$this->session->set_flashdata('message', 'Successfully Product Updated!!');
	      			redirect('admin/edit-products/'.$id);
	      		}
	      		else 
	      		{
	      			$this->session->set_flashdata('message', 'Updating Product Failed!!');
	      			redirect('admin/edit-products/'.$id,'refresh');
	      		}	
	      	}
	    }	
	      
	      /* User Delete Product */
	      public function delete_product($product_slug)
	      {
	      	$product = $this->adminmodel->getOnlyProduct($product_slug);

	      	$product->is_deleted 	= 1;
	      	$product->deleted_date= date('Y-m-d H:i:s');

	      	if($this->adminmodel->update($product_slug,$product,'product_slug','products'))
	      	{
	      		$this->session->set_flashdata('message', 'Successfully Product Deleted!!');
	      		redirect('admin/products','refresh');
	      	}
	      	else 
	      	{
	      		$this->session->set_flashdata('message', 'Deleting Product Failed!!');
	      		redirect('admin/products','refresh');
	      	}	
	      	
	      }


	/*================
	    BLOG POST
	    ================*/        
	    
	    /*All Blogs*/
	    public function blog_list()
	    {
	   // $data['blogList'] = $this->usermodel->getAllValues('blogs');
	    	$data['blogList'] = $this->adminmodel->getBlogs();
	    	
	    	$this->load->view('admin/header');
		// $this->load->view('admin/user_left_sidebar');
	    	$this->load->view('admin/all_blogs',$data);
		// $this->load->view('admin/user_right_sidebar');
	    	$this->load->view('admin/footer');
	    }
	    
	    /* Preview blog */
	    public function blog_details($id)
	    {
	    	$data['blog'] = $this->usermodel->getSingleValue($id,'blog_id','blogs');
	    	
	    	$this->load->view('admin/inc/header');
	    	$this->load->view('admin/blog_details',$data);
	    	$this->load->view('admin/footer');        
	    }

	    /* Add new Blog */
	    public function add_blog()
	    {
	    	$data['users']             = $this->adminmodel->getAllUsers('user');
	    	if($this->form_validation->run('blogs') == false)
	    	{
	    		$this->load->view('admin/header',$data);
	            //$this->load->view('admin/user_add_new_blog');
	    		$this->load->view('admin/add_new_blogs');
	    		$this->load->view('admin/footer');	        
	    	} else {
	    		$isenquiry = htmlentities($this->input->post('isenquiry'), ENT_QUOTES) == 'on' ? 1 : 0;
	    		$blog_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('blog_name'));
	    		$info = array(
	    			// 'blog_id'			=> htmlentities($this->input->post('blog_id'), ENT_QUOTES),
	    			'user_id'			=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
	    			'blog_name'    		=> htmlentities($this->input->post('blog_name'), ENT_QUOTES),
	    			'blog_description'  => htmlentities($this->input->post('blog_description'), ENT_QUOTES),
	    			'blog_status'		=> 1,
	    			'isenquiry'         => $isenquiry,
	    			'blog_slug'			=> $blog_slug
	    		);
	    		
	    		if($_FILES && $_FILES['blog_image']['name'])
	    		{
	    			$img_info = [
	    				'upload_path' => 'images/blogs',
	    				'quality'     => '60%',
	    				'height'      => 500,
	    				'width'       => 1000,
	    				'image_name'  => 'blog_image'
	    			];
	    			$info['blog_image'] = uploadAndResize($img_info);
	    		}

	    		if($this->usermodel->add('blogs',$info))
	    		{
	    			$this->session->set_flashdata('message', 'Successfully Added Blog!!');
	    			redirect('admin/blog-list');
	    		}
	    		else 
	    		{
	    			$this->session->set_flashdata('message', 'Adding Blog Failed!!');
	    		}	            
	    	}
	    }
	    
	    /* Edit User Blog */
	    public function edit_blog($id)
	    {
	    	$data['users']   = $this->adminmodel->getAllUsers('user');

	    	$data['blog']    = $this->usermodel->getSingleValue($id,'blog_id','blogs');
	    	$old_image       = $data['blog']->blog_image;

	    	if($this->form_validation->run('blogs') == FALSE)
	    	{
	    		$this->load->view('admin/header',$data);
	    		$this->load->view('admin/user_edit_blog');
	    		$this->load->view('admin/footer');
	    	} else 
	    	{
	    		$isenquiry = htmlentities($this->input->post('isenquiry'), ENT_QUOTES) == 'on' ? 1 : 0;
	    		$info = array(
	    			'blog_id'			=> $id,
	    			'user_id'			=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
	    			'blog_name'    		=> htmlentities($this->input->post('blog_name'), ENT_QUOTES),
	    			'blog_description'  => htmlentities($this->input->post('blog_description'), ENT_QUOTES),
	    			'isenquiry'         => $isenquiry
	    		);
	    		
	    		if($_FILES && $_FILES['blog_image']['name'])
	    		{
	    			$img_info = [
	    				'upload_path' => 'images/blogs',
	    				'quality'     => '60%',
	    				'height'      => 500,
	    				'width'       => 1000,
	    				'image_name'  => 'blog_image'
	    			];
	    			
	    			$image_link = $old_image;

	    			if($image_link != null){
	    				if(file_exists('./'.$image_link))
	    				{
	    					unlink($image_link);
	    				}                    
	    			}
	    			
	    			$info['blog_image'] = uploadAndResize($img_info);
	    		} else 
	    		{
	    			$info['blog_image'] = $old_image;
	    		}

	    		if($this->adminmodel->update($id,$info,'blog_id','blogs'))
	    		{	
	    			$this->session->set_flashdata('message', 'Successfully Updated Blog!!');
	    			redirect('admin/blog-list','refresh');
	    		} else 
	    		{
	    			$this->session->set_flashdata('message', 'Sorry, Update Blog Failed!!');
	    			redirect('admin/edit-blog'.$id, 'refresh');
	    		}



	    	}	   
	    }

	    /*Delete Blog*/
	    public function delete_blog($id)
	    {
	    	if($this->usermodel->deleteBlog($id))
	    	{
	    		$this->session->set_flashdata('message', 'Successfully Removed Blog!!');
	    		redirect('admin/blog-list');
	    	} 
	    }	
	  /*================
	    News
	    ================*/        
	    
	    /*All News*/
	    public function news_list()
	    {
	   		// $data['blogList'] = $this->usermodel->getAllValues('blogs');
	    	$data['newsList'] = $this->adminmodel->getNews();
	    	
	    	$this->load->view('admin/header');
	    	$this->load->view('admin/all_news',$data);
	    	$this->load->view('admin/footer');
	    }
	    
	    /* Preview News */
	    public function news_details($id)
	    {
	    	$data['blog'] = $this->usermodel->getSingleValue($id,'news_id','news');
	    	
	    	$this->load->view('admin/inc/header');
	    	$this->load->view('admin/news_details',$data);
	    	$this->load->view('admin/footer');        
	    }

	    /* Add new News */
	    public function add_news()
	    {
	    	$data['users'] = $this->adminmodel->getAllUsers('user');
	    	if($this->form_validation->run('news') == false)
	    	{
	    		$data['all_news_category'] = $this->adminmodel->allNewsCategory();
	    		$this->load->view('admin/header',$data);
	    		$this->load->view('admin/add_new_news');
	    		$this->load->view('admin/footer');	        
	    	} else {
	    		$news_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('news_title'));
	    		$info = array(
	    			'user_id'			=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
	    			'news_title'    	=> htmlentities($this->input->post('news_title'), ENT_QUOTES),
	    			'news_description'  => htmlentities($this->input->post('news_description'), ENT_QUOTES),
	    			'news_category_id'  => htmlentities($this->input->post('news_category_id'), ENT_QUOTES),
	    			'news_seo_title'  	=> htmlentities($this->input->post('news_seo_title'), ENT_QUOTES),
	    			'news_seo_description'=> htmlentities($this->input->post('news_seo_description'), ENT_QUOTES),
	    			'news_seo_keywords' => htmlentities($this->input->post('news_seo_keywords'), ENT_QUOTES),
	    			'featured_news'  	=> htmlentities($this->input->post('featured_news'), ENT_QUOTES),
	    			'news_slug'			=> $news_slug
	    		);
	    		
	    		if($_FILES && $_FILES['news_image']['name'])
	    		{
	    			$img_info = [
	    				'upload_path' => 'images/news',
	    				'quality'     => '60%',
	    				'image_name'  => 'news_image'
	    			];
	    			$info['news_image'] = uploadAndResize($img_info);
	    		}

	    		if($this->adminmodel->add('news',$info))
	    		{
	    			$this->session->set_flashdata('message', 'Successfully Added News!!');
	    			redirect('admin/news-list');
	    		}
	    		else 
	    		{
	    			$this->session->set_flashdata('message', 'Adding News Failed!!');
	    		}	            
	    	}
	    }
	    
	    /* Edit User News */
	    public function edit_news($id)
	    {
	    	$data['users']   = $this->adminmodel->getAllUsers('user');
	    	$data['news']    = $this->usermodel->getSingleValue($id,'news_id','news');
	    	$old_image       = $data['news']->news_image;

	    	if($this->form_validation->run('news') == FALSE)
	    	{
	    		$data['all_news_category'] = $this->adminmodel->allNewsCategory();
	    		$this->load->view('admin/header');
	    		$this->load->view('admin/user_edit_news',$data);
	    		$this->load->view('admin/footer');
	    	} else 
	    	{
	    		$info = array(
	    			'user_id'			=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
	    			'news_title'    		=> htmlentities($this->input->post('news_title'), ENT_QUOTES),
	    			'news_description'  => htmlentities($this->input->post('news_description'), ENT_QUOTES),
	    			'news_category_id'  => htmlentities($this->input->post('news_category_id'), ENT_QUOTES),
	    			'news_seo_title'  => htmlentities($this->input->post('news_seo_title'), ENT_QUOTES),
	    			'news_seo_description'  => htmlentities($this->input->post('news_seo_description'), ENT_QUOTES),
	    			'news_seo_keywords'  => htmlentities($this->input->post('news_seo_keywords'), ENT_QUOTES),
	    			'featured_news'  => htmlentities($this->input->post('featured_news'), ENT_QUOTES)
	    		);
	    		
	    		if($_FILES && $_FILES['news_image']['name'])
	    		{
	    			$img_info = [
	    				'upload_path' => 'images/news',
	    				'quality'     => '60%',
	    				'image_name'  => 'news_image'
	    			];
	    			
	    			$image_link = $old_image;

	    			if($image_link != null){
	    				if(file_exists('./'.$image_link))
	    				{
	    					unlink($image_link);
	    				}                    
	    			}
	    			
	    			$info['news_image'] = uploadWithoutResize($img_info);
	    		} else 
	    		{
	    			$info['news_image'] = $old_image;
	    		}

	    		if($this->adminmodel->update($id,$info,'news_id','news'))
	    		{	
	    			$this->session->set_flashdata('message', 'Successfully Updated News!!');
	    			redirect('admin/news-list','refresh');
	    		} else 
	    		{
	    			$this->session->set_flashdata('message', 'Sorry, Update News Failed!!');
	    			redirect('admin/edit-news'.$id, 'refresh');
	    		}
	    	}	   
	    }

	    /*Delete News*/
	    public function delete_news($id)
	    {
	    	if($this->adminmodel->deleteNews($id))
	    	{
	    		$this->session->set_flashdata('message', 'Successfully Removed News!!');
	    		redirect('admin/news-list');
	    	} 
	    }
	    /*News Category*/
	    
			/*====================
			All News Category
			=====================*/
			
			public function all_news_category()
			{
				$data['user'] = $this->adminmodel->getAdminInformation();
				$data['all_news_category'] = $this->adminmodel->allNewsCategory();
				
				$this->load->view('admin/header');
				$this->load->view('admin/all_news_category',$data);
				$this->load->view('admin/footer');
			}
			/*====================
			Add new Category
			=====================*/
			
			public function add_news_category()
			{		
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[news_categories.category_name]');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/add_news_category');
					$this->load->view('admin/footer');
				}
				else 
				{
					$data = array();
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$data['category_name'] = $this->input->post('category_name');
					$data['category_seo_title'] = $this->input->post('category_seo_title');
					$data['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$data['category_seo_description'] = $this->input->post('category_seo_description');
					$data['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/news',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						$data['category_image'] = uploadAndResize($img_info);
					}	    
					if($this->adminmodel->addNewsCategory($data))
					{
						$this->session->set_flashdata('message', 'Successfully Added News!!');
						redirect('admin/all_news_category');
					}
					else 
					{
						$this->session->set_flashdata('message', 'Adding News Category failed!!');
					}
				}
			}
			
			/*====================
			Edit Category
			=====================*/
			public function edit_news_category($id)
			{
				$data['category'] = $this->adminmodel->getSingleValue($id,'category_id','news_categories');
				$old_image        = $data['category']->category_image;
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/edit_news_category',$data);
					$this->load->view('admin/footer');
				} else 
				{
					$info['category_name'] = $this->input->post('category_name');
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$info['category_name'] = $this->input->post('category_name');
					$info['category_seo_title'] = $this->input->post('category_seo_title');
					$info['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$info['category_seo_description'] = $this->input->post('category_seo_description');
					$info['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/news',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						
						$image_link = $old_image;
						if($image_link != null){
							if(file_exists('./'.$image_link))
							{
								unlink($image_link);
							}                    
						}

						
						$info['category_image'] = uploadAndResize($img_info);
					} else 
					{
						$info['category_image'] = $old_image;
					}
					
					if($this->adminmodel->updateNewsCategory($id,$info))
						{	$this->session->set_flashdata('message', 'Successfully Updated News Category!!');
					redirect('admin/all_news_category','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update Listing Category failed!!');
					redirect('admin/edit_news_category', 'refresh');
				}
			}

		}
			/*====================
			Delete News Category
			=====================*/
			public function delete_news_category($id)
			{
				if($this->adminmodel->deleteNewsCategory($id))
				{
					redirect('admin/all_news_category','refresh');
				} else 
				{
					redirect('admin/all_news_category','refresh');
				}
			}
			/*News*/

			/*
			Start Video 
			*/	    
			/*====================
			All Video Category
			=====================*/
			
			public function all_video_category()
			{
				$data['user'] = $this->adminmodel->getAdminInformation();
				$data['all_video_category'] = $this->adminmodel->allVideoCategory();
				
				$this->load->view('admin/header');
				$this->load->view('admin/all_video_category',$data);
				$this->load->view('admin/footer');
			}
			/*====================
			Add new Category
			=====================*/
			
			public function add_video_category()
			{		
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[video_categories.category_name]');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/add_video_category');
					$this->load->view('admin/footer');
				}
				else 
				{
					$data = array();
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$data['category_name'] = $this->input->post('category_name');
					$data['category_seo_title'] = $this->input->post('category_seo_title');
					$data['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$data['category_seo_description'] = $this->input->post('category_seo_description');
					$data['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/video',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						$data['category_image'] = uploadAndResize($img_info);
					}	    
					if($this->adminmodel->addVideoCategory($data))
					{
						$this->session->set_flashdata('message', 'Successfully Added Category!!');
						redirect('admin/all_video_category');
					}
					else 
					{
						$this->session->set_flashdata('message', 'Adding Video Category failed!!');
					}
				}
			}
			
			/*====================
			Edit Category
			=====================*/
			public function edit_video_category($id)
			{
				$data['category'] = $this->adminmodel->getSingleValue($id,'category_id','video_categories');
				$old_image        = $data['category']->category_image;
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/edit_video_category',$data);
					$this->load->view('admin/footer');
				} else 
				{
					$info['category_name'] = $this->input->post('category_name');
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$info['category_name'] = $this->input->post('category_name');
					$info['category_seo_title'] = $this->input->post('category_seo_title');
					$info['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$info['category_seo_description'] = $this->input->post('category_seo_description');
					$info['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/video',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						
						$image_link = $old_image;
						if($image_link != null){
							if(file_exists('./'.$image_link))
							{
								unlink($image_link);
							}                    
						}

						
						$info['category_image'] = uploadAndResize($img_info);
					} else 
					{
						$info['category_image'] = $old_image;
					}
					
					if($this->adminmodel->updateVideoCategory($id,$info))
						{	$this->session->set_flashdata('message', 'Successfully Updated Video Category!!');
					redirect('admin/all_video_category','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update Video Category failed!!');
					redirect('admin/edit_video_category', 'refresh');
				}
			}

		}
			/*====================
			Delete Video Category
			=====================*/
			public function delete_video_category($id)
			{
				if($this->adminmodel->deleteVideoCategory($id))
				{
					$this->session->set_flashdata('message', 'Category has been Permanently Deleted!!!');
					redirect('admin/all_video_category','refresh');
				} else 
				{
					redirect('admin/all_video_category','refresh');
				}
			}
			/*End Video Category*/
			/*All Video*/
			public function video_list()
			{
				$data['videoList'] = $this->adminmodel->getVideo();
				$this->load->view('admin/header');
				$this->load->view('admin/all_video',$data);
				$this->load->view('admin/footer');
			}

			/* Preview Video */
			public function video_details($id)
			{
				$data['blog'] = $this->usermodel->getSingleValue($id,'video_id','video');

				$this->load->view('admin/inc/header');
				$this->load->view('admin/video_details',$data);
				$this->load->view('admin/footer');        
			}

			/* Add new Video */
			public function add_video()
			{
				$data['users'] = $this->adminmodel->getAllUsers('user');
				if($this->form_validation->run('video') == false)
				{
					$data['all_video_category'] = $this->adminmodel->allVideoCategory();
					$this->load->view('admin/header',$data);
					$this->load->view('admin/add_new_video');
					$this->load->view('admin/footer');	        
				} else {
					$video_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('video_title'));
					$info = array(
						'user_id'			=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
						'video_title'    		=> htmlentities($this->input->post('video_title'), ENT_QUOTES),
						'video_code'    		=> htmlentities($this->input->post('video_code'), ENT_QUOTES),
						'featured_video'    		=> htmlentities($this->input->post('featured_video'), ENT_QUOTES),
						'video_description'  => htmlentities($this->input->post('video_description'), ENT_QUOTES),
						'video_category_id'  => htmlentities($this->input->post('video_category_id'), ENT_QUOTES),
						'video_seo_title'  => htmlentities($this->input->post('video_seo_title'), ENT_QUOTES),
						'video_seo_description'  => htmlentities($this->input->post('video_seo_description'), ENT_QUOTES),
						'video_seo_keywords'  => htmlentities($this->input->post('video_seo_keywords'), ENT_QUOTES),
						'video_slug'  => htmlentities($video_slug, ENT_QUOTES)
					);

					if($_FILES && $_FILES['video_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/video',
							'quality'     => '60%',
							'image_name'  => 'video_image'
						];
						$info['video_image'] = uploadAndResize($img_info);
					}

					if($this->adminmodel->add('video',$info))
					{
						$this->session->set_flashdata('message', 'Successfully Added Video!!');
						redirect('admin/video-list');
					}
					else 
					{
						$this->session->set_flashdata('message', 'Adding Video Failed!!');
					}	            
				}
			}

			/* Edit Video */
			public function edit_video($id)
			{
				$data['users']   = $this->adminmodel->getAllUsers('user');
				$data['video']    = $this->usermodel->getSingleValue($id,'video_id','video');
				$old_image       = $data['video']->video_image;

				if($this->form_validation->run('video') == FALSE)
				{
					$data['all_video_category'] = $this->adminmodel->allVideoCategory();
					$this->load->view('admin/header');
					$this->load->view('admin/edit_video',$data);
					$this->load->view('admin/footer');
				} else 
				{
					$video_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('video_title'));
					$info = array(
						'user_id'			=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
						'video_title'    		=> htmlentities($this->input->post('video_title'), ENT_QUOTES),
						'video_code'    		=> htmlentities($this->input->post('video_code'), ENT_QUOTES),
						'featured_video'    		=> htmlentities($this->input->post('featured_video'), ENT_QUOTES),
						'video_description'  => htmlentities($this->input->post('video_description'), ENT_QUOTES),
						'video_category_id'  => htmlentities($this->input->post('video_category_id'), ENT_QUOTES),
						'video_seo_title'  => htmlentities($this->input->post('video_seo_title'), ENT_QUOTES),
						'video_seo_description'  => htmlentities($this->input->post('video_seo_description'), ENT_QUOTES),
						'video_seo_keywords'  => htmlentities($this->input->post('video_seo_keywords'), ENT_QUOTES),
						'video_slug'  => htmlentities($video_slug, ENT_QUOTES)
					);

					if($_FILES && $_FILES['video_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/video',
							'quality'     => '60%',
							'image_name'  => 'video_image'
						];

						$image_link = $old_image;

						if($image_link != null){
							if(file_exists('./'.$image_link))
							{
								unlink($image_link);
							}                    
						}

						$info['video_image'] = uploadWithoutResize($img_info);
					} else 
					{
						$info['video_image'] = $old_image;
					}

					if($this->adminmodel->update($id,$info,'video_id','video'))
					{	
						$this->session->set_flashdata('message', 'Successfully Updated Video!!');
						redirect('admin/video-list','refresh');
					} else 
					{
						$this->session->set_flashdata('message', 'Sorry, Update Video Failed!!');
						redirect('admin/edit-video'.$id, 'refresh');
					}
				}	   
			}

			/*Delete Video*/
			public function delete_video($id)
			{
				if($this->adminmodel->deleteVideo($id))
				{
					$this->session->set_flashdata('message', 'Successfully Removed Video!!');
					redirect('admin/video-list');
				} 
			}
			/*
			End Video 
			*/
			/*
			Start classifieds 
			*/	    
			/*====================
			All classifieds Category
			=====================*/
			
			public function all_classifieds_category()
			{
				$data['user'] = $this->adminmodel->getAdminInformation();
				$data['all_classifieds_category'] = $this->adminmodel->allClassifiedsCategory();
				
				$this->load->view('admin/header');
				$this->load->view('admin/all_classifieds_category',$data);
				$this->load->view('admin/footer');
			}
			/*====================
			Add new Category
			=====================*/
			
			public function add_classifieds_category()
			{		
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[classifieds_categories.category_name]');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/add_classifieds_category');
					$this->load->view('admin/footer');
				}
				else 
				{
					$data = array();
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$data['category_name'] = $this->input->post('category_name');
					$data['category_seo_title'] = $this->input->post('category_seo_title');
					$data['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$data['category_seo_description'] = $this->input->post('category_seo_description');
					$data['category_slug'] = $category_slug;

					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/classifieds',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						$data['category_image'] = uploadAndResize($img_info);
					}	    
					// echo "<pre>";var_dump($data);die();
					if($this->adminmodel->addClassifiedsCategory($data))
					{
						$this->session->set_flashdata('message', 'Successfully Added Category!!');
						redirect('admin/all_classifieds_category');
					}
					else 
					{
						$this->session->set_flashdata('message', 'Adding classifieds Category failed!!');
					}
				}
			}
			
			/*====================
			Edit Category
			=====================*/
			public function edit_classifieds_category($id)
			{
				$data['category'] = $this->adminmodel->getSingleValue($id,'category_id','classifieds_categories');
				$old_image        = $data['category']->category_image;
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/edit_classifieds_category',$data);
					$this->load->view('admin/footer');
				} else 
				{
					$info['category_name'] = $this->input->post('category_name');
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$info['category_name'] = $this->input->post('category_name');
					$info['category_seo_title'] = $this->input->post('category_seo_title');
					$info['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$info['category_seo_description'] = $this->input->post('category_seo_description');
					$info['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/classifieds',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						
						$image_link = $old_image;
						if($image_link != null){
							if(file_exists('./'.$image_link))
							{
								unlink($image_link);
							}                    
						}

						
						$info['category_image'] = uploadAndResize($img_info);
					} else 
					{
						$info['category_image'] = $old_image;
					}
					
					if($this->adminmodel->updateClassifiedsCategory($id,$info))
						{	$this->session->set_flashdata('message', 'Successfully Updated Classifieds Category!!');
					redirect('admin/all_classifieds_category','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update Classifieds Category failed!!');
					redirect('admin/edit_classifieds_category', 'refresh');
				}
			}

			}
			/*====================
			Delete classifieds Category
			=====================*/
			public function delete_classifieds_category($id)
			{
				if($this->adminmodel->deleteClassifiedsCategory($id))
				{
					$this->session->set_flashdata('message', 'Category has been Permanently Deleted!!!');
					redirect('admin/all_classifieds_category','refresh');
				} else 
				{
					redirect('admin/all_classifieds_category','refresh');
				}
			}
			/*End classifieds Category*/


		/**********************/
		/***All classifieds***/
		/********************/
		public function classifieds_list()
		{
			$data['classifiedsList'] = $this->adminmodel->getclassifieds();
			$this->load->view('admin/header');
			$this->load->view('admin/all_classifieds',$data);
			$this->load->view('admin/footer');
		}

		/* Preview classifieds */
		public function classifieds_details($id)
		{
			$data['blog'] = $this->usermodel->getSingleValue($id,'classifieds_id','classifieds');

			$this->load->view('admin/inc/header');
			$this->load->view('admin/classifieds_details',$data);
			$this->load->view('admin/footer');        
		}

		/* Add new classifieds */
		public function add_classifieds()
		{
			$data['users'] = $this->adminmodel->getAllUsers('user');
			if($this->form_validation->run('classifieds') == false)
			{
				$data['all_classifieds_category'] = $this->adminmodel->allclassifiedsCategory();
				$this->load->view('admin/header',$data);
				$this->load->view('admin/add_classifieds');
				$this->load->view('admin/footer');	        
			} else {
				$classifieds_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('classifieds_title'));
				$info = array(
					'user_id'					  => htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'classifieds_title'    		  => htmlentities($this->input->post('classifieds_title'), ENT_QUOTES),
					'classifieds_price'    		  => htmlentities($this->input->post('classifieds_price'), ENT_QUOTES),
					'classifieds_category_id'	  => htmlentities($this->input->post('classifieds_category_id'), ENT_QUOTES),
					'featured_classifieds'  	  => htmlentities($this->input->post('featured_classifieds'), ENT_QUOTES),
					'spotlight_classifieds'  	  => htmlentities($this->input->post('spotlight_classifieds'), ENT_QUOTES),
					'display_contact'  	  		  => htmlentities($this->input->post('display_contact'), ENT_QUOTES),
					'classifieds_description'	  => htmlentities($this->input->post('classifieds_description'), ENT_QUOTES),
					'classifieds_seo_title' 	  => htmlentities($this->input->post('classifieds_seo_title'), ENT_QUOTES),
					'classifieds_seo_description' => htmlentities($this->input->post('classifieds_seo_description'), ENT_QUOTES),
					'classifieds_seo_keywords'    => htmlentities($this->input->post('classifieds_seo_keywords'), ENT_QUOTES),
					'classifieds_slug'  		  => htmlentities($classifieds_slug, ENT_QUOTES)
				);

				if($_FILES && $_FILES['classifieds_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/classifieds',
						'quality'     => '60%',
						'image_name'  => 'classifieds_image'
					];
					$info['classifieds_image'] = uploadAndResize($img_info);
				}

				if($this->adminmodel->add('classifieds',$info))
				{
					$this->session->set_flashdata('message', 'Successfully Added classifieds!!');
					redirect('admin/classifieds-list');
				}
				else 
				{
					$this->session->set_flashdata('message', 'Adding classifieds Failed!!');
				}	            
			}
		}

		/* Edit classifieds */
		public function edit_classifieds($id)
		{
			$data['users']   = $this->adminmodel->getAllUsers('user');
			$data['classifieds']    = $this->usermodel->getSingleValue($id,'classifieds_id','classifieds');
			$old_image       = $data['classifieds']->classifieds_image;

			if($this->form_validation->run('classifieds') == FALSE)
			{
				$data['all_classifieds_category'] = $this->adminmodel->allClassifiedsCategory();
				$this->load->view('admin/header');
				$this->load->view('admin/edit_classifieds',$data);
				$this->load->view('admin/footer');
			} else 
			{
				$classifieds_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('classifieds_title'));
				$info = array(
					'user_id'					  => htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'classifieds_title'    		  => htmlentities($this->input->post('classifieds_title'), ENT_QUOTES),
					'classifieds_price'    		  => htmlentities($this->input->post('classifieds_price'), ENT_QUOTES),
					'classifieds_category_id'	  => htmlentities($this->input->post('classifieds_category_id'), ENT_QUOTES),
					'featured_classifieds'  	  => htmlentities($this->input->post('featured_classifieds'), ENT_QUOTES),
					'spotlight_classifieds'  	  => htmlentities($this->input->post('spotlight_classifieds'), ENT_QUOTES),
					'display_contact'  	  		  => htmlentities($this->input->post('display_contact'), ENT_QUOTES),
					'classifieds_description'	  => htmlentities($this->input->post('classifieds_description'), ENT_QUOTES),
					'classifieds_seo_title' 	  => htmlentities($this->input->post('classifieds_seo_title'), ENT_QUOTES),
					'classifieds_seo_description' => htmlentities($this->input->post('classifieds_seo_description'), ENT_QUOTES),
					'classifieds_seo_keywords'    => htmlentities($this->input->post('classifieds_seo_keywords'), ENT_QUOTES),
					'classifieds_slug'  		  => htmlentities($classifieds_slug, ENT_QUOTES)
				);

				if($_FILES && $_FILES['classifieds_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/classifieds',
						'quality'     => '60%',
						'image_name'  => 'classifieds_image'
					];

					$image_link = $old_image;

					if($image_link != null){
						if(file_exists('./'.$image_link))
						{
							unlink($image_link);
						}                    
					}

					$info['classifieds_image'] = uploadWithoutResize($img_info);
				} else 
				{
					$info['classifieds_image'] = $old_image;
				}

				if($this->adminmodel->update($id,$info,'classifieds_id','classifieds'))
				{	
					$this->session->set_flashdata('message', 'Successfully Updated classifieds!!');
					redirect('admin/classifieds-list','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update classifieds Failed!!');
					redirect('admin/edit-classifieds'.$id, 'refresh');
				}
			}	   
		}

		/*Delete classifieds*/
		public function delete_classifieds($id)
		{
			if($this->adminmodel->deleteClassifieds($id))
			{
				$this->session->set_flashdata('message', 'Successfully Removed classifieds!!');
				redirect('admin/classifieds-list');
			} 
		}
		/**********************/
		/***End Classifieds***/
		/********************/

		/*
			Start marketplace 
		*/	    
		/*====================
		All marketplace Category
		=====================*/
			
		public function all_marketplace_category()
		{
			$data['user'] = $this->adminmodel->getAdminInformation();
			$data['all_marketplace_category'] = $this->adminmodel->allMarketplaceCategory();
			
			$this->load->view('admin/header');
			$this->load->view('admin/all_marketplace_category',$data);
			$this->load->view('admin/footer');
		}
			/*====================
			Add new Category
			=====================*/
			
			public function add_marketplace_category()
			{		
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[marketplace_categories.category_name]');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/add_marketplace_category');
					$this->load->view('admin/footer');
				}
				else 
				{
					$data = array();
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$data['category_name'] = $this->input->post('category_name');
					$data['category_seo_title'] = $this->input->post('category_seo_title');
					$data['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$data['category_seo_description'] = $this->input->post('category_seo_description');
					$data['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/marketplace',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						$data['category_image'] = uploadAndResize($img_info);
					}	    
					if($this->adminmodel->addmarketplaceCategory($data))
					{
						$this->session->set_flashdata('message', 'Successfully Added Category!!');
						redirect('admin/all_marketplace_category');
					}
					else 
					{
						$this->session->set_flashdata('message', 'Adding marketplace Category failed!!');
					}
				}
			}
			
			/*====================
			Edit Category
			=====================*/
			public function edit_marketplace_category($id)
			{
				$data['category'] = $this->adminmodel->getSingleValue($id,'category_id','marketplace_categories');
				$old_image        = $data['category']->category_image;
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/edit_marketplace_category',$data);
					$this->load->view('admin/footer');
				} else 
				{
					$info['category_name'] = $this->input->post('category_name');
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$info['category_name'] = $this->input->post('category_name');
					$info['category_seo_title'] = $this->input->post('category_seo_title');
					$info['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$info['category_seo_description'] = $this->input->post('category_seo_description');
					$info['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/marketplace',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						
						$image_link = $old_image;
						if($image_link != null){
							if(file_exists('./'.$image_link))
							{
								unlink($image_link);
							}                    
						}

						
						$info['category_image'] = uploadAndResize($img_info);
					} else 
					{
						$info['category_image'] = $old_image;
					}
					
					if($this->adminmodel->updatemarketplaceCategory($id,$info))
						{	$this->session->set_flashdata('message', 'Successfully Updated marketplace Category!!');
					redirect('admin/all_marketplace_category','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update marketplace Category failed!!');
					redirect('admin/edit_marketplace_category', 'refresh');
				}
			}

		}
			/*====================
			Delete marketplace Category
			=====================*/
			public function delete_marketplace_category($id)
			{
				if($this->adminmodel->deletemarketplaceCategory($id))
				{
					$this->session->set_flashdata('message', 'Category has been Permanently Deleted!!!');
					redirect('admin/all_marketplace_category','refresh');
				} else 
				{
					redirect('admin/all_marketplace_category','refresh');
				}
			}
			/*End marketplace Category*/


		/**********************/
		/***All marketplace***/
		/********************/
		public function marketplace_list()
		{
			$data['marketplaceList'] = $this->adminmodel->getmarketplace();
			$this->load->view('admin/header');
			$this->load->view('admin/all_marketplace',$data);
			$this->load->view('admin/footer');
		}

		/* Preview marketplace */
		public function marketplace_details($id)
		{
			$data['blog'] = $this->usermodel->getSingleValue($id,'marketplace_id','marketplace');

			$this->load->view('admin/inc/header');
			$this->load->view('admin/marketplace_details',$data);
			$this->load->view('admin/footer');        
		}

		/* Add new marketplace */
		public function add_marketplace()
		{
			$data['users'] = $this->adminmodel->getAllUsers('user');
			if($this->form_validation->run('marketplace') == false)
			{
				$data['all_marketplace_category'] = $this->adminmodel->allmarketplaceCategory();
				$this->load->view('admin/header',$data);
				$this->load->view('admin/add_marketplace');
				$this->load->view('admin/footer');	        
			} else {
				$marketplace_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('marketplace_title'));
				$info = array(
					'user_id'					  => htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'marketplace_title'    		  => htmlentities($this->input->post('marketplace_title'), ENT_QUOTES),
					'marketplace_price'    		  => htmlentities($this->input->post('marketplace_price'), ENT_QUOTES),
					'marketplace_category_id'	  => htmlentities($this->input->post('marketplace_category_id'), ENT_QUOTES),
					'featured_marketplace'  	  => htmlentities($this->input->post('featured_marketplace'), ENT_QUOTES),
					'spotlight_marketplace'  	  => htmlentities($this->input->post('spotlight_marketplace'), ENT_QUOTES),
					'display_contact'  	  		  => htmlentities($this->input->post('display_contact'), ENT_QUOTES),
					'marketplace_description'	  => htmlentities($this->input->post('marketplace_description'), ENT_QUOTES),
					'marketplace_seo_title' 	  => htmlentities($this->input->post('marketplace_seo_title'), ENT_QUOTES),
					'marketplace_seo_description' => htmlentities($this->input->post('marketplace_seo_description'), ENT_QUOTES),
					'marketplace_seo_keywords'    => htmlentities($this->input->post('marketplace_seo_keywords'), ENT_QUOTES),
					'marketplace_slug'  		  => htmlentities($marketplace_slug, ENT_QUOTES)
				);

				if($_FILES && $_FILES['marketplace_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/marketplace',
						'quality'     => '60%',
						'image_name'  => 'marketplace_image'
					];
					$info['marketplace_image'] = uploadAndResize($img_info);
				}

				if($this->adminmodel->add('marketplace',$info))
				{
					$this->session->set_flashdata('message', 'Successfully Added marketplace!!');
					redirect('admin/marketplace-list');
				}
				else 
				{
					$this->session->set_flashdata('message', 'Adding marketplace Failed!!');
				}	            
			}
		}

		/* Edit marketplace */
		public function edit_marketplace($id)
		{
			$data['users']   = $this->adminmodel->getAllUsers('user');
			$data['marketplace']    = $this->usermodel->getSingleValue($id,'marketplace_id','marketplace');
			$old_image       = $data['marketplace']->marketplace_image;

			if($this->form_validation->run('marketplace') == FALSE)
			{
				$data['all_marketplace_category'] = $this->adminmodel->allmarketplaceCategory();
				$this->load->view('admin/header');
				$this->load->view('admin/edit_marketplace',$data);
				$this->load->view('admin/footer');
			} else 
			{
				$marketplace_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('marketplace_title'));
				$info = array(
					'user_id'					  => htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'marketplace_title'    		  => htmlentities($this->input->post('marketplace_title'), ENT_QUOTES),
					'marketplace_price'    		  => htmlentities($this->input->post('marketplace_price'), ENT_QUOTES),
					'marketplace_category_id'	  => htmlentities($this->input->post('marketplace_category_id'), ENT_QUOTES),
					'featured_marketplace'  	  => htmlentities($this->input->post('featured_marketplace'), ENT_QUOTES),
					'spotlight_marketplace'  	  => htmlentities($this->input->post('spotlight_marketplace'), ENT_QUOTES),
					'display_contact'  	  		  => htmlentities($this->input->post('display_contact'), ENT_QUOTES),
					'marketplace_description'	  => htmlentities($this->input->post('marketplace_description'), ENT_QUOTES),
					'marketplace_seo_title' 	  => htmlentities($this->input->post('marketplace_seo_title'), ENT_QUOTES),
					'marketplace_seo_description' => htmlentities($this->input->post('marketplace_seo_description'), ENT_QUOTES),
					'marketplace_seo_keywords'    => htmlentities($this->input->post('marketplace_seo_keywords'), ENT_QUOTES),
					'marketplace_slug'  		  => htmlentities($marketplace_slug, ENT_QUOTES)
				);

				if($_FILES && $_FILES['marketplace_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/marketplace',
						'quality'     => '60%',
						'image_name'  => 'marketplace_image'
					];

					$image_link = $old_image;

					if($image_link != null){
						if(file_exists('./'.$image_link))
						{
							unlink($image_link);
						}                    
					}

					$info['marketplace_image'] = uploadWithoutResize($img_info);
				} else 
				{
					$info['marketplace_image'] = $old_image;
				}

				if($this->adminmodel->update($id,$info,'marketplace_id','marketplace'))
				{	
					$this->session->set_flashdata('message', 'Successfully Updated marketplace!!');
					redirect('admin/marketplace-list','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update marketplace Failed!!');
					redirect('admin/edit-marketplace'.$id, 'refresh');
				}
			}	   
		}

		/*Delete marketplace*/
		public function delete_marketplace($id)
		{
			if($this->adminmodel->deletemarketplace($id))
			{
				$this->session->set_flashdata('message', 'Successfully Removed marketplace!!');
				redirect('admin/marketplace-list');
			} 
		}
		/**********************/
		/***End marketplace***/
		/********************/

		/*
			Start rental 
			*/	    
			/*====================
			All rental Category
			=====================*/
			
			public function all_rental_category()
			{
				$data['user'] = $this->adminmodel->getAdminInformation();
				$data['all_rental_category'] = $this->adminmodel->allRentalCategory();
				
				$this->load->view('admin/header');
				$this->load->view('admin/all_rental_category',$data);
				$this->load->view('admin/footer');
			}
			/*====================
			Add new Category
			=====================*/
			
			public function add_rental_category()
			{		
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[rental_categories.category_name]');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/add_rental_category');
					$this->load->view('admin/footer');
				}
				else 
				{
					$data = array();
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$data['category_name'] = $this->input->post('category_name');
					$data['category_seo_title'] = $this->input->post('category_seo_title');
					$data['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$data['category_seo_description'] = $this->input->post('category_seo_description');
					$data['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/rental',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						$data['category_image'] = uploadAndResize($img_info);
					}	    
					if($this->adminmodel->addRentalCategory($data))
					{
						$this->session->set_flashdata('message', 'Successfully Added Category!!');
						redirect('admin/all_rental_category');
					}
					else 
					{
						$this->session->set_flashdata('message', 'Adding rental Category failed!!');
					}
				}
			}
			
			/*====================
			Edit Category
			=====================*/
			public function edit_rental_category($id)
			{
				$data['category'] = $this->adminmodel->getSingleValue($id,'category_id','rental_categories');
				$old_image        = $data['category']->category_image;
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/edit_rental_category',$data);
					$this->load->view('admin/footer');
				} else 
				{
					$info['category_name'] = $this->input->post('category_name');
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$info['category_name'] = $this->input->post('category_name');
					$info['category_seo_title'] = $this->input->post('category_seo_title');
					$info['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$info['category_seo_description'] = $this->input->post('category_seo_description');
					$info['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/rental',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						
						$image_link = $old_image;
						if($image_link != null){
							if(file_exists('./'.$image_link))
							{
								unlink($image_link);
							}                    
						}

						
						$info['category_image'] = uploadAndResize($img_info);
					} else 
					{
						$info['category_image'] = $old_image;
					}
					
					if($this->adminmodel->updateRentalCategory($id,$info))
						{	$this->session->set_flashdata('message', 'Successfully Updated rental Category!!');
					redirect('admin/all_rental_category','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update rental Category failed!!');
					redirect('admin/edit_rental_category', 'refresh');
				}
			}

			}
			/*====================
			Delete rental Category
			=====================*/
			public function delete_rental_category($id)
			{
				if($this->adminmodel->deleteRentalCategory($id))
				{
					$this->session->set_flashdata('message', 'Category has been Permanently Deleted!!!');
					redirect('admin/all_rental_category','refresh');
				} else 
				{
					redirect('admin/all_rental_category','refresh');
				}
			}
			/*End rental Category*/


		/**********************/
		/***All rental***/
		/********************/
		public function rental_list()
		{
			$data['rentalList'] = $this->adminmodel->getRental();
			$this->load->view('admin/header');
			$this->load->view('admin/all_rental',$data);
			$this->load->view('admin/footer');
		}

		/* Preview rental */
		public function rental_details($id)
		{
			$data['blog'] = $this->usermodel->getSingleValue($id,'rental_id','rental');

			$this->load->view('admin/inc/header');
			$this->load->view('admin/rental_details',$data);
			$this->load->view('admin/footer');        
		}

		/* Add new rental */
		public function add_rental()
		{
			$data['users'] = $this->adminmodel->getAllUsers('user');
			if($this->form_validation->run('rental') == false)
			{
				$data['all_rental_category'] = $this->adminmodel->allRentalCategory();
				$this->load->view('admin/header',$data);
				$this->load->view('admin/add_rental');
				$this->load->view('admin/footer');	        
			} else {
				$rental_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('rental_title'));
				$info = array(
					'user_id'					  => htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'rental_title'    		  => htmlentities($this->input->post('rental_title'), ENT_QUOTES),
					'rental_price'    		  => htmlentities($this->input->post('rental_price'), ENT_QUOTES),
					'rental_category_id'    		  => htmlentities($this->input->post('rental_category_id'), ENT_QUOTES),
					'featured_rental'    		  => htmlentities($this->input->post('featured_rental'), ENT_QUOTES),
					'spotlight_rental'    		  => htmlentities($this->input->post('spotlight_rental'), ENT_QUOTES),
					'display_contact'    		  => htmlentities($this->input->post('display_contact'), ENT_QUOTES),
					'rental_address'    		  => htmlentities($this->input->post('rental_address'), ENT_QUOTES),
					'rental_description'    		  => htmlentities($this->input->post('rental_description'), ENT_QUOTES),
					'bedrooms'    		  => htmlentities($this->input->post('bedrooms'), ENT_QUOTES),
					'living_area'    		  => htmlentities($this->input->post('living_area'), ENT_QUOTES),
					'bathroom'    		  => htmlentities($this->input->post('bathroom'), ENT_QUOTES),
					'property_age'    		  => htmlentities($this->input->post('property_age'), ENT_QUOTES),
					'garage'    		  => htmlentities($this->input->post('garage'), ENT_QUOTES),
					'floors'    		  => htmlentities($this->input->post('floors'), ENT_QUOTES),
					'rent_to_own'    		  => htmlentities($this->input->post('rent_to_own'), ENT_QUOTES),
					'can_sublet'    		  => htmlentities($this->input->post('can_sublet'), ENT_QUOTES),
					'rental_seo_title'    		  => htmlentities($this->input->post('rental_seo_title'), ENT_QUOTES),
					'rental_seo_keywords'    		  => htmlentities($this->input->post('rental_seo_keywords'), ENT_QUOTES),
					'rental_seo_description'    		  => htmlentities($this->input->post('rental_seo_description'), ENT_QUOTES),
					'rental_slug'  		  => htmlentities($rental_slug, ENT_QUOTES)
				);

				if($_FILES && $_FILES['rental_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/rental',
						'quality'     => '60%',
						'image_name'  => 'rental_image'
					];
					$info['rental_image'] = uploadWithoutResize($img_info);
				}

				if($this->adminmodel->add('rental',$info))
				{
					$this->session->set_flashdata('message', 'Successfully Added rental!!');
					redirect('admin/rental-list');
				}
				else 
				{
					$this->session->set_flashdata('message', 'Adding rental Failed!!');
				}	            
			}
		}

		/* Edit rental */
		public function edit_rental($id)
		{
			$data['users']   = $this->adminmodel->getAllUsers('user');
			$data['rental']    = $this->usermodel->getSingleValue($id,'rental_id','rental');
			$old_image       = $data['rental']->rental_image;

			if($this->form_validation->run('rental') == FALSE)
			{
				$data['all_rental_category'] = $this->adminmodel->allrentalCategory();
				$this->load->view('admin/header');
				$this->load->view('admin/edit_rental',$data);
				$this->load->view('admin/footer');
			} else 
			{
				$rental_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('rental_title'));
				$info = array(
					'user_id'					  => htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'rental_title'    		  => htmlentities($this->input->post('rental_title'), ENT_QUOTES),
					'rental_price'    		  => htmlentities($this->input->post('rental_price'), ENT_QUOTES),
					'rental_category_id'    		  => htmlentities($this->input->post('rental_category_id'), ENT_QUOTES),
					'featured_rental'    		  => htmlentities($this->input->post('featured_rental'), ENT_QUOTES),
					'spotlight_rental'    		  => htmlentities($this->input->post('spotlight_rental'), ENT_QUOTES),
					'display_contact'    		  => htmlentities($this->input->post('display_contact'), ENT_QUOTES),
					'rental_address'    		  => htmlentities($this->input->post('rental_address'), ENT_QUOTES),
					'rental_description'    		  => htmlentities($this->input->post('rental_description'), ENT_QUOTES),
					'bedrooms'    		  => htmlentities($this->input->post('bedrooms'), ENT_QUOTES),
					'living_area'    		  => htmlentities($this->input->post('living_area'), ENT_QUOTES),
					'bathroom'    		  => htmlentities($this->input->post('bathroom'), ENT_QUOTES),
					'property_age'    		  => htmlentities($this->input->post('property_age'), ENT_QUOTES),
					'garage'    		  => htmlentities($this->input->post('garage'), ENT_QUOTES),
					'floors'    		  => htmlentities($this->input->post('floors'), ENT_QUOTES),
					'rent_to_own'    		  => htmlentities($this->input->post('rent_to_own'), ENT_QUOTES),
					'can_sublet'    		  => htmlentities($this->input->post('can_sublet'), ENT_QUOTES),
					'rental_seo_title'    		  => htmlentities($this->input->post('rental_seo_title'), ENT_QUOTES),
					'rental_seo_keywords'    		  => htmlentities($this->input->post('rental_seo_keywords'), ENT_QUOTES),
					'rental_seo_description'    		  => htmlentities($this->input->post('rental_seo_description'), ENT_QUOTES),
					'rental_slug'  		  => htmlentities($rental_slug, ENT_QUOTES)
				);

				if($_FILES && $_FILES['rental_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/rental',
						'quality'     => '60%',
						'image_name'  => 'rental_image'
					];

					$image_link = $old_image;

					if($image_link != null){
						if(file_exists('./'.$image_link))
						{
							unlink($image_link);
						}                    
					}

					$info['rental_image'] = uploadWithoutResize($img_info);
				} else 
				{
					$info['rental_image'] = $old_image;
				}

				if($this->adminmodel->update($id,$info,'rental_id','rental'))
				{	
					$this->session->set_flashdata('message', 'Successfully Updated rental!!');
					redirect('admin/rental-list','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update rental Failed!!');
					redirect('admin/edit-rental'.$id, 'refresh');
				}
			}	   
		}

		/*Delete rental*/
		public function delete_rental($id)
		{
			if($this->adminmodel->deleteRental($id))
			{
				$this->session->set_flashdata('message', 'Successfully Removed rental!!');
				redirect('admin/rental-list');
			} 
		}
		/**********************/
		/***End rental***/
		/********************/
		/*
			Start house 
			*/	    
			/*====================
			All house Category
			=====================*/
			
			public function all_house_category()
			{
				$data['user'] = $this->adminmodel->getAdminInformation();
				$data['all_house_category'] = $this->adminmodel->allhouseCategory();
				
				$this->load->view('admin/header');
				$this->load->view('admin/all_house_category',$data);
				$this->load->view('admin/footer');
			}
			/*====================
			Add new Category
			=====================*/			
			public function add_house_category()
			{		
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|is_unique[house_categories.category_name]');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/add_house_category');
					$this->load->view('admin/footer');
				}
				else 
				{
					$data = array();
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$data['category_name'] = $this->input->post('category_name');
					$data['category_seo_title'] = $this->input->post('category_seo_title');
					$data['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$data['category_seo_description'] = $this->input->post('category_seo_description');
					$data['category_slug'] = $category_slug;
					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/house',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						$data['category_image'] = uploadAndResize($img_info);
					}	    
					if($this->adminmodel->addhouseCategory($data))
					{
						$this->session->set_flashdata('message', 'Successfully Added Category!!');
						redirect('admin/all_house_category');
					}
					else 
					{
						$this->session->set_flashdata('message', 'Adding house Category failed!!');
					}
				}
			}
			
			/*====================
			Edit Category
			=====================*/
			public function edit_house_category($id)
			{
				$data['category'] = $this->adminmodel->getSingleValue($id,'category_id','house_categories');
				$old_image        = $data['category']->category_image;
				$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

				if($this->form_validation->run() == FALSE)
				{
					$this->load->view('admin/header');
					$this->load->view('admin/edit_house_category',$data);
					$this->load->view('admin/footer');
				} else 
				{
					$info['category_name'] = $this->input->post('category_name');
					$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('category_name'));
					$info['category_name'] = $this->input->post('category_name');
					$info['category_seo_title'] = $this->input->post('category_seo_title');
					$info['category_seo_keywords'] = $this->input->post('category_seo_keywords');
					$info['category_seo_description'] = $this->input->post('category_seo_description');
					$info['category_slug'] = $category_slug;

					if($_FILES && $_FILES['category_image']['name'])
					{
						$img_info = [
							'upload_path' => 'images/house',
							'quality'     => '60%',
							'image_name'  => 'category_image'
						];
						
						$image_link = $old_image;
						if($image_link != null){
							if(file_exists('./'.$image_link))
							{
								unlink($image_link);
							}                    
						}

						
						$info['category_image'] = uploadAndResize($img_info);
					} else 
					{
						$info['category_image'] = $old_image;
					}

					if($this->adminmodel->updatehouseCategory($id,$info))
						{	$this->session->set_flashdata('message', 'Successfully Updated house Category!!');
					redirect('admin/all_house_category','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update house Category failed!!');
					redirect('admin/edit_house_category', 'refresh');
				}
			}

			}
			/*====================
			Delete house Category
			=====================*/
			public function delete_house_category($id)
			{
				if($this->adminmodel->deletehouseCategory($id))
				{
					$this->session->set_flashdata('message', 'Category has been Permanently Deleted!!!');
					redirect('admin/all_house_category','refresh');
				} else 
				{
					redirect('admin/all_house_category','refresh');
				}
			}
			/*End house Category*/


		/**********************/
		/***All house***/
		/********************/
		public function house_list()
		{
			$data['houseList'] = $this->adminmodel->getHouse();
			$this->load->view('admin/header');
			$this->load->view('admin/all_house',$data);
			$this->load->view('admin/footer');
		}

		/* Preview house */
		public function house_details($id)
		{
			$data['blog'] = $this->usermodel->getSingleValue($id,'house_id','house');

			$this->load->view('admin/inc/header');
			$this->load->view('admin/house_details',$data);
			$this->load->view('admin/footer');        
		}

		/* Add new house */
		public function add_house()
		{
			$data['users'] = $this->adminmodel->getAllUsers('user');
			if($this->form_validation->run('house') == false)
			{
				$data['all_house_category'] = $this->adminmodel->allhouseCategory();

				$this->load->view('admin/header',$data);
				$this->load->view('admin/add_house');
				$this->load->view('admin/footer');	        
			} else {
				$house_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('house_title'));
				$info = array(
					'user_id'			  	=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'house_title'    	  	=> htmlentities($this->input->post('house_title'), ENT_QUOTES),
					'house_price'    	  	=> htmlentities($this->input->post('house_price'), ENT_QUOTES),
					'house_category_id'	  	=> htmlentities($this->input->post('house_category_id'), ENT_QUOTES),
					'featured_house'  	  	=> htmlentities($this->input->post('featured_house'), ENT_QUOTES),
					'spotlight_house'  	  	=> htmlentities($this->input->post('spotlight_house'), ENT_QUOTES),
					'display_contact'  	  	=> htmlentities($this->input->post('display_contact'), ENT_QUOTES),
					'bedrooms'    		  	=> htmlentities($this->input->post('bedrooms'), ENT_QUOTES),
					'living_area'    		=> htmlentities($this->input->post('living_area'), ENT_QUOTES),
					'bathroom'    		  	=> htmlentities($this->input->post('bathroom'), ENT_QUOTES),
					'property_age'    		=> htmlentities($this->input->post('property_age'), ENT_QUOTES),
					'garage'    		  	=> htmlentities($this->input->post('garage'), ENT_QUOTES),
					'floors'    		  	=> htmlentities($this->input->post('floors'), ENT_QUOTES),
					'rent_to_own'    		=> htmlentities($this->input->post('rent_to_own'), ENT_QUOTES),
					'can_sublet'    		=> htmlentities($this->input->post('can_sublet'), ENT_QUOTES),					
					'house_description'	  	=> htmlentities($this->input->post('house_description'), ENT_QUOTES),
					'house_seo_title' 	  	=> htmlentities($this->input->post('house_seo_title'), ENT_QUOTES),
					'house_seo_description' => htmlentities($this->input->post('house_seo_description'), ENT_QUOTES),
					'house_seo_keywords'    => htmlentities($this->input->post('house_seo_keywords'), ENT_QUOTES),
					'house_slug'  		  	=> htmlentities($house_slug, ENT_QUOTES)
				);

				if($_FILES && $_FILES['house_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/house',
						'quality'     => '60%',
						'image_name'  => 'house_image'
					];
					$info['house_image'] = uploadAndResize($img_info);
				}

				if($this->adminmodel->add('house',$info))
				{
					$this->session->set_flashdata('message', 'Successfully Added house!!');
					redirect('admin/house-list');
				}
				else 
				{
					$this->session->set_flashdata('message', 'Adding house Failed!!');
				}	            
			}
		}

		/* Edit house */
		public function edit_house($id)
		{
			$data['users']   = $this->adminmodel->getAllUsers('user');
			$data['house']   = $this->usermodel->getSingleValue($id,'house_id','house');
			$old_image       = $data['house']->house_image;

			if($this->form_validation->run('house') == FALSE)
			{
				$data['all_house_category'] = $this->adminmodel->allhouseCategory();
				$this->load->view('admin/header');
				$this->load->view('admin/edit_house',$data);
				$this->load->view('admin/footer');
			} else 
			{
				$house_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('house_title'));
				$info = array(
					'user_id'				=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'house_title'    		=> htmlentities($this->input->post('house_title'), ENT_QUOTES),
					'house_price'    		=> htmlentities($this->input->post('house_price'), ENT_QUOTES),
					'house_category_id'	 	=> htmlentities($this->input->post('house_category_id'), ENT_QUOTES),
					'featured_house'  	 	=> htmlentities($this->input->post('featured_house'), ENT_QUOTES),
					'spotlight_house'  	 	=> htmlentities($this->input->post('spotlight_house'), ENT_QUOTES),
					'display_contact'  	  	=> htmlentities($this->input->post('display_contact'), ENT_QUOTES),
					'house_description'	    => htmlentities($this->input->post('house_description'), ENT_QUOTES),
					'house_seo_title' 	    => htmlentities($this->input->post('house_seo_title'), ENT_QUOTES),
					'house_seo_description' => htmlentities($this->input->post('house_seo_description'), ENT_QUOTES),
					'house_seo_keywords'    => htmlentities($this->input->post('house_seo_keywords'), ENT_QUOTES),
					'house_slug'  		  	=> htmlentities($house_slug, ENT_QUOTES)
				);

				if($_FILES && $_FILES['house_image']['name'])
				{
					$img_info = [
						'upload_path' => 'images/house',
						'quality'     => '60%',
						'image_name'  => 'house_image'
					];

					$image_link = $old_image;

					if($image_link != null){
						if(file_exists('./'.$image_link))
						{
							unlink($image_link);
						}                    
					}

					$info['house_image'] = uploadWithoutResize($img_info);
				} else 
				{
					$info['house_image'] = $old_image;
				}

				if($this->adminmodel->update($id,$info,'house_id','house'))
				{	
					$this->session->set_flashdata('message', 'Successfully Updated house!!');
					redirect('admin/house-list','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Update house Failed!!');
					redirect('admin/edit-house'.$id, 'refresh');
				}
			}	   
		}

		/*Delete house*/
		public function delete_house($id)
		{
			if($this->adminmodel->deletehouse($id))
			{
				$this->session->set_flashdata('message', 'Successfully Removed house!!');
				redirect('admin/house-list');
			} 
		}
		/**********************/
		/***End house***/
		/********************/
			

	/*=====================
	      EVENTS
	      =====================*/        
	      
	      /*All events*/
// 	public function all_events()
// 	{
// 	    $data['allEvents'] = $this->adminmodel->get_events();
	      
// 		$this->load->view('admin/header');
// 		$this->load->view('admin/left_sidebar');
// 		$this->load->view('admin/all_event',$data);
// 		$this->load->view('admin/right_sidebar');
// 		$this->load->view('admin/footer');
// 	}
	      
//     /* Preview Event */
//     public function event_details($id)
//     {
//         $data['event'] = $this->adminmodel->getSingleValue($id,'event_id','events');
	      
// 		$this->load->view('header');
// 		$this->load->view('event_details',$data);
// 		$this->load->view('footer');        
//     }
	      
// 	/* Add new Event */
// 	public function add_user_event()
// 	{
// 	    if($this->form_validation->run('event_rules') == false)
// 	    {
//     		$this->load->view('header');
//     		$this->load->view('user_add_new_event');
//     		$this->load->view('footer');	        
// 	    } else {
// 	        $info = array(
//     	            'event_name'        => $this->input->post('event_name'),
//     	            'event_address'     => $this->input->post('event_address'),
//     	            'event_start_date'  => $this->input->post('event_start_date'),
//                     'event_time'        => $this->input->post('event_time'),
//                     'event_description' => $this->input->post('event_description'),
//                     'event_map'         => $this->input->post('event_map'),
//                     'event_contact_name'=> $this->input->post('event_contact_name'),
//                     'event_mobile'      => $this->input->post('event_mobile'),
//                     'event_email'       => $this->input->post('event_email'),
//                     'event_website'     => $this->input->post('event_website'),
//                     'isenquiry'         => $this->input->post('isenquiry')
// 	            );
	      
//             if($_FILES && $_FILES['event_image']['name'])
//             {
// 				$img_info = [
//     				'upload_path' => 'images/events',
//     				'quality'     => '60%',
//     				'height'      => 400,
//     				'width'       => 1000,
//     				'image_name'  => 'event_image'
//     			];
//     			$info['event_image'] = uploadAndResize($img_info);
//             }

// 			if($this->adminmodel->addEvents($info))
// 			{
// 				$this->session->set_flashdata('message', 'Successfully Added Event!!');
// 				redirect('user/add_user_event');
// 			}
// 			else 
// 			{
// 				$this->session->set_flashdata('message', 'Adding Event Failed!!');
// 			}	            

// 	    }
// 	}
	      
// 	/* Edit User Event */
// 	public function edit_user_event($id)
// 	{
//         $data['event']    = $this->adminmodel->getSingleValue($id,'event_id','events');
// 	    $old_image        = $data['event']->event_image;

// 		if($this->form_validation->run('event_rules') == FALSE)
// 		{
//     		$this->load->view('header');
//     		$this->load->view('user_edit_event',$data);
//     		$this->load->view('footer');
// 		} else 
// 		{
// 	        $info = array(
//     	            'event_name'        => $this->input->post('event_name'),
//     	            'event_address'     => $this->input->post('event_address'),
//     	            'event_start_date'  => $this->input->post('event_start_date'),
//                     'event_time'        => $this->input->post('event_time'),
//                     'event_description' => $this->input->post('event_description'),
//                     'event_map'         => $this->input->post('event_map'),
//                     'event_contact_name'=> $this->input->post('event_contact_name'),
//                     'event_mobile'      => $this->input->post('event_mobile'),
//                     'event_email'       => $this->input->post('event_email'),
//                     'event_website'     => $this->input->post('event_website'),
//                     'isenquiry'         => $this->input->post('isenquiry') == 'on' ? 1 : 0
// 	            );
	      
// 			if($_FILES && $_FILES['event_image']['name'])
// 			{
// 				$img_info = [
// 					'upload_path' => 'images/events',
// 					'quality'     => '60%',
// 					'height'      => 400,
// 					'width'       => 1000,
// 					'image_name'  => 'event_image'
// 				];
	      
// 	            $image_link = $old_image;

//                 if($image_link != null){
//                     if(file_exists('./'.$image_link))
//                     {
//                         unlink($image_link);
//                     }                    
//                 }
	      
// 				$info['event_image'] = uploadAndResize($img_info);
// 			} else 
// 			{
// 			    $info['event_image'] = $old_image;
// 			}

// 			if($this->adminmodel->update($id,$info,'event_id','events'))
// 			{	$this->session->set_flashdata('message', 'Successfully Updated Event!!');
// 			    redirect('user/user_events','refresh');
// 			} else 
// 			{
// 			    $this->session->set_flashdata('message', 'Sorry, Update Event Failed!!');
// 				redirect('user/edit_user_event', 'refresh');
// 			}
	      

	      
// 		}	   
// 	}
	      
// 	/*Delete events*/
// 	public function delete_user_event($id)
// 	{
//         if($this->adminmodel->deleteUserEvent($id))
//         {
//             $this->session->set_flashdata('message', 'Successfully Removed Event!!');
//             redirect('user/user_events');
//         } 
// 	}



	      
	      
	/*=====================
	      EVENTS
	      =====================*/        
	      
	      /*All events*/
	      public function all_events()
	      {
	      	$data['allEvents'] = $this->adminmodel->get_events();
	      	
	      	$this->load->view('admin/header');
	      	$this->load->view('admin/all_event',$data);
	      	$this->load->view('admin/footer');
	      }
	      
	      /* Preview Event */
	      public function event_details($id)
	      {

	      	$data['event'] = $this->adminmodel->getSingleValue($id,'event_id','events');
	      	$data['logged_id'] = '';
	      	$this->load->view('header');
	      	$this->load->view('event_details',$data);
	      	$this->load->view('footer');        
	      }

	      /* Add new Event */
	      public function add_new_event()
	      {
	      	$data['users'] = $this->adminmodel->getAllUsers('user');
	      	
	      	if($this->form_validation->run('admin_event_rules') == false)
	      	{
	      		$this->load->view('admin/header');
	      		$this->load->view('admin/add_new_event',$data);
	      		$this->load->view('admin/footer');	        
	      	} else {
				$event_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('event_name'));

	      		$info = array(
	      			'user_id'           => $this->input->post('user_id'),
	      			'event_name'        => $this->input->post('event_name'),
	      			'event_address'     => $this->input->post('event_address'),
	      			'event_start_date'  => $this->input->post('event_start_date'),
	      			'event_time'        => $this->input->post('event_time'),
	      			'event_description' => $this->input->post('event_description'),
	      			'event_map'         => $this->input->post('event_map'),
	      			'event_contact_name'=> $this->input->post('event_contact_name'),
	      			'event_mobile'      => $this->input->post('event_mobile'),
	      			'event_email'       => $this->input->post('event_email'),
	      			'event_website'     => $this->input->post('event_website'),
	      			'isenquiry'         => $this->input->post('isenquiry'),
	      			'event_status'      => 1,
	      			'event_slug'		=>$event_slug
	      		);
	      		
	      		if($_FILES && $_FILES['event_image']['name'])
	      		{
	      			$img_info = [
	      				'upload_path' => 'images/events',
	      				'quality'     => '60%',
	      				'height'      => 400,
	      				'width'       => 1000,
	      				'image_name'  => 'event_image'
	      			];
	      			$info['event_image'] = uploadAndResize($img_info);
	      		}

	      		if($this->adminmodel->addEvent($info))
	      		{
	      			$this->session->set_flashdata('message', 'Successfully Added Event!!');
	      			redirect('admin/all-events');
	      		}
	      		else 
	      		{
	      			$this->session->set_flashdata('message', 'Adding Event Failed!!');
	      		}	            

	      	}
	      }
	      
	      /* Edit User Event */
	      public function edit_event($id)
	      {
	      	$data['event']    = $this->adminmodel->getSingleValue($id,'event_id','events');
	      	$data['allUsers'] = $this->adminmodel->get_users();
	      	$old_image        = $data['event']->event_image;

	      	if($this->form_validation->run('event_rules') == FALSE)
	      	{
	      		$this->load->view('admin/header');
	      		$this->load->view('admin/edit_event',$data);
	      		$this->load->view('admin/footer');
	      	} else 
	      	{
				$event_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('event_name'));
	      		$info = array(
	      			'user_id'           => $this->input->post('user_id'),
	      			'event_name'        => $this->input->post('event_name'),
	      			'event_address'     => $this->input->post('event_address'),
	      			'event_start_date'  => $this->input->post('event_start_date'),
	      			'event_time'        => $this->input->post('event_time'),
	      			'event_description' => $this->input->post('event_description'),
	      			'event_map'         => $this->input->post('event_map'),
	      			'event_contact_name'=> $this->input->post('event_contact_name'),
	      			'event_mobile'      => $this->input->post('event_mobile'),
	      			'event_email'       => $this->input->post('event_email'),
	      			'event_website'     => $this->input->post('event_website'),
	      			'isenquiry'         => $this->input->post('isenquiry') == 'on' ? 1 : 0,
	      			'event_slug'		=>$event_slug
	      		);
	      		);
	      		
	      		if($_FILES && $_FILES['event_image']['name'])
	      		{
	      			$img_info = [
	      				'upload_path' => 'images/events',
	      				'quality'     => '60%',
	      				'height'      => 400,
	      				'width'       => 1000,
	      				'image_name'  => 'event_image'
	      			];
	      			
	      			$image_link = $old_image;

	      			if($image_link != null){
	      				if(file_exists('./'.$image_link))
	      				{
	      					unlink($image_link);
	      				}                    
	      			}
	      			
	      			$info['event_image'] = uploadAndResize($img_info);
	      		} else 
	      		{
	      			$info['event_image'] = $old_image;
	      		}

	      		if($this->adminmodel->update($id,$info,'event_id','events'))
	      			{	$this->session->set_flashdata('message', 'Successfully Updated Event!!');
	      		redirect('admin/all-events','refresh');
	      	} else 
	      	{
	      		$this->session->set_flashdata('message', 'Sorry, Update Event Failed!!');
	      		redirect('admin/edit_event', 'refresh');
	      	}
	      	

	      	
	      }	   
	    }
	    
	    /*Delete events*/
	    public function delete_event($id)
	    {
	    	if($this->adminmodel->deleteEvent($id))
	    	{
	    		$this->session->set_flashdata('message', 'Successfully Removed Event!!');
	    		redirect('admin/all-events');
	    	} 
	    }
	    
	/*====================
	All Slider
	=====================*/
	public function slider_all(){
		$data['user'] = $this->adminmodel->getAdminInformation();
		$data['all_slider'] = $this->adminmodel->allSlider();
		$this->load->view('admin/header');
		$this->load->view('admin/slider_all',$data);
		$this->load->view('admin/footer');
	}
	/*====================
	Add Slider
	=====================*/
	
	public function slider_create()
	{		
		$this->form_validation->set_rules('slider_link', 'Slider Link', 'trim');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/slider_create');
			$this->load->view('admin/footer');
		}
		else 
		{
			$data = array();
			$data['slider_link'] = htmlentities($this->input->post('slider_link'), ENT_QUOTES);

			if($_FILES && $_FILES['slider_photo']['name'])
			{
				$img_info = [
					'upload_path' => 'images/slider',
					'height'      => 160,
					'width'       => 960,
					'image_name'  => 'slider_photo'
				];
				$data['slider_photo'] = uploadAndResize($img_info);
			}	    

			if($this->adminmodel->addSlider($data))
			{
				$this->session->set_flashdata('message', 'Successfully Added New Slider!!');
				redirect('admin/slider_all');
			}
			else 
			{
				$this->session->set_flashdata('message', 'Add New Slider failed!!');
			}
		}
	}
	/*====================
	Edit Slider
	=====================*/
	public function slider_edit($id)
	{
		$data['slider'] = $this->adminmodel->getsliderByid($id);
		$old_image        = $data['slider']->slider_photo;

		$this->form_validation->set_rules('slider_link', 'Slider Link', 'trim');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/slider_edit',$data);
			$this->load->view('admin/footer');
		} else 
		{
			$info['slider_link'] = $this->input->post('slider_link');
			
			if($_FILES && $_FILES['slider_photo']['name'])
			{
				$img_info = [
					'upload_path' => 'images/slider',
					'image_name'  => 'slider_photo',
					'quality'     => '60%',
					'width'       => 1350,
					'height'      => 325
				];
				
				$image_link = './'.$old_image;
				if(file_exists($image_link))
				{
					unlink($image_link);
				}

                /*$tempPath=$_FILES["slider_photo"]["tmp_name"];
                $uploadTo = "./assets/images/slider/"; 
                 $imageName = $_FILES['slider_photo']['name'];
                    $basename = basename($imageName);
                    $originalPath = $uploadTo.$basename; 
                 $imageQuality= 60;
                 $info['slider_photo'] = compress_image($tempPath, $originalPath, $imageQuality);*/
                 $info['slider_photo'] = uploadAndResize($img_info);
               } else 
               {
               	$info['slider_photo'] = $old_image;
               }
               
               if($this->adminmodel->updateSlider($id,$info))
               {	
               	$this->session->set_flashdata('message', 'Successfully Updated Slider!!');
               	redirect('admin/slider_all','refresh');
               } else 
               {
               	$this->session->set_flashdata('message', 'Sorry, Slider Update failed!!');
               	redirect('admin/slider_edit', 'refresh');
               }
               

               
             }

           }

	/*====================
	Delete Slider
	=====================*/
	public function slider_delete($id)
	{
		if($this->adminmodel->deleteSlider($id))
		{	
			$this->session->set_flashdata('message', 'Slider has been Permanently Deleted!!!');
			redirect('admin/slider_all','refresh');
		} else 
		{
			redirect('admin/slider_all','refresh');
		}
	}


	/*==============
		 ENQUIRY
		 ==============*/

		 public function enquiries()
		 {
		 	$data['logged_id'] = NULL;
		 	$session 		   = $this->session->userdata('logged_user');
		 	$data['logged_id'] = $session['logged_id'];

		 	$data['enquiries'] = $this->adminmodel->getEnquiries();

		 	$this->load->view('admin/header');
		// $this->load->view('admin/inc/left_sidebar');
		 	$this->load->view('admin/all_enquiry',$data);
		// $this->load->view('user_right_sidebar');
		 	$this->load->view('admin/footer');
		 }

		 public function saved_enquiry()
		 {
		 	$data['logged_id'] = NULL;
		 	$session 		   = $this->session->userdata('logged_user');
		 	$data['logged_id'] = $session['logged_id'];

		 	$data['enquiries'] = $this->adminmodel->savedEnquiry();

		 	$this->load->view('admin/header');
		// $this->load->view('admin/inc/left_sidebar');
		 	$this->load->view('admin/saved_enquiries',$data);
		// $this->load->view('user_right_sidebar');
		 	$this->load->view('admin/footer');
		 }

		 public function delete_enquiry($id)
		 {
		 	if($this->adminmodel->deleteEnquiry($id))
		 	{
		 		redirect('admin/enquiries','refresh');
		 	} else 
		 	{
		 		redirect('admin/enquiries','refresh');
		 	}		
		 }

		 public function delete_saved_enquiry($id)
		 {
		 	if($this->adminmodel->deleteEnquiry($id))
		 	{
		 		redirect('admin/saved-enquiry','refresh');
		 	} else 
		 	{
		 		redirect('admin/saved-enquiry','refresh');
		 	}		
		 }

	/*==========================================
		ACTIVE/INACTIVE STATUS UPDATE FUNCTION
		==========================================*/
		
		public function update_status()
		{
			$id = $this->input->post('id');
			$fieldName = $this->input->post('fieldName');
			$selectedValue = $this->input->post('value');
			$tableName = $this->input->post('tableName');
			$tableID = $this->input->post('tableIdName');

			$data = $this->adminmodel->getSingleAjaxValue($id,$tableID,$tableName);

			$data[$fieldName] = $selectedValue;

			if ($this->db->where($tableID,$id)->update($tableName,$data)) {
				$update['message'] = 'success';
				$this->session->set_flashdata('message', 'Status Updated Successfully!');
			} else 
			{
				$update['message'] = 'error';
				$this->session->set_flashdata('message', 'Status Update Unsuccessful!');
			}
			echo json_encode($update);
		}


		public function claimed_listings()
		{
			$data['logged_id'] = NULL;
			$session 		   = $this->session->userdata('logged_user');
			$data['logged_id'] = $session['logged_id'];

			$data['listing_requests'] = $this->usermodel->getAllValues('claim_listings');

			$this->load->view('admin/header');
		// $this->load->view('user_left_sidebar');
			$this->load->view('admin/claim_listing',$data);
		// $this->load->view('user_right_sidebar');
			$this->load->view('admin/footer');		
		}

		public function claim_approve($id)
		{
			$claimListing = $this->db->select('*')->from('claim_listings')->where('claim_listing_id',$id)->get()->row_array();
			
			$getSingleListing = $this->db->select('*')->from('listings')->where('listing_id',$claimListing['listing_id'])->get()->row_array();

			$lisitngID = '';

			if ($getSingleListing != NULL) {

				$listing_id = $getSingleListing['listing_id'];

				$claimListing['claim_status'] = 1;
				unset($getSingleListing['listing_id']);
				$getSingleListing['user_id'] = $claimListing['enquiry_sender_id'];
				if ($this->db->where('claim_listing_id',$id)->update('claim_listings',$claimListing)) {

					if($this->db->where('listing_id',$listing_id)->update('listings',$getSingleListing)){
						$this->session->set_flashdata('message', 'Successfully Status Updated !');
						redirect('admin/claimed-listings','refresh');
					}
				} else 
				{
					$this->session->set_flashdata('message', 'Status Update Unsuccessful!');
					redirect('admin/claimed-listings','refresh');
				}

			}
		}

		public function delete_claim($id)
		{
			if($this->adminmodel->deleteClaim($id))
			{
				$this->session->set_flashdata('message', 'Claim has been Permanently Deleted!!!');
				redirect('admin/claimed-listings','refresh');
			} else {
				$this->session->set_flashdata('message', 'Claim Delete Failed!');
				redirect('admin/claimed-listings','refresh');
			}
		}



	/*================================
		ALL ADS FUNCTION
		================================*/
		public function current_ads()
		{
			$data['logged_id'] 	= NULL;
			$session  			= $this->session->userdata('logged_user');
			$data['logged_id'] 	= $session['logged_id'];

			$data['ads'] 		= $this->adminmodel->getAllAds();

			$this->load->view('admin/header',$data);
			$this->load->view('admin/current_ads');
			$this->load->view('admin/footer');
		}
		/* Ads Add*/
		public function create_ads()
		{
			$data['logged_id'] 	= NULL;
			$session  			= $this->session->userdata('logged_user');
			$data['logged_id'] 	= $session['logged_id'];

			$data['users'] 		= $this->adminmodel->getAllValues('user');
			$data['adsPrices'] 	= $this->adminmodel->allAdsPrices();

			$width = $height = 0;

			$this->form_validation->set_rules('user_id', 'User', 'trim|required');
			$this->form_validation->set_rules('ads_price_id', 'Ads Position', 'trim|required');
			$this->form_validation->set_rules('ad_start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('ad_end_date', 'End Date', 'trim|required');
			$this->form_validation->set_rules('ad_link', 'Ads Link', 'trim|required');
			$this->form_validation->set_rules('ad_total_days', 'Total Days', 'trim|required');
			$this->form_validation->set_rules('ad_cost_per_day', 'Cost Per Day', 'trim|required');
			$this->form_validation->set_rules('ad_total_cost', 'Total Cost', 'trim|required');

			if($this->form_validation->run() == false)
			{
				$this->load->view('admin/header',$data);
				$this->load->view('admin/create_ads');
				$this->load->view('admin/footer');	        
			} else {
				$info = array(
					'u_id'		 		=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'ads_price_id'   	=> htmlentities($this->input->post('ads_price_id'), ENT_QUOTES),
					'ad_start_date'  	=> date('Y-m-d h:i:s',strtotime($this->input->post('ad_start_date'))),
					'ad_end_date'    	=> date('Y-m-d h:i:s',strtotime($this->input->post('ad_end_date'))),
					'ad_link'   		=> htmlentities($this->input->post('ad_link'), ENT_QUOTES),
					'ad_total_days'   	=> htmlentities($this->input->post('ad_total_days'), ENT_QUOTES),
					'ad_cost_per_day' 	=> htmlentities($this->input->post('ad_cost_per_day'), ENT_QUOTES),
					'ad_total_cost'   	=> htmlentities($this->input->post('ad_total_cost'), ENT_QUOTES),
					'photo_width'		=> htmlentities($this->input->post('ad_width'), ENT_QUOTES),
					'photo_height'      => htmlentities($this->input->post('ad_height'), ENT_QUOTES)
				);			

				if($_FILES && $_FILES['ad_photo']['name'])
				{
					$img_info = [
						'upload_path' => 'images/ads/main',
						'quality'     => '60%',
						'height'      => $info['photo_height'],
						'width'       => $info['photo_width'],
						'image_name'  => 'ad_photo'
					];
					$info['ad_photo'] = uploadAndResize($img_info);
				}

				if($this->adminmodel->add('ads',$info))
				{
					$this->session->set_flashdata('message', 'Ads Added Successfully!!');
					redirect('admin/current-ads');
				}
				else 
				{
					$this->session->set_flashdata('message', 'Failed to add Ads!!');
				}	            
			}
		}

		/* Ads edit*/
		public function ads_edit($id)
		{
			$data['logged_id'] 	= NULL;
			$session  			= $this->session->userdata('logged_user');
			$data['logged_id'] 	= $session['logged_id'];

			$data['users'] 		= $this->adminmodel->getAllValues('user');
			$data['adsPrices'] 	= $this->adminmodel->allAdsPrices();
			$data['ad']			= $this->adminmodel->getSingleValue($id,'id','ads');		
			$old_image        	= $data['ad']->ad_photo;

			$this->form_validation->set_rules('user_id', 'User', 'trim|required');
			$this->form_validation->set_rules('ads_price_id', 'Ads Position', 'trim|required');
			$this->form_validation->set_rules('ad_start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('ad_end_date', 'End Date', 'trim|required');
			$this->form_validation->set_rules('ad_link', 'Ads Link', 'trim|required');
			$this->form_validation->set_rules('ad_total_days', 'Total Days', 'trim|required');
			$this->form_validation->set_rules('ad_cost_per_day', 'Cost Per Day', 'trim|required');
			$this->form_validation->set_rules('ad_total_cost', 'Total Cost', 'trim|required');

			if($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/header',$data);
				$this->load->view('admin/ads_edit');
				$this->load->view('admin/footer');
			} else 
			{
				$info = array(
					'u_id'		 		=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
					'ads_price_id'   	=> htmlentities($this->input->post('ads_price_id'), ENT_QUOTES),
					'ad_start_date'  	=> date('Y-m-d h:i:s',strtotime($this->input->post('ad_start_date'))),
					'ad_end_date'    	=> date('Y-m-d h:i:s',strtotime($this->input->post('ad_end_date'))),
					'ad_link'   		=> htmlentities($this->input->post('ad_link'), ENT_QUOTES),
					'ad_total_days'   	=> htmlentities($this->input->post('ad_total_days'), ENT_QUOTES),
					'ad_cost_per_day' 	=> htmlentities($this->input->post('ad_cost_per_day'), ENT_QUOTES),
					'ad_total_cost'   	=> htmlentities($this->input->post('ad_total_cost'), ENT_QUOTES),
					'photo_width'		=> htmlentities($this->input->post('ad_width'), ENT_QUOTES),
					'photo_height'      => htmlentities($this->input->post('ad_height'), ENT_QUOTES)
				);

				if($_FILES && $_FILES['ad_photo']['name'])
				{
					$img_info = [
						'upload_path' => 'images/ads/main',
						'image_name'  => 'ad_photo',
						'quality'     => '60%',
						'height'      => $info['photo_height'],
						'width'       => $info['photo_width'],
					];

					$image_link = './'.$old_image;
					if(file_exists($image_link))
					{
						unlink($image_link);
					}

					$info['ad_photo'] = uploadAndResize($img_info);
				} else 
				{
					$info['ad_photo'] = $old_image;
				}

				if($this->adminmodel->update($id,$info,'id','ads'))
				{	
					$this->session->set_flashdata('message', 'Ads Updated Successfully!!');
					redirect('admin/current-ads','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Ads Update failed!!');
					redirect('admin/ads-edit/'.$id, 'refresh');
				}
			}
		}

		public function ads_delete($id)
		{
			if($this->adminmodel->deleteAds($id))
			{
				$this->session->set_flashdata('message', 'Ads has been Permanently Deleted!!!');
				redirect('admin/current-ads','refresh');
			} else {
				$this->session->set_flashdata('message', 'Ads  Delete Failed!');
				redirect('admin/current-ads','refresh');
			}
		}

		/* Ads Price*/
		public function ads_price()
		{
			$data['logged_id'] 	= NULL;
			$session  			= $this->session->userdata('logged_user');
			$data['logged_id'] 	= $session['logged_id'];

			$data['prices']		= $this->adminmodel->allAdsPrices();

			$this->load->view('admin/header',$data);
			$this->load->view('admin/ads_price');
			$this->load->view('admin/footer');
		}
		/* Ads Price Create*/
		public function create_ads_price()
		{
			$data['logged_id'] 	= NULL;
			$session  			= $this->session->userdata('logged_user');
			$data['logged_id'] 	= $session['logged_id'];

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('width', 'Ad Width', 'trim|required');
			$this->form_validation->set_rules('height', 'Ad Height', 'trim|required');
			$this->form_validation->set_rules('cost', 'Cost', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/header',$data);
				$this->load->view('admin/create_ads_price');
				$this->load->view('admin/footer');
			} else 
			{
				$info = array(
					'name'		=> htmlentities($this->input->post('name'), ENT_QUOTES),
					'cost'    	=> htmlentities($this->input->post('cost'), ENT_QUOTES),
					'size'		=> htmlentities($this->input->post('width'), ENT_QUOTES).'X'.htmlentities($this->input->post('height'), ENT_QUOTES).' px',
					'height'	=> htmlentities($this->input->post('height'), ENT_QUOTES),
					'width'		=> htmlentities($this->input->post('width'), ENT_QUOTES),
					'status'    => htmlentities($this->input->post('status'), ENT_QUOTES)
				);

				if($_FILES && $_FILES['img']['name'])
				{
					$img_info = [
						'upload_path' => 'images/ads',
						'image_name'  => 'img',
						'quality'     => '60%',
						'width'       => $info['width'],
						'height'      => $info['height']
					];				

					$info['img'] = uploadAndResize($img_info);
				}

				if($this->adminmodel->add('ads_prices',$info))
				{	
					$this->session->set_flashdata('message', 'Ads Price has been Successfully Added!!');
					redirect('admin/ads-price','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Error Adding Ads Price!!');
					redirect('admin/create-ads-price');
				}
			}
		}

		/* Ads Price Edit*/
		public function ads_price_edit($id)
		{
			$data['logged_id'] 	= NULL;
			$session  			= $this->session->userdata('logged_user');
			$data['logged_id'] 	= $session['logged_id'];

			$data['price']		= $this->adminmodel->getAdsPrice($id);		
			$old_image        	= $data['price']->img;

			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('width', 'Ad Width', 'trim|required');
			$this->form_validation->set_rules('height', 'Ad Height', 'trim|required');
			$this->form_validation->set_rules('cost', 'Cost', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/header',$data);
				$this->load->view('admin/ads_price_edit');
				$this->load->view('admin/footer');
			} else 
			{
				$info = array(
					'name'		=> htmlentities($this->input->post('name'), ENT_QUOTES),
					'cost'    	=> htmlentities($this->input->post('cost'), ENT_QUOTES),
					'size'		=> htmlentities($this->input->post('width'), ENT_QUOTES).'X'.htmlentities($this->input->post('height'), ENT_QUOTES).' px',
					'height'	=> htmlentities($this->input->post('height'), ENT_QUOTES),
					'width'		=> htmlentities($this->input->post('width'), ENT_QUOTES),
					'status'    => htmlentities($this->input->post('status'), ENT_QUOTES)
				);

				if($_FILES && $_FILES['img']['name'])
				{
					$img_info = [
						'upload_path' => 'images/ads',
						'image_name'  => 'img',
						'quality'     => '60%',
						'width'       => $info['width'],
						'height'      => $info['height']
					];

					$image_link = './'.$old_image;
					if(file_exists($image_link))
					{
						if(file_exists($image_link)){
							unlink($image_link);
						}
					}

					$info['img'] = uploadAndResize($img_info);
				} else 
				{
					$info['img'] = $old_image;
				}

				if($this->adminmodel->updateAdsPrice($id,$info))
				{	
					$this->session->set_flashdata('message', 'Successfully Updated Ads Price!!');
					redirect('admin/ads-price','refresh');
				} else 
				{
					$this->session->set_flashdata('message', 'Sorry, Ads Price Update failed!!');
					redirect('admin/ads-price-edit/'.$id, 'refresh');
				}
			}
		}
		/* Ads Request*/
		public function ads_request()
		{
			$data['logged_id'] 	= NULL;
			$session  			= $this->session->userdata('logged_user');
			$data['logged_id'] 	= $session['logged_id'];

			$data['ads'] 		= $this->adminmodel->getAllInactiveAds();

			$this->load->view('admin/header',$data);
			$this->load->view('admin/ads_request');
			$this->load->view('admin/footer');
		}
		/* Ads History*/
		public function ads_history()
		{
			$data['logged_id'] 	= NULL;
			$session  			= $this->session->userdata('logged_user');
			$data['logged_id'] 	= $session['logged_id'];

			$data['ads'] 		= $this->adminmodel->getAllAdsHistory();

			$this->load->view('admin/header',$data);
			$this->load->view('admin/ads_history');
			$this->load->view('admin/footer');
		}
		public function ads_history_delete($id)
		{
			if($this->adminmodel->deleteAds($id))
			{
				$this->session->set_flashdata('message', 'Ad has been Permanently Deleted!!!');
				redirect('admin/ads-history','refresh');
			} else {
				$this->session->set_flashdata('message', 'Ad Delete Failed!');
				redirect('admin/ads-history','refresh');
			}
		}

	/*==========================================
	 ADS ACTIVE/INACTIVE STATUS UPDATE FUNCTION
	 ==========================================*/
	 
	 public function approveAdStatus()
	 {
	 	$id = $this->input->post('id');
	 	$statusValue = $this->input->post('status');

	 	$data = $this->adminmodel->getSingleAdsAjaxValue($id);

	 	$data['ad_status'] = 1;

	 	if ($this->db->where('id',$id)->update('ads',$data)) {
	 		$update['message'] = 'success';
	 		$this->session->set_flashdata('message', 'Status Updated Successfully!');
	 	} else 
	 	{
	 		$update['message'] = 'error';
	 		$this->session->set_flashdata('message', 'Status Update Unsuccessful!');
	 	}
	 	echo json_encode($update);
	 }	
	}
