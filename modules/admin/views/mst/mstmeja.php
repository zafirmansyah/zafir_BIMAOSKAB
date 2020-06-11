<div class="nav-tabs-custom">
   <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Meja</a></li>
      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Meja</a></li>
   </ul>
   <div class="tab-content">
      <div class="tab-pane active full-height" id="tab_1">
         <div id="grid1" style="height:500px"></div>
      </div>
      <div class="tab-pane" id="tab_2">
      <form>
         <div class="row">
            <div class="col-sm-10">
               <div class="form-group">
                  <label>Kode</label>
                  <input type="text" name="kode" id="kode" class="form-control" placeholder="Kode" required>
               </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" required>
               </div>
            </div>
         </div>
         <button class="btn btn-primary" id="cmdsave">Simpan</button>
      </form>
      </div>
   </div>
</div>
<script type="text/javascript">
   <?=cekbosjs();?>

   bos.mstmeja.grid1_data    = null ;
   bos.mstmeja.grid1_loaddata= function(){
      this.grid1_data 		= {} ;
   }

   bos.mstmeja.grid1_load    = function(){
      this.obj.find("#grid1").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.mstmeja.base_url + "/loadgrid",
	        postData: this.grid1_data ,
	        show: {
	        	footer 		: true,
	        	toolbar		: true,
            toolbarColumns  : false
	        },
	        multiSearch		: false,
	        columns: [
	        	{ field: 'kode', caption: 'Kode', size: '150px', sortable: false},
	            { field: 'keterangan', caption: 'Keterangan', size: '200px', sortable: false },
	            { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
	            { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
	        ]
	    });
   }

   bos.mstmeja.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.mstmeja.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.mstmeja.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}

	bos.mstmeja.grid1_render 	= function(){
		this.obj.find("#grid1").w2render(this.id + '_grid1') ;
	}

	bos.mstmeja.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

   bos.mstmeja.cmdedit 		= function(kode){
		bjs.ajax(this.url + '/editing', 'kode=' + kode);
	}

	bos.mstmeja.cmddelete 	= function(kode){
		if(confirm("Delete Data?")){
			bjs.ajax(this.url + '/deleting', 'kode=' + kode);
		}
	}

	bos.mstmeja.init 			= function(){
      this.obj.find("#kode").val("") ;
      this.obj.find("#keterangan").val("") ;
      this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;

      bjs.ajax(this.url + '/init') ;
	}

	bos.mstmeja.initcomp		= function(){
		this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initenter(this.obj.find("form")) ;
      bjs.initdate("#" + this.id + " .date") ;
		bjs.ajax(this.url + '/init') ;
	}

	bos.mstmeja.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.mstmeja.grid1_destroy() ;
		}) ;
	}

   bos.mstmeja.cmdsave       = bos.mstmeja.obj.find("#cmdsave") ;
	bos.mstmeja.initfunc	   = function(){
      this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
         if($(e.target).parent().index() == 0){//load grid
            bos.mstmeja.grid1_reloaddata() ;
         }else{//focus
            bos.mstmeja.obj.find("#nik").focus() ;
         }
      });

		this.obj.find('form').on("submit", function(e){
         e.preventDefault() ;
         if( bjs.isvalidform(this) ){
				bjs.ajax( bos.mstmeja.base_url + '/saving', bjs.getdataform(this) , bos.mstmeja.cmdsave) ;
			}
		}) ;
	}

	$(function(){
		bos.mstmeja.initcomp() ;
		bos.mstmeja.initcallback() ;
		bos.mstmeja.initfunc() ;
	})

</script>
