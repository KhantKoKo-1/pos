var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope) {
    $scope.UserInputType = '';
    $scope.username = '';
    $scope.password = '';
    $scope.Login = function(){
        $('#submit').submit();
    }

    $scope.usernameFocus = function(){
       $scope.UserInputType = 'username'
    }
    $scope.passwordFocus = function(){
        $scope.UserInputType = 'password'
     }
    $scope.numberClick = function(number){
        var input_num = parseInt(number);
        if($scope.UserInputType == '' || $scope.UserInputType == 'username'){
            $scope.username = $scope.username + input_num;
        }else{
            $scope.password = $scope.password + input_num;
        }
    }

    $scope.delete = function(){
        if($scope.UserInputType == 'username'){
            $scope.username = $scope.username.slice(0, -1);
        }else{
            $scope.password = $scope.password.slice(0, -1);
        }
     }
});