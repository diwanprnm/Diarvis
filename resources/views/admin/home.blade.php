@extends('admin.layout.index')

@section('title') Admin Dashboard @endsection

 

@section('page-body') 
<div class="row">
                                            <!-- task, page, download counter  start -->
                                            <div class="col-xl-3 col-md-6">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <h4 class="text-c-yellow f-w-600">$30200</h4>
                                                                <h6 class="text-muted m-b-0">All Earnings</h6>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <i class="feather icon-bar-chart f-28"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-c-yellow">
                                                        <div class="row align-items-center">
                                                            <div class="col-9">
                                                                <p class="text-white m-b-0">% change</p>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="feather icon-trending-up text-white f-16"></i>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <h4 class="text-c-green f-w-600">290+</h4>
                                                                <h6 class="text-muted m-b-0">Page Views</h6>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <i class="feather icon-file-text f-28"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-c-green">
                                                        <div class="row align-items-center">
                                                            <div class="col-9">
                                                                <p class="text-white m-b-0">% change</p>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="feather icon-trending-up text-white f-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <h4 class="text-c-pink f-w-600">145</h4>
                                                                <h6 class="text-muted m-b-0">Task Completed</h6>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <i class="feather icon-calendar f-28"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-c-pink">
                                                        <div class="row align-items-center">
                                                            <div class="col-9">
                                                                <p class="text-white m-b-0">% change</p>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="feather icon-trending-up text-white f-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <h4 class="text-c-blue f-w-600">500</h4>
                                                                <h6 class="text-muted m-b-0">Downloads</h6>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <i class="feather icon-download f-28"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-c-blue">
                                                        <div class="row align-items-center">
                                                            <div class="col-9">
                                                                <p class="text-white m-b-0">% change</p>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="feather icon-trending-up text-white f-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- task, page, download counter  end -->

                                            <!-- visitor start -->
                                            <div class="col-xl-8 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Visitors</h5>
                                                        <span class="text-muted">For more details about usage, please refer <a href="https://www.amcharts.com/online-store/" target="_blank">amCharts</a> licences.</span>
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="feather icon-maximize full-card"></i></li>
                                                                <li><i class="feather icon-minus minimize-card"></i></li>
                                                                <li><i class="feather icon-trash-2 close-card"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <div id="visitor" style="height:300px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-12">
                                                <div class="card">
                                                    <div class="card-block bg-c-green">
                                                        <div id="proj-earning" style="height: 230px"></div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <h6 class="text-muted m-b-30 m-t-15">Total completed project and earning</h6>
                                                        <div class="row text-center">
                                                            <div class="col-6 b-r-default">
                                                                <h6 class="text-muted m-b-10">Completed Projects</h6>
                                                                <h4 class="m-b-0 f-w-600 ">175</h4>
                                                            </div>
                                                            <div class="col-6">
                                                                <h6 class="text-muted m-b-10">Total Earnings</h6>
                                                                <h4 class="m-b-0 f-w-600 ">76.6M</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- visitor end -->

                                            <!-- sale start -->
                                               

                                            <!-- sale order start -->
                                            <div class="col-xl-4 col-md-6">
                                                <div class="card o-hidden">
                                                    <div class="card-block bg-c-pink text-white">
                                                        <h6>Sales Per Day <span class="f-right"><i class="feather icon-activity m-r-15"></i>3%</span></h6>
                                                        <canvas id="sale-chart1" height="150"></canvas>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div class="row">
                                                            <div class="col-6 b-r-default">
                                                                <h4>$4230</h4>
                                                                <p class="text-muted m-b-0">Total Revenue</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <h4>321</h4>
                                                                <p class="text-muted m-b-0">Today Sales</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="card o-hidden">
                                                    <div class="card-block bg-c-green text-white">
                                                        <h6>Visits<span class="f-right"><i class="feather icon-activity m-r-15"></i>9%</span></h6>
                                                        <canvas id="sale-chart2" height="150"></canvas>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div class="row">
                                                            <div class="col-6 b-r-default">
                                                                <h4>3562</h4>
                                                                <p class="text-muted m-b-0">Monthly Visits</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <h4>96</h4>
                                                                <p class="text-muted m-b-0">Today Visits</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-12">
                                                <div class="card o-hidden">
                                                    <div class="card-block bg-c-blue text-white">
                                                        <h6>Orders<span class="f-right"><i class="feather icon-activity m-r-15"></i>12%</span></h6>
                                                        <canvas id="sale-chart3" height="150"></canvas>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <div class="row">
                                                            <div class="col-6 b-r-default">
                                                                <h4>1695</h4>
                                                                <p class="text-muted m-b-0">Monthly Orders</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <h4>52</h4>
                                                                <p class="text-muted m-b-0">Today Orders</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- sale order end -->

                                            <!-- social start -->
                                            <div class="col-xl-4 col-md-12">
                                                <div class="card quater-card">
                                                    <div class="card-block">
                                                        <h6 class="text-muted m-b-20">This Quarter</h6>
                                                        <h4>$3,9452.50</h4>
                                                        <p class="text-muted">$3,9452.50</p>
                                                        <h5 class="m-t-30">87</h5>
                                                        <p class="text-muted">Online Revenue<span class="f-right">80%</span></p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-simple-c-pink" style="width: 80%"></div>
                                                        </div>
                                                        <h5 class="m-t-30">68</h5>
                                                        <p class="text-muted">Offline Revenue<span class="f-right">50%</span></p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-simple-c-yellow" style="width: 50%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-md-12">
                                                <div class="card social-network">
                                                    <div class="card-header">
                                                        <h5>Social Network</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <img src="..\files\assets\images\widget\icon-1.png" alt=" " class="img-responsive p-b-20">
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Views :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">545,721</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Comments :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">2,256</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Likes :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">4,129</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Subscribe :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">3,451,945</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <img src="..\files\assets\images\widget\icon-2.png" alt=" " class="img-responsive p-b-20">
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Engagement :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">1,543</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Shares :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">846</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Likes :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">569</p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Comments :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">156</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6 m-t-0">
                                                                <img src="..\files\assets\images\widget\icon-3.png" alt=" " class="img-responsive p-b-10 p-t-10">
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Tweets :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">103,576</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 m-t-0">
                                                                <img src="..\files\assets\images\widget\icon-4.png" alt=" " class="img-responsive p-b-10 p-t-10">
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <p class="text-muted m-b-5">Tweets :</p>
                                                                    </div>
                                                                    <div class="col-7">
                                                                        <p class="m-b-5 f-w-400">103,576</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- social end -->
                                        </div>

@endsection
