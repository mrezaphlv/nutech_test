<?php
class M_barang extends CI_Model{


var $table = 'tb_barang';
	var $column_order = array(null, 'nama_barang','harga_beli','harga_jual','stok'); //set column field database for datatable orderable
	var $column_search = array('nama_barang','harga_beli','harga_jual','stok'); //set column field database for datatable searchable 
	var $order = array('id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

public function get_dt()
	{
		$this->db->select('*');
		$this->db->from('tb_barang');
		$query = $this->db->get()->result();
		return $query;
	}
	function get_barang_by_kode($kobar){
		$hsl=$this->db->query("SELECT * FROM tb_barang WHERE id='$kobar'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'foto_barang' => $data->foto_barang,
					'nama_barang' => $data->nama_barang,
					'harga_beli' => $data->harga_beli,
					'harga_jual' => $data->harga_jual,
					'stok' => $data->stok
					);
			}
		}
		return $hasil;
	}
	public function add_dt($data){
//return $this->db->insert($table,$data);
$this->db->insert('tb_barang' ,$data);
            return true;
	}
function numrows($where,$table){
return $this->db->get_where($table,$where);
}
	function hapus_barang($kobar){
		//$this->db->where($kobar);
		   $row = $this->db->where('id',$kobar)->get('tb_barang')->row();
		      unlink('gambar/'.$row->foto_barang);
		$hasil=$this->db->query("DELETE FROM tb_barang WHERE id='$kobar'");
		return $hasil;
	}
	public function edit($where,$data){	
		$this->db->where($where);
		$this->db->update('tb_barang',$data);
	}
	public function get_id($where){
		return $this->db->get_where('tb_barang',$where);
	}
	function del_img($id){
		$row = $this->db->where('id',$id)->get('tb_barang')->row();
		      unlink('gambar/'.$row->foto_barang);
	}
	public function edit1($where,$data,$foto){
		$row = $this->db->where('id',$foto)->get('tb_barang')->row();
		//$unl = base_url('gambar/');
		      unlink('gambar/'.$row->foto_barang);
		$this->db->where($where);
		$this->db->update('tb_barang',$data);
	}

/* --- fungsi serverside datatabeles */
	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


	/* --- END fungsi serverside datatabeles */
	
	
}