<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_m extends CI_model {

    public function get_transaksi($id = '')
    {
        if ($id == '') {
            $this->db->select('*, tb_member.nama as nama_member, tb_outlet.nama as nama_outlet, tb_user.nama as nama_user,');
            $this->db->join('tb_outlet', 'id_outlet', 'left');
            $this->db->join('tb_user', 'id_user', 'left');
            $this->db->join('tb_member', 'id_member', 'left');

            if ($this->session->userdata('role') == 'kasir') {
                $this->db->where('id_user', $this->session->userdata('id_user'));
            }
            
            return $this->db->get('tb_transaksi')->result_array();
        }else{
            return $this->db->get_where('tb_transaksi',['id_transaksi' => $id])->row_array();
        }
    }

    public function cari_transaksi($keyword)
    {
        $this->db->select('*, tb_member.nama as nama_member, tb_outlet.nama as nama_outlet, tb_user.nama as nama_user,');
        $this->db->join('tb_outlet', 'id_outlet', 'left');
        $this->db->join('tb_user', 'id_user', 'left');
        $this->db->join('tb_member', 'id_member', 'left');
        $this->db->where('kode_invoice', $keyword);

        if ($this->session->userdata('role') == 'kasir') {
            $this->db->where('id_user', $this->session->userdata('id_user'));
        }
        return $this->db->get('tb_transaksi')->result_array();
    }

    public function insert($post)
    {
        $id_outlet = $this->session->userdata('id_outlet');
        $id_transaksi = id('tb_transaksi', 'id_transaksi');

        $this->db->insert('tb_transaksi',[
            'id_transaksi' => $id_transaksi,
            'id_outlet' => $id_outlet,
            'kode_invoice' => $post['kode_invoice'],
            'id_member' => $post['member'],
            'id_user' => $this->session->userdata('id_user'),
            'tgl' => $post['tgl'],
            'batas_waktu' => $post['batas_waktu'],
            'tgl_bayar' => $post['tgl_bayar'],
            'biaya_tambahan' => $post['biaya_tambahan'],
            'pajak' => $post['pajak'],
            'diskon' => $post['diskon'],
            'status' => $post['status'],
            'dibayar' => $post['dibayar'],
            'total_bayar' => $post['total_bayar'],
            'cash' => $post['cash']
        ]);
        
        for ($i=0; $i < count($post['id_paket']); $i++) {
            $this->db->insert('tb_detail_transaksi',[
                'id' => id('tb_detail_transaksi', 'id'),
                'id_transaksi' => $id_transaksi,
                'id_paket' => $post['id_paket'][$i],
                'id_paket' => $post['id_paket'][$i],
                'qty' => $post['qty'][$i],
                'keterangan' => $post['keterangan'][$i],
                'total_harga' => $post['total_harga'][$i]
                ]);    
            }
    }
    public function update($post)
    {
            $id_outlet = $this->session->userdata('id_outlet');

            $this->db->where('kode_invoice', $post['kode_invoice']);
            $this->db->update('tb_transaksi',[
                // 'tgl' => $post['tgl'],
                // 'batas_waktu' => $post['batas_waktu'],
                'tgl_bayar' => $post['tgl_bayar'],
                'status' => $post['status'],
                'dibayar' => $post['dibayar']
            ]);
        }

    public function cetak($kode_invoice)
    {
            // $this->db->select('*');
            // $this->db->from('tb_transaksi');
            // $this->db->join('tb_outlet', 'tb_transaksi.id_outlet = tb_outlet.id_outlet', 'left');
            // $this->db->join('tb_member', 'tb_transaksi.id_member = tb_member.id_member', 'left');
            // $this->db->join('tb_user', 'tb_transaksi.id_user = tb_user.id_user', 'left');
            // $this->db->where('kode_invoice', $kode_invoice);
            // return $this->db->get()->row_array();

            $this->db->select('
                DATE(tgl) as tgl,
                batas_waktu as tgl_diambil,
                tgl_bayar,
                tb_outlet.nama as nama_outlet,
                nama_paket,
                harga,
                SUM(qty) as terjual,
                harga * SUM(qty) as pendapatan,
                dibayar,
                tb_member.nama as nama_member,
                tb_member.id_member,
            ');

            $this->db->join('tb_member', 'id_member', 'left');
            $this->db->join('tb_outlet', 'id_outlet', 'left');
            $this->db->join('tb_detail_transaksi', 'id_transaksi', 'left');
            $this->db->join('tb_paket', 'tb_detail_transaksi.id_paket = tb_paket.id_paket', 'left');
            $this->db->group_by('tb_paket.id_paket, tb_outlet.id_outlet, DATE(tgl)');
            $this->db->where('kode_invoice', $kode_invoice);
            return $this->db->get('tb_transaksi')->result_array();
    }
}
