<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="disabled"><a href="#tab_0" data-toggle="tab" aria-expanded="true">Filter</a></li>
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Data</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tab_0">
            <form>
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
                                                    <input type="radio" name="optFilterUnit" id="optFilterUnit1" onclick="bos.rptpsbi_komunikasi.selectFilterGolonganPSBI('A')" value="A" checked>
                                                    All
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>
                                                    <input type="radio" name="optFilterUnit" id="optFilterUnit2" onclick="bos.rptpsbi_komunikasi.selectFilterGolonganPSBI('P')" value="P">
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
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-6">
                        <input type="text" name="cMetodeGolPSBI" id="cMetodeGolPSBI">
                        <button class="btn btn-info pull-right" id="cmdRefresh">Preview Data</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:700px"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.rptpsbi_komunikasi.grid1_data    = null ;
    bos.rptpsbi_komunikasi.grid1_loaddata= function(){
        this.grid1_data      = {
            "dTglAwal"        : $("#dTglAwal").val(),
            "dTglAkhir"       : $("#dTglAkhir").val(),
            "cMetodeGolPSBI"  : $("#cMetodeGolPSBI").val(),
            "optGolonganPSBI" : $("#optGolonganPSBI").val()
        } ;
    }

    bos.rptpsbi_komunikasi.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.rptpsbi_komunikasi.base_url + "/loadgrid",
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
                { span: 1, caption: '', master: true },
                { span: 1, caption: '', master: true },
                { span: 1, caption: '', master: true },
                { span: 1, caption: '', master: true },
                { span: 1, caption: '', master: true },
                { span: 1, caption: '', master: true },
                { span: 4, caption: 'Progress Pelaksanaan'},
                { span: 1, caption: '', master: true },
                { span: 1, caption: '', master: true },
                { span: 1, caption: '', master: true }
            ],
            columns: [

                { field: 'Kode' , caption: 'Kode Faktur', size: '150px', sortable: false,frozen: true},
                { field: 'Tgl', caption: 'Tgl Entry', size: '150px', sortable: false },
                { field: 'NamaProgram', caption: 'Program / Kegiatan Berdasarkan Jenis Kegiatan Komunikasi', size: '150px', sortable: false ,frozen: true},
                { field: 'UnitKerja', caption: 'Unit Kerja penyelenggara', size: '150px', sortable: false },
                { field: 'LatarBelakangKegiatan', caption: 'Latar Belakang Kegiatan', size: '150px', sortable: false },
                { field: 'Tujuan', caption: 'Tujuan', size: '150px', sortable: false },
                { field: 'WaktuPelaksanaan', caption: 'Waktu Pelaksanaan', size: '150px', sortable: false },
                { field: 'Narasumber', caption: 'Narasumber', size: '150px', sortable: false },
                { field: 'Saluran', caption: 'Saluran', size: '150px', sortable: false },
                { field: 'Peserta', caption: 'Audience/Peserta/Sasaran', size: '150px', sortable: false },
                { field: 'PersepsiStakeHolder', caption: 'Persepsi Stakeholder terkait Komunikasi Kebijakan BI', size: '150px', sortable: false },
                { field: 'PenggunaanAnggaran', caption: 'Penggunaan Anggaran (Rp) ', render: 'int',  size: '150px', sortable: false },
                { field: 'DampakOutput', caption: 'Dampak/Output ', size: '150px', sortable: false }
                
            ]
        });
    }

    bos.rptpsbi_komunikasi.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.rptpsbi_komunikasi.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.rptpsbi_komunikasi.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.rptpsbi_komunikasi.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.rptpsbi_komunikasi.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.rptpsbi_komunikasi.initTab1 = function(){
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.rptpsbi_komunikasi.initComp     = function(){
        $('#cMetodeGolPSBI').val("A");
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        $('.numberthousand').divide({delimiter: ',',divideThousand: true});
        $("#divSelectGolonganPSBI").css("display","none") ;
    }

    bos.rptpsbi_komunikasi.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptpsbi_komunikasi.grid1_destroy() ;
        }) ;
    }

    bos.rptpsbi_komunikasi.selectFilterGolonganPSBI = function(par){
        $("#cMetodeGolPSBI").val(par);
        if(par === 'P'){
            $("#divSelectGolonganPSBI").css("display","block") ;
        }else{
            $("#divSelectGolonganPSBI").css("display","none") ;
        }
    }

    bos.rptpsbi_komunikasi.cmdsave       = bos.rptpsbi_komunikasi.obj.find("#cmdsave") ;
    bos.rptpsbi_komunikasi.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.rptpsbi_komunikasi.grid1_reloaddata() ;
            }
        });

        this.obj.find(".nav li.disabled a").click(function() {
            return false;
        });

        this.obj.find("#cmdRefresh").on("click", function(){
            alert("mashok");
        }) ; 
    }

    bos.rptpsbi_komunikasi.showDataGridTab = function(){
        this.obj.find(".nav-tabs li:eq(1)").removeClass("disabled");   
        this.obj.find(".nav-tabs li:eq(1) a").tab("show") ; 
    }

    $('#optGolonganPSBI').select2({
        allowClear: true,
        ajax: {
            url: bos.rptpsbi_komunikasi.base_url + '/SeekGolonganPSBI',
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
            url: bos.rptpsbi_komunikasi.base_url + '/SeekLokasiPSBI',
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
        bos.rptpsbi_komunikasi.initComp() ;
        bos.rptpsbi_komunikasi.initCallBack() ;
        bos.rptpsbi_komunikasi.initFunc() ;
    })

</script>