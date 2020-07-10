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
            <li class="active"><a id="linkBackUpDatabase" href="#"><i class="fa fa-database"></i> Database</a></li>
            <li id="linkUsers"><a href="#"><i class="fa fa-lock"></i> User</a></li>
            <li><a id="linkUserLevel" href="#"><i class="fa fa-random"></i> User Level</a></li>
            <li><a id="linkBackUpDirektori" href="#"><i class="fa fa-download"></i> Backup Direktori</a></li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Setting Username & Password</h3>
            </div>
            <div class="box-body no-padding"> 
                <div class="col-sm-12">
                    <div class="box box-info color-palette-box">
                        <div class="box-body">
                            <form>
                                <div class=col-md-6>
                                    <label>Download Url : </label>
                                    <a id="linkdownlaodbackup" href=""></a>
                                </div>
                                <button id="cmdBackup" class="btn btn-primary btn-block">Backup Database</button>
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


    bos.utlbackup_database.initcomp	= function(){

        bjs.initdate("#" + this.id + " .date") ;
    }  

    bos.utlbackup_database.initcallback	= function(){
        this.obj.on("bos:tab", function(e){
            bos.utlbackup_database.tabsaction( e.i )  ;
        }); 
    }

    bos.utlbackup_database.objs = bos.utlbackup_database.obj.find("#cmdBackup") ;
    bos.utlbackup_database.initfunc 		= function(){
        this.obj.find("form").on("submit", function(e){ 
            e.preventDefault() ;
        });

        this.obj.find("#cmdBackup").on("click", function(e){
            e.preventDefault() ;
            if(bjs.isvalidform(this)){
                bjs.ajax(bos.utlbackup_database.base_url + '/backup', bjs.getdataform(this), bos.utlbackup_database.objs) ;
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
    $(function(){
        bos.utlbackup_database.initcomp() ;
        bos.utlbackup_database.initcallback() ;
        bos.utlbackup_database.initfunc() ;
    }) ;
</script>