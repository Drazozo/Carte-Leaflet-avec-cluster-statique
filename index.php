<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>OpenStreetMap</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
        <!-- CSS -->
        <style>
            #maCarte{
                height: 400px;
            }
        </style>
    </head>
    <body>
        <div id="maCarte"></div>

        <!-- Fichiers Javascript -->
        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
        <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
        <script>
            var villes = {
                "Paris": { "lat": 48.852969, "lon": 2.349903 },
                "Brest": { "lat": 48.383, "lon": -4.500 },
                "Quimper": { "lat": 48.000, "lon": -4.100 },
                "Bayonne": { "lat": 43.500, "lon": -1.467 }
            };
            var tableauMarqueurs = [];

            // On initialise la carte
            var carte = L.map('maCarte').setView([48.852969, 2.349903], 13);
            
            // On charge les "tuiles"
            L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                // Il est toujours bien de laisser le lien vers la source des données
                attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                minZoom: 1,
                maxZoom: 20
            }).addTo(carte);

            var marqueurs = L.markerClusterGroup();

            // On personnalise le marqueur
            var icone = L.icon({
                iconUrl: "icone.png",
                iconSize: [50, 50],
                iconAnchor: [25, 50],
                popupAnchor: [0, -50]
            })

            // On parcourt les différentes villes
            for(ville in villes){
                // On crée le marqueur et on lui attribue une popup
                var marqueur = L.marker([villes[ville].lat, villes[ville].lon], {icon: icone}); //.addTo(carte); Inutile lors de l'utilisation des clusters
                marqueur.bindPopup("<p>"+ville+"</p>");
                marqueurs.addLayer(marqueur); // On ajoute le marqueur au groupe

                // On ajoute le marqueur au tableau
                tableauMarqueurs.push(marqueur);
            }
            // On regroupe les marqueurs dans un groupe Leaflet
            var groupe = new L.featureGroup(tableauMarqueurs);

            // On adapte le zoom au groupe
            carte.fitBounds(groupe.getBounds().pad(0.5));

            carte.addLayer(marqueurs);
        </script>
    </body>
</html>