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
            <input type="hidden" name="cKode" id="cKode">
            <button class="btn btn-primary" id="cmdsave">Simpan</button>
            <button class="btn btn-warning" id="cmdCancel" onClick="bos.mstsurat_cetak.init()">Cancel</button>
        </form>
        </div>
    </div>
</div>
<iframe id="my_iframe" style="display:none;"></iframe>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.mstsurat_cetak.grid1_data    = null ;
    bos.mstsurat_cetak.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.mstsurat_cetak.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.mstsurat_cetak.base_url + "/loadgrid",
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

    bos.mstsurat_cetak.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.mstsurat_cetak.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.mstsurat_cetak.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.mstsurat_cetak.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.mstsurat_cetak.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.mstsurat_cetak.cmdedit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.mstsurat_cetak.cmddelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }

    bos.mstsurat_cetak.cmdDownload  = function(url) {
        // alert(url);
        window.location = url ;
        // document.getElementById('my_iframe').src = url;
    };

    bos.mstsurat_cetak.init         = function(){ 
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cKeterangan").val("") ;
        this.obj.find("#cUplFileTEMPLATE").val("") ;
        bjs.ajax(this.url + '/init') ;

        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.mstsurat_cetak.initcomp     = function(){
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        bjs.ajax(this.url + '/init') ;
    }

    bos.mstsurat_cetak.initcallback = function(){
        this.obj.on('remove', function(){
            bos.mstsurat_cetak.grid1_destroy() ;
        }) ;
    }

    bos.mstsurat_cetak.cmdsave       = bos.mstsurat_cetak.obj.find("#cmdsave") ;
    bos.mstsurat_cetak.initfunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.mstsurat_cetak.grid1_reloaddata() ;
            }else{//focus
                bos.mstsurat_cetak.obj.find("#cKode").focus() ;
            }
        });

        this.obj.find("#cUplFileTEMPLATE").on("change", function(e){
            e.preventDefault() ;
            bos.mstsurat_cetak.uname       = $(this).attr("id") ;
            bos.mstsurat_cetak.fal         = $("#cUplFileTEMPLATE")[0].files;//e.target.files;
            bos.mstsurat_cetak.gfal        = new FormData() ;
            for(var i = 0; i < bos.mstsurat_cetak.fal.length; i++){
                bos.mstsurat_cetak.gfal.append("cUplFileTEMPLATE[]",bos.mstsurat_cetak.fal[i]);
            }
            bos.mstsurat_cetak.obj.find("#idl" + bos.mstsurat_cetak.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.mstsurat_cetak.base_url + "/savingFile" , bos.mstsurat_cetak.gfal, this) ;
            
        }) ;

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.mstsurat_cetak.base_url + '/saving', bjs.getdataform(this) , bos.mstsurat_cetak.cmdsave) ;
            }
        }) ;
    }

    $(function(){
        bos.mstsurat_cetak.initcomp() ;
        bos.mstsurat_cetak.initcallback() ;
        bos.mstsurat_cetak.initfunc() ;
    })

</script>