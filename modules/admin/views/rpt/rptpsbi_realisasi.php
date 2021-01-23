<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Data</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:700px"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.rptpsbi_realisasi.grid1_data    = null ;
    bos.rptpsbi_realisasi.grid1_loaddata= function(){
        this.grid1_data      = {} ;
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
            columns: [
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
        $('.numberthousand').divide({delimiter: ',',divideThousand: true});
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
    }

    bos.rptpsbi_realisasi.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptpsbi_realisasi.grid1_destroy() ;
        }) ;
    }

    bos.rptpsbi_realisasi.cmdsave       = bos.rptpsbi_realisasi.obj.find("#cmdsave") ;
    bos.rptpsbi_realisasi.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.rptpsbi_realisasi.grid1_reloaddata() ;
            }
        });

        this.obj.find(".nav li.disabled a").click(function() {
            return false;
        });
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