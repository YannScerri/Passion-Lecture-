<?php
/**
 * ETML
 * Auteur : Dany Carneiro
 * Date : 19.11.2024
 * Description : fichier contenant la classe Database qui permet de récupérer et d'utiliser les données dans la base de données 
 */

class Database {

    // Variable de classe
    private $connector;

    public function __construct()
    {
        try {
            // Lire le fichier de config json
            $json = file_get_contents('../json/config.json');

            // Charger la configuration depuis le fichier JSON
            $config = json_decode($json, true);

            // Construire la chaîne de connexion
            $dsn = 'mysql:host=' . $config['database']['host'] . 
                   ';port=' . $config['database']['port'] . 
                   ';dbname=' . $config['database']['dbname'] . 
                   ';charset=' . $config['database']['charset'];

            // Se connecter à la base de données
            $this->connector = new PDO($dsn, $config['database']['username'], $config['database']['password']);
        }
        catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Méthode permettant d'exécuter une simple requête SQL
     */
    private function querySimpleExecute($query) {
        // Effectue une simple requête
        $req = $this->connector->query($query);
        return $req;
    }

    /**
     * Méthode permettant d'exécuter une requête SQL en utilisant "prepare"
     */
    private function queryPrepareExecute($query, $binds = []) {
        $req = $this->connector->prepare($query);

        foreach ($binds as $key => $value) {
            $req->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $req->execute();
        return $req;
    }

    /**
     * Formatte les données reçues par une requête en tableau associatif
     */
    private function formatData($req) {
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Récupère les 5 derniers livres ajoutés
     */
    public function get5LastBooks() {
        $query = "SELECT titre, image, pseudo, nom, prenom, ouvrage_id 
                  FROM t_ouvrage 
                  INNER JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id 
                  INNER JOIN t_utilisateur ON t_utilisateur.utilisateur_id = t_ouvrage.utilisateur_id 
                  ORDER BY ouvrage_id DESC LIMIT 5";

        return $this->formatData($this->querySimpleExecute($query));
    }

    /**
     * Méthode permettant l'ajout d'un utilisateur
     */
    public function addUser($pseudo, $password, $admin) {
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // requête SQL permettant d'ajouter un utilisateur
        $query = "INSERT INTO t_utilisateur (pseudo, password, admin, date_entree)
                  VALUES (:pseudo, :password, :admin, :date_entree)";

        $date = date("d/m/y");

        $binds = [
            'pseudo' => $pseudo,
            'password' => $hashedPassword,
            'admin' => $admin,
            'date_entree' => $date,
        ];

        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * Méthode permettant de récupérer un utilisateur spécifique par son login
     */
    public function getUserByLogin($login) {
        $query = "SELECT * FROM t_utilisateur WHERE pseudo = :pseudo";
        $stmt = $this->queryPrepareExecute($query, ['pseudo' => $login]);
        $users = $this->formatData($stmt);
        return count($users) === 1 ? $users[0] : [];
    }

    /**
     * Méthode permettant de retourner tous les utilisateurs
     */
    public function getAllUsers() {
        // requête SQL sélectionnant toute la table t_utilisateur
        $query = "SELECT * FROM t_utilisateur";

        // exécute la requête SQL
        return $this->formatData($this->querySimpleExecute($query));
    }

    /**
     * Méthode pour insérer un livre dans la table t_ouvrage
     */
    public function insertBook($data) {
        $query = "
            INSERT INTO t_ouvrage (titre, extrait, resume, annee, image, nombre_pages, utilisateur_id, categorie_id, editeur_id, auteur_id)
            VALUES (:titre, :extrait, :resume, :annee, :image, :nombre_pages, :utilisateur_id, :categorie_id, :editeur_id, :auteur_id)
        ";

        return $this->queryPrepareExecute($query, $data);
    }

    /**
     * Récupère toutes les catégories
     */
    public function getAllCategories() {
        $query = "SELECT * FROM t_categorie";
        $req = $this->querySimpleExecute($query);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les auteurs
     */
    public function getAllAuthors() {
        $query = "SELECT * FROM t_auteur";
        $req = $this->querySimpleExecute($query);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les éditeurs
     */
    public function getAllEditors() {
        $query = "SELECT * FROM t_editeur";
        $req = $this->querySimpleExecute($query);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un livre
     */
    public function deleteBook($id) {
        $query = "DELETE FROM t_ouvrage WHERE ouvrage_id LIKE :id";
        $binds = ['id' => $id];
        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * Récupère les informations d'un ouvrage spécifique par ID
     */
    public function getOneOuvrage($idOuvrage) {
        $query = "
            SELECT t_ouvrage.*, 
                   t_auteur.nom AS auteur_nom, 
                   t_auteur.prenom AS auteur_prenom, 
                   t_editeur.nom AS editeur_nom, 
                   t_categorie.nom AS categorie_nom
            FROM t_ouvrage
            JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id
            JOIN t_editeur ON t_ouvrage.editeur_id = t_editeur.editeur_id
            JOIN t_categorie ON t_ouvrage.categorie_id = t_categorie.categorie_id
            WHERE t_ouvrage.ouvrage_id = :ouvrage_id
        ";

        $req = $this->queryPrepareExecute($query, ["ouvrage_id" => $idOuvrage]);

        $ouvrage = $req->fetch(PDO::FETCH_ASSOC);

        return $ouvrage ?: null;
    }

    /**
     * Récupère une catégorie spécifique par ID
     */
    public function getOneCategorie($idCategorie) {
        $query = "SELECT * FROM t_categorie WHERE categorie_id = :categorie_id";
        $binds = [":categorie_id" => $idCategorie];
        $req = $this->queryPrepareExecute($query, $binds);
        $categorie = $this->formatData($req);
        return $categorie[0];
    }

    /**
     * Récupère tous les ouvrages
     */
    public function getAllOuvrages() {
        $query = "
            SELECT t_ouvrage.*, t_auteur.nom AS auteur_nom, t_auteur.prenom AS auteur_prenom, 
                   t_editeur.nom AS editeur_nom, t_categorie.nom AS categorie_nom
            FROM t_ouvrage
            JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id
            JOIN t_editeur ON t_ouvrage.editeur_id = t_editeur.editeur_id
            JOIN t_categorie ON t_ouvrage.categorie_id = t_categorie.categorie_id
        ";

        $req = $this->querySimpleExecute($query);

        $ouvrages = $this->formatData($req);

        return $ouvrages;
    }
}
?>
