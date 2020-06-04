<div class="nav-tabs-custom">
   <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Jabatan</a></li>
      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Data Form</a></li>
   </ul>
   <div class="tab-content">
      <div class="tab-pane active full-height" id="tab_1">
         <div class="row">
            <div class="col-md-6">
               <div id="grid1" style="height:500px"></div>
            </div>
            <div class="col-md-6">
               <div id="grid2" style="height:500px"></div>
            </div>
         </div>
      </div>
      <div class="tab-pane" id="tab_2">
      <form>
         <div class="row">
            <div class="col-sm-10">
               <div class="form-group">
                  <label for="Divisi">Divisi</label>
                  <select class="form-control select2 sparent" data-sf="load_divisi"
                  name="optDivisi" id="optDivisi" data-placeholder="Divisi" required>
                  </select>
               </div>
            </div>
            <div class="col-sm-10">
               <div class="form-group">
                  <label>Nama Jabatan</label>
                  <input type="text" name="cNamaJabatan" id="cNamaJabatan" class="form-control" placeholder="Nama Jabatan" required>
               </div>
            </div>
         </div>
         <input type="hidden" name="cKodeDivisi" id="cKodeDivisi">
         <input type="hidden" name="cKodeJabatan" id="cKodeJabatan">
         <button class="btn btn-primary" id="cmdsave">Simpan</button>
      </form>
      </div>
   </div>
</div>
<script type="text/javascript">
   <?=cekbosjs();?>

   bos.mstjabatan.grid1_data    = null ;
   bos.mstjabatan.grid1_loaddata= function(){
      this.grid1_data      = {} ;
   }

   bos.mstjabatan.grid1_load    = function(){
      this.obj.find("#grid1").w2grid({
           name   : this.id + '_grid1',
           header : 'Daftar Divisi',
           limit  : 100 ,
           url    : bos.mstjabatan.base_url + "/loadgrid",
           postData: this.grid1_data ,
           show: {
            header      : true,
            footer      : true,
            lineNumbers : true 
           },
           multiSearch     : false,
           columns: [
               { field: 'Nama', caption: 'Nama Divisi', size: '150px', sortable: false},
               { field: 'cmdShow', caption: ' ', size: '80px', sortable: false },
           ]
       });
   }

   bos.mstjabatan.grid1_setdata   = function(){
      w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
   }
   bos.mstjabatan.grid1_reload    = function(){
      w2ui[this.id + '_grid1'].reload() ;
   }
   bos.mstjabatan.grid1_destroy   = function(){
      if(w2ui[this.id + '_grid1'] !== undefined){
         w2ui[this.id + '_grid1'].destroy() ;
      }
   }

   bos.mstjabatan.grid1_render    = function(){
      this.obj.find("#grid1").w2render(this.id + '_grid1') ;
   }

   bos.mstjabatan.grid1_reloaddata   = function(){
      this.grid1_loaddata() ;
      this.grid1_setdata() ;
      this.grid1_reload() ;
   }

   /********************************************************************************************* */

   // bos.tcfasilitasnasabah.gridDataFPK_data    =  {'cKodeRegister':''} ;
   // bos.tcfasilitasnasabah.gridDataFPK_loaddata = function(){
   //    var cKodeRegister       = this.obj.find("#cKodeRegister").val();
   //    this.gridDataFPK_data   = {'cKodeRegister':cKodeRegister} ;
   // }

   bos.mstjabatan.grid2_data    = {'cKodeDivisi':''} ;
   bos.mstjabatan.grid2_loaddata= function(){
      var cKodeDivisi      = this.obj.find("#cKodeDivisi").val();
      this.grid2_data      = {'cKodeDivisi':cKodeDivisi} ;
   }

   bos.mstjabatan.grid2_load    = function(){
      this.obj.find("#grid2").w2grid({
           name   : this.id + '_grid2',
           header : 'Daftar Jabatan Per Divisi',
           limit  : 100 ,
           url    : bos.mstjabatan.base_url + "/loadgrid_jabatan",
           postData: this.grid2_data ,
           show: {
            footer      : true,
            header      : true,
            lineNumbers : true 
           },
           columns: [
               { field: 'Keterangan', caption: 'Nama Jabatan', size: '150px', sortable: false},
               { field: 'Divisi', caption: 'Gol. Divisi', size: '150px', sortable: false},
               { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
               { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
           ]
       });
   }

   bos.mstjabatan.grid2_setdata   = function(){
      w2ui[this.id + '_grid2'].postData   = this.grid2_data ;
   }
   bos.mstjabatan.grid2_reload    = function(){
      w2ui[this.id + '_grid2'].reload() ;
   }
   bos.mstjabatan.grid2_destroy   = function(){
      if(w2ui[this.id + '_grid2'] !== undefined){
         w2ui[this.id + '_grid2'].destroy() ;
      }
   }

   bos.mstjabatan.grid2_render    = function(){
      this.obj.find("#grid2").w2render(this.id + '_grid2') ;
   }

   bos.mstjabatan.grid2_reloaddata   = function(){
      this.grid2_loaddata() ;
      this.grid2_setdata() ;
      this.grid2_reload() ;
   }

   /********************************************************************************************* */

   bos.mstjabatan.cmdedit      = function(id){
      bjs.ajax(this.url + '/editing', 'cKodeJabatan=' + id);
   }

   bos.mstjabatan.cmddelete    = function(kode){
      if(confirm("Delete Data?")){
         bjs.ajax(this.url + '/deleting', 'kode=' + kode);
      }
   }

   bos.mstjabatan.init         = function(){

      $('#optDivisi').sval("") ;
      $('#cNamaJabatan').val("") ;
      $('#cKodeDivisi').val("") ;
      $('#cKodeJabatan').val("") ;
      this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;

      bjs.ajax(this.url + '/init') ;
   }

   bos.mstjabatan.initcomp     = function(){
      this.grid1_loaddata() ;
      this.grid1_load() ;
      this.grid2_loaddata() ;
      this.grid2_load() ;
      bjs.initenter(this.obj.find("form")) ;
      bjs.initdate("#" + this.id + " .date") ;
      bjs.ajax(this.url + '/init') ;
   }

   bos.mstjabatan.initcallback = function(){
      this.obj.on('remove', function(){
         bos.mstjabatan.grid1_destroy() ;
         bos.mstjabatan.grid2_destroy() ;
      }) ;
   }

   bos.mstjabatan.cmdsave       = bos.mstjabatan.obj.find("#cmdsave") ;
   bos.mstjabatan.initfunc     = function(){
      this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
         if($(e.target).parent().index() == 0){//load grid
            bos.mstjabatan.grid1_reloaddata() ;
            bos.mstjabatan.grid2_reloaddata() ;
         }else{//focus
            bos.mstjabatan.obj.find("#optDivisi").focus() ;
         }
      });

      this.obj.find('form').on("submit", function(e){
         e.preventDefault() ;
         if( bjs.isvalidform(this) ){
            bjs.ajax( bos.mstjabatan.base_url + '/saving', bjs.getdataform(this) , bos.mstjabatan.cmdsave) ;
         }
      }) ;
   }

   $('#optDivisi').select2({
      allowClear: true,
      ajax: {
         url: bos.mstjabatan.base_url + '/SeekDivisi',
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

   bos.mstjabatan.cmdShow = function(id){
      $("#cKodeDivisi").val(id);
      this.grid2_reloaddata() ;
   }

   $(function(){
      bos.mstjabatan.initcomp() ;
      bos.mstjabatan.initcallback() ;
      bos.mstjabatan.initfunc() ;
   })

</script>