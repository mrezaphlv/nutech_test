<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
function __construct(){
		parent::__construct();
		  $this->load->helper(array('form', 'url','file'));
		  $this->load->model('M_barang');
      $this->load->model('Barang_m');
		          $this->load->library('form_validation');
		           	$this->load->library('session');
	}
	public function index()
	{
		$data['d_barang'] = $this->M_barang->get_dt();	
		$this->load->view('v_barang',$data);
	}
	function data_barang(){
		$data=$this->M_barang->get_dt();
		echo json_encode($data);
	}
	function get_barang(){
		$kobar=$this->input->get('id');
		$data=$this->M_barang->get_barang_by_kode($kobar);
		echo json_encode($data);
	}

public function ajax_list()
  {
    $list = $this->Barang_m->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $kk) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = '<img src="'.base_url().'gambar/'.$kk->foto_barang.'" width="45px" height="45px">';
      $row[] = $kk->nama_barang;
      $row[] = $kk->harga_beli;
      $row[] = $kk->harga_jual;
      $row[] = $kk->stok;
      $row[] = '<div class="btn-group"><a href="javascript:;" data-toggle="modal" data-target="#edt'.$kk->id.'" class="btn btn-sm btn-info">EDIT</a><a href="javascript:;" class="btn btn-sm btn-danger" id="item_hapus" data="'.$kk->id.'">Hapus</a></div>';
      $data[] = $row;
    }

    $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Barang_m->count_all(),
            "recordsFiltered" => $this->Barang_m->count_filtered(),
            "data" => $data,
        );
    //output to json format
    echo json_encode($output);
  }


	function upload_img($tempat,$namaFile='')
    {
// $config['upload_path'] = ''.'uploads/data_karyawan/foto_karyawan'.'/';
        $config['upload_path'] = 'gambar';
        $config['allowed_types']= 'jpg|png|jpeg'; 
        $config['max_size']  = '100';
        $config['remove_space'] = TRUE;//untuk menghilangkan karakter spasi
        $config['overwrite'] = TRUE;//untuk mengoverwrite
        if ($namaFile != '') {
           $config['file_name'] = $namaFile;
       }

       $this->load->library('upload', $config);    
       if ( ! $this->upload->do_upload($tempat)){
        $error = array('error' => $this->upload->display_errors());
        return $error;
    }
    else{
        $tempatfile = array('upload_data' => $this->upload->data());
        $namatempatfile = $tempatfile['upload_data']['file_name'];
        $simpan['tempatfile'] = $namatempatfile; 
        return $simpan['tempatfile'];
    }
}
    function cek_upload(){
    	 $type=$_FILES['foto_barang']['type'];
    	 $sizee = $_FILES['foto_barang']['size'];
        if($sizee != 0){

        	if (!($type == 'image/jpeg'||$type == 'image/png')) {
        		$this->form_validation->set_message('cek_upload', "Tipe file tidak sesuai");
        		return false;
        	}

         	else if( $sizee > 100000){
        		 $this->form_validation->set_message('cek_upload', 'Size Maksimal 100kb | size :'.$sizee/1000);
       				 return false;
        	}
        	else {
        	 	//$this->form_validation->set_message('cek_upload', "tipe file salah");
        		return true;
        	 }
      }
          
        else{
        $this->form_validation->set_message('cek_upload', "Silahkan pilih satu file gambar");
        return false;
    } 
    }

	public function add_exe(){
		$this->load->library('form_validation');
	 $this->form_validation->set_rules('foto_barang','Foto Barang','callback_cek_upload');
 $this->form_validation->set_rules('nama_barang','Nama Barang','required|is_unique[tb_barang.nama_barang]');
         $this->form_validation->set_rules('harga_beli','Harga Beli','required|numeric');
         $this->form_validation->set_rules('harga_jual','Harga jual','required|numeric');
          $this->form_validation->set_rules('stok','Kolom Stok','required|numeric');
         if($this->form_validation->run() == false){
		$x['d_barang'] = $this->M_barang->get_dt();
		$this->load->view('v_barang',$x);
         }
         else {
         	$foto_barang = $this->input->post('foto_barang',TRUE);
		$nama_barang = $this->input->post('nama_barang',TRUE);
		$harga_beli = $this->input->post('harga_beli',TRUE);
		$harga_jual = $this->input->post('harga_jual',TRUE);
		$stok = $this->input->post('stok',TRUE);
		$foto_bar = 'foto_barang';
			$foto_bar = $this->upload_img($foto_bar,$nama_barang);
			if (!$foto_bar) {
				echo 'Foto tidak sesuai ketentuan';
				
			}else{
				$data = array(
					'foto_barang' => $foto_bar,
					'nama_barang' => $nama_barang,
					'harga_beli' => $harga_beli,
					'harga_jual' => $harga_jual,
					'stok' => $stok
				);
				$inn = $this->M_barang->add_dt($data);
				if ($inn) {
					$this->session->set_flashdata('berhasil', 'anda berhasil menginput data');
				redirect('barang');
				}
				
			}
         }
		
	}
	function cek_uploadedit(){
       $type=$_FILES['ed_foto_barang']['type'];
    	 $sizee = $_FILES['ed_foto_barang']['size'];
        if($sizee != 0){

        	if (!($type == 'image/jpeg'||$type == 'image/png')) {
        		$this->form_validation->set_message('cek_uploadedit', "Tipe file tidak sesuai");
        		return false;
        	}

         	else if( $sizee > 100000){
        		 $this->form_validation->set_message('cek_uploadedit', "Size Maksimal 100kb | size : ".$sizee/1000);
       				 return false;
        	}
        	else {
        	 	//$this->form_validation->set_message('cek_upload', "tipe file salah");
        		return true;
        	 }
      }
          
          
        else{
        $this->form_validation->set_message('cek_uploadedit', "Silahkan pilih satu file gambar");
        return false;
    } 
    }
        function upload_img_edit($tempat,$namaFile='')
    {
// $config['upload_path'] = ''.'uploads/data_karyawan/foto_karyawan'.'/';
        $config['upload_path'] = 'gambar';
        $config['allowed_types']= 'jpg|png|jpeg'; 
        $config['max_size']  = '100';
        $config['remove_space'] = TRUE;//untuk menghilangkan karakter spasi
        $config['overwrite'] = TRUE;//untuk mengoverwrite
        if ($namaFile != '') {
           $config['file_name'] = $namaFile;
       }

       $this->load->library('upload', $config);    
       if ( ! $this->upload->do_upload($tempat)){
        $error = array('error' => $this->upload->display_errors());
        return $error;
    }
    else{
        $tempatfile = array('upload_data' => $this->upload->data());
        $namatempatfile = $tempatfile['upload_data']['file_name'];
        $simpan['tempatfile'] = $namatempatfile; 
        return $simpan['tempatfile'];
    }
}

function numrows(){
  $nama_barang = $this->input->post('ed_nama_barang', true);
  $where = array('nama_barang' => $nama_barang);
  $cek_nm = $this->M_barang->numrows($where,'tb_barang')->num_rows();
  if ($cek_nm >= 1) {
 $this->form_validation->set_message('numrows', 'nama barang sudah digunakan');
 return false;
  }
  else{
    return true;
  }
}

	public function edit_exe(){
		$id = $this->input->post('ed_id', true);
		$ed_foto_barang = $this->input->post('ed_foto_barang',true);
		$nama_barang1 = $this->input->post('ed_nama_barang',true);
		 $sizes = $_FILES['ed_foto_barang']['size'];
		if ($sizes!= 0) {
			$this->form_validation->set_rules('ed_foto_barang','Foto Barang','callback_cek_uploadedit');
			$this->form_validation->set_rules('ed_nama_barang','Nama Barang','required|callback_numrows');
         $this->form_validation->set_rules('ed_harga_beli','Harga Beli','required|numeric');
         $this->form_validation->set_rules('ed_harga_jual','Harga jual','required|numeric');
          $this->form_validation->set_rules('ed_stok','Kolom Stok','required|numeric');
          if (!$this->form_validation->run()) {
          	$x['d_barang'] = $this->M_barang->get_dt();
		$this->load->view('v_barang',$x);
          }
          else{
          	$foto_bar = 'ed_foto_barang';
			$foto_bar = $this->upload_img_edit($foto_bar,$nama_barang1);
          	$where = array('id' => $id);
		$data = array(
			'foto_barang' => $foto_bar,
			'nama_barang' => $this->input->post('ed_nama_barang',true),
			'harga_beli' => $this->input->post('ed_harga_beli',true),
			'harga_jual' => $this->input->post('ed_harga_jual',true),
			'stok' => $this->input->post('ed_stok',true)
			);
		
		$this->M_barang->del_img($id);
			$this->M_barang->edit($where,$data);
		
			$this->session->set_flashdata('berhasil', 'anda berhasil edit data');
		redirect('Barang');
          }
			 //echo 'isinya ada';
         
		}


		else{
		$this->form_validation->set_rules('ed_nama_barang','Nama Barang','required|callback_numrows');
$this->form_validation->set_rules('ed_harga_beli','Harga Beli','required|numeric');
         $this->form_validation->set_rules('ed_harga_jual','Harga jual','required|numeric');
          $this->form_validation->set_rules('ed_stok','Kolom Stok','required|numeric');
          if (!$this->form_validation->run()) {
          	$x['d_barang'] = $this->M_barang->get_dt();
		$this->load->view('v_barang',$x);
          }
          else{
          	$where = array('id' => $id);
		$data = array(
			'nama_barang' => $this->input->post('ed_nama_barang',true),
			'harga_beli' => $this->input->post('ed_harga_beli',true),
			'harga_jual' => $this->input->post('ed_harga_jual',true),
			'stok' => $this->input->post('ed_stok',true)
			);
		$this->M_barang->edit($where,$data);

          $this->session->set_flashdata('berhasil', 'anda berhasil edit data');
		redirect('Barang');
          }
		}	
			
	}
	function hapus_barang(){
		$kobar=$this->input->post('kode');
		$data=$this->M_barang->hapus_barang($kobar);
		$sflash = $this->session->set_flashdata('berhasil', 'anda berhasil menghapus data');
		echo json_encode($data);
		// if ($data) {
		// 	echo json_encode(array('message'=> $sflash));
		// }
	}
}