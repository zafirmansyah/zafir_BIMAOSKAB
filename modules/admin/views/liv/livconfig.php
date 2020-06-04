<section class="content">
  <div class="row">
    <!-- /.col -->
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h5 class="box-title">&nbsp;</h5>
            </div>
            <div class="box-body no-padding"> 
                <div class="col-sm-6">
                    <div class="box box-info color-palette-box">
                        <div class="box-body">
                            <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="cKeterangan">Keterangan Jenis Izin</label>
                                        <input type="text" class="form-control" name="cKeterangan" id="cKeterangan" placeholder="contoh : Cuti / Izin" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullname">Tanggal Mulai</label>
                                        <div class="col-xs-8 input-group">
                                            <input
                                                type="text" 
                                                class=" form-control date" 
                                                id="dTglAwal" 
                                                name="dTglAwal" 
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullname">Tanggal Akhir</label>
                                        <div class="col-xs-8 input-group">
                                            <input
                                                type="text" 
                                                class=" form-control date" 
                                                id="dTglAkhir" 
                                                name="dTglAkhir" 
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Batas Hari Maksimal</label>
                                        <div class="col-xs-8 input-group">
                                            <input type="number" class="form-control" name="cJumlahHari" id="cJumlahHari" placeholder="">
                                            <div class="input-group-addon">
                                                <i> Hari </i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="username">Hak Kepada</label>
                                        <select name="optNIK" id="optNIK" class="form-control" placeholder="Nomor Induk Karyawan" disabled="disabled"></select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="username">&nbsp;</label>
                                        <input type="checkbox" name="chkAll" value="ALL" id="chkAll" checked>
                                        <label class="optLabel" for="chkAll">Semua Karyawan</label>
                                    </div>
                                </div>
                            </div>
                            <button id="cmdsave" class="btn btn-primary btn-block">Save</button>
                            <input type="hidden" id="chKode" name="chKode">
                    </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="box box-default color-palette-box">
                        <div class="box-body">
                            <div id="grusername" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>

<script type="text/javascript">
	if(typeof bos === "undefined") window.location.href = "<?=base_url()?>";

	bos.livconfig.grid1_data 	= null ;
	bos.livconfig.grid1_loaddata= function(){
	}

	bos.livconfig.grid1_load	= function(){
		this.obj.find("#grusername").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.livconfig.base_url + "/loadgrid",
	        postData: this.grid1_data ,
	        show: {
	        	footer 		: true
	        },
	        columns: [
	            { field: 'Nomor', caption: 'No.', size: '40px', sortable: false },
	            { field: 'Keterangan', caption: 'Keterangan', size: '120px', sortable: false },
	            { field: 'TglAwal', caption: 'Start', size: '80px', sortable: false },
                { field: 'TglAkhir', caption: 'End', size: '80px', sortable: false },
                { field: 'HakKepada', caption: 'Hak Kepada', size: '100px', sortable: false, style:'text-align:center;' },
	            { field: 'cmdedit', caption: ' ', size: '80px', sortable: false,style:'text-align:center;' },
	            { field: 'cmddelete', caption: ' ', size: '80px', sortable: false,style:'text-align:center;' }
	        ]
	    });
	}
	bos.livconfig.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.livconfig.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.livconfig.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}
	bos.livconfig.grid1_render 	= function(){
		this.obj.find("#grusername").w2render(this.id + '_grid1') ;
	}

	bos.livconfig.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

	bos.livconfig.cmdedit 		= function(username){
		bjs.ajax(this.base_url + '/editing', 'username=' + username);
	}

	bos.livconfig.cmddelete 	= function(username){
		if(confirm("Delete Data?")){
			bjs.ajax(this.base_url + '/deleting', 'username=' + username);
		}
	}

	bos.livconfig.init 			= function(){
        $("#cKeterangan").val("");
        $("#dTglAwal").val("");
        $("#dTglAkhir").val("");
        $("#cJumlahHari").val("");
        $("#optNIK").sval({});
        $("#chkAll").val("");
        $("#chKode").val("");
		this.grid1_reloaddata() ;
		// bjs.ajax(this.base_url + '/init') ;
	}

	bos.livconfig.initcomp		= function(){
		this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initselect({
			class 		: "#" + this.id + " .select2.sparent"
		}) ;
		bjs.initenter(this.obj) ;
        bjs.initdate("#" + this.id + " .date") ;
		// bjs.ajax(this.base_url + '/init') ;
	}

	bos.livconfig.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.livconfig.grid1_destroy() ;
		}) ;
	}

    bos.livconfig.cmdsave       = bos.livconfig.obj.find("#cmdsave") ;
	bos.livconfig.initfunc		= function(){
		setTimeout(function(){
			bos.livconfig.obj.find('#cKeterangan').focus() ;
		},1) ;

		
		this.obj.find('form').on("submit", function(e){
        e.preventDefault() ;
			if( bjs.isvalidform(this) ){
				bjs.ajax( bos.livconfig.base_url + '/saving', bjs.getdataform(this) , bos.livconfig.cmdsave) ;
			}
		}) ;

        this.obj.find("#optNIK").on("change",function(e){
            e.preventDefault() ;
            bjs.ajax(bos.livconfig.base_url + "/SeekNIK", "Kode=" + $(this).val()) ;
        });
        
        this.obj.find("#linkUserLevel").on('click',function(e){
            objForm    = "livconfiglevel" ;
            locForm    = "admin/config/username_lv" ;
            setTimeout(function(){
                bjs.form({
                    "module" : "Administrator",
                    "name"   : "",
                    "obj"    : objForm, 
                    "loc"    : locForm
                });
            }, 1);
        });

        this.obj.find("#linkUsers").on('click',function(e){
            objForm    = "livconfig" ;
            locForm    = "admin/config/username" ;
            setTimeout(function(){
                bjs.form({
                    "module" : "Administrator",
                    "name"   : "",
                    "obj"    : objForm, 
                    "loc"    : locForm
                });
            }, 1);
        });

        $("#chkAll").on("change",function(){
            if(this.checked) {
                $("#optNIK").prop("disabled","disabled");    
            }else{
                $("#optNIK").removeAttr("disabled","disabled");    
            }
        });

	}
    
    $('#cabang').select2({
        ajax: {
            url: bos.livconfig.base_url + '/seekcabang',
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

    $('#optNIK').select2({
        ajax: {
            url: bos.livconfig.base_url + '/PickNomorKaryawan',
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
		bos.livconfig.initcomp() ;
		bos.livconfig.initcallback() ;
		bos.livconfig.initfunc() ;
	})
</script>