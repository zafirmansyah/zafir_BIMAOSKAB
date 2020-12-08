<section class="content">
    <div class="row">
       
        <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" style="text-align:center;">
                <h3 class="box-title">Daftar Work Order</h3>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive mailbox-messages">
                    <div id="gridWorkOrder" style="height:500px"></div>
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

    bos.rptwo.gridWorkOrder_data    = null ;
    bos.rptwo.gridWorkOrder_loaddata= function(){
        this.gridWorkOrder_data      = {} ;
    }

    bos.rptwo.gridWorkOrder_load    = function(){
        this.obj.find("#gridWorkOrder").w2grid({
            name     : this.id + '_gridWorkOrder',
            limit    : 100 ,
            url      : bos.rptwo.base_url + "/loadgrid",
            postData : this.gridWorkOrder_data ,
            header   : 'Daftar Work Order',
            show: {
                // header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            searches: [
                { field: 'Subject', caption: 'Judul Work Order', type: 'text' },
            ],
            columns: [
                { field: 'cmdDetail', caption: 'Judul Work Order', size: '150px', sortable: false},
                { field: 'UserName', caption: 'User Input WO', size: '100px', sortable: false},
                { field: 'Tgl', caption: 'Tgl Input Master', size: '100px', sortable: false},
                { field: 'TujuanUserName', caption: 'User Tujuan WO', size: '100px', sortable: false},
                { field: 'Status', caption: 'Status', size: '150px', sortable: false, style:'font-weight:bold'},
                { field: 'TglProses', caption: 'Tgl Awal Proses', size: '130px', sortable: false, style:'text-align:center'},
                { field: 'TglStatusAkhir', caption: 'Tgl Status Akhir', size: '130px', sortable: false, style:'text-align:center'},
            ]
        });
    }

    bos.rptwo.gridWorkOrder_setdata   = function(){
        w2ui[this.id + '_gridWorkOrder'].postData   = this.gridWorkOrder_data ;
    }
    bos.rptwo.gridWorkOrder_reload    = function(){
        w2ui[this.id + '_gridWorkOrder'].reload() ;
    }
    bos.rptwo.gridWorkOrder_destroy   = function(){
        if(w2ui[this.id + '_gridWorkOrder'] !== undefined){
            w2ui[this.id + '_gridWorkOrder'].destroy() ;
        }
    }

    bos.rptwo.gridWorkOrder_render    = function(){
        this.obj.find("#gridWorkOrder").w2render(this.id + '_gridWorkOrder') ;
    }

    bos.rptwo.gridWorkOrder_reloaddata   = function(){
        this.gridWorkOrder_loaddata() ;
        this.gridWorkOrder_setdata() ;
        this.gridWorkOrder_reload() ;
    }

    bos.rptwo.cmdDetail = function(id){
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
        this.gridWorkOrder_loaddata() ;
        this.gridWorkOrder_load() ;
        //$(".modal-backdrop").css("display","none");
    }

    bos.rptwo.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptwo.gridWorkOrder_destroy() ;
        }) ;
    }

   

    $(function(){
        bos.rptwo.initComp() ;
        bos.rptwo.initCallBack() ;
        // bos.rptwo.initFunc() ;
    })

    
</script>