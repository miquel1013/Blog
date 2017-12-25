<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Classe gérant les Tag dans la base de données
 *
 * @author jordy
 */
require_once 'Manager.php';
require_once '../entity/Tag.php';

class TagManager extends Manager
{
    private static $p_singleton;

    private function __construct()
    {
        
    }

    public static function getInstance()
    {
        if (is_null(self::$p_singleton))
        {
            self::$p_singleton = new ArticleManager();
        }
        return self::$p_singleton;
    }

    public function insert(Tag $a)
    {
        $sql = "INSERT INTO tag VALUES (:id_article, :tag)" ;
        $ps = Database::getInstance()->prepare($sql) ;
        return $ps->execute([
            "id_article"=>$a->getId_article(),
            "tag"=> strtolower($a->getTag())
            ]) ;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM tag" ;
        $ps = Database::getInstance()->getPDO()->query($sql) ;
        $tag_array = array() ;
        $results = $ps->fetchAll(PDO::FETCH_ASSOC) ;
        $tag = new Tag() ;
        foreach ($results as $value)
        {
            $tag->setId_article($value["id_article"]) ;
            $tag->setTag($value["tag"]) ;
            array_push($tag_array, $tag) ;
        }
        return $tag_array;
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM tag WHERE id_article=:id" ;
        $ps = Database::getInstance()->prepare($sql) ;
        if(!$ps->execute(["id_article"=>$id]))
        {
            return array() ;
        }
        $tag_array = array() ;
        $results = $ps->fetchAll(PDO::FETCH_ASSOC) ;
        $tag = new Tag() ;
        foreach ($results as $value)
        {
            $tag->setId_article($value["id_article"]) ;
            $tag->setTag($value["tag"]) ;
            array_push($tag_array, $tag) ;
        }
        return $tag_array;
    }

    public function findByCriteria(string $criteria)
    {
        $sql = "SELECT * FROM tag WHERE tag=:criteria" ;
        $ps = Database::getInstance()->prepare($sql) ;
        if(!$ps->execute(["criteria"=>$criteria]))
        {
            return array() ;
        }
        $tag_array = array() ;
        $results = $ps->fetchAll(PDO::FETCH_ASSOC) ;
        $tag = new Tag() ;
        foreach ($results as $value)
        {
            $tag->setId_article($value["id_article"]) ;
            $tag->setTag($value["tag"]) ;
            array_push($tag_array, $tag) ;
        }
        return $tag_array;
    }

    public function update(Tag $a)
    {
        $sql = "UPDATE tag set tag=:tag WHERE id_article=:id_article" ;
        $ps = Database::getInstance()->prepare($sql) ;
        return $ps->execute([
            "id_article"=>$a->getId_article(),
            "tag"=>$a->getTag()
        ]);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM tag WHERE id=:id" ;
        $ps = Database::getInstance()->prepare($sql) ;
        return $ps->execute(array("id"=>$id)) ;
    }
}
