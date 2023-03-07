<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __contruct()
    {
        parent:: __contruct();
        cek_login();
        $this->load->model('Laporan_m');
        $this->load->model('outlet_m');
        $this->load->model('paket_m');
        if ($this->session->userdata('role') == 'kasir') {
            echo "Error Unauthorized";
            die;
        }
       
    }

	public function index()
	{
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_paket = $this->input->get('id_paket');
        $id_outlet = $this->input->get('id_outlet');

		$data['judul'] = "Data Laporan";
        $data['laporan'] = $this->laporan_m->get_laporan($dari, $sampai, $id_paket, $id_outlet);
        $data['outlet'] = $this->outlet_m->get_outlet();
        $data['paket'] = $this->Paket_m->get_paket();

		$this->load->view('template/header',$data);
        $this->load->view('Laporan/index',$data);
        $this->load->view('template/footer',$data);
	}

    public function pdf(){
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_paket = $this->input->get('id_paket');
        $id_outlet = $this->input->get('id_outlet');
        $dibayar = $this->input->get('dibayar');

        $data['laporan'] = $this->laporan_m->get_laporan($dari, $sampai, $id_paket, $id_outlet, $dibayar);
        
        $this->load->library('pdf');
    
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-petanikode.pdf";
        $this->pdf->load_view('laporan/pdf', $data);    
    }
    
}