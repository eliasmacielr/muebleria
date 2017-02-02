# Access Point Guide
REST APIs follow CakePHP conventions (not completely) for paths. See [CakePHP routing](http://book.cakephp.org/3.0/en/development/routing.html#creating-restful-routes).

*All access point are available in Postman Collection*

### Example

HTTP verbs | URL.format      | actions
---------- | --------------- | -------
GET        | /resources/     | List
GET        | /resources/123/ | View
POST       | /resources/     | Add
PUT        | /resources/123/ | Edit
DELETE     | /resources/123/ | Delete

# Let's start

All access point are prefixed with **"api"**.

Not all responses with HTTP code 200 are OK, always Check response status field (true/false).

[For pagination information](https://github.com/bcrowe/cakephp-api-pagination)

## HTTP requests Headers
For all requests
  - Accept: application/json
  - Content-Type: application/json (*With some exceptions*)

## Products

- Base path: products

Methods | Paths  | Actions | Responses
------- | ------ | ------- | ---------
GET | / | Index | {"products": object[], "status": boolean, "pagination": {}}
GET | /:id | View | {"product": {}, "status": boolean}
GET | /:slug | View | {"product": {}, "status": boolean}
POST | / | Add | {"product": {}, "status": boolean, "message": string, "errors": string[]}
PUT | /:id | Edit | {"product": {}, "status": boolean, "message": string, "errors": string[]}
PUT | /:slug | Edit | {"product": {}, "status": boolean, "message": string, "errors": string[]}
DELETE | /:id | Delete | {"product": {}, "status": boolean, "message": string}
DELETE | /:slug | Delete | {"product": {}, "status": boolean, "message": string}
DELETE | /delete-all | Delete All | {"products": {}, "status": boolean, "message": string}

##### Extra

For Delete All action the request must be sent with a json {“ids”: int[]}, with products' ids


## Product Images

  - Access Point are prefixed with products/:id
  - Action Add need header Content-Type: multipart/form-data
  - Base path: images

Methods | Paths  | Actions | Responses
------- | ------ | ------- | ---------
GET | / | Index | {"productImages": object[], "status": boolean, "pagination": {}}
GET | /:id | View | {"productImage": {}, "status": boolean}
POST | / | Add | {"productImage": {}, "status": boolean, "message": string, "errors": string[]}
PUT | /:id | Mark as Main | {"productImage": {}, "status": boolean, "message": string, "errors": string[]}
DELETE | /:id | Delete | {"productImage": {}, "status": boolean, "message": string}

## Product Specifications

  - Access Point are prefixed with products/:id
  - Base path: specifications

Methods | Paths  | Actions | Responses
------- | ------ | ------- | ---------
GET | / | Index | {"productSpecifications": object[], "status": boolean, "pagination": {}}
GET | /:id | View | {"productSpecification": {}, "status": boolean}
POST | / | Add | {"productSpecification": {}, "status": boolean, "message": string, "errors": string[]}
PUT | /:id | Mark as Main | {"productSpecification": {}, "status": boolean, "message": string, "errors": string[]}
DELETE | /:id | Delete | {"productSpecification": {}, "status": boolean, "message": string}

## Categories

- Base path: categories

Methods | Paths  | Actions | Responses
------- | ------ | ------- | ---------
GET | / | Index | {"categories": object[], "status": boolean, "pagination": {}}
GET | /:id | View | {"category": {}, "status": boolean}
GET | /:slug | View | {"category": {}, "status": boolean}
POST | / | Add | {"category": {}, "status": boolean, "message": string, "errors": string[]}
PUT | /:id | Edit | {"category": {}, "status": boolean, "message": string, "errors": string[]}
PUT | /:slug | Edit | {"category": {}, "status": boolean, "message": string, "errors": string[]}
DELETE | /:id | Delete | {"category": {}, "status": boolean, "message": string}
DELETE | /:slug | Delete | {"category": {}, "status": boolean, "message": string}

##### Extra
Cancel pagination when list all records use paged=0 in url query

## Users

- Base path: users

Methods | Paths  | Actions | Responses
------- | ------ | ------- | ---------
GET | / | Index | {"users": object[], "status": boolean, "pagination": {}}
GET | /:id | View | {"user": {}, "status": boolean}
POST | / | Add | {"user": {}, "status": boolean, "message": string, "errors": string[]}
PUT | /:id | Edit | {"user": {}, "status": boolean, "message": string, "errors": string[]}
DELETE | /:id | Delete | {"user": {}, "status": boolean, "message": string}

## Setting

- Base path: setting

Methods | Paths  | Actions | Responses
------- | ------ | ------- | ---------
GET | / | View | {"setting": {}, "status": boolean}
PUT | / | Edit | {"setting": {}, "status": boolean, "message": string, "errors": string[]}


# Search with Url query

## Products

  - name: Result in search LIKE: `WHERE name LIKE %$name%`
  - lte: Compare less than or equal to price field: `WHERE $lte <= price`
  - gte: Compare greater than or equal to price: `WHERE $gte >= price`
  - btw: Compare price between values, usage btw[]=value0&btw[]=value1`: `WHERE price BETWEEN $btw[0] and $btw[1]`
  - category_id: `WHERE $category_id = category_id`

## Categories

  - name: Result in search LIKE: `WHERE name LIKE %$name%`

## Users

  - name: Result in search LIKE: `WHERE name LIKE %$name%`
  - last_name: Result in search LIKE: `WHERE last_name LIKE %$last_name%`
  - username: Result in search LIKE: `WHERE username LIKE %$username%`
  - role: `WHERE $role = role`
