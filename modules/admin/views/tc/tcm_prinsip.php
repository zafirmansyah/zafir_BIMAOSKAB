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
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label>Ditujukan Kepada</label>
                                <input type="text" name="cKepada" id="cKepada" class="form-control" maxlength="225" placeholder="Kepada" required>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label>Perihal</label>
                                <input type="text" name="cSubject" id="cSubject" class="form-control" maxlength="225" placeholder="Subject" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Sifat Dokumen</label>
                                <select class="form-control optSifatSurat select2" data-sf="load_Kota" name="optSifatSurat" id="optSifatSurat" data-placeholder=" - Sifat Dokumen - "></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload File</label>
                                <div id="idcUplFile"><input style="width:100%" type="file" class="form-control" name="cUplFile" id="cUplFile" required></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Disposisi</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" id="cDisposisi" name="cDisposisi" class="form-control" placeholder="Klik tombol pencarian untuk memasukkan data disposisi..." readonly>
                                <span class="input-group-btn">
                                    <button class="form-control btn btn-info" type="button" id="cmdDisposisi"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="gridDisposisi" class="full-height" style="height: 200px; border: 1px solid;"></div>
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
                <input type="hidden" name="nNo" id="nNo" value="0">
                <input type="hidden" name="cKodeKaryawan" id="cKodeKaryawan">
                <input type="hidden" name="cFaktur" id="cFaktur">
                <input type="hidden" name="cNoSurat" id="cNoSurat">
                <input type="hidden" name="cLastPath" id="cLastPath">
                <button class="btn btn-primary" id="cmdSave">Simpan</button>
                <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcm_prinsip.init()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    <?=cekbosjs();?>

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
            header   : 'Data Penarikan Anggaran',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'NoSurat', caption: 'Nomor Surat', size: '120px', sortable: false},
                { field: 'Perihal', caption: 'Perihal Anggaran', size: '250px', sortable: false},
                { field: 'Kepada', caption: 'Ditujukan Kepada', size: '200px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'Metode', caption: 'Metode', size: '80px', sortable: false},
                { field: 'Nominal', caption: 'Nominal Anggaran', size: '120px', sortable: false, render:'int'},
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
        this.grid1_setdata() ;
    }


    bos.tcm_prinsip.initForm   = function(){
        $('#cKepada').val("");
        $('#cSubject').val("");
        $('#cDeskripsi').val("");
        tinymce.activeEditor.setContent("");
        $('#cKeteranganAnggaran').val("");
        $('#nNilaiAnggaran').val("");
        $('#nTotalAnggaran').val("");
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
        bos.tcm_prinsip.initTinyMCE() ;

        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
	}

    bos.tcm_prinsip.initCallBack	= function(){
        this.obj.on("bos:tab", function(e){
            bos.tcm_prinsip.tabsaction( e.i )  ;
            alert(e.i) ;
        });
        this.obj.on('remove', function(){
            bos.tcm_prinsip.grid1_destroy() ;
            tinymce.remove() ;
        }) ;
    }

    bos.tcm_prinsip.initTab1 = function(){
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcm_prinsip.initFunc     = function(){
        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tcm_prinsip.base_url + '/validSaving', bjs.getdataform(this) , bos.tcm_prinsip.cmdSave) ;
            }
        }) ;

    }


    bos.tcm_prinsip.cmdEdit = function(id){
        
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