<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Data Dokumen</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Tambah Nomor Dokumen</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:500px"></div>
        </div>
        <div class="tab-pane" id="tab_2">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-sm-6">
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
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Perihal</label>
                                <input type="text" name="cSubject" id="cSubject" class="form-control" maxlength="225" placeholder="Subject" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sifat Dokumen</label>
                                <select class="form-control optSifatSurat select2" data-sf="load_Kota" name="optSifatSurat" id="optSifatSurat" data-placeholder=" - Sifat Dokumen - "></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload File</label>
                                <div id="idcUplFile">
                                    <input style="width:100%" type="file" class="form-control cUplFile" id="cUplFile" name="cUplFile[]" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Metode Tanda Tangan</label>
                                <div class="col-md-12">
                                    <div class="col-sm-3">
                                        <label>
                                            <input type="radio" name="optMetode" id="optMetode1" onclick="bos.tcm_prinsip.selectMetode('M')" value="M" checked>
                                            Manual
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>
                                            <input type="radio" name="optMetode" id="optMetode2" onclick="bos.tcm_prinsip.selectMetode('S')" value="S">
                                            By System
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="formDisposisi">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>
                                    Disposisi
                                </label>
                                <span class="pull-right-container">
                                    <span class="label label-primary" onclick="bos.tcm_prinsip.helpDisposisi()">?</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-btn" style="margin-right: 5px;">
                                    <button class="form-control btn btn-info" type="button" id="cmdDisposisi"><i class="fa fa-search"></i></button>
                                </span>
                                <input type="text" id="cDisposisi" name="cDisposisi" class="form-control" placeholder="Klik tombol pencarian untuk memasukkan data disposisi..." readonly>
                                <span class="input-group-btn">
                                    <button class="form-control btn btn-primary" type="button" id="cmdOK">OK</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="gridDisposisi" class="full-height" style="height: 200px;"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>&nbsp;</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <textarea name="cDeskripsi" id="cDeskripsi" cols="20" rows="10" placeholder="Deskripsi Persetujuan Prinsip..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" placeholder="nNo" name="nNo" id="nNo" value="1">
                <input type="hidden" placeholder="cKodeKaryawan" name="cKodeKaryawan" id="cKodeKaryawan">
                <input type="hidden" placeholder="cFaktur" name="cFaktur" id="cFaktur">
                <input type="hidden" placeholder="cNoSurat" name="cNoSurat" id="cNoSurat">
                <input type="hidden" placeholder="cLastPath" name="cLastPath" id="cLastPath">
                <input type="hidden" placeholder="cKodeDispo" name="cKodeDispo" id="cKodeDispo">
                <input type="hidden" placeholder="cMetodeSM" name="cMetodeSM" id="cMetodeSM">
                
                <button class="btn btn-success" id="cmdCheckNomor">Check Nomor</button>
                <button class="btn btn-primary" id="cmdSave">Simpan</button>
                <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcm_prinsip.init()">Cancel</button>
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

    /************************************************************* */
    bos.tcm_prinsip.grid1_data    = null ;
    bos.tcm_prinsip.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcm_prinsip.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcm_prinsip.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Data Memorandum (M.02)',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'NoSurat', caption: 'Nomor Dokumen', size: '150px', sortable: false},
                { field: 'Perihal', caption: 'Perihal', size: '250px', sortable: false},
                { field: 'Kepada', caption: 'Ditujukan Kepada', size: '100px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'MetodeDisposisi', caption: 'Metode Disposisi', size: '80px', sortable: false},
                { field: 'UserName', caption: 'Petugas Entry', size: '100px', sortable: false},
                { field: 'Unit', caption: 'Unit Petugas', size: '120px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcm_prinsip.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
    }

    bos.tcm_prinsip.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcm_prinsip.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcm_prinsip.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcm_prinsip.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    /**************************************************************** */

    /******************************************** */

    bos.tcm_prinsip.gridDisposisi_load    = function(){
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

    bos.tcm_prinsip.gridDisposisi_destroy     = function(){
        if(w2ui[this.id + '_gridDisposisi'] !== undefined){
            w2ui[this.id + '_gridDisposisi'].destroy() ;
        }
    }

    bos.tcm_prinsip.gridDisposisi_reload      = function(){
        w2ui[this.id + '_gridDisposisi'].reload() ;
    }

    bos.tcm_prinsip.gridDisposisi_append    = function(no,kodekaryawan,disposisi){
        var datagrid  = w2ui[this.id + '_gridDisposisi'].records;
        var recid     = "";
        if(no <= datagrid.length){
            recid = no;
            w2ui[this.id + '_gridDisposisi'].set(recid,{level: no, 
                                                        kode:kodekaryawan, 
                                                        disposisi: disposisi});
        }else{
            recid = no;
            var Hapus = "<button type='button' onclick = 'bos.tcm_prinsip.gridDisposisi_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridDisposisi'].add([
                {   recid:recid,
                    level: no,
                    kode:kodekaryawan,
                    disposisi:disposisi,
                    cmdDeleteGr:Hapus}
            ]) ;
        }
        bos.tcm_prinsip.initDetail();
        bos.tcm_prinsip.obj.find("#cmdDisposisi").focus() ;
    }

    bos.tcm_prinsip.gridDisposisi_deleterow = function(recid){
        if(confirm("Anda yakin untuk menghilangkan data pada nomor "+ recid +" ini ???")){
            w2ui[this.id + '_gridDisposisi'].select(recid);
            w2ui[this.id + '_gridDisposisi'].delete(true);
            bos.tcm_prinsip.gridDisposisi_urutkan();
            bos.tcm_prinsip.initDetail();

        }
    }

    bos.tcm_prinsip.gridDisposisi_render  = function(){
        this.obj.find("#gridDisposisi").w2render(this.id + '_gridDisposisi') ;
    }

    bos.tcm_prinsip.gridDisposisi_clear   = function(){
        w2ui[this.id + '_gridDisposisi'].clear();
    }

    bos.tcm_prinsip.gridDisposisi_urutkan = function(){
        var datagrid = w2ui[this.id + '_gridDisposisi'].records;
        w2ui[this.id + '_gridDisposisi'].clear();
        for(i=0;i<datagrid.length;i++){
            var no = i+1;
            datagrid[i]["recid"] = no;
            var recid = no;
            var Hapus = "<button type='button' onclick = 'bos.tcm_prinsip.gridDisposisi_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridDisposisi'].add({recid:recid,level: recid, 
                                                              kode: datagrid[i]["kode"],
                                                              disposisi: datagrid[i]["disposisi"],
                                                              cmdDeleteGr:Hapus});
        }
    }

    /******************************************** */

    /******************************************** */

    //grid3 Disposisi
    bos.tcm_prinsip.grid3_data    = null ;
    bos.tcm_prinsip.grid3_loaddata= function(){
        this.grid3_data         = {} ;
    }

    bos.tcm_prinsip.grid3_load    = function(){
        this.obj.find("#grid3").w2grid({
            name    : this.id + '_grid3',
            limit   : 100 ,
            url     : bos.tcm_prinsip.base_url + "/loadGridDataUserDisposisi",
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

    bos.tcm_prinsip.grid3_setdata = function(){
        w2ui[this.id + '_grid3'].postData   = this.grid3_data ;
    }
    bos.tcm_prinsip.grid3_reload      = function(){
        w2ui[this.id + '_grid3'].reload() ;
    }
    bos.tcm_prinsip.grid3_destroy     = function(){
        if(w2ui[this.id + '_grid3'] !== undefined){
            w2ui[this.id + '_grid3'].destroy() ;
        }
    }

    bos.tcm_prinsip.grid3_render  = function(){
        this.obj.find("#grid3").w2render(this.id + '_grid3') ;
    }

    bos.tcm_prinsip.grid3_reloaddata  = function(){
        this.grid3_loaddata() ;
        this.grid3_setdata() ;
        this.grid3_reload() ;
    }

    /********************************************** */


    bos.tcm_prinsip.initForm   = function(){
        $('#cKepada').val("");
        $('#cSubject').val("");
        $('#cDeskripsi').val("");
        tinymce.activeEditor.setContent("");
        $('#cKeteranganAnggaran').val("");
        $('#nNilaiAnggaran').val("");
        $('#nTotalAnggaran').val("");
        $('#cUplFile').val("");
        $('#optSifatSurat').sval("");
        this.initDetail() ;
        bos.tcm_prinsip.gridDisposisi_clear() ;
        bjs.ajax(this.url + '/initForm');
    }
    
    bos.tcm_prinsip.initTinyMCE = function(){
        tinymce.init({
            selector: '#cDeskripsi',
            height: 450,
            file_browser_callback_types: 'file image media',
            file_picker_types: 'file image media',   
            forced_root_block : "",
            force_br_newlines : true,
            force_p_newlines : false,
        });
    }

    bos.tcm_prinsip.initComp	= function(){
        bos.tcm_prinsip.grid1_load() ;
        bos.tcm_prinsip.gridDisposisi_load() ;
        bos.tcm_prinsip.grid3_load() ;
        bos.tcm_prinsip.initTinyMCE() ;

        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        $("#formDisposisi").css("display","none") ;
	}

    bos.tcm_prinsip.initCallBack	= function(){
        this.obj.on("bos:tab", function(e){
            bos.tcm_prinsip.tabsaction( e.i )  ;
            alert(e.i) ;
        });
        this.obj.on('remove', function(){
            bos.tcm_prinsip.grid1_destroy() ;
            bos.tcm_prinsip.gridDisposisi_destroy() ;
            bos.tcm_prinsip.grid3_destroy() ;
            tinymce.remove() ;
        }) ;
    }

    bos.tcm_prinsip.initTab1 = function(){
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcm_prinsip.init = function(){
        this.initTab1() ;
        this.initForm() ;
    }

    bos.tcm_prinsip.initDetail            = function(){
        var datagrid = w2ui[this.id + '_gridDisposisi'].records;

        this.obj.find("#nNo").val(datagrid.length+1) ;
        this.obj.find("#cDisposisi").val("") ;
        this.obj.find("#cKodeKaryawan").val("") ;;
    }

    bos.tcm_prinsip.initFunc     = function(){
        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                var optMetodeTTD = $("#cMetodeSM").val();
                var dataGridDisposisi = "" ;
                if(optMetodeTTD === "S"){
                    var dataGridDisposisi   = w2ui['bos-form-tcm_prinsip_gridDisposisi'].records;
                }
                // alert(optMetodeTTD) ;
                dataGridDisposisi       = JSON.stringify(dataGridDisposisi);
                bjs.ajax( bos.tcm_prinsip.base_url + '/validSaving', bjs.getdataform(this)+"&dataDisposisi="+dataGridDisposisi , bos.tcm_prinsip.cmdSave) ;
            }
        }) ;

        this.obj.find("#cmdDisposisi").on("click", function(e){
            bos.tcm_prinsip.loadModalDisposisi("show");
            bos.tcm_prinsip.grid3_reloaddata() ;
        }) ;

        this.obj.find('#cmdCheckNomor').on('click',function(e){
            e.preventDefault() ;
            var optJenisSurat = $('#optJenisSurat').val();
            var optSifatSurat = $('#optSifatSurat').val();            
            var dTgl          = $('#dTgl').val();
            var optUnit       = $('#optUnit').val();
            bjs.ajax(bos.tcm_prinsip.base_url + '/checkNomorSurat', 'optSifatSurat='+optSifatSurat+'&dTgl='+dTgl) ;
        });

        this.obj.find("#cUplFile").on("change", function(e){
            e.preventDefault() ;
            bos.tcm_prinsip.uname       = $(this).attr("id") ;
            bos.tcm_prinsip.fal         = $("#cUplFile")[0].files;
            bos.tcm_prinsip.gfal        = new FormData() ;
            for(var i = 0; i < bos.tcm_prinsip.fal.length; i++){
                bos.tcm_prinsip.gfal.append("cUplFile[]",bos.tcm_prinsip.fal[i]);
            }
            bos.tcm_prinsip.obj.find("#idl" + bos.tcm_prinsip.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.tcm_prinsip.base_url + "/savingFile" , bos.tcm_prinsip.gfal, this) ;
            
        }) ;

        this.obj.find("#cmdOK").on("click", function(e){
            var no                  = bos.tcm_prinsip.obj.find("#nNo").val();
            var kodekaryawan        = bos.tcm_prinsip.obj.find("#cKodeKaryawan").val();
            var disposisi           = bos.tcm_prinsip.obj.find("#cDisposisi").val();

            if(disposisi !== ""){
                bos.tcm_prinsip.gridDisposisi_reload() ;
                bos.tcm_prinsip.gridDisposisi_append(no,kodekaryawan,disposisi);
            }else{
                Swal.fire({
                    icon    : "error",
                    title   : "Error",
                    html    : "Data Disposisi Harus Dipilih terlebih dahulu"
                });    
            }
        }) ;

    }

    bos.tcm_prinsip.loadModalDisposisi      = function(l){
        this.obj.find("#modalDisposisi").modal(l) ;
    }


    bos.tcm_prinsip.cmdEdit = function(id){
        bjs.ajax(this.url + '/editing', 'cFaktur=' + id);
    }

    bos.tcm_prinsip.cmdDelete = function(id){
        if(confirm("Yakin untuk hapus data ini?")){
            bjs.ajax(this.url + '/deletePrinsip', 'cFaktur=' + id);
            this.grid1_reloaddata() ;
        }else{
            this.grid1_reloaddata() ;

        }
    }

    bos.tcm_prinsip.helpDisposisi = function(){
        Swal.fire({
            icon: "question",
            title: "How to?" ,
            text : "Tentukan level disposisi dari yang paling rendah sampai paling tinggi tingkatannya"
        });  
    }

    bos.tcm_prinsip.selectMetode = function(par){
        $("#cMetodeSM").val(par);
        if(par === 'S'){
            $("#formDisposisi").css("display","block") ;
            bos.tcm_prinsip.setGridDisposisi() ;
            bos.tcm_prinsip.gridDisposisi_clear() ;
        }else{
            $("#formDisposisi").css("display","none") ;
        }
    }

    bos.tcm_prinsip.setGridDisposisi = function(){
        bos.tcm_prinsip.gridDisposisi_reload() ;
    }

    bos.tcm_prinsip.setContentJS = function(par){
        tinymce.activeEditor.setContent(par , {format: 'raw'});
    }

    bos.tcm_prinsip.setopt = function(nama,isi){
        this.obj.find('input:radio[name='+nama+'][value='+isi+']').prop('checked',true);
    }

    bos.tcm_prinsip.cmdPilih      = function(kode){
        bjs.ajax(this.url + '/selectTargetDisposisi', 'kode=' + kode);
    }

    $('.optSifatSurat').select2({
        allowClear: true,
        ajax: {
            url: bos.tcm_prinsip.base_url + '/SeekSifatSurat',
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
        bos.tcm_prinsip.initComp() ;
        bos.tcm_prinsip.initCallBack() ;
        bos.tcm_prinsip.initFunc() ;
        // bos.tcm_prinsip.initDetailAnggaran();
    })

</script>