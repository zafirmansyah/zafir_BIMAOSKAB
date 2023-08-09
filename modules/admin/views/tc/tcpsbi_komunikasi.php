<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Data</a></li>
        <li class="disabled"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="cursor: not-allowed;">Data Form</a></li>
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
                            <label>Kode Faktur</label>
                            <input type="text" name="cKode" id="cKode" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tanggal Entry</label>
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
                            <label>Waktu Kegiatan</label>
                            <div class="col-xs-8 input-group">
                                <input
                                    type="text" 
                                    class=" form-control date" 
                                    id="dTglKegiatan" 
                                    name="dTglKegiatan" 
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
                            <label>Program / Kegiatan Berdasarkan Jenis Kegiatan Komunikasi</label>
                            <input type="text" name="cNamaKegiatan" id="cNamaKegiatan" class="form-control" maxlength="225" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Unit Kerja penyelenggara</label>
                            <input type="text" name="cUnitKerjaPenyelenggara" id="cUnitKerjaPenyelenggara" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Latar Belakang Kegiatan</label>
                            <input type="text" name="cLatarBelakang" id="cLatarBelakang" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" name="cTujuan" id="cTujuan" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Narasumber</label>
                            <input type="text" name="cNarasumber" id="cNarasumber" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Audience / Peserta / Sasaran</label>
                            <input type="text" name="cPeserta" id="cPeserta" class="form-control" maxlength="225" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Saluran</label>
                            <input type="text" name="cSaluran" id="cSaluran" class="form-control" maxlength="225" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Persepsi Stakeholder terkait Komunikasi Kebijakan BI</label>
                            <input type="text" name="cPersepsiStakeholder" id="cPersepsiStakeholder" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Realisasi Nilai Bantuan</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>Rp.</b>
                                </div>
                                <input type="text" class="form-control numberthousand number" name="nRealisasi" id="nRealisasi" value="" required> 
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Dampak/Output </label>
                            <input type="text" name="cDampakOutput" id="cDampakOutput" class="form-control" maxlength="225" required>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" id="cmdSave">Simpan</button>
                <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcpsbi_komunikasi.init()">Cancel</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcpsbi_komunikasi.grid1_data    = null ;
    bos.tcpsbi_komunikasi.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcpsbi_komunikasi.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcpsbi_komunikasi.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'DATA KOMUNIKASI YANG TELAH DILAKSANAKAN KANTOR PERWAKILAN BANK INDONESIA MALANG',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            searches: [
                { field: 'Kode', caption: 'Kode Faktur', type: 'text' },
                { field: 'NamaProgram', caption: 'Nama Program', type: 'text' },
                { field: 'WaktuPelaksanaan', caption: 'Tgl Kegiatan', type: 'text' },
            ],
            toolbar: {
                items: [
                    { id: 'add', type: 'button', caption: 'Add Record', icon: 'w2ui-icon-plus' }
                ],
                onClick: function (event) {
                    if (event.target == 'add') {
                        bos.tcpsbi_komunikasi.showFormInput() ;
                    }
                }
            },
            columns: [
                { field: 'Kode', caption: 'Kode Faktur', size: '150px', sortable: false },
                { field: 'Tgl', caption: 'Tanggal Entry', size: '120px', sortable: false },
                { field: 'WaktuPelaksanaan', caption: 'Tanggal Kegiatan', size: '120px', sortable: false },
                { field: 'NamaProgram', caption: 'Program / Kegiatan Berdasarkan Jenis Kegiatan Komunikasi', size: '250px', sortable: false },
                { field: 'Narasumber', caption: 'Audience/Peserta/Sasaran', size: '150px', sortable: false },
                { field: 'PenggunaanAnggaran', caption: 'Penggunaan Anggaran (Rp) ', size: '150px', render: 'int', sortable: false },
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcpsbi_komunikasi.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.tcpsbi_komunikasi.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcpsbi_komunikasi.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcpsbi_komunikasi.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcpsbi_komunikasi.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.tcpsbi_komunikasi.cmdEdit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.tcpsbi_komunikasi.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }

    bos.tcpsbi_komunikasi.initTab1 = function(){
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcpsbi_komunikasi.init         = function(){
        $('#cKode').val("");
        $('#dTgl').val("");
        $('#dTglKegiatan').val("");
        $('#cNamaKegiatan').val("");
        $('#cUnitKerjaPenyelenggara').val("");
        $('#cLatarBelakang').val("");
        $('#cTujuan').val("");
        $('#cNarasumber').val("");
        $('#cPeserta').val("");
        $('#cSaluran').val("");
        $('#cPersepsiStakeholder').val("");
        $('#nRealisasi').val("");
        $('#cDampakOutput').val("");
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcpsbi_komunikasi.initComp     = function(){
        $('.numberthousand').divide({delimiter: ',',divideThousand: true});
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
    }

    bos.tcpsbi_komunikasi.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.tcpsbi_komunikasi.grid1_destroy() ;
        }) ;
    }

    bos.tcpsbi_komunikasi.showFormInput = function(){
        this.obj.find(".nav-tabs li:eq(1)").removeClass("disabled");   
        this.obj.find(".nav-tabs li:eq(1) a").tab("show") ; 
    }

    bos.tcpsbi_komunikasi.cmdsave       = bos.tcpsbi_komunikasi.obj.find("#cmdsave") ;
    bos.tcpsbi_komunikasi.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcpsbi_komunikasi.grid1_reloaddata() ;
            }else{//focus
                bos.tcpsbi_komunikasi.obj.find("#cKode").focus() ;
            }
        });

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tcpsbi_komunikasi.base_url + '/validSaving', bjs.getdataform(this) , bos.tcpsbi_komunikasi.cmdsave) ;
            }
        }) ;

        this.obj.find(".nav li.disabled a").click(function() {
            return false;
        });
    }

    $('#optGolonganPSBI').select2({
        allowClear: true,
        ajax: {
            url: bos.tcpsbi_komunikasi.base_url + '/SeekGolonganPSBI',
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

    $('#optLokasiPSBI').select2({
        allowClear: true,
        ajax: {
            url: bos.tcpsbi_komunikasi.base_url + '/SeekLokasiPSBI',
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
        bos.tcpsbi_komunikasi.initComp() ;
        bos.tcpsbi_komunikasi.initCallBack() ;
        bos.tcpsbi_komunikasi.initFunc() ;
    })

</script>