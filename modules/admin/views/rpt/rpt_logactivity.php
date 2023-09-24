<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Filter Data</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <form>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Awal</label>
                                        <div class="col-xs-12 input-group">
                                            <input
                                                type="text" 
                                                class=" form-control date" 
                                                id="dTglAwal" 
                                                name="dTglAwal" 
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
                            </div>
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <div class="col-xs-12 input-group">
                                            <input
                                                type="text" 
                                                class=" form-control date" 
                                                id="dTglAkhir" 
                                                name="dTglAkhir" 
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
                            </div>
                            <div class="col-md-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Jenis Filter</label>
                                        <div class="col-md-12">
                                            <div class="col-sm-4">
                                                <label>
                                                    <input type="radio" name="optJenisFilter" id="optJenisFilter1" onclick="bos.rpt_logactivity.selectJenisFilter('A')" value="A" checked>
                                                    Semua User
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>
                                                    <input type="radio" name="optJenisFilter" id="optJenisFilter2" onclick="bos.rpt_logactivity.selectJenisFilter('P')" value="P">
                                                    Per User
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="col-md-12" id="divSelectUserList">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>List User</label>
                                        <select class="form-control optUserList select2" data-sf="load_Kota" name="optUserList" id="optUserList" data-placeholder=" - User List - "></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="cJenisFilter" id="cJenisFilter">
                        <button class="btn btn-info pull-right" id="cmdRefresh">Refresh Data</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <center><h3 class="box-title"><b>Logs Acitvity</b></h3></center>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive mailbox-messages">
                        <div id="gridLogActivity" style="height:700px"></div>
                    </div>
                </div>
                <div class="box-footer no-padding">

                </div>
            </div>
        </div>
    </div>
</section>

<script>

    <?=cekbosjs();?>

    bos.rpt_logactivity.gridLogActivity_data    = null ;
    bos.rpt_logactivity.gridLogActivity_loaddata= function(){
        this.gridLogActivity_data      = {
            "dTglAwal"     : $("#dTglAwal").val(),
            "dTglAkhir"    : $("#dTglAkhir").val(),
            "cJenisFilter" : $("#cJenisFilter").val(),
            "optUserList"  : $("#optUserList").val()
        } ;
    }

    bos.rpt_logactivity.gridLogActivity_load    = function(){
        this.obj.find("#gridLogActivity").w2grid({
            name     : this.id + '_gridLogActivity',
            limit    : 100 ,
            url      : bos.rpt_logactivity.base_url + "/loadgrid",
            postData : this.gridLogActivity_data ,
            show: {
                footer         : true,
                toolbar        : true,
                toolbarColumns : false,
                lineNumbers    : true,
            },
            searches: [
                { field: 'username', caption: 'username', type: 'text' }
            ],
            multiSearch     : false,
            columns: [
                { field: 'username', caption: 'User Name', size: '100px', sortable: false},
                { field: 'fullname', caption: 'Full Name', size: '175px', sortable: false},
                { field: 'activity_menu', caption: 'Menu Aplikasi', size: '200px', sortable: false, attr: "align=center"},
                { field: 'activity_type', caption: 'Aktifitas', size: '450px', sortable: false},
                { field: 'datetime', caption: 'Date Time', size: '150px', sortable: false}
            ]
        });
    }

    bos.rpt_logactivity.gridLogActivity_setdata   = function(){
        w2ui[this.id + '_gridLogActivity'].postData   = this.gridLogActivity_data ;
    }
    bos.rpt_logactivity.gridLogActivity_reload    = function(){
        w2ui[this.id + '_gridLogActivity'].reload() ;
    }
    bos.rpt_logactivity.gridLogActivity_destroy   = function(){
        if(w2ui[this.id + '_gridLogActivity'] !== undefined){
            w2ui[this.id + '_gridLogActivity'].destroy() ;
        }
    }

    bos.rpt_logactivity.gridLogActivity_render    = function(){
        this.obj.find("#gridLogActivity").w2render(this.id + '_gridLogActivity') ;
    }

    bos.rpt_logactivity.gridLogActivity_reloaddata   = function(){
        this.gridLogActivity_loaddata() ;
        this.gridLogActivity_setdata() ;
        this.gridLogActivity_reload() ;
    }

    bos.rpt_logactivity.cmdDetail = function(id){
        objForm    = "rpt_logactivity_read" ;
        locForm    = "admin/rpt/rpt_logactivity_read" ;
        this.setSessionIDSurat(id);
        setTimeout(function(){
            bjs.form({
                "module" : "Administrator",
                "name"   : "",
                "obj"    : objForm, 
                "loc"    : locForm
            });
        }, 1);
    }
    
    bos.rpt_logactivity.setSessionIDSurat = function(id){
        bjs.ajax(this.url + '/setSessionIDSurat', 'cKode=' + id);
    }

    bos.rpt_logactivity.initComp     = function(){
        this.gridLogActivity_loaddata() ;
        this.gridLogActivity_load() ;
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        $("#divSelectUserList").css("display","none") ;
        $('#cJenisFilter').val("A");
    }

    bos.rpt_logactivity.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rpt_logactivity.gridLogActivity_destroy() ;
        }) ;
    }

    bos.rpt_logactivity.initFunc 		= function(){
		this.gridLogActivity_loaddata() ;
		this.gridLogActivity_load() ;

		this.obj.find("form").on("submit", function(e){ 
         e.preventDefault() ;
      	});
	}

    bos.rpt_logactivity.selectJenisFilter = function(par){
        $("#cJenisFilter").val(par);
        if(par === 'P'){
            $("#divSelectUserList").css("display","block") ;
        }else{
            $("#divSelectUserList").css("display","none") ;
        }
    }

    bos.rpt_logactivity.obj.find("#cmdRefresh").on("click", function(){ 
   		bos.rpt_logactivity.gridLogActivity_reloaddata() ;  
	}) ; 

    bos.rpt_logactivity.cmdCheckNomorSurat = function(id){
        Swal.fire({
            icon    : "info",
            title   : id,
        });   
    }
   
    $('.optUserList').select2({
        allowClear: true,
        ajax: {
            url: bos.rpt_logactivity.base_url + '/seekUserList',
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
        bos.rpt_logactivity.initComp() ;
        bos.rpt_logactivity.initCallBack() ;
        bos.rpt_logactivity.initFunc() ;
    })

    
</script>