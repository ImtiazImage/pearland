<?php

class Adminmodel extends CI_Model{
	function __construct() {

		parent::__construct();

		/*Validate Form*/

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->load->library('session');

		$this->load->helper('cookie');

	}

	/*====================

		Login

		=====================*/

		function login(){

			$this->form_validation->set_rules('admin_email', 'Email Address', 'required|trim|valid_email');

			$this->form_validation->set_rules('admin_password', 'Password', 'required');

			if($this->form_validation->run())

			{

				$admin_email = htmlentities($this->input->post('admin_email'), ENT_QUOTES);

				$admin_password  = md5($this->input->post('admin_password'));

				$query = $this->db->query("SELECT * FROM admin WHERE admin_email = '$admin_email' AND admin_password = '$admin_password'");

				$result = $query->result();

				if (sizeof($result) > 0) {

					if($result[0]->banned != 1){

						$sess_array = array( 'logged_id' => $result[0]->admin_id );

						$this->session->set_userdata('logged_user', $sess_array);

						return array('status' => TRUE, 'url' => 'admin/dashboard' );

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
		Get Admin Information
		========================*/

		public function getAdminInformation(){

		/*$session = $this->session->userdata('logged_user');

		$logged_id = $session['logged_id'];

		$result =  $this->db->query("SELECT * FROM user WHERE user_id = $logged_id LIMIT 1");

		$result = $result->result();

		return $result[0];*/

	}
	
	/*===================================
		Get Users
		====================================*/

		public function get_users()
		{
			return $data = $this->db->select('name,user_id')->from('user')->order_by('name', 'ASC')->get()->result();
		}

	/*===================================
		Get Listing Category Information
		====================================*/

		public function allListingCategory()
		{
			return $data = $this->db->select('*')->from('listing_categories')->order_by('category_id', 'DESC')->get()->result();
		}
		
	/*=======================
		Add Listing Category Information
		========================*/
		
		public function addListingCategory($data)
		{
			if($this->db->insert('listing_categories', $data)){
				return true;
			} else {
				return false;
			}
		}

	/*===================================
     Update Listing Category Information
     ====================================*/

     public function updateListingCategory($id,$info)
     {
     	if($this->db->where('category_id',$id)->update('listing_categories',$info)){
     		return true;
     	} else {
     		return false;
     	}
     }

	/*===================================
		Delete Listing Category Information
		====================================*/

		public function deleteCategory($id)
		{
			$data = $this->db->select('*')->from('listing_categories')->where('category_id',$id)->get()->row();
			$img = '';
			if($data->category_image)
			{
				$image_link = './'.$data->category_image;
				
				if(file_exists($image_link))
				{
					$img = $image_link;
				} else 
				{
					$img = '';
				}
			}
			
			if($this->db->where('category_id',$id)->delete('listing_categories'))
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
		
		
	/*===================================
		Get Listing Sub Category Information
		====================================*/

		public function allListingSubCategory()
		{
			return $data = $this->db->select('sub_cate.category_id, main_cate.category_name, sub_cate.sub_category_name, main_cate.category_id, sub_cate.created_at, sub_cate.sub_category_id')
			->from('listing_sub_categories as sub_cate')
			->join('listing_categories as main_cate', 'sub_cate.category_id = main_cate.category_id', 'LEFT')
			->get()
			->result();
		}
	/*=======================================
	 Add Listing Sub Category Information
	 ========================================*/

	 public function addListingSubCategory($data)
	 {
	 	if($this->db->insert('listing_sub_categories', $data)){
	 		return true;
	 	} else {
	 		return false;
	 	}

	 }
	/*=======================================
	 Get Single Listing Sub Category Information
	 ========================================*/

	 public function get_listing_sub_category_ById($id)
	 {
	 	return $data = $this->db->select('*')->from('listing_sub_categories')->where('sub_category_id',$id)->get()->row();
	 }
	/*=======================================
	 Get Listing Sub Category Information By Main Category ID
	 ========================================*/

	 public function ListingSubCategoryByCateId($id)
	 {
	 	return $data = $this->db->select('sub_cate.category_id, main_cate.category_name, sub_cate.sub_category_name, main_cate.category_id, sub_cate.created_at, sub_cate.sub_category_id')
	 	->from('listing_sub_categories as sub_cate')
	 	->join('listing_categories as main_cate', 'sub_cate.category_id = main_cate.category_id', 'LEFT')
	 	->where('sub_cate.category_id',$id)
	 	->get()
	 	->result();
	 }
	/*=======================================
	 Update Listing Sub Category Information
	 ========================================*/

	 public function updateListingSubCategory($id,$info)
	 {
	 	if($this->db->where('sub_category_id',$id)->update('listing_sub_categories',$info)){
	 		return true;
	 	} else {
	 		return false;
	 	}
	 }
	 
	/*===================================
		Delete Listing Category Information
		====================================*/

		public function deleteListingSubCategory($id)
		{
			if($this->db->where('sub_category_id',$id)->delete('listing_sub_categories'))
			{
				return true;
			} else 
			{
				return false;
			}
		}
		
	/*===================================
		Get Product Category Information
		====================================*/
		public function allProductCategory()
		{
			return $data = $this->db->select('main_cate.category_id, main_cate.category_name, main_cate.category_image, main_cate.created_at, count(products.category_id) as total_product , count(sub_cate.category_id) as total_sub_cate ')
			->from('product_categories as main_cate')
			->join('product_sub_categories as sub_cate', 'sub_cate.category_id = main_cate.category_id', 'LEFT')
			->join('products', 'products.category_id = main_cate.category_id', 'LEFT')
			->group_by("main_cate.category_id")
			->get()
			->result();
		}

	/*===================================
		Add Product Category Information
		====================================*/
		public function addProductCategory($data)
		{
			if($this->db->insert('product_categories', $data)){
				return true;
			} else {
				return false;
			}

		}
	/*=======================================
	 Get Single Listing Sub Category Information
	 ========================================*/

	 public function get_product_category_ById($id)
	 {
	 	return $data = $this->db->select('*')->from('product_categories')->where('category_id',$id)->get()->row();
	 }
	/*=======================================
	 Update Product Category Information
	 ========================================*/

	 public function updateProductCategory($id,$info)
	 {
	 	if($this->db->where('category_id',$id)->update('product_categories',$info)){
	 		return true;
	 	} else {
	 		return false;
	 	}
	 }
	/*=======================================
	 Delete Product Category 
	 ========================================*/
	 public function deleteProductCategory($id)
	 {
	 	$data = $this->db->select('*')->from('product_categories')->where('category_id',$id)->get()->row();
	 	$img = '';
	 	if($data->category_image)
	 	{
	 		$image_link = './'.$data->category_image;
	 		
	 		if(file_exists($image_link))
	 		{
	 			$img = $image_link;
	 		} else 
	 		{
	 			$img = '';
	 		}
	 	}
	 	
	 	if($this->db->where('category_id',$id)->delete('product_categories'))
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
	/*===================================
		Get Product Sub Category Information
	====================================*/

		public function allProductSubCategory()
		{
			return $data = $this->db->select('sub_cate.category_id, main_cate.category_name, sub_cate.sub_category_name, main_cate.category_id, sub_cate.created_at, sub_cate.sub_category_id,count(products.sub_category_id) as total_product ')
			->from('product_sub_categories as sub_cate')
			->join('product_categories as main_cate', 'sub_cate.category_id = main_cate.category_id', 'LEFT')
			->join('products', 'products.sub_category_id = sub_cate.sub_category_id', 'LEFT')
			->group_by("sub_cate.sub_category_id")
			->get()
			->result();
		}
	/*=======================================
	 Add Product Sub Category Information
	 ========================================*/

	 public function addProductSubCategory($data)
	 {
	 	if($this->db->insert('product_sub_categories', $data)){
	 		return true;
	 	} else {
	 		return false;
	 	}

	 }
	/*===========================================
	 Get Single Product Sub Category Information
	 ==========================================*/

	 public function get_product_sub_category_ById($id)
	 {
	 	return $data = $this->db->select('*')->from('product_sub_categories')->where('sub_category_id',$id)->get()->row();
	 }
	/*=======================================================
	 Get Product Sub Category Information By Main Category ID
	 ======================================================*/

	 // public function ProductSubCategoryByCateId($id)
	 // {
	 // 	return $data = $this->db->select('sub_cate.category_id, main_cate.category_name, sub_cate.sub_category_name, main_cate.category_id, sub_cate.created_at, sub_cate.sub_category_id')
	 // 	->from('product_sub_categories as sub_cate')
	 // 	->join('product_categories as main_cate', 'sub_cate.category_id = main_cate.category_id', 'LEFT')
	 // 	->where('sub_cate.category_id',$id)
	 // 	->get()
	 // 	->result();
	 // }
	/*=======================================
	 Update Product Sub Category Information
	========================================*/

	 public function updateProductSubCategory($id,$info)
	 {
	 	if($this->db->where('sub_category_id',$id)->update('product_sub_categories',$info)){
	 		return true;
	 	} else {
	 		return false;
	 	}
	 }
	 
	/*===================================
		Delete Product Category Information
	====================================*/

		public function deleteProductSubCategory($id)
		{
			if($this->db->where('sub_category_id',$id)->delete('product_sub_categories'))
			{
				return true;
			} else 
			{
				return false;
			}
		}


	/*========================================================
	 Get Product Sub Category Information By Main Category ID
	========================================================*/

	 public function ProductSubCategoryByCateId($id)
	 {
	 	return $data = $this->db->select('sub_cate.category_id, main_cate.category_name, sub_cate.sub_category_name, main_cate.category_id, sub_cate.created_at, sub_cate.sub_category_id')
	 	->from('product_sub_categories as sub_cate')
	 	->join('product_categories as main_cate', 'sub_cate.category_id = main_cate.category_id', 'LEFT')
	 	->where('sub_cate.category_id',$id)
	 	->get()
	 	->result();
	 }



	/*======================
		Get All Slider
	======================*/

		public function allSlider()
		{
			return $data = $this->db->get('slider')->result();
		}
		
	/*=======================
		Add Sliter
	========================*/
		
	public function addSlider($data)
	{
		if($this->db->insert('slider', $data)){
			return true;
		} else {
			return false;
		}

	}

	/*=======================================
	 	Get Single Slider Information
	========================================*/

	 public function getsliderByid($id)
	 {
	 	return $data = $this->db->select('*')->from('slider')->where('slider_id',$id)->get()->row();
	 }


	/*===================================
     	Update Slider Information
    ====================================*/

	public function updateSlider($id,$info)
	{
	 	if($this->db->where('slider_id',$id)->update('slider',$info)){
	 		return true;
	 	} else {
	 		return false;
	 	}
	}
	/*===================================
		Delete Slider Information
	====================================*/

		public function deleteSlider($id)
		{
			$data = $this->db->select('*')->from('slider')->where('slider_id',$id)->get()->row();
			$img = '';
			if($data->slider_photo)
			{
				$image_link = './'.$data->slider_photo;
				
				if(file_exists($image_link))
				{
					$img = $image_link;
				} else 
				{
					$img = '';
				}
			}
			
			if($this->db->where('slider_id',$id)->delete('slider'))
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
		Get All Event Information
		===========================*/

		public function get_events(){
			return $data = $this->db->select('events.event_id, events.user_id, events.event_start_date, events.event_name,events.event_status, user.name, events.created_at')
			->from('events')
			->join('user', 'user.user_id = events.user_id', 'LEFT')
			->order_by('events.event_id', 'DESC')
			->get()
			->result();
		}

	/*==========================
		Add Event Information
		===========================*/

		public function addEvent($data)
		{

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

	   public function deleteEvent($id)
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
	   
	   
	   
	/*==========================
		Get All Product Information
		===========================*/

		public function getAllProduct(){
			return $data = $this->db->get('products')->result();
		}
		
		
	/*===================
      PRODUCTS FUNCTION
      ===================*/	
      
      public function getAllProducts()
      {
      	return $data = $this->db->select('*')->from('products')->where('is_deleted',0)->get()->result();
      }


      public function getOnlyProduct($product_slug)
      {
      	return $data = $this->db->select('*')->from('products')->where('product_slug',$product_slug)->get()->row();
      }

      public function getSingleProduct($product_slug)
      {
        // $data['product'] = $this->db->select('*')->from('products')->where('product_id',$id)->get()->row();
        // $data['category']= $this->db->select('*')->from('product_categories')
        // 					->where('category_id',$data['product']->category_id)
        // 					->get()->row();
      	$data = $this->db->select('*,product_categories.category_name as cat_name, product_categories.category_id as pro_cat_id,user.name, user.user_created')
      	->from('products, product_categories,user')
      	->where('product_slug',$product_slug)
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
		return $data = $this->db->select('*')
						->from('blogs')
						->order_by('blog_id','DESC')
						->get()->result();
      	// return $data = $this->db->get('blogs')->order_by('blog_id', DESC)->result();
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
  		/*==============
      News FUNCTION
      ===============*/	
      
      
      public function getNews()
      {
      	return $data = $this->db->select('news.news_id,news.news_title, news.news_description,news.news_status,news.created_at,news.news_image, user.user_id,user.name,categories.category_name')->from('news')
      	->join('user','user.user_id = news.user_id','LEFT')
      	->join('news_categories as categories', 'categories.category_id = news.news_category_id', 'LEFT')
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
      /*===================================
			Get News Category Information
			====================================*/

			public function allNewsCategory()
			{
				return $data = $this->db->select('*')->from('news_categories')->order_by('category_name', 'ASC')->get()->result();
			}
			
			/*=======================
			Add News Category Information
			========================*/
			
			public function addNewsCategory($data)
			{
				if($this->db->insert('news_categories', $data)){
					return true;
				} else {
					return false;
				}
			}

			/*===================================
	     Update News Category Information
	     ====================================*/

	     public function updateNewsCategory($id,$info)
	     {
	     	if($this->db->where('category_id',$id)->update('news_categories',$info)){
	     		return true;
	     	} else {
	     		return false;
	     	}
	     }

			/*===================================
			Delete News Category Information
			====================================*/

			public function deleteNewsCategory($id)
			{
				$data = $this->db->select('*')->from('news_categories')->where('category_id',$id)->get()->row();
				$img = '';
				if($data->category_image)
				{
					$image_link = './'.$data->category_image;
					
					if(file_exists($image_link))
					{
						$img = $image_link;
					} else 
					{
						$img = '';
					}
				}
				
				if($this->db->where('category_id',$id)->delete('news_categories'))
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
			/*********** VIDEO SECTION **********/

			/*===================================
			Get Video Category Information
			====================================*/

			public function allVideoCategory()
			{
					return $data = $this->db->select('*')
					->from('video_categories')
					->order_by('category_name', 'ASC')
					->get()->result();
			}
			/*=======================
			Add Video Category Information
			========================*/
			
			public function addVideoCategory($data)
			{
				if($this->db->insert('video_categories', $data)){
					return true;
				} else {
					return false;
				}
			}

			/*===================================
	     Update Video Category Information
	     ====================================*/

	     public function updateVideoCategory($id,$info)
	     {
	     	if($this->db->where('category_id',$id)->update('video_categories',$info)){
	     		return true;
	     	} else {
	     		return false;
	     	}
	     }

			/*===================================
			Delete Video Category Information
			====================================*/

			public function deleteVideoCategory($id)
			{
				$data = $this->db->select('*')->from('video_categories')->where('category_id',$id)->get()->row();
				$img = '';
				if($data->category_image)
				{
					$image_link = './'.$data->category_image;
					
					if(file_exists($image_link))
					{
						$img = $image_link;
					} else 
					{
						$img = '';
					}
				}
				
				if($this->db->where('category_id',$id)->delete('video_categories'))
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
			public function getVideo()
			{
				return $data = $this->db->select('video.video_id,video.video_title, video.video_description,video.video_status,video.created_at,video.video_image, user.user_id,user.name,categories.category_name')->from('video')
				->join('user','user.user_id = video.user_id','LEFT')
				->join('video_categories as categories', 'categories.category_id = video.video_category_id', 'LEFT')
				->order_by('video_id','DESC')
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


			/*********** VIDEO SECTION **********/

			/*********** CLASSIFIED SECTION START**********/
			/*===================================
			Get classified Category Information
			====================================*/

			public function allClassifiedsCategory()
			{
				return $data = $this->db->select('*')
							->from('classifieds_categories')
							->order_by('category_name', 'ASC')
							->get()->result();
			}
			/*=======================
			Add classified Category Information
			========================*/
			
			public function addClassifiedsCategory($data)
			{
				if($this->db->insert('classifieds_categories', $data)){
					return true;
				} else {
					return false;
				}
			}
			/*===================================
     		Update classified Category Information
     		====================================*/

     		public function updateClassifiedsCategory($id,$info)
     		{
     			if($this->db->where('category_id',$id)->update('classifieds_categories',$info)){
     				return true;
     			} else {
     				return false;
     			}
     		}
     	/*===================================
			Delete classified Category Information
			====================================*/
			public function deleteClassifiedsCategory($id)
			{
				$data = $this->db->select('*')->from('classifieds_categories')->where('category_id',$id)->get()->row();
				$img = '';
				if($data->category_image)
				{
					$image_link = './'.$data->category_image;
					
					if(file_exists($image_link))
					{
						$img = $image_link;
					} else 
					{
						$img = '';
					}
				}
				
				if($this->db->where('category_id',$id)->delete('classifieds_categories'))
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
			public function getClassifieds()
			{
				return $data = $this->db->select('classifieds.classifieds_id,classifieds.classifieds_title, classifieds.classifieds_description,classifieds.classifieds_status,classifieds.created_at,classifieds.classifieds_image, user.user_id,user.name,categories.category_name')->from('classifieds')
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

			/*********** CLASSIFIED SECTION END**********/
			/*********** marketplace SECTION START**********/
			/*===================================
			Get marketplace Category Information
			====================================*/

			public function allmarketplaceCategory()
			{
				return $data = $this->db->select('*')->from('marketplace_categories')->order_by('category_name', 'ASC')->get()->result();
			}
			/*=======================
			Add marketplace Category Information
			========================*/
			
			public function addmarketplaceCategory($data)
			{
				if($this->db->insert('marketplace_categories', $data)){
					return true;
				} else {
					return false;
				}
			}
			/*===================================
     		Update marketplace Category Information
     		====================================*/

     		public function updatemarketplaceCategory($id,$info)
     		{
     			if($this->db->where('category_id',$id)->update('marketplace_categories',$info)){
     				return true;
     			} else {
     				return false;
     			}
     		}
     	/*===================================
			Delete marketplace Category Information
			====================================*/
			public function deletemarketplaceCategory($id)
			{
				$data = $this->db->select('*')->from('marketplace_categories')->where('category_id',$id)->get()->row();
				$img = '';
				if($data->category_image)
				{
					$image_link = './'.$data->category_image;
					
					if(file_exists($image_link))
					{
						$img = $image_link;
					} else 
					{
						$img = '';
					}
				}
				
				if($this->db->where('category_id',$id)->delete('marketplace_categories'))
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
			public function getmarketplace()
			{
				return $data = $this->db->select('marketplace.marketplace_id,marketplace.marketplace_title, marketplace.marketplace_description,marketplace.marketplace_status,marketplace.created_at,marketplace.marketplace_image, user.user_id,user.name,categories.category_name')->from('marketplace')
				->join('user','user.user_id = marketplace.user_id','LEFT')
				->join('marketplace_categories as categories', 'categories.category_id = marketplace.marketplace_category_id', 'LEFT')
				->order_by('marketplace_id','DESC')
				->get()->result();
			}

			public function deletemarketplace($id)
			{
				$data = $this->db->select('*')->from('marketplace')->where('marketplace_id',$id)->get()->row();

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


				if($this->db->where('marketplace_id',$id)->delete('marketplace'))
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

			/*********** marketplace SECTION END**********/

			/*********** Rental SECTION START**********/

			/*===================================
			Get Rental Category Information
			====================================*/

			public function allRentalCategory()
			{
				return $data = $this->db->select('*')->from('rental_categories')->order_by('category_name', 'ASC')->get()->result();
			}
			/*=======================
			Add Rental Category Information
			========================*/
			
			public function addRentalCategory($data)
			{
				if($this->db->insert('rental_categories', $data)){
					return true;
				} else {
					return false;
				}
			}
			/*===================================
     		Update Rental Category Information
     	====================================*/

     	public function updateRentalCategory($id,$info)
     	{
     		if($this->db->where('category_id',$id)->update('rental_categories',$info)){
     			return true;
     		} else {
     			return false;
     		}
     	}
     	/*===================================
			Delete Rental Category Information
			====================================*/
			public function deleteRentalCategory($id)
			{
				$data = $this->db->select('*')->from('rental_categories')->where('category_id',$id)->get()->row();
				$img = '';
				if($data->category_image)
				{
					$image_link = './'.$data->category_image;
					
					if(file_exists($image_link))
					{
						$img = $image_link;
					} else 
					{
						$img = '';
					}
				}
				
				if($this->db->where('category_id',$id)->delete('rental_categories'))
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
			public function getRental()
			{
				return $data = $this->db->select('*')->from('rental')
				->join('user','user.user_id = rental.user_id','LEFT')
				->join('rental_categories as categories', 'categories.category_id = rental.rental_category_id', 'LEFT')
				->order_by('rental_id','DESC')
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


			/*********** RENTAL SECTION END**********/


			/*********** HOUSE FOR SALE SECTION START**********/
			/*===================================
			Get House Category Information
			====================================*/

			public function allHouseCategory()
			{
				return $data = $this->db->select('*')->from('house_categories')->order_by('category_name', 'ASC')->get()->result();
			}
			/*=======================
			Add House Category Information
			========================*/
			
			public function addHouseCategory($data)
			{
				if($this->db->insert('house_categories', $data)){
					return true;
				} else {
					return false;
				}
			}
			/*===================================
     		Update House Category Information
     	====================================*/

     	public function updateHouseCategory($id,$info)
     	{
     		if($this->db->where('category_id',$id)->update('house_categories',$info)){
     			return true;
     		} else {
     			return false;
     		}
     	}
     	/*===================================
			Delete House Category Information
			====================================*/
			public function deleteHouseCategory($id)
			{
				$data = $this->db->select('*')->from('house_categories')->where('category_id',$id)->get()->row();
				$img = '';
				if($data->category_image)
				{
					$image_link = './'.$data->category_image;
					
					if(file_exists($image_link))
					{
						$img = $image_link;
					} else 
					{
						$img = '';
					}
				}
				
				if($this->db->where('category_id',$id)->delete('house_categories'))
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

			public function getHouse()
			{
				return $data = $this->db->select('*')->from('house')
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
			
/*********** HOUSE FOR SALE SECTION END**********/

	/*==================
    	Add LISTINGS
    ==================*/
    public function addListing($data)
    {
    	if($this->db->insert('listings',$data))
    	{
    		return true;
    	} else {
    		return false;
    	}   	
    }


    /*==============
		LISTINGS
    ==============*/
    public function getAllListings($limit=NULL, $offset = NULL)
    {
      	return $data = $this->db->select('listings.listing_id,listings.listing_name, listings.postal_code,listings.listing_status,listings.listing_id,listings.listing_slug, listings.created_at,listings.listing_image, user.user_id,user.name,categories.category_name,sub_categories.sub_category_name')->from('listings')
      	->join('user','listings.user_id = user.user_id','left')
      	->where('is_deleted',0)
      	->join('listing_categories as categories', 'categories.category_id = listings.category_id', 'LEFT')
      	->join('listing_sub_categories as sub_categories', 'sub_categories.sub_category_id = listings.sub_category_id', 'LEFT')
      	->order_by('listing_id','DESC')
      	->limit($limit,$offset)
      	->get()->result();
    }
    public function getAllDeletedListings($limit=NULL, $offset = NULL)
    {
      	return $data = $this->db->select('listings.listing_id,listings.listing_name, listings.postal_code,listings.listing_status,listings.listing_id,listings.listing_slug,listings.created_at,listings.listing_image, user.user_id,user.name,categories.category_name,sub_categories.sub_category_name')->from('listings')
      	->join('user','listings.user_id = user.user_id','left')
      	->where('is_deleted',1)
      	->join('listing_categories as categories', 'categories.category_id = listings.category_id', 'LEFT')
      	->join('listing_sub_categories as sub_categories', 'sub_categories.sub_category_id = listings.sub_category_id', 'LEFT')
      	->order_by('listing_id','DESC')
      	->limit($limit,$offset)
      	->get()->result();
    }
          

	public function getAllListingNames()
	{
	  	return $this->db->select('listing_id,listing_name')
	  	->from('listings')
	  	->where('is_deleted',0)
	  	->get()->result_array();
	}

	public function getListingSingleValue($id,$table_id,$tableName)
	{
	  	return $data = $this->db->select('*')->from($tableName)->where($table_id,$id)->get()->result_array();
	}

	public function addDuplicateListing($tableName, $data)
	{
	  	if($this->db->insert($tableName,$data))
	  	{
	  		return TRUE;
	  	} else {
	  		return FALSE;
	  	}   	
	}        

	public function permanentDeleteListing($slug)
	{
	  	$data = $this->db->select('*')->from('listings')->where('listing_slug',$slug)->get()->row();

	  	$img = '';

	  	if($data->listing_image != null)
	  	{
	  		$image_link = './'.$data->listing_image;

	  		if(file_exists($image_link))
	  		{
	  			$img = $image_link;
	  		} else 
	  		{
	  			$img = '';
	  		}
	  	}
	  	if($this->db->where('listing_slug',$slug)->delete('listings'))
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
      COMMON FUNCTION
      ==================*/
      
      public function getAllValues($tableName)
      {
      	return $data = $this->db->get($tableName)->result();
      }
      
      public function getSingleValue($id,$table_id,$tableName)
      {
      	return $data = $this->db->select('*')->from($tableName)->where($table_id,$id)->get()->row();
      }
      
      public function add($tableName, $data)
      {
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
      


      public function getAllUsers($tableName)
      {
      	return $data = $this->db->get($tableName)->result();
      }
      
	/*============================================
		COMMON AJAX ACTIVE/INACTIVE GET FUNCTION
		============================================*/
		public function getSingleAjaxValue($id,$table_id,$tableName)
		{
			return $data = $this->db->select('*')->from($tableName)->where($table_id,$id)->get()->row_array();
		}    
		


		
		public function getEnquiries()
		{
			return $data = $this->db->get('enquiries')->result();
		}
		
		public function savedEnquiry()
		{
			return $data = $this->db->where('enquiry_save',1)->get('enquiries')->result();
		}
		
		public function deleteEnquiry($id)	
		{
			if($this->db->where('enquiry_id',$id)->delete('enquiries'))
			{
				return true;
			} else 
			{
				return false;
			}
		}


		public function deleteClaim($id)
		{      
			if($this->db->where('claim_listing_id',$id)->delete('claim_listings'))
			{
				return true;
			} else 
			{
				return false;
			}
		}

	/*==================
          ADS
          ==================*/	
          public function getAllAds()
          {
          	$data =  $this->db->select('ads.*,u.name as username,u.profile_image as user_image,u.user_created as user_join,ap.name as ads_price_name')
          	->from('ads')
          	->where('ads.ad_status',1)
          	->join('user as u','ads.u_id = u.user_id')
          	->join('ads_prices as ap','ads.ads_price_id = ap.id')
          	->get()->result();
          	return $data;
          }
          public function getAllAdsHistory()
          {
          	$data =  $this->db->select('ads.*,u.name as username,u.profile_image as user_image,u.user_created as user_join,ap.name as ads_price_name')
          	->from('ads')
          	->join('user as u','ads.u_id = u.user_id')
          	->join('ads_prices as ap','ads.ads_price_id = ap.id')
          	->get()->result();
          	return $data;
          }
          public function getAllInactiveAds()
          {
          	$data =  $this->db->select('ads.*,u.name as username,u.profile_image as user_image,u.user_created as user_join,ap.name as ads_price_name')
          	->from('ads')
          	->where('ads.ad_status',0)
          	->join('user as u','ads.u_id = u.user_id')
          	->join('ads_prices as ap','ads.ads_price_id = ap.id')
          	->get()->result();
          	return $data;
          }
          public function deleteAds($id)
          {
          	$data = $this->db->select('*')->from('ads')->where('id',$id)->get()->row();

          	$img = '';

          	if($data->ad_photo)
          	{
          		$image_link = './'.$data->ad_photo;

          		if(file_exists($image_link))
          		{
          			$img = $image_link;
          		} else 
          		{
          			$img = '';
          		}
          	}
          	

          	if($this->db->where('id',$id)->delete('ads'))
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
          
          public function getSingleAdsAjaxValue($id)
          {
          	return $data = $this->db->select('*')->from('ads')->where('id',$id)->get()->row_array();
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


          }