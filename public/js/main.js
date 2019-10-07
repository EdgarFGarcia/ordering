var MainApp = angular.module('MainApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
// MainApp.factory('PagerService', PagerService);
