<?php

 function cek_login()
{
    $ci =& get_instance();
    if (!$ci->session->userdata('id_user')) {
        $ci->session->set_flashdata('error','Anda belum login');
        redirect('auth','refresh');
    }
}

function id($table, $id)
{
    $ci =& get_instance();
                $ci->db->order_by($id, 'Desc');
    $last_id = $ci->db->get($table)->row_array();
    if ($last_id != null) {
        $new_id = $last_id[$id] + 1;
    } else {
        $new_id = 1;
    }
    return $new_id;
}

function kode_invoice()
{
    $ci =& get_instance(); 
    //'TR-0403210001'
    $ci->db->order_by('id_transaksi', 'desc');
    $latest = $ci->db->get('tb_transaksi')->row();

    if ($latest != null) {
        $latest_id = substr($latest->kode_invoice, 9,4);
    } else {
        $latest_id = 0;
    }
    
    return 'TR-' . date('dny') . sprintf('%03s', $latest_id + '1');
}