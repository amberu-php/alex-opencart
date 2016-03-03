<?php 
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
 
/**
 * class ControllerpavblogBlog 
 */
class ControllerpavblogBlog extends Controller {
		private $mparams = '';
		private $mdata = array();

		public function preload(){

			$this->mdata['objlang'] = $this->language;
			$this->mdata['objurl'] = $this->url;

			$this->load->language('module/pavblog');
			$this->load->model("pavblog/blog");
			$this->load->model("pavblog/comment");
			$mparams = $this->config->get( 'pavblog' );
			$default = $this->model_pavblog_blog->getDefaultConfig();
			
			$mparams = !empty($mparams)?$mparams:array();

			if( $mparams ){
				$mparams =  array_merge( $default,$mparams);
			}else{
				$mparams = $default;
			}
			$config = new Config();
			if( $mparams ){
				foreach( $mparams as $key => $value ){
					$config->set( $key, $value );
				}
			}
			$this->mparams = $config; 

			
			if( $this->mparams->get('comment_engine') == '' ||  $this->mparams->get('comment_engine') == 'local' ) {
			}else {			
				$this->mparams->set( 'blog_show_comment_counter', 0 );	
				$this->mparams->set( 'cat_show_comment_counter', 0 );	
			}	
		

			if( !defined("_PAVBLOG_MEDIA_") ){
				if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavblog.css')) {
					$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavblog.css');
				} else {
					$this->document->addStyle('catalog/view/theme/default/stylesheet/pavblog.css');
				}
				define("_PAVBLOG_MEDIA_",true);
			}
		}
		
		public function getParam( $key, $value='' ){
			return  $this->mparams->get( $key, $value );
		}
		
		/**
		 * get module object
		 *
		 */
		public function getModel( $model='blog' ){
			return $this->{"model_pavblog_{$model}"};
		}
		
		/**
		 *
	     * index action
		 */
		public function index() {  
		
			$this->preload();
			$category_id = 0;
			$this->load->model('tool/image'); 
			
			
			$this->mdata['breadcrumbs'] = array();
			
			$this->mdata['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),
				'separator' => false
			);
		
			$this->request->get['id'] = isset($this->request->get['id'])?$this->request->get['id']:0;
			$blog_id = $this->request->get['id'];
			$blog = $this->getModel()->getInfo( $blog_id );
			$this->load->model('pavblog/category');
			
			$users = $this->model_pavblog_category->getUsers();

			

			$this->mdata['config']	 = $this->mparams; 
			if ($blog) {
			
				$category_id = $blog['category_id'];
				$title = $blog['meta_title'] ? $blog['meta_title']:$blog['title']; 
				$this->document->setTitle( $title ); 
				$this->document->setDescription( $blog['meta_description'] );
				$this->document->setKeywords( $blog['meta_keyword'] );
				



			// крошки  PS:сплошной ГОVНОКОД - ПЕРЕПИСАТЬ !!!
				$category_info = $this->model_pavblog_category->getInfo( $category_id );
	
				$parent_id = $category_info['parent_id'];		
				$max_level = 6;
				$breads = array();
				$hleb = array();

				for ($i = $max_level-1; $i >= 0; --$i) {

						$result = $this->model_pavblog_category->getInfo( $parent_id );
						if ($parent_id == 0) break;

						$hleb [] = array(
								'text'      => $result['title'],
								'href'      => $this->url->link('pavblog/category', 'id='.$result['category_id']), 
								'id'		=> $result['category_id'],     		
								'separator' => $this->language->get('text_separator')
										
										);

						if (isset($result['parent_id'])) {
						  $parent_id = $result['parent_id'];
						} else { break; }

					}

			
				$breads =  (array_reverse($hleb));

				foreach( $breads as $bread ){

							       	$this->mdata['breadcrumbs'][] = array(
									'text'      => $bread['text'],
									'href'      => $bread['href'], 
									'id'		=> $bread['id'],     		
									'separator' => $this->language->get('text_separator')
								
								);
				}
			
        	// крошки END PS:сплошной ГОVНОКОД - ПЕРЕПИСАТЬ !!!	
	


				$this->mdata['breadcrumbs'][] = array(
					'text'      => $blog['category_title'],
					'href'      => $this->url->link('pavblog/category', 'id=' .  $category_id),      		
					'separator' => $this->language->get('text_separator')
				);	

				$this->mdata['breadcrumbs'][] = array(
					'text'      => $blog['title'],
					'href'      => $this->url->link('pavblog/blog', 'id=' .  $blog_id),      		
					'separator' => $this->language->get('text_separator')
				);	


							
				$this->mdata['heading_title'] = $blog['title'];
				
				$this->mdata['button_continue'] = $this->language->get('button_continue');
				
				$this->mdata['description'] = html_entity_decode($blog['description'], ENT_QUOTES, 'UTF-8');
				$this->mdata['content'] = html_entity_decode($blog['content'], ENT_QUOTES, 'UTF-8');
				$this->mdata['entry_captcha'] = $this->language->get('entry_captcha');
				$this->mdata['continue'] = $this->url->link('common/home');
				if (isset($this->error['captcha'])) {
					$this->mdata['error_captcha'] = $this->error['captcha'];
				} else {
					$this->mdata['error_captcha'] = '';
				}

				if ($this->config->get('config_google_captcha_status')) {
					$this->document->addScript('https://www.google.com/recaptcha/api.js');
					$this->mdata['site_key'] = $this->config->get('config_google_captcha_public');
				} else {
					$this->mdata['site_key'] = '';
				}


				if ($this->config->get('config_google_captcha_status')) {
					$this->document->addScript('https://www.google.com/recaptcha/api.js');
					$this->mdata['site_key'] = $this->config->get('config_google_captcha_public');
				} else {
					$this->mdata['site_key'] = '';
				}

				$type = array('l'=>'thumb_large','s'=>'thumb_small');
				$imageType = isset($type[$this->mparams->get('blog_image_type')])?$type[$this->mparams->get('blog_image_type')]:'thumb_xsmall';
				
				if( $blog['image'] ){	
					$blog['thumb_large'] = $this->model_tool_image->resize($blog['image'], $this->mparams->get('general_lwidth'), $this->mparams->get('general_lheight'),'w');
					$blog['thumb_small'] = $this->model_tool_image->resize($blog['image'], $this->mparams->get('general_swidth'), $this->mparams->get('general_sheight'),'w' );
					$blog['thumb_xsmall'] = $this->model_tool_image->resize($blog['image'],$this->mparams->get('general_xwidth'), $this->mparams->get('general_xheight') ,'w');
				}else {
					$blog['thumb_large'] = '';
					$blog['thumb_small'] = '';
					$blog['thumb_xsmall'] = '';
				}
				
				$blog['thumb'] = $blog[$imageType];
				
				$blog['description'] = html_entity_decode( $blog['description'] );
				$blog['author'] = isset($users[$blog['user_id']])?$users[$blog['user_id']]:$this->language->get('text_none_author');
				$blog['category_link'] =  $this->url->link( 'pavblog/category', "id=".$blog['category_id'] );
				$blog['comment_count'] =  $this->getModel('comment')->countComment( $blog['blog_id'] );
				$blog['link'] =  $this->url->link( 'pavblog/blog','id='.$blog['blog_id'] );

				if (isset($this->request->post['captcha'])) {
					$this->mdata['captcha'] = $this->request->post['captcha'];
				} else {
					$this->mdata['captcha'] = '';
				}	

				$this->mdata['comment_action'] = $this->url->link( 'pavblog/blog/comment','id='.$blog['blog_id'] );
				$this->mdata['blog'] = $blog;
				$this->mdata['samecategory'] = $this->getModel()->getSameCategory( $blog['category_id'], $blog['blog_id'] );
				$this->mdata['social_share'] =  '';
				$data = array(
					'filter_category_id' => '',
					'filter_tag'		=> $blog['lang_tags'],
					'not_in'           => $blog['blog_id'],
					'sort'               => 'created',
					'order'              => 'DESC',
					'start'              => 0,
					'limit'              => 10
				);

				$related = $this->getModel('blog')->getListBlogs(  $data );
			
				
				$this->mdata['related'] = $related;
				
				$ttags = explode( ",",$blog['lang_tags']);
				$tags  = array();
				
				foreach( $ttags as $tag ){
					$tags[trim($tag)] = $this->url->link( 'pavblog/category&id=1&','tag='.trim($tag) );
				}
				
				$this->mdata['tags'] = $tags;
				if( $this->mparams->get('enable_recaptcha') ){  
					if ($this->config->get('config_ssl')) {
						$recaptcha_ssl = true;
					} else {
						$recaptcha_ssl = false;
					}
				//	require_once(DIR_SYSTEM . 'library/recaptchalib.php');
				//	$this->mdata['recaptcha'] = recaptcha_get_html($this->mparams->get('recaptcha_public_key'), null, $recaptcha_ssl);

				}else {
					$this->mdata['recaptcha'] = null;
				}
				$this->mdata['link'] =  $this->url->link( 'pavblog/blog','id='.$blog['blog_id'] );
				
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else { 
					$page = 1;
				}	
				$limit = $this->getParam( 'comment_limit' );
			
				$url = '';
				$pagination = new Pagination();
				$pagination->total = $blog['comment_count'];
				$pagination->page = $page;
				$pagination->limit =  $limit;
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->url->link('pavblog/blog', 'id=' . $blog['blog_id'] . $url . '&page={page}');
				$data = array(
					'blog_id' => $blog['blog_id'],
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit
				);
				$this->mdata['comments'] = $this->getModel('comment')->getList( $data );
				
				$this->mdata['pagination'] = $pagination->render();
								
				$this->getModel( 'blog' )->updateHits( $blog_id ); 

			// товары к статье

			$this->load->model('catalog/product');
			$this->load->model('tool/image');
			$this->load->language('product/product');

			$this->mdata['button_cart'] = $this->language->get('button_cart');
			$this->mdata['button_wishlist'] = $this->language->get('button_wishlist');
			$this->mdata['button_compare'] = $this->language->get('button_compare');
			$this->mdata['button_continue'] = $this->language->get('button_continue');
			$this->mdata['text_tax'] = $this->language->get('text_tax');

			$this->mdata['text_related'] = $this->language->get('text_related');

		
			$results = $this->model_pavblog_blog->getBlogRelatedProduct($blog_id);

			if (!empty($results)) {

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$this->mdata['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
		} else {
			$this->mdata['products'] = false;
		}

			// товары к статье END



				$this->mdata['column_left'] = $this->load->controller('common/column_left');
				$this->mdata['column_right'] = $this->load->controller('common/column_right');
				$this->mdata['content_top'] = $this->load->controller('common/content_top');
				$this->mdata['content_bottom'] = $this->load->controller('common/content_bottom');
				$this->mdata['footer'] = $this->load->controller('common/footer');
				$this->mdata['header'] = $this->load->controller('common/header');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/pavblog/blog.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/pavblog/blog.tpl', $this->mdata));
				} else {
					$this->response->setOutput($this->load->view('default/template/pavblog/blog.tpl', $this->mdata));
				}

			} else {
				$this->mdata['breadcrumbs'][] = array(
					'text'      => $this->language->get('text_error'),
					'href'      => $this->url->link('information/information', 'category_id=' . $category_id),
					'separator' => $this->language->get('text_separator')
				);
					
				$this->document->setTitle($this->language->get('text_error'));
				
				$this->mdata['heading_title'] = $this->language->get('text_error');

				$this->mdata['text_error'] = $this->language->get('text_error');

				$this->mdata['button_continue'] = $this->language->get('button_continue');
				
				$this->mdata['continue'] = $this->url->link('common/home');

				$this->mdata['column_left'] = $this->load->controller('common/column_left');
				$this->mdata['column_right'] = $this->load->controller('common/column_right');
				$this->mdata['content_top'] = $this->load->controller('common/content_top');
				$this->mdata['content_bottom'] = $this->load->controller('common/content_bottom');
				$this->mdata['footer'] = $this->load->controller('common/footer');
				$this->mdata['header'] = $this->load->controller('common/header');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $this->mdata));
				} else {
					$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $this->mdata));
				}

			}
		}
		
		public function captcha() {
			$this->load->library('captcha');
		
			$captcha = new Captcha();
		
			$this->session->data['captcha'] = $captcha->getCode();
		
			$captcha->showImage();
		}	


		/**
		 * process adding comment
		 */
		public function comment(){
			$this->preload();
			$error = array();
			

			if( isset($this->request->post['comment']) ){
				$d = array('email'=>'','user'=>'','comment'=>'','blog_id'=>'');

				$data = $this->request->post['comment'];
				$data  = array_merge( $d,$data );
				if( $this->mparams->get('enable_recaptcha') ){ 
					if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {

      					$error['captcha'] = '<div class="comment-warning">'.$this->language->get('error_captcha').'</div>';
    				} 
				}
				
				if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $data['email'])) {
					 $error['email'] = '<div class="comment-warning">'.$this->language->get('error_email').'</div>';
				}
				if( empty($data['comment']) ){
					$error['comment'] = '<div class="comment-warning">'.$this->language->get('error_comment').'</div>';
				}
				if( empty($data['user']) ){
					$error['user'] = '<div class="comment-warning">'.$this->language->get('error_user').'</div>';
				}
				

				if( empty($error) && $data['blog_id'] ){
					$this->getModel('comment')->saveComment( $data, $this->mparams->get('auto_publish_comment') );
					$output = array('hasError'=>false, 'message'=> '' );
					echo json_encode( $output );die();
				}
			}
			$output = array('hasError'=>true, 'message'=> implode(" \r\n ", $error ) );
			echo json_encode( $output );die();
		}
	}	
	?>