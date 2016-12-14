/**
 * Created by 李伟豪 on 2016/11/30.
 */

app.controller('dianBoController', ['$scope', '$http', '$state', function ($scope, $http, $state) {
    $scope.dianBoData = {};
    $http.get('http://localhost/qyzbApi5.1/public/api/dianbo_select_all')
        .success(function (result) {
            $scope.dianBoData = result.data;
        })
        .error(function () {
            alert('获取点播数据失败');
        });

    $scope.bofan = function (id) {
        sessionStorage.bofansrc = id;
        $state.go('bofan');
    }
}]);
