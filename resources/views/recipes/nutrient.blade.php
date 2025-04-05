<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Nutrients</title>
</head>

<body>
    <!-- コントローラークラスに入力情報を送るためにPOSTメソッドを使う -->
    <form action="/nutrientSerch" method="POST">
        @csrf
        <input type="text" name='nutrient' required placeholder="食材名を入力してください">
        <input type="submit" value="食材登録">
    </form>


</body>