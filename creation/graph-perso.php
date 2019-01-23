<script src="../includes/Chart.bundle.js"></script>
<script src="../includes/utils.js"></script>

<?php
// variables
$queryLogement=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Logement"
AND pointer=1
AND debit_credit="D"
');
$queryLogement->execute();
$dataLogement = $queryLogement->fetch();
$resultLogement = $dataLogement[0];
    
$queryViequotidienneautreachat=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Vie_quotidienne_autre_achat"
AND pointer=1
AND debit_credit="D"
');
$queryViequotidienneautreachat->execute();
$dataVie_quotidienne_autre_achat = $queryViequotidienneautreachat->fetch();
$resultVie_quotidienne_autre_achat = $dataVie_quotidienne_autre_achat[0];

$queryADSL_cable=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Vie_quotidienne_autre_achat"
AND pointer=1
AND debit_credit="D"
');
$queryADSL_cable->execute();
$dataADSL_cable = $queryADSL_cable->fetch();
$resultADSL_cable = $dataADSL_cable[0];
    
$queryTelephone_mobile=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Telephone_mobile"
AND pointer=1
AND debit_credit="D"
');
$queryTelephone_mobile->execute();
$dataTelephone_mobile = $queryTelephone_mobile->fetch();
$resultTelephone_mobile = $dataTelephone_mobile[0];
    
    $logement = $resultTelephone_mobile+$resultVie_quotidienne_autre_achat+$resultLogement+$resultADSL_cable;
    

$querySante=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Sante"
AND pointer=1
AND debit_credit="D"
');
$querySante->execute();
$dataSante = $querySante->fetch();
            
$queryTransport=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Transport"
AND pointer=1
AND debit_credit="D"
');
$queryTransport->execute();
$dataTransport = $queryTransport->fetch();
            
$queryLoisir=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Loisir"
AND pointer=1
AND debit_credit="D"
');
$queryLoisir->execute();
$dataLoisir = $queryLoisir->fetch();
            
$queryImpots=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Impots"
AND pointer=1
AND debit_credit="D"
');
$queryImpots->execute();
$dataImpots = $queryImpots->fetch();
            
$queryEpargne=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Epargne"
AND pointer=1
AND debit_credit="D"
');
$queryEpargne->execute();
$dataEpargne = $queryEpargne->fetch();
            
$queryAlimentation=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Alimentation"
AND pointer=1
AND debit_credit="D"
');
$queryAlimentation->execute();
$dataAlimentation = $queryAlimentation->fetch();

            
$queryAnimaux=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Animaux"
AND pointer=1
AND debit_credit="D"
');
$queryAnimaux->execute();
$dataAnimaux = $queryAnimaux->fetch();
            
$queryScolaire=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Scolaire"
AND pointer=1
AND debit_credit="D"
');
$queryScolaire->execute();
$dataScolaire = $queryScolaire->fetch();
            
$queryVetements=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Vetements"
AND pointer=1
AND debit_credit="D"
');
$queryVetements->execute();
$dataVetements = $queryVetements->fetch();
            
$queryFraisbancaire=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Frais_banquaire"
AND pointer=1
AND debit_credit="D"
');
$queryFraisbancaire->execute();
$dataFraisbancaire = $queryFraisbancaire->fetch();
            
$queryFraisprofessionnels=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Frais_professionnels"
AND pointer=1
AND debit_credit="D"
');
$queryFraisprofessionnels->execute();
$dataFraisprofessionnels = $queryFraisprofessionnels->fetch();
            
$queryCadeaux=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Cadeaux"
AND pointer=1
AND debit_credit="D"
');
$queryCadeaux->execute();
$dataCadeaux = $queryCadeaux->fetch();
            
$queryAutre=$db->prepare('SELECT sum(montant) FROM ecritures WHERE categorie="Autre"
AND pointer=1
AND debit_credit="D"
');
$queryAutre->execute();
$dataAutre = $queryAutre->fetch();

            $Logement = $logement;
			$Transport = $dataTransport[0];
			$Sante = $dataSante[0];
            $Loisir = $dataLoisir[0];
            $Impots = $dataImpots[0];
            $Epargne = $dataEpargne[0];
            $Alimentation = $dataAlimentation[0];
            $Animaux = $dataAnimaux[0];
            $Scolaire = $dataScolaire[0];
            $Vetements = $dataVetements[0];
            $Frais_bancaire = $dataFraisbancaire[0];
            $Frais_professionnels = $dataFraisprofessionnels[0];
            $Cadeaux = $dataCadeaux[0];
            $Autre = $dataAutre[0];
            
            //=========================
?>

<div id="canvas-holder" style="width:100%">
		<canvas id="chart-area"></canvas>
	</div>
	
	<script>
		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
				        <?= $Logement ?>,
						<?= $Transport ?>,
						<?= $Sante ?>,
						<?= $Loisir ?>,
						<?= $Impots ?>,
                        <?= $Epargne ?>,
                        <?= $Alimentation ?>,
                        <?= $Animaux ?>,
                        <?= $Scolaire ?>,
                        <?= $Vetements ?>,
                        <?= $Frais_bancaire ?>,
                        <?= $Frais_professionnels ?>,
                        <?= $Cadeaux ?>,
                        <?= $Autre ?>,
					],
					backgroundColor: [
						'rgba(255, 99, 132, 0.6)' ,
						'rgba(54, 162, 235, 0.6)',
						'rgba(255, 206, 86, 0.6)',
						'rgba(75, 192, 192, 0.6)',
						'rgba(153, 99, 132, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 99, 255, 0.6)',
                        'rgba(100, 105, 92, 0.6)',
                        'rgba(65, 99, 132, 0.6)',
                        'rgba(178, 205, 132, 0.6)',
                        'rgba(68, 68, 132, 0.6)',
                        'rgba(255, 200, 132, 0.6)',
                        'rgba(198, 205, 255, 0.6)'
					],
                    
					label: 'Graphique de mes dépenses réelles'
				}],
				labels: [
					'Logement',
					'Transport',
					'Santé',
					'Loisir',
					'Impôts',
                    'Epargne',
                    'Alimentation',
                    'Animaux',
                    'Scolaire',
                    'Vêtements',
                    'Frais bancaire',
                    'Frais professionnels',
                    'Cadeaux',
                    'Autre'
				]
			},
			options: {
				responsive: true,
            }
            }
        ;

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
<?                        