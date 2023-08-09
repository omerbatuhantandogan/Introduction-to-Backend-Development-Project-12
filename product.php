<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    
    <style>
        body {
            text-align: center;
        }
        .thumbnail {
            display: block;
            margin: 0 auto;
        }
        .images-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .image-item {
            margin: 10px;
            cursor: pointer;
            width: 100px; 
            height: 100px; 
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            background-color: lightgray; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        th:first-child {
            font-weight: bold; 
            display: table-cell; 
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #000000; 
        }
        th {
            display: none; 
        }
        td.price-cell { 
            text-align: center;
            font-size: 40px; 
            color: blue; 
        }
        .back-link {
            margin-left: 5px; 
        }
        .big-image-container {
            display: flex;
            justify-content: center;
        }
        .big-image {
            width: 300px; 
            height: 300px; 
        }

        .thumbnails-container {
            padding: 10px;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

       
        .thumbnail-box {
            background-color: lightgray;
            border: 2px solid blue;
            border-radius: 8px;
            margin: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100px;
            height: 100px;
            transition: all 0.2s; 
        }

        
        .thumbnail-box.clicked {
            width: 120px; 
        }

       
        .thumbnail-image {
            width: 80px;
            height: 80px;
        }
    </style>
    
</head>
<body>
    
    <?php
    require_once './vendor/autoload.php';
    
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        $httpClient = new GuzzleHttp\Client(["verify" => false]);
        $response = $httpClient->request("GET", "https://dummyjson.com/products/{$productId}");
        $productData = json_decode($response->getBody()->getContents(), true);
        

        
        $imageUrl = $_GET['imageUrl'] ?? ($productData['images'][0] ?? null);
        $index = $_GET['index'] ?? 1;

        
        if ($index < 1 || $index > count($productData['images'])) {
            $index = 1; 
        }
    } else {
        echo "Product ID not found in the URL.";
    }
    ?>
    <?php if (isset($productData) && is_array($productData)) : ?>
        <h1><?= isset($productData['title']) ? $productData['title'] : 'N/A' ?></h1>
        <div class="big-image-container">
            <?php if (isset($productData['images'])) : ?>
                <img class="big-image thumbnail" src="<?= $imageUrl ?>" alt="Product Image <?= $index ?>">
            <?php endif; ?>
        </div>

       
        <div class="thumbnails-container">
            <?php if (isset($productData['images'])) : ?>
                <?php foreach ($productData['images'] as $index => $image) : ?>
                    <?php if ($index === 0) continue; ?>
               
                    <div class="thumbnail-box">
                        <a href="?id=<?= urlencode($productId) ?>&imageUrl=<?= urlencode($image) ?>&index=<?= $index + 1 ?>">
                            <img
                                class="thumbnail-image"
                                src="<?= $image ?>"
                                alt="Product Image <?= $index + 1 ?>"
                            >
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <table>
            <tr>
                <td><strong>Brand</strong></td>
                <td><?= isset($productData['brand']) ? $productData['brand'] : 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>Category</strong></td>
                <td><?= isset($productData['category']) ? $productData['category'] : 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>Description</strong></td>
                <td><?= isset($productData['description']) ? $productData['description'] : 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>Rating</strong></td>
                <td><?= isset($productData['rating']) ? $productData['rating'] : 'N/A' ?></td>
            </tr>
            <tr>
                <td><strong>Stock</strong></td>
                <td><?= isset($productData['stock']) ? $productData['stock'] : 'N/A' ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="price-cell"><?= isset($productData['price']) ? '$' . $productData['price'] : 'N/A' ?></td>
            </tr>
        </table>
        <p>
            <a href="index.php" class="back-link">&#8592; Products</a> 
        </p>
    <?php else : ?>
        <p>Product not found.</p>
    <?php endif; ?>
    <script>
 
 const thumbnailBoxes = document.querySelectorAll('.thumbnail-box');

 thumbnailBoxes.forEach((box) => {
     box.addEventListener('click', () => {
         thumbnailBoxes.forEach((otherBox) => {
             if (otherBox !== box) {
                 otherBox.classList.remove('clicked');
             }
         });
         box.classList.toggle('clicked');
     });
 });
</script>
    
</body>
</html>
