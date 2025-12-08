<?php
$server = "db";
$utente_db = "myuser";
$password_db = "mypassword";
$database = "myapp_db";

$conn = new mysqli($server, $utente_db, $password_db, $database);
if ($conn->connect_error) die("Connessione fallita: " . $conn->connect_error);

// Inserimento utente
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nome"], $_POST["email"]) && !isset($_POST["modifica_id"])) {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $conn->query("INSERT INTO utenti (nome, email) VALUES ('$nome', '$email')");
}

// Eliminazione utente
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["elimina_id"])) {
    $id = $_POST["elimina_id"];
    $conn->query("DELETE FROM utenti WHERE id='$id'");
}

// Modifica utente
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["modifica_id"], $_POST["modifica_nome"], $_POST["modifica_email"])) {
    $id = $_POST["modifica_id"];
    $nome = trim($_POST["modifica_nome"]);
    $email = trim($_POST["modifica_email"]);
    $conn->query("UPDATE utenti SET nome='$nome', email='$email' WHERE id='$id'");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gestione utenti</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.hidden { display: none; }
</style>
<script>
function Modifica(id) {
    var riga = document.getElementById('riga-modifica-' + id);
    riga.classList.remove('hidden');
}
</script>
</head>
<body class="p-5 bg-light">

<div class="container">

<h2>Inserisci nuovo utente</h2>
<form method="post" class="row g-3 mb-5">
    <div class="col-md-4">
        <input type="text" name="nome" class="form-control" placeholder="Nome e Cognome" required>
    </div>
    <div class="col-md-4">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary">Inserisci</button>
    </div>
</form>

<h2>Lista utenti</h2>
<table class="table table-bordered table-striped bg-white">
<tr class="table-dark">
    <th>ID</th>
    <th>Nome</th>
    <th>Email</th>
    <th>Azioni</th>
</tr>

<?php
$risultato = $conn->query("SELECT * FROM utenti ORDER BY id");
if ($risultato) {
    while ($utente = $risultato->fetch_assoc()) {
        // Riga principale
        echo "<tr>";
        echo "<td>" . $utente['id'] . "</td>";
        echo "<td>" . htmlspecialchars($utente['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($utente['email']) . "</td>";
        echo "<td>
                <button type='button' class='btn btn-warning btn-sm' onclick='Modifica(" . $utente['id'] . ")'>Modifica</button>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='elimina_id' value='" . $utente['id'] . "'>
                    <button type='submit' class='btn btn-danger btn-sm'>Elimina</button>
                </form>
              </td>";
        echo "</tr>";

        // Riga nascosta per modifica sotto la riga
        echo "<tr id='riga-modifica-" . $utente['id'] . "' class='hidden'>";
        echo "<td colspan='4'>
                <form method='post' class='row g-3 align-items-center'>
                    <input type='hidden' name='modifica_id' value='" . $utente['id'] . "'>
                    <div class='col-md-4'>
                        <input type='text' name='modifica_nome' class='form-control' value='" . htmlspecialchars($utente['nome']) . "' required>
                    </div>
                    <div class='col-md-4'>
                        <input type='email' name='modifica_email' class='form-control' value='" . htmlspecialchars($utente['email']) . "' required>
                    </div>
                    <div class='col-md-4'>
                        <button type='submit' class='btn btn-success btn-sm'>Salva</button>
                    </div>
                </form>
              </td>";
        echo "</tr>";
    }
}
$conn->close();
?>
</table>

</div>
</body>
</html>
