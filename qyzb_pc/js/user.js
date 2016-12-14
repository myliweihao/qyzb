/**
 * Created by 李伟豪 on 2016/11/27.
 */

//注册--------------------
app.controller('registerController', ['$scope', '$http', function ($scope, $http) {
    /**
     * registerData参数
     *  exist：手机是已被注册
     *  register_success_mes: 提示注册成功
     *  register_failed_mes: 提示注册失败
     *
     */
    $scope.registerData = {
        register_success_mes: 0,
        register_failed_mes: 0
    };

    //注册方法
    $scope.register = function () {
        $http.post('http://localhost/qyzbApi5.1/public/api/user_register'
            , {
                mobile: $scope.registerData.mobile,
                password: $scope.registerData.password
            })
            .success(function (result) {
                if (result.status) {
                    $scope.registerData.register_success_mes = 1;
                } else {
                    $scope.registerData.register_failed_mes = 1;
                }
            })
            .error(function () {
                $scope.registerData.register_failed_mes = 1;
            });
    };

    //检查用户名是否被注册过
    $scope.checkUserNameExist = function () {
        $http.post('http://localhost/qyzbApi5.1/public/api/user_exist'
            , {
                mobile: $scope.registerData.mobile
            })
            .success(function (result) {
                if (result.status) {
                    $scope.registerData.exist = true;
                }
            }).error(function (error) {
            console.log('error:' + error);
        });
    };

    //重置注册表单
    $scope.reset = function () {
        $scope.registerForm.$setPristine();
        $scope.registerData = {};
    }
}]);

//登陆--------------------
app.controller('loginController', ['$scope', '$http', '$state', '$rootScope', function ($scope, $http, $state, $rootScope) {

    /**
     *
     * login_success_mes: 登陆成功提示
     * login_failed_mes: 登陆失败提示
     *
     */

    $scope.loginData = {};

    $scope.login = function () {
        $http.post('http://localhost/qyzbApi5.1/public/api/user_login'
            , {
                mobile: $scope.loginData.mobile,
                password: $scope.loginData.password
            })
            .success(function (result) {
                if (result.status) {
                    sessionStorage.setItem('user_id', result.data.user_id);
                    sessionStorage.setItem('nickname', result.data.nickname);
                    $state.go('index');
                } else {
                    $scope.loginData.login_failed_mes = 1;
                }
            })
            .error(function () {
                $scope.loginData.login_failed_mes = 1;
            });
    };

    //检查登陆的用户名是否不存在
    $scope.check_login_user_noExist = function () {
        $http.post('http://localhost/qyzbApi5.1/public/api/login_user_noexist'
            , {
                mobile: $scope.loginData.mobile
            })
            .success(function (result) {
                if (result.status) {
                    $scope.loginData.usernameNoExist = true;
                } else {
                    $scope.loginData.usernameNoExist = false;
                }
            }).error(function (error) {
            console.log('error:' + error);
        });
    };


    //登出
    $rootScope.logout = function () {
        if (!confirm('确认退出')) return 0;
        $http.post('http://localhost/qyzbApi5.1/public/api/user_logout')
            .success(function (result) {
                sessionStorage.setItem('user_id', 0);
                sessionStorage.setItem('nickname', '已退出登陆');
                $state.go('index');
            }).error(function (error) {
            console.log(error);
        });
    };

    $rootScope.is_login = function () {
        if (sessionStorage.getItem('user_id') != 0) {
            return 1;
        } else {
            return 0;
        }
    };
    $rootScope.searchSpeaker = {};
    $rootScope.nickname = function () {
        return sessionStorage.getItem('nickname');
    }

}]);

//修改密码
app.controller('changePasswordController', ['$scope', '$http', '$state', '$rootScope',
    function ($scope, $http, $state, $rootScope) {
        $scope.changeData = {
            changePassword_success_mes: 0,
            changePassword_failed_mes: 0
        };

        //重置修改密码表单
        $scope.reset = function () {
            $scope.changePasswordForm.$setPristine();
            $scope.changeData = {};
        };

        $scope.changePassword = function () {
            $http.post('http://localhost/qyzbApi5.1/public/api/user_change_password', {
                old_password: $scope.changeData.oldPassword,
                new_password: $scope.changeData.newPassword
            }).success(function (result) {
                if (result.status) {
                    $scope.changeData.changePassword_success_mes = 1;
                    $http.post('http://localhost/qyzbApi5.1/public/api/user_logout')
                        .success(function () {
                            sessionStorage.setItem('user_id', 0);
                            sessionStorage.setItem('nickname', '已退出登陆');
                        }).error(function () {
                        console.log('退出登陆失败！');
                    });
                    $state.go('login')
                } else {
                    $scope.changeData.changePassword_failed_mes = 1;
                }
            }).error(function () {
                $scope.changePassword_failed_mes = 1;
            });
        };
    }]);

app.service('personalInformationService', ['$http', '$rootScope', function ($http, $rootScope) {
    var that = this;
    that.personalInformationServiceData = {};
    $rootScope.change_information_failedMes = 0; //修改个人信息成功提示信息
    $rootScope.change_information_successMes = 0; //修改个人信息失败提示信息


    $http.post('http://localhost/qyzbApi5.1/public/api/user_get_primary_data', {
        user_id: sessionStorage.getItem('user_id')
    }).success(function (result) {
        if (result.status) {
            that.personalInformationServiceData = result.data;
        } else {
            alert('获取用户信息出错！');
        }
    }).error(function () {
        alert('获取用户信息出错！');
    });

    //更新数据库里的个人信息
    that.change_informationService = function () {
        $http.post('http://localhost/qyzbApi5.1/public/api/user_change_data', {
            user_id: sessionStorage.getItem('user_id'),
            name: that.personalInformationServiceData.name,
            nickname: that.personalInformationServiceData.nickname,
            sex: that.personalInformationServiceData.sex,
            mobile: that.personalInformationServiceData.mobile,
            address: that.personalInformationServiceData.address,
            email: that.personalInformationServiceData.email
        }).success(function (result) {
            if (result.status) {
                sessionStorage.setItem('nickname', that.personalInformationServiceData.nickname);
                $rootScope.change_information_successMes = 1;
            } else {
                $rootScope.change_information_failedMes = 1;
            }
        }).error(function () {
            that.change_information_failedMes = 1;
        });
    }
}]);

//获取个人信息
app.controller('personalInformationController', ['$scope', 'personalInformationService',
    function ($scope, personalInformationService) {
        $scope.personalInformationData = personalInformationService.personalInformationServiceData;
        $scope.getSex = function () {
            if ($scope.personalInformationData.sex == 1) {
                return '男';
            } else if ($scope.personalInformationData.sex == 2) {
                return '女';
            } else {
                return '空';
            }
        };
    }]);


//修改个人信息
app.controller('change_informationController', ['$scope', 'personalInformationService', '$rootScope',
    function ($scope, personalInformationService, $rootScope) {
        $scope.change_informationData = personalInformationService.personalInformationServiceData;
        $scope.originInformationData = angular.copy($scope.change_informationData);
        $scope.change_information = function () {
            personalInformationService.change_informationService();
        };
        $scope.cancalMes = function () {
            $rootScope.change_information_failedMes = 0; //修改个人信息成功提示信息
            $rootScope.change_information_successMes = 0; //修改个人信息失败提示信息
        };

        $scope.reset_changeInformation = function () {
            $scope.change_informationData = angular.copy($scope.originInformationData);
            $scope.change_informationForm.$setPristine();
        };

    }]);