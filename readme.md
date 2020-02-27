# Marketplace API

## Products
### Get All Products
    http://{baseurl}/api/products
    Method : GET
To get all products data, you can use the api link above.

### Get A Product
##### By Slug
    http://{baseurl}/api/product/{slug-product}
    Method : GET

Example :
```
    GET : http://210.210.154.65:4444/api/product/macbook-pro-md101
```
To get a product data (detail) by it's slug you can use api link above.

##### By ID
    http://{baseurl}/api/product-by-id/
    Method : GET

Example :
```
    GET : http://210.210.154.65:4444/api/product-by-id/10101
```
To get a product data (detail) by it's ID you can use api link above.

### Post A Product
     http://{baseurl}/api/products
     Method : POST

      This method Can be done in two way
        1. with JSON
        2. with x-www-form-urlencoded

     Parameter :
        1. productName
        2. productDesc
        3. productQty
        4. productImage (String base64)
        5. productPrice
        6. merchantId
        7. categoryId

Example :
```
        POST : http://210.210.154.65:4444/api/products
```

1. With JSON 
(do with JsonObjectRequest in Volley Android)
```
        Set Header :
            Content-type : application/json
```
2. With x-www-form-urlencoded 
(do with StringRequest in Volley Android)

```    
        Set Header :
            Content-type : application/x-www-form-urlencoded
```
Parameter : Value
```
        productName => "Macbook Pro md101 
        productDesc => "macbook unit and magsafe only"
        productQty => 1
        productImage => YXNsZGFsa3NkbGFsZGFzZGFzamxka2xramRsa2FzZGprbGFqZHNsamFzamRsYXNkamxrYWRsaiBxd2RqbHF3ZGpsa3F3IGpkbHF3bGRrbGRscXdqa2R3cQ==
        productPrice => 20000
        merchantId =>1011
        categoryId =>1011
```
In JSON example :
``` json
        "productName":"Macbook Pro md101 "
        "productDesc":"macbook unit and magsafe only"
        "productQty":1
        "productImage":"YXNsZGFsa3NkbGFsZGFzZGFzamxka2xramRsa2FzZGprbGFqZHNsamFzamRsYXNkamxrYWRsaiBxd2RqbHF3ZGpsa3F3IGpkbHF3bGRrbGRscXdqa2R3cQ=="
        "productPrice":20000
        "merchantId":1011
        "categoryId":1011
```
### Update A Product
    http://{baseurl}/api/product/{id}/update
    Method : PUT

    This method Can be done in two way
        1. with JSON
        2. with x-www-form-urlencoded
    
    Parameter :
        1. productName
        2. productDesc
        3. productQty
        4. productImage (String base64)
        5. productPrice
        6. merchantId
        7. categoryId

Example :
```
        PUT : http://210.210.154.65:4444/api/product/101/update
```

1. With JSON 
(do with JsonObjectRequest in Volley Android)
```
        Set Header :
            Content-type : application/json
```
2. With x-www-form-urlencoded 
(do with StringRequest in Volley Android)

```    
        Set Header :
            Content-type : application/x-www-form-urlencoded
```
Parameter : Value
```
        productName => "Macbook Pro md101 
        productDesc => "macbook unit and magsafe only"
        productQty => 1
        productImage => YXNsZGFsa3NkbGFsZGFzZGFzamxka2xramRsa2FzZGprbGFqZHNsamFzamRsYXNkamxrYWRsaiBxd2RqbHF3ZGpsa3F3IGpkbHF3bGRrbGRscXdqa2R3cQ==
        productPrice => 20000
        merchantId =>1011
        categoryId =>1011
```
In JSON example :
``` json
        "productName":"Macbook Pro md101 "
        "productDesc":"macbook unit and magsafe only"
        "productQty":1
        "productImage":"YXNsZGFsa3NkbGFsZGFzZGFzamxka2xramRsa2FzZGprbGFqZHNsamFzamRsYXNkamxrYWRsaiBxd2RqbHF3ZGpsa3F3IGpkbHF3bGRrbGRscXdqa2R3cQ=="
        "productPrice":20000
        "merchantId":1011
        "categoryId":1011
```


### Delete A Product
    http://{baseurl}/api/product/{ID}/delete
    Method : DELETE

Example :
```
         DELETE : http://210.210.154.65:4444/api/product/101/delete
```



## Categories
### Get All Categories
    http://{baseurl}/api/categories
    Method : GET

Example :
```
        GET : http://210.210.154.65:4444/api/categories
```
To retrive all categories, you can use api link above


