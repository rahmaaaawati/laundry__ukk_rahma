<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet_m extends CI_Model {

    public function get_outlet($id = '')
    {
        if ($id == '') {
            return $this->db->get('tb_outlet')->result_array();
        }else{
            // $this->db->join('tb_outlet', 'id_outlet', 'left');
            return $this->db->get_where('tb_outlet', ['id_outlet' => $id])->row_array();

        }
    }
    public function insert($post)
    {
        $this->db->insert('tb_outlet',[
            'id_outlet' => $post['id_outlet'],
            'nama' => $post['nama'],
            'alamat' => $post['alamat'],
            'tlp' => $post['tlp']
        ]);
    }
      public function update($post)
    {
        $data = [       
            'nama' => $post['nama'],
            'alamat' => $post['alamat'],
            'tlp' => $post['tlp']
        ];
        $this->db->where('id_outlet', $post['id_outlet']);
        $this->db->update('tb_outlet', $data);
    }
    
    }
