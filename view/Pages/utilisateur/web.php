<?php

include_once('../../templates/header.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MadaRec - Votre Partenaire Recrutement Local</title>
    <link href="/recrutement-local/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/recrutement-local/assets/css/style.css">
</head>
<body>

    <section class="hero-section min-vh-100 d-flex align-items-center text-white" style="background-image: url('/recrutement-local/assets/images/hero-bg3.jpg'); background-size: cover; background-position: center;">
        <div class="overlay"></div> <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-8 text-center text-lg-start animate-fade-in-up">
                    <p class="text-uppercase mb-2">// Facilitez votre recrutement avec MadaRec</p>
                    <h1 class="display-3 fw-bold mb-4">
                        Où l'Innovation Rencontre les Talents Locaux
                    </h1>
                    <p class="lead mb-5">
                        Simplifiez votre processus de recrutement ou trouvez l'emploi de vos rêves. MadaRec connecte les entreprises et les candidats à Madagascar.
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-lg-start">
                        <a href="/recrutement-local/" class="btn btn-primary btn-lg px-4 shadow-lg animate-scale-in">S'inscrire</a>
                        <a href="/recrutement-local/index.php?page=login" class="btn btn-outline-light btn-lg px-4 shadow-lg animate-scale-in">Se Connecter</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features-nav py-3 bg-white shadow-sm d-none d-md-block">
        <div class="container">
            <div class="d-flex justify-content-around align-items-center text-dark fw-bold flex-wrap">
                <a href="#offres" class="nav-item-link px-3 py-2 text-decoration-none text-dark d-flex align-items-center"><i class="fas fa-search me-2"></i> Consulter les Offres</a>
                <span class="mx-2 text-primary">*</span>
                <a href="#candidats" class="nav-item-link px-3 py-2 text-decoration-none text-dark d-flex align-items-center"><i class="fas fa-user-tie me-2"></i> Espace Candidat</a>
                <span class="mx-2 text-primary">*</span>
                <a href="#recruteurs" class="nav-item-link px-3 py-2 text-decoration-none text-dark d-flex align-items-center"><i class="fas fa-building me-2"></i> Espace Recruteur</a>
                <span class="mx-2 text-primary">*</span>
                <a href="#faq" class="nav-item-link px-3 py-2 text-decoration-none text-dark d-flex align-items-center"><i class="fas fa-question-circle me-2"></i> FAQ & Aide</a>
            </div>
        </div>
    </section>

    <section id="about" class="py-5 py-lg-0 bg-light position-relative overflow-hidden">
        <div class="container py-5">
            <div class="row align-items-center flex-column-reverse flex-lg-row">
                <div class="col-lg-6 mb-4 mb-lg-0 animate-fade-in-left">
                    <div class="row g-3">
                        <div class="col-6">
                            <img src="/recrutement-local/assets/images/team3.jpg" alt="Team Member 1" class="img-fluid rounded shadow-sm hover-grow">
                        </div>
                        <div class="col-6">
                            <img src="/recrutement-local/assets/images/team4.jpg" alt="Team Member 2" class="img-fluid rounded shadow-sm hover-grow">
                        </div>
                        <div class="col-6">
                            <img src="/recrutement-local/assets/images/team8.jpg" alt="Team Member 3" class="img-fluid rounded shadow-sm hover-grow">
                        </div>
                        <div class="col-6">
                            <img src="/recrutement-local/assets/images/team9.jpg" alt="Team Member 4" class="img-fluid rounded shadow-sm hover-grow">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 animate-fade-in-right">
                    <p class="text-center .text-primary.text-uppercase.mb-2">// À Propos de Nous</p>
                    <h2 class="display-5 fw-bold mb-4">
                        Transformons le Recrutement à Madagascar
                    </h2>
                    <p class="lead mb-4">
                        MadaRec est une plateforme innovante dédiée à simplifier la recherche d'emploi et le recrutement à Madagascar. Nous connectons efficacement les talents locaux avec les entreprises qui cherchent à croître.
                    </p>
                    <div class="row text-center text-md-start mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h3 class="display-6 fw-bold text-primary">150+</h3>
                            <p class="text-muted">Offres Publiées</p>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h3 class="display-6 fw-bold text-primary">2000+</h3>
                            <p class="text-muted">Candidats Heureux</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="display-6 fw-bold text-primary">99%</h3>
                            <p class="text-muted">Satisfaction</p>
                        </div>
                    </div>
                    <p class="text-muted fst-italic">
                        "Notre mission est de créer un pont entre les opportunités et les compétences locales."
                    </p>
                    <p class="fw-bold mb-0">Fiderana Andriahasiniaina</p>
                    <p class="text-primary">Fondatrice & CEO de MadaRec</p>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5 animate-fade-in-up">
                <p class="text-primary text-uppercase mb-2">// Nos Services</p>
                <h2 class="display-5 fw-bold mb-4">
                    Des Fonctionnalités qui Élèvent Votre Processus
                </h2>
                <a href="#all-services" class="btn btn-outline-primary mt-3 animate-scale-in">Voir Toutes les Fonctionnalités</a>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4 animate-fade-in-up delay-1">
                    <div class="card service-card h-100 shadow-sm border-0 rounded-4 p-4 text-center">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-clipboard-list service-icon"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Publication d'Offres Facile</h5>
                            <p class="card-text text-muted">
                                Recruteurs, publiez vos offres d'emploi en quelques clics et atteignez un large bassin de talents qualifiés.
                            </p>
                            <a href="#" class="btn btn-link mt-auto text-decoration-none fw-bold text-primary">En savoir plus <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 animate-fade-in-up delay-2">
                    <div class="card service-card h-100 shadow-sm border-0 rounded-4 p-4 text-center">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-users service-icon"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Gestion des Candidatures Intuitive</h5>
                            <p class="card-text text-muted">
                                Suivez et gérez les candidatures reçues via un tableau de bord ergonomique pour les recruteurs.
                            </p>
                            <a href="#" class="btn btn-link mt-auto text-decoration-none fw-bold text-primary">En savoir plus <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 animate-fade-in-up delay-3">
                    <div class="card service-card h-100 shadow-sm border-0 rounded-4 p-4 text-center">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-user-check service-icon"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Candidatures Simplifiées</h5>
                            <p class="card-text text-muted">
                                Candidats, postulez facilement aux offres qui vous intéressent et suivez le statut de vos candidatures.
                            </p>
                            <a href="#" class="btn btn-link mt-auto text-decoration-none fw-bold text-primary">En savoir plus <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="process" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5 animate-fade-in-up">
                <p class="text-primary text-uppercase mb-2">// Notre Processus de Travail</p>
                <h2 class="display-5 fw-bold mb-4">
                    Le Processus de Recrutement MadaRec
                </h2>
            </div>
            <div class="row g-4 process-steps">
                <div class="col-md-6 col-lg-3 text-center animate-fade-in-up delay-1">
                    <div class="process-step position-relative p-4 rounded-4 shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div class="step-icon-wrapper mb-3">
                            <div class="step-number">01</div>
                            <i class="fas fa-comment-dots process-icon"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Inscription</h5>
                        <p class="text-muted">
                            Créez votre compte recruteur ou candidat en quelques étapes simples.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center animate-fade-in-up delay-2">
                    <div class="process-step position-relative p-4 rounded-4 shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div class="step-icon-wrapper mb-3">
                            <div class="step-number">02</div>
                            <i class="fas fa-upload process-icon"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Publication / Candidature</h5>
                        <p class="text-muted">
                            Recruteurs publient leurs offres, candidats postulent aux annonces.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center animate-fade-in-up delay-3">
                    <div class="process-step position-relative p-4 rounded-4 shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div class="step-icon-wrapper mb-3">
                            <div class="step-number">03</div>
                            <i class="fas fa-users-cog process-icon"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Gestion & Suivi</h5>
                        <p class="text-muted">
                            Les recruteurs gèrent les candidatures, les candidats suivent leur statut.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center animate-fade-in-up delay-4">
                    <div class="process-step position-relative p-4 rounded-4 shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div class="step-icon-wrapper mb-3">
                            <div class="step-number">04</div>
                            <i class="fas fa-check-circle process-icon"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Confirmation Finale</h5>
                        <p class="text-muted">
                            Le recruteur confirme les candidatures retenues, finalisant le processus.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section bg-primary text-white py-5 text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-3">Prêt à Transformer Votre Recrutement ?</h2>
            <p class="lead mb-4">
                Rejoignez la communauté MadaRec dès aujourd'hui et trouvez les meilleurs talents ou l'emploi de vos rêves.
            </p>
            <a href="/recrutement-local/register.php" class="btn btn-light btn-lg px-5 shadow-lg animate-scale-in">Commencer Maintenant</a>
        </div>
    </section>

    <section class="footer-nav py-3 bg-dark text-white d-none d-md-block">
        <div class="container">
            <div class="d-flex justify-content-around align-items-center fw-bold flex-wrap">
                <a href="#about" class="nav-item-link px-3 py-2 text-decoration-none text-white d-flex align-items-center"><i class="fas fa-info-circle me-2"></i> À Propos</a>
                <span class="mx-2 text-primary">*</span>
                <a href="#services" class="nav-item-link px-3 py-2 text-decoration-none text-white d-flex align-items-center"><i class="fas fa-cogs me-2"></i> Fonctionnalités</a>
                <span class="mx-2 text-primary">*</span>
                <a href="#process" class="nav-item-link px-3 py-2 text-decoration-none text-white d-flex align-items-center"><i class="fas fa-sync-alt me-2"></i> Processus</a>
                <span class="mx-2 text-primary">*</span>
                <a href="#" class="nav-item-link px-3 py-2 text-decoration-none text-white d-flex align-items-center"><i class="fas fa-envelope me-2"></i> Contact</a>
            </div>
        </div>
    </section>

    <script src="/recrutement-local/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/recrutement-local/assets/js/script.js"></script>
</body>
</html>

<?php
// Assurez-vous que le chemin est correct pour votre projet
include_once('../../templates/footer.php');
?>