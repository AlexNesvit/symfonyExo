# Procédure d'installation

> Exemple de mise en place d'une application Symfony 7

Nous partirons sur une installation de base complète pour le dévellopement d'application web. Vous devrez au préalable avoir un environement de développement local ainsi que la commande symfony cli.

[plus d'information ici...](https://symfony.com/download)

- Installation du projet sur Pc avec environement local WAMP.

    ```bash
    cd../..
    cd wamp64/www
    symfony new monApp --webapp
    cd monApp && code .
    ```

- Installation du projet sur Mac avec environement local MAMP et htdocs reparamétré sur le dossier Sites.

    ```bash
    cd Sites
    symfony new monApp --webapp
    cd monApp && code .
    ```

## Front-End

> Nous decidons de choisir webpack afin de gérer notre partie Front avec Bootstrap, Sass, Font-awesome

- mise en place du bundle Webpack encore

    ```bash
    composer require symfony/webpack-encore-bundle
    npm install
    ```

    [plus d'information ici...](https://symfony.com/doc/current/frontend/encore/installation.html)

- Installation de bootstrap CSS & JS ainsi que FontAwesome avec Webpack Encore

    ```bash
    npm install bootstrap --save-dev
    npm install @fortawesome/fontawesome-free
    ```

    [plus d'information ici...](https://symfony.com/doc/current/frontend/encore/bootstrap.html)

- Installation du sass loader et activation dans le webpack.config.js

    ```bash
    npm install sass-loader@^14.0.0 sass --save-dev
    npm run dev
    ```

- Nous allons spécifier à notre app que nous utiliserons le theme bootstrap5 pour nos form twig

    ```code
    # config/packages/twig.yaml
    twig:
        form_themes: ['bootstrap_5_layout.html.twig']
    ```

- Création d'un menu templates/components/menu.html.twig

    > Nous récupérerons une trame de navbar bootstrap que nous customiserons au besoin

- Création d'un composant d'affichage de messages et notifications utilisateur templates/components/message.html.twig

    ```code
    {% for label, messages in app.flashes %}
        {% for message in messages %}
            <div class="alert alert-{{ label }}">
                {{ message }}
            </div>
        {% endfor %}
    {% endfor %}
    ````

    > Nous inclurons ces éléments dans la base.html.twig

## Back-End

- Création d'un .env.local pour définir nos informations de connexion databases et création de la DB

    ```bash
    symfony console d:d:c 
    ```

- Mise en place d'un premier controller pour afficher notre futur page d'accueil ainsi qu'un second pour une page profile (On respecte les conventions de nommage avec l'utilisation de majuscule dans toutes les class objets )

    ```bash
    symfony console make:controller HomeController
    symfony console make:controller ProfileController
    ```

- Création d'une entity User pour la gestion de nos utilisateur (login,roles)

    ```bash
    symfony console make:user User
    symfony console make:migration
    symfony console d:m:m
    ```

    > L'entity User dans Symfony représente typiquement un utilisateur dans l'application. Elle est utilisée pour stocker des informations comme les identifiants, les mots de passe, et les rôles. Cette entité est souvent utilisée avec le composant Security pour gérer l'authentification et les autorisations.

- Mise en place d'un mécanisme d'authentification dans l'application avec choix du login form et logout intégrés.

    ```bash
    symfony console make:auth
    ```

    > On oublie pas de régler nos redirections dans notre AppAuthenticator et de décommenter les access_controls dans le /config/packages/security.yaml

- Mise en place du bundle de verification d'email pour inscription utilisateur et création de la form d'inscription

    ```bash
    composer require symfonycasts/verify-email-bundle
    symfony console make:registration-form
    symfony console make:migration
    symfony console d:m:m
    ```

- Nous utiliserons le bridge Google Mailer de Symfony pour configurer notre compte Gmail comme serveur de messagerie de développement, un mot de passe d'application google sera a créer.

    ```bash
    composer require symfony/google-mailer
    ```

    > configuration a réaliser dans le .env.local

- Nous allons maintenant installer le bundle d'administration easyAdmin 4

    ```bash
    composer require easycorp/easyadmin-bundle
    ```

- Création de l'admin dashboard

    ```bash
    symfony console make:admin:dashboard
    ```

