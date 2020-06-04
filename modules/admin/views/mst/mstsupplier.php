<div class="nav-tabs-custom">
   <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Supplier</a></li>
      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Supplier</a></li>
   </ul>
   <div class="tab-content">
      <div class="tab-pane active full-height" id="tab_1">
         <div id="grid1" style="height:500px"></div>
      </div>
      <div class="tab-pane" id="tab_2">
      <form>
         <div class="row">
            <div class="col-sm-2">
               <div class="form-group">
                  <label>Kode</label>
                  <input type="text" name="kode" id="kode" class="form-control" placeholder="Kode" required>
               </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="nama" required>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group">
                  <label>No. Telepon</label>
                  <input type="text" name="notelepon" id="notelepon" class="form-control" placeholder="08123456789">
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" id="email" class="form-control" placeholder="info@mail.com" >
               </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat">
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

   bos.mstsupplier.grid1_data    = null ;
   bos.mstsupplier.grid1_loaddata= function(){
      this.grid1_data 		= {} ;
   }

   bos.mstsupplier.grid1_load    = function(){
      this.obj.find("#grid1").w2grid({
	        name	: this.id + '_grid1',
	        limit 	: 100 ,
	        url 	: bos.mstsupplier.base_url + "/loadgrid",
	        postData: this.grid1_data ,
	        show: {
	        	footer 		: true,
	        	toolbar		: true,
            toolbarColumns  : false
	        },
	        multiSearch		: false,
	        columns: [
	        	{ field: 'kode', caption: 'Kode', size: '150px', sortable: false},
	            { field: 'nama', caption: 'Nama', size: '200px', sortable: false },
	            { field: 'notelepon', caption: 'No. Telepon', size: '200px', sortable: false },
	            { field: 'email', caption: 'e-Mail', size: '200px', sortable: false },
	            { field: 'alamat', caption: 'Alamat', size: '200px', sortable: false },
	            { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
	            { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
	        ]
	    });
   }

   bos.mstsupplier.grid1_setdata	= function(){
		w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
	}
	bos.mstsupplier.grid1_reload		= function(){
		w2ui[this.id + '_grid1'].reload() ;
	}
	bos.mstsupplier.grid1_destroy 	= function(){
		if(w2ui[this.id + '_grid1'] !== undefined){
			w2ui[this.id + '_grid1'].destroy() ;
		}
	}

	bos.mstsupplier.grid1_render 	= function(){
		this.obj.find("#grid1").w2render(this.id + '_grid1') ;
	}

	bos.mstsupplier.grid1_reloaddata	= function(){
		this.grid1_loaddata() ;
		this.grid1_setdata() ;
		this.grid1_reload() ;
	}

   bos.mstsupplier.cmdedit 		= function(kode){
		bjs.ajax(this.url + '/editing', 'kode=' + kode);
	}

	bos.mstsupplier.cmddelete 	= function(kode){
		if(confirm("Delete Data?")){
			bjs.ajax(this.url + '/deleting', 'kode=' + kode);
		}
	}

	bos.mstsupplier.init 			= function(){
      this.obj.find("#kode").val("") ;
      this.obj.find("#nama").val("") ;
      this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;

      bjs.ajax(this.url + '/init') ;
	}

	bos.mstsupplier.initcomp		= function(){
		this.grid1_loaddata() ;
		this.grid1_load() ;
		bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
		bjs.ajax(this.url + '/init') ;
	}

	bos.mstsupplier.initcallback	= function(){
		this.obj.on('remove', function(){
			bos.mstsupplier.grid1_destroy() ;
		}) ;
	}

   bos.mstsupplier.cmdsave       = bos.mstsupplier.obj.find("#cmdsave") ;
	bos.mstsupplier.initfunc	   = function(){
      this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
         if($(e.target).parent().index() == 0){//load grid
            bos.mstsupplier.grid1_reloaddata() ;
         }else{//focus
            bos.mstsupplier.obj.find("#nik").focus() ;
         }
      });

		this.obj.find('form').on("submit", function(e){
         e.preventDefault() ;
         if( bjs.isvalidform(this) ){
				bjs.ajax( bos.mstsupplier.base_url + '/saving', bjs.getdataform(this) , bos.mstsupplier.cmdsave) ;
			}
		}) ;
	}

	$(function(){
		bos.mstsupplier.initcomp() ;
		bos.mstsupplier.initcallback() ;
		bos.mstsupplier.initfunc() ;
	})

</script>
