/**
 * Created by 李伟豪 on 2016/12/1.
 */

app.controller('boFanController', ['$scope', '$sce', function ($scope, $sce) {
    $scope.bofan_resource = "http://www.myliweihao.com/qyzb_video/" + sessionStorage.bofansrc;
    $scope.bofan_resource = $sce.trustAsResourceUrl($scope.bofan_resource);
}]);
