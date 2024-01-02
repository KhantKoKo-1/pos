<?php
$title = 'Order Form';
require ('../template/template_header.php');
?>
        <div class="container-fluid receipt category-pg"  ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
            <div class="row cmn-ttl cmn-ttl2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 col-sm-6 col-6">
                            <h3>
                                Category
                            </h3>
                        </div>
                        <div class="col-lg-8 col-md-7 col-sm-6 col-6 receipt-btn">
                            <button class="btn" ng-click="returnBack()">
                              <img src="<?php echo $base_url;?>asset/images/frontend/payment/previous_img.png" alt="Previous" class="heightLine_06" />
                            </button>
                         </div>
                    </div>
                </div>
            </div>
            <div class="item-container" >
                <div class="row">
                    <div class="col-md-9">
                        <div class="cat-table">
                            <div class="table-responsive">
                                <button class="scroll-txt cat-to-btm2"><i class="fas fa-angle-double-down"></i></button>
                                <form class="form-horizontal" id="order-form">
                                    <table class="table table-hover item-list" style="text-align:left;">
                                        <thead>
                                            <tr>
                                                <th width="20%" align="center">Item Name</th>
                                                <th width="20%" align="center">Quantity</th>
                                                <th width="10%" align="center">Price</th>
                                                <th width="10%" align="center">Discount</th>
                                                <th width="10%" align="center">Amount</th>
                                                <th width="15%" align="center">code_no</th>
                                                <th width="15%" align="center">Cancel</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cat-table-body">
                                            <tr class="item-tr" ng-repeat="itemData in itemDatas">
                                                <td class="item-td" width="20%"><p>{{itemData.name}}</p></td>
                                                <td class="cart_quantity item-td" width="20%">
                                                    <div class="qty-box">
                                                        <input type='button' value='-' ng-click ="itemQuantity('minus',itemData.id)" class='qtyminus' field='quantity'/>
                                                        <input type='text' name='quantity[]' value='{{itemData.quantity}}' class='qty' />
                                                        <input type='button' value='+' ng-click ="itemQuantity('plus',itemData.id)" class='qtyplus' field='quantity' />
                                                    </div>
                                                </td>
                                                <td class="item-td" width="10%">{{itemData.price}}</td>
                                                <td id="discount" class="item-td">
                                                    <span>{{itemData.discount_amount}}</span></td>
                                                <td class="item-td" width="10%">
                                                    <input type="text" value="{{itemData.total_amount}}" style="border:none;background:none;" readonly class="price-input" />
                                                </td>
                                                <td class="item-td" width="15%">
                                                    {{itemData.code_no}}
                                                </td>
                                                <td class="item-td" width="15%">
                                                    <button class="cancel-btn" type="button" ng-click="cancelItem(itemData.id)">Cancel</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                                <button class="scroll-txt cat-to-top2" type="button"><i class="fas fa-angle-double-up"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="price-table">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td colspan="2" rowspan="5" class="order-btn-gp">
                                                <button class="order-btn makeorder-btn" id="back-lg">
                                                    <img src="<?php echo $base_url;?>asset/images/frontend/payment/previous_img.png" alt="Previous" class="heightLine_06">     
                                                </button>
                                                <button class="order-btn makeorder-btn" id="order-item" ng-click = "orderConfirm()">
                                                    <img src="<?php echo $base_url;?>asset/images/frontend/payment/order.png" class="heightLine_06">
                                                </button>
                                            </td>
                                            <td>Sub Total : </td>
                                            <td id="sub-total">{{subTotal}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- col-md-9 -->

                    <div class="col-md-3">
                        <div class="row category" >
                        <div class="row category">
                            <div class="col-md-12 cat-list" id="cathome">
                                <div class="cat-ttl">
                                    <button class="backBtn" ng-click = "getParentCategory(0)"><i class="fas fa-angle-left"></i></button>
                                    <input class="btnSearch" type="text" placeholder="Search" ng-model="searchData" ng-keyup = "searchItem()">
                                    <span style="margin-left : -20px;"><i class="fas fa-search"></i></span>
                                </div>
                                <div class="tab-content row" id="cat-tab-content">
                                    <button class="scroll-txt cat-to-btm"><i class="fas fa-angle-double-down"></i></button>
                                    <div class="tab-pane active clearfix" id="categoryDiv" role="tabpanel" >
                                        <!-- Category Loop Start Here -->
                                        <div class="cat-box" style="width: 45%" ng-if="showCategorie" ng-repeat="category in categories">
                                            <button ng-click = "getChildCategory(category.id)">
                                                <figure>
                                                    <img ng-src="{{base_url}}asset/upload/category/{{category.id}}/{{category.image}}" class="img-responsive">
                                                    <figcaption>{{category.name}}</figcaption>
                                                </figure>
                                            </button>
                                        </div>
                                        <!-- Category Loop End Here -->
                                        <div class="cat-box" style="width: 45%;" ng-if="showItem" ng-repeat="item in items">
                                            <button ng-click = "fetchItemId(item.id)">
                                                <figure>
                                                <img ng-src="{{base_url}}asset/upload/item/{{item.id}}/{{item.image}}" class="img-responsive">
                                                    <figcaption>{{item.name}}</</figcaption>
                                                    <figcaption>{{item.price}}</figcaption>
                                                </figure>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="setDiv" role="tabpanel">
                                    </div>
                                    <button class="scroll-txt cat-to-top"><i class="fas fa-angle-double-up"></i></button>
                                </div> <!-- tab-content -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- col-md-3 -->
                </div><!-- row -->
            </div>
        </div><!-- container-fluid -->
    </div><!-- wrapper -->
    <script src="<?php echo $base_url;?>asset/js/page/order.js"></script>
    <?php require ('../template/template_footer.php');?>