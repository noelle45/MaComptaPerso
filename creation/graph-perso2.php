
<!--<script src="../includes/Chart.bundle.js"></script>
<script src="../includes/utils.js"></script>-->


<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width-device-width, initial-scale-1.0">
    
    <meta http-equiv="X-UA-compatible" content="ie-edge">

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"> </script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" />
    <title></title>
    
    </head>
    
    <body>
        
        <? include('../includes/graph-depenses-perso.php'); ?>
        
        <div class="container">
            <canvas id="myChartPerso"></canvas>
        </div>
        
        <script>
            let myChartPerso = document.getElementById('myChartPerso').getContext('2d');
            
            let dataMyBudgetPerso = new Chart(myChartPerso, {
                type:'horizontalBar', //bar,horizontalBar, pie,line, doughnut, radar,polarAred
                data:{
                    labels:['Logement','Transport','Sante','Loisir','Impots','Epargne','Alimentation','Animaux','Scolaire','Vetements','Frais_bancaire','Frais_professionnels','Cadeaux','Autre'],
                datasets:[{
                    label:'Depenses personnelles réelles',
                    data:[
                        <?= $Logement_perso ?>,
						<?= $Transport_perso ?>,
						<?= $Sante_perso ?>,
						<?= $Loisir_perso ?>,
						<?= $Impots_perso ?>,
                        <?= $Epargne_perso ?>,
                        <?= $Alimentation_perso ?>,
                        <?= $Animaux_perso ?>,
                        <?= $Scolaire_perso ?>,
                        <?= $Vetements_perso ?>,
                        <?= $Frais_bancaire_perso ?>,
                        <?= $Frais_professionnels_perso ?>,
                        <?= $Cadeaux_perso ?>,
                        <?= $Autre_perso ?>
                ],
                    backgroundColor:[
                        'rgba( 236, 112, 99 )',
                        'rgba( 175, 122, 197 )',
                        'rgba( 165, 105, 189 )',
                        'rgba( 84, 153, 199 )',
                        'rgba( 93, 173, 226 )',
                        'rgba( 72, 201, 76 )',
                        'rgba( 69, 79, 157 )',
                        'rgba( 82, 190, 128 )',
                        'rgba( 88, 214, 141 )',
                        'rgba( 244, 208, 63 )',
                        'rgba( 245, 176, 65 )',
                        'rgba( 235, 152, 78 )',
                        'rgba( 220, 118, 51 )',
                        'rgba( 52, 73, 94 )'
                    ]
                
            }]
            },
                options:{
                    legend:{
                        display:false
                    }
                }
            });
        </script>
    </body>