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
            <li><a id="linkGeneralSystem" href="#"><i class="fa fa-power-off"></i> General System</a></li>
            <li><a id="linkDatabase" href="#"><i class="fa fa-database"></i> Database</a></li>
            <li id="linkUsers" class="active"><a href="#"><i class="fa fa-lock"></i> User</a></li>
            <li><a id="linkUserLevel" href="#"><i class="fa fa-random"></i> User Level</a></li>
            
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
                <div class="col-sm-6">
                    <div class="box box-info color-palette-box">
                        <div class="box-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="fullname">Fullname</label>
                                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="passowrd">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" name="cEmail" id="cEmail" placeholder="your@mail.com" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Golongan Unit</label>
                                            <select name="optUnit" id="optUnit" class="form-control" placeholder="Golongan Unit" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Jabatan</label>
                                            <select name="optJabatan" id="optJabatan" class="form-control" placeholder="Jabatan" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="level">Hak Akses Menu</label>
                                            <select class="form-control select2 sparent" data-sf="load_level"
                                            name="level" id="level" data-placeholder="Level" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="image">Foto <span id="idlimage"></span></label>
                                            <input type="file" name="image" id="image" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="idimage" style="text-align:center;"></div>
                                </div>
                                <button id="cmdsave" class="btn btn-primary btn-block">Save</button>
                                <input type="hidden" name="chKodeKaryawan" id="chKodeKaryawan">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="box box-default color-palette-box">
                        <div class="box-body">
                            <div id="grusername" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>

<script type="text/javascript">
	if(typeof bos === "undefined") window.location.href = "<?=base_url()?>";

	bos.con_user.grid1_data 	= null ;
	bos.con_user.grid1_loaddata= function(){
	}

	bos.con_user.grid1_load	= function(){
		this.obj.find("#grusername").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.con_user.base_url + "/loadgrid",
	        postData: this.grid1_data ,
	        show: {
	        	footer 		: true
	        },
	        columns: [
	            { field: 'username', caption: 'Username', size: '80px', sortable: false },
	            { field: 'fullname', caption: 'Fullname', size: '150px', sortable: false },
                { field: 'cabang', caption: 'Cabang', size: '100px', sortable: false },
	            { field: 'cmdedit', caption: ' ', size: '80px', sortable: false,style:'text-align:center;' },
	            { field: 'cmddelete', caption: ' ', size: '80px', sortable: false,style:'text-align:center;' }
	        ]
	    });
	}
	bos.con_user.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.con_user.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.con_user.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}
	bos.con_user.grid1_render 	= function(){
		this.obj.find("#grusername").w2render(this.id + '_grid1') ;
	}

	bos.con_user.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

	bos.con_user.cmdedit 		= function(username){
		bjs.ajax(this.base_url + '/editing', 'username=' + username);
	}

	bos.con_user.cmddelete 	= function(username){
		if(confirm("Delete Data?")){
			bjs.ajax(this.base_url + '/deleting', 'username=' + username);
		}
	}

	bos.con_user.init 			= function(){
        this.obj.find("#optNIK").sval("").attr("readonly", false).focus() ;
		this.obj.find("#username").val("") ;
		this.obj.find("#fullname").val("") ;
        this.obj.find("#password").val("") ;
		this.obj.find("#level").sval({}) ;
		this.obj.find("#optUnit").sval({}) ;
		this.obj.find("#optJabatan").sval({}) ;
		this.obj.find("#idlimage").html("") ;
		this.obj.find("#idimage").html("") ;
        this.obj.find("#cabang").sval({}) ;
		this.grid1_reloaddata() ;
		bjs.ajax(this.base_url + '/init') ;
	}

	bos.con_user.initcomp		= function(){
		this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initselect({
			class 		: "#" + this.id + " .select2.sparent"
		}) ;
		bjs.initenter(this.obj) ;

		bjs.ajax(this.base_url + '/init') ;
	}

	bos.con_user.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.con_user.grid1_destroy() ;
		}) ;
	}

   bos.con_user.cmdsave       = bos.con_user.obj.find("#cmdsave") ;
	bos.con_user.initfunc		= function(){

		this.obj.find("#username").on("blur", function(){
			bjs.ajax( bos.con_user.base_url + '/seekusername', 'username=' + $(this).val() ) ;
		});

		this.obj.find("#image").on("change", function(e){
			e.preventDefault() ;

            bos.con_user.cfile    = e.target.files ;
            bos.con_user.gfile    = new FormData() ;
            $.each(bos.con_user.cfile, function(cKey,cValue){
              bos.con_user.gfile.append(cKey,cValue) ;
            }) ;

            bos.con_user.obj.find("#idlimage").html("<i class='fa fa-spinner fa-pulse'></i>");
            bos.con_user.obj.find("#idimage").html("") ;

            bjs.ajaxfile(bos.con_user.base_url + "/saving_image", bos.con_user.gfile, this) ;

		}) ;

		this.obj.find('form').on("submit", function(e){
         e.preventDefault() ;
			if( bjs.isvalidform(this) ){
				bjs.ajax( bos.con_user.base_url + '/saving', bjs.getdataform(this) , bos.con_user.cmdsave) ;
			}
		}) ;

        this.obj.find("#optNIK").on("change",function(e){
            e.preventDefault() ;
            bjs.ajax(bos.con_user.base_url + "/SeekNIK", "Kode=" + $(this).val()) ;
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

	}
    
    $('#optUnit').select2({
        ajax: {
            url: bos.con_user.base_url + '/seekUnit',
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

    $('#optJabatan').select2({
        ajax: {
            url: bos.con_user.base_url + '/seekJabatan',
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

    $('#optNIK').select2({
        ajax: {
            url: bos.con_user.base_url + '/PickNomorKaryawan',
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
		bos.con_user.initcomp() ;
		bos.con_user.initcallback() ;
		bos.con_user.initfunc() ;
	})
</script>