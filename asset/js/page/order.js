var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope,$http) {
   $scope.base_url  =  base_url;
   $scope.categories = [];
   $scope.items = [];
   $scope.allItems = [];
   $scope.itemDatas = [];
   $scope.showCategorie = true;
   $scope.showItem = false;
   $scope.sameItem = false;
   $scope.subTotal = 0;
   $scope.totalDiscount = 0;
   $scope.searchData = '';
   $scope.init = function(){
        $scope.fetchCategory(0)
        $scope.fetchAllItem()
   }

   $scope.getChildCategory = function(parent_id){
        $scope.fetchCategory(parent_id)
   }

   $scope.getParentCategory = function(parent_id){
        $scope.fetchCategory(parent_id)
   }

   $scope.fetchCategory = function(parent_id){
        $scope.showCategorie = true;
        $scope.showItem = false;
        $scope.categories = [];
        var data ={
            parent_id : parent_id
        }
        const url = base_url + 'api/get_category';
        $http.post(url,data,parent_id)
        .then(function(response) {
            if(response.data.length <= 0){
                $scope.fetchItem(parent_id);
            }else{
                $scope.categories = response.data;
            }
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });
   }

   $scope.fetchItem = function(category_id){
        $scope.showCategorie = false;
        $scope.showItem = true;
        var data ={
            category_id : category_id
        }
        const url = base_url + 'api/get_items';
        $http.post(url,data)
        .then(function(response) {
            $scope.items = response.data;
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });
   }

   $scope.fetchAllItem = function(){
        var data ={}
        const url = base_url + 'api/all_get_items';
        $http.post(url,data)
        .then(function(response) {
            $scope.allItems = response.data;
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });
   }

   $scope.fetchItemId = function(item_id){
        $scope.sameItem = false;
        let data ={
            item_id : item_id
        }
        const url = base_url + 'api/get_item';
        $http.post(url,data)
        .then(function(response) {
            var found = false;
            $scope.itemDatas = $scope.itemDatas.map(function(item) {
                if (item_id === item.id) {
                    found = true;
                    item.quantity += 1;
                    item.total_amount = item.original_amount * item.quantity;
                    item.discount_amount = $scope.totalDiscount * item.quantity;
                }
                return item;
            });
            $scope.sameItem = found;
            if (!$scope.sameItem) {
                $scope.itemDatas.push(response.data[0]);
                $scope.totalDiscount += response.data[0].discount_amount;
            }
            $scope.calculationSubTotable();
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });
       
   }

   $scope.itemQuantity = function(type, itemId) {
    $scope.itemDatas = $scope.itemDatas.map(function(item) {
        if (itemId == item.id) {
            item.total_amount += (type === 'minus' && item.quantity > 1) ?  - item.original_amount : (type === 'plus' ? + item.original_amount : 0);
            item.quantity += (type === 'minus' && item.quantity > 1) ? -1 : (type === 'plus' ? 1 : 0);
            item.discount_amount = $scope.totalDiscount * item.quantity;
        }
        return item;
    });
    $scope.calculationSubTotable();
};
   
   $scope.cancelItem = function(itemId) {
    let removedItem = $scope.itemDatas.find(item => itemId === item.id);
    if (removedItem) {
        $scope.itemDatas = $scope.itemDatas.filter(item => itemId !== item.id);
    }
    $scope.calculationSubTotable();
};

$scope.calculationSubTotable = function() {
   $scope.subTotal = 0;
   for(i = 0; i < $scope.itemDatas.length ; i++){
    $scope.subTotal += $scope.itemDatas[i].total_amount;
   }
};
$scope.searchItem = function() {
    let searchData = $scope.searchData;
    if(searchData == ''){
        $scope.showCategorie = true;
        $scope.showItem = false;
        $scope.fetchCategory(0);  
    }else{
        $scope.showCategorie = false;
        $scope.showItem = true;     
        $scope.items = $scope.allItems.filter(item => item.code_no.startsWith(searchData));
    }
};
$scope.orderConfirm = function() {
    Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!!",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Order Now!"
    }).then((result) => {
    if (result.isConfirmed) {
        $scope.order();
    }
    });
};
$scope.order = function() {
        let data =$scope.itemDatas;
        data.push({ sub_total: $scope.subTotal });
        const url = base_url + 'api/order_confirmed';
        $http.post(url,data)
        .then(function(response) {
            $scope.items = response.data;
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });
};


});