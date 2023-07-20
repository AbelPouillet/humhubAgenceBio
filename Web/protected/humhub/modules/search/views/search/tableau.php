
<html>

<head></head>
<table>
    <thead>
        <tr>
            <td>Num</td>
            <td>Producteur</td>
            <td>Adresse1</td>
            <td>Adresse2</td>
            <td>Adresse3</td>
            <td>Type</td>
            <td>Personne</td>
            <td>Email</td>
            <td>Tel1</td>
            <td>Tel2</td>
            <td> Etiquette(s) </td>
        </tr>
    </thead>
    <tbody>

        <!--Insertion des lignes du tableau-->
    <?php foreach($rows as $row): ?>
        <?= $row ?>
    <?php endforeach?>
    </tbody>
</table>

</html>
