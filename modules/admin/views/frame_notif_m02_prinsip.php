
<a href="#" class="dropdown-toggle" data-toggle="dropdown" alt="Surat Masuk">
    <i class="fa fa-book" alt="Work Order"></i>
    <span class="label label-primary"><?= sizeof(listNotifM02Prinsip()) ?></span>
</a>
<ul class="dropdown-menu">
    <li class="header">Daftar Persetujuan Prinsip...</li>
        <li>
            <!-- inner menu: contains the actual data -->
            <?php
                $nJumlahNotif = sizeof(listNotifM02Prinsip()) ;
                $cFooterDescription = "" ;
                if($nJumlahNotif > 0){
                    ?>
                        <ul class="menu">
                            <?php

                                foreach(listNotifM02Prinsip() as $key=>$val){
                                    ?>
                                        <li onClick="openDetailM02('<?=$val['FakturDokumenM02']?>')"><!-- start message -->
                                            <a href="#">
                                                <h4>
                                                    <?=$val['Perihal']?>
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
    <li onClick="openAllListM02()" class="footer"><a href="#">Lihat Semua</a></li>
</ul>