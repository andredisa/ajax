<?php
include_once("../classes/GestioneProdotti.php");
$gestione = new GestioneProdotti();

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['idUtente'])) {
    $idUtente = $_SESSION['idUtente'];
} else {
    header("Location: prodotti.php");
    exit();
}
?>


<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function updateMessage(message) {
            document.getElementById("message").innerHTML = message;
        }

        $(document).ready(function() {
            $("#aggiungiProdotto").click(function() {
                let nome = document.getElementById("nomeProdotto").value;
                if (nome != "") {
                    let prezzo = document.getElementById("prezzoProdotto").value;
                    if (prezzo != null || prezzo >= 0) {
                        let quantita = document.getElementById("quantitaProdotto").value;
                        if (quantita != null || quantita >= 0) {
                            let select = document.getElementById("selectTipologia");
                            let tipologia = select.value;
                            if (tipologia != "") {
                                //richiesta aggiungi
                                $.get("../AJAX/addProdotto.php", {
                                    nome: nome,
                                    prezzo: prezzo,
                                    quantita: quantita,
                                    tipologia: tipologia
                                }, function(data) {
                                    updateMessage(data["message"]);
                                }, "json");
                            } else {
                                updateMessage("Errore: Inserire una tipologia");
                            }
                        } else {
                            updateMessage("Errore: Inserire una quantità");
                        }
                    } else {
                        updateMessage("Errore: Inserire un prezzo");
                    }
                } else {
                    updateMessage("Errore: Inserire un nome");
                }
            });
        });
    </script>
</head>

<body>
    <h1>Aggiungi prodotto</h1>
    <br>
    Nome: <input type="text" id="nomeProdotto">
    <br>
    Prezzo: <input type="number" id="prezzoProdotto" min=0>
    <br>
    Quantita': <input type="number" id="quantitaProdotto" min=1>
    <br>
    Tipologia: <select id='selectTipologia'>
        <?php
        $mysqli = new mysqli("localhost", "root", "", "preverifica");
        $stmt = $mysqli->prepare("SELECT DISTINCT tipologia FROM prodotto");
        $stmt->execute();
        $query = $stmt->get_result();
        $html = "";
        while ($row = $query->fetch_assoc()) {
            $tipologia = $row['tipologia']; // accedi al valore della colonna 'tipologia'
            $html .= "<option value='$tipologia'>$tipologia</option>";
        }
        echo $html;
        ?>
    </select>
    <br>
    <button id="aggiungiProdotto">INVIA</button>
    <button onclick="window.location.href='prodotti.php'">INDIETRO</button>
    <div id="divMessage">
        <span id="message"></span>
    </div>
</body>

</html>