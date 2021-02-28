<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_0" data-toggle="tab" aria-expanded="true">Filter</a></li>
        <li class="disabled"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Data</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_0">
            <!-- <form> -->
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Realisasi Awal</label>
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
                                        <label>Tanggal Realisasi Akhir</label>
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
                                        <label>Golongan PSBI</label>
                                        <div class="col-md-12">
                                            <div class="col-sm-4">
                                                <label>
                                                    <input type="radio" name="optFilterUnit" id="optFilterUnit1" onclick="bos.rptpsbi_realisasi.selectFilterGolonganPSBI('A')" value="A" checked>
                                                    All
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>
                                                    <input type="radio" name="optFilterUnit" id="optFilterUnit2" onclick="bos.rptpsbi_realisasi.selectFilterGolonganPSBI('P')" value="P">
                                                    Per Golongan PSBI
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="col-md-12" id="divSelectGolonganPSBI">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Golongan PSBI</label>
                                        <select class="form-control optGolonganPSBI select2" data-sf="load_Kota" name="optGolonganPSBI" id="optGolonganPSBI" data-placeholder=" - Golongan PSBI - "></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="col-sm-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Export Report</label>
                                        <select name="export" id="export" class="form-control select" style="width:100%" 
                                            data-sf="load_export" data-placeholder="PDF" required></select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-6">
                        <input type="hidden" name="cMetodeGolPSBI" id="cMetodeGolPSBI">
                        <input type="hidden" name="cExportRpt" id="cExportRpt" value="F">
                        <button class="btn btn-info pull-right" id="cmdRefresh">Preview Data</button>
                    </div>
                </div>
            <!-- </form> -->
        </div>
        <div class="tab-pane full-height" id="tab_1">
            <div id="grid1" style="height:700px"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.rptpsbi_realisasi.grid1_data    = null ;
    bos.rptpsbi_realisasi.grid1_loaddata= function(){
        this.grid1_data      = {
            "dTglAwal"        : $("#dTglAwal").val(),
            "dTglAkhir"       : $("#dTglAkhir").val(),
            "cMetodeGolPSBI"  : $("#cMetodeGolPSBI").val(),
            "optGolonganPSBI" : $("#optGolonganPSBI").val(),
            "cExportRpt"      : $("#export").val()
        } ;
    }

    bos.rptpsbi_realisasi.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.rptpsbi_realisasi.base_url + "/loadgrid",
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
            columnGroups: [
                { caption: '', master: true },
                { caption: '', master: true },
                { caption: 'LAPORAN DEWAN KOMISARIS', span: 9 },
                { caption: 'DETAIL PROPOSAL', span: 4 },
                { caption: 'PERSETUJUAN M.02', span: 7 },
                { caption: '', master: true },
                { caption: '', master: true },
                { caption: '', master: true },
                { caption: '', master: true }

            ],
            toolbar: {
                items: [
                    { id: 'xpt', type: 'button', caption: '<b>Download Exported Report</b>',   img: 'icon-page'}
                ],
                onClick: function (event) {
                    if (event.target == 'xpt') {
                        bos.rptpsbi_realisasi.rptExport() ;
                    }
                }
            },
            columns: [
                { field: 'NoRekap' , caption: 'No. Rekap', size: '150px', sortable: false},
                { field: 'Kode' , caption: 'Kode Faktur', size: '150px', sortable: false},
                
                // Laporan DKOM START
                { field: 'WaktuKegiatan' , caption: 'Tanggal Kegiatan', size: '150px', sortable: false},
                { field: 'NamaKegiatan' , caption: 'Nama Kegiatan', size: '150px', sortable: false},
                { field: 'PenerimaManfaat' , caption: 'Penerima Manfaat *)', size: '150px', sortable: false },
                { field: 'TujuanManfaat' , caption: 'Tujuan & Manfaat *)', size: '150px', sortable: false },
                { field: 'RuangLingkup' , caption: 'Ruang Lingkup *)', size: '150px', sortable: false },
                { field: 'NilaiPengajuan', render: 'int' , caption: 'Pengajuan Bantuan (Total)', size: '150px', sortable: false },
                { field: 'LokasiKegiatan' , caption: 'Lokasi', size: '150px', sortable: false },
                { field: 'DetailLokasi' , caption: 'Detail Lokasi', size: '150px', sortable: false },
                { field: 'PesertaPartisipan' , caption: 'Keikutsertaan/ Partisipasi Lembaga Lain', size: '150px', sortable: false },
                { field: 'Permasalahan' , caption: 'Permasalahan / Kendala yang Dihadapi', size: '150px', sortable: false },
                // LAPORAN DKOM END

                // DETAIL PROPOSAL
                { field: 'TanggalProposal' , caption: 'Tanggal Proposal', size: '150px', sortable: false },
                { field: 'NomorSuratProposal' , caption: 'Nomor Surat', size: '150px', sortable: false },
                { field: 'JenisBantuan' , caption: 'Jenis Bantuan yang Diajukan', size: '150px', sortable: false },
                { field: 'DetailBantuan' , caption: 'Detail Jenis Bantuan', size: '150px', sortable: false },
                // DETAIL PROPOSAL

                // DETAIL M02
                { field: 'KodeM02Persetujuan' , caption: 'Nomor Surat M.02', size: '150px', sortable: false },
                { field: 'TanggalPersetujuan' , caption: 'Tanggal Persetujuan', size: '150px', sortable: false },
                { field: 'TanggalRealisasi' , caption: 'Tanggal Realisasi', size: '150px', sortable: false },
                { field: 'Vendor' , caption: 'Vendor (Apabila Pembelian Barang)', size: '150px', sortable: false },
                { field: 'UserName' , caption: 'PIC', size: '150px', sortable: false },
                { field: 'GolonganPSBI' , caption: 'Golongan PSBI', size: '150px', sortable: false },
                { field: 'NilaiRealisasi', render: 'int' , caption: 'Nilai Realisasi', size: '150px', sortable: false },
                // DETAIL M02

                { field: 'SaldoReguler' , render: 'int' , caption: 'Saldo Reguler',size: '150px', sortable: false },
                { field: 'SaldoTematik' , render: 'int' , caption: 'Saldo Tematik', size: '150px', sortable: false },
                { field: 'SaldoBeasiswa', render: 'int' , caption: 'Saldo Beasiswa', size: '150px', sortable: false },

            ]
        });
    }

    bos.rptpsbi_realisasi.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.rptpsbi_realisasi.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.rptpsbi_realisasi.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.rptpsbi_realisasi.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.rptpsbi_realisasi.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.rptpsbi_realisasi.initTab1 = function(){
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.rptpsbi_realisasi.initComp     = function(){
        $('#cMetodeGolPSBI').val("A");
        bjs.initselect({
			class : "#" + this.id + " .select"
		}) ;
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        $('.numberthousand').divide({delimiter: ',',divideThousand: true});
        $("#divSelectGolonganPSBI").css("display","none") ;
    }

    bos.rptpsbi_realisasi.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptpsbi_realisasi.grid1_destroy() ;
        }) ;
    }

    bos.rptpsbi_realisasi.selectFilterGolonganPSBI = function(par){
        $("#cMetodeGolPSBI").val(par);
        if(par === 'P'){
            $("#divSelectGolonganPSBI").css("display","block") ;
        }else{
            $("#divSelectGolonganPSBI").css("display","none") ;
        }
    }

    bos.rptpsbi_realisasi.selectExportRpt = function(par){
        $("#cExportRpt").val(par);
    }

    bos.rptpsbi_realisasi.cmdsave       = bos.rptpsbi_realisasi.obj.find("#cmdsave") ;
    bos.rptpsbi_realisasi.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 1){//load grid
                bos.rptpsbi_realisasi.grid1_reloaddata() ;
            }
        });

        this.obj.find(".nav li.disabled a").click(function() {
            return false;
        });
    }

    bos.rptpsbi_realisasi.obj.find("#cmdRefresh").on("click", function(){ 
        bos.rptpsbi_realisasi.showDataGridTab() ;
	}) ; 

    bos.rptpsbi_realisasi.showDataGridTab = function(){
        this.obj.find(".nav-tabs li:eq(1)").removeClass("disabled");   
        this.obj.find(".nav-tabs li:eq(1) a").tab("show") ; 
        bos.rptpsbi_realisasi.grid1_reloaddata() ;
    }

    bos.rptpsbi_realisasi.rptExport = function(){
        bjs.form_report( this.base_url + '/initReport') ;
    }

    $('#optGolonganPSBI').select2({
        allowClear: true,
        ajax: {
            url: bos.rptpsbi_realisasi.base_url + '/SeekGolonganPSBI',
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
            url: bos.rptpsbi_realisasi.base_url + '/SeekLokasiPSBI',
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
        bos.rptpsbi_realisasi.initComp() ;
        bos.rptpsbi_realisasi.initCallBack() ;
        bos.rptpsbi_realisasi.initFunc() ;
    })

</script>