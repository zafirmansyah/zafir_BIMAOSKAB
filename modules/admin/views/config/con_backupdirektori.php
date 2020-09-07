<section class="content">
  <div class="row">
    <div class="col-md-3">
    <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Quick Access</h3>

          <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li><a id="linkBackUpDatabase" href="#"><i class="fa fa-database"></i> Database</a></li>
            <li><a id="linkUsers" href="#"><i class="fa fa-lock"></i> User</a></li>
            <li><a id="linkUserLevel" href="#"><i class="fa fa-random"></i> User Level</a></li>
            <li class="active"><a id="linkBackUpDirektori" href="#"><i class="fa fa-download"></i> Backup Direktori</a></li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Backup Data Dokumen-Dokumen Terupload</h3>
            </div>
            <div class="box-body no-padding"> 
                <div class="col-sm-12">
                    <div class="box box-info color-palette-box">
                        <div class="box-body">
                            <form>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tahun Buku</label>
                                        <select class="form-control optTahunBuku select2" data-sf="load_TB" name="optTahunBuku" id="optTahunBuku" data-placeholder=" - Pilih Tahun Buku - "></select>
                                    </div>
                                </div>
                                <button id="cmdBackup" class="btn btn-primary btn-block">Backup Dokumen</button>
                                <div class=col-md-12>
                                    <label>Download Url : </label>
                                    <a id="linkdownlaodbackup" href=""></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>

<script type="text/javascript">
    <?=cekbosjs();?>


    bos.con_backupdirektori.initcomp	= function(){

        bjs.initdate("#" + this.id + " .date") ;
    }  

    bos.con_backupdirektori.initcallback	= function(){
        this.obj.on("bos:tab", function(e){
            bos.con_backupdirektori.tabsaction( e.i )  ;
        }); 
    }

    bos.con_backupdirektori.objs = bos.con_backupdirektori.obj.find("#cmdBackup") ;
    bos.con_backupdirektori.initfunc 		= function(){
        this.obj.find("form").on("submit", function(e){ 
            e.preventDefault() ;
        });

        this.obj.find("#cmdBackup").on("click", function(e){
            e.preventDefault() ;
            if(bjs.isvalidform(this)){
                var optTahunBuku = $("#optTahunBuku").val();
                bjs.ajax(bos.con_backupdirektori.base_url + '/backup', "optTahunBuku="+optTahunBuku) ;
            }
        }) ;

        this.obj.find("#linkUserLevel").on('click',function(e){
            objForm    = "con_userlevel" ;
            locForm    = "admin/config/username_lv" ;
            setTimeout(function(){
                bjs.form({
                    "module" : "Administrator",
                    "name"   : "",
                    "obj"    : objForm, 
                    "loc"    : locForm
                });
            }, 1);
        });

        this.obj.find("#linkUsers").on('click',function(e){
            objForm    = "con_user" ;
            locForm    = "admin/config/username" ;
            setTimeout(function(){
                bjs.form({
                    "module" : "Administrator",
                    "name"   : "",
                    "obj"    : objForm, 
                    "loc"    : locForm
                });
            }, 1);
        });

        this.obj.find("#linkBackUpDatabase").on('click',function(e){
            objForm    = "utlbackup_database" ;
            locForm    = "admin/config/utlbackup_database" ;
            setTimeout(function(){
                bjs.form({
                    "module" : "Administrator",
                    "name"   : "",
                    "obj"    : objForm, 
                    "loc"    : locForm
                });
            }, 1);
        });

        this.obj.find("#linkBackUpDirektori").on('click',function(e){
            objForm    = "con_backupdirektori" ;
            locForm    = "admin/config/con_backupdirektori" ;
            setTimeout(function(){
                bjs.form({
                    "module" : "Administrator",
                    "name"   : "",
                    "obj"    : objForm, 
                    "loc"    : locForm
                });
            }, 1);
        });
    }

    $('.optTahunBuku').select2({
        allowClear: true,
        ajax: {
            url: bos.con_backupdirektori.base_url + '/seekTahunBuku',
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

    bos.con_backupdirektori.finalAct = function(fileToDownload,fileName){
        let timerInterval
        Swal.fire({
            icon: 'info',
            title: 'Harap Tunggu',
            html: 'Sistem Sedang Memproses Backup Dokumen',
            timer: 7000,
            timerProgressBar: true,
            onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                    b.textContent = Swal.getTimerLeft()
                    }
                }
                }, 100)
            },
            onClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
            var a = document.getElementById("linkdownlaodbackup");
            document.getElementById("linkdownlaodbackup").href = fileToDownload ;
            a.innerHTML = fileName;
        })
    }

    $(function(){
        bos.con_backupdirektori.initcomp() ;
        bos.con_backupdirektori.initcallback() ;
        bos.con_backupdirektori.initfunc() ;
    }) ;
</script>