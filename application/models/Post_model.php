<?php
    class Post_model extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function get_posts($slug = FALSE)
        {
            if ($slug === FALSE) 
            {
                $this->db->order_by('tb_posts.id','DESC');
                $this->db->join('tb_categories','tb_categories.id = tb_posts.category_id');
                $query = $this->db->get('tb_posts');
                return $query->result_array();
            }
                $query = $this->db->get_where('tb_posts' , array('slug' => $slug));
                return $query->row_array();
        }

        public function create_post($post_image)
        {
            $slug = url_title($this->input->post('title'));

            $data = array(
                'title' => $this->input->post('title'),
                'slug'  => $slug,
                'body'  => $this->input->post('body'),
                'category_id' => $this->input->post('category_id'),
                'post_image' => $post_image
            );

            return $this->db->insert ('tb_posts', $data);
        }

        public function delete_post($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('tb_posts');
            return true;
        }

        public function update_post()
        {
            $slug = url_title($this->input->post('title'));

            $data = array(
                'title' => $this->input->post('title'),
                'slug'  => $slug,
                'body'  => $this->input->post('body'),
                'category_id' => $this->input->post('category_id')
            );
            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('tb_posts', $data);
        }

        public function get_categories()
        {
            $this->db->order_by('name');
            $query = $this->db->get('tb_categories');
            return $query->result_array();
        }
    }
    