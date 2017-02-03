'use strict';

// Register `settingList` component, along with its associated controller and template
angular.
  module('settingList').
  component('settingList', {
    templateUrl: 'app/setting/list/setting-list.template.html',
    controller: ['$scope', '$mdDialog', '$mdSidenav', '$mdToast', 'Setting',
      function SettingListController($scope, $mdDialog, $mdSidenav, $mdToast, Setting) {

        var self = this;

        self.setting = {};

        Setting.view().$promise.then(
          function (response) {
            self.setting = response.setting;
          }
        );

      }
    ]
  });
