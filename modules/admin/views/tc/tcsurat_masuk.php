<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false" onClick="bos.tcsurat_masuk.init()">Daftar Data</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" onClick="bos.tcsurat_masuk.initForm()">Data Form</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active full-height" id="tab_1">
            <div id="grid1" style="height:500px"></div>
            <div class="row">
                <div class="col-md-12">
                    Download File : <b><div id="downloadLink"></div></b>                
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab_2">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active" id="tab-link1"><a href="#tab_form_1" data-toggle="tab" aria-expanded="false">Data Dokumen</a></li>
                    <li class="" id="tab-link2"><a href="#tab_form_2" data-toggle="tab" aria-expanded="true">Lembar Disposisi</a></li>
                </ul>
                <form>
                <div class="tab-content">
                    <div class="tab-pane active full-height" id="tab_form_1">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label>Dokumen Masuk Dari</label>
                                    <input type="text" name="cSuratDari" id="cSuratDari" class="form-control" maxlength="225" placeholder="Surat Dari..." required>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label>Perihal Dokumen</label>
                                    <input type="text" name="cPerihal" id="cPerihal" class="form-control" maxlength="225" placeholder="Perihal" required>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label>Nomor Dokumen</label>
                                    <input type="text" name="cNomorSurat" id="cNomorSurat" class="form-control" maxlength="225" placeholder="Nomor Surat Masuk" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Dokumen Masuk</label>
                                    <div class="col-xs-8 input-group">
                                        <input
                                            type="text" 
                                            class=" form-control date" 
                                            id="dTgl" 
                                            name="dTgl" 
                                            placeholder="dd-mm-yyyy"
                                            required
                                            value=<?=date("d-m-Y")?> <?=date_set()?> 
                                        >
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Penulisan Dokumen</label>
                                    <div class="col-xs-8 input-group">
                                        <input
                                            type="text" 
                                            class=" form-control date" 
                                            id="dTglSurat" 
                                            name="dTglSurat" 
                                            placeholder="dd-mm-yyyy"
                                            required
                                            value=<?=date("d-m-Y")?> <?=date_set()?> 
                                        >
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label>Jenis Dokumen</label>
                                    <select class="form-control optJenisSurat select2" data-sf="load_Kota" name="optJenisSurat" id="optJenisSurat" data-placeholder=" - Jenis Dokumen - "></select>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label>Disposisi</label>
                                    <textarea name="cDeskripsi" id="cDeskripsi" cols="20" rows="10" placeholder="Deskripsi Disposisi..."></textarea>                   
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Disposisi</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" id="cDisposisi" name="cDisposisi" class="form-control" placeholder="Klik tombol pencarian untuk memasukkan data disposisi..." readonly>
                                    <span class="input-group-btn">
                                        <button class="form-control btn btn-info" type="button" id="cmdDisposisi"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-primary" id="cmdOK">OK</button>
                            </div>
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="col-md-12">
                                <div id="gridDisposisi" class="full-height" style="height: 200px;"></div>
                            </div>
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Upload File</label>
                                    <div id="idcUplFile">
                                        <input style="width:100%" type="file" class="form-control cUplFile" id="cUplFile" name="cUplFile[]" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane lembar-disposisi" id="tab_form_2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="chckLampiran[]" value="SangatSegera" id="chckSangatSegera">
                                        <label for="chckSangatSegera">Sangat Segera</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="chckLampiran[]" value="Segera" id="chckSegera">
                                        <label for="chckSegera">Segera</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-top:15px;">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="">Deputi Kepala Perwakilan</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">&nbsp;</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Petunjuk Disposisi</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="chckLampiran[]" value="TimIR" id="chckTimIR">
                                        <label for="chckTimIR">Tim Implementasi Rekda</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="checkbox" name="chckLampiran[]" value="FungsiDSEK" id="chckFungsiDSEK">
                                        <label for="chckFungsiDSEK">Fungsi Data & Statistik Ekonomi & Keuangan</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="checkbox" name="chckLampiran[]" value="Setuju" id="chckSetuju">
                                        <label for="chckSetuju">Setuju</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-4">
                                        <input type="checkbox" name="chckLampiran[]" value="FungsiPPUKS" id="chckFungsiPPUKS">
                                        <label for="chckFungsiPPUKS">Fungsi Pelaksanaan Pengembangan UMKM, KI, dan Syariah</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="checkbox" name="chckLampiran[]" value="Tolak" id="chckTolak">
                                        <label for="chckTolak">Tolak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-4">
                                        <input type="checkbox" name="chckLampiran[]" value="SeksiHumas" id="chckSeksiHumas">
                                        <label for="chckSeksiHumas">Seksi Kehumasan</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDiteliti" id="chckUntukDiteliti">
                                        <label for="chckUntukDiteliti">Untuk di teliti & pendapat</label>
                                    </div>
                                </div>
                            </div>
                            <hr width="95%" style="margin: 0 auto;border-top: 1px solid #555;"/>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="chckLampiran[]" value="TimISPM" id="chckTimISPM">
                                        <label for="chckTimISPM">Tim Implementasi SP, PUR, dan MI</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="checkbox" name="chckLampiran[]" value="UnitIPUR" id="chckUnitIPUR">
                                        <label for="chckUnitIPUR">Unit Implementasi PUR</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDiketahui" id="chckUntukDiketahui">
                                        <label for="chckUntukDiketahui">Untuk diketahui</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-4" style="display:flex;">
                                        <input type="checkbox" name="chckLampiran[]" value="UnitIKSPPUR" id="chckUnitIKSPPUR">
                                        <label for="chckUnitIKSPPUR">Unit Implementasi Kebijakan SP dan Pengawasan SP-PUR</label>
                                    </div>
                                    <div class="col-sm-3" style="display:flex;">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDiselesaikan" id="chckUntukDiselesaikan">
                                        <label for="chckUntukDiselesaikan">Untuk di selesaikan sesuai ketentuan </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-4">
                                        <input type="checkbox" name="chckLampiran[]" value="UnitManajemen" id="chckUnitManajemen">
                                        <label for="chckUnitManajemen">Unit Manajemen Internera</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="checkbox" name="chckLampiran[]" value="SesuaiCatatan" id="chckSesuaiCatatan">
                                        <label for="chckSesuaiCatatan">Sesuai Catatan</label>
                                    </div>
                                </div>
                            </div>
                            <hr width="95%" style="margin: 0 auto;border-top: 1px solid #555;"/>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="chckLampiran[]" value="PM" id="chckPM">
                                        <label for="chckPM">PM</label>
                                    </div>
                                    <div class="col-sm-3 col-sm-offset-5">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukPerhatian" id="chckUntukPerhatian">
                                        <label for="chckUntukPerhatian">Untuk perhatian </label>
                                    </div>
                                </div>
                            </div>
                            <hr width="95%" style="margin: 0 auto;border-top: 1px solid #555;"/>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="chckLampiran[]" value="ICO" id="chckICO">
                                        <label for="chckICO">ICO</label>
                                    </div>
                                    <div class="col-sm-3 col-sm-offset-5">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDiedarkan" id="chckUntukDiedarkan">
                                        <label for="chckUntukDiedarkan">Untuk diedarkan </label>
                                    </div>
                                </div>
                            </div>
                            <hr width="95%" style="margin: 0 auto;border-top: 1px solid #555;"/>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="chckLampiran[]" value="KetuaIPEBI" id="chckKetuaIPEBI">
                                        <label for="chckKetuaIPEBI">Ketua IPEBI</label>
                                    </div>
                                    <div class="col-sm-3 col-sm-offset-5">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDijawab" id="chckUntukDijawab">
                                        <label for="chckUntukDijawab">Untuk dijawab </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDiperbaiki" id="chckUntukDiperbaiki">
                                        <label for="chckUntukDiperbaiki">Untuk diperbaiki </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDibicarakanDgnSaya" id="chckUntukDibicarakanDgnSaya">
                                        <label for="chckUntukDibicarakanDgnSaya">untuk dibicarakan dengan Saya </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDibicarakanBersama" id="chckUntukDibicarakanBersama">
                                        <label for="chckUntukDibicarakanBersama">Untuk dibicarakan bersama  </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDiingatkan" id="chckUntukDiingatkan">
                                        <label for="chckUntukDiingatkan">untuk diingatkan </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDisimpan" id="chckUntukDisimpan">
                                        <label for="chckUntukDisimpan">Untuk disimpan </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDisiapkan" id="chckUntukDisiapkan">
                                        <label for="chckUntukDisiapkan">Untuk disiapkan </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDijadwalkan" id="chckUntukDijadwalkan">
                                        <label for="chckUntukDijadwalkan">Untuk dijadwalkan </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <input type="checkbox" name="chckLampiran[]" value="UntukDihadiri" id="chckUntukDihadiri">
                                        <label for="chckUntukDihadiri">Untuk dihadiri / Wakil </label>
                                    </div>
                                </div>
                            </div>
                            <hr width="95%" style="margin: 0 auto;border-top: 1px solid #555;"/>
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px;">
                        <div class="col-lg-12">
                            <input type="hidden" name="nNo" id="nNo" value="0">
                            <input type="hidden" name="cKodeKaryawan" id="cKodeKaryawan">
                            <input type="hidden" name="cKode" id="cKode">
                            <input type="hidden" name="cLastPath" id="cLastPath">
                            <button class="btn btn-primary" id="cmdSave">Simpan</button>
                            <button class="btn btn-warning" id="cmdCancel" onClick="bos.tcsurat_masuk.init()">Cancel</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDisposisi" role="dialog" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="wm-title">Daftar Nama Pegawai</h4>
            </div>
            <div class="modal-body">
                <div id="grid3" style="height:250px"></div>
            </div>
            <div class="modal-footer">
                *Pilih Nama Pegawai
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
<?=cekbosjs();?>

    bos.tcsurat_masuk.grid1_data    = null ;
    bos.tcsurat_masuk.grid1_loaddata= function(){
        this.grid1_data      = {} ;
    }

    bos.tcsurat_masuk.grid1_load    = function(){
        this.obj.find("#grid1").w2grid({
            name     : this.id + '_grid1',
            limit    : 100 ,
            url      : bos.tcsurat_masuk.base_url + "/loadgrid",
            postData : this.grid1_data ,
            header   : 'Daftar Surat Masuk',
            show: {
                header      : true,
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false,
                lineNumbers    : true,
            },
            multiSearch     : false,
            columns: [
                { field: 'NoSurat', caption: 'Nomor Surat', size: '150px', sortable: false},
                { field: 'Dari', caption: 'Surat Dari', size: '250px', sortable: false},
                { field: 'Perihal', caption: 'Perihal Surat', size: '250px', sortable: false},
                { field: 'Tgl', caption: 'Tanggal', size: '80px', sortable: false},
                { field: 'UserName', caption: 'Petugas Entry', size: '100px', sortable: false},
                { field: 'cmdEdit', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdDelete', caption: ' ', size: '80px', sortable: false },
                { field: 'cmdPrint', caption: 'Opsi', size: '100px', sortable: false}
            ]
        });
    }

    bos.tcsurat_masuk.grid1_setdata   = function(){
        w2ui[this.id + '_grid1'].postData   = this.grid1_data ;
    }

    bos.tcsurat_masuk.grid1_reload    = function(){
        w2ui[this.id + '_grid1'].reload() ;
    }
    bos.tcsurat_masuk.grid1_destroy   = function(){
        if(w2ui[this.id + '_grid1'] !== undefined){
            w2ui[this.id + '_grid1'].destroy() ;
        }
    }

    bos.tcsurat_masuk.grid1_render    = function(){
        this.obj.find("#grid1").w2render(this.id + '_grid1') ;
    }

    bos.tcsurat_masuk.grid1_reloaddata   = function(){
        this.grid1_setdata() ;
    }

    /******************************************** */

    bos.tcsurat_masuk.gridDisposisi_load    = function(){
        this.obj.find("#gridDisposisi").w2grid({
            name    : this.id + '_gridDisposisi',
            show: {
                footer      : true,
                toolbar     : false,
                toolbarColumns  : false,
                lineNumbers: true
            },
            columns: [
                { field: 'level', caption: 'Urutan Tujuan', size: '100px', sortable: false },
                { field: 'kode', caption: 'Kode Karyawan', size: '150px', sortable: false },
                { field: 'disposisi', caption: 'Nama Karyawan', size: '200px', sortable: false },
                { field: 'cmdDeleteGr', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcsurat_masuk.gridDisposisi_destroy     = function(){
        if(w2ui[this.id + '_gridDisposisi'] !== undefined){
            w2ui[this.id + '_gridDisposisi'].destroy() ;
        }
    }

    bos.tcsurat_masuk.gridDisposisi_reload      = function(){
        w2ui[this.id + '_gridDisposisi'].reload() ;
    }

    bos.tcsurat_masuk.gridDisposisi_append    = function(no,kodekaryawan,disposisi){
        var datagrid  = w2ui[this.id + '_gridDisposisi'].records;
        var recid     = "";
        // alert(no +"  "+datagrid.length);
        if(no == 0) no+=1;
        no = parseInt(no);
        if(no <= datagrid.length){
            recid = no;
            w2ui[this.id + '_gridDisposisi'].set(recid,{level: no, 
                                                        kode:kodekaryawan, 
                                                        disposisi: disposisi});
        }else{
            recid = no;
            var Hapus = "<button type='button' onclick = 'bos.tcsurat_masuk.gridDisposisi_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridDisposisi'].add([
                {   recid:recid,
                    level: no,
                    kode:kodekaryawan,
                    disposisi:disposisi,
                    cmdDeleteGr:Hapus}
            ]) ;
        }
        bos.tcsurat_masuk.initDetail();
        bos.tcsurat_masuk.obj.find("#cmdDisposisi").focus() ;
    }

    bos.tcsurat_masuk.gridDisposisi_deleterow = function(recid){
        if(confirm("Anda yakin untuk menghilangkan data pada nomor "+ recid +" ini ???")){
            w2ui[this.id + '_gridDisposisi'].select(recid);
            w2ui[this.id + '_gridDisposisi'].delete(true);
            bos.tcsurat_masuk.gridDisposisi_urutkan();
            bos.tcsurat_masuk.initDetail();

        }
    }

    bos.tcsurat_masuk.gridDisposisi_render  = function(){
        this.obj.find("#gridDisposisi").w2render(this.id + '_gridDisposisi') ;
    }

    bos.tcsurat_masuk.gridDisposisi_clear   = function(){
        w2ui[this.id + '_gridDisposisi'].clear();
    }

    bos.tcsurat_masuk.gridDisposisi_urutkan = function(){
        var datagrid = w2ui[this.id + '_gridDisposisi'].records;
        w2ui[this.id + '_gridDisposisi'].clear();
        for(i=0;i<datagrid.length;i++){
            var no = i+1;
            datagrid[i]["recid"] = no;
            var recid = no;
            var Hapus = "<button type='button' onclick = 'bos.tcsurat_masuk.gridDisposisi_deleterow("+recid+")' class='btn btn-danger btn-grid'>Delete</button>";
            w2ui[this.id + '_gridDisposisi'].add({recid:recid,level: recid, 
                                                              kode: datagrid[i]["kode"],
                                                              disposisi: datagrid[i]["disposisi"],
                                                              cmdDeleteGr:Hapus});
        }
    }

    /******************************************** */
    /******************************************** */

    //grid3 Disposisi
    bos.tcsurat_masuk.grid3_data    = null ;
    bos.tcsurat_masuk.grid3_loaddata= function(){
        this.grid3_data         = {} ;
    }

    bos.tcsurat_masuk.grid3_load    = function(){
        this.obj.find("#grid3").w2grid({
            name    : this.id + '_grid3',
            limit   : 100 ,
            url     : bos.tcsurat_masuk.base_url + "/loadGridDataUserDisposisi",
            postData: this.grid3_data ,
            show: {
                footer      : true,
                toolbar     : true,
                toolbarColumns  : false
            },
            multiSearch     : false,
            columns: [
                { field: 'fullname', caption: 'Nama', size: '200px', sortable: false },
                { field: 'unit', caption: 'Satuan Unit', size: '100px', sortable: false },
                { field: 'cmdPilih', caption: ' ', size: '80px', sortable: false }
            ]
        });
    }

    bos.tcsurat_masuk.grid3_setdata = function(){
        w2ui[this.id + '_grid3'].postData   = this.grid3_data ;
    }
    bos.tcsurat_masuk.grid3_reload      = function(){
        w2ui[this.id + '_grid3'].reload() ;
    }
    bos.tcsurat_masuk.grid3_destroy     = function(){
        if(w2ui[this.id + '_grid3'] !== undefined){
            w2ui[this.id + '_grid3'].destroy() ;
        }
    }

    bos.tcsurat_masuk.grid3_render  = function(){
        this.obj.find("#grid3").w2render(this.id + '_grid3') ;
    }

    bos.tcsurat_masuk.grid3_reloaddata  = function(){
        this.grid3_loaddata() ;
        this.grid3_setdata() ;
        this.grid3_reload() ;
    }

    /********************************************** */

    bos.tcsurat_masuk.cmdEdit      = function(id){
        bos.tcsurat_masuk.gridDisposisi_clear();
        bos.tcsurat_masuk.gridDisposisi_reload() ;
        bjs.ajax(this.url + '/editing', 'cKode=' + id);
    }

    bos.tcsurat_masuk.cmdDelete    = function(id){
        if(confirm("Delete Data?")){
            bjs.ajax(this.url + '/deleting', 'cKode=' + id);
        }
    }

    bos.tcsurat_masuk.cmdPilih      = function(kode){
        bjs.ajax(this.url + '/selectTargetDisposisi', 'kode=' + kode);
    }

    bos.tcsurat_masuk.init         = function(){
        this.obj.find("#cSuratDari").val("") ;
        this.obj.find("#cPerihal").val("") ;
        this.obj.find("#cNomorSurat").val("") ;
        this.obj.find("#cDeskripsi").val("") ;
        tinymce.activeEditor.setContent("");
        this.obj.find("#cDisposisi").val("") ;
        this.obj.find("#cKode").val("") ;
        this.obj.find("#cKodeKaryawan").val("") ;
        this.obj.find("#nNo").val("0") ;
        this.obj.find("#cUplFile").val("");
        $("input[type=checkbox]").prop("checked",false);
        bjs.ajax(this.url + '/init') ;
        w2ui[this.id + '_gridDisposisi'].clear(); 
        this.obj.find(".nav-tabs li:eq(0) a").tab("show") ;
        bos.tcsurat_masuk.grid1_reload();
        bos.tcsurat_masuk.grid1_loaddata() ;
        
    }

    bos.tcsurat_masuk.initForm    = function(){
        $("#tab-link2").removeClass("active");
        $("#tab-link1").addClass("active");
        
        $("#tab_form_2").removeClass("active");
        $("#tab_form_1").addClass("active");
        
        bos.tcsurat_masuk.init();
    }

    bos.tcsurat_masuk.initTinyMCE = function(){
        tinymce.init({
            selector: '#cDeskripsi',
            height: 250,
            file_browser_callback_types: 'file image media',
            file_picker_types: 'file image media',   
            forced_root_block : "",
            force_br_newlines : true,
            force_p_newlines : false,
        });
    }

    bos.tcsurat_masuk.initComp     = function(){
        bjs.initenter(this.obj.find("form")) ;
        bjs.initdate("#" + this.id + " .date") ;

        this.grid1_loaddata() ;
        this.grid1_load() ;
        this.initTinyMCE() ;

        this.gridDisposisi_load() ;
        this.gridDisposisi_reload() ;

        this.grid3_loaddata() ;
        this.grid3_load() ;
        
        bjs.ajax(this.url + '/init') ;
    }

    bos.tcsurat_masuk.initDetail            = function(){
        var datagrid = w2ui[this.id + '_gridDisposisi'].records;

        this.obj.find("#nNo").val(datagrid.length+1) ;
        this.obj.find("#cDisposisi").val("") ;
        this.obj.find("#cKodeKaryawan").val("") ;
    }

    bos.tcsurat_masuk.cmdPrint = function(no,id){
        bjs.ajax(this.url + '/initReport', 'cKode=' + id);
    }

    bos.tcsurat_masuk.tabsaction    = function(n){
        if(n == 0){
            bos.tcsurat_masuk.grid1_render() ;
            bos.tcsurat_masuk.init() ;
        }else{
            bos.tcsurat_masuk.gridDisposisi_reload() ;
        }
    }

    bos.tcsurat_masuk.initCallBack = function(){
        this.obj.on("bos:tab", function(e){
            bos.tcsurat_masuk.tabsaction( e.i )  ;
        });
        this.obj.on('remove', function(){
            bos.tcsurat_masuk.grid1_destroy() ;
            bos.tcsurat_masuk.gridDisposisi_destroy() ;
            bos.tcsurat_masuk.grid3_destroy() ;
            tinymce.remove() ;
        }) ;
    }

    bos.tcsurat_masuk.loadModalDisposisi      = function(l){
        this.obj.find("#modalDisposisi").modal(l) ;
    }

    bos.tcsurat_masuk.setCheckboxLampiran     = function(data){
        console.log(data);
        for (const [key, value] of Object.entries(test)) {
            //console.log(key, value);
        }
    }

    bos.tcsurat_masuk.cmdSave           = bos.tcsurat_masuk.obj.find("#cmdSave") ;
    bos.tcsurat_masuk.initFunc     = function(){
        this.obj.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if($(e.target).parent().index() == 0){//load grid
                bos.tcsurat_masuk.grid1_reloaddata() ;
                bos.tcsurat_masuk.gridDisposisi_reload() ;
            }else{//focus
                bos.tcsurat_masuk.gridDisposisi_reload() ;
            }
        });

        this.obj.find("#cmdDisposisi").on("click", function(e){
            bos.tcsurat_masuk.loadModalDisposisi("show");
            bos.tcsurat_masuk.grid3_reloaddata() ;
        }) ;

        

        this.obj.find("#cmdOK").on("click", function(e){
            var no                  = bos.tcsurat_masuk.obj.find("#nNo").val();
            var kodekaryawan        = bos.tcsurat_masuk.obj.find("#cKodeKaryawan").val();
            var disposisi           = bos.tcsurat_masuk.obj.find("#cDisposisi").val();

            if(disposisi !== ""){
                bos.tcsurat_masuk.gridDisposisi_reload() ;
                bos.tcsurat_masuk.gridDisposisi_append(no,kodekaryawan,disposisi);
            }else{
                Swal.fire({
                    icon    : "error",
                    title   : "Error",
                    html    : "Data Disposisi Harus Dipilih terlebih dahulu"
                });    
            }
        }) ;

        this.obj.find("#cUplFile").on("change", function(e){
            e.preventDefault() ;
            bos.tcsurat_masuk.uname       = $(this).attr("id") ;
            bos.tcsurat_masuk.fal         = $("#cUplFile")[0].files;//e.target.files;
            bos.tcsurat_masuk.gfal        = new FormData() ;
            for(var i = 0; i < bos.tcsurat_masuk.fal.length; i++){
                bos.tcsurat_masuk.gfal.append("cUplFile[]",bos.tcsurat_masuk.fal[i]);
            }
            bos.tcsurat_masuk.obj.find("#idl" + bos.tcsurat_masuk.uname).html("<i class='fa fa-spinner fa-pulse'></i>");
            bjs.ajaxfile(bos.tcsurat_masuk.base_url + "/savingFile" , bos.tcsurat_masuk.gfal, this) ;
            
        }) ;
        

        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                var dataGridDisposisi   = w2ui['bos-form-tcsurat_masuk_gridDisposisi'].records;
                dataGridDisposisi       = JSON.stringify(dataGridDisposisi);
                bjs.ajax( bos.tcsurat_masuk.base_url + '/saving', bjs.getdataform(this)+"&dataDisposisi="+dataGridDisposisi , bos.tcsurat_masuk.cmdSave) ;
            }
        }) ;
        
    }

    $('.optJenisSurat').select2({
        allowClear: true,
        ajax: {
            url: bos.tcsurat_masuk.base_url + '/SeekJenisSurat',
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
        bos.tcsurat_masuk.initComp() ;
        bos.tcsurat_masuk.initCallBack() ;
        bos.tcsurat_masuk.initFunc() ;
        bos.tcsurat_masuk.initDetail();
    })

</script>