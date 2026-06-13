<?php
session_start();

echo '<pre>';
echo 'SESSION completa: ';
print_r($_SESSION);
echo '</pre>';

echo '<pre>';
echo 'Flash: ';
print_r($_SESSION['flash'] ?? 'VAZIO');
echo '</pre>';
?>