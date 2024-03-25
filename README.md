1- Créer fichier .env.local
2- Rentrer l'url de la base de donnée avec ses identifiants dans le fichier env.local
3- Création de la base de donnée taper dans le terminal : "php bin/console doctrine:database:create" puis mettre "Yes"
4- Création des tables et des champs via les migrations : "php bin/console doctrine:migrations:migrate"
5- Ajout des DataFixtures de Author et de Book : "php bin/console doctrine:fixtures:load" puis mettre yes
6- Puis lancer votre serveur local PHP ou SYMFONY
