/**
 * Created by 李伟豪 on 2016/11/27.
 */

app.controller('ziBoController', ['$scope', '$http', '$state', function ($scope, $http, $state) {
    $scope.ziBoData = {};
    $http.get('http://localhost/qyzbApi5.1/public/api/zibo_select_all')
        .success(function (result) {
            $scope.ziBoData = result.data;
        })
        .error(function () {
            alert('刷新太频繁，请稍后再试！');
        });

    $scope.bofan = function (id) {
        sessionStorage.bofansrc = id;
        $state.go('bofan');
    }

}]);