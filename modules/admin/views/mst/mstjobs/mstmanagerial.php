<div class="nav-tabs-custom">
   <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Divisi <?=$nHariCuti?></a></li>
      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Data Form</a></li>
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
                  <label>Nama Divisi</label>
                  <input type="text" name="cNamaDivisi" id="cNamaDivisi" class="form-control" placeholder="Nama Divisi" required>
               </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group">
                  <label>Deskripsi</label>
                  <input type="text" name="cDeskripsi" id="cDeskripsi" class="form-control" placeholder="Deskripsi Divisi Pekerjaan" required>
               </div>
            </div>
         </div>
         <input type="hidden" id="cKode" name="cKode">
         <button class="btn btn-primary" id="cmdsave">Simpan</button>
      </form>
      </div>
   </div>
</div>
<script type="text/javascript">
   <?=cekbosjs();?>

   bos.mstjobtitle.grid1_data    = null ;
   bos.mstjobtitle.grid1_loaddata= function(){
      this.grid1_data      = {} ;
   }

   bos.mstjobtitle.grid1_load    = function(){
      this.obj.find("#grid1").w2grid({
           name   : this.id + '_grid1',
           limit  : 100 ,
           url    : bos.mstjobtitle.base_url + "/loadgrid",
           postData: this.grid1_data ,
           show: {
            footer      : true,
            toolbar     : true,
            toolbarColumns  : false,
            lineNumbers    : true,
           },
           multiSearch     : false,
           columns: [
               { field: 'Nama', caption: 'Nama Divisi', size: '150px', sortable: false},
               { field: 'Deskripsi', caption: 'Deskripsi', size: '200px', sortable: false },
               { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
               { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
           ]
       });
   }

   bos.mstjobtitle.grid1_setdata   = function(){
      w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
   }
   bos.mstjobtitle.grid1_reload    = function(){
      w2ui[this.id + '_grid1'].reload() ;
   }
   bos.mstjobtitle.grid1_destroy   = function(){
      if(w2ui[this.id + '_grid1'] !== undefined){
         w2ui[this.id + '_grid1'].destroy() ;
      }
   }

   bos.mstjobtitle.grid1_render    = function(){
      this.obj.find("#grid1").w2render(this.id + '_grid1') ;
   }

   bos.mstjobtitle.grid1_reloaddata   = function(){
      this.grid1_loaddata() ;
      this.grid1_setdata() ;
      this.grid1_reload() ;
   }

   bos.mstjobtitle.cmdedit      = function(id){
      bjs.ajax(this.url + '/editing', 'cKode=' + id);
   }

   bos.mstjobtitle.cmddelete    = function(kode){
      if(confirm("Delete Data?")){
         bjs.ajax(this.url + '/deleting', 'kode=' + kode);
      }
   }

   bos.mstjobtitle.init         = function(){
      this.obj.find("#cKode").val("") ;
      this.obj.find("#cNamaDivisi").val("") ;
      this.obj.find("#cDeskripsi").val("") ;
      bjs.ajax(this.url + '/init') ;

      this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
   }

   bos.mstjobtitle.initcomp     = function(){
      this.grid1_loaddata() ;
      this.grid1_load() ;
      bjs.initenter(this.obj.find("form")) ;
      bjs.initdate("#" + this.id + " .date") ;
      bjs.ajax(this.url + '/init') ;
   }

   bos.mstjobtitle.initcallback = function(){
      this.obj.on('remove', function(){
         bos.mstjobtitle.grid1_destroy() ;
      }) ;
   }

   bos.mstjobtitle.cmdsave       = bos.mstjobtitle.obj.find("#cmdsave") ;
   bos.mstjobtitle.initfunc     = function(){
      this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
         if($(e.target).parent().index() == 0){//load grid
            bos.mstjobtitle.grid1_reloaddata() ;
         }else{//focus
            bos.mstjobtitle.obj.find("#nik").focus() ;
         }
      });

      this.obj.find('form').on("submit", function(e){
         e.preventDefault() ;
         if( bjs.isvalidform(this) ){
            bjs.ajax( bos.mstjobtitle.base_url + '/saving', bjs.getdataform(this) , bos.mstjobtitle.cmdsave) ;
         }
      }) ;
   }

   $(function(){
      bos.mstjobtitle.initcomp() ;
      bos.mstjobtitle.initcallback() ;
      bos.mstjobtitle.initfunc() ;
   })

</script>