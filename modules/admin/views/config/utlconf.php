<section class="content">
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <div class="box-body no-padding"> 
                    <div class="col-lg-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>User</h3>

                                <p>Setting Username and Password</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-lock"></i>
                            </div> 
                            <a href="#" id="linkUsers" class="small-box-footer">Go &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- small box -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>Database</h3>

                                <p>Backup Database</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-database"></i>
                            </div>
                            <a href="#" id="linkBackUpDatabase" class="small-box-footer">Go &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>User Level</h3>

                                <p>Setting User Level Access</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-random"></i>
                            </div>
                            <a href="#" id="linkUserLevel" class="small-box-footer">Go &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>Backup Direktori</h3>

                                <p>Download Direktori Dokumen Tahunan</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-download"></i>
                            </div>
                            <a href="#" id="linkBackupDirektori" class="small-box-footer">Go &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</section>

<script type="text/javascript">

<?=cekbosjs();?>

    bos.utlconf.initFunc    = function(){
        
        this.obj.find("#linkBackupDirektori").on('click',function(e){
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


    }

    $(function(){
        bos.utlconf.initFunc() ;   
    });

</script>