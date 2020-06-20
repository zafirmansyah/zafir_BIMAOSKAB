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
                        <label>Tanggal Penulisan Work Order</label>
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
                        <input type="text" name="cSubject" id="cSubject" class="form-control" maxlength="225" placeholder="Judul Work Order" required>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <div class="col-sm-12">
                                <textarea name="cDeskripsi" id="cDeskripsi" cols="20" rows="10" placeholder="Deskripsi Master Work Order...">
                                Permasalahan: 
                                </textarea>                   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Tujuan UserName</label>
                        <select class="form-control optUserName select2" data-sf="load_Kota" name="optUserName" id="optUserName" data-placeholder=" - Tujuan Unit - " required></select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Upload File</label>
                        <div id="idcUplFileWO">
                            <input style="width:100%" type="file" class="form-control cUplFileWO" id="cUplFileWO" name="cUplFileWO[]" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="nNo" id="nNo" value="0">
            <input type="hidden" name="cKodeKaryawan" id="cKodeKaryawan">
            <input type="hidden" name="cKode" id="cKode">
            <input type="hidden" name="cStatus" id="cStatus">
            <input type="hidden" name="cLastPath" id="cLastPath">
            <button class="btn btn-primary" id="cmdSave">Simpan</button>
            <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcwo_master.init()">Cancel</button>
        </form>
        </div>
    </div>
</div>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcwo_master.grid1_data    = null ;
    bos.tcwo_master.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcwo_master.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcwo_master.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Daftar Work Order',
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
                { field: 'TujuanUserName', caption: 'Tujuan User', size: '250px', sortable: false},
                { field: 'Subject', caption: 'Judul', size: '150px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'Status', caption: 'Status', size: '80px', sortable: false},
                { field: 'UserName', caption: 'Petugas Entry', size: '100px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcwo_master.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }

    bos.tcwo_master.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcwo_master.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcwo_master.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcwo_master.grid1_reloaddata   = function(){
        this.grid1_setdata() ;
    }

    /******************************************** */


    /********************************************** */

    bos.tcwo_master.cmdEdit      = function(id){
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.tcwo_master.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }


    bos.tcwo_master.init         = function(){
        this.obj.find("#cSubject").val("") ;
        this.obj.find("#cDeskripsi").val("") ;
        tinymce.activeEditor.setContent("");
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cStatus").val("");
        this.obj.find("#optUserName").val("") ;
        this.obj.find("#cUplFileWO").val("") ;
        this.obj.find("#nNo").val("0") ;
        bjs.ajax(this.url + '/init') ;
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bos.tcwo_master.grid1_loaddata() ;
        bos.tcwo_master.grid1_reload() ;
    }


    bos.tcwo_master.initTinyMCE = function(){
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

    bos.tcwo_master.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;

        this.initTinyMCE() ;
        this.grid1_loaddata() ;
        this.grid1_load() ;

        bjs.ajax(this.url + '/init') ;
    }


    bos.tcwo_master.tabsaction    = function(n){
        bos.tcwo_master.grid1_render() ;
        bos.tcwo_master.init() ;
    }

    bos.tcwo_master.initCallBack = function(){
        this.obj.on("bos:tab", function(e){
            bos.tcwo_master.tabsaction( e.i )  ;
        });
        this.obj.on('remove', function(){
            bos.tcwo_master.grid1_destroy() ;
            tinymce.remove() ;
        }) ;
    }


    bos.tcwo_master.cmdSave       = bos.tcwo_master.obj.find("#cmdSave") ;
    bos.tcwo_master.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcwo_master.grid1_reloaddata() ;
            }
        });

        this.obj.find("#cUplFileWO").on("change", function(e){
            e.preventDefault() ;
            bos.tcwo_master.uname       = $(this).attr("id") ;
            bos.tcwo_master.fal         = $("#cUplFileWO")[0].files;//e.target.files;
            bos.tcwo_master.gfal        = new FormData() ;
            for(var i = 0; i < bos.tcwo_master.fal.length; i++){
                bos.tcwo_master.gfal.append("cUplFileWO[]",bos.tcwo_master.fal[i]);
            }
            bos.tcwo_master.obj.find("#idl" + bos.tcwo_master.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.tcwo_master.base_url + "/savingFile" , bos.tcwo_master.gfal, this) ;
            
        }) ;
        

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.tcwo_master.base_url + '/saving', bjs.getdataform(this) , bos.tcwo_master.cmdSave) ;
            }
        }) ;
    }

    $('.optUserName').select2({
        allowClear: true,
        ajax: {
            url: bos.tcwo_master.base_url + '/seekUserName',
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
        bos.tcwo_master.initComp() ;
        bos.tcwo_master.initCallBack() ;
        bos.tcwo_master.initFunc() ;
    })

</script>