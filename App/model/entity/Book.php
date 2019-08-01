<?php
class Book extends Table
{
    private $_id;
    private $_title;
    private $_plot;
    private $_onlineDat;
    private $_nbEps;
    private $_status;
    private $_isbn;
    private $_editYear;
    private $_cover;
    private $_coverAlt;
    private $_promoted;
/**
     * Variablea ajoutés hors base données
     */
    private $episodes;
    private $nbEpisodes;
    private $alertEps;
   
    
     /**
    
     * @param array $donnees
     */
    public function __construct($dtas = [])
  {
      if(!empty($dtas))
      {
          $this->hydrate($dtas);
      }
  }
    /**
     * @param array $donnees
     */
    public function hydrate($dtas)
    {
        if(is_array($dtas))
        {
            foreach ($dtas as $key => $value)
            {
                $method = 'set' . ucfirst($key);
                if(method_exists($this, $method))
                {
                    $this->$method($value);
                }
            }
        }
    }

// Setters
    public function setId($id)
    {
        $this->_id = (int) $id;
    }
    public function setTitle($title)
    {
        $this->_title = $title;
    }
    public function setPlot($plot)
    {
        $this->_plot = $plot;
    }
    public function setOnlineDate(datetime $onlineDate)
    {
        $date = new DateTime();
       $this->_onlineDate = ($onlineDate !='') ? date('Y-m-d', strtotime($onlineDate)) : null;
    }
    public function setNbEps($nbEps)
    {
        $this->_nbEps = (int) $nbEps;
    }
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    public function setIsbn($isbn)
    {
        $this->_isbn = $isbn;
    }
    public function setEditYear($editYear)
    {
        $this->_editYear = (int) $editYear;
    }
    public function setCover($cover)
    {
        $this->_cover =  $cover;
    }
    public function setCoverAlt($coverAlt)
    {
        $this->_coverAlt =  $coverAlt;
    }

    public function setPromoted($promoted)
    {
        $this->_promoted =  (int) $promoted;
    }

    // Getters
    public function getId()
    {
        return $this->_id;
    }
    public function getTitle()
    {
        return $this->_title;
    }
    public function getPlot()
    {
        return $this->_plot;
    }
    public function getOnlineDat()
    {
        return $this->_onlineDat;
    }
    public function getNbEps()
    {
        return $this->_nbEps;
    }
    public function getStatus()
    {
        return $this->_status;
    }
    public function getIsbn()
    {
        return $this->_isbn;
    }
    public function getEditYear()
    {
        return $this->_editYear;
    }
    public function getCover()
    {
        return $this->_cover;
    }
    public function getCoverAlt()
    {
        return $this->_coverAlt;
    }
    public function getPromoted()
    {
        return $this->_promoted;
    }

    public function isNew()
    {
        return empty($this->_id);
    }


    /**
     * Fonction annexes _____________________________________________SET
     */

    public function setEpisodes($episodes)   // tableau d'objets Episode
    {
        $this->episodes = $episodes;
        $this->setNbEpisodes(count($episodes));
    }

    public function setNbEpisodes($nbEpisodes)
    {
        $this->nbEpisodes = $nbEpisodes;
    }

    public function setAlertEpisode($altE=false)
    {
        $this->AlertEpisode = $altE;
    }

     /**
    *  Fonction annexes  _____________________________________________GET
    */
   
   public function getEpisodes()
   {
       return $this->episodes;
   }

       public function getNbEpisodes()
    {
        return $this->nbEpisodes;
    }
    public function getAlertEpisode()
    {
        return $this->alertEpisode;
    }
  /**
    *  Fonction annexes  _____________________________________________Validation/MAJ
    */
    public static function validation()
    {
    $validTable =       array('id'        =>array(
                            'Reference'     =>'Identifiant',
                            'required'      => false
                            ),
            'title'     =>array(
                            'Reference'     =>'Titre',
                            'required'      => true,
                            'min'           => 3,
                            'max'           => 50
                            ),
            'plot'      =>array(
                            'Reference'     =>'intrigue',
                            'required'      => true,
                            'min'           => 10,
                            'max'           => 2000
                            ),
            'onlineDat' =>array(
                            'Reference'     =>'En ligne',
                            'required'      => false,    
                            ),
            'nbEps'     =>array(
                            'Reference'     =>'Nb Episodes',
                            'required'      => false
                          ),
            'status'    =>array(
                            'Reference'     =>'statut',
                            'required'      => true,
                            'max'           => 2,
                            'list'          => '00;10;30;80;90'
                          ),
            'isbn'      =>array(
                            'Reference'     =>'isbn',
                            'required'      => false,
                            'max'           => 20
                            // 'unique'        => 'book'
                          ),
            'editYear'      =>array(
                                'Reference'     =>'Année édit°',
                                'required'      => false,
                                'max'           => 4
                            ),
            'cover'         =>array(
                                'Reference'     =>'Couverture',
                                'required'      => false,
                                'max'           => 30
                            ),
            'coverAlt'         =>array(
                            'Reference'     =>'Legende',
                            'required'      => false,
                            'max'           => 50
                            ),
            'promoted'        =>array(
                                'Reference'     =>'Mis en avant',
                                'required'      => false,
                                'max'           => 1
                            )
                                        
      ); 
      return $validTable;
    }
}
