<section class="content">
    <div class="row">
        <!--div class="col-md-3">
            <?php $this->load->view('rptlistfolder_suratmasuk');?>
        </div-->
        <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border" style="text-align:center;">
                <h3 class="box-title">Daftar Surat Masuk</h3>
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

    bos.rptsuratmasuk.gridSuratMasuk_data    = null ;
    bos.rptsuratmasuk.gridSuratMasuk_loaddata= function(){
        this.gridSuratMasuk_data      = {} ;
    }

    bos.rptsuratmasuk.gridSuratMasuk_load    = function(){
        this.obj.find("#gridSuratMasuk").w2grid({
            name     : this.id + '_gridSuratMasuk',
            limit    : 100 ,
            url      : bos.rptsuratmasuk.base_url + "/loadgrid",
            postData : this.gridSuratMasuk_data ,
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
                { field: 'cmdDetail', caption: 'Perihal Surat', size: '250px', sortable: false},
                { field: 'Dari', caption: 'Dari', size: '125px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal Input', size: '150px', sortable: false, attr: "align=center"},
            ]
        });
    }

    bos.rptsuratmasuk.gridSuratMasuk_setdata   = function(){
        w2ui[this.id + '_gridSuratMasuk'].postData   = this.gridSuratMasuk_data ;
    }
    bos.rptsuratmasuk.gridSuratMasuk_reload    = function(){
        w2ui[this.id + '_gridSuratMasuk'].reload() ;
    }
    bos.rptsuratmasuk.gridSuratMasuk_destroy   = function(){
        if(w2ui[this.id + '_gridSuratMasuk'] !== undefined){
            w2ui[this.id + '_gridSuratMasuk'].destroy() ;
        }
    }

    bos.rptsuratmasuk.gridSuratMasuk_render    = function(){
        this.obj.find("#gridSuratMasuk").w2render(this.id + '_gridSuratMasuk') ;
    }

    bos.rptsuratmasuk.gridSuratMasuk_reloaddata   = function(){
        this.gridSuratMasuk_loaddata() ;
        this.gridSuratMasuk_setdata() ;
        this.gridSuratMasuk_reload() ;
    }

    bos.rptsuratmasuk.cmdDetail = function(id){
        objForm    = "rptsuratmasuk_read" ;
        locForm    = "admin/rpt/rptsuratmasuk_read" ;
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
    
    bos.rptsuratmasuk.setSessionIDSurat = function(id){
        bjs.ajax(this.url + '/setSessionIDSurat', 'cKode=' + id);
    }

    bos.rptsuratmasuk.initComp     = function(){
        this.gridSuratMasuk_loaddata() ;
        this.gridSuratMasuk_load() ;
    }

    bos.rptsuratmasuk.initCallBack = function(){
        this.obj.on('remove', function(){
            bos.rptsuratmasuk.gridSuratMasuk_destroy() ;
        }) ;
    }

   

    $(function(){
        bos.rptsuratmasuk.initComp() ;
        bos.rptsuratmasuk.initCallBack() ;
        // bos.rptsuratmasuk.initFunc() ;
    })

    
</script>