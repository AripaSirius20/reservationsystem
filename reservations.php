<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Rezervasyonlar</title>
</head>
<body>
<ul>
        <li><a href="index.php">Ana Sayfa</a></li>
        <li><a href="register.php">Kayıt Ol</a></li>
        <li><a href="login.php">Oturum Aç</a></li>
        <li><a href="reservation.php">Rezervasyon Yap</a></li>
        <li><a href="reservations.php">Rezervasyonlar</a></li>
    </ul>
    <div class="container">
        <h1>Rezervasyonlarınız</h1>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tarih</th>
                        <th>Saat</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Burada rezervasyonları çekmek için SQL sorgusu yapmalısınız
                    // $reservations değişkeni, kullanıcının rezervasyonlarını içermelidir
                    foreach ($reservations as $reservation) {
                        echo "<tr>
                                <td>{$reservation['id']}</td>
                                <td>{$reservation['date']}</td>
                                <td>{$reservation['time']}</td>
                                <td>{$reservation['status']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
