/**
 * Created by 李伟豪 on 2016/11/27.
 */

app.controller('getProgramTypeController', ['$scope', '$http', '$rootScope', function ($scope, $http, $rootScope) {
    $scope.programType = [];
    $rootScope.typeData = '';
    $rootScope.all = true;
    $http.get('http://localhost/qyzbApi5.1/public/api/programtype_select')
        .success(function (result) {
            $scope.programType = result.data;
        })
        .error(function () {
            console.log('获取菜单失败！');
        });
    $scope.filterProgram = function (id) {
        $rootScope.typeData = id;
        $rootScope.all = false;
    };
    $rootScope.filterSpeak = function () {
        $rootScope.all = false;
    };

    $scope.allProgram = function () {
        $rootScope.all = true;
    };
    $scope.getActive = function (id) {
        if ($rootScope.all) return 0;
        if ($rootScope.typeData == id) return 1;
        return 0;
    };
    $scope.getActiveAll = function () {
        if ($rootScope.all) return 1;
        return 0;
    };


}]);

