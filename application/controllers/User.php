<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class User extends CI_Controller {



	public function __construct()

	{

		parent::__construct();
		$this->load->model('usermodel');
		$this->load->model('adminmodel');
		$this->load->library('pagination');



		if(isset($_POST['logout'])){
			$this->session->unset_userdata('logged_user');
			$this->session->sess_destroy();
			redirect(base_url()); die();
		}

		/*Page Access Prevention*/

		$page = $this->router->fetch_method();

		if ($page != 'register' && $page != 'login' && $page != 'index' && $page != 'forget_password' && $page != 'all_category'&& $page != 'all_listing'&& $page != 'listing_preview'&& $page != 'all_blog' && $page != 'event' && $page != 'all_products' && $page != 'product_details' && $page != 'event_details' && $page != 'blog_details' && $page != 'news_details' && $page != 'news_lists' && $page != 'listing_details_n' && $page != 'pricing_n' && $page != 'listing_list_n' && $page != 'event_details_n') {

			if(!$this->session->userdata('logged_user')){ 

				redirect(base_url()); die(); 

			}

		}
		//if($this->session->userdata('logged_admin')){ redirect('dashboard'); die(); }
	}





	/*Home Page*/

	public function index()
	{
		$data['spolight_listing']= $this->usermodel->getSpotlightListing('listings','5', 'spotlight');
		$data['featured_listing']= $this->usermodel->getFeaturedListing('listings','6', 'featured');
		$data['categories'] = $this->usermodel->getDashboardCategories()->get()->result();
		$data['events'] 	= $this->usermodel->getDashboardEvents();
		$data['products'] 	= $this->usermodel->getDashboardProducts();
		$data['slide_latest_news']= $this->usermodel->getlatest_news('3');
		$data['latest_5news']= $this->usermodel->getlatest_news('5');
		$data['specialAndCoupons']= $this->usermodel->getListingByCategory('39','5', NULL);
		$data['LatestEvents']= $this->usermodel->getlatest_events('6');
		$data['hpbsl']		= $this->usermodel->getHPBSLAds();
		$data['hpbsr']		= $this->usermodel->getHPBSRAds();
		$data['fbr1']		= $this->usermodel->getFBR1Ads();
		$data['fbr2']		= $this->usermodel->getFBR2Ads();
		$data['fbr3']		= $this->usermodel->getFBR3Ads();
		$data['afl']		= $this->usermodel->getAFLAds();
		
		$this->load->view('header',$data);
		$this->load->view('index');
		$this->load->view('footer');

	}



	/*All Product*/

	public function all_products(){

		if($this->session->userdata('logged_user')){ 

			$data['user'] = $this->usermodel->getUserInformation();

		}

		$data['AllProduct'] = $this->usermodel->getAllProduct();



		$data['title'] = "Pearland | All Products";



		$this->load->view('header');

		$this->load->view('all-products',$data);

		$this->load->view('footer');

	}



	/*All Category*/

	public function all_category(){

		if($this->session->userdata('logged_user')){ 

			$data['user'] = $this->usermodel->getUserInformation();

		}

		

		$data['AllCategory'] = $this->usermodel->getAllCategory();



		$data['title'] = "Pearland | All Category";



		$this->load->view('header');

		$this->load->view('all-category',$data);

		$this->load->view('footer');

	}

	

	/*All Category Listings*/

	public function all_listing($cat_id = Null)
	{

		$data['allCategories']  = $this->usermodel->getAllListingCategory();

		if($this->session->userdata('logged_user')){ 
			$data['user'] = $this->usermodel->getUserInformation();
		}

		// $data['allListings'] = $this->usermodel->getListingByCategory($cat_id);

		$config = [
			'base_url' => base_url('user/all_listing/'.$cat_id),
			'per_page' => 10,
			'total_rows'=> count($this->usermodel->getListingByCategory($cat_id,NULL, NULL))
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

		$data['allListings']   = $this->usermodel->getListingByCategory($cat_id,$config['per_page'],$this->uri->segment(4)); 
		$data['link'] 		   = $this->pagination->create_links();
		$data['title'] = "Pearland | All Listings";
		$data['randListings']  = $this->usermodel->getRandFiveFeatureListing();

		$this->load->view('header',$data);
		$this->load->view('all-listing');
		$this->load->view('footer');
	}


	/*All Blog Post*/

	public function all_blog(){

		if($this->session->userdata('logged_user')){ 

			$data['user'] = $this->usermodel->getUserInformation();

		}

		// $data['user'] = $this->usermodel->getUserInformation();

		$data['AllBlog'] = $this->usermodel->getAllBlog();



		$data['title'] = "Pearland | All Blog";



		$this->load->view('header');

		$this->load->view('blog-posts',$data);

		$this->load->view('footer');

	}

	/*All Event Post*/

	public function event(){

		if($this->session->userdata('logged_user')){ 

			$data['user'] = $this->usermodel->getUserInformation();

		}

		$data['Allevent'] = $this->usermodel->getAllEvent();



		$data['title'] = "Pearland | All Event";



		$this->load->view('header');

		$this->load->view('events',$data);

		$this->load->view('footer');

	}



	/*Regitration*/

	public function register()

	{

		

		if(isset($_POST['register_submit'])){/*Registration Action*/

			//Register User If data valid

			$data['registrationSucess'] = $this->usermodel->registerUser(); 

			if ($data['registrationSucess']['status']) {

				$data['reset'] = TRUE;

			}else{

				$data['reset'] = FALSE;

			}

		}else{

			$data['registrationSucess'] = array('status'=>FALSE, 'referror'=>'');

			$data['reset'] = FALSE;

		}		

		$data['title'] = "Pearland | Registration";

		$this->load->view('header',$data);

		$this->load->view('register');

		$this->load->view('footer');

	}



	/*Login*/

	public function login()

	{

		if($this->session->userdata('logged_user')){ 

			redirect('dashboard');

		}

		if(isset($_POST['login_submit'])){/*Registration Action*/

			//Register User If data valid

			$data['loginSucess'] = $this->usermodel->login(); 

			if ($data['loginSucess']['status']) {

				redirect($data['loginSucess']['url']);

			}else{

				$data['reset'] = FALSE;

			}

		}else{

			$data['loginSucess'] = array('status'=>FALSE,'message' => '', 'referror'=>'');

			$data['reset'] = FALSE;

		}	

		$this->load->view('header',$data);

		$this->load->view('login');

		$this->load->view('footer');

	}



	/*Forget Password*/

	public function forgot_password()

	{

		$this->load->view('header');

		$this->load->view('forgot_password');

		$this->load->view('footer');

	}



	/*Logout*/

	public function logout()

	{

		$this->session->unset_userdata('logged_user');

		$this->session->sess_destroy();

		redirect(base_url()); die();

	}







	/******* After User Login All Controller Below ***********/

	



	/*====================

	Dashboard

	=====================*/

	public function dashboard(){

		$data['logged_id'] = NULL;		

		if($this->session->userdata('logged_user')){ 

			$session 		   = $this->session->userdata('logged_user');

			$data['logged_id'] = $session['logged_id'];

		}

		$data['user'] = $this->usermodel->getUserInformation();

		$data['AllListings'] = $this->usermodel->getListingById($data['logged_id'],10,NULL);

		$data['AllEvents'] = $this->usermodel->dashboardInfo('events','event_status',0,NULL);

		$data['AllBlogs'] = $this->usermodel->dashboardInfo('blogs','blog_status',0,NULL);





		$data['title'] = "Pearland | Dashboard";



		$this->load->view('header',$data);

		$this->load->view('user_left_sidebar');

		$this->load->view('user_dashboard');

		$this->load->view('user_right_sidebar');

		$this->load->view('footer');

	}

	





	/*User Profile*/

	public function my_profile()

	{

		$this->load->view('header');
		$this->load->view('user_left_sidebar');
		$this->load->view('my_profile');
		$this->load->view('user_right_sidebar');
		$this->load->view('footer');

	}

	



	/*======================
	    USER LISTING
	======================*/

	/*All Listing*/

    public function user_listing()
    {		
    	$data['logged_id'] = NULL;	

    	if($this->session->userdata('logged_user')){ 
    		$session 		   = $this->session->userdata('logged_user');
    		$data['logged_id'] = $session['logged_id'];
    	}

		// $data['AllListings'] = $this->usermodel->getAllListings();	
    	$config = [
    		'base_url' => base_url('user/user_listing/'.$data['logged_id']),
    		'per_page' => 10,
    		'total_rows'=> count($this->usermodel->getListingById($data['logged_id'],NULL, NULL))
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

    	$data['AllListings']   = $this->usermodel->getListingById($data['logged_id'],$config['per_page'],$this->uri->segment(4)); 

    	$data['link'] 		   = $this->pagination->create_links();

    	$this->load->view('header');
    	$this->load->view('user_left_sidebar');
    	$this->load->view('user_listing',$data);
    	$this->load->view('user_right_sidebar');
    	$this->load->view('footer');
    }

	/*listing Preview */
	public function listing_preview($listing_id)
	{ 
		$data['logged_id'] = NULL;		

		if($this->session->userdata('logged_user')){ 
			$session 		   = $this->session->userdata('logged_user');
			$data['logged_id'] = $session['logged_id'];
		}

		$data['listing'] = $this->usermodel->getSingleValue($listing_id,'listing_slug','listings');
		
		$data['RelatedListing'] = $this->usermodel->getRelatedListing('listings',$listing_id,$data['listing']->category_id);

		$this->load->view('header');
		$this->load->view('listing_details',$data);
		$this->load->view('footer');			
	}

    /*Add Listing*/
    public function add_new_listing_start()
    {
    	$data['listings'] = $this->usermodel->getListingsList();

    	$this->load->view('header');
    	$this->load->view('user_add_listing_start',$data);
    	$this->load->view('footer');
    }

    public function duplicate_listing()
    {
    	$old_listing_id = $this->input->post('listing_id');
    	$new_listing_name = $this->input->post('listing_name');
		$listing_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('listing_name'));


    	$getOldData = $this->usermodel->getListingSingleValue($old_listing_id,'listing_id','listings');

    	unset($getOldData[0]['listing_id']);

    	$getOldData[0]['listing_name'] = $new_listing_name;
    	$getOldData[0]['listing_status']= 0;
    	$getOldData[0]['listing_slug']  = $listing_slug;

    	if($this->usermodel->addDuplicateListing('listings',$getOldData[0]))
    	{
    		$this->session->set_flashdata('message', 'Successfully Duplicated Listing!!');
    		redirect('user/user-listing');
    	}
    	else 
    	{
    		$this->session->set_flashdata('message', 'Duplicating Listing Failed!!');
    		redirect('user/user-listing');
    	}
    }

	/*====================
		Add New Listing
	=====================*/
	public function add_listing_scratch()
	{
		$data['categories'] = $this->usermodel->getAllValues('listing_categories');

		if($this->form_validation->run('user_listing_scratch') == FALSE)
		{	        
			$this->load->view('header',$data);
			$this->load->view('add_new_listing_start');
			$this->load->view('footer');
		} else 
		{
			$listing_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('listing_name'));

			$info = array(
				'listing_name'		=> $this->input->post('listing_name'),
				'category_id'		=> $this->input->post('category_id'),
				'sub_category_id'	=> $this->input->post('sub_category_id'),
				'listing_mobile'	=> $this->input->post('listing_mobile'),
				'listing_whatsapp'	=> $this->input->post('listing_whatsapp'),
				'display_phone'		=> $this->input->post('display_phone'),
				'listing_email'		=> $this->input->post('listing_email'),
				'listing_website'	=> $this->input->post('listing_website'),
				'listing_address'	=> $this->input->post('listing_address'),
				'county_name'		=> $this->input->post('county_name'),
				'postal_code'		=> $this->input->post('postal_code'),
				'listing_lat'		=> $this->input->post('listing_lat'),
				'listing_lng'		=> $this->input->post('listing_lng'),
				'display_address'	=> $this->input->post('display_address'),
				'listing_description'=> $this->input->post('listing_description'),
				'service_locations'	=> $this->input->post('service_locations'),
				'service_offered'	=> $this->input->post('service_offered'),
				'listing_video'		=> $this->input->post('listing_video'),
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
					'height'      => 500,
					'width'       => 500,
					'image_name'  => 'listing_profile_image'
				];

				$info['listing_image'] = uploadAndResize($img_info);
			}

			if($this->usermodel->addListing($info)){
				$this->session->set_flashdata('message', 'Lisitng Added Successfully.');
				redirect('user/user-listing','refresh');
			}else{
				redirect('user/add-listing-scratch', 'refresh');
			}
		}
	}


	/*===================
		Edit Listing
	===================*/
	public function edit_listing($slug)
	{
		$data['categories'] 	= $this->usermodel->getAllValues('listing_categories');
		$data['listing_slug']	= $slug;
		$data['listing'] 		= $this->usermodel->getSingleValue($slug,'listing_slug','listings');

		if($data['listing']->category_id != ''){
			$data['sub_category_listing'] = $this->adminmodel->ListingSubCategoryByCateId($data['listing']->category_id);
		}

		if($this->form_validation->run('user_listing_scratch') == FALSE)
		{	        
			$this->load->view('header',$data);
			$this->load->view('edit_listings');
			$this->load->view('footer');
		} else 
		{
			$listing_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('listing_name'));

			$info = array(
				'listing_name'		=> $this->input->post('listing_name'),
				'category_id'		=> $this->input->post('category_id'),
				'sub_category_id'	=> $this->input->post('sub_category_id'),
				'listing_mobile'	=> $this->input->post('listing_mobile'),
				'listing_whatsapp'	=> $this->input->post('listing_whatsapp'),
				'display_phone'		=> $this->input->post('display_phone'),
				'listing_email'		=> $this->input->post('listing_email'),
				'listing_website'	=> $this->input->post('listing_website'),
				'listing_address'	=> $this->input->post('listing_address'),
				'county_name'		=> $this->input->post('county_name'),
				'postal_code'		=> $this->input->post('postal_code'),
				'listing_lat'		=> $this->input->post('listing_lat'),
				'listing_lng'		=> $this->input->post('listing_lng'),
				'display_address'	=> $this->input->post('display_address'),
				'listing_description'=> $this->input->post('listing_description'),
				'service_locations'	=> $this->input->post('service_locations'),
				'service_offered'	=> $this->input->post('service_offered'),
				'listing_video'		=> $this->input->post('listing_video'),
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
					'height'      => 500,
					'width'       => 500,
					'image_name'  => 'listing_profile_image'
				];

				$info['listing_image'] = uploadAndResize($img_info);
			}

			if($this->usermodel->update($slug,$info,'listing_slug','listings'))
			{
				$this->session->set_flashdata('message', 'Lisitng Updated Successfully.');
				redirect('user/user-listing','refresh');
			}
			else 
			{
				redirect('user/edit-listing/'.$id);
			}	
		}
	}

	    //   public function add_listing_step_1()

	    //   {

	    //   	$data['categories'] = $this->usermodel->getAllValues('listing_categories');

		// 	//$data['sub-category'] = $this->usermodel->getAllSubCategory($data['category']->category_id);







	    //   	if($this->form_validation->run('listing_step_1') == FALSE)

	    //   	{	        

	    //   		$this->load->view('header');

	    //   		$this->load->view('add_listing_step_1',$data);

	    //   		$this->load->view('footer');

	    //   	} else 

	    //   	{

	    //   		$info = array(

	    //   			'listing_name' 		=> htmlentities($this->input->post('listing_name'), ENT_QUOTES), 

	    //   			'listing_mobile'	=> htmlentities($this->input->post('listing_mobile'), ENT_QUOTES),

	    //   			'listing_email'		=> htmlentities($this->input->post('listing_email'), ENT_QUOTES),

	    //   			'listing_whatsapp'	=> htmlentities($this->input->post('listing_whatsapp'), ENT_QUOTES),

	    //   			'listing_website'	=> htmlentities($this->input->post('listing_website'), ENT_QUOTES),

	    //   			'listing_address'	=> htmlentities($this->input->post('listing_address'), ENT_QUOTES),

	    //   			'listing_lat'		=> htmlentities($this->input->post('listing_lat'), ENT_QUOTES),

	    //   			'listing_lng'		=> htmlentities($this->input->post('listing_lng'), ENT_QUOTES),

	    //   			'country_name'		=> htmlentities($this->input->post('country_name'), ENT_QUOTES),

	    //   			'city_name'			=> htmlentities($this->input->post('city_name'), ENT_QUOTES),

	    //   			'category_id'		=> htmlentities($this->input->post('category_id'), ENT_QUOTES),

		// 		// 'sub_category_id'=>

	    //   			'listing_description'=> $this->input->post('listing_description'),

	    //   			'service_locations' => $this->input->post('service_locations'),

	    //   		);

	    //   		if($_FILES && $_FILES['profile_image']['name'])

	    //   		{

	    //   			$img_info = [

	    //   				'upload_path' => 'images/listings',

	    //   				'quality'     => '60%',

	    //   				'height'      => 500,

	    //   				'width'       => 500,

	    //   				'image_name'  => 'profile_image'

	    //   			];

	    //   			$info['profile_image'] = uploadAndResize($img_info);

	    //   		}

	    //   		if($_FILES && $_FILES['cover_image']['name'])

	    //   		{

	    //   			$img_info = [

	    //   				'upload_path' => 'images/listings',

	    //   				'quality'     => '60%',

	    //   				'height'      => 400,

	    //   				'width'       => 1000,

	    //   				'image_name'  => 'cover_image'

	    //   			];

	    //   			$info['cover_image'] = uploadAndResize($img_info);

	    //   		}



	    //   		$inserted_id = $this->usermodel->addListing('listings',$info);

	    //   		if($inserted_id > 0)

	    //   		{

		// 		// $this->session->set_flashdata('message', 'Successfully Added Listing!!');

	    //   			redirect('user/add_listing_step_2/'.$inserted_id);

	    //   		}

	    //   		else 

	    //   		{

		// 		// $this->session->set_flashdata('message', 'Adding Listing Failed!!');

	    //   			redirect('user/add_listing_step_1');

	    //   		}	

	    //   	}

	    //   }



	    //   public function add_listing_step_2($inserted_id = NULL)

	    //   {

	    //   	$data['listing_id'] = $inserted_id;

	    //   	if($this->form_validation->run('listing_step_2') == FALSE)

	    //   	{	        

	    //   		$this->load->view('header');

	    //   		$this->load->view('add_listing_step_2',$data);

	    //   		$this->load->view('footer');

	    //   	} else 

	    //   	{

	    //   		$inserted_id = htmlentities($this->input->post('listing_id'), ENT_QUOTES);

	    //   		$info = array(

	    //   			'service_name' 		=> htmlentities($this->input->post('service_name'), ENT_QUOTES), 

	    //   		);

	    //   		if($_FILES && $_FILES['service_image']['name'])

	    //   		{

	    //   			$img_info = [

	    //   				'upload_path' => 'images/listings',

	    //   				'quality'     => '60%',

	    //   				'height'      => 500,

	    //   				'width'       => 500,

	    //   				'image_name'  => 'service_image'

	    //   			];

	    //   			$info['service_image'] = uploadAndResize($img_info);

	    //   		}



	    //   		if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

	    //   		{

	    //   			redirect('user/add_listing_step_3/'.$inserted_id);

	    //   		}

	    //   		else 

	    //   		{

	    //   			redirect('user/add_listing_step_2/'.$inserted_id);

	    //   		}	

	    //   	}

	    //   }



	    //   public function add_listing_step_3($inserted_id = NULL)

	    //   {

	    //   	$data['listing_id'] = $inserted_id;

	    //   	if($this->form_validation->run('listing_step_3') == FALSE)

	    //   	{	        

	    //   		$this->load->view('header');

	    //   		$this->load->view('add_listing_step_3',$data);

	    //   		$this->load->view('footer');

	    //   	} else 

	    //   	{

	    //   		$inserted_id = htmlentities($this->input->post('listing_id'), ENT_QUOTES);



	    //   		$info = array(

	    //   			'service_1_name' 		=> htmlentities($this->input->post('service_1_name'), ENT_QUOTES), 

	    //   			'service_1_price' 		=> htmlentities($this->input->post('service_1_price'), ENT_QUOTES), 

	    //   			'service_1_detail' 		=> htmlentities($this->input->post('service_1_detail'), ENT_QUOTES), 

	    //   			'service_1_view_more' 	=> htmlentities($this->input->post('service_1_view_more'), ENT_QUOTES), 

	    //   		);

	    //   		if($_FILES && $_FILES['service_1_image']['name'])

	    //   		{

	    //   			$img_info = [

	    //   				'upload_path' => 'images/listings',

	    //   				'quality'     => '60%',

	    //   				'height'      => 400,

	    //   				'width'       => 1000,

	    //   				'image_name'  => 'service_1_image'

	    //   			];

	    //   			$info['service_1_image'] = uploadAndResize($img_info);

	    //   		}



	    //   		if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

	    //   		{

	    //   			redirect('user/add_listing_step_4/'.$inserted_id);

	    //   		}

	    //   		else 

	    //   		{

	    //   			redirect('user/add_listing_step_3/'.$inserted_id);

	    //   		}	

	    //   	}

	    //   }	



	    //   public function add_listing_step_4($inserted_id = NULL)

	    //   {

	    //   	$data['listing_id'] = $inserted_id;



	    //   	if($this->form_validation->run('listing_step_4') == FALSE)

	    //   	{	        

	    //   		$this->load->view('header');

	    //   		$this->load->view('add_listing_step_4',$data);

	    //   		$this->load->view('footer');

	    //   	} else 

	    //   	{

	    //   		$inserted_id = htmlentities($this->input->post('listing_id'), ENT_QUOTES);





	    //   		$info = array(

	    //   			'google_map' 	=> htmlentities($this->input->post('google_map'), ENT_QUOTES), 

	    //   			'360_view' 		=> htmlentities($this->input->post('360_view'), ENT_QUOTES),  

	    //   		);

	    //   		if(!empty($this->input->post('listing_video')))

	    //   		{

	    //   			$info['listing_video'] = json_encode($this->input->post('listing_video'));

	    //   		}



	    //   		if($_FILES && $_FILES['gallery_image']['name'])

	    //   		{

	    //   			$img_info = [

	    //   				'upload_path' => 'images/listings',

	    //   				'quality'     => '60%',

	    //   				'height'      => 500,

	    //   				'width'       => 500,

	    //   				'image_name'  => 'gallery_image'

	    //   			];

	    //   			$info['gallery_image'] = uploadMultipleAndResize($img_info);

	    //   		}



	    //   		if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

	    //   		{

	    //   			redirect('user/add-listing-step-5/'.$inserted_id);

	    //   		}

	    //   		else 

	    //   		{

	    //   			redirect('user/add-listing-step-4/'.$inserted_id);

	    //   		}	

	    //   	}

	    //   }



	    //   public function add_listing_step_5($inserted_id = NULL)

	    //   {

	    //   	$data['listing_id'] = $inserted_id;



	    //   	if($this->form_validation->run('listing_step_5') == FALSE)

	    //   	{	        

	    //   		$this->load->view('header');

	    //   		$this->load->view('add_listing_step_5',$data);

	    //   		$this->load->view('footer');

	    //   	} else 

	    //   	{

	    //   		$info = array();

	    //   		$inserted_id = htmlentities($this->input->post('listing_id'), ENT_QUOTES);



	    //   		if(!empty($this->input->post('listing_info_question')))

	    //   		{

	    //   			$info['listing_info_question'] = json_encode($this->input->post('listing_info_question'));

	    //   		}



	    //   		if(!empty($this->input->post('listing_info_answer')))

	    //   		{

	    //   			$info['listing_info_answer'] = json_encode($this->input->post('listing_info_answer'));

	    //   		}

		// 	// echo "<pre>";

		// 	// var_dump($info);

		// 	// die();

	    //   		redirect('user/add-listing-step-6/'.$inserted_id);

		// 	// if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

		// 	// {

		// 	// 	redirect('user/add-listing-step-6/'.$inserted_id);

		// 	// }

		// 	// else 

		// 	// {

		// 	// 	redirect('user/add-listing-step-5/'.$inserted_id);

		// 	// }	

	    //   	}

	    //   }

	    //   public function add_listing_step_6($listing_id = NULL)

	    //   {

	    //   	$data['listing_id'] = $listing_id;



	    //   	$this->load->view('header');

	    //   	$this->load->view('add_listing_step_6',$data);

	    //   	$this->load->view('footer');

	    //   }



	/*Edit Listing*/



	public function edit_listing_step_1($inserted_id)

	{

		$data['categories'] = $this->usermodel->getAllValues('listing_categories');

		$data['listing_id']= $inserted_id;

		$data['listing'] = $this->usermodel->getSingleValue($inserted_id,'listing_id','listings');





		if($this->form_validation->run('listing_step_1') == FALSE)

		{	        

			$this->load->view('header');

			$this->load->view('edit_listing_step_1',$data);

			$this->load->view('footer');

		} else 

		{

			$info = array(

				'listing_name' 		=> htmlentities($this->input->post('listing_name'), ENT_QUOTES), 

				'listing_mobile'	=> htmlentities($this->input->post('listing_mobile'), ENT_QUOTES),

				'listing_email'		=> htmlentities($this->input->post('listing_email'), ENT_QUOTES),

				'listing_whatsapp'	=> htmlentities($this->input->post('listing_whatsapp'), ENT_QUOTES),

				'listing_website'	=> htmlentities($this->input->post('listing_website'), ENT_QUOTES),

				'listing_address'	=> htmlentities($this->input->post('listing_address'), ENT_QUOTES),

				'listing_lat'		=> htmlentities($this->input->post('listing_lat'), ENT_QUOTES),

				'listing_lng'		=> htmlentities($this->input->post('listing_lng'), ENT_QUOTES),

				'country_id'		=> htmlentities($this->input->post('country_id'), ENT_QUOTES),

				'city_name'			=> htmlentities($this->input->post('city_name'), ENT_QUOTES),

				'category_id'		=> htmlentities($this->input->post('category_id'), ENT_QUOTES),

				// 'sub_category_id'=>

				'listing_description'=> $this->input->post('listing_description'),

				'service_locations' => $this->input->post('service_locations'),

			);

			if($_FILES && $_FILES['profile_image']['name'])

			{

				$img_info = [

					'upload_path' => 'images/listings',

					'quality'     => '60%',

					'height'      => 500,

					'width'       => 500,

					'image_name'  => 'profile_image'

				];

				$info['profile_image'] = uploadAndResize($img_info);

			}

			if($_FILES && $_FILES['cover_image']['name'])

			{

				$img_info = [

					'upload_path' => 'images/listings',

					'quality'     => '60%',

					'height'      => 400,

					'width'       => 1000,

					'image_name'  => 'cover_image'

				];

				$info['cover_image'] = uploadAndResize($img_info);

			}



   			// $inserted_id = $this->usermodel->addListing('listings',$info);

			if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

			{

				// $this->session->set_flashdata('message', 'Successfully Added Listing!!');

				redirect('user/user_listing');

			}

			else 

			{

				// $this->session->set_flashdata('message', 'Adding Listing Failed!!');

				redirect('user/edit-listing-step-1');

			}	

		}

	}



	public function edit_listing_step_2($inserted_id = NULL)

	{

		$data['listing_id'] = $inserted_id;

		$data['listing'] = $this->usermodel->getSingleValue($inserted_id,'listing_id','listings');



		if($this->form_validation->run('listing_step_2') == FALSE)

		{	        

			$this->load->view('header');

			$this->load->view('edit_listing_step_2',$data);

			$this->load->view('footer');

		} else 

		{

			$inserted_id = htmlentities($this->input->post('listing_id'), ENT_QUOTES);

			$info = array(

				'service_name' 		=> htmlentities($this->input->post('service_name'), ENT_QUOTES), 

			);

			if($_FILES && $_FILES['service_image']['name'])

			{

				$img_info = [

					'upload_path' => 'images/listings',

					'quality'     => '60%',

					'height'      => 500,

					'width'       => 500,

					'image_name'  => 'service_image'

				];

				$info['service_image'] = uploadAndResize($img_info);

			}



			if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

			{

				redirect('user/user_listing');

			}

			else 

			{

				redirect('user/edit-listing-step-2/'.$inserted_id);

			}	

		}

	}



	public function edit_listing_step_3($inserted_id = NULL)

	{

		$data['listing_id'] = $inserted_id;

		$data['listing'] = $this->usermodel->getSingleValue($inserted_id,'listing_id','listings');



		if($this->form_validation->run('listing_step_3') == FALSE)

		{	        

			$this->load->view('header');

			$this->load->view('edit_listing_step_3',$data);

			$this->load->view('footer');

		} else 

		{

			$inserted_id = htmlentities($this->input->post('listing_id'), ENT_QUOTES);



			$info = array(

				'service_1_name' 		=> htmlentities($this->input->post('service_1_name'), ENT_QUOTES), 

				'service_1_price' 		=> htmlentities($this->input->post('service_1_price'), ENT_QUOTES), 

				'service_1_detail' 		=> htmlentities($this->input->post('service_1_detail'), ENT_QUOTES), 

				'service_1_view_more' 	=> htmlentities($this->input->post('service_1_view_more'), ENT_QUOTES), 

			);

			if($_FILES && $_FILES['service_1_image']['name'])

			{

				$img_info = [

					'upload_path' => 'images/listings',

					'quality'     => '60%',

					'height'      => 400,

					'width'       => 1000,

					'image_name'  => 'service_1_image'

				];

				$info['service_1_image'] = uploadAndResize($img_info);

			}



			if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

			{

				redirect('user/user_listing');

			}

			else 

			{

				redirect('user/edit-listing-step-3/'.$inserted_id);

			}	

		}

	}	



	public function edit_listing_step_4($inserted_id = NULL)

	{

		$data['listing_id'] = $inserted_id;

		$data['listing'] = $this->usermodel->getSingleValue($inserted_id,'listing_id','listings');



		if($this->form_validation->run('listing_step_4') == FALSE)

		{	        

			$this->load->view('header');

			$this->load->view('edit_listing_step_4',$data);

			$this->load->view('footer');

		} else 

		{

			$inserted_id = htmlentities($this->input->post('listing_id'), ENT_QUOTES);





			$info = array(

				'google_map' 	=> htmlentities($this->input->post('google_map'), ENT_QUOTES), 

				'360_view' 		=> htmlentities($this->input->post('360_view'), ENT_QUOTES),  

			);

			if(!empty($this->input->post('listing_video')))

			{

				$info['listing_video'] = json_encode($this->input->post('listing_video'));

			}



			if($_FILES && $_FILES['gallery_image']['name'])

			{

				$img_info = [

					'upload_path' => 'images/listings',

					'quality'     => '60%',

					'height'      => 500,

					'width'       => 500,

					'image_name'  => 'gallery_image'

				];

				$info['gallery_image'] = uploadMultipleAndResize($img_info);

			}



			if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

			{

				redirect('user/user_listing');

			}

			else 

			{

				redirect('user/edit-listing-step-4/'.$inserted_id);

			}	

		}

	}



	public function edit_listing_step_5($inserted_id = NULL)

	{

		$data['listing_id'] = $inserted_id;

		$data['listing'] = $this->usermodel->getSingleValue($inserted_id,'listing_id','listings');



		if($this->form_validation->run('listing_step_5') == FALSE)

		{	        

			$this->load->view('header');

			$this->load->view('edit_listing_step_5',$data);

			$this->load->view('footer');

		} else 

		{

			$info = array();

			$inserted_id = htmlentities($this->input->post('listing_id'), ENT_QUOTES);



			if(!empty($this->input->post('listing_info_question')))

			{

				$info['listing_info_question'] = json_encode($this->input->post('listing_info_question'));

			}



			if(!empty($this->input->post('listing_info_answer')))

			{

				$info['listing_info_answer'] = json_encode($this->input->post('listing_info_answer'));

			}

			// echo "<pre>";

			// var_dump($info);

			// die();

			redirect('user/edit-listing-step-6/'.$inserted_id);

			// if($this->usermodel->update($inserted_id,$info,'listing_id','listings'))

			// {

			// 	redirect('user/add-listing-step-6/'.$inserted_id);

			// }

			// else 

			// {

			// 	redirect('user/add-listing-step-5/'.$inserted_id);

			// }	

		}

	}

	public function edit_listing_step_6($listing_id = NULL)

	{

		$data['listing_id'] = $listing_id;

		$data['listing'] = $this->usermodel->getSingleValue($inserted_id,'listing_id','listings');



		$this->load->view('header');

		$this->load->view('edit_listing_step_6',$data);

		$this->load->view('footer');

	}





	/* Delete Listing */

	public function delete_listing($listing_slug)
	{
		$listings = $this->usermodel->getSingleValue($listing_slug,'listing_slug','listings');
		$listings->is_deleted 	= 1;
		$listings->deleted_date= date('Y-m-d H:i:s');
		if($this->usermodel->update($listing_slug,$listings,'listing_slug','listings'))
		{
			$this->session->set_flashdata('message', 'Successfully Listing Deleted!!');
			redirect('user/user-listing','refresh');
		}

		else 

		{

			$this->session->set_flashdata('message', 'Deleting Listing Failed!!');

			redirect('user/user-listing','refresh');

		}    	

	}

	/*======================

	    USER PRODUCTS

	    ======================*/



	    /*User All Products*/

	    public function products()

	    {
	    	$data['allProducts'] = $this->usermodel->getAllProducts(); 
	    	
	    	$this->load->view('header');
	    	$this->load->view('user_left_sidebar');
	    	$this->load->view('user_products',$data);
	    	$this->load->view('user_right_sidebar');
	    	$this->load->view('footer');
	    }

	    /*Product Details*/

	    public function product_details($id)

	    {
	    	$data['product'] = $this->usermodel->getSingleProduct($id);
	    	$this->load->view('header');
	    	$this->load->view('product_details',$data);
	    	$this->load->view('footer');
	    }


		/*=============================
			Get Product Sub Category
		=============================*/
		// public function get_product_sub_category()
		// {
			
		// 	if(!empty($this->input->post('category_id'))){
		// 		$category_id = $this->input->post('category_id');
		// 		$data['sub_categories'] = $this->adminmodel->ProductSubCategoryByCateId($category_id);
		// 		$this->load->view('admin/get_sub_categories',$data);
		// 	}
		// }


	    /*User Add Product*/
	    public function add_product()
	    {
	    	$data['productCategories'] = $this->usermodel->getAllValues('product_categories');
	    	if ($this->form_validation->run('products') == FALSE) {
	    		$this->load->view('header');
	    		$this->load->view('add_new_product',$data);
	    		$this->load->view('footer');
	    	} else {

	      		$product_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('product_name'));
	    		$info = array(
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

	    		if($this->usermodel->add('products',$info))
	    		{
	    			$this->session->set_flashdata('message', 'Successfully Product Added!!');
	    			redirect('user/add-product');
	    		}
	    		else 
	    		{
	    			$this->session->set_flashdata('message', 'Adding Product Failed!!');
	    			redirect('user/add-product','refresh');
	    		}	
	    	}
	    }

	    /* User Edit Product */
	    public function edit_products($id)
	    {
	    	$data['product'] 			= $this->usermodel->getOnlyProduct($id);
	    	$data['productCategories'] 	= $this->usermodel->getAllValues('product_categories');

	    	if($data['product']->category_id != ''){
	    		$data['sub_category_products'] = $this->usermodel->productSubCategoryByCateId($data['product']->category_id);
	    	}

	    	$old_images = $data['product']->gallery_image;

	    	if ($this->form_validation->run('products') == FALSE) {
	    		$this->load->view('header');
	    		$this->load->view('edit_product',$data);
	    		$this->load->view('footer');
	    	} else {

	      		$product_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('product_name'));
	    		$info = (array)$data['product'];

	    		$info['product_name']		= htmlentities($this->input->post('product_name'), ENT_QUOTES);
	    		$info['category_id']		= htmlentities($this->input->post('category_id'), ENT_QUOTES);
	    		$info['sub_category_id']	= htmlentities($this->input->post('sub_category_id'), ENT_QUOTES);
	    		$info['product_price']		= htmlentities($this->input->post('product_price'), ENT_QUOTES);
	    		$info['product_price_offer']= htmlentities($this->input->post('product_price_offer'), ENT_QUOTES);
	    		$info['product_payment_link']= htmlentities($this->input->post('product_payment_link'), ENT_QUOTES);
	    		$info['product_description']	= htmlentities($this->input->post('product_description'), ENT_QUOTES);
	    		$info['product_tags']		= htmlentities($this->input->post('product_tags'), ENT_QUOTES);
	    		$info['product_slug']		= $product_slug;

	    		if(!empty($this->input->post('product_highlights')))
	    		{
	    			$info['product_highlights'] = json_encode($this->input->post('product_highlights'));
	    		}
	    		if(!empty($this->input->post('product_info_question')))
	    		{
	    			$info['product_info_question']= json_encode($this->input->post('product_info_question'));
	    		}
	    		if(!empty($this->input->post('product_info_answer')))
	    		{
	    			$info['product_info_answer'] = json_encode($this->input->post('product_info_answer'));
	    		}

	    		if($_FILES && $_FILES['gallery_image']['name'][0] != "")
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
	    		if($info['gallery_image'] == '[]' || $info['gallery_image'] == 0)
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
	    		}

	    		if($this->usermodel->update($id,$info,'product_id','products'))
	    		{
	    			$this->session->set_flashdata('message', 'Successfully Product Updated!!');
	    			redirect('user/edit-products/'.$id);
	    		}
	    		else 
	    		{
	    			$this->session->set_flashdata('message', 'Updating Product Failed!!');
	    			redirect('user/edit-products/'.$id,'refresh');
	    		}	
	    	}
	    }	



	    /* User Delete Product */

	    public function delete_product($id)

	    {

	    	$product = $this->usermodel->getOnlyProduct($id);



	    	$product->is_deleted 	= 1;

	    	$product->deleted_date= date('Y-m-d H:i:s');



	    	if($this->usermodel->update($id,$product,'product_id','products'))

	    	{

	    		$this->session->set_flashdata('message', 'Successfully Product Deleted!!');

	    		redirect('user/products','refresh');

	    	}

	    	else 

	    	{

	    		$this->session->set_flashdata('message', 'Deleting Product Failed!!');

	    		redirect('user/products','refresh');

	    	}	



	    }



		/*====================

		Get Listing Sub Category

		=====================*/

		public function get_product_sub_category()
		{
			if(!empty($this->input->post('category_id'))){
				$category_id = $this->input->post('category_id');
				$data['sub_categories'] = $this->usermodel->productSubCategoryByCateId($category_id);
				$this->load->view('admin/get_sub_categories',$data);
			}
		}





	/*=====================
	      USER EVENTS
	=====================*/        

	     /*All events*/
	    public function user_events()
	    {
			$data['logged_id'] = NULL;		
			if($this->session->userdata('logged_user')){ 
				$session 		   = $this->session->userdata('logged_user');
				$data['logged_id'] = $session['logged_id'];
			}
			$data['allEvents'] = null;

			$config = array(
				'full_tag_open' => '<ul class="pagination">',
				'full_tag_close' => '</ul>',
				'prev_tag_open' => '<li class="page-link">',
				'prev_tag_close' => '</li>',
				'next_tag_open' => '<li class="page-link">',
				'next_tag_close' => '</li>',
				'num_tag_open' => '<li class="page-link">',
				'num_tag_close' => '</li>',
				'last_tag_open' => '<li class="page-link">',
				'last_tag_close' => '</li>',
				'first_tag_open' => '<li class="page-link">',
				'first_tag_close' => '</li>',
				'next_link' => 'Next >',
				'prev_link' => '< Prev',
			);

			$config = [
				'base_url' 	=> base_url('user/user-events'),
				'per_page' 	=> 10,
				'total_rows'=> count($this->usermodel->getAllEvent($data['logged_id'],NULL, NULL))
			];

			$this->pagination->initialize($config);

			$data['allEvents']   	= $this->usermodel->getAllEvent($data['logged_id'],$config['per_page'],$this->uri->segment(3)); 

			$data['link'] 		= $this->pagination->create_links();

			$data['title'] 		= "Pearland | All Events";

	      	$this->load->view('header',$data);
	      	$this->load->view('user_left_sidebar');
	      	$this->load->view('user_events');
	      	$this->load->view('user_right_sidebar');
	      	$this->load->view('footer');
	    }



	      /* Preview Event */

	      public function event_details($id)

	      {		

	      	$data['logged_id'] = NULL;

	      	if($this->session->userdata('logged_user')){ 

	      		$session 		   = $this->session->userdata('logged_user');

	      		$data['logged_id'] = $session['logged_id'];

	      	}





	      	$data['event'] = $this->usermodel->getSingleValue($id,'event_id','events');



	      	$this->load->view('header');

	      	$this->load->view('event_details',$data);

	      	$this->load->view('footer');        

	      }



	      /* Add new Event */

	      public function add_user_event()

	      {

	      	if($this->form_validation->run('event_rules') == false)

	      	{

	      		$this->load->view('header');

	      		$this->load->view('user_add_new_event');

	      		$this->load->view('footer');	        

	      	} else {

	      		$info = array(

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

	      			'isenquiry'         => $this->input->post('isenquiry')

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



	      		if($this->usermodel->addEvents($info))

	      		{

	      			$this->session->set_flashdata('message', 'Successfully Added Event!!');

	      			redirect('user/add-user-event');

	      		}

	      		else 

	      		{

	      			$this->session->set_flashdata('message', 'Adding Event Failed!!');

	      		}	            



	      	}

	      }



	      /* Edit User Event */

	      public function edit_user_event($id)
	      {
	      	$data['event']    = $this->usermodel->getSingleValue($id,'event_id','events');
	      	$old_image        = $data['event']->event_image;

	      	if($this->form_validation->run('event_rules') == FALSE)
	      	{
	      		$this->load->view('header');
	      		$this->load->view('user_edit_event',$data);
	      		$this->load->view('footer');
	      	} else 
	      	{
	      		$info = array(
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
	      			'isenquiry'         => $this->input->post('isenquiry') == 'on' ? 1 : 0
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
		      	if($this->usermodel->update($id,$info,'event_id','events'))
		      	{	
		      		$this->session->set_flashdata('message', 'Successfully Updated Event!!');
		      		redirect('user/user_events','refresh');
		      	} else 
		      	{
		      		$this->session->set_flashdata('message', 'Sorry, Update Event Failed!!');
		      		redirect('user/edit_user_event', 'refresh');
		      	}
	      	}	   
	    }

	    /*Delete events*/
	    public function delete_user_event($id)
	    {
	    	if($this->usermodel->deleteUserEvent($id))
	    	{
	    		$this->session->set_flashdata('message', 'Successfully Removed Event!!');
	    		redirect('user/user_events');
	    	} 
	    }





	/*======================
	    USER BLOG POST
	======================*/        
	    /*All Blogs*/

	    public function blog_list()
	    {
	   		// $data['blogList'] = $this->usermodel->getAllValues('blogs');
	     	// $data['blogList'] = $this->usermodel->getBlogs();
			$data['logged_id'] = NULL;		
			if($this->session->userdata('logged_user')){ 
				$session 		   = $this->session->userdata('logged_user');
				$data['logged_id'] = $session['logged_id'];
			}
			$data['blogList'] = null;

			$config = array(
				'full_tag_open' => '<ul class="pagination">',
				'full_tag_close' => '</ul>',
				'prev_tag_open' => '<li class="page-link">',
				'prev_tag_close' => '</li>',
				'next_tag_open' => '<li class="page-link">',
				'next_tag_close' => '</li>',
				'num_tag_open' => '<li class="page-link">',
				'num_tag_close' => '</li>',
				'last_tag_open' => '<li class="page-link">',
				'last_tag_close' => '</li>',
				'first_tag_open' => '<li class="page-link">',
				'first_tag_close' => '</li>',
				'next_link' => 'Next >',
				'prev_link' => '< Prev',
			);

			$config = [
				'base_url' 	=> base_url('user/blog-list'),
				'per_page' 	=> 10,
				'total_rows'=> count($this->usermodel->getAllBlogs($data['logged_id'],NULL, NULL))
			];

			$this->pagination->initialize($config);

			$data['blogList']   	= $this->usermodel->getAllBlogs($data['logged_id'],$config['per_page'],$this->uri->segment(3)); 

			$data['link'] 		= $this->pagination->create_links();

			$data['title'] 		= "Pearland | All Blog";	     	

	     	$this->load->view('header',$data);
	     	$this->load->view('user_left_sidebar');
	     	$this->load->view('user_blog_posts');
	     	$this->load->view('user_right_sidebar');
	     	$this->load->view('footer');
	     }



	     /* Preview blog */
	    public function blog_details($id)
	    {
	     	$data['logged_id'] = NULL;
	     	if($this->session->userdata('logged_id')){
	     		$session 		   = $this->session->userdata('logged_user');
	     		$data['logged_id'] = $session['logged_id'];
	     	}

	     	$data['blog'] = $this->usermodel->getSingleValue($id,'blog_id','blogs');

	     	$this->load->view('header');
	     	$this->load->view('blog_details',$data);
	     	$this->load->view('footer');        
	    }



	    /* Add new Blog */

	    public function add_blog()
	    {
	     	if($this->form_validation->run('blogs') == false)
	     	{
	     		$this->load->view('header');
	     		$this->load->view('user_add_new_blog');
	     		$this->load->view('footer');	        
	     	} else {
	     		$isenquiry = htmlentities($this->input->post('isenquiry'), ENT_QUOTES) == 'on' ? 1 : 0;
	    		$blog_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('blog_name'));

	     		$info = array(
	     			'blog_name'    		=> htmlentities($this->input->post('blog_name'), ENT_QUOTES),
	     			'blog_description'  => htmlentities($this->input->post('blog_description'), ENT_QUOTES),
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
	     			redirect('user/blog-list');
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
	     	$data['blog']    = $this->usermodel->getSingleValue($id,'blog_id','blogs');
	     	$old_image       = $data['blog']->blog_image;

	     	if($this->form_validation->run('blogs') == FALSE)
	     	{
	     		$this->load->view('header');
	     		$this->load->view('user_edit_blog',$data);
	     		$this->load->view('footer');
	     	} else 
	     	{
	     		$isenquiry = htmlentities($this->input->post('isenquiry'), ENT_QUOTES) == 'on' ? 1 : 0;
	     		$info = array(
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

	     			if($image_link != null)
	     			{
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

	     		if($this->usermodel->update($id,$info,'blog_id','blogs'))
	     		{	
	     			$this->session->set_flashdata('message', 'Successfully Updated Blog!!');
	     			redirect('user/blog-list','refresh');
	     		} else 
	     		{
		     		$this->session->set_flashdata('message', 'Sorry, Update Blog Failed!!');
		     		redirect('user/edit-blog'.$id, 'refresh');
	     		}
	    	}	   
	    }

	   	/*Delete Blog*/
	   	public function delete_blog($id)
	  	{
	   		if($this->usermodel->deleteBlog($id))
	   		{
		   		$this->session->set_flashdata('message', 'Successfully Removed Blog!!');
		   		redirect('user/blog-list');
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

	 	$data['enquiries'] = $this->usermodel->getEnquiries($data['logged_id']);

	 	$this->load->view('header');
	 	$this->load->view('user_left_sidebar');
	 	$this->load->view('enquiry_list',$data);
		// $this->load->view('user_right_sidebar');
	 	$this->load->view('footer');
	}



		 public function add_enquiry($link = NULL,$id = NULL)

		 {

		 	if ($this->form_validation->run('enquiry') == FALSE) {

		 		$this->session->set_flashdata('message', 'Enquiry Submit Failed!!');

		 		redirect('user/'.$link.'/'.$id,'refresh');	 



		 	} else {       

		 		$info = array(

		 			'listing_id'    	=> htmlentities($this->input->post('listing_id'), ENT_QUOTES),

		 			'event_id'     		=> htmlentities($this->input->post('event_id'), ENT_QUOTES),

		 			'blog_id'     		=> htmlentities($this->input->post('blog_id'), ENT_QUOTES),

		 			'product_id'    	=> htmlentities($this->input->post('product_id'), ENT_QUOTES),

		 			'receiving_user_id' => htmlentities($this->input->post('receiving_user_id'), ENT_QUOTES),

		 			'enquiry_sender_id' => htmlentities($this->input->post('enquiry_sender_id'), ENT_QUOTES),

		 			'enquiry_source'	=> htmlentities($this->input->post('enquiry_source'), ENT_QUOTES),

		 			'enquiry_type'		=> htmlentities($this->input->post('enquiry_type'), ENT_QUOTES),

		 			'enquiry_name' 		=> htmlentities($this->input->post('enquiry_name'), ENT_QUOTES),

		 			'enquiry_email'		=> htmlentities($this->input->post('enquiry_email'), ENT_QUOTES),

		 			'enquiry_mobile'	=> htmlentities($this->input->post('enquiry_mobile'), ENT_QUOTES),

		 			'enquiry_message'   => htmlentities($this->input->post('enquiry_message'), ENT_QUOTES),

		 		);		



		 		if ($this->usermodel->addEnquiry($info)) {

		 			$this->session->set_flashdata('message', 'Successfully Submitted Enquiry!!');

		 			redirect('user/'.$link.'/'.$id,'refresh');

		 		} else {

		 			$this->session->set_flashdata('message', 'Failed to Add Enquiry!!');

		 			redirect('user/'.$link.'/'.$id,'refresh');

		 		}

		 	}

		 }



	/*====================

		CLAIM BUSINESS

		====================*/



		public function claim_listing($id)

		{

			$info = array(

				'listing_id'    	=> htmlentities($this->input->post('listing_id'), ENT_QUOTES),

				'enquiry_sender_id' => htmlentities($this->input->post('enquiry_sender_id'), ENT_QUOTES),

				'enquiry_source'	=> htmlentities($this->input->post('enquiry_source'), ENT_QUOTES),

				'enquiry_name' 		=> htmlentities($this->input->post('enquiry_name'), ENT_QUOTES),

				'enquiry_email'		=> htmlentities($this->input->post('enquiry_email'), ENT_QUOTES),

				'enquiry_mobile'	=> htmlentities($this->input->post('enquiry_mobile'), ENT_QUOTES),

				'enquiry_message'   => htmlentities($this->input->post('enquiry_message'), ENT_QUOTES),

			);		



			if($_FILES && $_FILES['enquiry_image']['name'])

			{

				$img_info = [

					'upload_path' => 'images/listings',

					'quality'     => '60%',

					'height'      => 500,

					'width'       => 500,

					'image_name'  => 'enquiry_image'

				];

				$info['enquiry_image'] = uploadAndResize($img_info);



				if ($this->usermodel->claimBusiness($info)) {

					$this->session->set_flashdata('message', 'Successfully Placed Request!!');

					redirect('user/listing-preview/'.$id,'refresh');

				} else {

					$this->session->set_flashdata('message', 'Failed to Place Request!!');

					redirect('user/listing-preview/'.$id,'refresh');

				}	

			}	

		}









	/*=============
		COUPONS
	=============*/	
	public function coupons()
	{
		$data['logged_id'] = NULL;		
		if($this->session->userdata('logged_user')){ 
			$session 		   = $this->session->userdata('logged_user');
			$data['logged_id'] = $session['logged_id'];
		}
		$data['coupons'] = null;

		$config = array(
			'full_tag_open' => '<ul class="pagination">',
			'full_tag_close' => '</ul>',
			'prev_tag_open' => '<li class="page-link">',
			'prev_tag_close' => '</li>',
			'next_tag_open' => '<li class="page-link">',
			'next_tag_close' => '</li>',
			'num_tag_open' => '<li class="page-link">',
			'num_tag_close' => '</li>',
			'last_tag_open' => '<li class="page-link">',
			'last_tag_close' => '</li>',
			'first_tag_open' => '<li class="page-link">',
			'first_tag_close' => '</li>',
			'next_link' => 'Next >',
			'prev_link' => '< Prev',
		);

		$config = [
			'base_url' 	=> base_url('user/coupons'),
			'per_page' 	=> 10,
			'total_rows'=> count($this->usermodel->getAllCoupons($data['logged_id'],NULL, NULL))
		];

		$this->pagination->initialize($config);

		$data['coupons']   	= $this->usermodel->getAllCoupons($data['logged_id'],$config['per_page'],$this->uri->segment(3)); 

		$data['link'] 		= $this->pagination->create_links();

		$data['title'] 		= "Pearland | All Coupons";

		$this->load->view('header', $data);
		$this->load->view('user_left_sidebar');
		$this->load->view('user_coupons');
		$this->load->view('user_right_sidebar');
		$this->load->view('footer');
	}

	public function add_coupon()
	{
		if($this->form_validation->run('coupons') == false)
		{
			$this->load->view('header');
			$this->load->view('add_coupons');
			$this->load->view('footer');	        
		} else {
			$info = array(
				'coupon_name'       => htmlentities($this->input->post('coupon_name'), ENT_QUOTES),
				'coupon_code'     	=> htmlentities($this->input->post('coupon_code'), ENT_QUOTES),
				'coupon_link'  		=> htmlentities($this->input->post('coupon_link'), ENT_QUOTES),
				'coupon_start_date' => date('Y-m-d',strtotime($this->input->post('coupon_start_date'))),
				'coupon_end_date' 	=> date('Y-m-d',strtotime($this->input->post('coupon_end_date'))),
				'coupon_status'		=> 0,
                // 'created_at'		=> date('Y-m-d H:i:s'),
			);

			if($_FILES && $_FILES['coupon_image']['name'])
			{
				$img_info = [
					'upload_path' => 'images/events',
					'quality'     => '60%',
					'height'      => 65,
					'width'       => 65,
					'image_name'  => 'coupon_image'
				];
				$info['coupon_photo'] = uploadAndResize($img_info);
			}

			if($this->usermodel->addCoupon($info))
			{
				$this->session->set_flashdata('message', 'Successfully Added Coupon!!');
				redirect('user/coupons');
			}
			else 
			{
				$this->session->set_flashdata('message', 'Adding Coupon Failed!!');
			}	            
		}
	}



		public function edit_coupon($id)

		{

			$data['coupon']    = $this->usermodel->getSingleValue($id,'coupon_id','coupons');

			$old_image         = $data['coupon']->coupon_photo;



			if($this->form_validation->run('coupons') == FALSE)

			{

				$this->load->view('header');

				$this->load->view('edit_coupons',$data);

				$this->load->view('footer');

			} else 

			{

				$info = array(

					'coupon_name'       => htmlentities($this->input->post('coupon_name'), ENT_QUOTES),

					'coupon_code'     	=> htmlentities($this->input->post('coupon_code'), ENT_QUOTES),

					'coupon_link'  		=> htmlentities($this->input->post('coupon_link'), ENT_QUOTES),

					'coupon_start_date' => date('Y-m-d',strtotime($this->input->post('coupon_start_date'))),

					'coupon_end_date' 	=> date('Y-m-d',strtotime($this->input->post('coupon_end_date'))),

				);



				if($_FILES && $_FILES['coupon_photo']['name'])

				{

					$img_info = [

						'upload_path' => 'images/events',

						'quality'     => '60%',

						'height'      => 400,

						'width'       => 1000,

						'image_name'  => 'coupon_photo'

					];



					$image_link = $old_image;



					if($image_link != null){

						if(file_exists('./'.$image_link))

						{

							unlink($image_link);

						}                    

					}



					$info['coupon_photo'] = uploadAndResize($img_info);

				} else 

				{

					$info['coupon_photo'] = $old_image;

				}



				if($this->usermodel->update($id,$info,'coupon_id','coupons'))

					{	$this->session->set_flashdata('message', 'Successfully Updated Coupon!!');

				redirect('user/coupons','refresh');

			} else 

			{

				$this->session->set_flashdata('message', 'Sorry, Update Coupon Failed!!');

				redirect('user/edit-coupon', 'refresh');

			}

		}	   

	}	



	public function delete_coupon($id)

	{

		$coupon = $this->usermodel->getSingleValue($id,'coupon_id','coupons');



		$coupon->coupon_status 	= 0;



		if($this->usermodel->update($id,$coupon,'coupon_id','coupons'))

		{

			$this->session->set_flashdata('message', 'Successfully Coupon Deleted!!');

			redirect('user/coupons','refresh');

		}

		else 

		{

			$this->session->set_flashdata('message', 'Deleting Coupon Failed!!');

			redirect('user/coupons','refresh');

		}	

		

	}

	

	

	/*User All Coupons*/

	public function user_coupons()

	{

		$this->load->view('header');

		$this->load->view('user_left_sidebar');

		$this->load->view('user_coupons');

		$this->load->view('user_right_sidebar');

		$this->load->view('footer');

	}

	/*User All Enquiry*/

	// public function user_enquiry()

	// {

	// 	$this->load->view('header');

	// 	$this->load->view('user_left_sidebar');

	// 	$this->load->view('user_enquiry');

	// 	$this->load->view('user_right_sidebar');

	// 	$this->load->view('footer');

	// }

	/*News Details*/

	public function news_details()

	{
		$this->load->view('header');

		$this->load->view('news_details_n');

		$this->load->view('footer');

	}

	/*News Lists*/

	public function news_lists()

	{
		$this->load->view('header');

		$this->load->view('news_lists_n');

		$this->load->view('footer');

	}

	/*Listing Details*/

	public function listing_details_n()

	{

		$this->load->view('header');

		$this->load->view('listing_details_n');

		$this->load->view('footer');

	}/*Listing List*/

	public function listing_list_n()

	{
		$this->load->view('header');

		$this->load->view('listing_list_n');

		$this->load->view('footer');

	}

	/*Package*/

	public function pricing_n()

	{



		$this->load->view('header');

		$this->load->view('pricing_n');

		$this->load->view('footer');

	}

	/*Package*/

	public function event_details_n()

	{
		$this->load->view('header');

		$this->load->view('event_details_n.php');

		$this->load->view('footer');

	}









	/* AD price details */

	public function ads_price()

	{

		$data['logged_id'] = NULL;		

		if($this->session->userdata('logged_user')){ 

			$session 		   = $this->session->userdata('logged_user');

			$data['logged_id'] = $session['logged_id'];

		}

		$data['prices']		= $this->usermodel->allAdsPrices();



		$this->load->view('header',$data);

		$this->load->view('ads_price.php');

		$this->load->view('footer');

	}

	

	/*Posted Ads*/

	public function ads_summery()

	{

		$data['logged_id'] = NULL;		

		if($this->session->userdata('logged_user')){ 

			$session 		   = $this->session->userdata('logged_user');

			$data['logged_id'] = $session['logged_id'];

		}

		$data['ads'] = null;



		$config = array(

			'full_tag_open' => '<ul class="pagination">',

			'full_tag_close' => '</ul>',

			'prev_tag_open' => '<li class="page-link">',

			'prev_tag_close' => '</li>',

			'next_tag_open' => '<li class="page-link">',

			'next_tag_close' => '</li>',

			'num_tag_open' => '<li class="page-link">',

			'num_tag_close' => '</li>',

			'last_tag_open' => '<li class="page-link">',

			'last_tag_close' => '</li>',

			'first_tag_open' => '<li class="page-link">',

			'first_tag_close' => '</li>',

			'next_link' => 'Next >',

			'prev_link' => '< Prev',

		);



		$config = [

			'base_url' 	=> base_url('user/ads-summary'),

			'per_page' 	=> 10,

			'total_rows'=> count($this->usermodel->getAllAds($data['logged_id'],NULL, NULL))

		];

		$this->pagination->initialize($config);



		$data['ads']   	= $this->usermodel->getAllAds($data['logged_id'],$config['per_page'],$this->uri->segment(3)); 

		$data['link'] 	= $this->pagination->create_links();



		$data['title'] 		= "Pearland | All Ads";



		$this->load->view('header',$data);

		$this->load->view('user_left_sidebar');

		$this->load->view('post_ads');

		$this->load->view('user_right_sidebar');

		$this->load->view('footer');

	}



	/*Post Ads*/
	public function post_ads()

	{

		$data['adsPrices'] 	= $this->usermodel->allAdsPrices();



		$this->form_validation->set_rules('ads_price_id', 'Ads Position', 'trim|required');

		$this->form_validation->set_rules('ad_start_date', 'Start Date', 'trim|required');

		$this->form_validation->set_rules('ad_end_date', 'End Date', 'trim|required');

		$this->form_validation->set_rules('ad_link', 'Ads Link', 'trim|required');

		$this->form_validation->set_rules('ad_total_days', 'Total Days', 'trim|required');

		$this->form_validation->set_rules('ad_cost_per_day', 'Cost Per Day', 'trim|required');

		$this->form_validation->set_rules('ad_total_cost', 'Total Cost', 'trim|required');



		if($this->form_validation->run() == false)

		{

			$this->load->view('header',$data);

            // $this->load->view('user_left_sidebar');

			$this->load->view('post_your_ads');

            // $this->load->view('user_right_sidebar');

			$this->load->view('footer');	        

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

				'ad_status'			=> 0,

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



			if($this->usermodel->addAds('ads',$info))

			{

				$this->session->set_flashdata('message', 'Successfully Added Ad!!');

				redirect('user/ads-summery');

			}

			else 

			{

				$this->session->set_flashdata('message', 'Failed to add Ads!!');

				redirect('user/post-ads');

			}	            

		}

	}

	/*======================
    		USER NEWS
  	======================*/
  	/*User All news*/
  	public function user_news()
  	{
	  	$data['allNews'] = $this->usermodel->getUserNews(); 

	  	$this->load->view('header');
	  	$this->load->view('user_left_sidebar');
	  	$this->load->view('user_news',$data);
	  	$this->load->view('user_right_sidebar');
	  	$this->load->view('footer');
 	}

	/*User Add News*/
	public function user_add_news()
	{
	  	$data['NewsCategories'] = $this->usermodel->getAllValues('news_categories');
	  	if ($this->form_validation->run('news') == FALSE) {
	  		$this->load->view('header');
		  	$this->load->view('user_left_sidebar');
		  	$this->load->view('user_add_news',$data);
		  	$this->load->view('user_right_sidebar');
		  	$this->load->view('footer');
	  	} else {
			$news_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('news_title'));
	  		$info = array(
	  			'news_title'    		=> htmlentities($this->input->post('news_title'), ENT_QUOTES),
	  			'news_description'  => htmlentities($this->input->post('news_description'), ENT_QUOTES),
	  			'news_category_id'  => htmlentities($this->input->post('news_category_id'), ENT_QUOTES),
	  			'news_seo_title'  => htmlentities($this->input->post('news_seo_title'), ENT_QUOTES),
	  			'news_seo_description'  => htmlentities($this->input->post('news_seo_description'), ENT_QUOTES),
	  			'news_seo_keywords'  => htmlentities($this->input->post('news_seo_keywords'), ENT_QUOTES),
	  			'featured_news'  => htmlentities($this->input->post('featured_news'), ENT_QUOTES),
	  			'news_status'	=> 0,
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


	  		if($this->usermodel->add('news',$info))
	  		{
	  			$this->session->set_flashdata('message', 'Successfully News Added!!');
	  			redirect('user/user-add-news');
	  		}
	  		else 
	  		{
	  			$this->session->set_flashdata('message', 'Adding News Failed!!');
	  			redirect('user/user-add-news','refresh');
	  		}	
	  	}
	}

    /* User Edit Product */
    public function user_edit_news($id)
    {
    	$data['news']    = $this->usermodel->getSingleValue($id,'news_id','news');
    	$old_image       = $data['news']->news_image;

    	if($this->form_validation->run('news') == FALSE)
    	{
    		$data['all_news_category'] = $this->adminmodel->allNewsCategory();
    		$this->load->view('header');
		  	$this->load->view('user_left_sidebar');
		  	$this->load->view('user_edit_news',$data);
		  	$this->load->view('user_right_sidebar');
		  	$this->load->view('footer');
    	} else 
    	{
    		$info = array(
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

    		if($this->usermodel->update($id,$info,'news_id','news'))
    		{	
    			$this->session->set_flashdata('message', 'Successfully Updated News!!');
    			redirect('user/user-news','refresh');
    		} else 
    		{
    			$this->session->set_flashdata('message', 'Sorry, Update News Failed!!');
    			redirect('user/user-edit-news'.$id, 'refresh');
    		}
    	}	   

    }	
    /* User Delete Product */
    // public function user_delete_news($id)
    // {
	    // 	$product = $this->usermodel->getOnlyProduct($id);

	    // 	$product->is_deleted 	= 1;
	    // 	$product->deleted_date= date('Y-m-d H:i:s');

	    // 	if($this->usermodel->update($id,$product,'product_id','products'))
	    // 	{
	    // 		$this->session->set_flashdata('message', 'Successfully Product Deleted!!');
	    // 		redirect('user/products','refresh');
	    // 	}
	    // 	else 
	    // 	{
	    // 		$this->session->set_flashdata('message', 'Deleting Product Failed!!');
	    // 		redirect('user/products','refresh');
	    // 	}	
    // }

   	/*Delete News*/
   	public function user_delete_news($id)
  	{
   		if($this->usermodel->deleteNews($id))
   		{
	   		$this->session->set_flashdata('message', 'Successfully Removed News!!');
	   		redirect('user/user-news');
   		} 
   	}    
	/*End User News*/



	/*======================
    	   USER Video
  	======================*/
    
	/*Video List*/
	public function video_list()
	{
		$data['videoList'] = $this->usermodel->getVideo();
		
		$this->load->view('header',$data);
	  	$this->load->view('user_left_sidebar');
	  	$this->load->view('user_videos');
	  	$this->load->view('user_right_sidebar');
	  	$this->load->view('footer');
	}

	/* Preview Video */
	public function video_details($id)
	{
		$data['video'] = $this->usermodel->getSingleValue($id,'video_id','video');

		$this->load->view('header',$data);
		$this->load->view('video_details');
		$this->load->view('footer');        
	}

	/* Add new Video */
	public function add_video()
	{
		$data['all_video_category'] = $this->usermodel->allVideoCategory();

		if($this->form_validation->run('video') == false)
		{
			$this->load->view('header',$data);
			$this->load->view('add_new_video');
			$this->load->view('footer');	        
		} else {
			$video_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('video_title'));
			$info = array(
				'video_title'    		=> htmlentities($this->input->post('video_title'), ENT_QUOTES),
				'video_code'    		=> htmlentities($this->input->post('video_code'), ENT_QUOTES),
				'featured_video'    	=> htmlentities($this->input->post('featured_video'), ENT_QUOTES),
				'video_description'  	=> htmlentities($this->input->post('video_description'), ENT_QUOTES),
				'video_category_id'  	=> htmlentities($this->input->post('video_category_id'), ENT_QUOTES),
				'video_status'			=> 0,	
				'video_seo_title'  		=> htmlentities($this->input->post('video_seo_title'), ENT_QUOTES),
				'video_seo_description' => htmlentities($this->input->post('video_seo_description'), ENT_QUOTES),
				'video_seo_keywords'  	=> htmlentities($this->input->post('video_seo_keywords'), ENT_QUOTES),
				'video_slug'  			=> htmlentities($video_slug, ENT_QUOTES)
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

			if($this->usermodel->add('video',$info))
			{
				$this->session->set_flashdata('message', 'Successfully Added Video!!');
				redirect('user/video-list');
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
		$data['video']   = $this->usermodel->getSingleValue($id,'video_id','video');
		$old_image       = $data['video']->video_image;
		$data['all_video_category'] = $this->usermodel->allVideoCategory();

		if($this->form_validation->run('video') == FALSE)
		{
			$this->load->view('header',$data);
			$this->load->view('edit_video');
			$this->load->view('footer');
		} else 
		{
			$video_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('video_title'));
			$info = array(
				// 'user_id'			=> htmlentities($this->input->post('user_id'), ENT_QUOTES),
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
			// echo "<pre>";
			// var_dump($info);die();

			if($this->usermodel->update($id,$info,'video_id','video'))
			{	
				$this->session->set_flashdata('message', 'Successfully Updated Video!!');
				redirect('user/video-list','refresh');
			} else 
			{
				$this->session->set_flashdata('message', 'Sorry, Update Video Failed!!');
				redirect('user/edit-video'.$id, 'refresh');
			}
		}	   
	}

	/*Delete Video*/
	public function delete_video($id)
	{
		if($this->usermodel->deleteVideo($id))
		{
			$this->session->set_flashdata('message', 'Successfully Removed Video!!');
			redirect('user/video-list');
		} 
	}
	/*============
	  End Video 
	============*/



	/*======================
    	User Classifieds
  	======================*/
	public function user_classifieds()
	{
		$data['classifiedsList'] = $this->usermodel->getclassifieds();
		
		$this->load->view('header',$data);
	  	$this->load->view('user_left_sidebar');
	  	$this->load->view('all_classifieds');
	  	$this->load->view('user_right_sidebar');
	  	$this->load->view('footer');

	}

	/* Preview classifieds */
	public function classifieds_details($id)
	{
		$data['blog'] = $this->usermodel->getSingleValue($id,'classifieds_id','classifieds');

		$this->load->view('header');
		$this->load->view('classifieds_details',$data);
		$this->load->view('footer');        
	}

	/* Add new classifieds */
	public function add_classifieds()
	{
		$data['all_classifieds_category'] = $this->usermodel->allclassifiedsCategory();

		if($this->form_validation->run('classifieds') == false)
		{
			$this->load->view('header',$data);
			$this->load->view('add_classifieds');
			$this->load->view('footer');	        
		} else {
			$classifieds_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('classifieds_title'));
			$info = array(
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
				'classifieds_status'    	  => 0,
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

			if($this->usermodel->add('classifieds',$info))
			{
				$this->session->set_flashdata('message', 'Successfully Added classifieds!!');
				redirect('user/user-classifieds');
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
		$data['classifieds']    = $this->usermodel->getSingleValue($id,'classifieds_id','classifieds');
		$old_image       		= $data['classifieds']->classifieds_image;
		$data['all_classifieds_category'] = $this->usermodel->allClassifiedsCategory();

		if($this->form_validation->run('classifieds') == FALSE)
		{
			$this->load->view('header');
			$this->load->view('edit_classifieds',$data);
			$this->load->view('footer');
		} else 
		{
			$classifieds_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('classifieds_title'));
			$info = array(
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
				redirect('user/user-classifieds','refresh');
			} else 
			{
				$this->session->set_flashdata('message', 'Sorry, Update classifieds Failed!!');
				redirect('user/edit-classifieds'.$id, 'refresh');
			}
		}	   
	}

	/*Delete classifieds*/
	public function delete_classifieds($id)
	{
		if($this->usermodel->deleteClassifieds($id))
		{
			$this->session->set_flashdata('message', 'Successfully Removed classifieds!!');
			redirect('user/user-classifieds');
		} 
	}
	/*=====================
	    End Classifieds
	=====================*/



	/*===================
    	 User Rental     
  	===================*/
	public function user_apartments_and_rental()
	{
		$data['rentalList'] = $this->usermodel->getRental();

		$this->load->view('header',$data);
	  	$this->load->view('user_left_sidebar');
	  	$this->load->view('all_rental');
	  	$this->load->view('user_right_sidebar');
	  	$this->load->view('footer');		
	}

	/* Preview rental */
	public function rental_details($id)
	{
		$data['blog'] = $this->usermodel->getSingleValue($id,'rental_id','rental');

		$this->load->view('header');
		$this->load->view('rental_details',$data);
		$this->load->view('footer');        
	}

	/* Add new rental */
	public function add_rental()
	{
		$data['all_rental_category'] = $this->usermodel->allRentalCategory();

		if($this->form_validation->run('rental') == false)
		{
			$this->load->view('header',$data);
			$this->load->view('add_rental');
			$this->load->view('footer');	        
		} else {
			$rental_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('rental_title'));

			$info = array(
				'rental_title'    		=> htmlentities($this->input->post('rental_title'), ENT_QUOTES),
				'rental_price'    		=> htmlentities($this->input->post('rental_price'), ENT_QUOTES),
				'rental_category_id'    => htmlentities($this->input->post('rental_category_id'), ENT_QUOTES),
				'featured_rental'    	=> htmlentities($this->input->post('featured_rental'), ENT_QUOTES),
				'spotlight_rental'    	=> htmlentities($this->input->post('spotlight_rental'), ENT_QUOTES),
				'display_contact'    	=> htmlentities($this->input->post('display_contact'), ENT_QUOTES),
				'rental_address'    	=> htmlentities($this->input->post('rental_address'), ENT_QUOTES),
				'rental_description'    => htmlentities($this->input->post('rental_description'), ENT_QUOTES),
				'bedrooms'    		  	=> htmlentities($this->input->post('bedrooms'), ENT_QUOTES),
				'living_area'    		=> htmlentities($this->input->post('living_area'), ENT_QUOTES),
				'bathroom'    		  	=> htmlentities($this->input->post('bathroom'), ENT_QUOTES),
				'property_age'    		=> htmlentities($this->input->post('property_age'), ENT_QUOTES),
				'garage'    		  	=> htmlentities($this->input->post('garage'), ENT_QUOTES),
				'floors'    		  	=> htmlentities($this->input->post('floors'), ENT_QUOTES),
				'rent_to_own'    		=> htmlentities($this->input->post('rent_to_own'), ENT_QUOTES),
				'can_sublet'    		=> htmlentities($this->input->post('can_sublet'), ENT_QUOTES),
				'rental_seo_title'    	=> htmlentities($this->input->post('rental_seo_title'), ENT_QUOTES),
				'rental_seo_keywords'   => htmlentities($this->input->post('rental_seo_keywords'), ENT_QUOTES),
				'rental_seo_description'=> htmlentities($this->input->post('rental_seo_description'), ENT_QUOTES),
				'rental_slug'  		    => htmlentities($rental_slug, ENT_QUOTES)
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

			if($this->usermodel->add('rental',$info))
			{
				$this->session->set_flashdata('message', 'Successfully Added rental!!');
				redirect('user/user-apartments-and-rental');
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
		$data['rental']    			= $this->usermodel->getSingleValue($id,'rental_id','rental');
		$data['all_rental_category']= $this->usermodel->allrentalCategory();
		$old_image       			= $data['rental']->rental_image;

		if($this->form_validation->run('rental') == FALSE)
		{
			$this->load->view('header',$data);
			$this->load->view('edit_rental');
			$this->load->view('footer');
		} else 
		{
			$rental_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('rental_title'));

			$info = array(
				'rental_title'    		=> htmlentities($this->input->post('rental_title'), ENT_QUOTES),
				'rental_price'    		=> htmlentities($this->input->post('rental_price'), ENT_QUOTES),
				'rental_category_id'    => htmlentities($this->input->post('rental_category_id'), ENT_QUOTES),
				'featured_rental'    	=> htmlentities($this->input->post('featured_rental'), ENT_QUOTES),
				'spotlight_rental'    	=> htmlentities($this->input->post('spotlight_rental'), ENT_QUOTES),
				'display_contact'    	=> htmlentities($this->input->post('display_contact'), ENT_QUOTES),
				'rental_address'    	=> htmlentities($this->input->post('rental_address'), ENT_QUOTES),
				'rental_description'    => htmlentities($this->input->post('rental_description'), ENT_QUOTES),
				'bedrooms'    		  	=> htmlentities($this->input->post('bedrooms'), ENT_QUOTES),
				'living_area'    	    => htmlentities($this->input->post('living_area'), ENT_QUOTES),
				'bathroom'    		  	=> htmlentities($this->input->post('bathroom'), ENT_QUOTES),
				'property_age'    	    => htmlentities($this->input->post('property_age'), ENT_QUOTES),
				'garage'    		  	=> htmlentities($this->input->post('garage'), ENT_QUOTES),
				'floors'    		  	=> htmlentities($this->input->post('floors'), ENT_QUOTES),
				'rent_to_own'    		=> htmlentities($this->input->post('rent_to_own'), ENT_QUOTES),
				'can_sublet'    		=> htmlentities($this->input->post('can_sublet'), ENT_QUOTES),
				'rental_seo_title'    	=> htmlentities($this->input->post('rental_seo_title'), ENT_QUOTES),
				'rental_seo_keywords'   => htmlentities($this->input->post('rental_seo_keywords'), ENT_QUOTES),
				'rental_seo_description'=> htmlentities($this->input->post('rental_seo_description'), ENT_QUOTES),
				'rental_slug'  		    => htmlentities($rental_slug, ENT_QUOTES)
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

			if($this->usermodel->update($id,$info,'rental_id','rental'))
			{	
				$this->session->set_flashdata('message', 'Successfully Updated rental!!');
				redirect('user/user-apartments-and-rental','refresh');
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
			redirect('user/rental-list');
		} 
	}
	/*====================
	      End rental 
	====================*/

	/**================
		 All house
	=================*/
	public function user_house_for_sale()
	{
		$data['houseList'] = $this->usermodel->getHouse();

		$this->load->view('header',$data);
	  	$this->load->view('user_left_sidebar');
	  	$this->load->view('all_house');
	  	$this->load->view('user_right_sidebar');
	  	$this->load->view('footer');	
	}

	/* Preview house */
	public function house_details($id)
	{
		$data['blog'] = $this->usermodel->getSingleValue($id,'house_id','house');

		$this->load->view('inc/header');
		$this->load->view('house_details',$data);
		$this->load->view('footer');        
	}

	/* Add new house */
	public function add_house()
	{
		$data['all_house_category'] = $this->adminmodel->allhouseCategory();

		if($this->form_validation->run('house') == false)
		{
			$this->load->view('header',$data);
			$this->load->view('add_house');
			$this->load->view('footer');	        
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

			if($this->usermodel->add('house',$info))
			{
				$this->session->set_flashdata('message', 'Successfully Added house!!');
				redirect('user/user-house-for-sale');
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
		$data['all_house_category'] = $this->usermodel->allhouseCategory();
		$data['house']   = $this->usermodel->getSingleValue($id,'house_id','house');
		$old_image       = $data['house']->house_image;

		if($this->form_validation->run('house') == FALSE)
		{
			$this->load->view('header');
			$this->load->view('edit_house',$data);
			$this->load->view('footer');
		} else 
		{
			$house_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $this->input->post('house_title'));
			$info = array(
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

			if($this->usermodel->update($id,$info,'house_id','house'))
			{	
				$this->session->set_flashdata('message', 'Successfully Updated house!!');
				redirect('user/user-house-for-sale','refresh');
			} else 
			{
				$this->session->set_flashdata('message', 'Sorry, Update house Failed!!');
				redirect('user/edit-house'.$id, 'refresh');
			}
		}	   
	}

	/*Delete house*/
	public function delete_house($id)
	{
		if($this->usermodel->deletehouse($id))
		{
			$this->session->set_flashdata('message', 'Successfully Removed house!!');
			redirect('user/user-house-for-sale');
		} 
	}

}

