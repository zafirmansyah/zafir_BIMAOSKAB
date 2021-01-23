<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Data</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Form</a></li>
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
                            <label>Faktur</label>
                            <input type="text" name="cFaktur" id="cFaktur" class="form-control" readonly>
                        </div>
                    </div>
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
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Golongan PSBI</label>
                            <select class="form-control optGolonganPSBI select2" data-sf="load_Kota" name="optGolonganPSBI" id="optGolonganPSBI" data-placeholder=" - Jenis Dokumen - "></select>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="cKeterangan" id="cKeterangan" class="form-control" maxlength="225" placeholder="eg : Plafond untuk realisasi PSBI Reguler / Tematik / Beasiswa" required>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Nominal Plafond</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>Rp.</b>
                                </div>
                                <input type="text" class="form-control numberthousand number" name="nPlafond" id="nPlafond" value=""> 
                            </div>
                            
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" id="cmdsave">Simpan</button>
                <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcpsbi_mutanggaran.init()">Cancel</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcpsbi_mutanggaran.grid1_data    = null ;
    bos.tcpsbi_mutanggaran.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcpsbi_mutanggaran.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcpsbi_mutanggaran.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Mutasi Penentuan Anggaran PSBI',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'Faktur', caption: 'Faktur', size: '150px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'Golongan', caption: 'Golongan PSBI', size: '100px', sortable: false},
                { field: 'Keterangan', caption: 'Keterangan', size: '250px', sortable: false},
                { field: 'Saldo', caption: 'Saldo', size: '150px', render: 'int', sortable: false},
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcpsbi_mutanggaran.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.tcpsbi_mutanggaran.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcpsbi_mutanggaran.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcpsbi_mutanggaran.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcpsbi_mutanggaran.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.tcpsbi_mutanggaran.cmdedit      = function(id){
        bjs.ajax(this.url + '/editing', 'cFaktur=' + id);
    }

    bos.tcpsbi_mutanggaran.cmddelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cFaktur=' + id);
        }
    }

    bos.tcpsbi_mutanggaran.initTab1 = function(){
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcpsbi_mutanggaran.init         = function(){
        this.obj.find("#cFaktur").val("").prop("readonly"); 
        this.obj.find("#cKeterangan").val("") ;
        this.obj.find("#optGolonganPSBI").val("") ;
        this.obj.find("#cRubrik").val("") ;
        bjs.ajax(this.url + '/init') ;

        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.tcpsbi_mutanggaran.initcomp     = function(){
        $('.numberthousand').divide({delimiter: ',',divideThousand: true});
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        bjs.ajax(this.url + '/init') ;
    }

    bos.tcpsbi_mutanggaran.initcallback = function(){
        this.obj.on('remove', function(){
            bos.tcpsbi_mutanggaran.grid1_destroy() ;
        }) ;
    }

    bos.tcpsbi_mutanggaran.cmdsave       = bos.tcpsbi_mutanggaran.obj.find("#cmdsave") ;
    bos.tcpsbi_mutanggaran.initfunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcpsbi_mutanggaran.grid1_reloaddata() ;
            }else{//focus
                bos.tcpsbi_mutanggaran.obj.find("#cFaktur").focus() ;
            }
        });

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tcpsbi_mutanggaran.base_url + '/saving', bjs.getdataform(this) , bos.tcpsbi_mutanggaran.cmdsave) ;
            }
        }) ;
    }

    $('#optGolonganPSBI').select2({
        allowClear: true,
        ajax: {
            url: bos.tcpsbi_mutanggaran.base_url + '/SeekGolonganPSBI',
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
        bos.tcpsbi_mutanggaran.initcomp() ;
        bos.tcpsbi_mutanggaran.initcallback() ;
        bos.tcpsbi_mutanggaran.initfunc() ;
    })

</script>