/**
 * Created by 李伟豪 on 2016/11/24.
 */

var app = angular.module('qyzbModule', ['ui.router']);


app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    $stateProvider.state('index', {
        url: '/index',
        templateUrl: 'templates/index.html'
    }).state('register', {
        url: '/register',
        templateUrl: 'templates/register.html'
    }).state('login', {
        url: '/login',
        templateUrl: "templates/login.html"
    }).state('personal_information', {
        url: '/personal_information',
        templateUrl: 'templates/personal_information.html',
        controller: 'personalInformationController'
    }).state('change_password', {
        url: '/change_password',
        templateUrl: 'templates/change_password.html'
    }).state('change_information', {
        url: '/change_information',
        templateUrl: 'templates/change_information.html'
    }).state('dianbo', {
        url: '/dianbo',
        templateUrl: 'templates/dianbo.html'
    }).state('yubo', {
        url: '/yubo',
        templateUrl: 'templates/yubo.html'
    }).state('bofan', {
        url: '/bofan',
        templateUrl: 'templates/bofan.html'
    }).state('myVideo', {
        url: '/myVideo',
        templateUrl: 'templates/myVideo.html'
    });
    $urlRouterProvider.otherwise('/index');
}]);


