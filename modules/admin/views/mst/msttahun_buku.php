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
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="text" name="cTahunBuku" id="cTahunBuku" class="form-control" placeholder="2020" maxlength="4" required>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Kode Tahun Buku</label>
                        <input type="text" name="cKodeTahunBuku" id="cKodeTahunBuku" class="form-control" maxlength="2" placeholder="22" required>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" id="cmdsave">Simpan</button>
            <button class="btn btn-warning" id="cmdCancel" onClick="bos.msttahun_buku.init()">Cancel</button>
        </form>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.msttahun_buku.grid1_data    = null ;
    bos.msttahun_buku.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.msttahun_buku.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.msttahun_buku.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Kode Tahun Buku',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'TahunBuku', caption: 'Tahun Buku', size: '100px', sortable: false},
                { field: 'KodeTahunBuku', caption: 'Kode Tahun Buku', size: '150px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.msttahun_buku.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.msttahun_buku.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.msttahun_buku.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.msttahun_buku.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.msttahun_buku.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.msttahun_buku.cmdEdit      = function(id){
        bjs.ajax(this.url + '/editing', 'cTahunBuku=' + id);
    }

    bos.msttahun_buku.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cTahunBuku=' + id);
        }
    }

    bos.msttahun_buku.init         = function(){
        this.obj.find("#cTahunBuku").val("").prop("readonly", false); 
        this.obj.find("#cKodeTahunBuku").val("") ;
        bjs.ajax(this.url + '/init') ;

        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.msttahun_buku.initComp     = function(){
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        bjs.ajax(this.url + '/init') ;
    }

    bos.msttahun_buku.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.msttahun_buku.grid1_destroy() ;
        }) ;
    }

    bos.msttahun_buku.cmdsave       = bos.msttahun_buku.obj.find("#cmdsave") ;
    bos.msttahun_buku.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.msttahun_buku.grid1_reloaddata() ;
            }else{//focus
                bos.msttahun_buku.obj.find("#cTahunBuku").focus() ;
            }
        });

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.msttahun_buku.base_url + '/saving', bjs.getdataform(this) , bos.msttahun_buku.cmdsave) ;
            }
        }) ;
    }

    $(function(){
        bos.msttahun_buku.initComp() ;
        bos.msttahun_buku.initCallBack() ;
        bos.msttahun_buku.initFunc() ;
    })

</script>