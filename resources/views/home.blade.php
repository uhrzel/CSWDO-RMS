@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">
                            Clients -
                            <div class="dropdown d-inline">
                                <a
                                    class="font-weight-600 dropdown-toggle"
                                    data-toggle="dropdown"
                                    href="#"
                                    id="orders-month">August</a>
                                <ul class="dropdown-menu dropdown-menu-sm">
                                    <li class="dropdown-title">Select Month</li>
                                    <li><a href="#" class="dropdown-item">January</a></li>
                                    <li>
                                        <a href="#" class="dropdown-item">February</a>
                                    </li>
                                    <li><a href="#" class="dropdown-item">March</a></li>
                                    <li><a href="#" class="dropdown-item">April</a></li>
                                    <li><a href="#" class="dropdown-item">May</a></li>
                                    <li><a href="#" class="dropdown-item">June</a></li>
                                    <li><a href="#" class="dropdown-item">July</a></li>
                                    <li>
                                        <a href="#" class="dropdown-item active">August</a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">September</a>
                                    </li>
                                    <li><a href="#" class="dropdown-item">October</a></li>
                                    <li>
                                        <a href="#" class="dropdown-item">November</a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">December</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{ $completedClients }}</div>
                                <div class="card-stats-item-label">Completed</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{ $incompleteClients }}</div>
                                <div class="card-stats-item-label">Processing</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">23</div>
                                <div class="card-stats-item-label">Pending</div>
                            </div>

                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Clients</h4>
                        </div>
                        <div class="card-body">{{ $totalClients }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Family Members</h4>
                        </div>
                        <div class="card-body">{{$totalFamilyMembers}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total of Social Workers</h4>
                        </div>
                        <div class="card-body">{{$totalSocialWorkers}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Budget vs Sales</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>

        </div>
</div>

</section>
</div>

@push('scripts')
<script src="assets/modules/jquery.min.js"></script>
<script src="assets/modules/popper.js"></script>
<script src="assets/modules/tooltip.js"></script>

<script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="assets/modules/moment.min.js"></script>
<script src="assets/js/stisla.js"></script>

<!-- JS Libraies -->
<script src="assets/modules/jquery.sparkline.min.js"></script>
<script src="assets/modules/chart.min.js"></script>
<script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
<script src="assets/modules/summernote/summernote-bs4.js"></script>
<script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

<!-- Page Specific JS File -->
<script src="assets/js/page/index.js"></script>


@endpush

@endsection