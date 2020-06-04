<style>

    .optLabel{
        margin-right: 15px;
    }

</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs bg-sky"  style="font-color:#FFF;">
		<li class="active"><a href="#tabMom_1" data-toggle="tab" aria-expanded="false"><b  style="font-color:#FFF;">Data List</b></a></li>
		<li class=""><a href="#tabMom_2" data-toggle="tab" aria-expanded="true"><b  style="font-color:#FFF;">Entry Point</b></a></li>
	</ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tabMom_1">
            <div id="grid1" style="height:500px"></div>
        </div>
        <div class="tab-pane" id="tabMom_2">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Data Personal</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Data Alamat</a></li>
                    <!-- <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Dokumen Pendukung</a></li> -->
                    <!-- <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Data Kontak Darurat</a></li> -->
                </ul>
                <form>
                    <div class="tab-content">
                        <div class="tab-pane active full-height" id="tab_1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <!-- <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Unique Code</label>
                                                <div>
                                                    <input style="width:80px; display: inline-block; " type="text" class="form-control" name="cCabang" id="cCabang" >
                                                    <input style="width:120px; display: inline-block; " type="text" class="form-control" name="cUrut" id="cUrut" maxlength="6" >
                                                </div>
                                            </div>
                                        </div> -->
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Tanggal Masuk</label>
                                                <div>
                                                    <div class="col-xs-8 input-group">
                                                        <input
                                                            type="text" 
                                                            class=" form-control date" 
                                                            id="dDate" 
                                                            name="dDate" 
                                                            placeholder="dd-mm-yyyy"
                                                            required
                                                            value=<?=date("d-m-Y")?> <?=date_set()?> 
                                                        >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <div>
                                                    <input type="text" class="form-control" name="cNama" id="cNama" placeholder="John E. Doe" required> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Tanggal Lahir</label>
                                                <div>
                                                    <div class="col-xs-8 input-group">
                                                        <input
                                                            type="text" 
                                                            class=" form-control date" 
                                                            id="dTglLahir" 
                                                            name="dTglLahir" 
                                                            placeholder="dd-mm-yyyy"
                                                            required
                                                            value=<?=date("d-m-Y")?> <?=date_set()?> 
                                                        >
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Tempat Lahir</label>
                                                <div>
                                                    <input  type="text" class="form-control" id="cTempatLahir" name="cTempatLahir"  placeholder="Tempat Lahir" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Kewarganegaraan</label>
                                                <div>
                                                    <input type="radio" name="optKewarganegaraan" id="optKewarganegaraan1" value="1" checked>
                                                    <label class="optLabel" for="optKewarganegaraan1">WNI</label>
                                                    <input type="radio" name="optKewarganegaraan" id="optKewarganegaraan2" value="2">
                                                    <label class="optLabel" for="optKewarganegaraan2">WNA</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>No. KTP</label>
                                                <div>
                                                    <input  type="text" class="form-control" id="cIDCard" name="cIDCard" maxlength="16" placeholder="ID Card" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>NPWP</label>
                                                <div>
                                                    <input  type="text" class="form-control" id="cNPWP" name="cNPWP" placeholder="NPWP" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div>
                                                    <input type="radio" name="optGender" id="optGender1" value="L" checked>
                                                    <label class="optLabel" for="optGender1">Laki-laki</label>
                                                    <input type="radio" name="optGender" id="optGender2" value="P">
                                                    <label class="optLabel" for="optGender2">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Golongan Darah</label>
                                                <div>
                                                    <input type="radio" name="optGolonganDarah" value="A" id="optGolonganDarahA" checked>
                                                    <label class="optLabel" for="A">A</label>

                                                    <input type="radio" name="optGolonganDarah" value="B" id="optGolonganDarahB">
                                                    <label class="optLabel" for="B">B</label>

                                                    <input type="radio" name="optGolonganDarah" value="AB" id="optGolonganDarahAB">
                                                    <label class="optLabel" for="AB">AB</label>
                                                    
                                                    <input type="radio" name="optGolonganDarah" value="O" id="optGolonganDarahO">
                                                    <label class="optLabel" for="O">O</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>No Handphone Official</label>
                                                <div>
                                                    <input  type="text" class="form-control" id="cNoHandphone" name="cNoHandphone" style="width:250px" placeholder="Nomor Handphone" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>No Telepon</label>
                                                <div>
                                                    <input  type="text" class="form-control" id="cNoTelepon" name="cNoTelepon" style="width:250px" placeholder="Nomor Telepon Lainnya">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Pendidikan Terakhir</label>
                                                <div>
                                                    <select /*disabled="disabled"*/ class="form-control select2" data-sf="load_pendidikan" name="optPendidikan" id="optPendidikan" required data-placeholder="Pendidikan Terakhir"  /*disabled="disabled"*/></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <fieldset style="margin-top: 20px;">
                                            <legend>Alamat KTP</legend>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <input type="text" name="cAlamatKTP" id="cAlamatKTP" class="form-control" placeholder="Alamat KTP" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Kota</label>
                                                    <select class="form-control optKota select2" data-sf="load_Kota" name="optKotaKTP" id="optKotaKTP" data-placeholder=" - Nama Kota - "></select>
                                                    <!-- <input type="text" name="cKotaKTP" id="cKotaKTP" class="form-control" placeholder="Kota"> -->
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Kecamatan</label>
                                                    <select class="form-control optKecamatan select2" data-sf="load_Kecamatan" name="optKecamatanKTP" id="optKecamatanKTP" data-placeholder=" - Nama Kecamatan - "></select>
                                                    <!-- <input type="text" name="cKecamatanKTP" id="cKecamatanKTP" class="form-control" placeholder="Kecamatan"> -->
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Kelurahan</label>
                                                    <select class="form-control optKelurahan select2" data-sf="load_Kelurahan" name="optKelurahanKTP" id="optKelurahanKTP" data-placeholder=" - Nama Kelurahan - "></select>
                                                    <!-- <input type="text" name="cKelurahanKTP" id="cKelurahanKTP" class="form-control" placeholder="Kelurahan"> -->
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset style="margin-top: 20px;">
                                            <legend>Alamat Rumah Tinggal</legend>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <input type="text" name="cAlamat" id="cAlamat" class="form-control" placeholder="Alamat Rumah Tinggal" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Kota</label>
                                                    <select class="form-control optKota select2" data-sf="load_Kota" name="optKota" id="optKota" data-placeholder=" - Nama Kota - "></select>
                                                    <!-- <input type="text" name="cKota" id="cKota" class="form-control" placeholder="Kota"> -->
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Kecamatan</label>
                                                    <select class="form-control optKecamatan select2" data-sf="load_Kecamatan" name="optKecamatan" id="optKecamatan" data-placeholder=" - Nama Kecamatan - "></select>
                                                    <!-- <input type="text" name="cKecamatan" id="cKecamatan" class="form-control" placeholder="Kecamatan"> -->
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Kelurahan</label>
                                                    <select class="form-control optKelurahan select2" data-sf="load_Kelurahan" name="optKelurahan" id="optKelurahan" data-placeholder=" - Nama Kelurahan - "></select>
                                                    <!-- <input type="text" name="cKelurahan" id="cKelurahan" class="form-control" placeholder="Kelurahan"> -->
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-12">
                                        <fieldset>
                                            <input type="hidden" name="cKode" id="cKode">
                                            <button class="btn btn-warning pull-right" style="margin-left: 10px;" id="cmdCancel" onClick="bos.mstregisterkaryawan.init()">Cancel</button>
                                            <button class="btn btn-primary pull-right" id="cmdsave">Simpan</button>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="row">

                            </div>
                        </div>
                    </div>
                </form>
            </div>      
        </div>
    </div>
</div>
<script type="text/javascript">
   <?=cekbosjs();?>

   bos.mstregisterkaryawan.grid1_data    = null ;
   bos.mstregisterkaryawan.grid1_loaddata= function(){
      this.grid1_data 		= {} ;
   }

   bos.mstregisterkaryawan.grid1_load    = function(){
      this.obj.find("#grid1").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.mstregisterkaryawan.base_url + "/loadgrid",
	        postData: this.grid1_data ,
	        show: {
	        	footer 			: true,
	        	toolbar			: true,
            	toolbarColumns  : false,
				lineNumbers 	: true 
	        },
	        multiSearch		: false,
	        columns: [
	        	{ field: 'Kode', caption: 'Kode', size: '200px', sortable: false },
				{ field: 'Nama', caption: 'Nama', size: '200px', sortable: false },
	            { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
	            { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
	        ]
	    });
   }

   bos.mstregisterkaryawan.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.mstregisterkaryawan.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.mstregisterkaryawan.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}

	bos.mstregisterkaryawan.grid1_render 	= function(){
		this.obj.find("#grid1").w2render(this.id + '_grid1') ;
	}

	bos.mstregisterkaryawan.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

    bos.mstregisterkaryawan.cmdedit 		= function(id){
        this.obj.find(".nav-tabs li:eq(1) a").tab("show") ;
		bjs.ajax(this.url + '/SeekDataDetail', 'cCIF=' + id);
	}

	bos.mstregisterkaryawan.cmddelete 	= function(id){
		if(confirm("Delete Data?")){
			bjs.ajax(this.url + '/deleting', 'cKode=' + id);
		}
	}

	bos.mstregisterkaryawan.init 			= function(){
	  	this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        $('#cCabang').val("");
        $('#cUrut').val("");
        $('#cNama').val("");
        $('#dTglLahir').val("");
        $('#cTempatLahir').val("");
        $('#optKewarganegaraan').val("");
        $('#cIDCard').val("");
        $('#cNPWP').val("");
        $('#cNoHandphone').val("");
        $('#cNoTelepon').val("");
        $('#optPendidikan').val("");
        $('#cAlamatKTP').val("");
        $('#optKotaKTP').sval("");
        $('#optKecamatanKTP').sval("");
        $('#optKelurahanKTP').sval("");
        $('#cAlamat').val("");
        $('#optKota').sval("");
        $('#optKecamatan').sval("");
        $('#optKelurahan').sval("");
    }

	bos.mstregisterkaryawan.initcomp		= function(){
        this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initenter(this.obj.find("form")) ;
      	bjs.initdate("#" + this.id + " .date") ;
        bjs.ajax(this.url + '/init') ;
	}

	bos.mstregisterkaryawan.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.mstregisterkaryawan.grid1_destroy() ;
		}) ;
	}

   	bos.mstregisterkaryawan.cmdsave       = bos.mstregisterkaryawan.obj.find("#cmdsave") ;
	bos.mstregisterkaryawan.initfunc	   = function(){
		this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			if($(e.target).parent().index() == 0){//load grid
				bos.mstregisterkaryawan.grid1_reloaddata() ;
			}else{//focus
				bos.mstregisterkaryawan.obj.find("#cNama").focus() ;
			}
		});

		this.obj.find('form').on("submit", function(e){
			e.preventDefault() ;
			if( bjs.isvalidform(this) ){
				bjs.ajax( bos.mstregisterkaryawan.base_url + '/ValidSaving', bjs.getdataform(this) , bos.mstregisterkaryawan.cmdsave) ;
			}
		}) ;

		this.obj.find('.optKota').on("change", function(e){
            e.preventDefault() ;
            bos.mstregisterkaryawan.cKota = $(this).val() ;
            bjs.ajax( bos.mstregisterkaryawan.base_url + '/SetSessionKota', "idKota=" + bos.mstregisterkaryawan.cKota) ;
        });

		this.obj.find('.optKecamatan').on("change", function(e){
            e.preventDefault() ;
            bos.mstregisterkaryawan.optKecamatan = $(this).val() ;
            bjs.ajax( bos.mstregisterkaryawan.base_url + '/SetSessionKecamatan', "idKecamatan=" + bos.mstregisterkaryawan.optKecamatan) ;
        });
	}

	$('.optKota').select2({
        allowClear: true,
        ajax: {
            url: bos.mstregisterkaryawan.base_url + '/SeekKota',
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

	$('.optKecamatan').select2({
        allowClear: true,
        ajax: {
            url: bos.mstregisterkaryawan.base_url + '/SeekKecamatan/' ,

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

    $('.optKelurahan').select2({
        allowClear: true,
        ajax: {
            url: bos.mstregisterkaryawan.base_url + '/SeekKelurahan',
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

    $('#optPendidikan').select2({
        allowClear: true,
        ajax: {
            url: bos.mstregisterkaryawan.base_url + '/SeekPendidikan',
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

    bos.mstregisterkaryawan.errAlert = function(msg){
        alert(msg);
    }

	$(function(){
		bos.mstregisterkaryawan.initcomp() ;
		bos.mstregisterkaryawan.initcallback() ;
		bos.mstregisterkaryawan.initfunc() ;
	})

</script>