<?php
require_once "../connect.php";

$products = [
    ['CeraVe Foaming Cleanser', '../images/f2.webp', 'CeraVe Foaming Cleanser', 2500.00, 5],
    ['12 Vitamin C Tablets', '../images/f1.png', '12 Vitamin C Tablets', 508.00, 5],
    ['Seven Seas Cod-Liver Oil', '../images/f3.webp', 'Seven Seas Cod-Liver Oil', 588.00, 5],
    ['10s Flu-Gone Capsules', '../images/f4.webp', '10s Flu-Gone Capsules', 385.00, 5],
    ['100s Panadol Capsules', '../images/f5.webp', '100s Panadol Capsules', 923.00, 5],
    ['Strepsils Strawberry Sugar Free', '../images/f6.webp', 'Strepsils Strawberry Sugar Free', 255.00, 5],
    ['Diabetone Tabs 30s', '../images/f7.webp', 'Diabetone Tabs 30s', 1534.00, 5],
    ['La Roche-Posay Effaclar Acnes Routine Kit 3 in 1', '../images/f8.webp', 'La Roche-Posay Effaclar Acnes Routine Kit 3 in 1', 4050.00, 5],
    ['Wow Gauze Bandages 2 12s', '../images/f9.webp', 'Wow Gauze Bandages 2 12s', 93.00, 5],
    ['Avalife Advance Rescue Caps 30s', '../images/f10.webp', 'Avalife Advance Rescue Caps 30s', 1930.00, 5],
    ['Zentel 400 mg Tablets 1s', '../images/f11.webp', 'Zentel 400 mg Tablets 1s', 313.00, 5],
    ['Jamieson Women Probiotic 45\'s', '../images/f12.webp', 'Jamieson Women Probiotic 45\'s', 4080.00, 5],
    ['Betadine Mouthwash 250ml', '../images/f13.webp', 'Betadine Mouthwash 250ml', 1013.00, 5],
    ['Amoxicillin 500mg Capsules 100\'s', '../images/f14.png', 'Amoxicillin 500mg Capsules 100\'s', 600.00, 5],
    ['Enterogermina Probiotic 10\'s', '../images/f15.JPG', 'Enterogermina Probiotic 10\'s', 1306.00, 5]
];

$stmt = $conn->prepare("INSERT INTO products (name, image_url, description, price, rating) VALUES (?, ?, ?, ?, ?)");
foreach ($products as $product) {
    $stmt->bind_param("sssdi", $product[0], $product[1], $product[2], $product[3], $product[4]);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo "Products inserted successfully!";
?>
