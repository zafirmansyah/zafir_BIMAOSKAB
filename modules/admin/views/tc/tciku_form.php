<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false" onclick="bos.tciku_form.init();">Daftar Data</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Data Form</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:500px"></div>
        </div>
        <div class="tab-pane" id="tab_2">
            <div id="previewKONKIN" class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                        <h3 class="box-title">Kode KONKIN : <span id="textKode_IKU"></span></h3>
                        </div>
                        <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <h3 id="textSubject_IKU"></h3>
                            <h5>From: <span id="textDari_IKU"></span>
                            <span class="mailbox-read-time pull-right" id="textDateTime_IKU"></span></h5>
                        </div>
                        <div class="mailbox-read-message" id="textDeskripsi_IKU">
                            <!-- Detail WO -->
                        </div>
                        </div>
                        <div class="box-footer">
                            <ul class="mailbox-attachments clearfix" id="areaFileIKU">
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="formKONKIN">
                <form>
                    <div class="row" style="padding:5px;">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tanggal Penulisan KONKIN</label>
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
                                <input type="text" name="cSubject" id="cSubject" class="form-control" maxlength="225" placeholder="Judul IKU" required>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="cDeskripsi" id="cDeskripsi" cols="20" rows="10" style="height: 50px;" placeholder="Deskripsi Master IKU..."></textarea>                   
                            </div>
                        </div>
                        <!-- <div class="col-sm-10">
                            <div class="form-group">
                                <label>Tujuan Unit</label>
                                <select class="form-control optGolonganUnit select2" data-sf="load_Kota" name="optGolonganUnit" id="optGolonganUnit" data-placeholder=" - Tujuan Unit - " required></select>
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-10">
                            <div class="form-group">
                                <label>Periode</label>
                                <input type="text" name="cPeriode" id="cPeriode" class="form-control" maxlength="225" placeholder="Periode IKU" required>
                            </div>
                        </div> -->
                        <div class="col-md-12" id="listFile" style="display:none;">
                            <label for="">Daftar File</label>
                            <ul class="mailbox-attachments clearfix" id="areaFileMasterIKU">
                                    
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload File</label>
                                <div id="idcUplFileIKU">
                                    <input style="width:100%" type="file" class="form-control cUplFileIKU" id="cUplFileIKU" name="cUplFileIKU[]" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="nNo" id="nNo" value="0">
                    <input type="hidden" name="cKodeKaryawan" id="cKodeKaryawan">
                    <input type="hidden" name="cKode" id="cKode">
                    <input type="hidden" name="cLastPath" id="cLastPath">
                    <button class="btn btn-primary" id="cmdSave">Simpan</button>
                    <button class="btn btn-warning" id="cmdCancel" onClick="bos.tciku_form.init()">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.tciku_form.loadDataFormIKU = function(data){
        // console.log("data:",data);
        $("#textKode_IKU").html(data.Kode);
        $("#textDateTime_IKU").html(data.DateTime);
        $("#textDari_IKU").html(data.UserName);
        $("#textSubject_IKU").html(data.Subject);
        $("#textDeskripsi_IKU").html(data.Deskripsi);
        bos.tciku_form.loadFileFormIKU(data.File);
        $("#formKONKIN").hide();
        $("#previewKONKIN").show();
    }

    bos.tciku_form.loadFileFormIKU = function(file){ 
        $("#areaFileIKU").html("");
        for(var i=0; i<file.length;i++){
            var cFileName    = file[i].FileName;
            var cFileNameCut = cFileName.substring(0,20);
            
            var $liFileWO         = $('<li class="itemFileWO"></li>');
            var $spanIconWO       = $('<span class="mailbox-attachment-icon"><i class="fa fa-file-text"></i></span>');
            var $divFileInfo      = $('<div class="mailbox-attachment-info"></div>');
            var $aLinkFile        = $('<a href="'+file[i].FilePath+'" class="mailbox-attachment-name" title="'+cFileName+'" target="_blank"><i class="fa fa-paperclip"></i>&nbsp;'+cFileNameCut+'</a>');
            var $spanDownloadFile = $('<span class="mailbox-attachment-size">'+file[i].FileSize+'</span>');
            var $aLinkDownload    = $('<a href="'+file[i].FilePath+'" class="btn btn-default btn-xs pull-right" title="Download" download><i class="fa fa-cloud-download"></i></a>');
            
            $spanDownloadFile.append($aLinkDownload);
            $divFileInfo.append($aLinkFile);
            $divFileInfo.append($spanDownloadFile);
            $liFileWO.append($spanIconWO);
            $liFileWO.append($divFileInfo);

            $("#areaFileIKU").append($liFileWO);
        } 
    }

    bos.tciku_form.loadFileMasterIKU = function(file){
        //console.log("file:",file);        
        $("#areaFileMasterIKU").html("");
        for(var i=0; i<file.length;i++){
            var id           = file[i].ID;
            var cFileName    = file[i].FileName;
            var cFileNameCut = cFileName.substring(0,20);
            var cFilePath    = file[i].FilePath;
            var cFileSize    = file[i].FileSize;

            var $liFileWO         = $('<li class="itemFileWO"></li>');
            var $spanIconWO       = $('<span class="mailbox-attachment-icon"><i class="fa fa-file-text"></i></span>');
            var $aDeleteFile      = $('<a href="#" onclick="bos.tciku_form.deleteFile('+id+')" style="float: right;margin: 5px;color: red;font-size:20px;" title="Hapus File?"><i class="fa fa-trash"></i></a>');
            var $divFileInfo      = $('<div class="mailbox-attachment-info"></div>');
            var $aLinkFile        = $('<a href="'+cFilePath+'" class="mailbox-attachment-name" title="'+cFileName+'" target="_blank"><i class="fa fa-paperclip"></i>&nbsp;'+cFileNameCut+'</a>');
            var $spanDownloadFile = $('<span class="mailbox-attachment-size">'+cFileSize+'</span>');
            var $aLinkDownload    = $('<a href="'+cFilePath+'" class="btn btn-default btn-xs pull-right" title="Download" download><i class="fa fa-cloud-download"></i></a>');
            
            $spanDownloadFile.append($aLinkDownload);
            $divFileInfo.append($aLinkFile);
            $divFileInfo.append($spanDownloadFile);
            $liFileWO.append($aDeleteFile);
            $liFileWO.append($spanIconWO);
            $liFileWO.append($divFileInfo);

            $("#areaFileMasterIKU").append($liFileWO);
        } 
        if(file.length > 0) $("#listFile").css("display","block");
    }

    bos.tciku_form.deleteFile = function(id){
        bos.tciku_form.showSwalConfirm("Apakah Anda Yakin?","Anda akan menghapus file ini","warning","/deleteFile","cID="+id);
    }

    bos.tciku_form.showSwalConfirm = function(title,msg,icon,func='',params=''){
        Swal.fire({
            title: title,
            text: msg,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya yakin!',
            cancelButtonText: 'Batal!'
        }).then((result) => {
            if (result.value) {
                if(func !== "" && params !== ""){
                    bjs.ajax(this.url + func, params);
                }else{
                    bos.tciku_form.showSwalInfo("Data Saved!","","success");
                }
            }
        });
    }

    bos.tciku_form.showSwalInfo = function(title,msg='',icon){
        Swal.fire({
            title: title,
            text: msg,
            icon: icon,
        });
    }
    
    bos.tciku_form.grid1_data    = null ;
    bos.tciku_form.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }
''
    bos.tciku_form.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tciku_form.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Daftar Master IKU',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'Kode', caption: 'Kode', size: '100px', sortable: false},
                // { field: 'Periode', caption: 'Periode', size: '60px', sortable: false},
                // { field: 'TujuanUnit', caption: 'TujuanUnit', size: '250px', sortable: false},
                { field: 'Subject', caption: 'Judul', size: '150px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'UserName', caption: 'Petugas Entry', size: '100px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '95px', sortable: false },
                // { field: 'cmdPreview', caption: ' ', size: '95px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '95px', sortable: false }
            ]
        });
    }

    bos.tciku_form.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }

    bos.tciku_form.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tciku_form.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tciku_form.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tciku_form.grid1_reloaddata   = function(){
        this.grid1_setdata() ;
    }

    /******************************************** */


    /********************************************** */

    bos.tciku_form.cmdEdit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.tciku_form.cmdPreview      = function(id){
        bjs.ajax(this.url + '/preview', 'cKode=' + id);
    }

    bos.tciku_form.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }


    bos.tciku_form.init         = function(){
        this.obj.find("#cSubject").val("") ;
        this.obj.find("#cDeskripsi").val("") ;
        tinymce.activeEditor.setContent("");
        this.obj.find("#cPeriode").val("") ;
        this.obj.find("#cKode").val("") ;
        this.obj.find("#optGolonganUnit").val("") ;
        this.obj.find("#cUplFileIKU").val("") ;
        this.obj.find("#nNo").val("0") ;
        bjs.ajax(this.url + '/init') ;
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bos.tciku_form.grid1_loaddata() ;
        bos.tciku_form.grid1_reload() ;
        $("#areaFileMasterIKU").html("");
        $("#listFile").css("display","none");
    }


    bos.tciku_form.initTinyMCE = function(){
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

    bos.tciku_form.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;

        $('#previewKONKIN').hide() ;

        this.initTinyMCE() ;
        this.grid1_loaddata() ;
        this.grid1_load() ;

        bjs.ajax(this.url + '/init') ;
    }


    bos.tciku_form.tabsaction    = function(n){
        bos.tciku_form.grid1_render() ;
        bos.tciku_form.init() ;
    }

    bos.tciku_form.initCallBack = function(){
        this.obj.on("bos:tab", function(e){
            bos.tciku_form.tabsaction( e.i )  ;
        });
        this.obj.on('remove', function(){
            bos.tciku_form.grid1_destroy() ;
            tinymce.remove() ;
        }) ;
    }


    bos.tciku_form.cmdSave       = bos.tciku_form.obj.find("#cmdSave") ;
    bos.tciku_form.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tciku_form.grid1_reloaddata() ;
            }
        });

        this.obj.find("#cUplFileIKU").on("change", function(e){
            e.preventDefault() ;
            bos.tciku_form.uname       = $(this).attr("id") ;
            bos.tciku_form.fal         = $("#cUplFileIKU")[0].files;//e.target.files;
            bos.tciku_form.gfal        = new FormData() ;
            for(var i = 0; i < bos.tciku_form.fal.length; i++){
                bos.tciku_form.gfal.append("cUplFileIKU[]",bos.tciku_form.fal[i]);
            }
            bos.tciku_form.obj.find("#idl" + bos.tciku_form.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.tciku_form.base_url + "/savingFile" , bos.tciku_form.gfal, this) ;
            
        }) ;
        

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tciku_form.base_url + '/saving', bjs.getdataform(this) , bos.tciku_form.cmdSave) ;
            }
        }) ;
    }

    $('.optGolonganUnit').select2({
        allowClear: true,
        ajax: {
            url: bos.tciku_form.base_url + '/seekGolonganUnit',
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
        bos.tciku_form.initComp() ;
        bos.tciku_form.initCallBack() ;
        bos.tciku_form.initFunc() ;
    })

</script>