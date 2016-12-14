/**
 * Created by 李伟豪 on 2016/12/13.
 */

app.controller('myVideoController', ['$scope', '$http', function ($scope, $http) {
    //inputType:传递类型的id
    //  $scope.myVideoData.speaker = sessionStorage.getItem('nickname');
    $scope.myVideoData = {
        speaker: sessionStorage.getItem('nickname')
    };

    $http.get('http://localhost/qyzbApi5.1/public/api/programtype_select')
        .success(function (result) {
            $scope.myVideoData.type = result.data;
            console.log($scope.myVideoData.type);
        })
        .error(function () {
            console.log('获取节目单类型失败');
        });
    $scope.yuGao = function () {
        $http.post('http://localhost/qyzbApi5.1/public/api/yubo_insert', {
            title: $scope.myVideoData.title,
            type_id: $scope.myVideoData.inputType,
            describe: $scope.myVideoData.describe
        }).success(function (result) {
            console.log('result : ' + result);
            $scope.myVideoData.success_mes = 1;
            $scope.myVideoData.failed_mes = 0;
        }).error(function () {
            console.log('error');
            $scope.myVideoData.success_mes = 0;
            $scope.myVideoData.failed_mes = 1;
        });
    }

}]);