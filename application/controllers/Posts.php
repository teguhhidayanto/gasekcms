<?php
	class Posts extends CI_Controller
	{
		public function index()
		{
			$data['title'] = 'Latest Posts';

			$data['posts'] = $this->post_model->get_posts();

			$this->load->view('templates/header');
			$this->load->view('posts/index', $data);
			$this->load->view('templates/footer');	
		}

		public function view($slug = NULL)
		{
			$data['post'] = $this->post_model->get_posts($slug);
			if (empty($data['post'])) 
			{
				show_404();
			}

			$data['title'] = $data['post']['title'];

			$this->load->view('templates/header');
			$this->load->view('posts/view', $data);
			$this->load->view('templates/footer');
		}

		public function create()
		{
			$data['title'] = 'Create Post';

			$data['categories'] = $this->post_model->get_categories();

			$this->form_validation->set_rules('title', 'Title','required');
			$this->form_validation->set_rules('body', 'Body ','required');
			
			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('posts/create', $data);
				$this->load->view('templates/footer');
			} else 
				{
					//upload image sesssion
					$config['upload_path']='./assets/images/posts';
					$config['allowed_types']='gif|jpg|png';
					$config['max_size']='8048';
					$config['max_width']='500';
					$config['max_height']='500';

					$this->load->library('upload', $config);

					if (!$this->upload->do_upload()) //if not uploaded
					{
						$errors = array('error' => $this->upload->display_errors()); //display errors message
						$post_image ='noimage.jpg';	//default 
					} else //if its uploded (image)
						{
							$data = array('upload_data'=> $this->upload->data()); //code to upload image
							$post_image = $_FILES['userfile']['name'];
						}				          //field name of 'postimage' and 'name'

					$this->post_model->create_post($post_image);
					redirect('posts');
				}
		}

		public function delete($id)
		{
			$this->post_model->delete_post($id);
			redirect('posts');
		}

		public function edit($slug)
		{
			$data['post'] = $this->post_model->get_posts($slug);

			$data['categories'] = $this->post_model->get_categories();

			if (empty($data['post'])) 
			{
				show_404();
			}

			$data['title'] = 'Edit Post';

			$this->load->view('templates/header');
			$this->load->view('posts/edit', $data);
			$this->load->view('templates/footer');
		}

		public function update()
		{
			$this->post_model->update_post();
			redirect('posts');
		}
	}
	