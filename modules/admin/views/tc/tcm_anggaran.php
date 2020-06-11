<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Data</a></li>
        <li class=""><a onClick="bos.tcm_anggaran.setGridAnggaran()" href="#tab_2" data-toggle="tab" aria-expanded="true">Data Form</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:500px"></div>
        </div>
        <div class="tab-pane" id="tab_2">
            <form>
                <div class="row">
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
                            <div class="form-group">
                                <textarea name="cDeskripsi" id="cDeskripsi" cols="20" rows="10" placeholder="Deskripsi Anggaran..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>&nbsp;</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Detail Anggaran</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label>Keterangan</label>
                            <div class="input-group">
                                <input type="text" id="cKeteranganAnggaran" name="cKeteranganAnggaran" class="form-control" style="width: 360px;" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Nilai</label>
                            <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input type="text" class="form-control" id="nNilaiAnggaran" name="nNilaiAnggaran" placeholder="0.00">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="cmdOK">OK</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        &nbsp;
                    </div>
                    <div class="col-md-12">
                        <div id="gridAnggaran" class="full-height" style="height: 200px;"></div>
                    </div>
                    <div class="col-md-8">
                        <label>Total Anggaran</label>
                        <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" id="nTotalAnggaran" name="nTotalAnggaran" placeholder="0.00" readonly>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <div class="col-md-12">
                                <div class="col-sm-3">
                                    <label>
                                        <input type="radio" name="optMetode" id="optMetode1" value="T" checked>
                                        Tunai
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label>
                                        <input type="radio" name="optMetode" id="optMetode2" value="P">
                                        Pemindahbukuan
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        &nbsp;
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Sifat Dokumen</label>
                            <select class="form-control optSifatSurat select2" data-sf="load_Kota" name="optSifatSurat" id="optSifatSurat" data-placeholder=" - Sifat Dokumen - "></select>
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label>Upload File</label>
                            <div id="idcUplFile"><input style="width:100%" type="file" class="form-control" name="cUplFile" id="cUplFile" required></div>
                        </div>
                    </div> -->
                </div>
                <input type="hidden" name="nNo" id="nNo" value="0">
                <input type="hidden" name="cKodeKaryawan" id="cKodeKaryawan">
                <input type="hidden" name="cFaktur" id="cFaktur">
                <input type="hidden" name="cNoSurat" id="cNoSurat">
                <input type="hidden" name="cLastPath" id="cLastPath">
                <button class="btn btn-primary" id="cmdSave">Simpan</button>
                <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcm_anggaran.init()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    <?=cekbosjs();?>

    bos.tcm_anggaran.grid1_data    = null ;
    bos.tcm_anggaran.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcm_anggaran.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcm_anggaran.base_url + "/loadgrid",
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

    bos.tcm_anggaran.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
    }

    bos.tcm_anggaran.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcm_anggaran.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcm_anggaran.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcm_anggaran.grid1_reloaddata   = function(){
        this.grid1_setdata() ;
    }

    /******************************************** */

    // Grid Detail Anggaran
    bos.tcm_anggaran.gridAnggaran_load  = function(){
        this.obj.find("#gridAnggaran").w2grid({
            name	: this.id + '_gridAnggaran',
            show: {
                footer 		: true,
                toolbar		: false,
                toolbarColumns  : false,
                lineNumbers: true
            },
            columns: [
                // { field: 'no', caption: 'No', size: '50px', sortable: false},
                { field: 'Keterangan', caption: 'Keterangan', size: '300px', sortable: false },
                { field: 'Nominal',render:'float:2', caption: 'Nominal', size: '100px', sortable: false, style:'text-align:right'},
                { field: 'cmdDeleteAnggaran', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcm_anggaran.gridAnggaran_destroy 	= function(){
        if(w2ui[this.id + '_gridAnggaran'] !== undefined){
            w2ui[this.id + '_gridAnggaran'].destroy() ;
        }
    }

    bos.tcm_anggaran.gridAnggaran_reload		= function(){
        w2ui[this.id + '_gridAnggaran'].reload() ;
    }

    bos.tcm_anggaran.gridAnggaran_append    = function(no,Keterangan,Nominal){
        var datagrid  = w2ui[this.id + '_gridAnggaran'].records;
        var lnew      = true;
        var recid     = "";
        if(no <= datagrid.length){
            recid = no;
            w2ui[this.id + '_gridAnggaran'].set(recid,{Keterangan: Keterangan,Nominal:Nominal});
        }else{
            recid = no;
            var Hapus = "<button type='button' onclick = 'bos.tcm_anggaran.gridAnggaran_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridAnggaran'].add([
                   {recid:recid,
                    no: no,
                    Keterangan: Keterangan,
                    Nominal:Nominal,
                    cmdDeleteAnggaran:Hapus}
            ]) ;
        }
        bos.tcm_anggaran.initDetailAnggaran();
        bos.tcm_anggaran.obj.find("#cKeteranganAnggaran").focus() ;
        bos.tcm_anggaran.hitungSubTotal();
    }

    bos.tcm_anggaran.gridAnggaran_deleterow = function(recid){
        if(confirm("Anda yakin untuk menghilangkan data pada nomor "+ recid +" ini ???")){
            w2ui[this.id + '_gridAnggaran'].select(recid);
            w2ui[this.id + '_gridAnggaran'].delete(true);
            bos.tcm_anggaran.gridAnggaran_urutkan();
            bos.tcm_anggaran.initDetailAnggaran();
        }
    }


    bos.tcm_anggaran.gridAnggaran_urutkan = function(){
        var datagrid = w2ui[this.id + '_gridAnggaran'].records;
        w2ui[this.id + '_gridAnggaran'].clear();
        for(i=0;i<datagrid.length;i++){
            var no = i+1;
            datagrid[i]["recid"] = no;
            var recid = no;
            var Hapus = "<button type='button' onclick = 'bos.tcm_anggaran.gridAnggaran_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridAnggaran'].add({recid:recid,
                                                    No: no, 
                                                    Keterangan: datagrid[i]["Keterangan"], 
                                                    Nominal: datagrid[i]["Nominal"],
                                                    cmdDeleteAnggaran:Hapus});
        }
    }

    /************************************************** */

    bos.tcm_anggaran.initForm   = function(){
        $('#cKepada').val("");
        $('#cSubject').val("");
        $('#cDeskripsi').val("");
        tinymce.activeEditor.setContent("");
        $('#cKeteranganAnggaran').val("");
        $('#nNilaiAnggaran').val("");
        $('#nTotalAnggaran').val("");
    }
    
    bos.tcm_anggaran.hitungSubTotal = function(){

        var nRows = w2ui[this.id + '_gridAnggaran'].records.length;
        var nSubTotal = 0 ;
        for(i=0;i< nRows;i++){
            var nNominal = w2ui[this.id + '_gridAnggaran'].getCellValue(i,1);
            nSubTotal += Number(nNominal);
        }
        this.obj.find("#nTotalAnggaran").val($.number(nSubTotal,2));
    }

    bos.tcm_anggaran.initTinyMCE = function(){
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

    bos.tcm_anggaran.initComp	= function(){
        bos.tcm_anggaran.gridAnggaran_load() ;
        bos.tcm_anggaran.grid1_load() ;
        bos.tcm_anggaran.initTinyMCE() ;

        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
	}

    bos.tcm_anggaran.initCallBack	= function(){
        this.obj.on("bos:tab", function(e){
            bos.tcm_anggaran.tabsaction( e.i )  ;
            alert(e.i) ;
        });
        this.obj.on('remove', function(){
            bos.tcm_anggaran.gridAnggaran_destroy() ;
            bos.tcm_anggaran.grid1_destroy() ;
            tinymce.remove() ;
        }) ;
    }

    bos.tcm_anggaran.initTab1 = function(){
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcm_anggaran.initFunc     = function(){
        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                var dataDetailAnggaran   = w2ui['bos-form-tcm_anggaran_gridAnggaran'].records;
                dataDetailAnggaran       = JSON.stringify(dataDetailAnggaran);
                bjs.ajax( bos.tcm_anggaran.base_url + '/validSaving', bjs.getdataform(this)+"&dataDetailAnggaran="+dataDetailAnggaran , bos.tcm_anggaran.cmdSave) ;
            }
        }) ;

        this.obj.find("#cmdOK").on("click", function(e){
            var no                  = bos.tcm_anggaran.obj.find("#nNo").val();
            var cKeterangan         = bos.tcm_anggaran.obj.find("#cKeteranganAnggaran").val();
            var nNilaiAnggaran      = bos.tcm_anggaran.obj.find("#nNilaiAnggaran").val();

            if(nNilaiAnggaran !== "" && cKeterangan !== ""){
                bos.tcm_anggaran.gridAnggaran_reload() ;
                bos.tcm_anggaran.gridAnggaran_append(no,cKeterangan,nNilaiAnggaran);
            }else{
                Swal.fire({
                    icon    : "error",
                    title   : "Error",
                    html    : "Harap Check Keterangan dan Nilai Anggaran!"
                });    
            }
        }) ;
    }

    bos.tcm_anggaran.initDetailAnggaran 			= function(){
        var datagrid = w2ui[this.id + '_gridAnggaran'].records;

        this.obj.find("#nNo").val(datagrid.length+1) ;
        this.obj.find("#cKeteranganAnggaran").val("") ;
        this.obj.find("#nNilaiAnggaran").val("") ;;
    }

    bos.tcm_anggaran.setGridAnggaran = function(){
        bos.tcm_anggaran.gridAnggaran_reload() ;
    }

    bos.tcm_anggaran.cmdEdit = function(id){
        
    }

    $('.optSifatSurat').select2({
        allowClear: true,
        ajax: {
            url: bos.tcm_anggaran.base_url + '/SeekSifatSurat',
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
        bos.tcm_anggaran.initComp() ;
        bos.tcm_anggaran.initCallBack() ;
        bos.tcm_anggaran.initFunc() ;
        bos.tcm_anggaran.initDetailAnggaran();
    })

</script>