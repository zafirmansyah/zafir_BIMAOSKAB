<a href="#" class="dropdown-toggle" data-toggle="dropdown" alt="Surat Masuk">
    <i class="fa fa-google-wallet" alt="Work Order"></i>
    <span class="label label-warning"><?= sizeof(listNotifWorkOrder()) ?></span>
</a>
<ul class="dropdown-menu">
    <li class="header">Daftar Work Order...</li>
        <li>
            <!-- inner menu: contains the actual data -->
            <?php
                $nJumlahNotif = sizeof(listNotifWorkOrder()) ;
                $cFooterDescription = "" ;
                if($nJumlahNotif > 0){
                    ?>
                        <ul class="menu">
                            <?php

                                foreach(listNotifWorkOrder() as $key=>$val){
                                    ?>
                                        <li onClick="openDetailSurat('<?=$val['Kode']?>')"><!-- start message -->
                                            <a href="#">
                                                <h4>
                                                    <?=$val['Subject']?>
                                                </h4>
                                                <p><small><i class="fa fa-clock-o"></i> <?=$val['DTDisposisi']?></small></p>
                                                <p>From : <?=$val['UNameSender']?></p>
                                            </a>
                                        </li>
                                    <?php
                                }

                            ?>
                        </ul>
                    <?php
                }else{
                    $cFooterDescription = "Tidak Ada Data" ;
                }
            ?>
            
        </li>
    <li onClick="openAllListSuratMasuk()" class="footer"><a href="#">Lihat Semua</a></li>
</ul>