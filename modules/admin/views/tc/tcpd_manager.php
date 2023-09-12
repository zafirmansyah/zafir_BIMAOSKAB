<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Data Terlapor</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Data Detail</a></li>
        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Data Form Tanggapan</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:500px"></div>
        </div>
        <div class="tab-pane full-height" id="tab_2">
            <!-- <div class="col-md-12"> -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Periode</b></h3>
                    </div>
                    <div class="box-body no-padding">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Tahun</label>
                                <select class="form-control optTahun select" name="optTahun" id="optTahun" data-placeholder=" - Tahun - "></select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Periode Triwulan</label>
                                <select class="form-control optPeriodeTriwulan select" name="optPeriodeTriwulan" id="optPeriodeTriwulan" data-placeholder=" - Periode - "></select>
                            </div>
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title"><b><span id="cJudul"></span></b></h3>
                    </div>
                    <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <table>
                                <tr>
                                    <td width="100px" >Dari</td>
                                    <td width="10px" >:</td>
                                    <td><span class="mailbox-read-time" id="cPegawaiPelapor"></span></td>
                                </tr>
                                <tr>
                                    <td width="100px" >Input Date Time</td>
                                    <td width="10px"> : </td>
                                    <td> <span class="mailbox-read-time" id="dDateTime"></span></td>
                                </tr>
                                <tr>
                                    <td width="100px" >Tahun Periode</td>
                                    <td width="10px"> : </td>
                                    <td> <span class="mailbox-read-time" id="cPeriode"></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="mailbox-read-message">
                            <!-- Detail Surat -->
                            <p><b>KOMENTAR TERHADAP PELAKSANAAN TUGAS :</b></p>
                            <span id="spanKomentar"></span>
                            <br><br>
                            <p><b>TANGGAPAN ATASAN :</b></p>
                            <span id="spanTanggapanKomentar"></span>
                        </div>
                        <hr>
                        <div class="mailbox-read-message">
                            <!-- Detail Surat -->
                            <p><b>AREA PENINGKATAN KINERJA : </b></p>
                            <span id="spanAreaPeningkatanKinerja"></span>
                            <br><br>
                            <p><b>TANGGAPAN ATASAN :</b></p>
                            <span id="spanTanggapanAreaPeningkatanKinerja"></span>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="button" id="cmdEditNoComment" class="btn btn-success">Perbaikan Tanpa Komentar</button> <!--  - tidak menghilangkan komentar bos.e jika si bos udah sempet komen -->
                            <!-- <button type="button" class="btn btn-default" onclick="bos.rptsuratmasuk_read.cmdForward('')"><i class="fa fa-share"></i> Berikan Tanggapan</button> -->
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        </div>
        <div class="tab-pane" id="tab_3">
            <form>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tanggal Input</label>
                            <div class="col-xs-8 input-group">
                                <input
                                    type="text" 
                                    class=" form-control" 
                                    id="dTgl" 
                                    name="dTgl" 
                                    placeholder="dd-mm-yyyy"
                                    readonly
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
                            <input type="text" name="cSubject" id="cSubject" class="form-control" maxlength="225" placeholder="Judul Pelaporan Pegawai" readonly>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-control optTahun2 select" data-sf="load_PeriodeTriwulan" name="optTahun2" id="optTahun2" data-placeholder=" - Periode - " readonly></select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Periode Triwulan</label>
                            <select class="form-control optPeriodeTriwulan2 select" data-sf="load_PeriodeTriwulan" name="optPeriodeTriwulan2" id="optPeriodeTriwulan2" data-placeholder=" - Periode - " readonly></select>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Umpan Balik Thd Evaluasi Kinerja</label>

                            <textarea name="cKomentarPelaksanaanTugas" id="cKomentarPelaksanaanTugas" cols="20" rows="5" placeholder="Umpan Balik Thd Evaluasi Kinerja..."></textarea>                   
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Rencana pengembangan pegawai</label>
                            <textarea name="cAreaPeningkatanKinerja" id="cAreaPeningkatanKinerja" cols="20" rows="5" placeholder="Rencana pengembangan pegawai..."></textarea>                   
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
                <input type="hidden" name="cUsernameKaryawan" id="cUsernameKaryawan" >
                <input type="text" name="cKode" id="cKode">
                <input type="hidden" name="cStatus" id="cStatus">
                <input type="hidden" name="cLastPath" id="cLastPath">
                <button class="btn btn-primary" id="cmdSave">Simpan</button>
                <!-- <button class="btn btn-success" id="cmdSave">Perbaiki</button> -->
                <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcpd_manager.init()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcpd_manager.grid1_data    = null ;
    bos.tcpd_manager.grid1_loaddata= function(){
        const cUsername = $("#cUsername").val() ;
        this.grid1_data = {"username" : cUsername} ;
    }

    bos.tcpd_manager.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcpd_manager.base_url + "/loadgrid",
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
                { field: 'fullname_pelapor', caption: 'Nama Pegawai', size: '250px', sortable: false},
                { field: 'status', caption: 'status', size: '150px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '100px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '100px', sortable: false }
            ]
        });
    }

    bos.tcpd_manager.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }

    bos.tcpd_manager.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcpd_manager.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcpd_manager.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcpd_manager.grid1_reloaddata   = function(){
        this.grid1_setdata() ;
    }

    /******************************************** */


    /********************************************** */

    bos.tcpd_manager.cmdEdit      = function(id){
        bjs.ajax(this.url + '/editing', 'cUsernamePelaporan=' + id);
    }

    bos.tcpd_manager.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }


    bos.tcpd_manager.init         = function(){
        this.obj.find("#cSubject").val("") ;
        this.obj.find("#cKomentarPelaksanaanTugas").val("") ;
        this.obj.find("#cAreaPeningkatanKinerja").val("") ;
        tinymce.activeEditor.setContent("");
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cStatus").val("");
        this.obj.find("#optUserName").val("") ;
        this.obj.find("#cUplFileWO").val("") ;
        this.obj.find("#nNo").val("0") ;
        bjs.ajax(this.url + '/init') ;
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bos.tcpd_manager.grid1_loaddata() ;
        bos.tcpd_manager.grid1_reload() ;
    }


    bos.tcpd_manager.initTinyMCE = function(){
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

    bos.tcpd_manager.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;

        this.initTinyMCE() ;
        this.grid1_loaddata() ;
        this.grid1_load() ;

        bjs.ajax(this.url + '/init') ;
    }


    bos.tcpd_manager.tabsaction    = function(n){
        bos.tcpd_manager.grid1_render() ;
        bos.tcpd_manager.init() ;
    }

    bos.tcpd_manager.initCallBack = function(){
        this.obj.on("bos:tab", function(e){
            bos.tcpd_manager.tabsaction( e.i )  ;
        });

        this.obj.find("#optPeriodeTriwulan").on("select2:select", function(e){ 
            const optTahunVal       = $("#optTahun").val() ;
            const cUsernameKaryawan = $("#cUsernameKaryawan").val() ;
            bjs.ajax(bos.tcpd_manager.url+"/refreshTriwulan", "periode=" + $(this).val() + "&tahun="+optTahunVal + "&uname_karyawan="+cUsernameKaryawan) ; 
        }) ; 
        
        this.obj.on('remove', function(){
            bos.tcpd_manager.grid1_destroy() ;
            tinymce.remove() ;
        }) ;

    }


    bos.tcpd_manager.cmdSave       = bos.tcpd_manager.obj.find("#cmdSave") ;
    bos.tcpd_manager.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcpd_manager.grid1_reloaddata() ;
            }
        });

        this.obj.find("#cUplFileWO").on("change", function(e){
            e.preventDefault() ;
            bos.tcpd_manager.uname       = $(this).attr("id") ;
            bos.tcpd_manager.fal         = $("#cUplFileWO")[0].files;//e.target.files;
            bos.tcpd_manager.gfal        = new FormData() ;
            for(var i = 0; i < bos.tcpd_manager.fal.length; i++){
                bos.tcpd_manager.gfal.append("cUplFileWO[]",bos.tcpd_manager.fal[i]);
            }
            bos.tcpd_manager.obj.find("#idl" + bos.tcpd_manager.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.tcpd_manager.base_url + "/savingFile" , bos.tcpd_manager.gfal, this) ;
            
        }) ;

        this.obj.find("#cmdEditNoComment").on('click' , function(e){
            e.preventDefault() ;
            const cKode = $("#cKode").val() ;
            bjs.ajax( bos.tcpd_manager.base_url + '/editNoComent', "cKode="+cKode) ;
        }) ;
        

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tcpd_manager.base_url + '/saving', bjs.getdataform(this) , bos.tcpd_manager.cmdSave) ;
            }
        }) ;
    }

    $('.optUserName').select2({
        allowClear: true,
        ajax: {
            url: bos.tcpd_manager.base_url + '/seekUserName',
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

    $('#optPeriodeTriwulan2').select2({
        disabled: true
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

    $('#optTahun2').select2({
        disabled: true
    });
    

    $(function(){
        bos.tcpd_manager.initComp() ;
        bos.tcpd_manager.initCallBack() ;
        bos.tcpd_manager.initFunc() ;
    })

</script>