<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('Transaksi_m');
        $this->load->model('paket_m');
        $this->load->model('member_m');
        $this->load->model('outlet_m');
        // if ($this->session->userdata('role') == 'owner') {
        //     echo "Error Unauthorized";
        //     die;
        // }
    }
    
	public function index()
	{
		$data['judul'] = "Data Transaksi";
        $data['transaksi'] = $this->Transaksi_m->get_transaksi();

        if ($this->input->get('keyword')) {
            $keyword = $this->input->get('keyword');
            $data['transaksi'] = $this->Transaksi_m->cari_transaksi($keyword);
        }

		$this->load->view('template/header', $data);
        $this->load->view('Transaksi/index', $data);
        $this->load->view('template/footer', $data);
	}
    public function tambah()
	{
        $valid = $this->form_validation;

        $valid->set_rules('kode_invoice', 'kode_invoice', 'required');

        if ($valid->run()) {
            $this->Transaksi_m->insert($this->input->post());

            redirect('transaksi/cetak/' . $this->input->post('kode_invoice'));
            
            $this->session->set_flashdata('message', 'Data Transaksi Berhasil Ditambahkan');
            redirect('transaksi', 'refresh');
        }
		$data['judul'] = "Tambah Transaksi";
        $data['transaksi'] = $this->Transaksi_m->get_transaksi();
        $data['paket'] = $this->paket_m->get_paket();
        $data['member'] = $this->member_m->get_member();
        
		$this->load->view('template/header', $data);
        $this->load->view('Transaksi/tambah', $data);
        $this->load->view('template/footer', $data);
	}
    public function ubah($id)
    {
        $valid = $this->form_validation;

        $valid->set_rules('kode_invoice', 'kode_invoice', 'required');

        if ($valid->run()) {
            $this->Transaksi_m->update($this->input->post());
            // var_dump('test');
            // die;
            $this->session->set_flashdata('message', 'Data Transaksi Berhasil Diubah');
            redirect('transaksi', 'refresh');
        }
		$data['judul'] = "Ubah Transaksi";
        $data['transaksi'] = $this->Transaksi_m->get_transaksi($id);
        $data['paket'] = $this->paket_m->get_paket();
        $data['member'] = $this->member_m->get_member();
        
		$this->load->view('template/header', $data);
        $this->load->view('Transaksi/ubah', $data);
        $this->load->view('template/footer', $data);
	}
    public function hapus($id)
    {
        $this->db->delete('tb_detail_transaksi', ['id_transaksi' => $id]);
        $this->db->delete('tb_transaksi', ['id_transaksi' => $id]);
        $this->session->set_flashdata('message', 'Data Transaksi Berhasil Dihapus');
        redirect('transaksi', 'refresh');
    }

    public function cetak($kode_invoice)
	{
        $this->load->library('pdf');

        $data['member'] = $this->member_m->get_member();
        $data['outlet'] = $this->outlet_m->get_outlet();

        $data['title'] = 'Detail Transaksi';
        $data['transaksi'] = $this->Transaksi_m->cetak($kode_invoice);
        $data['kode_invoice'] = $kode_invoice;

        
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-laundry.pdf";
        $this->pdf->load_view('transaksi/cetak', $data);
        
		
        
		// $this->load->view('transaksi/cetak', $data);
	}
}