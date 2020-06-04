<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Cabang</a></li>
		<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Cabang</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active full-height" id="tab_1">
			<div id="grid1" style="height:500px"></div>
		</div>
		<div class="tab-pane" id="tab_2">
			<form>
				<div class="row">
					<div class="col-md-6">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Keterangan</label>
								<input type="text" name="cKeterangan" id="cKeterangan" class="form-control" placeholder="Kantor Cabang XYZ" required>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Alamat</label>
								<input type="text" name="cAlamat" id="cAlamat" class="form-control" placeholder="Alamat Kantor" required>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Kota</label>
								<select class="form-control optKota select2" data-sf="load_Kota" name="optKota" id="optKota" data-placeholder=" - Nama Kota - "></select>
								<!-- <input type="text" name="cKota" id="cKota" class="form-control" placeholder="Kota" required> -->
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Kecamatan</label>
								<select class="form-control optKecamatan select2" data-sf="load_Kecamatan" name="optKecamatan" id="optKecamatan" data-placeholder=" - Nama Kecamatan - "></select>
								<!-- <input type="text" name="cKecamatan" id="cKecamatan" class="form-control" placeholder="Kecamatan" required> -->
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Kelurahan</label>
								<select class="form-control optKelurahan select2" data-sf="load_Kelurahan" name="optKelurahan" id="optKelurahan" data-placeholder=" - Nama Kelurahan - "></select>
								<!-- <input type="text" name="cKelurahan" id="cKelurahan" class="form-control" placeholder="Kelurahan" required> -->
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Kode Pos</label>
								<input type="text" name="cKodePos" id="cKodePos" class="form-control" placeholder="exp : 65144">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>No Telepon</label>
								<input type="text" name="cNoTelepon" id="cNoTelepon" class="form-control" placeholder="0341-234567">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>No Faximile</label>
								<input type="text" name="cNoFax" id="cNoFax" class="form-control" placeholder="0341-234568">
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="cKode" id="cKode">
				<button class="btn btn-primary" id="cmdsave">Simpan</button>
				<button class="btn btn-warning" id="cmdCancel" onClick="bos.mstcabang.init()">Cancel</button>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
   <?=cekbosjs();?>

   bos.mstcabang.grid1_data    = null ;
   bos.mstcabang.grid1_loaddata= function(){
      this.grid1_data 		= {} ;
   }

   bos.mstcabang.grid1_load    = function(){
      this.obj.find("#grid1").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.mstcabang.base_url + "/loadgrid",
	        postData: this.grid1_data ,
	        show: {
	        	footer 			: true,
	        	toolbar			: true,
            	toolbarColumns  : false,
				lineNumbers 	: true 
	        },
	        multiSearch		: false,
	        columns: [
	        	{ field: 'Keterangan', caption: 'Keterangan', size: '200px', sortable: false },
				{ field: 'Alamat', caption: 'Alamat', size: '200px', sortable: false },
	            { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
	            { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
	        ]
	    });
   }

   bos.mstcabang.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.mstcabang.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.mstcabang.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}

	bos.mstcabang.grid1_render 	= function(){
		this.obj.find("#grid1").w2render(this.id + '_grid1') ;
	}

	bos.mstcabang.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

   bos.mstcabang.cmdedit 		= function(id){
		bjs.ajax(this.url + '/editing', 'cKode=' + id);
	}

	bos.mstcabang.cmddelete 	= function(id){
		if(confirm("Delete Data?")){
			bjs.ajax(this.url + '/deleting', 'cKode=' + id);
		}
	}

	bos.mstcabang.init 			= function(){
		$("#cKeterangan").val("");
		$("#cAlamat").val("");
		$("#optKota").sval("");
		$("#optKecamatan").sval("");
		$("#optKelurahan").sval("");
		$("#cKodePos").val("");
		$("#cNoTelepon").val("");
		$("#cNoFax").val("");
		$("#cKode").val("");
      	this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
      	bjs.ajax(this.url + '/init') ;
	}

	bos.mstcabang.initcomp		= function(){
		this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initenter(this.obj.find("form")) ;
      	bjs.initdate("#" + this.id + " .date") ;
		bjs.ajax(this.url + '/init') ;
	}

	bos.mstcabang.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.mstcabang.grid1_destroy() ;
		}) ;
	}

   	bos.mstcabang.cmdsave       = bos.mstcabang.obj.find("#cmdsave") ;
	bos.mstcabang.initfunc	   = function(){
		this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			if($(e.target).parent().index() == 0){//load grid
				bos.mstcabang.grid1_reloaddata() ;
			}else{//focus
				bos.mstcabang.obj.find("#nik").focus() ;
			}
		});

		this.obj.find('form').on("submit", function(e){
			e.preventDefault() ;
			if( bjs.isvalidform(this) ){
				bjs.ajax( bos.mstcabang.base_url + '/saving', bjs.getdataform(this) , bos.mstcabang.cmdsave) ;
			}
		}) ;

		this.obj.find('#optKota').on("change", function(e){
            e.preventDefault() ;
            bos.mstcabang.cKota = $(this).val() ;
            bjs.ajax( bos.mstcabang.base_url + '/SetSessionKota', "idKota=" + bos.mstcabang.cKota) ;
        });

		this.obj.find('#optKecamatan').on("change", function(e){
            e.preventDefault() ;
            bos.mstcabang.optKecamatan = $(this).val() ;
            bjs.ajax( bos.mstcabang.base_url + '/SetSessionKecamatan', "idKecamatan=" + bos.mstcabang.optKecamatan) ;
        });
	}

	$('#optKota').select2({
        allowClear: true,
        ajax: {
            url: bos.mstcabang.base_url + '/SeekKota',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

	$('#optKecamatan').select2({
        allowClear: true,
        ajax: {
            url: bos.mstcabang.base_url + '/SeekKecamatan/' ,

            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('#optKelurahan').select2({
        allowClear: true,
        ajax: {
            url: bos.mstcabang.base_url + '/SeekKelurahan',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

	$(function(){
		bos.mstcabang.initcomp() ;
		bos.mstcabang.initcallback() ;
		bos.mstcabang.initfunc() ;
	})

</script>
