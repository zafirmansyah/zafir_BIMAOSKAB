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
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tanggal Input <?=$cSuperior?></label>
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
                            <label>Judul</label>
                            <input type="text" name="cSubject" id="cSubject" class="form-control" maxlength="225" placeholder="Judul Pelaporan Pegawai" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-control optTahun select" data-sf="load_Tahun" name="optTahun" id="optTahun" data-placeholder=" - Jenis Dokumen - "></select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Periode Triwulan</label>
                            <select class="form-control optPeriodeTriwulan select" data-sf="load_PeriodeTriwulan" name="optPeriodeTriwulan" id="optPeriodeTriwulan" data-placeholder=" - Jenis Dokumen - "></select>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Komentar Pelaksanaan Tugas</label>
                            <textarea name="cKomentarPelaksanaanTugas" id="cKomentarPelaksanaanTugas" class="textTinyMCE" cols="20" rows="5" placeholder="Komentar Pelaksanaan Tugas..."></textarea>                   
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Area Peningkatan Kinerja</label>
                            <textarea name="cAreaPeningkatanKinerja" id="cAreaPeningkatanKinerja" class="textTinyMCE" cols="20" rows="5" placeholder="Area Peningkatan Kinerja..."></textarea>                   
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label>Upload File</label>
                            <div id="idcUplFileWO">
                                <input style="width:100%" type="file" class="form-control cUplFileWO" id="cUplFileWO" name="cUplFileWO[]" multiple>
                            </div>
                        </div>
                    </div> -->
                </div>
                <input type="hidden" name="nNo" id="nNo" value="0">
                <input type="hidden" value=<?=$cUsername?> name="cUsername" id="cUsername">
                <input type="hidden" name="cKode" id="cKode">
                <input type="hidden" name="cStatus" id="cStatus" value=0>
                <input type="hidden" name="cLastPath" id="cLastPath">
                <button class="btn btn-primary" id="cmdSave">Simpan</button>
                <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcpd_pegawai.init()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcpd_pegawai.grid1_data    = null ;
    bos.tcpd_pegawai.grid1_loaddata = function(){
        const cUsername = $("#cUsername").val() ;
        this.grid1_data      = {"username" : cUsername} ;
    }

    bos.tcpd_pegawai.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcpd_pegawai.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Data Pelaporan Performance Dialog',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'tahun', caption: 'Tahun', size: '100px', sortable: false},
                { field: 'periode_triwulan', caption: 'Periode Triwulan', size: '250px', sortable: false},
                { field: 'judul', caption: 'judul', size: '150px', sortable: false},
                { field: 'tanggal', caption: 'Tanggal Input', size: '80px', sortable: false},
                { field: 'status', caption: 'status', size: '80px', sortable: false},
                { field: 'username', caption: 'username', size: '100px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcpd_pegawai.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }

    bos.tcpd_pegawai.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcpd_pegawai.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcpd_pegawai.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcpd_pegawai.grid1_reloaddata   = function(){
        this.grid1_setdata() ;
    }

    /******************************************** */


    /********************************************** */

    bos.tcpd_pegawai.cmdEdit      = function(cKode){
        bjs.ajax(this.url + '/editing', 'cKode=' + cKode);
    }

    bos.tcpd_pegawai.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }


    bos.tcpd_pegawai.init         = function(){
        this.obj.find("#cSubject").val("") ;
        tinymce.get("cKomentarPelaksanaanTugas").setContent("");
        tinymce.get("cAreaPeningkatanKinerja").setContent("");
        this.obj.find("#cKomentarPelaksanaanTugas").val("") ;
        this.obj.find("#cAreaPeningkatanKinerja").val("") ;
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cStatus").val('0');
        this.obj.find("#optUserName").val("") ;
        this.obj.find("#cUplFileWO").val("") ;
        this.obj.find("#nNo").val("0") ;
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bos.tcpd_pegawai.grid1_loaddata() ;
        bos.tcpd_pegawai.grid1_reload() ;
    }


    bos.tcpd_pegawai.initTinyMCE = function(){
        tinymce.init({
            selector: '#cKomentarPelaksanaanTugas',
            height: 300,
            file_browser_callback_types: 'file image media',
            file_picker_types: 'file image media',   
            forced_root_block : "",
            force_br_newlines : true,
            force_p_newlines : false,
        });

        tinymce.init({
            selector: '#cAreaPeningkatanKinerja',
            height: 300,
            file_browser_callback_types: 'file image media',
            file_picker_types: 'file image media',   
            forced_root_block : "",
            force_br_newlines : true,
            force_p_newlines : false,
        });
    }

    bos.tcpd_pegawai.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;

        this.initTinyMCE() ;
        this.grid1_loaddata() ;
        this.grid1_load() ;

        // bjs.ajax(this.url + '/init') ;
    }


    bos.tcpd_pegawai.tabsaction    = function(n){
        bos.tcpd_pegawai.grid1_render() ;
        bos.tcpd_pegawai.init() ;
    }

    bos.tcpd_pegawai.initCallBack = function(){
        this.obj.on("bos:tab", function(e){
            bos.tcpd_pegawai.tabsaction( e.i )  ;
        });

        // this.obj.find("#optPeriodeTriwulan").on("select2:select", function(e){ 
        //     // bjs.ajax(bos.tcpd_pegawai.url+"/refresh", "rekening=" + $(this).val()) ; 
        // }) ; 
        
        this.obj.on('remove', function(){
            bos.tcpd_pegawai.grid1_destroy() ;
            tinymce.remove() ;
        }) ;

    }


    bos.tcpd_pegawai.cmdSave = bos.tcpd_pegawai.obj.find("#cmdSave") ;
    bos.tcpd_pegawai.initFunc = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcpd_pegawai.grid1_reloaddata() ;
            }
        });

        this.obj.find("#cUplFileWO").on("change", function(e){
            e.preventDefault() ;
            bos.tcpd_pegawai.uname       = $(this).attr("id") ;
            bos.tcpd_pegawai.fal         = $("#cUplFileWO")[0].files;//e.target.files;
            bos.tcpd_pegawai.gfal        = new FormData() ;
            for(var i = 0; i < bos.tcpd_pegawai.fal.length; i++){
                bos.tcpd_pegawai.gfal.append("cUplFileWO[]",bos.tcpd_pegawai.fal[i]);
            }
            bos.tcpd_pegawai.obj.find("#idl" + bos.tcpd_pegawai.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.tcpd_pegawai.base_url + "/savingFile" , bos.tcpd_pegawai.gfal, this) ;
            
        }) ;
        
        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tcpd_pegawai.base_url + '/validSaving', bjs.getdataform(this) , bos.tcpd_pegawai.cmdSave) ;
            }
        }) ;
    }

    $('.optUserName').select2({
        allowClear: true,
        ajax: {
            url: bos.tcpd_pegawai.base_url + '/seekUserName',
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

    const vaDataPeriodeTriwulan = [
        {"id" : 0 , "text" : "Triwulan I"},
        {"id" : 1 , "text" : "Triwulan II"},
        {"id" : 2 , "text" : "Triwulan III"},
        {"id" : 3 , "text" : "Triwulan IV"},
    ]
    $('#optPeriodeTriwulan').select2({
        data: vaDataPeriodeTriwulan
    });

    const vaDataTahun = [
        {"id" : "2020" , "text" : "2020"},
        {"id" : "2021" , "text" : "2021"},
        {"id" : "2022" , "text" : "2022"},
        {"id" : "2023" , "text" : "2023", "selected": true},
        {"id" : "2024" , "text" : "2024"},
        {"id" : "2025" , "text" : "2025"}
    ]
    $('#optTahun').select2({
        data : vaDataTahun
    });
    

    $(function(){
        bos.tcpd_pegawai.initComp() ;
        bos.tcpd_pegawai.initCallBack() ;
        bos.tcpd_pegawai.initFunc() ;
    })

</script>