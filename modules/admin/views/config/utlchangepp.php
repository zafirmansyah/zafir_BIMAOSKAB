<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <form>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">Upload Foto Disini<span id="idlimage"></span></label>
                                    <input type="file" name="image" id="image" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="cMetodeUK" id="cMetodeUK">
                        <button class="btn btn-success pull-right" id="cmdRefresh">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12" id="idimage" style="text-align:center;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    <?=cekbosjs();?>

    bos.utlchangepp.initComp = function(){
        bjs.ajax( bos.utlchangepp.base_url + '/initComp') ;
    }

    bos.utlchangepp.initFunc = function(){
        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.utlchangepp.base_url + '/saving', bjs.getdataform(this)) ;
            }
        }) ;

        this.obj.find("#image").on("change", function(e){
			e.preventDefault() ;

            bos.utlchangepp.cfile    = e.target.files ;
            bos.utlchangepp.gfile    = new FormData() ;
            $.each(bos.utlchangepp.cfile, function(cKey,cValue){
              bos.utlchangepp.gfile.append(cKey,cValue) ;
            }) ;

            bos.utlchangepp.obj.find("#idlimage").html("<i class='fa fa-spinner fa-pulse'></i>");
            bos.utlchangepp.obj.find("#idimage").html("") ;

            bjs.ajaxfile(bos.utlchangepp.base_url + "/saving_image", bos.utlchangepp.gfile, this) ;

		}) ;
    }

    bos.utlchangepp.finalAct = function(){
        let timerInterval
        Swal.fire({
            icon: 'info',
            title: 'Foto Anda Sedang Diupdate',
            html: 'Log Out Otomatis Akan Dilakukan Untuk Penyempurnaan Data.',
            timer: 7000,
            timerProgressBar: true,
            onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                    b.textContent = Swal.getTimerLeft()
                    }
                }
                }, 100)
            },
            onClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
            this.logOut() ;
        })
    }

    bos.utlchangepp.logOut = function(){
        bjs.ajax(bos.utlchangepp.base_url + '/logOut') ;
    }


    $(function(){
        bos.utlchangepp.initComp() ;
        bos.utlchangepp.initFunc() ;
    })

</script>