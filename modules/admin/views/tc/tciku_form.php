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
                        <label>Pilih Kode IKU</label>
                        <select class="form-control optKodeIKU select2" data-sf="load_Kota" name="optKodeIKU" id="optKodeIKU" data-placeholder=" - Kode IKU - " required></select>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="cDeskripsi" id="cDeskripsi" class="form-control" placeholder="Deskripsi" row="20" required></textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tanggal Pengisian Form IKU</label>
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
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Upload File</label>
                        <div id="idcUplFileFormIKU">
                            <input style="width:100%" type="file" class="form-control cUplFileFormIKU" id="cUplFileFormIKU" name="cUplFileFormIKU[]" multiple required>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="nNo" id="nNo" value="0">
            <input type="hidden" name="cKode" id="cKode">
            <input type="hidden" name="cLastPath" id="cLastPath">
            <button class="btn btn-primary" id="cmdSave">Simpan</button>
            <button class="btn btn-warning" id="cmdCancel" onClick="bos.tciku_form.init()">Cancel</button>
        </form>
        </div>
    </div>
</div>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.tciku_form.grid1_data    = null ;
    bos.tciku_form.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tciku_form.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tciku_form.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Daftar Surat Keluar',
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
                { field: 'Subject', caption: 'Judul', size: '150px', sortable: false},
                { field: 'Deskripsi', caption: 'Deskripsi', size: '250px', sortable: false},
                { field: 'Periode', caption: 'Periode', size: '250px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'UserName', caption: 'Petugas Entry', size: '100px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
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

    bos.tciku_form.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }


    bos.tciku_form.init         = function(){
        this.obj.find("#cDeskripsi").val("") ;
        this.obj.find("#cKode").val("") ;
        this.obj.find("#optKodeIKU").val("") ;
        this.obj.find("#nNo").val("0") ;
        this.obj.find("#cUplFileFormIKU").val("");
        bjs.ajax(this.url + '/init') ;
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bos.tciku_form.grid1_loaddata() ;
    }

    bos.tciku_form.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;

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
        }) ;
    }


    bos.tciku_form.cmdSave       = bos.tciku_form.obj.find("#cmdSave") ;
    bos.tciku_form.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tciku_form.grid1_reloaddata() ;
            }
        });

        this.obj.find("#cUplFileFormIKU").on("change", function(e){
            e.preventDefault() ;
            bos.tciku_form.uname       = $(this).attr("id") ;
            bos.tciku_form.fal         = $("#cUplFileFormIKU")[0].files;//e.target.files;
            bos.tciku_form.gfal        = new FormData() ;
            for(var i = 0; i < bos.tciku_form.fal.length; i++){
                bos.tciku_form.gfal.append("cUplFileFormIKU[]",bos.tciku_form.fal[i]);
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

    $('.optKodeIKU').select2({
        allowClear: true,
        ajax: {
            url: bos.tciku_form.base_url + '/seekKodeIKU',
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