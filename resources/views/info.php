<?php
insertTemplate('/templates/header', ['data' => $data]);
$userId = userId();
?>

<main>
    <h1 class="text-body-emphasis">Info</h1>

</main>

<?php
insertTemplate('/templates/footer-pages', ['data' => $data]);

// echo '<pre>';
// var_dump(userAllDataNew());
// echo '</pre>';
