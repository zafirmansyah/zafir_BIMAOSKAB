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
                        <label>Kode</label>
                        <input type="text" name="cKode" id="cKode" class="form-control" placeholder="001" maxlength="3" required>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="cKeterangan" id="cKeterangan" class="form-control" maxlength="225" placeholder="eg : Kantor Perwakilan Bank Indonesia Malang" required>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Kode Rubrik</label>
                        <input type="text" name="cRubrik" id="cRubrik" class="form-control" maxlength="225" placeholder="eg : MI" required>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" id="cmdsave">Simpan</button>
            <button class="btn btn-warning" id="cmdCancel" onClick="bos.mstgol_unit.init()">Cancel</button>
        </form>
        </div>
    </div>
</div>
<script type="text/javascript">
<?=cekbosjs();?>

    bos.mstgol_unit.grid1_data    = null ;
    bos.mstgol_unit.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.mstgol_unit.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.mstgol_unit.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Golongan Unit Kerja',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'Kode', caption: 'Kode', size: '50px', sortable: false},
                { field: 'Keterangan', caption: 'Keterangan', size: '150px', sortable: false},
                { field: 'KodeRubrik', caption: 'Kode Rubrik', size: '100px', sortable: false},
                { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.mstgol_unit.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }
    bos.mstgol_unit.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.mstgol_unit.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.mstgol_unit.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.mstgol_unit.grid1_reloaddata   = function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    bos.mstgol_unit.cmdedit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.mstgol_unit.cmddelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }

    bos.mstgol_unit.init         = function(){
        this.obj.find("#cKode").val("").prop("readonly", false); 
        this.obj.find("#cKeterangan").val("") ;
        this.obj.find("#cRubrik").val("") ;
        bjs.ajax(this.url + '/init') ;

        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
    }

    bos.mstgol_unit.initcomp     = function(){
        this.grid1_loaddata() ;
        this.grid1_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        bjs.ajax(this.url + '/init') ;
    }

    bos.mstgol_unit.initcallback = function(){
        this.obj.on('remove', function(){
            bos.mstgol_unit.grid1_destroy() ;
        }) ;
    }

    bos.mstgol_unit.cmdsave       = bos.mstgol_unit.obj.find("#cmdsave") ;
    bos.mstgol_unit.initfunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.mstgol_unit.grid1_reloaddata() ;
            }else{//focus
                bos.mstgol_unit.obj.find("#cKode").focus() ;
            }
        });

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.mstgol_unit.base_url + '/saving', bjs.getdataform(this) , bos.mstgol_unit.cmdsave) ;
            }
        }) ;
    }

    $(function(){
        bos.mstgol_unit.initcomp() ;
        bos.mstgol_unit.initcallback() ;
        bos.mstgol_unit.initfunc() ;
    })

</script>