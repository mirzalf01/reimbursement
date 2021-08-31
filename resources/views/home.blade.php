@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Home</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Approved</span>
                        <span class="info-box-number">
                            {{ $info['approved'] }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending</span>
                            <span class="info-box-number">{{ $info['pending'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
    
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
    
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-times-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Rejected</span>
                            <span class="info-box-number">{{ $info['rejected'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-money-bill"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total</span>
                            <span class="info-box-number">
                                Rp. {{ number_format($info['totalReimburse']) }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Claim History</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                          <table class="table">
                            <thead>
                              <tr>
                                <th style="width: 15%">#</th>
                                <th style="width: 40%">Title</th>
                                <th style="width: 25%">Amount</th>
                                <th style="width: 20%">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($reimbursements as $key=>$reimbursement)
                                  <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $reimbursement->title }}</td>
                                        <td>Rp. {{ number_format($reimbursement->amount, 0, ".", ".") }}</td>
                                        @if ($reimbursement->status == 'Pending')
                                            <td><span class="badge badge-warning">{{ $reimbursement->status }}</span></td>
                                        @elseif($reimbursement->status == 'Approved')
                                            <td><span class="badge badge-success">{{ $reimbursement->status }}</span></td>
                                        @else
                                            <td><span class="badge badge-danger">{{ $reimbursement->status }}</span></td>
                                        @endif
                                  </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Category Chart</h3>
                        </div>
                        <div class="card-body">
                          <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Main Content --}}
    

@endsection

@section('js')
    <!-- ChartJS -->
    <script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function(){
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
            var donutData        = {
            labels: [
                'Travel',
                'Fuel',
                'Medical',
                'Accomodation',
                'Other'
            ],
            datasets: [
                {
                data: [{{$reimburseData['travel']}},{{$reimburseData['fuel']}},{{$reimburseData['medical']}},{{$reimburseData['accomodation']}},{{$reimburseData['other']}}],
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
                }
            ]
            }
            var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var donutChart = new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
            })
        })
    </script>
@endsection