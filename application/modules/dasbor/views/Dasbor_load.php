 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $menu; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $menu; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<!-- Main content -->
    <section class="content animated zoomIn">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">

                <?php

                $doc = "";
                $query = $this->db->query("SELECT  COUNT(RentalID) AS GetID
                                           FROM    T_Rental
                                           WHERE   IsActive = 'Y'
                                          ");
                 if ($query->num_rows() > 0) {
                   $arr = $query->first_row();
                   $doc = $arr->GetID;
                   //echo $doc;
                 }

                ?>

                <h3><i class="fas fa-key"></i> <?php echo $doc; ?></h3>

                <p>Rental Data</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a style="cursor:pointer;" onclick="callpage('rental/viewRental', '', '')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">

                <?php

                $doc = "";
                $query = $this->db->query("SELECT  COUNT(OrderID) AS GetID
                                           FROM    T_CustomerOrder
                                           WHERE   IsActive = 'Y'
                                          ");
                 if ($query->num_rows() > 0) {
                   $arr = $query->first_row();
                   $doc = $arr->GetID;
                   //echo $doc;
                 }

                ?>

                <h3><i class="fas fa-users"></i> <?php echo $doc; ?></h3>
                <!-- <h3>53<sup style="font-size: 20px">%</sup></h3> -->

                <p>Customer Data</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a style="cursor:pointer;" onclick="callpage('customer/viewCustomer', '', '')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <?php

                $doc = "";
                $query = $this->db->query("SELECT  COUNT(CarID) AS GetID
                                           FROM    M_MasterCar
                                           WHERE   IsActive = 'Y'
                                          ");
                 if ($query->num_rows() > 0) {
                   $arr = $query->first_row();
                   $doc = $arr->GetID;
                   //echo $doc;
                 }

                ?>

                <h3><i class="fas fa-car-side"></i> <?php echo $doc; ?></h3>

                <p>Car Data</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a style="cursor:pointer;" onclick="callpage('car/viewCar', '', '')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                 <?php

                $doc = "";
                $query = $this->db->query("SELECT  COUNT(DriverID) AS GetID
                                           FROM    M_MasterDriver
                                           WHERE   IsActive = 'Y'
                                          ");
                 if ($query->num_rows() > 0) {
                   $arr = $query->first_row();
                   $doc = $arr->GetID;
                   //echo $doc;
                 }

                ?>

                <h3><i class="fas fa-car"></i> <?php echo $doc; ?></h3>

                <p>Driver Data</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a style="cursor:pointer;" onclick="callpage('driver/viewDriver', '', '')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-area"></i>
                  Chart Total Customer Rent <?php echo date('Y');?>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                  <div id="revenue-chart" style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                   </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->


          
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

          <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-pie"></i>
                  Merk Car
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                 <div id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                  </div>
              </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->

           
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->


    <?php 

    $piec  = "";
    $query = $this->db->query("

                                SELECT A.MerkID, B.MerkName, COUNT(CarID) as Total
                                FROM   M_MasterCar A 
                                INNER  JOIN M_MasterMerk B ON A.MerkID=B.MerkID AND B.IsActive ='Y'
                                WHERE  A.IsActive ='Y'
                                GROUP  BY A.MerkID, B.MerkName
                                Order  BY B.MerkName

                              ");

    if ($query->num_rows() > 0) {
        $arr = $query->result();
        foreach($arr as $value){
            $merk[]  = $value->MerkName;
            $totdm[] = $value->Total;
        }
    }
    else{
        $merk  = array("Honda", "Toyota", "Suzuki");
        $totdm = array(0, 0, 0);
    }


    // line chart
    $doc = "";
    $query = $this->db->query("

                              SELECT A.MonthID, A.MonthName, ifnull(B.RentalID,0) AS RentalID
                              FROM   M_Months A
                              LEFT JOIN (
                                        
                                        SELECT MONTH(A.StartDate) as StartDate, COUNT(A.RentalID) AS RentalID 
                                        FROM   T_Rental A
                                        INNER  JOIN T_Return B ON A.RentalID=B.RentalID
                                        WHERE  A.IsActive ='Y'
                                               AND A.Status = '7'
                                               AND B.IsActive ='Y'
                                               AND B.Status = '7'
                                               AND Year(A.StartDate) ='".date('Y')."'
                                        group  by MONTH(A.StartDate)
                                        order  by MONTH(A.StartDate)

                                        ) B ON B.StartDate=A.MonthID
                              WHERE  A.IsActive='Y'
                              ORDER  BY A.MonthID

                                          ");
            if ($query->num_rows() > 0) {
                $arr = $query->result();
                foreach($arr as $value){
                  $month[] = $value->MonthName;
                  $total[] = $value->RentalID;
                }
            }

  ?>






  <script type="text/javascript">

  // Donut Chart
  var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
  var pieData        = {
    labels: <?php echo json_encode($merk); ?>,
    datasets: [
      {
        data: [<?php echo join($totdm,','); ?>],
        backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
      }
    ]
  }
  var pieOptions = {
    maintainAspectRatio : false,
    responsive : true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  var pieChart = new Chart(pieChartCanvas, {
    type: 'doughnut',
    data: pieData,
    options: pieOptions      
  });



  //line chart
  // Sales chart
  var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
  //$('#revenue-chart').get(0).getContext('2d');

  var salesChartData = {
    labels  : <?php echo json_encode($month); ?>,
    datasets: [
      {
        label               : 'Total Rent',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [<?php echo join($total,',');?>]
      },
    ]
  }

  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines : {
          display : false,
        }
      }],
      yAxes: [{
        gridLines : {
          display : false,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas, { 
      type: 'line', 
      data: salesChartData, 
      options: salesChartOptions
    }
  )

  </script>
