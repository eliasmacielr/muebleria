'use strict';

// Register `settingList` component, along with its associated controller and template
angular.
  module('settingList').
  component('settingList', {
    templateUrl: 'app/setting/list/setting-list.template.html',
    controller: ['$scope', '$mdDialog', '$mdSidenav', '$mdToast', 'Setting', 'Auth',
      function SettingListController($scope, $mdDialog, $mdSidenav, $mdToast, Setting, Auth) {

        var self = this;

        self.setting = {};

        self.editable = false;

        Setting.view().$promise.then(
          function (response) {
            self.setting = response.setting;
          }
        );

        self.editSetting = function () {
          Setting.edit(self.setting).$promise.then(
            function (response) {
              self.messageToast(response.message);
            }
          )
        };

        self.isSuperAdmin = function () {
          return (Auth.user.role === 'super-admin' ? true : false);
        };

        self.messageToast = function (message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

        self.showLeftSidenav = function () {
          $mdSidenav('left').toggle();
        };

      }
    ]
  });
