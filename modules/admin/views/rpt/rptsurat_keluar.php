<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Filter Data</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <form>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Awal</label>
                                        <div class="col-xs-12 input-group">
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
                            </div>
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <div class="col-xs-12 input-group">
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
                            </div>
                            <div class="col-md-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Golongan Unit</label>
                                        <div class="col-md-12">
                                            <div class="col-sm-4">
                                                <label>
                                                    <input type="radio" name="optFilterUnit" id="optFilterUnit1" onclick="bos.rptsurat_keluar.selectFilterUnit('A')" value="A" checked>
                                                    All
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>
                                                    <input type="radio" name="optFilterUnit" id="optFilterUnit2" onclick="bos.rptsurat_keluar.selectFilterUnit('P')" value="P">
                                                    Per Unit Kerja
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="col-md-12" id="divSelectUnitKerja">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Unit Kerja Petugas</label>
                                        <select class="form-control optUnit select2" data-sf="load_Kota" name="optUnit" id="optUnit" data-placeholder=" - Unit Petugas - "></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="cMetodeUK" id="cMetodeUK">
                        <button class="btn btn-info pull-right" id="cmdRefresh">Refresh Data</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <center><h3 class="box-title"><b>Daftar Dokumen Keluar</b></h3></center>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive mailbox-messages">
                        <div id="gridSuratKeluar" style="height:700px"></div>
                    </div>
                </div>
                <div class="box-footer no-padding">

                </div>
            </div>
        </div>
    </div>
</section>

<script>

    <?=cekbosjs();?>

    bos.rptsurat_keluar.gridSuratKeluar_data    = null ;
    bos.rptsurat_keluar.gridSuratKeluar_loaddata= function(){
        this.gridSuratKeluar_data      = {
            "dTglAwal"      : $("#dTglAwal").val(),
            "dTglAkhir"     : $("#dTglAkhir").val(),
            "cMetodeUK"     : $("#cMetodeUK").val(),
            "optUnit"       : $("#optUnit").val()
        } ;
    }

    bos.rptsurat_keluar.gridSuratKeluar_load    = function(){
        this.obj.find("#gridSuratKeluar").w2grid({
            name     : this.id + '_gridSuratKeluar',
            limit    : 100 ,
            url      : bos.rptsurat_keluar.base_url + "/loadgrid",
            postData : this.gridSuratKeluar_data ,
            show: {
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            searches: [
                { field: 'Perihal', caption: 'Perihal Dokumen', type: 'text' },
                { field: 'Kepada', caption: 'Ditujukan Kepada', type: 'text' },
                { field: 'UserName', caption: 'Petugas', type: 'text' },
                { field: 'Tgl', caption: 'Tanggal Input', type: 'text' },
            ],
            multiSearch     : false,
            columns: [
                { field: 'Perihal', caption: 'Perihal', size: '250px', sortable: false},
                { field: 'Kepada', caption: 'Kepada', size: '125px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal Input', size: '100px', sortable: false, attr: "align=center"},
                { field: 'JenisSurat', caption: 'Jenis Surat', size: '150px', sortable: false},
                { field: 'UserName', caption: 'Nama Petugas', size: '150px', sortable: false},
                { field: 'Unit', caption: 'Unit', size: '75px', sortable: false, attr: "align=center"},
                { field: 'cmdCheckNomorSurat', caption: '', size: '150px', sortable: false},
            ]
        });
    }

    bos.rptsurat_keluar.gridSuratKeluar_setdata   = function(){
        w2ui[this.id + '_gridSuratKeluar'].postData   = this.gridSuratKeluar_data ;
    }
    bos.rptsurat_keluar.gridSuratKeluar_reload    = function(){
        w2ui[this.id + '_gridSuratKeluar'].reload() ;
    }
    bos.rptsurat_keluar.gridSuratKeluar_destroy   = function(){
        if(w2ui[this.id + '_gridSuratKeluar'] !== undefined){
            w2ui[this.id + '_gridSuratKeluar'].destroy() ;
        }
    }

    bos.rptsurat_keluar.gridSuratKeluar_render    = function(){
        this.obj.find("#gridSuratKeluar").w2render(this.id + '_gridSuratKeluar') ;
    }

    bos.rptsurat_keluar.gridSuratKeluar_reloaddata   = function(){
        this.gridSuratKeluar_loaddata() ;
        this.gridSuratKeluar_setdata() ;
        this.gridSuratKeluar_reload() ;
    }

    bos.rptsurat_keluar.cmdDetail = function(id){
        objForm    = "rptsurat_keluar_read" ;
        locForm    = "admin/rpt/rptsurat_keluar_read" ;
        this.setSessionIDSurat(id);
        setTimeout(function(){
            bjs.form({
                "module" : "Administrator",
                "name"   : "",
                "obj"    : objForm, 
                "loc"    : locForm
            });
        }, 1);
    }
    
    bos.rptsurat_keluar.setSessionIDSurat = function(id){
        bjs.ajax(this.url + '/setSessionIDSurat', 'cKode=' + id);
    }

    bos.rptsurat_keluar.initComp     = function(){
        this.gridSuratKeluar_loaddata() ;
        this.gridSuratKeluar_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        $("#divSelectUnitKerja").css("display","none") ;
        $('#cMetodeUK').val("A");
    }

    bos.rptsurat_keluar.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptsurat_keluar.gridSuratKeluar_destroy() ;
        }) ;
    }

    bos.rptsurat_keluar.initFunc 		= function(){
		this.gridSuratKeluar_loaddata() ;
		this.gridSuratKeluar_load() ;

		this.obj.find("form").on("submit", function(e){ 
         e.preventDefault() ;
      	});
	}

    bos.rptsurat_keluar.selectFilterUnit = function(par){
        $("#cMetodeUK").val(par);
        if(par === 'P'){
            $("#divSelectUnitKerja").css("display","block") ;
        }else{
            $("#divSelectUnitKerja").css("display","none") ;
        }
    }

    bos.rptsurat_keluar.obj.find("#cmdRefresh").on("click", function(){ 
   		bos.rptsurat_keluar.gridSuratKeluar_reloaddata() ;  
	}) ; 

    bos.rptsurat_keluar.cmdCheckNomorSurat = function(id){
        Swal.fire({
            icon    : "info",
            title   : id,
        });   
    }
   
    $('.optUnit').select2({
        allowClear: true,
        ajax: {
            url: bos.rptsurat_keluar.base_url + '/seekUnit',
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
        bos.rptsurat_keluar.initComp() ;
        bos.rptsurat_keluar.initCallBack() ;
        bos.rptsurat_keluar.initFunc() ;
    })

    
</script>