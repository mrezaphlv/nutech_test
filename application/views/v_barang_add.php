<?php $this->load->view('_head'); ?>
<h3>Data Barang</h3>

<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modaladd">Tambah Data</button>
<br>
<?php if ($this->session->flashdata('berhasil') == TRUE): ?>
  <div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo $this->session->flashdata('berhasil');?>
</div>
<?php endif ?>

<?php if (validation_errors()): ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo validation_errors();?>
</div>
<?php endif ?>

<br>
<table class="table table-condensed table-striped" id="myTable">
	<thead>
		<tr>
			<th>Foto barang</th>
			<th>Nama barang</th>
			<th>Harga Beli</th>
			<th>Harga Jual</th>
			<th>Stok</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody id="data_list">
	<div id="">
	
	<?php foreach ($d_barang as $val): ?>
		<!--<tr>
			<td><a data-toggle="modal" data-target="#det<?php echo $val->id; ?>"><img src="<?php echo base_url().'gambar/'.$val->foto_barang; ?>" width="50px" height="50px"></a></td>
			<td><?php echo $val->nama_barang; ?></td>
			<td><?php echo $val->harga_beli; ?></td>
			<td><?php echo $val->harga_jual; ?></td>
			<td><?php echo $val->stok; ?></td>
			<td><div class="btn-group"><a href="javascript:;"  id="item-edit" class="btn btn-success btn-sm " data="<?php echo $val->id; ?>">Edit</a><a href="" class="btn btn-sm btn-danger">Hapus</a></div></td>
		</tr>-->
		<div class="modal fade" id="det<?php echo $val->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $val->nama_barang; ?></h4>
      </div>
      <div class="modal-body">
      <img src="<?php echo base_url().'gambar/'.$val->foto_barang; ?>" width="400px" height="400px">
      </div>
    </div>
  </div>
</div>
		<?php endforeach ?>
	</div>	
	</tbody>
</table>
<!-- Button trigger modal -->

<!-- modal edit try-->
  <?php foreach ($d_barang as $ve): ?>
    <div class="modal fade" id="edt<?php echo $ve->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Barang</h4>
      </div>
      <div class="modal-body">

      <form class="" method="post" action="<?php echo base_url('Barang/edit_exe'); ?>" enctype="multipart/form-data">
      <input name="ed_id" value="<?php echo $ve->id;?>" hidden></input>
        <div class="form-group">
    <label for="exampleInputFile">Foto Barang</label><br>
    <img src="gambar/<?php echo $ve->foto_barang; ?>" width="70px" height="70px"><p><?php echo $ve->foto_barang; ?></p><br>
    <input type="file" name="ed_foto_barang" id="ed_foto_barang">
    <p class="help-block">Max: 100kb | Format yang diizinkan jpg, png</p>

  </div>
           <div class="form-group">
    <label for="exampleInputEmail1">Nama Barang</label>
    <input type="text" name="ed_nama_barang" class="form-control" id="ed_nama_barang" value="<?php echo $ve->nama_barang; ?>" placeholder="">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Harga Beli</label>
    <input type="text" name="ed_harga_beli" class="form-control" value="<?php echo $ve->harga_beli ?>" id="ed_harga_beli" >
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Harga Jual</label>
    <input type="text" name="ed_harga_jual" class="form-control" id="ed_harga_jual" value="<?php echo $ve->harga_jual; ?>" placeholder="">
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Stok</label>
    <input type="number" name="ed_stok" class="form-control" value="<?php echo $ve->stok; ?>" id="ed_stok" placeholder="">
  </div>
  <button type="submit" class="btn btn-default">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
    <?php endforeach ?>
<!--end modal edit try-->


<div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data</h4>
      </div>
      <div class="modal-body">
        <form class="" method="post" action="<?php echo base_url('Barang/add_exe') ?>" enctype="multipart/form-data">
        <div class="form-group">
    <label for="exampleInputFile">Foto Barang</label>
    <input type="file" name="foto_barang" id="foto_barang">
    <p class="help-block">Max: 100kb | Format yang diizinkan jpg, png</p>

  </div>
        	 <div class="form-group">
    <label for="exampleInputEmail1">Nama Barang</label>
    <input type="text" name="nama_barang" class="form-control" id="nama_barang" placeholder="">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Harga Beli</label>
    <input type="text" name="harga_beli" class="form-control" id="harga_beli" >
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Harga Jual</label>
    <input type="text" name="harga_jual" class="form-control" id="exampleInputPassword1" placeholder="">
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Stok</label>
    <input type="number" name="stok" class="form-control" id="exampleInputPassword1" placeholder="">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- MODAL EDIT -->
        <div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Barang</h3>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
<div class="form-group">
    <label class="control-label col-xs-3" >Foto Barang</label>

    <div class="col-xs-9">
    <input type="text" name="e_foto_barang" id="e_foto_barang">
    <p class="help-block">Max: 100kb | Format yang diizinkan jpg, png</p>
</div>
  </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="e_nama_barang" id="e_nama_barang" class="form-control" type="text" placeholder="Nama Barang" style="width:335px;" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3" >Harga Beli</label>
                        <div class="col-xs-9">
                            <input name="e_harga_beli" id="e_harga_beli" class="form-control" type="text" placeholder="" style="width:335px;" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Harga Jual</label>
                        <div class="col-xs-9">
                            <input name="e_harga_jual" id="e_harga_jual" class="form-control" type="text" placeholder="" style="width:335px;" required>
                        </div>
                    </div>
 <div class="form-group">
                        <label class="control-label col-xs-3" >Stok</label>
                        <div class="col-xs-9">
                            <input name="e_stok" id="e_stok" class="form-control" type="text" placeholder="" style="width:335px;" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_update">Update</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        <!--END MODAL EDIT-->

         <!--MODAL HAPUS-->
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Barang</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><strong><p>Apakah Anda yakin mau menghapus barang ini?</p></strong></div>
                                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODAL HAPUS-->
        <script type="text/javascript">
  $(document).ready(function() {
    tampil_data_barang();
    $('#myTable').DataTable();
    function tampil_data_barang(){
        $.ajax({
            type  : 'POST',
            url   : '<?php echo base_url()?>Barang/data_barang',
            async : true,
            dataType : 'json',
            success : function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                          '<td><a><img src="<?php echo base_url('gambar/'); ?>'+data[i].foto_barang+'" width="50px" height="50px"></a></td>'+
                            '<td>'+data[i].nama_barang+'</td>'+
                            '<td>'+data[i].harga_beli+'</td>'+
                             '<td>'+data[i].harga_jual+'</td>'+
                              '<td>'+data[i].stok+'</td>'+
                            '<td style="text-align:right;"><div class="btn-group">'+
                                    '<a href="javascript:;" data-toggle="modal" data-target="#edt'+data[i].id+'" class="btn btn-info btn-sm" id="item_edit" data="'+data[i].id+'">Edit</a>'+' '+
                                    '<a href="javascript:;" class="btn btn-danger btn-sm" id="item_hapus" data="'+data[i].id+'">Hapus</a>'+
                                '</div></td>'+
                            '</tr>';
                }
                $('#data_list').html(html);
            }

        });
    }
    $('#data_list').on('click','#item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
        });
       $('#btn_hapus').on('click',function(){
            var kode=$('#textkode').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('Barang/hapus_barang')?>",
            dataType : "JSON",
                    data : {kode: kode},
                    success: function(data){
                            $('#ModalHapus').modal('hide');
                            tampil_data_barang();
                    }
                });
                return false;
            });
    // $('#data_list').on('click','#item_edit',function(){
    //         var id=$(this).attr('data');
    //         $.ajax({
    //             type : "GET",
    //             url  : "<?php echo base_url('barang/get_barang')?>",
    //             dataType : "JSON",
    //             data : {id:id},
    //             success: function(data){
    //               $.each(data,function(foto_barang, nama_barang, harga_beli, harga_jual,stok){
    //                   $('#ModalaEdit').modal('show');
    //               $('#e_foto_barang').val(data.foto_barang);
    //               $('[name="e_nama_barang"]').val(data.nama_barang);
    //               $('[name="e_harga_beli"]').val(data.harga_beli);
    //               $('[name="e_harga_jual"]').val(data.harga_jual);
    //               $('[name="e_stok"]').val(data.stok);
    //             });
    //             }
    //         });
    //         return false;
    //     });
} );
</script>
<?php $this->load->view('_foot'); ?>
   