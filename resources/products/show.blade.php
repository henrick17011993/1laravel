<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
</head>
<body>
    <h1>{{ $product->name }}</h1>
    <p>Price: ${{ $product->price }}</p>
    <a href="{{ route('products.index') }}">Back to List</a>
</body>
</html>
