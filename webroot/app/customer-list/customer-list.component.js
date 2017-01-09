'use strict';

// Register `customerList` component, along with its associated controller
// and template
angular.
  module('customerList').
  component('customerList', {
    templateUrl: 'customer-list/customer-list.template.html',
    controller: ['$routeParams', '$location', 'Customer',
      function CustomerListController($routeParams, $location, Customer) {

        this.query = {
          order: 'last_name',
          limit: 5,
          page: 1
        };

        this.selected = []; // list of selected customers in the table

        this.customer = null;

        // List
        this.customers = Customer.list(); //

        // View
        this.viewCustomer = function() {
          this.customer = Customer.view({customerId: $routeParams.customerId});
        }

        // Add
        this.addCustomer = function() {
          Customer.add(this.customer);
        }

        // Edit
        this.editCustomer = function(editedCustomer) {
          Customer.edit(editedCustomer);
        }

        // Delete
        this.deleteCustomer = function() {
          Customer.delete({customerId: $routeParams.customerId});
        }

      }
    ]
  });
