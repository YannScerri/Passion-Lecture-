<?php
/**
 * ETML
 * Auteur : Dany Carneiro, Maxime Pelloquin, Yann Scerri, Hanieh Mohajerani
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
            $json = file_get_contents('json/config.json');

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
        $query = "SELECT titre, image, pseudo, nom, prenom, ouvrage_id, t_ouvrage.utilisateur_id
                  FROM t_ouvrage 
                  INNER JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id 
                  INNER JOIN t_utilisateur ON t_utilisateur.utilisateur_id = t_ouvrage.utilisateur_id 
                  ORDER BY ouvrage_id DESC LIMIT 5";

        return $this->formatData($this->querySimpleExecute($query));
    }

    public function addUser($pseudo, $password, $admin, $date_entree) {
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Requête SQL permettant d'ajouter un utilisateur
        $query = "INSERT INTO t_utilisateur (pseudo, mot_de_passe, admin, date_entree)
                  VALUES (:pseudo, :password, :admin, :date_entree)";
        
        // Préparation des valeurs à insérer
        $binds = [
            'pseudo' => $pseudo,
            'password' => $hashedPassword,
            'admin' => $admin,
            'date_entree' => $date_entree,
        ];
        
        // Exécution de la requête via une méthode personnalisée
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
    public function insertBook($title, $excerpt, $summary, $year, $img, $pages, $userID, $categoryID, $editorID, $authorID) {
        $query = "
            INSERT INTO t_ouvrage (titre, extrait, resume, annee, image, nombre_pages, utilisateur_id, categorie_id, editeur_id, auteur_id)
            VALUES (:titre, :extrait, :resume, :annee, :image, :nombre_pages, :utilisateur_id, :categorie_id, :editeur_id, :auteur_id)
        ";

        $binds = ['titre' => $title,
                'extrait' => $excerpt,
                'resume' => $summary,
                'annee' => $year,
                'image' => $img,
                'nombre_pages' => $pages,
                'utilisateur_id' => $userID,
                'categorie_id' => $categoryID,
                'editeur_id' => $editorID,
                'auteur_id' => $authorID
            ];
                

        return $this->queryPrepareExecute($query, $binds);
    }

    /**
     * Methode permettant de retourner tout les livres pour une catégorie
     */
    public function getBooksByCategory($category){
        // requete sql selectionnant tout les livres d'une catégorie
         $query = "SELECT 
        t_ouvrage.image AS photo_du_livre,
        t_ouvrage.titre AS nom_du_livre,
        CONCAT(t_auteur.prenom, ' ', t_auteur.nom) AS nom_de_l_auteur,
        t_utilisateur.pseudo AS pseudo_ajouteur,
        t_utilisateur.utilisateur_id AS utilisateur_id,
        t_ouvrage.ouvrage_id AS ouvrage_id
        FROM 
            t_ouvrage
        INNER JOIN 
            t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id
        INNER JOIN 
            t_utilisateur ON t_ouvrage.utilisateur_id = t_utilisateur.utilisateur_id
        INNER JOIN 
            t_categorie ON t_ouvrage.categorie_id = t_categorie.categorie_id
        WHERE 
            t_categorie.nom = '$category'";

        // retourne le résultat ous forme de tableau
        return $this->formatData($this->querySimpleExecute($query));
    }

    /**
     * Methode permettant de retourner tout les livres pour une catégorie
     */
    public function getAllCategories(){
        // requete sql selectionnant tout les livres d'une catégorie
         $query = "SELECT * from t_categorie";

         //retourne le résultat de la requete sous forme de tableau
         return $this->formatData($this->querySimpleExecute($query));
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
     * Récupérer un utilisateur par son ID
     */
    public function getUserById($userId) {
        $query = "SELECT 
                pseudo, 
                (SELECT COUNT(*) FROM apprecier WHERE utilisateur_id = :id) AS review_count,
                (SELECT COUNT(*) FROM t_ouvrage WHERE utilisateur_id = :id) AS upload_count
            FROM t_utilisateur
            WHERE utilisateur_id = :id
        ";
        $result = $this->queryPrepareExecute($query, ['id' => $userId]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Mettre à jour le pseudo d'un utilisateur
     */
    public function updateUserPseudo($userId, $newPseudo) {
        $query = "
            UPDATE t_utilisateur
            SET pseudo = :pseudo
            WHERE utilisateur_id = :id
        ";
        return $this->queryPrepareExecute($query, ['pseudo' => $newPseudo, 'id' => $userId]);
    }

    /**
     * Récupérer les livres ajoutés par l'utilisateur
     */
    public function getBooksUploadedByUser($userId) {
        $query = "
            SELECT titre, extrait, resume, annee, image, nombre_pages 
            FROM t_ouvrage 
            WHERE utilisateur_id = :id
        ";
        $req = $this->queryPrepareExecute($query, ['id' => $userId]);
        return $this->formatData($req); // Retourne les résultats sous forme de tableau associatif
    }

    /**
     * Récupérer les livres notés par l'utilisateur (avec alias pour simplifier)
     */
    public function getBooksRatedByUser($userId) {
        $query = "
            SELECT 
                o.titre, 
                o.extrait, 
                o.nombre_pages, 
                o.image, 
                a.note 
            FROM apprecier a
            INNER JOIN t_ouvrage o ON a.ouvrage_id = o.ouvrage_id
            WHERE a.utilisateur_id = :id
        ";
        $req = $this->queryPrepareExecute($query, ['id' => $userId]);
        return $this->formatData($req); // Retourne les résultats sous forme de tableau associatif
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
                   t_categorie.nom AS categorie_nom,
                   t_utilisateur.utilisateur_id AS utilisateur_id, 
                   t_utilisateur.pseudo AS utilisateur_pseudo
            FROM t_ouvrage
            JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id
            JOIN t_editeur ON t_ouvrage.editeur_id = t_editeur.editeur_id
            JOIN t_categorie ON t_ouvrage.categorie_id = t_categorie.categorie_id
            JOIN t_utilisateur ON t_ouvrage.utilisateur_id = t_utilisateur.utilisateur_id
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
    /**
 * Obtient l'id d'un auteur grâce à son nom
 */
public function getAuthorID($firstName, $lastName){
    
    $query = "SELECT auteur_id FROM t_auteur WHERE nom LIKE :lastName AND prenom LIKE :firstName";

    $binds = [
            'lastName' => $lastName,
            'firstName' => $firstName
            ];

    return $this->formatData($this->queryPrepareExecute($query, $binds))[0]['auteur_id'];
}

/**
 * Vérifie si un auteur existe déja ou pas
 */
public function doesAuthorExists($firstName, $lastName){

    $query = "SELECT 1 FROM t_auteur WHERE nom LIKE '$lastName' AND prenom LIKE '$firstName'";

    $result = $this->formatData($this->querySimpleExecute($query));

    if(empty($result)){
        return false;
    } else {
        return true;
    }
}

/**
 * Ajoute un auteur
 */
public function addAuthor($firstName, $lastName){

    $query = "INSERT INTO t_auteur (nom, prenom) VALUES (:lastName, :firstName)";

    $binds = ['firstName' => $firstName, 'lastName' => $lastName];

    $this->queryPrepareExecute($query, $binds);
}

/**
 * Obtient l'id d'un éditeur grâce à son nom
 */
public function getEditorID($editor){
    
    $query = "SELECT editeur_id FROM t_editeur WHERE nom LIKE :editor";

    $binds = ['editor'=>$editor];

    return $this->formatData($this->queryPrepareExecute($query, $binds))[0]['editeur_id'];
}

/**
 * Vérifie si un éditeur existe déja
 */
public function doesEditorExists($editor){

    $query = "SELECT 1 FROM t_editeur WHERE nom LIKE '$editor'";

    return $this->querySimpleExecute($query);
}

/**
 * Ajoute un éditeur
 */
public function addEditor($editor){

    $query = "INSERT INTO t_editeur (nom) VALUES (:editor)";

    $binds = ['editor'=>$editor];

    $this->queryPrepareExecute($query, $binds);
}

/**
 * obtient le chemin de l'image d'un livre grâce à son ID
 */
public function getBookImage($id){

    $query = "SELECT image FROM t_ouvrage WHERE ouvrage_id = '$id'";

    return $this->formatData($this->querySimpleExecute($query))[0]['image'];
}

/**
 * obtient toutes les informations d'un livre grâce à son ID
 */
public function getBook($id){

    $query = "SELECT * FROM t_ouvrage WHERE ouvrage_id = :id";

    $binds = ['id'=>$id];

    return $this->formatData($this->queryPrepareExecute($query, $binds))[0];
}

/**
 * obtient le nom de l'auteur grâce à son ID
 */
public function getAuthorName($id){

    $query = "SELECT * FROM t_auteur WHERE auteur_id = '$id'";

    return $this->formatData($this->querySimpleExecute($query))[0];
}

/**
 * obtient la nom de l'éditeur grâce à son ID
 */
public function getEditorName($id){

    $query = "SELECT * FROM t_editeur WHERE editeur_id = '$id'";

    return $this->formatData($this->querySimpleExecute($query))[0];
}

/**
 * obtient le nom d'une catégorie grâce à son ID
 */
public function getCategoryName($id){

    $query = "SELECT * FROM t_categorie WHERE categorie_id = '$id'";

    return $this->formatData($this->querySimpleExecute($query))[0];
}

/**
 * modifie les informations d'un livre
 */
public function modifyBook($bookId, $title, $excerpt, $summary, $year, $cover, $pages, $userId, $categoryId, $editorId, $authorId){

    $query = "UPDATE t_ouvrage 
    SET titre = :title, extrait = :excerpt, resume = :summary, annee = :year, image = :cover, nombre_pages = :pages, utilisateur_id = :user, categorie_id = :category, editeur_id = :editor, auteur_id = :author
    WHERE ouvrage_id = :id";

    $binds = ["id"=>$bookId,
                "title"=>$title,
                "excerpt"=>$excerpt,
                "summary"=>$summary,
                "year"=>$year,
                "cover"=>$cover,
                "pages"=>$pages,
                "user"=>$userId,
                "category"=>$categoryId,
                "editor"=>$editorId,
                "author"=>$authorId
            ];

    $this->queryPrepareExecute($query, $binds);
}

/**
 * Methode permettant de retourner la moyenne et le nombre de vote d'un livre
 */
public function getBookRatingAndVotes($idOuvrage){
    $query = "SELECT 
        t_ouvrage.ouvrage_id, 
        t_ouvrage.titre, 
        COALESCE(AVG(apprecier.note), 0) AS moyenne_note, 
        COUNT(apprecier.utilisateur_id) AS nombre_votes
    FROM t_ouvrage
    LEFT JOIN apprecier ON t_ouvrage.ouvrage_id = apprecier.ouvrage_id
    WHERE t_ouvrage.ouvrage_id = :ouvrage_id
    GROUP BY t_ouvrage.ouvrage_id";

    $req = $this->queryPrepareExecute($query, ["ouvrage_id" => $idOuvrage]);
    return $req->fetch(PDO::FETCH_ASSOC);
}

}
?>