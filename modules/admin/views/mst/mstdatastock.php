<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Daftar Stock</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Stock</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:500px"></div>
        </div>
        <div class="tab-pane" id="tab_2">
            <form>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="kode" id="kode" class="form-control" placeholder="Kode" readonly =  true required>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Group</label>
                            <select name="group" id="group" class="form-control" placeholder="Group Stock" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Satuan</label>
                            <select name="satuan" id="satuan" class="form-control" placeholder="Satuan Stock" required>

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" style="text-align:right;" name="hargajual" id="hargajual" class="form-control" placeholder="0.00">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="image">Foto <span id="idlimage"></span></label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>
                        <div class="col-sm-6" id="idimage" style="text-align:center;"></div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Paket (*hanya untuk menu paket)</label>
                            <div id="boxpaket" class = "box box-success">
                                <div class = "box-body">
                                    <input  type="checkbox" id="ckpilihsemua" onclick ="bos.mstdatastock.grid2_checkheader(this)"> Pilih Semua
                                    <div id="grid2" style="height:300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button class="btn btn-primary" id="cmdsave">Simpan</button>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="cmdbatal">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    <?=cekbosjs();?>

    bos.mstdatastock.grid1_data    = null ;
    bos.mstdatastock.grid1_loaddata= function(){
        this.grid1_data 		= {} ;
    }

    bos.mstdatastock.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name	: this.id + '_grid1',
            limit 	: 100 ,
            url 	: bos.mstdatastock.base_url + "/loadgrid",
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
                { field: 'KetStockGroup', caption: 'Stock Group', size: '150px', sortable: false },
                { field: 'satuan', caption: 'Satuan', size: '150px', sortable: false },
                { field: 'hargajual', caption: 'Harga Jual', size: '150px', sortable: false, style:"text-align:right"},
                { field: 'cmdedit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmddelete', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.mstdatastock.grid1_setdata	= function(){
        w2ui[this.id + '_grid1'].postData 	= this.grid1_data ;
    }
    bos.mstdatastock.grid1_reload		= function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.mstdatastock.grid1_destroy 	= function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.mstdatastock.grid1_render 	= function(){$('#ckpilihsemua').
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.mstdatastock.grid1_reloaddata	= function(){
        this.grid1_loaddata() ;
        this.grid1_setdata() ;
        this.grid1_reload() ;
    }

    //grid 2
    bos.mstdatastock.grid2_data    = null ;
    bos.mstdatastock.grid2_lreload    = true ;
    bos.mstdatastock.grid2_loaddata= function(){
        this.grid2_data 		= {} ;
    }
    bos.mstdatastock.datagrid    = true;
    bos.mstdatastock.grid2_load    = function(){
      this.obj.find("#grid2").w2grid({
            name	: this.id + '_grid2',
            method  : 'GET',
            url 	: bos.mstdatastock.base_url + "/loadgrid2",
            postData: this.grid2_data ,
	        show: {
	        	footer 		: true,
	        	toolbar		: false,
            toolbarColumns  : false
	        },
	        columns: [
                { field: 'ck', caption: '', size: '30px', sortable: false,
                    render: function(record){
                        return '<div style = "text-align:center">'+
                            ' <input type="checkbox"'+(record.ck ? 'checked' : '')+
                            '  onclick="var obj = w2ui[\''+this.name+'\'];obj.set(\''+record.recid+'\',{ck:this.checked});(this.checked) ? obj.set(\''+record.recid+'\',{qty:1}) : obj.set(\''+record.recid+'\',{qty:0});">'+
                            '</div>';
                    }
                },
                { field: 'no', caption: 'No', size: '30px', sortable: false,style:"text-align:right"},
	            { field: 'kode', caption: 'Stock', size: '80px', sortable: false },
                { field: 'keterangan', caption: 'Nama Stock', size: '100px', sortable: false },
                { field: 'qty', caption: 'Qty', size: '50px', sortable: false, style:"text-align:right",
                    render: function(record){
                       return '<div style = "text-align:center">'+
                                ' <input type="number" style="width:40px" value='+record.qty+
                                '  onChange="var obj = w2ui[\''+this.name+'\'];obj.set(\''+record.recid+'\',{qty:this.value});">'+
                                '</div>';
                    }
                },
                { field: 'satuan', caption: 'Satuan', size: '70px', sortable: false}
                ],
          checkck: function(l){
               this.set({ck:l});
          }
      });
    }

    bos.mstdatastock.grid2_destroy 	= function(){
		if(w2ui[this.id + '_grid2'] !== undefined){
			w2ui[this.id + '_grid2'].destroy() ;
		}
	}

    bos.mstdatastock.grid2_setdata	= function(){
        w2ui[this.id + '_grid2'].postData 	= this.grid2_data ;
    }

    bos.mstdatastock.grid2_reload		= function(){
		w2ui[this.id + '_grid2'].reload() ;
	}

    bos.mstdatastock.grid2_render 	= function(){
        this.obj.find("#grid2").w2render(this.id + '_grid2') ;
    }

    bos.mstdatastock.grid2_reloaddata	= function(){
        this.grid2_loaddata() ;
        this.grid2_setdata() ;
        this.grid2_reload() ;
    }
    bos.mstdatastock.grid2_checkheader 	= function(e){
        w2ui[this.id + '_grid2'].checkck(e.checked);

        $('#ckpilihsemua').checked = e.checked;
    }

    bos.mstdatastock.cmdedit 		= function(kode){
        bjs.ajax(this.url + '/editing', 'kode=' + kode);
    }

    bos.mstdatastock.cmddelete 	= function(kode){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'kode=' + kode);
        }
    }

    bos.mstdatastock.init 			= function(){
        this.obj.find("#kode").val("") ;
        this.obj.find("#keterangan").val("") ;
        this.obj.find("#hargajual").val("") ;
        this.obj.find("#group").sval("") ;
        this.obj.find("#satuan").sval("") ;
        this.obj.find("#ckpilihsemua").checked = false;
        this.obj.find("#ckpaket").checked = false;
        this.obj.find("#idlimage").html("") ;
        this.obj.find("#idimage").html("") ;
        this.obj.find("#image").val("") ;
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bjs.ajax(this.url + '/init') ;
        bjs.ajax(this.url + '/getkode') ;
        bos.mstdatastock.grid2_lreload = true;
    }

    bos.mstdatastock.initcomp		= function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;
        bjs.ajax(this.url + '/init') ;
        bjs.ajax(this.url + '/getkode') ;
        
        this.grid1_loaddata() ;
        this.grid1_load() ;
        
        this.grid2_loaddata() ;
        this.grid2_load() ;

    }

    bos.mstdatastock.initcallback	= function(){
        this.obj.on('remove', function(){
            bos.mstdatastock.grid1_destroy() ;
            bos.mstdatastock.grid2_destroy() ;
        }) ;
    }

    bos.mstdatastock.loadmodelpaket      = function(l){
      this.obj.find("#wrap-paket-d").modal(l) ;
    }

    bos.mstdatastock.cmdsave       = bos.mstdatastock.obj.find("#cmdsave") ;
    bos.mstdatastock.initfunc	   = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.mstdatastock.grid1_reloaddata() ;
            }else{//focus
                bos.mstdatastock.obj.find("#keterangan").focus() ;
                if(bos.mstdatastock.grid2_lreload){
                    bos.mstdatastock.grid2_reloaddata() ;
                }

            }
        });

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                var datagrid2 =  w2ui['bos-form-mstdatastock_grid2'].records;
                datagrid2 = JSON.stringify(datagrid2);
                bjs.ajax( bos.mstdatastock.base_url + '/saving', bjs.getdataform(this)+"&grid2="+datagrid2, bos.mstdatastock.cmdsave) ;
            }
        }) ;

        this.obj.find("#cmdbatal").on("click", function(e){
            bos.mstdatastock.init();
        }) ;

        this.obj.find("#cmdok").on("click", function(e){
            bos.mstdatastock.loadmodelpaket("hide");
        }) ;

        this.obj.find("#image").on("change", function(e){
            e.preventDefault() ;

            bos.mstdatastock.cfile    = e.target.files ;
            bos.mstdatastock.gfile    = new FormData() ;
            $.each(bos.mstdatastock.cfile, function(cKey,cValue){
              bos.mstdatastock.gfile.append(cKey,cValue) ;
            }) ;

            bos.mstdatastock.obj.find("#idlimage").html("<i class='fa fa-spinner fa-pulse'></i>");
            bos.mstdatastock.obj.find("#idimage").html("") ;

            bjs.ajaxfile(bos.mstdatastock.base_url + "/saving_image", bos.mstdatastock.gfile, this) ;

        })
    }

    $('#satuan').select2({
        ajax: {
            url: bos.mstdatastock.base_url + '/seeksatuan',
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

    $('#group').select2({
        ajax: {
            url: bos.mstdatastock.base_url + '/seekgroup',
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
        bos.mstdatastock.initcomp() ;
        bos.mstdatastock.initcallback() ;
        bos.mstdatastock.initfunc() ;

    })

</script>
