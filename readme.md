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

    GET : http://210.210.154.65:4444/api/product/macbook-pro-md101
To get a product data (detail) by it's slug you can use api link above.

##### By ID
    http://{baseurl}/api/product-by-id/
    Method : GET

    Example :

    GET : http://210.210.154.65:4444/api/product-by-id/10101
To get a product data (detail) by it's ID you can use api link above.

### Post A Product
     http://{baseurl}/api/products
     Method : POST

     Parameter :
        1. productName
        2. productDesc
        3. productQty
        4. productImage (String base64)
        5. productPrice
        6. merchantId
        7. categoryId

    Example :
        POST : http://210.210.154.65:4444/api/products

        Parameter : Value
        1. productName => "Macbook Pro md101 
        2. productDesc => "macbook unit and magsafe only"
        3. productQty => 1
        4. productImage => YXNsZGFsa3NkbGFsZGFzZGFzamxka2xramRsa2FzZGprbGFqZHNsamFzamRsYXNkamxrYWRsaiBxd2RqbHF3ZGpsa3F3IGpkbHF3bGRrbGRscXdqa2R3cQ==
        5. productPrice => 20000
        6. merchantId =>1011
        7. categoryId =>1011

### Delete A Product
    http://{baseurl}/api/product/{ID}/delete
    Method : DELETE

    Example :
         DELETE : http://210.210.154.65:4444/api/product/101/delete

