<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omer Batuhan Tandogan 21830754 Homework 2 - CTIS256</title>
    <style>

        body {
            text-align: center;
        }
      table {
  margin: 0 auto;
  border-collapse: collapse;
}

th, td {
  padding: 8px;
}

img {
  max-width: 100px;
  max-height: 100px;
}

.spacer {
  border-bottom: 1px solid #ddd;
}


table, th, td {
  border: none;
}

th {
  display: none;
}

td {
  text-align: left;
}
    </style>
</head>
<body>
    <h1>LAPTOPS</h1>
    <?php
    require_once './vendor/autoload.php';
    $httpClient = new GuzzleHttp\Client(["verify" => false]);
    $response = $httpClient->request("GET", "https://dummyjson.com/products/category/laptops");
    $data = json_decode($response->getBody()->getContents(), true);
    ?>
    <table>
        <tr>
            <th>Thumbnail</th>
            <th>Title</th>
            <th>Price</th>
        </tr>
        <?php foreach ($data['products'] as $item) : ?>
            <tr>
                <td>
                    <?php if (isset($item['thumbnail'])) : ?>
                        <img src="<?= $item['thumbnail'] ?>" alt="Thumbnail" width="100" height="100">
                    <?php else : ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td>
                    <a href="product.php?id=<?= $item['id'] ?>">
                        <?= isset($item['title']) ? $item['title'] : 'N/A' ?>
                    </a>
                </td>
                <td>
                    <?= isset($item['price']) ? '$' . $item['price'] : 'N/A' ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>Total: <?= isset($data['total']) ? $data['total'] : 'N/A' ?></p>
</body>
</html>
