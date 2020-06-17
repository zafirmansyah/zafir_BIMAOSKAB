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
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Surat Dari</label>
                        <input type="text" name="cSuratDari" id="cSuratDari" class="form-control" maxlength="225" placeholder="Surat Dari..." required>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Perihal Surat</label>
                        <input type="text" name="cPerihal" id="cPerihal" class="form-control" maxlength="225" placeholder="Perihal" required>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input type="text" name="cNomorSurat" id="cNomorSurat" class="form-control" maxlength="225" placeholder="Nomor Surat Masuk" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tanggal Surat Masuk</label>
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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tanggal Penulisan Surat</label>
                        <div class="col-xs-8 input-group">
                            <input
                                type="text" 
                                class=" form-control date" 
                                id="dTglSurat" 
                                name="dTglSurat" 
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
                        <label>Jenis Surat</label>
                        <select class="form-control optJenisSurat select2" data-sf="load_Kota" name="optJenisSurat" id="optJenisSurat" data-placeholder=" - Jenis Surat - "></select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Disposisi</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="text" id="cDisposisi" name="cDisposisi" class="form-control" placeholder="Klik tombol pencarian untuk memasukkan data disposisi..." readonly>
                        <span class="input-group-btn">
                            <button class="form-control btn btn-info" type="button" id="cmdDisposisi"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary" id="cmdOK">OK</button>
                </div>
                <div class="col-md-12">
                    &nbsp;
                </div>
                <div class="col-md-12">
                    <div id="gridDisposisi" class="full-height" style="height: 200px;"></div>
                </div>
                <div class="col-md-12">
                    &nbsp;
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Upload File</label>
                        <div id="idcUplFile">
                            <input style="width:100%" type="file" class="form-control cUplFile" id="cUplFile" name="cUplFile[]" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="nNo" id="nNo" value="0">
            <input type="hidden" name="cKodeKaryawan" id="cKodeKaryawan">
            <input type="hidden" name="cKode" id="cKode">
            <input type="hidden" name="cLastPath" id="cLastPath">
            <button class="btn btn-primary" id="cmdSave">Simpan</button>
            <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcsurat_masuk.init()">Cancel</button>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDisposisi" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="wm-title">Daftar Nama Pegawai</h4>
            </div>
            <div class="modal-body">
                <div id="grid3" style="height:250px"></div>
            </div>
            <div class="modal-footer">
                *Pilih Nama Pegawai
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcsurat_masuk.grid1_data    = null ;
    bos.tcsurat_masuk.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcsurat_masuk.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcsurat_masuk.base_url + "/loadgrid",
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
                { field: 'NoSurat', caption: 'Nomor Surat', size: '150px', sortable: false},
                { field: 'Dari', caption: 'Surat Dari', size: '250px', sortable: false},
                { field: 'Perihal', caption: 'Perihal Surat', size: '250px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'UserName', caption: 'Petugas Entry', size: '100px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcsurat_masuk.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }

    bos.tcsurat_masuk.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcsurat_masuk.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcsurat_masuk.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcsurat_masuk.grid1_reloaddata   = function(){
        this.grid1_setdata() ;
    }

    /******************************************** */

    bos.tcsurat_masuk.gridDisposisi_load    = function(){
        this.obj.find("#gridDisposisi").w2grid({
            name    : this.id + '_gridDisposisi',
            show: {
                footer      : true,
                toolbar     : false,
                toolbarColumns  : false,
                lineNumbers: true
            },
            columns: [
                { field: 'level', caption: 'Urutan Tujuan', size: '100px', sortable: false },
                { field: 'kode', caption: 'Kode Karyawan', size: '150px', sortable: false },
                { field: 'disposisi', caption: 'Nama Karyawan', size: '200px', sortable: false },
                { field: 'cmdDeleteGr', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcsurat_masuk.gridDisposisi_destroy     = function(){
        if(w2ui[this.id + '_gridDisposisi'] !== undefined){
            w2ui[this.id + '_gridDisposisi'].destroy() ;
        }
    }

    bos.tcsurat_masuk.gridDisposisi_reload      = function(){
        w2ui[this.id + '_gridDisposisi'].reload() ;
    }

    bos.tcsurat_masuk.gridDisposisi_append    = function(no,kodekaryawan,disposisi){
        var datagrid  = w2ui[this.id + '_gridDisposisi'].records;
        var recid     = "";
        if(no <= datagrid.length){
            recid = no;
            w2ui[this.id + '_gridDisposisi'].set(recid,{level: no, 
                                                        kode:kodekaryawan, 
                                                        disposisi: disposisi});
        }else{
            recid = no;
            var Hapus = "<button type='button' onclick = 'bos.tcsurat_masuk.gridDisposisi_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridDisposisi'].add([
                {   recid:recid,
                    level: no,
                    kode:kodekaryawan,
                    disposisi:disposisi,
                    cmdDeleteGr:Hapus}
            ]) ;
        }
        bos.tcsurat_masuk.initDetail();
        bos.tcsurat_masuk.obj.find("#cmdDisposisi").focus() ;
    }

    bos.tcsurat_masuk.gridDisposisi_deleterow = function(recid){
        if(confirm("Anda yakin untuk menghilangkan data pada nomor "+ recid +" ini ???")){
            w2ui[this.id + '_gridDisposisi'].select(recid);
            w2ui[this.id + '_gridDisposisi'].delete(true);
            bos.tcsurat_masuk.gridDisposisi_urutkan();
            bos.tcsurat_masuk.initDetail();

        }
    }

    bos.tcsurat_masuk.gridDisposisi_render  = function(){
        this.obj.find("#gridDisposisi").w2render(this.id + '_gridDisposisi') ;
    }

    bos.tcsurat_masuk.gridDisposisi_clear   = function(){
        w2ui[this.id + '_gridDisposisi'].clear();
    }

    bos.tcsurat_masuk.gridDisposisi_urutkan = function(){
        var datagrid = w2ui[this.id + '_gridDisposisi'].records;
        w2ui[this.id + '_gridDisposisi'].clear();
        for(i=0;i<datagrid.length;i++){
            var no = i+1;
            datagrid[i]["recid"] = no;
            var recid = no;
            var Hapus = "<button type='button' onclick = 'bos.tcsurat_masuk.gridDisposisi_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridDisposisi'].add({recid:recid,level: recid, 
                                                              kode: datagrid[i]["kode"],
                                                              disposisi: datagrid[i]["disposisi"],
                                                              cmdDeleteGr:Hapus});
        }
    }

    /******************************************** */
    /******************************************** */

    //grid3 Disposisi
    bos.tcsurat_masuk.grid3_data    = null ;
    bos.tcsurat_masuk.grid3_loaddata= function(){
        this.grid3_data         = {} ;
    }

    bos.tcsurat_masuk.grid3_load    = function(){
        this.obj.find("#grid3").w2grid({
            name    : this.id + '_grid3',
            limit   : 100 ,
            url     : bos.tcsurat_masuk.base_url + "/loadGridDataUserDisposisi",
            postData: this.grid3_data ,
            show: {
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false
            },
            multiSearch     : false,
            columns: [
                { field: 'fullname', caption: 'Nama', size: '200px', sortable: false },
                { field: 'unit', caption: 'Satuan Unit', size: '100px', sortable: false },
                { field: 'cmdPilih', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcsurat_masuk.grid3_setdata = function(){
        w2ui[this.id + '_grid3'].postData   = this.grid3_data ;
    }
    bos.tcsurat_masuk.grid3_reload      = function(){
        w2ui[this.id + '_grid3'].reload() ;
    }
    bos.tcsurat_masuk.grid3_destroy     = function(){
        if(w2ui[this.id + '_grid3'] !== undefined){
            w2ui[this.id + '_grid3'].destroy() ;
        }
    }

    bos.tcsurat_masuk.grid3_render  = function(){
        this.obj.find("#grid3").w2render(this.id + '_grid3') ;
    }

    bos.tcsurat_masuk.grid3_reloaddata  = function(){
        this.grid3_loaddata() ;
        this.grid3_setdata() ;
        this.grid3_reload() ;
    }

    /********************************************** */

    bos.tcsurat_masuk.cmdEdit      = function(id){
        bos.tcsurat_masuk.gridDisposisi_clear();
        bos.tcsurat_masuk.gridDisposisi_reload() ;
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.tcsurat_masuk.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }

    bos.tcsurat_masuk.cmdPilih      = function(kode){
        bjs.ajax(this.url + '/selectTargetDisposisi', 'kode=' + kode);
    }

    bos.tcsurat_masuk.init         = function(){
        this.obj.find("#cSuratDari").val("") ;
        this.obj.find("#cPerihal").val("") ;
        this.obj.find("#cNomorSurat").val("") ;
        this.obj.find("#cDisposisi").val("") ;
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cKodeKaryawan").val("") ;
        this.obj.find("#nNo").val("0") ;
        bjs.ajax(this.url + '/init') ;
        w2ui[this.id + '_gridDisposisi'].clear(); 
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bos.tcsurat_keluar.grid1_loaddata() ;
    }

    bos.tcsurat_masuk.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;

        this.grid1_loaddata() ;
        this.grid1_load() ;

        this.gridDisposisi_load() ;
        this.gridDisposisi_reload() ;

        this.grid3_loaddata() ;
        this.grid3_load() ;
        
        bjs.ajax(this.url + '/init') ;
    }

    bos.tcsurat_masuk.initDetail            = function(){
        var datagrid = w2ui[this.id + '_gridDisposisi'].records;

        this.obj.find("#nNo").val(datagrid.length+1) ;
        this.obj.find("#cDisposisi").val("") ;
        this.obj.find("#cKodeKaryawan").val("") ;;
    }

    bos.tcsurat_masuk.tabsaction    = function(n){
        if(n == 0){
            bos.tcsurat_masuk.grid1_render() ;
            bos.tcsurat_masuk.init() ;
        }else{
            bos.tcsurat_masuk.gridDisposisi_reload() ;
        }
    }

    bos.tcsurat_masuk.initCallBack = function(){
        this.obj.on("bos:tab", function(e){
            bos.tcsurat_masuk.tabsaction( e.i )  ;
        });
        this.obj.on('remove', function(){
            bos.tcsurat_masuk.grid1_destroy() ;
            bos.tcsurat_masuk.gridDisposisi_destroy() ;
            bos.tcsurat_masuk.grid3_destroy() ;
        }) ;
    }

    bos.tcsurat_masuk.loadModalDisposisi      = function(l){
        this.obj.find("#modalDisposisi").modal(l) ;
    }

    bos.tcsurat_masuk.cmdSave           = bos.tcsurat_masuk.obj.find("#cmdSave") ;
    bos.tcsurat_masuk.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcsurat_masuk.grid1_reloaddata() ;
                bos.tcsurat_masuk.gridDisposisi_reload() ;
            }else{//focus
                bos.tcsurat_masuk.gridDisposisi_reload() ;
            }
        });

        this.obj.find("#cmdDisposisi").on("click", function(e){
            bos.tcsurat_masuk.loadModalDisposisi("show");
            bos.tcsurat_masuk.grid3_reloaddata() ;
        }) ;

        

        this.obj.find("#cmdOK").on("click", function(e){
            var no                  = bos.tcsurat_masuk.obj.find("#nNo").val();
            var kodekaryawan        = bos.tcsurat_masuk.obj.find("#cKodeKaryawan").val();
            var disposisi           = bos.tcsurat_masuk.obj.find("#cDisposisi").val();

            if(disposisi !== ""){
                bos.tcsurat_masuk.gridDisposisi_reload() ;
                bos.tcsurat_masuk.gridDisposisi_append(no,kodekaryawan,disposisi);
            }else{
                Swal.fire({
                    icon    : "error",
                    title   : "Error",
                    html    : "Data Disposisi Harus Dipilih terlebih dahulu"
                });    
            }
        }) ;

        this.obj.find("#cUplFile").on("change", function(e){
            e.preventDefault() ;
            bos.tcsurat_masuk.uname       = $(this).attr("id") ;
            bos.tcsurat_masuk.fal         = $("#cUplFile")[0].files;//e.target.files;
            bos.tcsurat_masuk.gfal        = new FormData() ;
            for(var i = 0; i < bos.tcsurat_masuk.fal.length; i++){
                bos.tcsurat_masuk.gfal.append("cUplFile[]",bos.tcsurat_masuk.fal[i]);
            }
            bos.tcsurat_masuk.obj.find("#idl" + bos.tcsurat_masuk.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.tcsurat_masuk.base_url + "/savingFile" , bos.tcsurat_masuk.gfal, this) ;
            
        }) ;
        

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                var dataGridDisposisi   = w2ui['bos-form-tcsurat_masuk_gridDisposisi'].records;
                dataGridDisposisi       = JSON.stringify(dataGridDisposisi);
                bjs.ajax( bos.tcsurat_masuk.base_url + '/saving', bjs.getdataform(this)+"&dataDisposisi="+dataGridDisposisi , bos.tcsurat_masuk.cmdSave) ;
            }
        }) ;
        
    }

    $('.optJenisSurat').select2({
        allowClear: true,
        ajax: {
            url: bos.tcsurat_masuk.base_url + '/SeekJenisSurat',
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
        bos.tcsurat_masuk.initComp() ;
        bos.tcsurat_masuk.initCallBack() ;
        bos.tcsurat_masuk.initFunc() ;
        bos.tcsurat_masuk.initDetail();
    })

</script>