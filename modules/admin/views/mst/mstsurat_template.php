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
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="cKeterangan" id="cKeterangan" class="form-control" maxlength="225" placeholder="eg : Keterangan Dokumen" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Upload File</label>
                        <div id="idcUplFileTEMPLATE">
                            <input style="width:100%" type="file" class="form-control cUplFileTEMPLATE" id="cUplFileTEMPLATE" name="cUplFileTEMPLATE[]" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <input type="text" name="cKode" id="cKode">
            <button class="btn btn-primary" id="cmdsave">Simpan</button>
            <button class="btn btn-warning" id="cmdCancel" onClick="bos.mstsurat_template.init()">Cancel</button>
        </form>
        </div>
    </div>
</div>
<iframe id="my_iframe" style="display:none;"></iframe>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.mstsurat_template.grid1_data    = null ;
    bos.mstsurat_template.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.mstsurat_template.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.mstsurat_template.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Daftar Jenis-Jenis Surat',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'Subject', caption: 'Judul Dokumen', size: '350px', sortable: false},
                { field: 'cmdDownload', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.mstsurat_template.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.mstsurat_template.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.mstsurat_template.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.mstsurat_template.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.mstsurat_template.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.mstsurat_template.cmdedit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.mstsurat_template.cmddelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }

    bos.mstsurat_template.cmdDownload  = function(url) {
        // alert(url);
        window.location = url ;
        // document.getElementById('my_iframe').src = url;
    };

    bos.mstsurat_template.init         = function(){ 
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cKeterangan").val("") ;
        this.obj.find("#cUplFileTEMPLATE").val("") ;
        bjs.ajax(this.url + '/init') ;

        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.mstsurat_template.initcomp     = function(){
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        bjs.ajax(this.url + '/init') ;
    }

    bos.mstsurat_template.initcallback = function(){
        this.obj.on('remove', function(){
            bos.mstsurat_template.grid1_destroy() ;
        }) ;
    }

    bos.mstsurat_template.cmdsave       = bos.mstsurat_template.obj.find("#cmdsave") ;
    bos.mstsurat_template.initfunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.mstsurat_template.grid1_reloaddata() ;
            }else{//focus
                bos.mstsurat_template.obj.find("#cKode").focus() ;
            }
        });

        this.obj.find("#cUplFileTEMPLATE").on("change", function(e){
            e.preventDefault() ;
            bos.mstsurat_template.uname       = $(this).attr("id") ;
            bos.mstsurat_template.fal         = $("#cUplFileTEMPLATE")[0].files;//e.target.files;
            bos.mstsurat_template.gfal        = new FormData() ;
            for(var i = 0; i < bos.mstsurat_template.fal.length; i++){
                bos.mstsurat_template.gfal.append("cUplFileTEMPLATE[]",bos.mstsurat_template.fal[i]);
            }
            bos.mstsurat_template.obj.find("#idl" + bos.mstsurat_template.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.mstsurat_template.base_url + "/savingFile" , bos.mstsurat_template.gfal, this) ;
            
        }) ;

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.mstsurat_template.base_url + '/saving', bjs.getdataform(this) , bos.mstsurat_template.cmdsave) ;
            }
        }) ;
    }

    $(function(){
        bos.mstsurat_template.initcomp() ;
        bos.mstsurat_template.initcallback() ;
        bos.mstsurat_template.initfunc() ;
    })

</script>