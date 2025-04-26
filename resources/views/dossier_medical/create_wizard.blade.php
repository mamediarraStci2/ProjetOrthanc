@extends('layouts.app')

@section('title', 'Nouveau dossier médical')

@section('content')
<div class="container">
    <!-- Fil d'ariane -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nouveau dossier médical</li>
        </ol>
    </nav>

    <h1 class="mb-4">Créer un dossier médical</h1>

    <!-- Barre de progression des étapes -->
    <div class="d-flex align-items-center mb-4">
        <div class="me-4 step step-active" id="step1Indicator">
            <span class="step-indicator">1</span>
            <span class="step-title">Informations Personnelles</span>
        </div>
        <div class="me-4 step" id="step2Indicator">
            <span class="step-indicator">2</span>
            <span class="step-title">Infos Médicales de Base</span>
        </div>
        <div class="me-4 step" id="step3Indicator">
            <span class="step-indicator">3</span>
            <span class="step-title">Antécédents Médicaux</span>
        </div>
        <div class="me-4 step" id="step4Indicator">
            <span class="step-indicator">4</span>
            <span class="step-title">Infos Familiales</span>
        </div>
        <div class="me-4 step" id="step5Indicator">
            <span class="step-indicator">5</span>
            <span class="step-title">Infos Administratives</span>
        </div>
        <div class="me-4 step" id="step6Indicator">
            <span class="step-indicator">6</span>
            <span class="step-title">Validation & NNS</span>
        </div>
    </div>

    <!-- Affichage des erreurs (si présentes) -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez vérifier les erreurs suivantes :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="dossierForm" action="{{ route('dossier_medical.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- ÉTAPE 1 : Informations Personnelles -->
        <div class="card mb-3" id="step1">
            <div class="card-header" style="background-color: var(--bleu-fonce); color: var(--blanc-pur);">
                <strong>Informations Personnelles</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="nom" id="nom" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" name="prenom" id="prenom" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="date_naissance" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                    <input type="date" name="date_naissance" id="date_naissance" class="form-control" required onchange="togglePoidsNaissance()"/>
                </div>
                <div class="mb-3">
                    <label for="lieu_naissance" class="form-label">Lieu de naissance <span class="text-danger">*</span></label>
                    <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="sexe" class="form-label">Sexe <span class="text-danger">*</span></label>
                    <select name="sexe" id="sexe" class="form-select" required>
                        <option value="">--Sélectionnez--</option>
                        <option value="Masculin">Masculin</option>
                        <option value="Féminin">Féminin</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="num_extrait_naissance" class="form-label">N° d'extrait de naissance (ou CNI) <span class="text-danger">*</span></label>
                    <input type="text" name="num_extrait_naissance" id="num_extrait_naissance" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="nationalite" class="form-label">Nationalité</label>
                    <input type="text" name="nationalite" id="nationalite" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse complète</label>
                    <textarea name="adresse" id="adresse" rows="2" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="profession" class="form-label">Profession</label>
                    <input type="text" name="profession" id="profession" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="contact_urgence" class="form-label">Personne à contacter en cas d'urgence</label>
                    <input type="text" name="contact_urgence" id="contact_urgence" class="form-control" placeholder="Nom, Téléphone, Relation"/>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo (optionnel)</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*" />
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4" id="step1Buttons">
            <button type="button" class="btn btn-primary" onclick="goToStep(2)">Suivant</button>
        </div>

        <!-- ÉTAPE 2 : Informations Médicales de Base -->
        <div class="card mb-3 d-none" id="step2">
            <div class="card-header" style="background-color: var(--bleu-fonce); color: var(--blanc-pur);">
                <strong>Informations Médicales de Base</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="groupe_sanguin" class="form-label">Groupe sanguin</label>
                    <input type="text" name="groupe_sanguin" id="groupe_sanguin" class="form-control" placeholder="Ex : A, B, AB, O"/>
                </div>
                <div class="mb-3">
                    <label for="rhesus" class="form-label">Rhésus</label>
                    <input type="text" name="rhesus" id="rhesus" class="form-control" placeholder="Ex : +, -"/>
                </div>
                <div class="mb-3">
                    <label for="taille" class="form-label">Taille (en cm)</label>
                    <input type="number" name="taille" id="taille" class="form-control" step="0.1" onchange="calculateIMC()"/>
                </div>
                <div class="mb-3">
                    <label for="poids_actuel" class="form-label">Poids actuel (en kg)</label>
                    <input type="number" name="poids_actuel" id="poids_actuel" class="form-control" step="0.1" onchange="calculateIMC()"/>
                </div>
                <div class="mb-3 d-none" id="poidsNaissanceContainer">
                    <label for="poids_naissance" class="form-label">Poids à la naissance (en kg)</label>
                    <input type="number" name="poids_naissance" id="poids_naissance" class="form-control" step="0.1" />
                </div>
                <div class="mb-3">
                    <label for="imc" class="form-label">IMC</label>
                    <input type="number" name="imc" id="imc" class="form-control" readonly />
                </div>
                <div class="mb-3">
                    <label for="allergies" class="form-label">Allergies connues</label>
                    <textarea name="allergies" id="allergies" rows="2" class="form-control" placeholder="Médicaments, aliments, autres"></textarea>
                </div>
                <div class="mb-3">
                    <label for="maladies_chroniques" class="form-label">Maladies chroniques</label>
                    <textarea name="maladies_chroniques" id="maladies_chroniques" rows="2" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="traitements" class="form-label">Traitements en cours</label>
                    <textarea name="traitements" id="traitements" rows="2" class="form-control"></textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4 d-none" id="step2Buttons">
            <button type="button" class="btn btn-secondary" onclick="goToStep(1)">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="goToStep(3)">Suivant</button>
        </div>

        <!-- ÉTAPE 3 : Antécédents Médicaux -->
        <div class="card mb-3 d-none" id="step3">
            <div class="card-header" style="background-color: var(--bleu-fonce); color: var(--blanc-pur);">
                <strong>Antécédents Médicaux</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="antecedents_personnels" class="form-label">Antécédents personnels</label>
                    <textarea name="antecedents_personnels" id="antecedents_personnels" rows="3" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="antecedents_familiaux" class="form-label">Antécédents familiaux</label>
                    <textarea name="antecedents_familiaux" id="antecedents_familiaux" rows="3" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="vaccinations" class="form-label">Vaccinations (avec dates)</label>
                    <textarea name="vaccinations" id="vaccinations" rows="3" class="form-control" placeholder="Ex : Rougeole : 12/05/2010"></textarea>
                </div>
                <div class="mb-3">
                    <label for="hospitalisations" class="form-label">Hospitalisations antérieures</label>
                    <textarea name="hospitalisations" id="hospitalisations" rows="3" class="form-control">{{ old('hospitalisations') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="dicom_image" class="form-label">Image DICOM</label>
                    <input type="file" name="dicom_image" id="dicom_image" class="form-control" accept=".dcm"/>
                    <small class="form-text text-muted">Sélectionnez un fichier DICOM (.dcm)</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4 d-none" id="step3Buttons">
            <button type="button" class="btn btn-secondary" onclick="goToStep(2)">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="goToStep(4)">Suivant</button>
        </div>

        <!-- ÉTAPE 4 : Informations Familiales -->
        <div class="card mb-3 d-none" id="step4">
            <div class="card-header" style="background-color: var(--bleu-fonce); color: var(--blanc-pur);">
                <strong>Informations Familiales</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nom_pere" class="form-label">Nom et prénom du père</label>
                    <input type="text" name="nom_pere" id="nom_pere" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="contact_pere" class="form-label">Contact du père</label>
                    <input type="text" name="contact_pere" id="contact_pere" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="nom_mere" class="form-label">Nom et prénom de la mère</label>
                    <input type="text" name="nom_mere" id="nom_mere" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="contact_mere" class="form-label">Contact de la mère</label>
                    <input type="text" name="contact_mere" id="contact_mere" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="antecedents_parents" class="form-label">Antécédents médicaux des parents</label>
                    <textarea name="antecedents_parents" id="antecedents_parents" rows="3" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="nbre_freres_soeurs" class="form-label">Nombre de frères/sœurs et leur état de santé (optionnel)</label>
                    <input type="number" name="nbre_freres_soeurs" id="nbre_freres_soeurs" class="form-control" min="0" />
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4 d-none" id="step4Buttons">
            <button type="button" class="btn btn-secondary" onclick="goToStep(3)">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="goToStep(5)">Suivant</button>
        </div>

        <!-- ÉTAPE 5 : Informations Administratives -->
        <div class="card mb-3 d-none" id="step5">
            <div class="card-header" style="background-color: var(--bleu-fonce); color: var(--blanc-pur);">
                <strong>Informations Administratives</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="assurance_maladie" class="form-label">Assurance maladie</label>
                    <input type="text" name="assurance_maladie" id="assurance_maladie" class="form-control" placeholder="Nom de l'assurance" />
                </div>
                <div class="mb-3">
                    <label for="num_assurance" class="form-label">Numéro d'assurance</label>
                    <input type="text" name="num_assurance" id="num_assurance" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="medecin_traitant" class="form-label">Médecin traitant</label>
                    <input type="text" name="medecin_traitant" id="medecin_traitant" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="etablissement_sante" class="form-label">Établissement de santé habituel</label>
                    <input type="text" name="etablissement_sante" id="etablissement_sante" class="form-control" />
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4 d-none" id="step5Buttons">
            <button type="button" class="btn btn-secondary" onclick="goToStep(4)">Précédent</button>
            <button type="button" class="btn btn-primary" onclick="goToStep(6)">Suivant</button>
        </div>

        <!-- ÉTAPE 6 : Validation et Génération du NNS -->
        <div class="card mb-3 d-none" id="step6">
            <div class="card-header" style="background-color: var(--bleu-fonce); color: var(--blanc-pur);">
                <strong>Validation et Génération du NNS</strong>
            </div>
            <div class="card-body">
                <p class="fw-bold">Récapitulatif des informations :</p>
                <div id="recapitulatif"></div>
                <div class="mt-3">
                    <label for="nns" class="form-label">NNS généré</label>
                    <input type="text" name="nns" id="nns" class="form-control" readonly />
                    <small class="text-muted">
                        Format suggéré: DOS-{premières lettres nom}-{année naissance}-{code lieu naissance}-{4 derniers chiffres extrait naissance}
                    </small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4 d-none" id="step6Buttons">
            <button type="button" class="btn btn-secondary" onclick="goToStep(5)">Précédent</button>
            <button type="button" class="btn btn-success" onclick="generateRecapAndNNS()">Valider et Créer le dossier médical</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let currentStep = 1;

    // Fonction de validation de l'étape
    function validateStep(step) {
        const stepElement = document.getElementById('step' + step);
        if (!stepElement) return true;
        const requiredFields = stepElement.querySelectorAll('[required]');
        for (const field of requiredFields) {
            if (!field.value.trim()) {
                return false;
            }
        }
        return true;
    }

    // Fonction de navigation entre étapes
    function goToStep(step) {
        if (step > currentStep && !validateStep(currentStep)) {
            alert('Veuillez remplir tous les champs requis avant de passer à l\'étape suivante.');
            return;
        }
        // Masquer étape et boutons actuels
        document.getElementById('step' + currentStep).classList.add('d-none');
        document.getElementById('step' + currentStep + 'Buttons').classList.add('d-none');
        document.getElementById('step' + currentStep + 'Indicator').classList && document.getElementById('step' + currentStep + 'Indicator').classList.remove('step-active');

        currentStep = step;

        // Afficher nouvelle étape et boutons
        document.getElementById('step' + currentStep).classList.remove('d-none');
        document.getElementById('step' + currentStep + 'Buttons').classList.remove('d-none');
        document.getElementById('step' + currentStep + 'Indicator').classList && document.getElementById('step' + currentStep + 'Indicator').classList.add('step-active');

        // Si dernière étape, mettre à jour le récapitulatif
        if (currentStep == 6) {
            generateRecap();
        }
    }

    // Calcul de l'IMC
    function calculateIMC() {
        const taille = parseFloat(document.getElementById('taille').value);
        const poids = parseFloat(document.getElementById('poids_actuel').value);
        if (taille > 0 && poids > 0) {
            const imc = (poids / ((taille / 100) ** 2)).toFixed(2);
            document.getElementById('imc').value = imc;
        }
    }

    // Afficher ou masquer le champ "Poids à la naissance" (par exemple, si le patient est âgé de moins d'un an)
    function togglePoidsNaissance() {
        const dateNaissance = document.getElementById('date_naissance').value;
        if (dateNaissance) {
            const birthDate = new Date(dateNaissance);
            const today = new Date();
            const ageInMs = today - birthDate;
            const ageInYears = ageInMs / (365.25 * 24 * 60 * 60 * 1000);
            if (ageInYears < 1) {
                document.getElementById('poidsNaissanceContainer').classList.remove('d-none');
            } else {
                document.getElementById('poidsNaissanceContainer').classList.add('d-none');
                document.getElementById('poids_naissance').value = '';
            }
        }
    }

    // Génération du récapitulatif et calcul automatique du NNS
    function generateRecapAndNNS() {
        if (!validateStep(currentStep)) {
            alert('Veuillez remplir tous les champs requis.');
            return;
        }
        // Ici, on peut éventuellement confirmer via un prompt ou directement soumettre
        generateRecap();
        // Si tout est validé, on soumet le formulaire
        document.getElementById('dossierForm').submit();
    }

    function generateRecap() {
        // Récupération des valeurs du formulaire
        const recapContainer = document.getElementById('recapitulatif');
        const fields = {
            'Nom': document.getElementById('nom').value,
            'Prénom': document.getElementById('prenom').value,
            'Date de naissance': document.getElementById('date_naissance').value,
            'Lieu de naissance': document.getElementById('lieu_naissance').value,
            'Sexe': document.getElementById('sexe').value,
            "N° extrait/CNI": document.getElementById('num_extrait_naissance').value,
            'Nationalité': document.getElementById('nationalite').value,
            'Adresse': document.getElementById('adresse').value,
            'Téléphone': document.getElementById('telephone').value,
            'Email': document.getElementById('email').value,
            'Profession': document.getElementById('profession').value,
            'Contact urgence': document.getElementById('contact_urgence').value,
            'Groupe sanguin': document.getElementById('groupe_sanguin').value,
            'Rhésus': document.getElementById('rhesus').value,
            'Taille (cm)': document.getElementById('taille').value,
            'Poids actuel (kg)': document.getElementById('poids_actuel').value,
            'IMC': document.getElementById('imc').value,
            'Allergies': document.getElementById('allergies').value,
            'Maladies chroniques': document.getElementById('maladies_chroniques').value,
            'Traitements': document.getElementById('traitements').value,
            'Antécédents personnels': document.getElementById('antecedents_personnels').value,
            'Antécédents familiaux': document.getElementById('antecedents_familiaux').value,
            'Vaccinations': document.getElementById('vaccinations').value,
            'Hospitalisations': document.getElementById('hospitalisations').value,
            'Nom du père': document.getElementById('nom_pere').value,
            'Contact du père': document.getElementById('contact_pere').value,
            'Nom de la mère': document.getElementById('nom_mere').value,
            'Contact de la mère': document.getElementById('contact_mere').value,
            'Antécédents parents': document.getElementById('antecedents_parents').value,
            'Nombre de frères/sœurs': document.getElementById('nbre_freres_soeurs').value,
            'Assurance maladie': document.getElementById('assurance_maladie').value,
            'Numéro assurance': document.getElementById('num_assurance').value,
            'Médecin traitant': document.getElementById('medecin_traitant').value,
            'Établissement de santé': document.getElementById('etablissement_sante').value,
        };

        let recapHtml = '<ul>';
        for (const key in fields) {
            recapHtml += '<li><strong>' + key + ':</strong> ' + (fields[key] || '-') + '</li>';
        }
        recapHtml += '</ul>';
        recapContainer.innerHTML = recapHtml;

        // Génération automatique du NNS selon le format suggéré
        const nomPart = document.getElementById('nom').value.substring(0, 3).toUpperCase();
        const annee = new Date(document.getElementById('date_naissance').value).getFullYear();
        const lieuPart = document.getElementById('lieu_naissance').value.substring(0, 3).toUpperCase();
        const extraitStr = document.getElementById('num_extrait_naissance').value.replace(/\D/g, '');
        const extraitPart = extraitStr.slice(-4);
        const nns = 'DOS-' + nomPart + '-' + annee + '-' + lieuPart + '-' + extraitPart;
        document.getElementById('nns').value = nns;
    }
</script>
@endsection
