<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Aanvraag nieuwsbrief</h1>
    <form method="POST">
        <input type="text" name="voornaam" placeholder="Wat is uw voornaam in!" required>
        <input type="text" name="tussenvoegsel" placeholder="Heeft u een tussenvoegsel">
        <input type="text" name="achternaam" placeholder="Wat is uw achternaam?" required><br>

        <input type="date" name="geboortedatum" required><br>

        <input type="text" name="straat" placeholder="Wat is uw straatnaam en nummer?" style="width:510px" required><br>
        <input type="text" name="postcode" placeholder="Wat is uw postcode?" required>
        <input type="text" name="woonplaats" placeholder="Wat is uw woonplaats?" required>
        <input type="text" name="telefoonnummer" placeholder="Wat is uw telefoonnummer" required> <br>

        <input type="checkbox" name="akkoord" id="akkoord" required>
        <label for="akkoord">Ik ga akkoord met de voorwaarden zoals vermeld op de website!</label> <br>

        <input type="submit" value="Verzenden">
    </form>
</body>

</html>
<?php
$host = 'localhost';
$dbname = 'ontwikkel';
$username = 'root';
$password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = ($_POST['voornaam']);
    $tussenvoegsel = ($_POST['tussenvoegsel']);
    $achternaam = ($_POST['achternaam']);
    $geboortedatum = $_POST['geboortedatum'];
    $straat = ($_POST['straat']);
    $postcode = ($_POST['postcode']);
    $woonplaats = ($_POST['woonplaats']);
    $telefoonnummer = ($_POST['telefoonnummer']);
    $akkoord = isset($_POST['akkoord']) ? 1 : 0;

    if (
        !empty($voornaam) &&
        !empty($achternaam) &&
        !empty($geboortedatum) &&
        !empty($straat) &&
        !empty($postcode) &&
        !empty($woonplaats) &&
        !empty($telefoonnummer) &&
        $akkoord === 1
    ) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "INSERT INTO nieuwsbrief 
            (voornaam, tussenvoegsel, achternaam, geboortedatum, straatnaam_num, postcode, woonplaats, telefoonnummer, akkoord)
            VALUES
            (:voornaam, :tussenvoegsel, :achternaam, :geboortedatum, :straatnaam_num, :postcode, :woonplaats, :telefoonnummer, :akkoord)";

            $statement = $pdo->prepare($query);

            $statement->execute([
                ':voornaam' => $voornaam,
                ':tussenvoegsel' => $tussenvoegsel,
                ':achternaam' => $achternaam,
                ':geboortedatum' => $geboortedatum,
                ':straatnaam_num' => $straat,
                ':postcode' => $postcode,
                ':woonplaats' => $woonplaats,
                ':telefoonnummer' => $telefoonnummer,
                ':akkoord' => $akkoord
            ]);

            echo "Uw gegevens zijn opgeslagen!";
        } catch (PDOException $e) {
            echo "Foutmelding: " . $e->getMessage();
        }
    } else {
        echo "Vul alle verplichte velden correct in.";
    }
}
?>