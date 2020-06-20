<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Ganti Password Anda Secara Berkala!</h3>
                </div>
                <form>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="col-md-12" id="divSelectUnitKerja">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="text" name="cUsername" id="cUsername" value="<?=$cUsername?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="divSelectUnitKerja">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="cOldPassword" id="cOldPassword" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="divSelectUnitKerja">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="cNewPassword" id="cNewPassword" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="divSelectUnitKerja">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Retype Your New Password</label>
                                        <input type="password" name="cReNewPassword" id="cReNewPassword" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="cMetodeUK" id="cMetodeUK">
                        <button class="btn btn-danger pull-right" id="cmdRefresh">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>

    <?=cekbosjs();?>

    bos.utlchangepassword.initComp = function(){
        $('#cOldPassword').val("");
        $('#cNewPassword').val("");
        $('#cReNewPassword').val("");
    }

    bos.utlchangepassword.initFunc = function(){
        this.obj.find('form').on("submit", function(e){
            e.preventDefault() ;
            if( bjs.isvalidform(this) ){
                bjs.ajax( bos.utlchangepassword.base_url + '/validSaving', bjs.getdataform(this)) ;
            }
        }) ;
    }

    bos.utlchangepassword.finalAct = function(){
        let timerInterval
        Swal.fire({
            icon: 'info',
            title: 'Password Anda Sedang Diupdate',
            html: 'Halaman akan logout otomatis setelah berhasil.',
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

    bos.utlchangepassword.logOut = function(){
        bjs.ajax(bos.utlchangepassword.base_url + '/logOut') ;
    }


    $(function(){
        bos.utlchangepassword.initComp() ;
        bos.utlchangepassword.initFunc() ;
    })

</script>