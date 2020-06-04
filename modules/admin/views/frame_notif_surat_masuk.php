<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-envelope-o"></i>
    <span class="label label-success"><?php echo sizeof(listNotifSuratMasuk()) ; ?></span>
</a>
<ul class="dropdown-menu">
    <li class="header"></li>
        <li>
            <!-- inner menu: contains the actual data -->
            <?php
                $nJumlahNotif = sizeof(listNotifSuratMasuk()) ;
                if($nJumlahNotif > 0){
                    ?>
                        <ul class="menu">
                            <?php

                                foreach(listNotifSuratMasuk() as $key=>$val){
                                    ?>
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="notif-title-perihal">
                                                    <p>
                                                        <h5>
                                                            <?=$val['Perihal']?>
                                                        </h5>
                                                    </p>
                                                </div>
                                                <p><small><i class="fa fa-clock-o"></i> <?=$val['DTDisposisi']?></small></p>
                                                <p>From : <?=$val['Dari']?></p>
                                            </a>
                                        </li>
                                    <?php
                                }

                            ?>
                        </ul>
                    <?php
                }
            ?>
            
        </li>
    <li class="footer"><a href="#">See All Messages</a></li>
</ul>