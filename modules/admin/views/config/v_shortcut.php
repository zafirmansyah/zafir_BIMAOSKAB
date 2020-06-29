<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Folders</h3>

        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li>
                <a id="linkFolderSuratMasuk" href="#">
                    <i class="fa fa-inbox"></i> Inbox
                </a>
            </li>
            <li><a id="linkFolderSuratMasuk1" href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
            <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
        </ul>
    </div>
</div>

<script>
    
    $("#linkFolderSuratMasuk").on('click',function(e){
        objForm    = "rptsuratmasuk" ;
        locForm    = "admin/rpt/rptsuratmasuk" ;
        setTimeout(function(){
            bjs.form({
                "module" : "Administrator",
                "name"   : "",
                "obj"    : objForm, 
                "loc"    : locForm
            });
        }, 1);
    });

    $("#linkFolderSuratMasuk1").on('click',function(e){
        alert("askjdksjdhasdkj");
    });

</script>