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
            <li><a id="linkUsers" href="#"><i class="fa fa-lock"></i> User</a></li>
            <li class="active"><a id="linkUserLevel" href="#"><i class="fa fa-random"></i> User Level</a></li>
            
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">User Level Access</h3>
        </div>
        <div class="box-body no-padding"> 
            <div class="col-sm-6">
                <div class="box box-info color-palette-box">
                    <div class="box-body">
                        <form>
                        <div class="row">
                            <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="code">Code</label>
                                        <input type="text" class="form-control" name="code" id="code"
                                        placeholder="Code ex: 0001-0009" maxlength="4" minlength="4" required>
                                    </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="dashboard">Dashboard</label>
                                    <select class="form-control select2" name="dashboard" id="dashboard" data-sf="loadmenu"
                                    placeholder="Dashboard" required></select>
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                    </div>
                    <input type="hidden" id="value" name="value">
                    <div id="menu" style="min-height:300px;max-height:350px;overflow:auto;border: 1px solid #eee"></div>
                    <hr />
                    <button id="cmdsave" class="btn btn-primary btn-block">Save</button>
                </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-default color-palette-box">
                    <div class="box-body">
                        <div id="grcon_userlevel" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<link rel="stylesheet" type="text/css" href="<?=base_url('bismillah/dynatree/ui.dynatree.css')?>">
<script  type="text/javascript" src="<?=base_url('bismillah/jQueryUI/jquery-ui-1.10.3.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('bismillah/jQuery/jquery.cookie.js')?>" ></script>
<script type="text/javascript" src="<?=base_url('bismillah/dynatree/jquery.dynatree.min.js')?>"></script>


<script type="text/javascript">
	if(typeof bos === "undefined") window.location.href = "<?=base_url()?>";

	bos.con_userlevel.grid1_data 	= null ;
	bos.con_userlevel.grid1_loaddata= function(){
	}

	bos.con_userlevel.grid1_load	= function(){
		this.obj.find("#grcon_userlevel").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.con_userlevel.base_url + "/loadgrid",
	        postData: this.grid1_data ,
	        show: {
	        	footer 		: true
	        },
	        columns: [
	        	{ field: 'code', caption: 'Code', size: '100px', sortable: false,style:'text-align:right;' },
	            { field: 'name', caption: 'Name', size: '150px', sortable: false },
	            { field: 'cmdedit', caption: ' ', size: '80px', sortable: false,style:'text-align:center;' },
	            { field: 'cmddelete', caption: ' ', size: '80px', sortable: false,style:'text-align:center;' }
	        ]
	    });
	}
	bos.con_userlevel.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.con_userlevel.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.con_userlevel.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}
	bos.con_userlevel.grid1_render 	= function(){
		this.obj.find("#grcon_userlevel").w2render(this.id + '_grid1') ;
	}

	bos.con_userlevel.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

	bos.con_userlevel.cmdedit 		= function(code){
		bjs.ajax(this.base_url + '/editing', 'code=' + code);
	}

	bos.con_userlevel.cmddelete 	= function(code){
		if(confirm("Delete Data?")){
			bjs.ajax(this.base_url + '/deleting', 'code=' + code);
		}
	}

	bos.con_userlevel.inittree 		= function(){
		this.obj.find("#menu").dynatree({
			checkbox: true,
			selectMode: 2,
			onSelect: function(select, node) {
				// Get a list of all selected nodes, and convert to a key array:
				var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
				  return node.data.key;
				});

				bos.con_userlevel.obj.find("#value").val(selKeys.join(","));
				// Get a list of all selected TOP nodes
				var selRootNodes = node.tree.getSelectedNodes(true);
				// ... and convert to a key array:
				var selRootKeys = $.map(selRootNodes, function(node){
				  return node.data.key;
				});
			},
			onKeydown: function(node, event) {
				if( event.which == 32 ) {
				  node.toggleSelect();
				  return false;
				}
			},
			cookieId: "dynatree-Cb3",
			idPrefix: "dynatree-Cb3-"
		});
	}

	bos.con_userlevel.init 			= function(){
        this.obj.find("#code").attr("readonly", false) ;
        this.obj.find("#code").val("") ;
        this.obj.find("#dashboard").sval("") ;
        this.obj.find("#name").val("") ;
        this.obj.find("#value").val("") ;
        this.obj.find("#menu").dynatree("getRoot").visit(function(node){
        node.select(false);
        }); 
        this.grid1_reloaddata() ;
        //bjs.ajax(this.base_url + '/init') ;
	}

	bos.con_userlevel.initcomp		= function(){
		this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initenter(this.obj) ;
		bjs.initselect({
			class	: "#" + this.id + " .select2",
			url 	: this.base_url
		}) ;

	}

	bos.con_userlevel.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.con_userlevel.grid1_destroy() ;
		}) ;
	}
   bos.con_userlevel.cmdsave       = bos.con_userlevel.obj.find("#cmdsave")
	bos.con_userlevel.initfunc		= function(){
		setTimeout(function(){
			bos.con_userlevel.obj.find('#code').focus() ;
		},1) ;
		this.obj.find("#code").on("blur", function(){
			if($(this).val() !== ""){
				bos.con_userlevel.obj.find("#dashboard").select2("open") ;
				bjs.ajax( bos.con_userlevel.base_url + '/editing', 'code=' + $(this).val()) ;
			}
		}) ;
		this.obj.find("#dashboard").on("select2:select", function(){
			bos.con_userlevel.obj.find("#name").focus() ;
		}) ;
		this.obj.find('form').on("submit", function(e){
         e.preventDefault() ;
			if( bjs.isvalidform(this) ){
				bjs.ajax( bos.con_userlevel.base_url + '/saving', bjs.getdataform(this) , bos.con_userlevel.cmdsave) ;
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
	}

	$(function(){
		bos.con_userlevel.initcomp() ;
		bos.con_userlevel.initcallback() ;
		bos.con_userlevel.initfunc() ;
		bos.con_userlevel.inittree() ;
	})
</script>
