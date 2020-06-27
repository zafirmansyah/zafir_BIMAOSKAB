<section class="content">
    <div class="row">
        <!--div class="col-md-3">
            <?php $this->load->view('rptlistfolder_suratmasuk');?>
        </div-->
        <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" style="text-align:center;">
                <h3 class="box-title">Daftar Work Order</h3>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive mailbox-messages">
                    <div id="gridSuratMasuk" style="height:500px"></div>
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

    bos.rptwo.gridSuratMasuk_data    = null ;
    bos.rptwo.gridSuratMasuk_loaddata= function(){
        this.gridSuratMasuk_data      = {} ;
    }

    bos.rptwo.gridSuratMasuk_load    = function(){
        this.obj.find("#gridSuratMasuk").w2grid({
            name     : this.id + '_gridSuratMasuk',
            limit    : 100 ,
            url      : bos.rptwo.base_url + "/loadgrid",
            postData : this.gridSuratMasuk_data ,
            header   : 'Daftar Work Order',
            show: {
                // header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'cmdDetail', caption: 'Judul Work Order', size: '150px', sortable: false},
                { field: 'UserName', caption: 'User Input WO', size: '100px', sortable: false},
                { field: 'Tgl', caption: 'Tgl Input Master', size: '100px', sortable: false},
                { field: 'TujuanUserName', caption: 'User Tujuan WO', size: '100px', sortable: false},
                { field: 'Status', caption: 'Status', size: '80px', sortable: false, style:'font-weight:bold'},
                { field: 'TglProses', caption: 'Tgl Awal Proses', size: '130px', sortable: false, style:'text-align:center'},
                { field: 'TglStatusAkhir', caption: 'Tgl Status Akhir', size: '130px', sortable: false, style:'text-align:center'},
            ]
        });
    }

    bos.rptwo.gridSuratMasuk_setdata   = function(){
        w2ui[this.id + '_gridSuratMasuk'].postData   = this.gridSuratMasuk_data ;
    }
    bos.rptwo.gridSuratMasuk_reload    = function(){
        w2ui[this.id + '_gridSuratMasuk'].reload() ;
    }
    bos.rptwo.gridSuratMasuk_destroy   = function(){
        if(w2ui[this.id + '_gridSuratMasuk'] !== undefined){
            w2ui[this.id + '_gridSuratMasuk'].destroy() ;
        }
    }

    bos.rptwo.gridSuratMasuk_render    = function(){
        this.obj.find("#gridSuratMasuk").w2render(this.id + '_gridSuratMasuk') ;
    }

    bos.rptwo.gridSuratMasuk_reloaddata   = function(){
        this.gridSuratMasuk_loaddata() ;
        this.gridSuratMasuk_setdata() ;
        this.gridSuratMasuk_reload() ;
    }

    bos.rptwo.cmdDetail = function(id){
        alert(id);
        objForm    = "rptwo_read" ;
        locForm    = "admin/rpt/rptwo_read" ;
        this.setSessionIDWO(id);
        setTimeout(function(){
            bjs.form({
                "module" : "Administrator",
                "name"   : "",
                "obj"    : objForm, 
                "loc"    : locForm
            });
        }, 1);
    }
    
    bos.rptwo.setSessionIDWO = function(id){
        bjs.ajax(this.url + '/setSessionIDWO', 'cKode=' + id);
    }

    bos.rptwo.initComp     = function(){
        this.gridSuratMasuk_loaddata() ;
        this.gridSuratMasuk_load() ;
    }

    bos.rptwo.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptwo.gridSuratMasuk_destroy() ;
        }) ;
    }

   

    $(function(){
        bos.rptwo.initComp() ;
        bos.rptwo.initCallBack() ;
        // bos.rptwo.initFunc() ;
    })

    
</script>