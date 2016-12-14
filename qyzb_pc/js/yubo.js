/**
 * Created by 李伟豪 on 2016/12/1.
 */

app.controller('yuBoController', ['$scope', '$http', '$state',
    function ($scope, $http, $state) {
        $scope.yuBoData = {};
        $http.get('http://localhost/qyzbApi5.1/public/api/yubo_select_all')
            .success(function (result) {
                $scope.yuBoData = result.data;
            })
            .error(function () {
                alert('获取直播数据失败');
            });
        $scope.bofan = function (id) {
            sessionStorage.bofansrc = id;
            $state.go('bofan');
        }
    }]);
