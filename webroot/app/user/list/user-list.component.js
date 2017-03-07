'use strict';

// Register `userList` component, along with its associated controller and template
angular.
  module('userList').
  component('userList', {
    templateUrl: 'app/user/list/user-list.template.html',
    controller: ['$scope', '$route', '$location', '$q', '$mdDialog', '$mdSidenav', '$mdToast', 'User',
      function UserListController($scope, $route, $location, $q, $mdDialog, $mdSidenav, $mdToast, User) {

        var self = this;

        $scope.selected = [];

        $scope.query = {
          limit: 5,
          page: 1,
          sort: 'name',
          search: ''
        };

        $scope.limitOptions = [5, 10, 15];

        function success(users) {
          self.users = users;
        }

        $scope.getUsers = function () {
          $scope.promise = User.list($scope.query, success).$promise;
        };

        self.roles = ['Admin', 'Staff'];

        var bookmark;

        $scope.search = {
          options: {
            debounce: 500
          }
        };

        $scope.$watch('query.name', function (newValue, oldValue) {
          if(!oldValue) {
            bookmark = $scope.query.page;
          }

          if(newValue !== oldValue) {
            $scope.query.page = 1;
          }

          if(!newValue) {
            $scope.query.page = bookmark;
          }

          $scope.getUsers();
        });

        self.showSearch = false;

        // Add
        $scope.addUserDialog = function (ev) {
          $mdDialog.show({
            controller: AddUserController,
            templateUrl: 'app/user/add/user-add.template.html',
            parent: angular.element(document.body),
            targetEvent: ev
          })
          .then(function (answer) {
            self.messageToast(answer);
          }, function () {
          });
        };

        // Edit
        $scope.editUserDialog = function (ev, user) {
          self.user = user;
          $mdDialog.show({
            controller: EditUserController,
            templateUrl: 'app/user/edit/user-edit.template.html',
            parent: angular.element(document.body),
            targetEvent: ev
          })
          .then(function (answer) {
            self.messageToast(answer);
          }, function () {
            self.messageToast('No se ha editado el registro');
          });
        };

        // Delete
        $scope.deleteUserDialog = function (ev) {
          var confirm = $mdDialog.confirm()
            .title('Eliminar usuarios')
            .textContent('Está seguro de borrar ' + $scope.selected.length + ' registro(s)?')
            .ariaLabel('Eliminar usuarios')
            .targetEvent(ev)
            .ok('Aceptar')
            .cancel('Cancelar');

          $mdDialog.show(confirm).then(function () {
            self.deleteUsers();
          }, function () {
            self.messageToast('No se borraron registros');
          });
        };

        // Controllers
        function AddUserController($scope, $mdDialog, User) {
          $scope.user = {};

          $scope.roles = ['Admin', 'Staff'];

          $scope.addUser = function () {
            User.add($scope.user,
              function (response) {
                if (response.status) {
                  self.users.users.push(response.user);
                  self.users.users.count += 1;
                }
                $scope.answer(response.message);
              }
            );
          };

          $scope.hide = function () {
            $mdDialog.hide();
          };

          $scope.cancel = function () {
            $mdDialog.cancel();
          };

          $scope.answer = function (answer) {
            $mdDialog.hide(answer);
          };
        };

        function EditUserController($scope, $mdDialog, User) {

          User.view({userId: self.user.id}).$promise.then(
            function (response) {
              $scope.toEdit = response;
            }
          );

          $scope.roles = ['Admin', 'Staff'];

          var index = self.users.users.indexOf(self.user);

          $scope.editUser = function () {
            User.edit(
              {userId: $scope.toEdit.user.id},
              $scope.toEdit.user,
              function (response) {
                if (response.status) {
                  self.users.users[index] = response.user;
                }
                $scope.answer(response.message);
              }
            );
          };

          $scope.hide = function () {
            $mdDialog.hide();
          };

          $scope.cancel = function () {
            $mdDialog.cancel();
          };

          $scope.answer = function (answer) {
            $mdDialog.hide(answer);
          };
        };

        self.deleteUser = function (userId) {
          User.delete({userId: userId});
        };

        self.deleteUsers = function () {
          var promises = [];

          for (var i = 0; i < $scope.selected.length; i++) {
            promises.push(
              User.delete({userId: $scope.selected[i].id})
            );
          }

          $q.all(promises).then(
            function (response) {
              self.messageToast('Se han borrado los registros');
              $route.reload();
            },
            function (reason) {
              self.messageToast('No se pudieron borrar los registros');
            }
          );
        };

        self.messageToast = function (message) {
          $mdToast.show(
            $mdToast.simple()
              .position('bottom left')
              .textContent(message)
              .hideDelay(3000)
          );
        };

        // Navigation sidenav
        $scope.showLeftSidenav = function () {
          $mdSidenav('left').toggle();
        };

      }
    ]
  });
