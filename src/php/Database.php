<?php
/**
 * ETML
 * Auteur : Dany Carneiro
 * Date : 19.11.2024
 * Description : fichier contenant la classe database qui permet de récupérer et d'utiliser les données dans la base de données 
 */



class Database{

    // Variable de classe
    private $connector;

    public function __construct()
    {
        try
        {
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
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Methode permettant d'executer une simple requete sql
     */
    private function querySimpleExecute($query){

        // Effectue une simple requete
        $req = $this->connector->query($query);
        return $req;
    }

    /**
     * Methode permettant d'executer une simple requete sql en utilisant "prepare"
     */
    private function queryPrepareExecute($query, $binds = []){
        $req = $this->connector->prepare($query);

        foreach ($binds as $key => $value) {
            $req->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
        $req->execute();
        return $req;
    }

    /**
     * formatte les données reçues par une requête en tableau associatif
     */
    private function formatData($req) {
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * récupère les 5 derniers livres ajoutés
     */
    public function get5LastBooks(){

        $query = "SELECT titre, image, pseudo, nom, prenom, ouvrage_id FROM t_ouvrage INNER JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id INNER JOIN t_utilisateur ON t_utilisateur.utilisateur_id = t_ouvrage.utilisateur_id ORDER BY ouvrage_id DESC LIMIT 5";

        return $this->formatData($this->querySimpleExecute($query));
    }

    /**
     * Mthode permettant l'ajout d'un utilisateur
     */
    public function addUser($pseudo, $password, $admin){
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // requete sql permettant d'ajouter un utilisateur
        $query = "INSERT INTO t_utilisateur (pseudo, mot_de_passe, admin, date_entree)
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
     * Methode permettant de récupèrer un utilisateur spécifique par son login
     */
    public function getUserByLogin($login){
        $query = "SELECT * FROM t_utilisateur WHERE pseudo = :pseudo";
        $stmt = $this->queryPrepareExecute($query, ['pseudo' => $login]);
        $users = $this->formatData($stmt);
        return count($users) === 1 ? $users[0] : [];
    }

    /**
     * Methode permettant de retourner tout les utilisateurs
     */
    public function getAllUsers(){
        // requete sql selectionnant toute la table t_user
        $query = "SELECT * FROM t_utilisateur";

        //execute la requete sql
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
 * Récupère toutes les catégories
 */
public function getAllCategories()
{
    $query = "SELECT * FROM t_categorie";
    return $this->formatData($this->querySimpleExecute($query));
}

/**
 * Récupère tous les auteurs
 */
public function getAllAuthors()
{
    $query = "SELECT * FROM t_auteur";
    $req = $this->querySimpleExecute($query);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les éditeurs
 */
public function getAllEditors()
{
    $query = "SELECT * FROM t_editeur";
    $req = $this->querySimpleExecute($query);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * Supprime un livre
 */
public function deleteBook($id){

    $query = "DELETE FROM t_ouvrage WHERE ouvrage_id LIKE :id";

    $binds = ['id'=>$id];

    $this->queryPrepareExecute($query, $binds);
    
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

    return $this->querySimpleExecute($query);
}

/**
 * Ajoute un auteur
 */
public function addAuthor($firstName, $lastName){

    $query = "INSERT INTO t_auteur (nom, prenom) VALUES (:firstName, :lastName)";

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


}
?>
