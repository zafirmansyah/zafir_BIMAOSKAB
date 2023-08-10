  <!-- Small boxes (Stat box) -->
  <div class="row">
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?=$Jumlah['JmlM02']?></h3>

          <p>M.02 Persetujuan Prinsip</p>
        </div>
        <div class="icon">
          <i class="fa fa-book"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?=$Jumlah['JmlWO']?></h3>

          <p>Work Order</p>
        </div>
        <div class="icon">
          <i class="ion ion-briefcase"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?=$Jumlah['JmlIKU']?></h3>

          <p>IKU</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
<!-- ./col -->
    <div class="col-lg-6 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>BIMA Sharing Folder</h3>
          <p></p>
        </div>
        <div class="icon">
          <i class="ion ion-folder"></i>
        </div>
	<a href="https://bankindonesiagov-my.sharepoint.com/:f:/r/personal/guntur_a_bi_go_id/Documents/BIMA%20Sharing%20Folder?csf=1&web=1&e=RcbUMq" class="small-box-footer" target="_blank">Go to Page <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-6 col-xs-6">
      <div class="small-box bg-teal">
        <div class="inner">
          <h3>BIMA Economic Updates</h3>
          <p></p>
        </div>
        <div class="icon">
          <i class="ion ion-connection-bars"></i>
        </div>
        <a href="https://app.powerbi.com/links/8WVMvDU6xc?ctid=ca37492e-f410-427b-ab39-055bdc18ce02&pbi_source=linkShare" class="small-box-footer" target="_blank">Go to Page <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="text-transform:uppercase;">Daftar Work Order <?=$keteranganUnit?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?php
            //var_dump($DataWO);
          ?>
          <table id="tableWO" class="table table-bordered table-super-condensed table-striped">
            <thead>
              <tr>
                <th width="50%">Judul</th>
                <th>Tgl</th>
                <th>Tujuan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(!empty($DataWO)){
                $nWOSize = sizeof($DataWO);
                $nLength = $nWOSize > 10 ? 10 : $nWOSize; // limit tampilkan maksimal 10 baris saja.
                for($i=0; $i<$nLength; $i++){
                  $dTgl = s_2date($DataWO[$i]['Tgl']);
             ?>
                <tr>
                  <td><?=$DataWO[$i]['Subject']?></td>
                  <td><?=$dTgl?></td>
                  <td><?=$DataWO[$i]['TujuanUserName']?></td>
                  <td><?=$DataWO[$i]['TextStatus']?></td>
                </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title" style="text-transform:uppercase;">Daftar IKU <?=$keteranganUnit?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?php
            //($DataIKU);
          ?>
          <table id="tableIKU" class="table table-bordered table-super-condensed table-striped">
            <thead>
              <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Periode</th>
                <th>Dari</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(!empty($DataIKU)){
                foreach($DataIKU as $key=>$value){
              ?>
                <tr>
                  <td><?=$value['Kode']?></td>
                  <td><?=$value['Subject']?></td>
                  <td><?=$value['Periode']?></td>
                  <td><?=$value['UserName']?></td>
                </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script>
  $(function () {
    $('#tableWO').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    })
    $('#tableIKU').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    })
    
  })
</script>
