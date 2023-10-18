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
                            <label>Golongan PSBI</label>
                            <select class="form-control optGolonganPSBI select2" name="optGolonganPSBI" id="optGolonganPSBI" data-placeholder=" - Jenis Dokumen - "></select>
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
                            <label>Nama Kegiatan</label>
                            <input type="text" name="cNamaKegiatan" id="cNamaKegiatan" class="form-control" maxlength="225" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Penerima Manfaat</label>
                            <input type="text" name="cPenerimaManfaat" id="cPenerimaManfaat" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Tujuan Manfaat</label>
                            <input type="text" name="cTujuanManfaat" id="cTujuanManfaat" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Ruang Lingkup</label>
                            <input type="text" name="cRuangLingkup" id="cRuangLingkup" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nominal Pengajuan</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>Rp.</b>
                                </div>
                                <input type="text" class="form-control numberthousand number" name="nPengajuan" id="nPengajuan" value=""> 
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Lokasi Kegiatan</label>
                            <select class="form-control optLokasiPSBI select2" data-sf="load_Kota" name="optLokasiPSBI" id="optLokasiPSBI" data-placeholder=" - Lingkup Lokasi PSBI - " required></select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Detail Lokasi</label>
                            <input type="text" name="cDetailLokasi" id="cDetailLokasi" class="form-control" maxlength="225" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Jumlah Anggota Kelompok</label>
                            <input type="text" name="cPesertaPartisipan" id="cPesertaPartisipan" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Permasalahan</label>
                            <input type="text" name="cPermasalahan" id="cPermasalahan" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tanggal Proposal</label>
                            <div class="col-xs-8 input-group">
                                <input
                                    type="text" 
                                    class=" form-control date" 
                                    id="dTglProposal" 
                                    name="dTglProposal" 
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
                            <label>Nomor Surat Proposal</label>
                            <input type="text" name="cNoSuratProposal" id="cNoSuratProposal" class="form-control" maxlength="225" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Jenis Bantuan</label>
                            <div class="col-md-12">
                                <div class="col-sm-4">
                                    <label>
                                        <input type="radio" name="optJenisBantuan" id="optJenisBantuan1" onclick="bos.tcpsbi_realisasi.selectJenisBantuan('D')" value="Dana" checked>
                                        Dana
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <label>
                                        <input type="radio" name="optJenisBantuan" id="optJenisBantuan2" onclick="bos.tcpsbi_realisasi.selectJenisBantuan('B')" value="Barang">
                                        Barang
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <label>
                                        <input type="radio" name="optJenisBantuan" id="optJenisBantuan3" onclick="bos.tcpsbi_realisasi.selectJenisBantuan('DB')" value="Dana dan Barang">
                                        Dana & Barang
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Detail Bantuan</label>
                            <input type="text" name="cDetailBantuan" id="cDetailBantuan" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Nomor M02 Persetujuan</label>
                            <input type="text" name="cKodeM02" id="cKodeM02" class="form-control" maxlength="225" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tanggal Persetujuan M02</label>
                            <div class="col-xs-8 input-group">
                                <input
                                    type="text" 
                                    class=" form-control date" 
                                    id="dTglM02" 
                                    name="dTglM02" 
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
                    <div id="divVendor" class="col-sm-12">
                        <div class="form-group">
                            <label>Vendor</label>
                            <input type="text" name="cVendor" id="cVendor" class="form-control" maxlength="225">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tanggal Realisasi</label>
                            <div class="col-xs-8 input-group">
                                <input
                                    type="text" 
                                    class=" form-control date" 
                                    id="dTglRealisasi" 
                                    name="dTglRealisasi" 
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
                            <label>Realisasi Nilai Bantuan</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>Rp.</b>
                                </div>
                                <input type="text" class="form-control numberthousand number" name="nRealisasi" id="nRealisasi" value="" required> 
                            </div>
                            
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" id="cmdSave">Simpan</button>
                <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcpsbi_realisasi.init()">Cancel</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcpsbi_realisasi.grid1_data    = null ;
    bos.tcpsbi_realisasi.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcpsbi_realisasi.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            // //limit    : 100 ,
            url      : bos.tcpsbi_realisasi.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Daftar Realisasi Anggaran PSBI',
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
                { field: 'NamaKegiatan', caption: 'Nama Kegiatan', type: 'text' },
                { field: 'TanggalRealisasi', caption: 'Tgl Realisasi', type: 'text' },
            ],
            toolbar: {
                items: [
                    { id: 'add', type: 'button', caption: 'Add Record', icon: 'w2ui-icon-plus' }
                ],
                onClick: function (event) {
                    if (event.target == 'add') {
                        bos.tcpsbi_realisasi.showFormInput() ;
                    }
                }
            },
            columns: [
                { field: 'NoRekap', caption: 'Nomor Rekap', size: '20px', sortable: false },
                { field: 'Kode', caption: 'Kode Faktur', size: '150px', sortable: false },
                { field: 'Tgl', caption: 'Tanggal Realisasi', size: '120px', sortable: false },
                { field: 'NamaKegiatan', caption: 'Keterangan', size: '250px', sortable: false },
                { field: 'Golongan', caption: 'Golongan PSBI', size: '100px', sortable: false },
                { field: 'NilaiPengajuan', caption: 'Saldo Pengajuan', size: '150px', render: 'int', sortable: false },
                { field: 'NilaiRealisasi', caption: 'Saldo Realisasi', size: '150px', render: 'int', sortable: false },
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcpsbi_realisasi.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.tcpsbi_realisasi.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcpsbi_realisasi.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcpsbi_realisasi.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcpsbi_realisasi.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.tcpsbi_realisasi.cmdEdit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.tcpsbi_realisasi.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }

    bos.tcpsbi_realisasi.initTab1 = function(){
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcpsbi_realisasi.init         = function(){
        this.obj.find('#cKode').val("");
        this.obj.find('#dTglKegiatan').val("");
        this.obj.find('#optGolonganPSBI').val("");
        this.obj.find('#dTgl').val("");
        this.obj.find('#cNamaKegiatan').val("");
        this.obj.find('#cPenerimaManfaat').val("");
        this.obj.find('#cTujuanManfaat').val("");
        this.obj.find('#cRuangLingkup').val("");
        this.obj.find('#nPengajuan').val("");
        this.obj.find('#optLokasiPSBI').val("");
        this.obj.find('#cDetailLokasi').val("");
        this.obj.find('#cPesertaPartisipan').val("");
        this.obj.find('#cPermasalahan').val("");
        this.obj.find('#dTglKegiatan').val("");
        this.obj.find('#cNoSuratProposal').val("");
        this.obj.find('#cDetailBantuan').val("");
        this.obj.find('#cJenisBantuan').val("");
        this.obj.find('#cKodeM02').val("");
        this.obj.find('#dTglM02').val("");
        this.obj.find('#cVendor').val("");
        this.obj.find('#nRealisasi').val("");
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcpsbi_realisasi.initComp     = function(){
        $('.numberthousand').divide({delimiter: ',',divideThousand: true});
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        $("#divVendor").css("display","none") ;
    }

    bos.tcpsbi_realisasi.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.tcpsbi_realisasi.grid1_destroy() ;
        }) ;
    }

    bos.tcpsbi_realisasi.showFormInput = function(){
        this.obj.find(".nav-tabs li:eq(1)").removeClass("disabled");   
        this.obj.find(".nav-tabs li:eq(1) a").tab("show") ; 
    }

    bos.tcpsbi_realisasi.cmdsave       = bos.tcpsbi_realisasi.obj.find("#cmdsave") ;
    bos.tcpsbi_realisasi.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcpsbi_realisasi.grid1_reloaddata() ;
            }else{//focus
                bos.tcpsbi_realisasi.obj.find("#cKode").focus() ;
            }
        });

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tcpsbi_realisasi.base_url + '/validSaving', bjs.getdataform(this) , bos.tcpsbi_realisasi.cmdsave) ;
            }
        }) ;

        this.obj.find(".nav li.disabled a").click(function() {
            return false;
        });
    }

    bos.tcpsbi_realisasi.selectJenisBantuan = function(par){
        // $("#cMetodeUK").val(par);
        if(par === 'B' || par === 'DB'){
            $("#divVendor").css("display","block") ;
        }else{
            $("#divVendor").css("display","none") ;
        }
    }

    $('#optGolonganPSBI').select2({
        allowClear: true,
        ajax: {
            url: bos.tcpsbi_realisasi.base_url + '/SeekGolonganPSBI',
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
            url: bos.tcpsbi_realisasi.base_url + '/SeekLokasiPSBI',
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
        bos.tcpsbi_realisasi.initComp() ;
        bos.tcpsbi_realisasi.initCallBack() ;
        bos.tcpsbi_realisasi.initFunc() ;
    })

</script>
