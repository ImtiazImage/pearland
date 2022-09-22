<?php



class Usermodel extends CI_Model{

	function __construct() {
		parent::__construct();
		/*Validate Form*/

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('cookie');
	}
	function logged_user_id(){
		$session = $this->session->userdata('logged_user');
		$logged_id = $session['logged_id'];
		return $logged_id;
	}

	/*=========================
	        Register
	        ==========================*/

	        function registerUser(){
	        	$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
	        	$this->form_validation->set_rules('mobile_number', 'Phone', 'trim|required|min_length[10]|max_length[20]');
	        	$this->form_validation->set_rules('email_id', 'Email', 'trim|required|valid_email|is_unique[user.email_id]',
	        		array(
	        			'required'      => 'You have not provided %s.',
	        			'is_unique'     => 'This %s already exists.'
	        		)
	        	);

	        	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');

	        	if ($this->form_validation->run())
	        	{
	        		$form_data 		= array(
	        			'name'				=> htmlentities($this->input->post('name'), ENT_QUOTES),
	        			'email_id'				=> htmlentities($this->input->post('email_id'), ENT_QUOTES),
	        			'password'				=> md5($this->input->post('password')),
	        			'mobile_number'			=> htmlentities($this->input->post('mobile_number'), ENT_QUOTES),
	        			'hear_us'				=> htmlentities($this->input->post('hear_us'), ENT_QUOTES),
	        			'sale_representative'	=> htmlentities($this->input->post('sale_representative'), ENT_QUOTES),
	        			'user_zip_code'				=> htmlentities($this->input->post('zip_code'), ENT_QUOTES)
	        		);

	        		if($this->db->insert('user', $form_data)){ 
	        			return array('status'=>TRUE); 
	        		}else{ return array('status'=>FALSE, 'referror'=>'', 'message'=>'Something Wrong please try again!'); 
	        	}
	        }

	        return array('status'=>FALSE, 'referror'=>'');
	      }

	/*====================
		    Login
	=====================*/

    function login()
    {
    	$this->form_validation->set_rules('email_id', 'Email Address', 'required|trim|valid_email');

    	$this->form_validation->set_rules('password', 'Password', 'required');

    	if($this->form_validation->run())
    	{
    		$email_id = htmlentities($this->input->post('email_id'), ENT_QUOTES);
    		$password  = md5($this->input->post('password'));
    		$query = $this->db->query("SELECT * FROM user WHERE email_id = '$email_id' AND password = '$password'");
    		$result = $query->result();

    		if (sizeof($result) > 0) {

    			if($result[0]->banned != 1){

    				$sess_array = array( 'logged_id' => $result[0]->user_id );
    				$this->session->set_userdata('logged_user', $sess_array);

    				if(!empty($this->input->post('lastpage'))){
    					$lastpage = $this->input->post('lastpage');
    				}else{
    					$lastpage = 'dashboard';
    				}

    				return array('status' => TRUE, 'url' => $lastpage );

    			}else{

    				return array('status' => FALSE, 'message' => 'You account removed. Please Contact Administrator ' , 'url' => 'login' );
    			}
    		}

    	}else{
    		return array('status'=>FALSE, 'referror'=>'' ,'message' => 'Email OR Password Worng');
    	}
    	return array('status' => FALSE, 'message' => 'Email OR Password Worng' , 'url' => '' );
    }

	/*=======================
		Get Dashboard Info
	========================*/

	public function getDashboardCategories()
	{
		// return $data = $this->db->select('*')->from('listing_categories')->limit(8)->order_by('category_id','DESC')->get()->result();
		return $data = $this->db->select('listing_categories.category_name as cat_name, listing_categories.category_id as cat_id,count(listings.listing_id) as totalValue, listing_categories.category_image as cat_image')
						->from('listing_categories, listings')
						->where('listing_categories.category_id = listings.category_id')
						->limit(8)->group_by('listing_categories.category_id');

		/*return $data = $this->db->select('sub_cate.category_id, main_cate.category_name, sub_cate.sub_category_name, main_cate.category_id, sub_cate.created_at, sub_cate.sub_category_id')
	     ->from('listing_sub_categories as sub_cate')
	     ->join('listing_categories as main_cate', 'sub_cate.category_id = main_cate.category_id', 'LEFT')
	     ->get()
	     ->result();*/

	}

    public function getDashboardEvents()
    {
   		return $data = $this->db->select('*')
   						->from('events')
   						->limit(8)
   						->order_by('event_id','DESC')
   						->get()->result();
    }

   	public function getDashboardProducts()
   	{
   		return $data = $this->db->select('*')
   						->from('products')
   						->limit(5)
   						->order_by('product_id','DESC')
   						->get()->result();
   	}

	/*=======================
		Get User Information
	========================*/

	public function getUserInformation()
	{
		$session = $this->session->userdata('logged_user');
		$logged_id = $session['logged_id'];

		$result = $this->db->select('*')
					->from('user')
					->where('user_id',$logged_id)
					->get()->row();
		return $result;
	}

	/*==========================
	Get All Product Information
	===========================*/

	public function getAllProduct()
	{
		return $data = $this->db->get('products')->result();
	}

	/*==========================
	Get All Product Information
	===========================*/
	public function getAllCategory()
	{
		return $data = $this->db->get('listing_categories')->result();
	}

	/*==========================
		Get All Blog Information
	===========================*/
	public function getAllBlog()
	{
		return $data = $this->db->get('blogs')->result();
	}

	public function getAllBlogs($user_id = NULL, $limit = NULL, $offset=NULL)
	{
		return $data = $this->db->select('*')->from('blogs')
						->where('user_id',$user_id)
						->where('blog_status',1)
						->order_by('blog_id', 'DESC')
						->limit($limit,$offset)
						->get()->result();			
	}

	/*==========================
		Get All Event Information
	===========================*/
	public function getAllEvent($user_id = NULL, $limit = NULL, $offset=NULL)
	{
		return $data = $this->db->select('*')->from('events')
						->where('user_id',$user_id)
						->where('event_status',1)
						->order_by('event_id', 'DESC')
						->limit($limit,$offset)
						->get()->result();
	}

	/*==========================
	  Get All Event Information
	===========================*/
	public function get_events()
	{
		return $data = $this->db->where('event_status',1)->get('events')->result();        
	}

	/*==========================
		Add Event Information
	===========================*/
	public function addEvents($data)
	{
		$session = $this->session->userdata('logged_user');
		$logged_id = $session['logged_id'];

		$data['user_id'] = $logged_id;

		if($data['isenquiry'] == null)
		{
			$data['isenquiry'] = 0;
		}

		if($this->db->insert('events',$data))
		{
			return true;
		} else {
			return false;
		}
	}

	/*==========================
	  Delete Event Information
	===========================*/
	public function deleteUserEvent($id)
	{
	   	$data = $this->db->select('*')->from('events')->where('event_id',$id)->get()->row();

	   	$img = '';

	   	if($data->event_image)
	   	{
	   		$image_link = './'.$data->event_image;

	   		if(file_exists($image_link))
	   		{
	   			$img = $image_link;
	   		} else 
	   		{
	   			$img = '';
	   		}
	   	}

	   	if($this->db->where('event_id',$id)->delete('events'))
	   	{
	   		if ($img != '')
	   		{
	   			unlink($img);
	   			return true;
	   		} else {
	   			return true;
	   		}
	   	} else 
	   	{
	   		return false;
	   	}
	}

	/*====================
      LISTENING FUNCTION
    ====================*/	

    public function addListing($data)
    {
      	$session = $this->session->userdata('logged_user');
      	$logged_id = $session['logged_id'];
      	$data['user_id'] = $logged_id;

      	if($this->db->insert('listings',$data))
      	{
      		return true;
      	} else {
      		return false;
      	}   	
    }

    public function getAllListings()
    {
      	return $data = $this->db->select('*')->from('listings')
      	->where('listing_status',1)
      	->where('is_deleted',0)
      	->get()->result();		
    }


      public function getRandFiveFeatureListing()
      {
      	return $data = $this->db->select('*')->from('listings')
      	->where('listing_status',1)
      	->where('is_deleted',0)
      	->where('featured_listing',1)
      	->limit(3)
      	->order_by('rand()')
      	->get()->result();		
      }


      public function getListingsList()

      {

      	return $data = $this->db->select('listing_id,listing_name')->from('listings')->where('is_deleted',0)->get()->result_array();

      }



      public function getListingSingleValue($id,$table_id,$tableName)

      {

      	return $data = $this->db->select('*')->from($tableName)->where($table_id,$id)->get()->result_array();

      }



    // public function addListing($tableName, $data)

    // {

	// 	$session = $this->session->userdata('logged_user');

	// 	$logged_id = $session['logged_id'];

    //     $data['user_id'] = $logged_id;



    //     if($this->db->insert($tableName,$data))

    //     {

    //     	$inserted_id =$this->db->insert_id();

	// 		if($inserted_id > 0){

	// 			return $inserted_id;

	// 		} else {

	// 			return 0;

	// 		}  

    //     } else {

    //         return 0;

    //     }   	

    // }



      public function addDuplicateListing($tableName, $data)

      {



      	$session = $this->session->userdata('logged_user');

      	$logged_id = $session['logged_id'];

      	$data['user_id'] = $logged_id;



      	if($this->db->insert($tableName,$data))

      	{

      		return TRUE;

      	} else {

      		return FALSE;

      	}   	

      }



      public function getListingByCategory($cat_id=NULL, $limit = NULL, $offset=NULL)
      {
      	return $data = $this->db->select('listings.*,user.name')
      	->from('listings')
      	->join('user','listings.user_id = user.user_id')
      	->where('listings.category_id',$cat_id)
      	->where('listings.is_deleted',0)
      	->where('listings.listing_status',1)
      	->order_by('listings.listing_id','DESC')
      	->limit($limit,$offset)
      	->get()->result();
      }

    /***********
    ****NEWS****
    ***********/
    public function getlatest_news($limit)
    {
    	$data = $this->db->select('news.*,user.name')
    	->from('news')
    	->join('user','news.user_id = user.user_id')
    	->where('news_status',1)
    	->limit($limit)
    	->order_by('news_id','DESC')
    	->get()->result();
    	return $data;
    }




    public function getlatest_events($limit = NULL)
    {
    	return $this->db->select('events.*,user.name')
    	->from('events')
    	->join('user','events.user_id = user.user_id')
    	->where('event_status',1)
    	->limit($limit)
    	->order_by('event_id','DESC')
    	->get()->result();
    }





    public function getListingById($id = NULL, $limit = NULL, $offset=NULL)
    {
    	return $data = $this->db->select('*')->from('listings')
    	->where('user_id',$id)
    	->where('is_deleted',0)
    	->limit($limit,$offset)
    	->order_by('listing_id','DESC')
    	->get()->result();
    }





    public function productSubCategoryByCateId($id)

    {

    	return $data = $this->db->select('sub_cate.category_id, main_cate.category_name, sub_cate.sub_category_name, main_cate.category_id, sub_cate.created_at, sub_cate.sub_category_id')

    	->from('product_sub_categories as sub_cate')

    	->join('product_categories as main_cate', 'sub_cate.category_id = main_cate.category_id', 'LEFT')

    	->where('sub_cate.category_id',$id)

    	->get()->result();

    }	

	// public function getAllProducts($limit,$offset)
	// {
		// 	 $this->db->select("*,products.id as p_id");
		 //      $this->db->from('products');
		 //      $this->db->join('product_images', 'products.id = product_images.product_id');
		 //      $this->db->group_by('product_images.product_id')->limit($limit,$offset);
		 //      return $query = $this->db->get()->result();
	// }



	/*===================
    PRODUCTS FUNCTION
  ===================*/	
  public function getAllProducts()
  {
    $logged_id = $this->logged_user_id();

  	return $data = $this->db->select('*')->from('products')
                  ->where('user_id',$logged_id)
                	->where('product_status',1)
                	->where('is_deleted',0)
                	->get()->result();
  }

  public function getOnlyProduct($id)
  {
  	return $data = $this->db->select('*')->from('products')->where('product_id',$id)->get()->row();
  }

  public function getSingleProduct($id)
  {
    // $data['product'] = $this->db->select('*')->from('products')->where('product_id',$id)->get()->row();

    // $data['category']= $this->db->select('*')->from('product_categories')

    // 					->where('category_id',$data['product']->category_id)

    // 					->get()->row();

  	$data = $this->db->select('*,product_categories.category_name as cat_name, product_categories.category_id as pro_cat_id,user.name, user.user_created')
          	->from('products, product_categories,user')
          	->where('product_id',$id)
          	->where('products.category_id = product_categories.category_id')
          	->where('products.user_id = user.user_id')
          	->get()->row();

  	return $data;

  }





	/*==============
      BLOG FUNCTION
    ===============*/	

    public function getBlogs()
    {
      	return $data = $this->db->where('blog_status',1)->get('blogs')->result();
    }

    public function deleteBlog($id)
    {
      	$data = $this->db->select('*')->from('blogs')->where('blog_id',$id)->get()->row();

      	$img = '';

      	if($data->blog_image)
      	{
      		$image_link = './'.$data->blog_image;

      		if(file_exists($image_link))
      		{
      			$img = $image_link;
      		} else 
      		{
      			$img = '';
      		}
      	}

      	if($this->db->where('blog_id',$id)->delete('blogs'))
      	{
      		if ($img != '')
      		{
      			unlink($img);
      			return true;
      		} else {
      			return true;
      		}
      	} else 
      	{
      		return false;
      	}
    }



	/*============
		Coupon
	============*/
		public function getAllCoupons($user_id = NULL, $limit = NULL, $offset=NULL)
		{
			return $data = $this->db->select('*')->from('coupons')
			->where('coupon_user_id',$user_id)
			->where('coupon_status',1)
			->order_by('coupon_id', 'DESC')
			->limit($limit,$offset)
			->get()->result();
		}



		public function addCoupon($data)

		{

			$session = $this->session->userdata('logged_user');

			$logged_id = $session['logged_id'];

			$data['coupon_user_id'] = $logged_id;



			if($this->db->insert('coupons',$data))

			{

				return true;

			} else {

				return false;

			}

		}



	/*==================
      COMMON FUNCTION
    ==================*/
    public function getAllValues($tableName)
    {
      	return $data = $this->db->get($tableName)->result();
    }

    public function getAllListingCategory()
    {
      	return $this->db->select('*')
		      	->from('listing_categories')
		      	->order_by('category_name','ASC')
		      	->get()->result();
    }

    public function getSingleValue($id,$table_id,$tableName)
    {
      	return $data = $this->db->select('*')
      					->from($tableName)
      					->where($table_id,$id)
      					->get()->row();
    }

    public function getRelatedListing($tableName,$listing_id,$category_id)

    {
      	$where = "WHERE listing_slug !='".$listing_id."' AND category_id = '".$category_id."'";

      	return $this->db->query("SELECT * FROM $tableName $where ORDER BY listing_id DESC LIMIT 3")->result();

    }

    public function add($tableName, $data)
    {
      	$session = $this->session->userdata('logged_user');
      	$logged_id = $session['logged_id'];
      	$data['user_id'] = $logged_id;

      	if($this->db->insert($tableName,$data))
      	{
      		return TRUE; 
      	} else {
      		return FALSE;
      	}
    }



      public function update($id,$info,$table_id,$tableName)

      {

      	if($this->db->where($table_id,$id)->update($tableName,$info)){

      		return true;

      	} else {

      		return false;

      	}

      }




      public function getDashboardInfo($tableName, $isDeleted=NULL, $limit = NULL)

      {

      	$limiter = '';

      	$where 	 = '';



      	if($limit != NULL){

      		$limiter = $limit;

      	}



      	if($isDeleted != NULL){

      		$where = 'WHERE is_deleted = '.$isDeleted;

      	} 



      	$query = $this->db->query("SELECT * FROM $tableName $where LIMIT 10")->result();



      	return $query;

      }



      public function dashboardInfo($tableName, $status=NULL, $isDeleted=NULL, $limit = NULL)

      {

      	$limiter = '';

      	$where 	 = '';



      	if($limit != NULL){

      		$limiter = $limit;

      	}



      	if($isDeleted != NULL){

      		$where = 'WHERE '.$status.' = '.$isDeleted;

      	} 



      	$query = $this->db->query("SELECT * FROM $tableName $where LIMIT 10")->result();



      	return $query;

      }





      public function getEnquiries($receivingUserId)

      {

      	return $data = $this->db->select('*')->from('enquiries')

      	->where('receiving_user_id',$receivingUserId)

      	->get()->result();

      }



      public function addEnquiry($data)

      {

      	if ($this->db->insert('enquiries',$data)) {

      		return true;

      	} else {

      		return false;

      	}

      }





      public function claimBusiness($data)

      {

      	if ($this->db->insert('claim_listings',$data)) {

      		return true;

      	} else {

      		return false;

      	}

      }





	/*********************

	 ***   ADS QUERY   ***

	 *********************/



	public function getAllAds($user_id = NULL, $limit = NULL, $offset=NULL)

	{

		return $data = $this->db->select('ads.*,u.name as username,u.profile_image as user_image,u.user_created as user_join,ap.name as ads_price_name')

		->from('ads')

		->where('ads.u_id',$user_id)

		->where('ads.ad_status',1)

		->join('user as u','ads.u_id = u.user_id')

		->join('ads_prices as ap','ads.ads_price_id = ap.id')

		->get()->result();

	}



	public function addAds($tableName, $data)

	{

		$session = $this->session->userdata('logged_user');

		$logged_id = $session['logged_id'];

		$data['u_id'] = $logged_id;

		// echo "<pre>";var_dump($data);die();

		if($this->db->insert($tableName,$data))

		{

			return TRUE; 

		} else {

			return FALSE;

		}

	}



	/*==================
        ADS PRICE
    ==================*/
    public function allAdsPrices()
    {
    	return $this->db->where('status',1)->get('ads_prices')->result();
    }

    public function getAdsPrice($id)
    {
    	return $this->db->where('id',$id)->get('ads_prices')->row();
    }

    public function updateAdsPrice($id,$info)
    {
    	if($this->db->where('id',$id)->update('ads_prices',$info)){
    		return true;
    	} else {
    		return false;
    	}
    }	    

    public function getHPBSLAds()
    {
    	return $this->db->select('ads.*,ap.name')
	        	->from('ads')
	        	->join('ads_prices as ap','ads.ads_price_id = ap.id')
	        	->where('ads.ad_status',1)
	        	->where('ap.name','Home Page Below Slider left')
	        	->order_by('rand()')
	        	->get()->row();
    }

    public function getHPBSRAds()
    {
    	return $this->db->select('ads.*,ap.name')
	        	->from('ads')
	        	->join('ads_prices as ap','ads.ads_price_id = ap.id')
	        	->where('ads.ad_status',1)
	        	->where('ap.name','Home Page Below Slider right')
	        	->order_by('rand()')
	        	->get()->row();
    }

    public function getFBR1Ads()
    {
    	return $this->db->select('ads.*,ap.name')
	        	->from('ads')
	        	->join('ads_prices as ap','ads.ads_price_id = ap.id')
	        	->where('ads.ad_status',1)
	        	->where('ap.name','Feature Business Right 1')
	        	->order_by('rand()')
	        	->get()->row();
    }

    public function getFBR2Ads()
    {
    	return $this->db->select('ads.*,ap.name')
	        	->from('ads')
	        	->join('ads_prices as ap','ads.ads_price_id = ap.id')
	        	->where('ads.ad_status',1)
	        	->where('ap.name','Feature Business Right 2')
	        	->order_by('rand()')
	        	->get()->row();
    }

    public function getFBR3Ads()
    {
    	return $this->db->select('ads.*,ap.name')
		    	->from('ads')
		    	->join('ads_prices as ap','ads.ads_price_id = ap.id')
		    	->where('ads.ad_status',1)
		    	->where('ap.name','Feature Business Right 3')
		    	->order_by('rand()')
		    	->get()->row();
    }

    public function getAFLAds()
    {
    	return $this->db->select('ads.*,ap.name')
	        	->from('ads')
	        	->join('ads_prices as ap','ads.ads_price_id = ap.id')
	        	->where('ads.ad_status',1)
	        	->where('ap.name','Above Footer Left')
	        	->order_by('rand()')
	        	->get()->row();
    }

    public function getSpotlightListing($tableName, $limit = NULL, $type = NULL)
    {
    	return $data = $this->db->select('listings.*,user.name,listing_categories.category_name')
		    	->from('listings')
		    	->join('user','listings.user_id = user.user_id')
		    	->join('listing_categories','listings.category_id = listing_categories.category_id')
		    	->where('listings.spotlight_listing',1)
		    	->where('listings.is_deleted',0)
		    	->where('listings.listing_status',1)
		    	->order_by('listings.listing_id','DESC')
		    	->limit($limit)
		    	->get()->result();
    }

    public function getFeaturedListing($tableName, $limit = NULL, $type = NULL)
    {
    	return $data = $this->db->select('listings.*,user.name,listing_categories.category_name')
			    	->from('listings')
			    	->join('user','listings.user_id = user.user_id')
			    	->join('listing_categories','listings.category_id = listing_categories.category_id')
			    	->where('listings.featured_listing',1)
			    	->where('listings.is_deleted',0)
			    	->where('listings.listing_status',1)
			    	->order_by('listings.listing_id','DESC')
			    	->limit($limit)
			    	->get()->result();
    }


    /*User News Functions*/
    public function getUserNews()
    {
      	$logged_id = $this->logged_user_id();

      	return $data = $this->db->select('*')->from('news')
	      	->where('user_id',$logged_id)
	      	->where('news_status',1)
	      	->where('is_deleted',0)
	      	->order_by('news_id','DESC')
	      	->get()->result();
    }

	public function deleteNews($id)
    {
      	$data = $this->db->select('*')->from('news')->where('news_id',$id)->get()->row();

      	$img = '';

      	if($data->news_image)
      	{
      		$image_link = './'.$data->news_image;

      		if(file_exists($image_link))
      		{
      			$img = $image_link;
      		} else 
      		{
      			$img = '';
      		}
      	}

      	if($this->db->where('news_id',$id)->delete('news'))
      	{
      		if ($img != '')
      		{
      			unlink($img);
      			return true;
      		} else {
      			return true;
      		}
      	} else 
      	{
      		return false;
      	}
    }


	/*=================
        User Video
    =================*/
	public function getVideo()
	{
      	$logged_id = $this->logged_user_id();

		return $data = $this->db->select('video.video_id,video.video_title, video.video_description,video.video_status,video.created_at,video.video_image, user.user_id,user.name,categories.category_name')
			->from('video')
			->where('video.user_id',$logged_id)
			->join('user','user.user_id = video.user_id','LEFT')
			->join('video_categories as categories', 'categories.category_id = video.video_category_id', 'LEFT')
			->order_by('video_id','DESC')
			->get()->result();
	}

	public function allVideoCategory()
	{
		return $data = $this->db->select('*')
					->from('video_categories')
					->order_by('category_name', 'ASC')
					->get()->result();
	}
	public function deleteVideo($id)
	{
		$data = $this->db->select('*')->from('video')->where('video_id',$id)->get()->row();

		$img = '';

		if($data->video_image)
		{
			$image_link = './'.$data->video_image;

			if(file_exists($image_link))
			{
				$img = $image_link;
			} else 
			{
				$img = '';
			}
		}

		if($this->db->where('video_id',$id)->delete('video'))
		{
			if ($img != '')
			{
				unlink($img);
				return true;
			} else {
				return true;
			}
		} else 
		{
			return false;
		}
	}


	/*==================
        Classifieds
    ==================*/
    // Category //
	public function allClassifiedsCategory()
	{
		return $data = $this->db->select('*')
					->from('classifieds_categories')
					->order_by('category_name', 'ASC')
					->get()->result();
	}

	public function getClassifieds()
	{
      	$logged_id = $this->logged_user_id();

		return $data = $this->db->select('classifieds.classifieds_id,classifieds.classifieds_title, classifieds.classifieds_description,classifieds.classifieds_status,classifieds.created_at,classifieds.classifieds_image, user.user_id,user.name,categories.category_name')
				->from('classifieds')
				->where('classifieds.user_id',$logged_id)
				->join('user','user.user_id = classifieds.user_id','LEFT')
				->join('classifieds_categories as categories', 'categories.category_id = classifieds.classifieds_category_id', 'LEFT')
				->order_by('classifieds_id','DESC')
				->get()->result();
	}

	public function deleteClassifieds($id)
	{
		$data = $this->db->select('*')->from('classifieds')->where('classifieds_id',$id)->get()->row();

		$img = '';

		if($data->video_image)
		{
			$image_link = './'.$data->video_image;

			if(file_exists($image_link))
			{
				$img = $image_link;
			} else 
			{
				$img = '';
			}
		}

		if($this->db->where('classifieds_id',$id)->delete('classifieds'))
		{
			if ($img != '')
			{
				unlink($img);
				return true;
			} else {
				return true;
			}
		} else 
		{
			return false;
		}
	}


	/*==========================
        Apartments & Rentals    
    ==========================*/
	public function getRental()
	{
		$logged_id = $this->logged_user_id();

		return $data = $this->db->select('*')
						->from('rental')
						->where('rental.user_id',$logged_id)
						->join('rental_categories as categories', 'categories.category_id = rental.rental_category_id', 'LEFT')
						->order_by('rental_id','DESC')
						->get()->result();
	}
	/*=====================================
		Get Rental Category Information
	=====================================*/

	public function allRentalCategory()
	{
		return $data = $this->db->select('*')
						->from('rental_categories')
						->order_by('category_name', 'ASC')
						->get()->result();
	}

	public function deleteRental($id)
	{
		$data = $this->db->select('*')->from('rental')->where('rental_id',$id)->get()->row();
		$img = '';

		if($data->video_image)
		{
			$image_link = './'.$data->video_image;

			if(file_exists($image_link))
			{
				$img = $image_link;
			} else 
			{
				$img = '';
			}
		}

		if($this->db->where('rental_id',$id)->delete('rental'))
		{
			if ($img != '')
			{
				unlink($img);
				return true;
			} else {
				return true;
			}
		} else 
		{
			return false;
		}
	}



	/*===========
		House
	===========*/

	public function allHouseCategory()
	{
		return $data = $this->db->select('*')
						->from('house_categories')
						->order_by('category_name', 'ASC')
						->get()->result();
	}

	public function getHouse()
	{
		$logged_id = $this->logged_user_id();

		return $data = $this->db->select('*')
					->from('house')
					->where('house.user_id',$logged_id)
					->join('user','user.user_id = house.user_id','LEFT')
					->join('house_categories as categories', 'categories.category_id = house.house_category_id', 'LEFT')
					->order_by('house_id','DESC')
					->get()->result();
	}

	public function deleteHouse($id)
	{

		$data = $this->db->select('*')->from('house')->where('house_id',$id)->get()->row();

		$img = '';

		if($data->video_image)
		{
			$image_link = './'.$data->house_image;

			if(file_exists($image_link))
			{
				$img = $image_link;
			} else 
			{
				$img = '';
			}
		}


		if($this->db->where('house_id',$id)->delete('house'))
		{
			if ($img != '')
			{
				unlink($img);
				return true;
			} else {
				return true;
			}
		} else 
		{
			return false;
		}				
	}

}