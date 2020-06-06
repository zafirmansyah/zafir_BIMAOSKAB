<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Data</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Data Form</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:500px"></div>
        </div>
        <div class="tab-pane" id="tab_2">
        <form>
            <div class="row">
                <!-- <div class="col-sm-4">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" name="cKode" id="cKode" class="form-control" placeholder="001" maxlength="3" required>
                    </div>
                </div> -->
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Surat Ditujukan Kepada</label>
                        <input type="text" name="cKepada" id="cKepada" class="form-control" maxlength="225" placeholder="Surat ditujukan kepada..." required>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Perihal Surat</label>
                        <input type="text" name="cPerihal" id="cPerihal" class="form-control" maxlength="225" placeholder="Perihal" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <div class="col-xs-8 input-group">
                            <input
                                type="text" 
                                class=" form-control date" 
                                id="dTgl" 
                                name="dTgl" 
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
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Jenis Golongan Dokumen</label>
                        <select class="form-control optJenisSurat select2" data-sf="load_Kota" name="optJenisSurat" id="optJenisSurat" data-placeholder=" - Jenis Golongan Dokumen - "></select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Sifat Dokumen</label>
                        <select class="form-control optSifatSurat select2" data-sf="load_Kota" name="optSifatSurat" id="optSifatSurat" data-placeholder=" - Sifat Dokumen - "></select>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" id="cmdsave">Simpan</button>
            <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcsurat_keluar.init()">Cancel</button>
        </form>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcsurat_keluar.grid1_data    = null ;
    bos.tcsurat_keluar.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcsurat_keluar.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcsurat_keluar.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Daftar Surat Keluar',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'Kode', caption: 'Kode', size: '100px', sortable: false},
                { field: 'Perihal', caption: 'Perihal Surat', size: '250px', sortable: false},
                { field: 'Kepada', caption: 'Ditujukan Kepada', size: '125px', sortable: false},
                { field: 'JenisSurat', caption: 'Jenis Surat', size: '150px', sortable: false},
                { field: 'NoSurat', caption: 'Nomor Surat', size: '150px', sortable: false},
                { field: 'UserName', caption: 'Petugas', size: '100px', sortable: false},
                { field: 'Unit', caption: 'Unit Petugas', size: '125px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcsurat_keluar.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.tcsurat_keluar.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcsurat_keluar.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcsurat_keluar.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcsurat_keluar.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.tcsurat_keluar.cmdedit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.tcsurat_keluar.cmddelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }

    bos.tcsurat_keluar.init         = function(){
        this.obj.find("#cKepada").val("") ;
        this.obj.find("#cPerihal").val("") ;
        this.obj.find("#optJenisSurat").sval("") ;
        bjs.ajax(this.url + '/init') ;

        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcsurat_keluar.initcomp     = function(){
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        bjs.ajax(this.url + '/init') ;
    }

    bos.tcsurat_keluar.initcallback = function(){
        this.obj.on('remove', function(){
            bos.tcsurat_keluar.grid1_destroy() ;
        }) ;
    }

    bos.tcsurat_keluar.cmdsave       = bos.tcsurat_keluar.obj.find("#cmdsave") ;
    bos.tcsurat_keluar.initfunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcsurat_keluar.grid1_reloaddata() ;
            }else{//focus
                bos.tcsurat_keluar.obj.find("#nik").focus() ;
            }
        });

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tcsurat_keluar.base_url + '/saving', bjs.getdataform(this) , bos.tcsurat_keluar.cmdsave) ;
            }
        }) ;
    }

    $('.optJenisSurat').select2({
        allowClear: true,
        ajax: {
            url: bos.tcsurat_keluar.base_url + '/SeekJenisSurat',
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

    $('.optSifatSurat').select2({
        allowClear: true,
        ajax: {
            url: bos.tcsurat_keluar.base_url + '/SeekSifatSurat',
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
        bos.tcsurat_keluar.initcomp() ;
        bos.tcsurat_keluar.initcallback() ;
        bos.tcsurat_keluar.initfunc() ;
    })

</script>