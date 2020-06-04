<link rel="stylesheet" type="text/css" href="<?=base_url('bismillah/dynatree/ui.dynatree.css')?>">
<script  type="text/javascript" src="<?=base_url('bismillah/jQueryUI/jquery-ui-1.10.3.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('bismillah/jQuery/jquery.cookie.js')?>" ></script>
<script type="text/javascript" src="<?=base_url('bismillah/dynatree/jquery.dynatree.min.js')?>"></script>

<div class="row">
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
		    	<div id="grusername_lv" style="height: 400px"></div>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	if(typeof bos === "undefined") window.location.href = "<?=base_url()?>";

	bos.username_lv.grid1_data 	= null ;
	bos.username_lv.grid1_loaddata= function(){
	}

	bos.username_lv.grid1_load	= function(){
		this.obj.find("#grusername_lv").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.username_lv.base_url + "/loadgrid",
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
	bos.username_lv.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.username_lv.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.username_lv.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}
	bos.username_lv.grid1_render 	= function(){
		this.obj.find("#grusername_lv").w2render(this.id + '_grid1') ;
	}

	bos.username_lv.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

	bos.username_lv.cmdedit 		= function(code){
		bjs.ajax(this.base_url + '/editing', 'code=' + code);
	}

	bos.username_lv.cmddelete 	= function(code){
		if(confirm("Delete Data?")){
			bjs.ajax(this.base_url + '/deleting', 'code=' + code);
		}
	}

	bos.username_lv.inittree 		= function(){
		this.obj.find("#menu").dynatree({
			checkbox: true,
			selectMode: 2,
			onSelect: function(select, node) {
				// Get a list of all selected nodes, and convert to a key array:
				var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
				  return node.data.key;
				});

				bos.username_lv.obj.find("#value").val(selKeys.join(","));
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

	bos.username_lv.init 			= function(){
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

	bos.username_lv.initcomp		= function(){
		this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initenter(this.obj) ;
		bjs.initselect({
			class	: "#" + this.id + " .select2",
			url 	: this.base_url
		}) ;

	}

	bos.username_lv.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.username_lv.grid1_destroy() ;
		}) ;
	}
   bos.username_lv.cmdsave       = bos.username_lv.obj.find("#cmdsave")
	bos.username_lv.initfunc		= function(){
		setTimeout(function(){
			bos.username_lv.obj.find('#code').focus() ;
		},1) ;
		this.obj.find("#code").on("blur", function(){
			if($(this).val() !== ""){
				bos.username_lv.obj.find("#dashboard").select2("open") ;
				bjs.ajax( bos.username_lv.base_url + '/editing', 'code=' + $(this).val()) ;
			}
		}) ;
		this.obj.find("#dashboard").on("select2:select", function(){
			bos.username_lv.obj.find("#name").focus() ;
		}) ;
		this.obj.find('form').on("submit", function(e){
         e.preventDefault() ;
			if( bjs.isvalidform(this) ){
				bjs.ajax( bos.username_lv.base_url + '/saving', bjs.getdataform(this) , bos.username_lv.cmdsave) ;
			}
		}) ;
	}

	$(function(){
		bos.username_lv.initcomp() ;
		bos.username_lv.initcallback() ;
		bos.username_lv.initfunc() ;
		bos.username_lv.inittree() ;
	})
</script>
