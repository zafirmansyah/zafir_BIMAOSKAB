<div class="row">
    <div class="col-md-12">
        <div class="col-sm-23">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Pencairan Selama Tahun <?=date('Y')?></h3><br>                    
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-body" id="chart_real_byLokasi" style="width:85%"></div>
                </div>
                <div class="box-body">
                    <div class="panel-body" id="chart_real_byGolongan" style="width:85%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=base_url('bismillah/chart/Chart-2.4.0.min.js')?>"></script>
<script>
$(function () {
    <?=cekbosjs();?>

    bos.dpsbi.loading      	= '<div class="loading-text">Loading...</div>' ;
    bos.dpsbi.loadc          = function(){
        bos.dpsbi.obj.find("#chart_real_byLokasi").html(bos.dpsbi.txt_loading) ;
        bjs.ajax(this.url + "/loadc") ;
        bjs.ajax(this.url + "/load_chart_realByGolongan") ;
    }

    bos.dpsbi.setc  = function(jdata) {
        bos.dpsbi.obj.find("#chart_real_byLokasi").html('<canvas id="vs_chart_real_byLokasi" width="100%"></canvas>') ;
        bos.dpsbi.cchart_real_byLokasi = bos.dpsbi.obj.find("#vs_chart_real_byLokasi")[0].getContext("2d") ;

        bos.dpsbi.chart_real_byLokasi  = new Chart( bos.dpsbi.cchart_real_byLokasi, {
            type : "bar",
            data : jdata,
            options :{
                title : {
                    display: true,
                    text: "Total Realisasi Per Lokasi"
                },
                legend: {
                    display: true,
                }
            }
        });
        this.obj.find("#text_bt").html("") ;
    }

    bos.dpsbi.setChartByGolongan  = function(jdata) {
        bos.dpsbi.obj.find("#chart_real_byGolongan").html('<canvas id="vs_chart_real_byGolongan" width="100%"></canvas>') ;
        bos.dpsbi.cchart_real_byGolongan = bos.dpsbi.obj.find("#vs_chart_real_byGolongan")[0].getContext("2d") ;

        bos.dpsbi.chart_real_byGolongan  = new Chart( bos.dpsbi.cchart_real_byGolongan, {
            type : "horizontalBar",
            data : jdata,
            options :{
                title : {
                    display: true,
                    text: "Total Realisasi Per Golongan PSBI"
                },
                legend: {
                    display: true,
                }
            }
        });
        this.obj.find("#text_bt").html("") ;
    }

    bos.dpsbi.initFunc 		= function(){
        bos.dpsbi.loadc() ;
    }

    $(function(){
        bos.dpsbi.initFunc() ;
    }) ;
})
</script>