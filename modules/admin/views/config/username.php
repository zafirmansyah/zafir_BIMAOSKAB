<div class="row">
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
                            <label>cabang</label>
                            <select name="cabang" id="cabang" class="form-control" placeholder="Cabang" required>

                            </select>
                        </div>
                    </div>
		    		<div class="col-sm-6">
		    			<div class="form-group">
							<label for="level">Level</label>
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
<script type="text/javascript">
	if(typeof bos === "undefined") window.location.href = "<?=base_url()?>";

	bos.username.grid1_data 	= null ;
	bos.username.grid1_loaddata= function(){
	}

	bos.username.grid1_load	= function(){
		this.obj.find("#grusername").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.username.base_url + "/loadgrid",
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
	bos.username.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.username.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.username.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}
	bos.username.grid1_render 	= function(){
		this.obj.find("#grusername").w2render(this.id + '_grid1') ;
	}

	bos.username.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

	bos.username.cmdedit 		= function(username){
		bjs.ajax(this.base_url + '/editing', 'username=' + username);
	}

	bos.username.cmddelete 	= function(username){
		if(confirm("Delete Data?")){
			bjs.ajax(this.base_url + '/deleting', 'username=' + username);
		}
	}

	bos.username.init 			= function(){
		this.obj.find("#username").val("").attr("readonly", false).focus() ;
		this.obj.find("#fullname").val("") ;
        this.obj.find("#password").val("") ;
		this.obj.find("#level").sval({}) ;
		this.obj.find("#idlimage").html("") ;
		this.obj.find("#idimage").html("") ;
        this.obj.find("#cabang").sval({}) ;
		this.grid1_reloaddata() ;
		bjs.ajax(this.base_url + '/init') ;
	}

	bos.username.initcomp		= function(){
		this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initselect({
			class 		: "#" + this.id + " .select2.sparent"
		}) ;
		bjs.initenter(this.obj) ;

		bjs.ajax(this.base_url + '/init') ;
	}

	bos.username.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.username.grid1_destroy() ;
		}) ;
	}

   bos.username.cmdsave       = bos.username.obj.find("#cmdsave") ;
	bos.username.initfunc		= function(){
		setTimeout(function(){
			bos.username.obj.find('#username').focus() ;
		},1) ;
		this.obj.find("#username").on("blur", function(){
			bjs.ajax( bos.username.base_url + '/seekusername', 'username=' + $(this).val() ) ;
		});
		this.obj.find("#image").on("change", function(e){
			e.preventDefault() ;

            bos.username.cfile    = e.target.files ;
            bos.username.gfile    = new FormData() ;
            $.each(bos.username.cfile, function(cKey,cValue){
              bos.username.gfile.append(cKey,cValue) ;
            }) ;

            bos.username.obj.find("#idlimage").html("<i class='fa fa-spinner fa-pulse'></i>");
            bos.username.obj.find("#idimage").html("") ;

            bjs.ajaxfile(bos.username.base_url + "/saving_image", bos.username.gfile, this) ;

		})
		this.obj.find('form').on("submit", function(e){
         e.preventDefault() ;
			if( bjs.isvalidform(this) ){
				bjs.ajax( bos.username.base_url + '/saving', bjs.getdataform(this) , bos.username.cmdsave) ;
			}
		}) ;
	}
    
    $('#cabang').select2({
        ajax: {
            url: bos.username.base_url + '/seekcabang',
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
		bos.username.initcomp() ;
		bos.username.initcallback() ;
		bos.username.initfunc() ;
	})
</script>
