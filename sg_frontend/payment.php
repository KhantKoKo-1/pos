<?php
$title = 'Payment Form';
require ('../template/template_header.php');
?>
        <div class="header-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-4 heightLine_01 head-lbox">
                        <div>
                            <a class="btn btn-large dash-btn" href="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</a>
                        </div>
                    </div>
                    <div class="col-md-2 col-2 heightLine_01">
                        <img src="<?php echo $base_url;?>asset/images/frontend/resturant_logo.png" alt="ROS logo" class="ros-logo">
                    </div>

                    <div class="col-md-3 col-3 heightLine_01 head-rbox">
                        <div>
                            <span class="staff-name">
                                Staff
                            </span>
                            <div class="dropdown show pull-right">
                                <button role="button" id="dropdownMenuLink" class="btn btn-primary user-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $base_url;?>asset/images/frontend/login_img.png" alt="login image">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- header-sec -->

    <div class="wrapper"> 
        <div class="container-fluid receipt">  
          <div class="row cmn-ttl cmn-ttl2">
              <div class="container">
                <div class="row">
                    <input type="hidden" class="void-value" id="" />
                    <input type="hidden" class="void-type" id="" />
                    <div class="col-lg-4 col-md-5 col-sm-6 col-6">
                        <h3>Order no : 11254521
                        </h3>
                    </div>
                  <div class="col-lg-8 col-md-7 col-sm-6 col-6 receipt-btn">
                        <button class="btn print-modal" id="printInvoice">
                            <img src="<?php echo $base_url;?>asset/images/frontend/payment/print_img.png" alt="Print Image" class="heightLine_06">
                        </button>

                    <a class="btn" href="">
                        <img src="<?php echo $base_url;?>asset/images/frontend/payment/previous_img.png" alt="Previous" class="heightLine_06">
                    </a>
                  </div>
                </div> 
              </div> 
          </div>
            <div class="row"> 
                <div class="container"> 
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-6">
                            <div class="table-responsive">
                                <table class="table receipt-table">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>20000</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-gray">Sub-Total (After All Discount)</td>
                                    </tr>
                                    <tr>
                                        <td>room charge</td>
                                        <td>2000</td>
                                    </tr> 

                                    <tr>
                                        <td>service charge </td>
                                        <td>200</td>
                                    </tr>

                                    <tr>
                                        <td>GST</td>
                                        <td>200 </td>
                                    </tr>
                                    <tr>
                                        <td>discount</td>
                                        <td>250</td>
                                    </tr>

                                    <tr class="foc-tr" style="cursor: pointer;">
                                        <td>free of charge</td>
                                        <td class="foc">100</td>
                                    </tr>
                                </table>
                            </div><!-- table-responsive -->

                            <h3 class="receipt-ttl">TOTAL - 25000</h3>
                            <div class="table-responsive">
                                <table class="table receipt-table" id="invoice-table">
                                    <tr class="before-tr" style="height: 32px;">
                                        <td colspan="2" class="bl-data"></td>
                                    </tr>
                                    <tr class="tender">
                                        <td>
                                        30000 mmk
                                        </td>
                                        <td>30000</td>
                                    </tr>
                      <tr>
                        <td>BALANCE</td>
                        <td class="balance">35000</td>
                      </tr>
                      <tr>
                        <td>CHANGE</td>
                        <td class="change">
                            35000
                        </td>
                      </tr>
                    </table>
                  </div><!-- table-responsive -->
                    <div class="row receipt-btn02">
                        <div class="col-md-6 col-sm-6 col-6">
                            <button class="btn btn-primary item-modal" data-toggle="modal" data-target="#printModal" >ITEM LISTS</button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6"><a class="btn btn-primary view-btn" href="">VIEW DETAILS</a></div>
                    </div>

                </div> 
                <div class="col-md-8 col-sm-8 col-6">
                  <div class="row"> 
                    <div class="col-md-12 list-group" id="myList" role="tablist">
                        <a class="list-group-item list-group-item-action heightLine_05 active" data-toggle="list" href="#home" role="tab" id="payment-cash">
                          <span class="receipt-type cash-img"></span><span class="receipt-txt">Cash</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#profile" role="tab" id="payment-card">
                          <span class="receipt-type card-img"></span><span class="receipt-txt">Card</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#messages" role="tab" id="payment-voucher">
                          <span class="receipt-type voucher-img"></span><span class="receipt-txt">Voucher</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#settings" role="tab" id="payment-nocollection">
                          <span class="receipt-type collection-img"></span><span class="receipt-txt">No Collection</span>
                        </a>
                        <a class="list-group-item list-group-item-action heightLine_05" data-toggle="list" href="#settings" role="tab" id="payment-loyalty">
                          <span class="receipt-type loyality-img"></span><span class="receipt-txt">Loyalty</span>
                        </a>
                    </div> <!-- list-group -->
                    <div class="col-md-12">
                    <div class="tab-content row">
                      <div class="tab-pane active" id="home" role="tabpanel">
                        <button class="btn heightLine_04 cash-payment" id="CASH"><span class="extra-cash"></span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH50"><span class="money">50</span> <span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH100"><span class="money">100</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH200"><span class="money">200</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH500"> <span class="money">500</span> <span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH1000"><span class="money">1000</span><span>Kyats</span></button>
                        <button class="btn heightLine_04 cash-payment" id="CASH5000"><span class="money">5000</span><span>Kyats</span> </button>
                        <button class="btn heightLine_04 cash-payment" id="CASH10000"> <span class="money">10000</span><span>Kyats</span></button>
                      </div>
                      <div class="tab-pane" id="profile" role="tabpanel">
                            <button class="btn heightLine_05 mpu-type agd-mpu card-payment" id="MPU_AGD"><span class="receipt-type cash-img"></span><span class="receipt-txt">AGD</span></button>
                            <button class="btn heightLine_05 mpu-type kbz-mpu card-payment" id="MPU_KBZ"><span class="receipt-type cash-img"></span><span class="receipt-txt">KBZ</span></button>
                            <button class="btn heightLine_05 mpu-type uab-mpu card-payment" id="MPU_UAB"><span class="receipt-type cash-img"></span><span class="receipt-txt">UAB</span></button>
                            <button class="btn heightLine_05 mpu-type mob-mpu card-payment" id="MPU_MOB"><span class="receipt-type cash-img"></span><span class="receipt-txt">MOB</span></button>
                            <button class="btn heightLine_05 mpu-type chd-mpu card-payment" id="MPU_CHD"><span class="receipt-type cash-img"></span><span class="receipt-txt">CHD</span></button>

                            <button class="btn heightLine_05 mpu-type kbz-visa card-payment" id="VISA_KBZ"><span class="receipt-type cash-img"></span><span class="receipt-txt">KBZ</span></button>
                            <button class="btn heightLine_05 mpu-type cb-visa card-payment" id="VISA_CB"><span class="receipt-type cash-img"></span><span class="receipt-txt">CB</span></button>
                      </div>
                    </div>
                    </div>
                    <div class="payment-cal col-md-12"> 
                      <div class="row"> 
                        <div class="col-md-12 payment-show">
                          <p class="amount-quantity" style="min-height: 33px;"></p>
                        </div>
                        <div class="col-md-12 receipt-btn3"> 
                          <button class="btn quantity" id="1">1</button>
                          <button class="btn quantity" id="2">2</button>
                          <button class="btn quantity" id="3">3</button>
                          <button class="btn quantity" id="4">4</button>
                          <button class="btn quantity" id="5">5</button>
                          <button class="btn quantity" id="6">6</button>
                          <button class="btn quantity" id="7">7</button>
                          <button class="btn quantity" id="8">8</button>
                          <button class="btn quantity" id="9">9</button>
                          <button class="btn quantity" id="0">0</button>
                        </div>
                        <div class="col-md-12 receipt-btn4">                       
                            <button class="btn btn-primary void-btn" id = 'void-item'>VOID <i class="fa fa-trash-alt"></i></button>
                            <button class="btn clear-input-btn">CLEAR INPUT</button>
                            <button class="btn btn-primary foc-btn">FREE CHARGE</button>
                        </div>
                      </div>

                    </div>
                  </div> <!-- row -->     
                </div> <!-- col-md-8 -->

              </div>

            </div> 
          </div>
        </div><!-- container-fluid -->
      </div><!-- wrapper -->
        <!--
            print template here
        @include('cashier.invoice.payment_print')
        -->
        <!-- item print her
        @include('cashier.invoice.items_list')
    -->
<div class="footer text-center">  
            <img src="<?php echo $base_url;?>asset/images/frontend/softguide_logo.png" alt="Softguide logo">
        </div><!-- footer -->
    </div><!-- wrapper -->

<?php require ('../template/template_footer.php');?>