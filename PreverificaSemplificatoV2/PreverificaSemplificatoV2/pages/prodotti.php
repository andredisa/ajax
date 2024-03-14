<?php
include_once("../classes/GestioneProdotti.php");
$gestione = new GestioneProdotti();

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['idUtente'])) {
    $idUtente = $_SESSION['idUtente'];
} else {
    header("Location: ../index.html");
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

        function elimina(button) {
            if (confirm("Confermare azione? (non sarà possibile tornare indietro!)") == true) {
                let idProdotto = button.id;
                $.get("../AJAX/eliminaProdotto.php", {
                    idProdotto: idProdotto
                }, function(data) {
                    updateMessage(data["message"]);
                }, "json");
            }
        }

        function modifica(button) {
            let idProdotto = button.id;
            window.location.href = "modifica.php?idProdotto=" + idProdotto;
        }


        $(document).ready(function() {
            //lista prodotti
            $.get("../AJAX/getProdotti.php", {
                tipologia: "Tutti"
            }, function(data) {
                if (data["status"] == "Ok") {
                    let listaProdotti = data["list"];

                    //crea HTML da stampare
                    $.get("../AJAX/stampaProdotti.php", {
                        list: listaProdotti
                    }, function(data) {
                        if (data["status"] == "Ok") {
                            $("body").append(data["html"]);

                            $("#aggiungiProdotto").click(function() {
                                window.location.href = "aggiungi.php";
                            });
                        }
                    }, "json");
                }

            }, "json");


        });
    </script>

    <style>
        table,
        td,
        tr,
        th {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="divMessage">
        <span id="message"></span>
    </div>
    <button onclick="window.location.href='logout.php'">LOGOUT</button>
</body>

</html>