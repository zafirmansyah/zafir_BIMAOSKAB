<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Data Form</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <form>
                <div class="row">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Nama Divisi</label>
                            <input type="text" name="cNamaDivisi" id="cNamaDivisi" class="form-control" placeholder="Nama Divisi" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" name="cDeskripsi" id="cDeskripsi" class="form-control" placeholder="Deskripsi Divisi Pekerjaan" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="cKode" name="cKode">
                <button class="btn btn-primary" id="cmdsave">Simpan</button>
            </form>
        </div>
   </div>
</div>
<script type="text/javascript">
   <?=cekbosjs();?>

    bos.livapply.cmdedit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.livapply.cmddelete    = function(kode){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'kode=' + kode);
        }
    }

    bos.livapply.init         = function(){
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cNamaDivisi").val("") ;
        this.obj.find("#cDeskripsi").val("") ;
        //   bjs.ajax(this.url + '/init') ;

        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.livapply.initcomp     = function(){
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        // bjs.ajax(this.url + '/init') ;
    }

    bos.livapply.initcallback = function(){
        this.obj.on('remove', function(){
            
        }) ;
    }

    bos.livapply.cmdsave       = bos.livapply.obj.find("#cmdsave") ;
    bos.livapply.initfunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                // bos.livapply.grid1_reloaddata() ;
            }else{//focus
                bos.livapply.obj.find("#nik").focus() ;
            }
        });

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.livapply.base_url + '/saving', bjs.getdataform(this) , bos.livapply.cmdsave) ;
            }
        }) ;
    }

    $(function(){
        bos.livapply.initcomp() ;
        bos.livapply.initcallback() ;
        bos.livapply.initfunc() ;
    });

</script>