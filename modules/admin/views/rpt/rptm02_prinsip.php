<section class="content">
    <div class="row">
        <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" style="text-align:center;">
                <h3 class="box-title">Daftar M02 Persetujuan Prinsip</h3>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive mailbox-messages">
                    <div id="gridPrinsip" style="height:500px"></div>
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

    bos.rptm02_prinsip.gridPrinsip_data    = null ;
    bos.rptm02_prinsip.gridPrinsip_loaddata= function(){
        this.gridPrinsip_data      = {} ;
    }

    bos.rptm02_prinsip.gridPrinsip_load    = function(){
        this.obj.find("#gridPrinsip").w2grid({
            name     : this.id + '_gridPrinsip',
            limit    : 100 ,
            url      : bos.rptm02_prinsip.base_url + "/loadgrid",
            postData : this.gridPrinsip_data ,
            header   : 'Daftar Surat Keluar',
            show: {
                // header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'NoSurat', caption: 'Nomor Dokumen', size: '150px', sortable: false},
                { field: 'Perihal', caption: 'Perihal Dokumen', size: '250px', sortable: false},
                { field: 'Dari', caption: 'Dari', size: '125px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal Input', size: '150px', sortable: false, attr: "align=center"},
                { field: 'cmdDetail', caption: '', size: '75px', sortable: false, attr: "align=center"},
                { field: 'cmdTimeline', caption: '', size: '75px', sortable: false, attr: "align=center"},
            ]
        });
    }

    bos.rptm02_prinsip.gridPrinsip_setdata   = function(){
        w2ui[this.id + '_gridPrinsip'].postData   = this.gridPrinsip_data ;
    }
    bos.rptm02_prinsip.gridPrinsip_reload    = function(){
        w2ui[this.id + '_gridPrinsip'].reload() ;
    }
    bos.rptm02_prinsip.gridPrinsip_destroy   = function(){
        if(w2ui[this.id + '_gridPrinsip'] !== undefined){
            w2ui[this.id + '_gridPrinsip'].destroy() ;
        }
    }

    bos.rptm02_prinsip.gridPrinsip_render    = function(){
        this.obj.find("#gridPrinsip").w2render(this.id + '_gridPrinsip') ;
    }

    bos.rptm02_prinsip.gridPrinsip_reloaddata   = function(){
        this.gridPrinsip_loaddata() ;
        this.gridPrinsip_setdata() ;
        this.gridPrinsip_reload() ;
    }

    bos.rptm02_prinsip.cmdDetail = function(id){
        objForm    = "rptm02_prinsip_read" ;
        locForm    = "admin/rpt/rptm02_prinsip_read" ;
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
    
    bos.rptm02_prinsip.setSessionIDSurat = function(id){
        bjs.ajax(this.url + '/setSessionIDSurat', 'cFaktur=' + id);
    }

    bos.rptm02_prinsip.initComp     = function(){
        this.gridPrinsip_loaddata() ;
        this.gridPrinsip_load() ;
    }

    bos.rptm02_prinsip.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptm02_prinsip.gridPrinsip_destroy() ;
        }) ;
    }

   

    $(function(){
        bos.rptm02_prinsip.initComp() ;
        bos.rptm02_prinsip.initCallBack() ;
        // bos.rptm02_prinsip.initFunc() ;
    })

    
</script>